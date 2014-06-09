<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 14-April-2011
	Purpose	: Agent class
*********************************************************************************************/
    class member
	{
		protected $_properties		= array();
		public    $error			= '';
		public    $message			= '';
		public    $warning			= '';
		
		public $user_type_array 	= array(1=>'Normal', 2=>'Facebook', 3=>'Both');
		public $role_type_array 	= array(1=>'Admin', 2=>'User');
		
        function __construct($member_id = 0)
		{
            $this->error	= '';
			$this->message	= '';
			$this->warning	= false;
			
			if($member_id > 0)
			{
				$this->initialize($member_id);
			}
        }
		
		function __get($property_name)
        {
			if (array_key_exists($property_name, $this->_properties))
			{
				return $this->_properties[$property_name];
			}
			return null;
        }
		public function __set($property_name, $value)
		{
			return $this->_properties[$property_name] = $value;
		}
		
		public function __destruct() 
		{
			unset($this->_properties);
			unset($this->error);
			unset($this->message);
		}
		
		//Initialize object variables.
		private function initialize($member_id)
		{
			$database	= new database();
			 $sql		= "SELECT *	 FROM member where member_id = '$member_id' ";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
		}
		public function check_username_exist($name='', $member_id=0)
		{
			$output		= false;
			$database	= new database();
			if($name == '')
			{
				$this->message	= "Email should not be empty!";
				$this->warning	= true;
			}
			else
			{
				
				if($member_id > 0)
				{
					  $sql	= "SELECT *	 FROM member WHERE username = '" . $database->real_escape_string($name) . "' AND member_id != '" . $member_id . "'";
				}
				else
				{
					 $sql	= "SELECT *	 FROM member WHERE username = '" . $database->real_escape_string($name) . "' AND (user_type = 1 OR user_type = 3)";
				}
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					$this->message	= "Email is already exist!";
					$this->warning	= true;
					$output 		= true;
				}
				else
				{
					$output			= false;
				}
			}
		
			
			return $output;	
		}
		
		// Save the Agent details
		public function save()
		{
			$database	= new database();
			$member_id	= $this->_properties['member_id'] > 0 ? $this->_properties['member_id'] : 0;
			
			if(member::check_fb_user_existing($this->email) > 0)
			{
				$sql	= "UPDATE member SET 					        
						  username = '". $database->real_escape_string($this->username) ."', 
						  first_name = '".  $database->real_escape_string($this->first_name)  ."' ,
						  last_name = '".  $database->real_escape_string($this->last_name)  ."' ,
						  contact_number = '".  $database->real_escape_string($this->contact_number)  ."' ,
						  email = '".  $database->real_escape_string($this->email)  ."' ,
						  avatar = '".  $database->real_escape_string($this->image_name)  ."' ,
						  role_id = '".  $database->real_escape_string($this->role_id)  ."' ,
						  user_type = '3' ,
						  status = '". $database->real_escape_string($this->status) ."'	
						  WHERE member_id = '$this->member_id'";
				$result			= $database->query($sql);	
			}
			else
			{
							if(!$this->check_username_exist($this->username,  $member_id))
							{				
								if ( isset($this->_properties['member_id']) && $this->_properties['member_id'] > 0) 
								{
									$member				= new member($this->_properties['member_id']);
									$current_status 	= $member->status;					
									$sql	= "UPDATE member SET 					        
												username = '". $database->real_escape_string($this->username) ."', 
												first_name = '".  $database->real_escape_string($this->first_name)  ."' ,
												last_name = '".  $database->real_escape_string($this->last_name)  ."' ,
												contact_number = '".  $database->real_escape_string($this->contact_number)  ."' ,
												email = '".  $database->real_escape_string($this->email)  ."' ,
												avatar = '".  $database->real_escape_string($this->image_name)  ."' ,
												status = '". $database->real_escape_string($this->status) ."'	
												WHERE member_id = '$this->member_id'";
									$result			= $database->query($sql);
									
									////address = '".  $database->real_escape_string($this->address)  ."' ,
											
								}
								else 
								{
									$current_status = $this->status;
										
									$order_id	= self::get_max_order_id() + 1;
									$sql		= "INSERT INTO member 
													(username,password, password_text, first_name, last_name,contact_number,email, avatar, role_id, user_type, status, order_id,join_date) 
													VALUES (						
													
														'" . $database->real_escape_string($this->username) . "', 
														'" . md5($database->real_escape_string($this->password) ). "',
														'" . $database->real_escape_string($this->password ). "',
														'" . $database->real_escape_string($this->first_name) . "',
														'" . $database->real_escape_string($this->last_name) . "',
														'" . $database->real_escape_string($this->contact_number) . "',
														'" . $database->real_escape_string($this->email) . "',
														'" . $database->real_escape_string($this->image_name) . "',
														'" . $database->real_escape_string($this->role_id). "',
														'1',
														'" . $database->real_escape_string($this->status). "',
														'" . $order_id."',
														NOW()
													)";
									$result			= $database->query($sql);						
								}
											
								//echo $sql;
												
								if($database->affected_rows == 1)
								{
									if($this->member_id == 0)
									{
										$this->member_id	= $database->insert_id;	
										
										$mail_content		= '';
										if($this->userside == 'Y')
										{
											$email_template		= new email_template('member.member-signup');
										}
										else
										{
											$email_template		= new email_template('member.member-registration');
										}
										//Replace template content with original values
										$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
										$mail_content		= str_replace("{name}", functions::deformat_string($this->first_name).' '. functions::deformat_string($this->last_name), $mail_content);
										$mail_content		= str_replace("{username}", functions::deformat_string($this->username), $mail_content);
										$mail_content		= str_replace("{password}", functions::deformat_string($this->password), $mail_content);
										$mail_content		= str_replace("{email}", functions::deformat_string($this->email), $mail_content);
										$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
										
										$mailer				= new mailer();					  
										$mailer->from		= ADMIN_EMAIL_ID;
										$mailer->from_name	= functions::deformat_string(ADMIN_EMAIL_NAME);
										$mailer->to_address	= $this->email;
										$mailer->to_name	= functions::deformat_string($this->first_name);
										$mailer->subject	= functions::deformat_string($email_template->subject);
										$mailer->body		= $mail_content;
										$mailer->Send();
										
										$mail_content		= '';
										if($this->userside == 'Y')
										{
											$email_template		= new email_template('admin.member-signup');
										}
										else
										{
											$email_template		= new email_template('admin.member-registration');
										}
										
										//Replace template content with original values
										$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
										$mail_content		= str_replace("{name}", functions::deformat_string($this->first_name).' '. functions::deformat_string($this->last_name), $mail_content);
										$mail_content		= str_replace("{phone}", functions::deformat_string($this->phone), $mail_content);
										$mail_content		= str_replace("{mobile}", functions::deformat_string($this->mobile), $mail_content);
										$mail_content		= str_replace("{email}", functions::deformat_string($this->email), $mail_content);
										$mail_content		= str_replace("{username}", functions::deformat_string($this->username), $mail_content);
										$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
										
										$mailer				= new mailer();
										$mailer->from		= ADMIN_EMAIL_ID;
										$mailer->from_name	= functions::deformat_string(ADMIN_EMAIL_NAME);
										$mailer->to_address	= ADMIN_EMAIL_ID;
										$mailer->to_name	= functions::deformat_string(ADMIN_EMAIL_NAME);
										$mailer->subject	= functions::deformat_string($email_template->subject);
										$mailer->body		= $mail_content;
										$mailer->Send();
										
										
										if($this->userside != 'Y')
										{
											$mail_content		= '';
											if($this->status == 'Y')
											{
												$email_template		= new email_template('member.status-approved');
											}
											else
											{
												$email_template		= new email_template('member.status-disabled');
											}
											
											//Replace template content with original values
											$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
											$mail_content		= str_replace("{name}", functions::deformat_string($this->first_name).' '. functions::deformat_string($this->last_name), $mail_content);
											$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
											
											$mailer				= new mailer();
											$mailer->from		= ADMIN_EMAIL_ID;
											$mailer->from_name	= functions::deformat_string(ADMIN_EMAIL_NAME);
											$mailer->to_address	= $this->email;
											$mailer->to_name	= functions::deformat_string($this->first_name);
											$mailer->subject	= functions::deformat_string($email_template->subject);
											$mailer->body		= $mail_content;
											$mailer->Send();
										}
									}	
									else
									{
										if($current_status != $this->status)
										{
											$mail_content		= '';
											if($this->status == 'Y')
											{
												$email_template		= new email_template('member.status-approved');
											}
											else
											{
												$email_template		= new email_template('member.status-disabled');
											}
											//Replace template content with original values
											$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
											$mail_content		= str_replace("{name}", functions::deformat_string($this->name), $mail_content);
											$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
											
											$mailer				= new mailer();
											$mailer->from		= ADMIN_EMAIL_ID;
											$mailer->from_name	= functions::deformat_string(ADMIN_EMAIL_NAME);
											$mailer->to_address	= $this->email;
											$mailer->to_name	= functions::deformat_string($this->first_name);
											$mailer->subject	= functions::deformat_string($email_template->subject);
											$mailer->body		= $mail_content;
											$mailer->Send();
										}
									}																							
								}
								
								$this->initialize($this->member_id);	
								$this->message = cnst11;
								$this->warning = false;
								return true;
							}
			}
		}
		
		
		
		//The function check the blog category eixst or not
		public function check_member_exist($name='', $member_id=0)
		{
			$output		= false;
			$database	= new database();
			if($company == '')
			{
				$this->message	= "Agent number should not be empty!";
				$this->warning	= true;
			}
			else
			{
				if($member_id > 0)
				{
					$sql	= "SELECT *	 FROM member WHERE name = '" . $database->real_escape_string($name) . "' AND member_id != '" . $member_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM member WHERE name = '" . $database->real_escape_string($name) . "'";
				}
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					$this->message	= "Agent number is already exist!";
					$this->warning	= true;
					$output 		= true;
				}
				else
				{
					$output			= false;
				}
			}
			return $output;	
		}
		
		
		// Validate user login information
		public function validate_login()
		{		
			$this->message	= "";
			$database	= new database();
			
			$sql		= "SELECT * FROM member WHERE status = 'Y' AND username = '" . $database->real_escape_string($this->username) . "' AND password = '" . md5($database->real_escape_string($this->password)) . "'";
			

			$result		= $database->query($sql);

			if ($result->num_rows > 0)
			{
				$this->_properties = $result->fetch_assoc();
				
				/*$sql1 	= "UPDATE user SET last_login_date=NOW() WHERE user_id='". $this->user_id."'";
				$result1	= $database->query($sql1);*/
							
				return true;
			}
			else
			{
				$this->message = "Invalid login information!";
				$this->warning = true;
				return false;
			}
		}
		
		
		
		public function update_profile_details()
		{
			$database	= new database();
			
			if(!$this->check_username_exist($this->username, $this->member_id))
			{		
				 $sql	= "UPDATE member SET 					        
						  username = '". $database->real_escape_string($this->username) ."', 
						  first_name = '".  $database->real_escape_string($this->first_name)  ."' ,
						  last_name = '".  $database->real_escape_string($this->last_name)  ."' ,
						  email = '".  $database->real_escape_string($this->email)  ."' ,
						  city = '".  $database->real_escape_string($this->city)  ."' ,
						  state_id = '".  $database->real_escape_string($this->state_id)  ."',
						  zip = '".  $database->real_escape_string($this->zip)  ."' ,
						  favorites_1 = '".  $database->real_escape_string($this->favorites_1)  ."' ,
						  favorites_2 = '".  $database->real_escape_string($this->favorites_2)  ."' ,
						  favorites_3 = '".  $database->real_escape_string($this->favorites_3)  ."' ,
						  favorites_4 = '".  $database->real_escape_string($this->favorites_4)  ."' 
						  WHERE member_id = '$this->member_id'";
				$result			= $database->query($sql);
				
				if($database->affected_rows == 1)
				{
				}
				
				$this->initialize($this->member_id);	
				$this->message = cnst11;
				$this->warning = false;
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public function update_contact_info()
		{
			$database	= new database();
			
			if(!$this->check_username_exist($this->username, $this->member_id))
			{		
				 $sql	= "UPDATE member SET 					        
						  username = '". $database->real_escape_string($this->username) ."', 
						  first_name = '".  $database->real_escape_string($this->first_name)  ."' ,
						  last_name = '".  $database->real_escape_string($this->last_name)  ."' ,
						  email = '".  $database->real_escape_string($this->email)  ."' ,
						  city = '".  $database->real_escape_string($this->city)  ."' ,
						  state_id = '".  $database->real_escape_string($this->state_id)  ."'
						  WHERE member_id = '$this->member_id'";
				$result			= $database->query($sql);
				
				if($database->affected_rows == 1)
				{
				}
				
				$this->initialize($this->member_id);	
				$this->message = cnst11;
				$this->warning = false;
				return true;
			}
			else
			{
				return false;
			}
		}
		
		// Validate member login information
		public function validate_login_admin()
		{
			$this->message	= "";
			$database	= new database();
			$sql		= "SELECT * FROM member WHERE status = 'Y' AND (role_id = 1 OR role_id = 0) AND (user_type=1 OR user_type=3) AND username = '" . $database->real_escape_string($this->username) . "' AND password = '" . md5($database->real_escape_string($this->password)) . "'";
			$result		= $database->query($sql);

			if ($result->num_rows > 0)
			{
				$this->_properties = $result->fetch_assoc();
				return true;
			}
			else
			{
				$this->message = "Invalid login information";
				return false;
			}
		}
		
		public function update_password_user()
		{		
			$this->message	= "";
			$database	= new database();
			
			$sql		= "SELECT * FROM member WHERE status = 'Y' AND (user_type=1 OR user_type=3) AND member_id = '" . $database->real_escape_string($this->member_id) . "' AND password = '" . md5($database->real_escape_string($this->existing_password)) . "'";
			
			$result		= $database->query($sql);

			if ($result->num_rows > 0)
			{		
				$sql1	= "UPDATE member SET password='". md5($database->real_escape_string($this->new_password)) ."' , password_text ='". $database->real_escape_string($this->new_password) ."' WHERE member_id = $this->member_id";
				$result1 = $database->query($sql1);
				$this->message ="Success";
			    $this->warning = false;					
				return true;
			}
			else
			{
				$this->message = "Existing password does not match";
				$this->warning = true;
				return false;
			}
		}
		
		// Validate user login information
		public function validate_login_ajax()
		{		
			$this->message	= "";
			$database	= new database();
			
			$sql		= "SELECT * FROM member WHERE status = 'Y' AND (user_type=1 OR user_type=3) AND username = '" . $database->real_escape_string($this->username) . "' AND password = '" . $database->real_escape_string($this->password) . "'";
			
			$result		= $database->query($sql);

			if ($result->num_rows > 0)
			{
				$this->_properties = $result->fetch_assoc();
				
				/*$sql1 	= "UPDATE user SET last_login_date=NOW() WHERE user_id='". $this->user_id."'";
				$result1	= $database->query($sql1);*/
							
				return true;
			}
			else
			{
				$this->message = "Invalid login information!";
				$this->warning = true;
				return false;
			}
		}
		
		// Validate user login information
		public function get_member_id_by_fbid($fb_id = 0)
		{		
			$this->message	= "";
			$database	= new database();
			
			$sql		= "SELECT * FROM member WHERE status = 'Y' AND fb_id = '" . $fb_id . "'";
			$result		= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$this->_properties = $result->fetch_assoc();
				
				$sql1 	= "UPDATE member SET date_last_login=NOW() WHERE member_id='". $this->_properties['member_id']."' AND fb_id='". $fb_id."'";
				$result1	= $database->query($sql1);
							
				return $this->_properties['member_id'];
			}
			else
			{
				return 0;
			}
		}
		
		public function add_fb_user($user_profile)
		{		
			$this->message	= "";
			$database	= new database();
			$member_id	= 0;
			
			if($user_profile['email'] != '')
			{
				$member_id1 = $this->get_member_id_byemail($user_profile['email']);
				if($member_id1 > 0)
				{
					$member_role 	= new member($member_id1);
					$sql	= "UPDATE member SET 	
						  fb_id		= 	'". $database->real_escape_string($user_profile['id']) ."',			        
						  username = '". $database->real_escape_string($user_profile['email']) ."', 
						  first_name = '".  $database->real_escape_string($user_profile['first_name'])  ."' ,
						  last_name = '".  $database->real_escape_string($user_profile['last_name'])  ."' ,
						  email = '".  $database->real_escape_string($user_profile['email'])  ."' ,
						  fb_username = '".  $database->real_escape_string($user_profile['username'])  ."' ,
						  role_id = '".  $database->real_escape_string($member_role->role_id)  ."' ,
						  date_last_login = NOW(),
						  user_type = '3' ,
						  status = 'Y'	
						  WHERE member_id = '$member_id1'";	
				}
				else
				{
					$order_id	= self::get_max_order_id() + 1;
					$sql		= "INSERT INTO member 
								(fb_id, role_id, username, email, password, password_text, first_name, last_name, fb_username, user_type, status, order_id, date_last_login,join_date) 
									VALUES (						
											'" . $database->real_escape_string($user_profile['id']) . "', 
											'2',
											'" . $database->real_escape_string($user_profile['email']) . "', 
											'" . $database->real_escape_string($user_profile['email']). "',
											'" . $database->real_escape_string($user_profile['email']). "',
											'" . $database->real_escape_string($user_profile['email']). "',
											'" . $database->real_escape_string($user_profile['first_name']) . "',
											'" . $database->real_escape_string($user_profile['last_name']) . "',
											'" . $database->real_escape_string($user_profile['username']) . "',
											'2',
											'Y',
											'" . $order_id . "',
											NOW(),
											NOW()
										)";
				}
				$result			= $database->query($sql);
			
				if($database->affected_rows == 1)
				{
					if($member_id1 > 0)
					{
						$member_id = $member_id1;
					}
					else
					{
						$member_id	= $database->insert_id;
					}
				}
			}
					
			return $member_id;
		}
		
		public function get_member_id_byemail($email = '')
		{		
			$member_id1 =0;
			$database	= new database();
			$sql		= "SELECT * FROM member WHERE email='". $email."'";
			$result		= $database->query($sql);
			if($result->num_rows > 0)
			{
				$data 			= $result->fetch_object();
				$member_id1 	    = $data->member_id;	
			}
			
			return $member_id1;
		}
		
		public static function check_fb_user_existing($email = '')
		{		
			$database	= new database();
			$sql		= "SELECT * FROM member WHERE email='". $email."' AND status = 'Y' AND fb_id != '' AND user_type =2";
			$result		= $database->query($sql);
			return $result->num_rows;	
		}
		
		
		public function update_fb_user_info($email ='')
		{
			$database	= new database();
			$member_id 	= 0;
			$sql		= "SELECT * FROM member WHERE email='". $this->email."' AND status = 'Y' AND fb_id != '' AND user_type =2 LIMIT 1"; 
			$result		= $database->query($sql);
			if($result->num_rows > 0)
			{
				$data 	= $result->fetch_object();
				$sql1	= "UPDATE  member SET password='". $this->password."', password_text='". $this->password_text."', user_type=3, first_name='".$this->first_name."', last_name='".$this->last_name."' WHERE member_id='". $data->member_id."'";
				$result1		= $database->query($sql1);
				$member_id 	 = $data->member_id;
			}
			
			return $member_id;
		}
		
		// The function return a random number

		public function get_unique_code()

		{

			$database 	= new database();

			$random_num = rand(12345,199999)+rand(123,999);

			$timestamp	= time();

			$unique_code= $random_num . ($timestamp + rand(10,999));

			$sql		= "SELECT * FROM member WHERE unique_code = '" . $unique_code . "'";

			$result		= $database->query($sql);

			if($result->num_rows > 0)

			{

				$this->get_unique_code();

			}

			else

			{

				return $unique_code;

			}

		}
		
		// The function is used to update unique_code value.

		public function update_unique_code($member_id, $unique_code = '')

		{		

			$database	= new database();

			

			$sql		= "UPDATE member 

						SET unique_code = '". $unique_code . "'

						WHERE member_id = '" . $member_id . "'";

			$result 	= $database->query($sql);

		}
		
		
		
		// Validate password recovery details
		public function validate_member_details()
		{
			$this->message	= "";
			$output			= false;
			$database		= new database();

			if($this->email != '')
			{
				$sql		= "SELECT * FROM member WHERE email = '" . $database->real_escape_string($this->email) . "'";
				$result		= $database->query($sql);	

				if ($result->num_rows > 0)
				{
					$this->_properties = $result->fetch_assoc();
					$output			= true;
				}
				else
				{
					$this->message	= "The email address is not available in the system!";
					$this->warning	= true;
					$output			= false;
				}
			}
			else
			{
				$this->message	= "You must provide email address!";
				$this->warning	= true;
				$output			= false;
			}

			if($output)
			{
				//$this->message	= "Password reset information sent to your email. Please follow the instruction in the mail!";
				$this->message	= "Thank you. Please check your email and follow the link to reset your password. <br \>If you do not receive an email in the next 24 hours please contact us.";
				$this->warning	= false;
				$unique_code	= $this->get_unique_code();
				$this->update_unique_code($this->member_id, $unique_code);
				$reset_password_url = URI_ROOT . 'reset_password.php?mid=' . $this->member_id . '&uc=' . $unique_code;		

				/**** Forgot password mail code stats here  ***/
				$mail_content		= '';
				$email_template		= new email_template('member.forgot-password');
				//Replace template content with original values

				$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
				$mail_content		= str_replace("{name}", functions::deformat_string($this->first_name). ' '. functions::deformat_string($this->last_name), $mail_content);
				$mail_content		= str_replace("{URL}", $reset_password_url, $mail_content);
				$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
					
				$mailer				= new mailer();					  
				$mailer->from		= ADMIN_EMAIL_ID;
				$mailer->from_name	= functions::deformat_string(ADMIN_EMAIL_NAME);
				$mailer->to_address	= $this->email;
				$mailer->to_name	= functions::deformat_string($this->first_name);
				$mailer->subject	= functions::deformat_string($email_template->subject);
				//$mailer->attach		= DIR_BACKGROUND. 'background.jpg';  
				$mailer->body		= $mail_content;
				$mailer->Send();
			}

			return $output;

		}
		
		// The function return a random number

		public function validate_unique_code($member_id, $unique_code)

		{

			$database	= new database();

			$member_id	= $member_id > 0 ? $member_id : 0;

			$sql		= "SELECT * FROM member WHERE member_id = '" . $database->real_escape_string($member_id) . "' AND unique_code = '" . $database->real_escape_string($unique_code) . "'";

			$result		= $database->query($sql);

			if($result->num_rows > 0)

			{

				return true;

			}

			else

			{

				return false;

			}

		}
		
		public function validate_member_details1()
		{
			$this->message	= "";
			$output			= false;
			$database		= new database();

			if($this->username != '')
			{
				$sql		= "SELECT * FROM member WHERE username = '" . $database->real_escape_string($this->username) . "'";
				$result		= $database->query($sql);

	

				if ($result->num_rows > 0)

				{

					$this->_properties = $result->fetch_assoc();

					$output			= true;

				}

				else

				{

					$this->message 	= "Username is not valid!";

					$this->warning	= true;

					$output			= false;

				}

			}

			else if($this->email != '')

			{

				$sql		= "SELECT * FROM member WHERE email = '" . $database->real_escape_string($this->email) . "'";

				$result		= $database->query($sql);

	

				if ($result->num_rows > 0)

				{

					$this->_properties = $result->fetch_assoc();

					$output			= true;

				}

				else

				{

					$this->message	= "The email address is not available in the system!";

					$this->warning	= true;

					$output			= false;

				}

			}

			else

			{

				$this->message	= "You must provide username or email address!";

				$this->warning	= true;

				$output			= false;

			}

			

			if($output)

			{

				//$this->message	= "Password reset information sent to your email. Please follow the instruction in the mail!";

				$this->message	= "Thank you. Please check your email and follow the link to reset your password. <br \>If you do not receive an email in the next 24 hours please contact us.";

				$this->warning	= false;

				

				$unique_code	= $this->get_unique_code();

				$this->update_unique_code($this->member_id, $unique_code);

				$reset_password_url = URI_ROOT . 'reset_password.php?mid=' . $this->member_id . '&uc=' . $unique_code;

				

				/**** Forgot password mail code stats here  ***/

				$mail_content		= '';

				$email_template		= new email_template('member.forgot-password');

				//Replace template content with original values

				$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);

				$mail_content		= str_replace("{name}", functions::deformat_string($this->first_name). ' '. functions::deformat_string($this->last_name), $mail_content);

				$mail_content		= str_replace("{URL}", $reset_password_url, $mail_content);

				$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);

				

				/*$mailer				= new mailer();

				$mailer->from		= ADMIN_EMAIL_ID;

				$mailer->to			= $this->email;

				$mailer->subject	= $email_template->subject;

				$mailer->body		= $mail_content;	

				$mailer->send();*/
				
				$mailer             = new mailer();
				//$mailer->IsSMTP(); 						// telling the class to use SMTP
				//$mailer->SMTPAuth   = true;               // enable SMTP authentication
				$mailer->SetFrom(ADMIN_EMAIL_ID, ADMIN_EMAIL_NAME);
				$mailer->AddAddress($this->email, functions::deformat_string($this->first_name));
				$mailer->Subject    = $email_template->subject;
				$mailer->MsgHTML($mail_content);
				$mailer->Send();

				/**** Forgot password mail code end here  ***/

			}

			return $output;

		}
		
		// Remove the current object details.
		public function remove()
		{
			$database	= new database();
			if ( isset($this->_properties['member_id']) && $this->_properties['member_id'] > 0) 
			{		
				$member 	= new member($this->member_id);
				$image_name = $member->image_name;
				
				if(file_exists(DIR_MEMBER. $image_name) && $image_name != '')
				{
					unlink(DIR_MEMBER. $image_name);	
				}
				if(file_exists(DIR_MEMBER. 'thumb_'. $image_name) && $image_name != '')
				{
					unlink(DIR_MEMBER. 'thumb_'. $image_name);	
				}
				if(file_exists(DIR_MEMBER. 'thumb1_'. $image_name) && $image_name != '')
				{
					unlink(DIR_MEMBER. 'thumb1_'. $image_name);	
				}
				if(file_exists(DIR_MEMBER. 'thumbresize_'. $image_name) && $image_name != '')
				{
					unlink(DIR_MEMBER. 'thumbresize_'. $image_name);	
				}
									
				$sql = "DELETE FROM member WHERE member_id = '" . $this->member_id . "'";
				try
				{
					if($result 	= $database->query($sql)) 
					{
						if ($database->affected_rows > 0)
						{
							$this->message = cnst12;	// Data successfully removed!
						}
					}
					else 
					{
						throw new Exception(cnst13);	// Selected record is not found!
					}
				}
				catch (Exception $e)
				{
					$this->message	= "Exception: ".$e->getMessage();
					$this->warning	= true;
				}
			}
		}
		
		// Remove selected items
		public function remove_selected($member_ids)
		{
			$database	= new database();
			if(count($member_ids)>0)
			{		
				foreach($member_ids as $member_id)
				{	
					$member			= new member($member_id);
					$image_name	= $member->avatar;
					if($image_name != '')
					{
						if( file_exists(DIR_MEMBER . $image_name))
						{
							unlink(DIR_MEMBER . $image_name);
						}
						if(file_exists(DIR_MEMBER . 'thumb_' . $image_name))
						{
							unlink(DIR_MEMBER . 'thumb_' . $image_name);
						}
						
						if(file_exists(DIR_MEMBER . 'thumb1_' . $image_name))
						{
							unlink(DIR_MEMBER . 'thumb1_' . $image_name);
						}
						if(file_exists(DIR_MEMBER . 'thumbresize_' . $image_name))
						{
							unlink(DIR_MEMBER . 'thumbresize_' . $image_name);
						}
					}
					
					$sql	= "DELETE FROM user WHERE member_id = '" . $member_id . "'";
					$result	= $database->query($sql);
				
					$sql = "DELETE FROM member WHERE member_id = '" . $member_id . "'";
					try
					{
						if($result 	= $database->query($sql)) 
						{
							if ($database->affected_rows > 0)
							{
								$this->message = cnst12;	// Data successfully removed!
							}
						}
						else 
						{
							throw new Exception(cnst13);	// Selected record is not found!
						}
					}
					catch (Exception $e)
					{
						$this->message	= "Exception: ".$e->getMessage();
						$this->warning	= true;
					}							   
				}		  		   
			}
		}
		
		public function get_my_member()
		{
			$database	= new database();
			$member_id	= $_SESSION[MEMBER_ID];
			$sql		= "SELECT * FROM member WHERE member_id = $member_id ORDER BY added_date DESC";
			$result		= $database->query($sql);
			$idate		= 0;
			if ($result->num_rows > 0)
			{	
				while($data=$result->fetch_object())
				{
					$i++;
					$member_serial_value++;
					$row_num++;
			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	
					
					$idate		= explode('-', $data->added_date);
				  	$added_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];
					echo "<tr>
							<td align='center'>$i</td>
							<td>$added_date</td>
							<td><a href='$data->location' target='_blank'><img src='images/view-member.png' border='0' title='View'></a></td>
						</tr>";
				}
			}
			else
			{
				echo "<tr><td colspan='4' align='center'>Sorry.. No records found !!</td></tr>";
			}
		}
		
		public function display_list()
		{
			$database				= new database();
			$validation				= new validation(); 
			$param_array			= array();
			$sql					= "SELECT * FROM member";
			$drag_drop				= '';
			
			$search_cond_array[]	= "role_id != '0' ";
			$search_cond_array[]	= "email != '' ";
			//$param_array[]			= "role_id!=$this->member_id";
			if(isset($_REQUEST['search_word'])) 
			{
				$search_word	= functions::clean_string($_REQUEST['search_word']);
				if(!empty($search_word))
				{
					$validation->check_blank($search_word, 'Search word', 'search_word');					
					if (!$validation->checkErrors())
					{
						$param_array[]			= "search=true";
						$param_array[]			= "search_word=" . htmlentities($search_word);
						$search_cond_array[]	= "( first_name like '%" . $database->real_escape_string($search_word) . "%' OR
													 last_name like '%" . $database->real_escape_string($search_word) . "%' OR
													 email like '%" . $database->real_escape_string($search_word) . "%' OR
													username like '%" . $database->real_escape_string($search_word) . "%' OR
													 contact_number like '%" . $database->real_escape_string($search_word) . "%'
													)";	
					}
				}
				// Drag and dorp ordering is not available in search
				$drag_drop 						= ' nodrag nodrop ';
			}
			
			if(count($search_cond_array)>0) 
			{ 
				$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
				$sql				.= $search_condition;
			}
						
			 $sql 			= $sql . " ORDER BY member_id DESC";
			$result			= $database->query($sql);
			
			$this->num_rows = $result->num_rows;
			functions::paginate($this->num_rows);
			$start			= functions::$startfrom;
			$limit			= functions::$limits;
			$sql 			= $sql . " limit $start, $limit";
			$result			= $database->query($sql);
			
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			if ($result->num_rows > 0)
			{				
				$i 			= 0;
				$row_num	= functions::$startfrom;
				$page		= functions::$startfrom > 0 ? (functions::$startfrom / PAGE_LIMIT) + 1 : 1;
				
			   	echo '
				<tr class="lightColorRow nodrop nodrag" style="display:none;">
					<td colspan="8"  class="noBorder">
						<input type="hidden" id="show"  name="show" value="0" />
               			<input type="hidden" id="member_id" name="member_id" value="0" />
						<input type="hidden" id="member_id" name="member_id" value="0" />
						<input type="hidden" id="show_member_id" name="show_member_id" value="0" />
						<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
						<input type="hidden" id="page" name="page" value="' . $page . '" />
					</td>
                </tr>';
				
				while($data=$result->fetch_object())
				{
					$i++;
					$member_serial_value++;
					$row_num++;
			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	
					
					$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
					$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
					
					$idate			= explode(' ', $data->added_date);
					$adate			= explode('-', $idate[0]);
				  	$added_date		= $adate[2] . '-' .  $adate[1] . '-' . $adate[0];
					if($data->member_id > 0)
					{
						$member = new member($data->member_id);
						$client = $member->first_name . ' ' . $member->last_name;
					}
					else
					{
						$client = $data->name . '<span class="txtRed">*</span>';
					}
					
					echo '
						<tr id="' . $data->member_id . '" class="' . $class_name . $drag_drop . '" >
							<td class="alignCenter pageNumberCol">' . $row_num . '</td>
							<td class="widthAuto handCursor" title="Click here to view details" onClick="javascript:open_member_details(\''.$data->member_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$member_serial_value.'\');return false;">' . functions::deformat_string($data->email) . '</td>
							<td class="widthAuto handCursor"><a href="#" title="Click here to view details" onClick="javascript:open_member_details(\''.$data->member_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$member_serial_value.'\');return false;">' . functions::deformat_string($data->first_name). '</a></td>	
							<td class="widthAuto handCursor"><a href="#" title="Click here to view details" onClick="javascript:open_member_details(\''.$data->member_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$member_serial_value.'\');return false;">' .  functions::deformat_string($data->last_name) . '</a></td>							
							
							<td class="alignCenter">'.functions::get_format_date($data->join_date, "d-m-Y")  .'</td>
							<td class="alignCenter">';
							if($data->user_type == 1 || $data->user_type == 3)
							{
								echo '<a title="Reset password" onclick="javascript: reset_password(\'' . $data->member_id . '\');" class="handCursor"><img src="images/icon-reset-password.png" alt="Reset password" title="Reset password" width="19" height="19" /></a>';
							}
							
							echo '</td>
							<td class="alignCenter">
								<a title="Click here to update status" class="handCursor" onclick="javascript: change_member_status(\'' . $data->member_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a>
							</td>
							
							<td class="alignCenter">
								<a href="register_member.php?member_id=' . $data->member_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
							</td>
							<td class="alignCenter deleteCol">';
							if($data->member_id != $_SESSION[ADMIN_ID]) {
								echo '<label><input type="checkbox" name="checkbox[' . $data->member_id . ']" id="checkbox" /></label>';
							}
							
							echo '</td>
						</tr>
						<tr id="details'.$i.'" class="expandRow" >
								<td id="details_div_'.$i.'" colspan="9" height="1" ></td>
							</tr>
						';
					$row_type++;
				}
				$param=join("&amp;",$param_array); 
				$this->pager_param=$param;
			}
			else
			{
				$this->pager_param1 = join("&",$param_array);
				if(isset($_GET['page']))
				{
					$currentPage = $_GET['page'];
				}
				if($currentPage>1)
				{
					$currentPage = $currentPage-1;
					if($this->pager_param=="")
					{
						$urlQuery = 'manage_member.php?page='.$currentPage;
					}
					else
					{
						$urlQuery = 'manage_member.php?'.$this->pager_param1.'&page='.$currentPage;	
					}
					functions::redirect($urlQuery);
				}
				else
				{
					echo "<tr><td colspan='4' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
				}
			}
		}
		
		// The function is used to change the password.

		public function change_password($old_password, $password)

		{		

			$database	= new database();

			$sql		= "SELECT *	 FROM member WHERE member_id = '" . $this->member_id . "' AND password = '" . md5($database->real_escape_string($old_password)) . "'";

			//print $sql;

			$result			= $database->query($sql);

			if($result->num_rows > 0)

			{

				return $this->update_password($password, false);

			}

			else

			{

				$this->message = "Your current password is not matching!";

				$this->warning = true;

				return false;

			}

		}


		public function update_password($password = '', $send_notification_mail=true)
		{		
			$database	= new database();
			
			$sql		= "UPDATE member 
						SET password = '". md5($database->real_escape_string($password)) . "',
						password_text ='". $database->real_escape_string($password) . "' 
						WHERE member_id = " . $this->member_id . "";
			$result 	= $database->query($sql);
			$this->initialize($this->member_id);
			$this->message = "Your password has been reset!";
			
			if($send_notification_mail)
			{
				$mail_content	= '';
				$email_template	= new email_template('member.reset-password');		

				//Replace template content with original values

				$mail_content	= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
				$mail_content	= str_replace("{name}", functions::deformat_string($this->first_name). ' '. functions::deformat_string($this->last_name), $mail_content);
				$mail_content	= str_replace("{username}", functions::deformat_string($this->username), $mail_content);
				$mail_content	= str_replace("{password}", functions::deformat_string($password), $mail_content);
				$mail_content	= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);		

				$mailer				= new mailer();					  
				$mailer->from		= ADMIN_EMAIL_ID;
				$mailer->from_name	= functions::deformat_string(ADMIN_EMAIL_NAME);
				$mailer->to_address	= $this->email;
				$mailer->to_name	= functions::deformat_string($this->first_name);
				$mailer->subject	= functions::deformat_string($email_template->subject);
				//$mailer->attach		= DIR_BACKGROUND. 'background.jpg';  
				$mailer->body		= $mail_content;
				$mailer->Send();

			}
			
			
			$this->warning = false;
			return true;
		}
		// The function is used to change the status.
		public static function update_status($member_id, $status = '')
		{		
			$database		= new database();
			$member			= new member($member_id);
			$current_status = $member->status;
			if($status == '')
			{
				$status =  $member->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE user 
						SET status = '". $status . "'
						WHERE member_id = '" . $member_id . "'";
			$result 	= $database->query($sql);
			
			if($current_status != '' && ($current_status != $status))
			{
				/**** Status update mail code stats here  ***/
			//	$mail_content		= '';
//				if($status == 'Y')
//				{
//					$email_template	= new email_template('member.status-approved');
//				}
//				else
//				{
//					$email_template	= new email_template('member.status-disabled');
//				}
//				
//				$member				= new member($member->member_id);
//				
//				//Replace template content with original values
//				$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
//				$mail_content		= str_replace("{JOB_TITLE}", functions::deformat_string($member->title), $mail_content);
//				$mail_content		= str_replace("{JOB_ADDED_ON}", functions::get_format_date($member->added_date, 'd-m-Y'), $mail_content);
//				$mail_content		= str_replace("{JOB_END_DATE}", functions::get_format_date($member->end_date, 'd-m-Y'), $mail_content);
//							
//				$mailer				= new mailer();
//				$mailer->from		= ADMIN_EMAIL_ID;
//				if($member->member_id > 0 && $member->email != '')
//				{
//					$mailer->to		= $member->email;
//				}
//				else if($member->email != '')
//				{
//					$mailer->to		= $member->email;
//				}
//				$mailer->subject	= $email_template->subject;
//				$mailer->body		= $mail_content;
//				if($mailer->to != '')
//				{
//					$mailer->send();
//				}
				/**** Status update mail code end here  ***/
			}
			
			return $status;
		}
		
		// The function is used to change the status.
		public static function update_member_status($member_id, $status = '')
		{		
			$database	= new database();
			$member		= new member($member_id);
			//$current_status = $member->status;
			if($status == '')
			{
				$status =  $member->status == 'Y' ? 'N' : 'Y';
			}
			
			 $sql		= "UPDATE member 
						SET status = '". $status . "'
						WHERE member_id = " . $member_id . "";
		
			$result 	= $database->query($sql);
			return $status;
		}
		
		public static function get_breadcrumbs($member_id, $client_side=false)
		{
			if($client_side)
			{
				$bread_crumb[]			= "<a href='member.php'>Gallery</a>";
			}
			else
			{		
				$page_id				= page::get_page_id('manage_member.php');	// Get the page id
				$page					= new page($page_id);
				$bread_crumb[]			= "<a href='". functions::deformat_string($page->name) ."'>" . functions::deformat_string($page->company) . "</a>";
			}
			
			$member_category 		= new member_category($member_id);
			$bread_crumb[]			= functions::deformat_string($member_category->name);
			
			if(count($bread_crumb)>0)
			{
				$bread_crumbs=join(" >> ",$bread_crumb);
			}
			return $bread_crumbs;
		}
		
		// Functoion update the list order
		public function update_list_order($list_array, $page_number)
		{
			$database		= new database();
			$limit			= PAGE_LIMIT;
			$id_array		= array();
			
			foreach ($list_array as $id)
			{
				if($id == '')
				{
					continue;
				}
				$id_array[] = $id;
			}
			
			if($page_number > 1)
			{
				$order_id = (($page_number - 1) * PAGE_LIMIT) + 1 ;
			}
			else
			{
				$order_id = 1;
			}
			
			for($i = 0; $i < count($id_array); $i++ )
			{
				$sql = "UPDATE member SET order_id = '" . $order_id . "' WHERE member_id = '" . $id_array[$i] . "'";
				$database->query($sql);
				$order_id++;
			}
		}
		
		public function get_top_member2()
		{
			$database			= new database();
			$member_array 			= array();
			//$sql				= "SELECT * FROM member WHERE top_member = 'Y' and status = 'Y' and NOW() between start_date and end_date ORDER BY added_date DESC";
			$sql				= "SELECT * FROM member WHERE top_member = 'Y' and status = 'Y' ORDER BY added_date DESC";
			$result				= $database->query($sql);
			$num_rows			= $result->num_rows;
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					?>
					<div class="content-left_each">
						<div class="top-member-left">
							<h2><?php echo functions::deformat_string($data->title); ?></h2>
							<h3>Location - <span><?php echo functions::deformat_string($data->location); ?></span></h3>
							<p>
							<?php echo functions::get_sub_words(functions::deformat_string($data->description), 35); ?>
							</p>
						</div>
						<div class="top-member-right">
							<h3><?php echo functions::deformat_string($data->salary); ?><br />
								per annum</h3>
							<h4><?php echo $data->contract == 'P' ? 'Permanent' : 'Temp'; ?></h4>
							<h5><img src="images/<?php echo $this->theme; ?>/arrow.png" /> <a href="member_details.php?member_id=<?php echo $data->member_id; ?>">VIEW JOB</a></h5>
						</div>
					</div>
					<?php
				}
			}
			else
			{
				echo 'Sorry.. No records found !!';
			}
		}
		
		
		public static function get_latest_member($count = 5)
		{
			$database			= new database();
			$sql				= "SELECT * FROM member WHERE status = 'Y' AND end_date > NOW() ORDER BY added_date DESC LIMIT 0, " . $count;
			$result				= $database->query($sql);
			$num_rows			= $result->num_rows;
			if ($result->num_rows > 0)
			{
				echo '<div class="home_member_listing">';
				while($data = $result->fetch_object())
				{
					$member = new member($data->member_id);
					$style	= $style == 'home_member_listing_grey' ? 'home_member_listing_white' : 'home_member_listing_grey';
					?>
					<div id="<?php echo $style; ?>" class="home_member_listing_link">
						<div class="home_member_listing_image">
						<?php
						if($member->company_member != '' && file_exists(DIR_MEMBER . $member->company_member))
						{
							echo '<img src="' . URI_MEMBER . $member->company_member . '" border="0" width="61" height="46" >';
						}
						else
						{
							echo '<img src="images/candidate_no_image.jpg" border="0" width="61" height="46" />';
						}
						?>
						</div>
						<a href="member_details.php?id=<?php echo $data->member_id; ?>">
						<div class="home_member_listing_title"><?php echo functions::deformat_string($data->title); ?><br />
							<span><?php echo functions::deformat_string($member->company); ?> / <?php echo functions::deformat_string($data->location); ?></span>
						</div>
						<div class="home_member_listing_date"><?php echo $data->contract == 'P' ? 'Permanent' : 'Temp'; ?><br />
							<?php echo functions::get_format_date($data->end_date, 'M d'); ?>
						</div>
						</a>
					</div>
					<?php
				}
				echo '</div>';
			}
		}
		
		public static function get_newsletter_member_list($member_sector_id = 0)
		{
			$member_list	= '';
			$count		= 25;
			$database	= new database();
			
			$sql		= "";
			$sql		= " SELECT * FROM member WHERE status = 'Y' AND DATE(added_date) = DATE(NOW()) ";
			if($member_sector_id > 0)
			{
				$sql	.= " AND member_sector_id = '" . $member_sector_id . "' " ;
			}
			$sql		.= " ORDER BY added_date DESC LIMIT 0, " . $count;
			
			//print $sql . '<br />' ; 
			$result		= $database->query($sql);
			$num_rows	= $result->num_rows;
			if ($result->num_rows > 0)
			{
				$member_list	= '<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">';
				while($data = $result->fetch_object())
				{
					$member 	= new member($data->member_id);
					/*
					$member_list	.= '<br /><a href="' . URI_ROOT . 'member_details.php?id=' . $data->member_id . '"><strong>' . functions::deformat_string($data->title) . '</strong></a><br />';
					$member_list	.= 'Employer: ' . functions::deformat_string($member->company) . ' / ' . functions::deformat_string($data->location) . '<br />';
					$member_list	.= 'Contract: ' . ($data->contract == 'P' ? 'Permanent' : 'Temp') . '<br />';
					$member_list	.= 'Salary: ' . functions::deformat_string($data->salary);
					if($data->other_benefits != '')
					{
						$member_list	.= ', ' . functions::deformat_string($data->other_benefits);
					}
					$member_list	.= '<br />';
					$member_list	.= 'Closing date for applications: ' . functions::get_format_date($data->end_date, "dS F  Y") . '<br />';
					*/
					
					$member_list	.= '<tr><td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px;">';
					$member_list	.= '<a href="' . URI_ROOT . 'member_details.php?id=' . $data->member_id . '" style="color:#00AEEA; font-weight:bold;">' . functions::deformat_string($data->title) . '</a><br />';
					$member_list	.= 'Employer: ' . functions::deformat_string($member->company) . ' / ' . functions::deformat_string($data->location) . '<br />';
					$member_list	.= 'Contract: ' . ($data->contract == 'P' ? 'Permanent' : 'Temp') . '<br />';
					$member_list	.= 'Salary: ' . functions::deformat_string($data->salary);
					if($data->other_benefits != '')
					{
						$member_list	.= ', ' . functions::deformat_string($data->other_benefits);
					}
					$member_list	.= '<br />';
					$member_list	.= 'Closing date for applications: ' . functions::get_format_date($data->end_date, "dS F  Y") . '<br />';
					$member_list	.= '		</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>';
				}
				$member_list	.= '</table>';
			}
			
			return $member_list;
		}
		
		public static function get_featured_member($member_id = 0)
		{
			$database	= new database();
			$flag		= false;
			$sql		= "SELECT j.*, mp.usage_count as balance_usage_count, p.usage_limit AS package_usage_count FROM member AS j INNER JOIN member_package AS mp ON mp.member_id = j.member_id INNER JOIN package AS p ON p.package_id = mp.package_id WHERE  mp.package_id = '7' AND mp.end_date >= NOW() AND mp.payment_status = 'COMPLETE' AND j.status = 'Y' AND j.featured_member = 'Y' AND j.end_date > NOW() ";
			$result		= $database->query($sql);
			$num_rows	= $result->num_rows;
			
			if($member_id > 0)
			{
				$sql		.= " AND j.member_id != '$member_id' ORDER BY Rand()";
			}
			else
			{
				$sql		.= " ORDER BY Rand()";
			}
			
			$result		= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					$usage_limt = '';
					
					$package_usage_count	= $data->package_usage_count;
					$balance_usage_count	= $data->balance_usage_count;
					if($package_usage_count == 0)
					{
						$usage_limt = 'NO_LIMIT';
					}
					else
					{
						$usage_limt	= $package_usage_count - $balance_usage_count;
					}
					
					if($usage_limt == '')
					{
						continue;
					}
					else
					{
						$flag = true;
						$member = new member($data->member_id);							
						?>
						<p>
						<?php
						if($member->company_member != '' && file_exists(DIR_MEMBER . $member->company_member))
						{
							echo '<img src="' . URI_MEMBER . $member->company_member . '" border="0" width="61" height="46" >';
						}
						else
						{
							echo '<img src="images/candidate_no_image.jpg" border="0" width="61" height="46" />';
						}
						?>
						</p>
						<strong><?php echo functions::deformat_string($data->title); ?></strong><br />
						<?php echo functions::deformat_string($member->company); ?><br />
						<?php 
						echo functions::deformat_string($data->salary);
						if($data->other_benefits != '')
						{
							echo ', ' . functions::deformat_string($data->other_benefits);
						}
						?>
						<br />
						<a href="member_details.php?id=<?php echo $data->member_id; ?>">read more </a>
						<input type="hidden" id="current_featured_member" value="<?php echo $data->member_id; ?>"  />
						<input type="hidden" id="total_featured_member" value="<?php echo $num_rows; ?>"  />
						<?php
					}
					
					if($flag == true)
					{
						break;	
					}
				}
				
				if($flag == false)
				{
					echo 'Sorry.. No records found !!';
				}
			}
			else
			{
				echo 'Sorry.. No records found !!';
			}
		}
		
		public static function get_featured_member1($member_id = 0)
		{
			$database	= new database();
			$flag		= false;
			$sql		= "SELECT * FROM member WHERE status = 'Y' AND featured_member = 'Y' AND end_date > NOW() ";
			$result		= $database->query($sql);
			$num_rows	= $result->num_rows;
			
			if($member_id > 0)
			{
				$sql		.= " AND member_id != '$member_id' ORDER BY Rand()";
			}
			else
			{
				$sql		.= " ORDER BY Rand()";
			}
			
			$result		= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					$member = new member($data->member_id);
					$package_balance = member_package::check_package_balance($member->member_id, 7);
					if($package_balance === 'NO_LIMIT' || $package_balance > 0)
					{
						$flag = true;
						?>
						<p>
						<?php
						if($member->company_member != '' && file_exists(DIR_MEMBER . $member->company_member))
						{
							echo '<img src="' . URI_MEMBER . $member->company_member . '" border="0" width="61" height="46" >';
						}
						else
						{
							echo '<img src="images/candidate_no_image.jpg" border="0" width="61" height="46" />';
						}
						?>
						</p>
						<strong><?php echo functions::deformat_string($data->title); ?></strong><br />
						<?php echo functions::deformat_string($member->company); ?><br />
						<?php 
						echo functions::deformat_string($data->salary);
						if($data->other_benefits != '')
						{
							echo ', ' . functions::deformat_string($data->other_benefits);
						}
						?>
						<br />
						<a href="member_details.php?id=<?php echo $data->member_id; ?>">read more </a>
						<input type="hidden" id="current_featured_member" value="<?php echo $data->member_id; ?>"  />
						<input type="hidden" id="total_featured_member" value="<?php echo $num_rows; ?>"  />
						<?php
					}
					
					if($flag == true)
					{
						break;	
					}
				}
				
				if($flag == false)
				{
					echo 'Sorry.. No records found !!';
				}
			}
			else
			{
				echo 'Sorry.. No records found !!';
			}
		}
		
		public static function get_top_member($member_id = 0)
		{
			$database	= new database();
			
			$sql		= "SELECT * FROM member WHERE status = 'Y' AND top_member = 'Y' AND end_date > NOW() ";
			$result		= $database->query($sql);
			$num_rows	= $result->num_rows;
			
			if($member_id > 0)
			{
				$sql		.= " AND member_id != '$member_id' ORDER BY Rand() Limit 0, 1";
			}
			else
			{
				$sql		.= " ORDER BY Rand() Limit 0, 1";
			}
			
			$result		= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					$member = new member($data->member_id);
					?>
					<p>
					<?php
					if($member->company_member != '' && file_exists(DIR_MEMBER . $member->company_member))
					{
						echo '<img src="' . URI_MEMBER . $member->company_member . '" border="0" width="61" height="46" >';
					}
					else
					{
						echo '<img src="images/candidate_no_image.jpg" border="0" width="61" height="46" />';
					}
					?>
					</p>
					<strong><?php echo functions::deformat_string($data->title); ?></strong><br />
					<?php echo functions::deformat_string($member->company); ?><br />
					<?php 
					echo functions::deformat_string($data->salary);
					if($data->other_benefits != '')
					{
						echo ', ' . functions::deformat_string($data->other_benefits);
					}
					?>
					<br />
					<a href="member_details.php?id=<?php echo $data->member_id; ?>">read more </a>
					<input type="hidden" id="current_top_member" value="<?php echo $data->member_id; ?>"  />
					<input type="hidden" id="total_top_member" value="<?php echo $num_rows; ?>"  />
					<?php
				}
			}
			else
			{
				echo 'Sorry.. No records found !!';
			}
		}
		
		public static function get_current_recruiter($count = 5)
		{
			$database			= new database();
			$sql				= "SELECT m.member_id, m.first_name, m.last_name, m.company, m.company_member FROM member AS j INNER JOIN member AS m ON m.member_id = j.member_id WHERE j.status = 'Y' AND j.end_date > NOW() GROUP BY m.member_id ORDER BY added_date DESC LIMIT 0, " . $count;
			$result				= $database->query($sql);
			$num_rows			= $result->num_rows;
			echo '<div class="recently_recruiting"><div class="recently_recruiting_heading">CURRENTLY RECRUITING</div>';
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					?>
					<div class="employer_member">
					<a href="employer_details.php?id=<?php echo $data->member_id; ?>" title="<?php echo functions::deformat_string($data->title); ?>">
					<?php
					if($data->company_member != '' && file_exists(DIR_MEMBER . $data->company_member))
					{
						echo '<img src="' . URI_MEMBER . $data->company_member . '" border="0" width="61" height="46" >';
					}
					else
					{
						echo '<img src="images/candidate_no_image.jpg" border="0" width="61" height="46" />';
					}
					?>
					</a>
					</div>
					<?php
				}
			}
			echo '</div>';
		}
		
		public function get_current_member()
		{
			$database			= new database();
			$member_array 			= array();
			if($this->member_sector_id > 0)
			{
				$condition	= " and member_sector_id = '". $this->member_sector_id ."' ";
			}
			else
			{
				$condition	= "";
			}
			
			//$sql				= "SELECT * FROM member WHERE status = 'Y' " . $condition . " and  NOW() between start_date and end_date ORDER BY added_date DESC";
			$sql				= "SELECT * FROM member WHERE status = 'Y' " . $condition . " ORDER BY added_date DESC";
			$result				= $database->query($sql);
			$num_rows			= $result->num_rows;
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					?>
					<div class="content-left_each">
						<div class="top-member-left">
							<h2><?php echo functions::deformat_string($data->title); ?></h2>
							<h3>Location - <span><?php echo functions::deformat_string($data->location); ?></span></h3>
							<p>
							<?php echo functions::get_sub_words(functions::deformat_string($data->description), 35); ?>
							</p>
						</div>
						<div class="top-member-right">
							<h3><?php echo functions::deformat_string($data->salary); ?><br />
								per annum</h3>
							<h4><?php echo $data->contract == 'P' ? 'Permanent' : 'Temp'; ?></h4>
							<h5><img src="images/<?php echo $this->theme; ?>/arrow.png" /> <a href="member_details.php?member_id=<?php echo $data->member_id; ?>">VIEW JOB</a></h5>
						</div>
					</div>
					<?php
				}
			}
			else
			{
				echo 'Sorry.. No records found !!';
			}
		}
		
		public function get_member_list()
		{
			$database				= new database();
			$param_array			= array();
			$sql 					= "SELECT j.* FROM member AS j INNER JOIN member AS m ON j.member_id = m.member_id ";
			
			$search_condition		= '';
			
			$search_cond_array[]	= " j.end_date > NOW() ";
			$search_cond_array[]	= " j.status = 'Y' ";
			
			if($this->member_sector_id != '' )		
			{
				$param_array[] 			= "member_sector_id=" . $this->member_sector_id;
				$search_cond_array[]	= " j.member_sector_id = '" . $this->member_sector_id . "' ";			   
			}
			
			if($this->search_keyword != '')
			{
				$param_array[] 			= "search_keyword=" . $this->search_keyword;
				$search_cond_array[]	= " j.title like '%" . $this->search_keyword . "%' OR j.location like '%" . $this->search_keyword . "%' OR j.salary like '%" . $this->search_keyword . "%' OR m.company like '%" . $this->search_keyword . "%' ";			   
			}
			
			if(count($search_cond_array)>0) 
			{ 
				$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
			}
			
			$sql			.= $search_condition;
			
			if(isset($_REQUEST['sort']))
			{
				$sortField		= $_REQUEST['sort'];
				$sortOrder		= $_REQUEST['odr'];
				$sql			.= " ORDER BY ".$sortField." ".$sortOrder;	
				$param_array[]	= "sort=".$_REQUEST['sort'];	
				$param_array[]	= "odr=".$_REQUEST['odr'];			
			}
			else
			{
				$sortField	= " j.added_date ";
				$sortOrder	= "DESC";
				$sql		.= " ORDER BY ".$sortField." ".$sortOrder;
			}
			
			//$sql 			= $sql . " ORDER BY member_date DESC";
			//print $sql;
			$result			= $database->query($sql);
			
			$this->num_rows = $result->num_rows;
			//functions::paginate($this->num_rows);
			functions::paginateclient($this->num_rows, 0, 0, 'CLIENT');
			$start			= functions::$startfrom;
			$limit			= functions::$limits;
			$sql 			= $sql . " limit $start, $limit";
			//print $sql;
			$result			= $database->query($sql);
			
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			$member_array	= array();
			
			$member_id		= isset($_SESSION[MEMBER_ID]) && $_SESSION[MEMBER_ID] > 0 ? $_SESSION[MEMBER_ID] : 0;
			$member			= new member($member_id);
			
			if ($result->num_rows > 0)
			{				
				$i 			= 0;
				$row_num	= functions::$startfrom;
				$page		= functions::$startfrom > 0 ? (functions::$startfrom / FRONT_PAGE_LIMIT) + 1 : 1;			
				while($data=$result->fetch_object())
				{
					$member = new member($data->member_id);
					$style	= $style == 'member_listing_grey' ? 'member_listing_white' : 'member_listing_grey';
					?>
					<div id="<?php echo $style; ?>" class="member_listing_link">
						<div class="member_listing_image">
						<?php
						if($member->company_member != '' && file_exists(DIR_MEMBER . $member->company_member))
						{
							echo '<img src="' . URI_MEMBER . $member->company_member . '" border="0" width="61" height="46" >';
						}
						else
						{
							echo '<img src="images/employer_no_image.jpg" border="0" width="61" height="46" />';
						}
						?>
						</div>
						<a href="member_details.php?id=<?php echo $data->member_id; ?>">
						<div class="member_listing_title"><?php echo functions::deformat_string($data->title); ?><br />
							<span><?php echo functions::deformat_string($member->company); ?> / <?php echo functions::deformat_string($data->location); ?></span>
						</div>
						<div class="member_listing_date"><?php echo $data->contract == 'P' ? 'Permanent' : 'Temp'; ?><br />
							<?php echo functions::get_format_date($data->end_date, 'M d'); ?>
						</div>
						<!-- <div class="member_listing_salary">Salary<br /><?php echo functions::deformat_string($data->salary); ?></div> -->
						</a>
					</div>
					<?php					
				}
				$param=join("&amp;",$param_array); 
				$this->pager_param=$param;
			}
			else
			{
				$this->pager_param1 = join("&",$param_array);
				if(isset($_GET['page']))
				{
					$currentPage = $_GET['page'];
				}
				if($currentPage>1)
				{
					$currentPage = $currentPage-1;
					if($this->pager_param=="")
					{
						$urlQuery = 'member.php?page='.$currentPage;
					}
					else
					{
						$urlQuery = 'member.php?'.$this->pager_param1.'&page='.$currentPage;	
					}
					functions::redirect($urlQuery);
				}
				else
				{
					echo "<div align='center' class='warningMesg'>Sorry.. No records found !!</div>";
				}
			}
		}
		
		public function my_member_list()
		{
			$database				= new database();
			$param_array			= array();
			$sql 					= "SELECT j.* FROM member AS j INNER JOIN member AS m ON j.member_id = m.member_id ";
			
			$search_condition		= '';
			
			//$search_cond_array[]	= " j.end_date > NOW() ";
			//$search_cond_array[]	= " j.status = 'Y' ";
			$search_cond_array[]	= " j.member_id = '" . $this->member_id . "' ";
			/*
			if($this->member_sector_id != '' )		
			{
				$param_array[] 			= "member_sector_id=" . $this->member_sector_id;
				$search_cond_array[]	= " j.member_sector_id = '" . $this->member_sector_id . "' ";			   
			}
			
			if($this->search_keyword != '')
			{
				$param_array[] 			= "search_keyword=" . $this->search_keyword;
				$search_cond_array[]	= " j.title like '%" . $this->search_keyword . "%' OR j.location like '%" . $this->search_keyword . "%' OR j.salary like '%" . $this->search_keyword . "%' OR m.company like '%" . $this->search_keyword . "%' ";			   
			}
			*/
			if(count($search_cond_array)>0) 
			{ 
				$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
			}
			
			$sql			.= $search_condition;
			
			if(isset($_REQUEST['sort']))
			{
				$sortField		= $_REQUEST['sort'];
				$sortOrder		= $_REQUEST['odr'];
				$sql			.= " ORDER BY ".$sortField." ".$sortOrder;	
				$param_array[]	= "sort=".$_REQUEST['sort'];	
				$param_array[]	= "odr=".$_REQUEST['odr'];			
			}
			else
			{
				$sortField	= " j.added_date ";
				$sortOrder	= "DESC";
				$sql		.= " ORDER BY ".$sortField." ".$sortOrder;
			}
			
			//$sql 			= $sql . " ORDER BY member_date DESC";
			//print $sql;
			$result			= $database->query($sql);
			
			$this->num_rows = $result->num_rows;
			//functions::paginate($this->num_rows);
			functions::paginateclient($this->num_rows, 0, 0, 'CLIENT');
			$start			= functions::$startfrom;
			$limit			= functions::$limits;
			$sql 			= $sql . " limit $start, $limit";
			//print $sql;
			$result			= $database->query($sql);
			
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			$member_array	= array();
			
			//$member_id		= isset($_SESSION[MEMBER_ID]) && $_SESSION[MEMBER_ID] > 0 ? $_SESSION[MEMBER_ID] : 0;
			//$member			= new member($member_id);
			
			if ($result->num_rows > 0)
			{				
				$i 			= 0;
				$row_num	= functions::$startfrom;
				$page		= functions::$startfrom > 0 ? (functions::$startfrom / FRONT_PAGE_LIMIT) + 1 : 1;			
				while($data=$result->fetch_object())
				{
					//$member = new member($data->member_id);
					$style	= $style == 'member_listing_grey' ? 'member_listing_white' : 'member_listing_grey';
					$row_num++;
					$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
					$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
					?>
					<div class="bid_table_single">
						<div class="table_ceremony" style="padding-left:10px;"><?php echo $row_num; ?>.</div>
						<div class="table_details" style="padding-left:8px;"><?php echo functions::deformat_string($data->title) . ', ' . CURRENCY_SYMBOL . functions::deformat_string($data->salary); ?></div>
						<div class="table_time"><?php echo functions::get_format_date($data->end_date, 'd-M-Y'); ?></div>
						<div class="table_more"><a href="member_application.php?id=<?php echo $data->member_id; ?>"><?php echo member_application::get_count($data->member_id); ?></a> </div>
						<div class="table_more" style="width:100px;"><a href="member_application.php?id=<?php echo $data->member_id; ?>"><?php echo member_application::get_count($data->member_id, 'PENDING'); ?></a> </div>
						<div class="table_delete"><a title="Click here to update status" style="cursor:pointer;" onclick="javascript: member_status('<?php echo $data->member_id; ?>','<?php echo $row_num; ?>');" ><img id="status_image_<?php echo $row_num; ?>" src="images/<?php echo $status_image; ?>" alt ="<?php echo $status; ?>" title ="<?php echo $status; ?>"></a></div>
						<div class="table_more"><a href="member_details.php?id=<?php echo $data->member_id; ?>">Details</a> </div>
						<div class="table_delete" style="width:50px;"><a href="create_member.php?member_id=<?php echo $data->member_id; ?>">Edit</a> </div>
					</div>
					<?php					
				}
				$param=join("&amp;",$param_array); 
				$this->pager_param=$param;
			}
			else
			{
				$this->pager_param1 = join("&",$param_array);
				if(isset($_GET['page']))
				{
					$currentPage = $_GET['page'];
				}
				if($currentPage>1)
				{
					$currentPage = $currentPage-1;
					if($this->pager_param=="")
					{
						$urlQuery = 'member.php?page='.$currentPage;
					}
					else
					{
						$urlQuery = 'member.php?'.$this->pager_param1.'&page='.$currentPage;	
					}
					functions::redirect($urlQuery);
				}
				else
				{
					echo "<div align='center' class='warningMesg'>Sorry.. No records found !!</div>";
				}
			}
		}
		
		public function get_member_list2($member_id = 0)
		{
			$database			= new database();
			$member_array 	= array();
			if($member_id > 0)
			{
				$sql	= "SELECT * FROM member WHERE member_id='".$member_id."' ORDER BY added_date DESC";
			}
			else
			{
				$sql	= "SELECT * FROM member ORDER BY added_date DESC";
			}
			$result				= $database->query($sql);
			$num_rows			= $result->num_rows;
			if ($result->num_rows > 0)
			{
				$counter		= 0;
				$i				= 0;
				while($data = $result->fetch_object())
				{
					$i++;
					
					$thumb_image	= '';
					//$url			= '';
					
					$youtube		= new youtube();
					$video_id		= $youtube->parseURL($data->location);
					$thumb_image	= $youtube->GetImgURL($data->location, 1);
					//$url			.= '?gallery_category_id=' . $data->gallery_category_id;
					
					if($counter == 0)
					{
						echo '<div id="portfoilio_inner_box">
								<div id="portfoilio_inner_top"><img src="images/member_box_inner_top.png" /></div>
								<div id="portfoilio_inner_bg">';	
					}
					?>
					
					<div class="portfoilio_image_space"></div>
					<div class="portfoilio_image_outer" style="cursor:pointer;" onclick="<?php echo $select_member_details > 0 ? 'show_video' : 'select_member_details'; ?>('<?php echo $data->member_id; ?>', '<?php echo $video_id; ?>');"><img src="<?php echo $thumb_image; ?>" alt="<?php echo functions::format_text_field($data->alt); ?>" width="132px" height="127px" />
						<div class="portfoilio_image_box"></div>
						<div class="portfoilio_image_company"><?php echo functions::deformat_string($data->name); ?></div>
					</div>
					<?php
					$counter++;
					
					if($counter == 5 || $i == $num_rows )
					{
						$counter=0;
						echo '<div class="portfoilio_image_space"></div>
							</div>
							<div id="portfoilio_inner_top"><img src="images/member_box_inner_bttm.png"/></div>
						</div>';	
					}
				}
			}
		}
	public static function get_max_order_id()
	{
		$database	= new database();
		$sql		= "SELECT MAX(order_id) AS order_id FROM member WHERE 1 ";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$data	= $result->fetch_object();
			return $data->order_id > 0 ? $data->order_id : 0;
		}
		else
		{
			return 0;
		}
	}
	
	
		public  function recent_activity($cat = 0)
		{
			$output     = array();
			$output1     = array();
			$database	= new database();
			$i =0;
			
			if($cat == 0 || $cat == 1|| $cat == 3)
			{
				$sql		= "SELECT * FROM content_like WHERE like_type='favorite' AND member_id =$this->member_id ORDER BY created_at DESC";
				$result		= $database->query($sql);
				

					
				if ($result->num_rows > 0)
				{
					while($data	= $result->fetch_object())
					{   $output[$i] = new stdClass();
						$output[$i]->type = $data->model_name;
						$output[$i]->id   = $data->content_id;
						$output[$i]->created_date   = $data->created_at;
						$i++;
					}
				}
				
			}
			
			$i =0;
			if($cat == 0 || $cat == 1|| $cat == 4)
			{
				$sql1		= "SELECT * FROM content_comment WHERE member_id =$this->member_id ORDER BY created_date DESC";
				$result1		= $database->query($sql1);
				if ($result1->num_rows > 0)
				{
					while($data1	= $result1->fetch_object())
					{   $output1[$i] = new stdClass();
						$output1[$i]->type = 'comment';
						$output1[$i]->id   = $data1->content_comment_id;
						$output1[$i]->created_date   = $data1->created_date;
						$i++;
					}
				}	
			}
			
			$out 	= array_merge((array)$output, (array)$output1);
			return $out;
		}
		
		
		
	
	
	}
?>