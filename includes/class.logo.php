<?php
    class logo
	{
		protected $_properties;
		public $error;
		public $message;
		public $warning;
		public $logo_category= array(1=> 'Partners', 2=>'Sponsors',);
        function __construct($logo_id = 0)
		{
			$this->_properties	= array();
			$this->error		= '';
			$this->message		= '';
			$this->warning		= false;
			
			if($logo_id > 0)
			{
				$this->initialize($logo_id);
			}
        }
		function __get($propertyName)
        {
			if (array_key_exists($propertyName, $this->_properties))
			{
				return $this->_properties[$propertyName];
			}
			return null;
        }
		public function __set($propertyName, $value)
		{
			return $this->_properties[$propertyName] = $value;
		}
		public function get_logo_category()
		{
			return $this->logo_category;
		}
		public function __destruct() 
		{
			unset($this->_properties);
			unset($this->error);
			unset($this->message);
			unset($this->warning);
		}
		
		//Initialize object variables.
		private function initialize($logo_id)
		{
			$database	= new database();
			$sql		= "SELECT *	 FROM logo WHERE logo_id = '$logo_id'";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
		}
		
		//Save the logo details
		public function save()
		{
			$database	= new database();
			$logo_id	= $this->_properties['logo_id'] > 0 ? $this->_properties['logo_id'] : 0;
			if(!$this->check_logoname_exist($this->logo_name,  $logo_id))
			{				
				
			   	if ( isset($this->_properties['logo_id']) && $this->_properties['logo_id'] > 0) 
				{
					$logo			= new logo($this->_properties['logo_id']);
					$current_status 	= $logo->status;					
					$sql	= "UPDATE logo SET 					        
					logo_name = '". $database->real_escape_string($this->logo_name) ."', 
					category_id = '".  $database->real_escape_string($this->category_id)  ."' ,
					image_name = '".  $database->real_escape_string($this->image_name)  ."' ,
					status = '". $database->real_escape_string($this->status) ."',	
					url = '". $database->real_escape_string($this->url) ."'	
					WHERE logo_id = '$this->logo_id'";
					$result			= $database->query($sql);
							
				}
				else 
				{
					$current_status = $this->status;
						
					$order_id	= self::get_max_order_id() + 1;
					 $sql		= "INSERT INTO logo 
					(logo_name,image_name,category_id,status,url, order_id,added_time) 
					VALUES (						
					
					'" . $database->real_escape_string($this->logo_name) . "', 
					'" . $database->real_escape_string($this->image_name) . "',
					'" . $database->real_escape_string($this->category_id) . "',
					'" . $database->real_escape_string($this->status). "'	,
					'" . $database->real_escape_string($this->url). "'	,
					'" . $order_id."',
					NOW()
					
					)";
					$result			= $database->query($sql);
															
										
				}
							
					
				
				if($database->affected_rows == 1)
				{
					if($this->logo_id == 0)
					{
						$this->logo_id	= $database->insert_id;	
					}																								
				}
				
				$this->initialize($this->logo_id);	
				$this->message = cnst11;
				$this->warning = false;
				return true;
			}
		}
		
		
	
		
		// Save the logo details
		public function save_profile()
		{
			$database	= new database();
			$logo_id	= $this->_properties['logo_id'] > 0 ? $this->_properties['logo_id'] : 0;
			if ( $logo_id > 0) 
			{
			 $sql	= "UPDATE logo SET 
						name = '". $database->real_escape_string($this->name) ."', 
						logo_code = '". $database->real_escape_string($this->logo_code) ."', 
						title = '". $database->real_escape_string($this->title) ."', 
						email = '". $database->real_escape_string($this->email) ."', 
						postcode = '". $database->real_escape_string($this->postcode) ."', 
						phone = '". $database->real_escape_string($this->phone) ."',						
						address = '". $database->real_escape_string($this->address) ."',
						address1 = '". $database->real_escape_string($this->address1) ."',
						address2 = '". $database->real_escape_string($this->address2) ."' 
						WHERE logo_id = '$this->logo_id'";
			
			}
			
			$result			= $database->query($sql);
			
			if($database->affected_rows == 1)
			{
				$this->initialize($this->logo_id);
				$email_template		= new email_template('admin.edit-profile');
				//Replace template content with original values
				$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
				$mail_content		= str_replace("{name}", functions::deformat_string($this->name), $mail_content);
				$mail_content		= str_replace("{logo_code}", functions::deformat_string($this->logo_code), $mail_content);
				$mail_content		= str_replace("{title}", functions::deformat_string($this->title), $mail_content);
				$mail_content		= str_replace("{email}", functions::deformat_string($this->email), $mail_content);
				$mail_content		= str_replace("{postcode}", functions::deformat_string($this->postcode), $mail_content);
				$mail_content		= str_replace("{phone}", functions::deformat_string($this->phone), $mail_content);						
				$mail_content		= str_replace("{address}", functions::deformat_string($this->address), $mail_content);
				$mail_content		= str_replace("{address1}", functions::deformat_string($this->address1), $mail_content);
				$mail_content		= str_replace("{address2}", functions::deformat_string($this->address2), $mail_content);
				//$mail_content		= str_replace("{category}", functions::deformat_string($this->category), $mail_content);
				$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
		
			
				$mailer				= new mailer();
				$mailer->from		= $this->email;
				$mailer->to			= ADMIN_EMAIL_ID;
				$mailer->subject	= $email_template->subject;
				$mailer->body		= $mail_content;
				$mailer->send();
				
				/**** Member notification mail code end here  ***/
			}
			
			$this->message = cnst11;
		}
		
		public function edit_profile()
		{
			$database	= new database();
			$logo_id	= $this->_properties['logo_id'] > 0 ? $this->_properties['logo_id'] : 0;
			if ( $logo_id > 0) 
			{
			 $sql	= "UPDATE logo SET 
						name = '". $database->real_escape_string($this->name) ."', 
						logo_code = '". $database->real_escape_string($this->logo_code) ."', 
						title = '". $database->real_escape_string($this->title) ."', 
						email = '". $database->real_escape_string($this->email) ."', 
						password = '". md5($database->real_escape_string($this->password)) ."', 
						postcode = '". $database->real_escape_string($this->postcode) ."', 
						phone = '". $database->real_escape_string($this->phone) ."',						
						address = '". $database->real_escape_string($this->address) ."',
						address1 = '". $database->real_escape_string($this->address1) ."',
						address2 = '". $database->real_escape_string($this->address2) ."',
						migration_status = 'Y',
						registration_date = NOW()
						WHERE logo_id = '$this->logo_id'";
			
			}
			
			$result			= $database->query($sql);
			
			if($database->affected_rows == 1)
			{
				$this->initialize($this->logo_id);
				$email_template		= new email_template('admin.edit-profile');
				//Replace template content with original values
				$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
				$mail_content		= str_replace("{name}", functions::deformat_string($this->name), $mail_content);
				$mail_content		= str_replace("{logo_code}", functions::deformat_string($this->logo_code), $mail_content);
				$mail_content		= str_replace("{title}", functions::deformat_string($this->title), $mail_content);
				$mail_content		= str_replace("{email}", functions::deformat_string($this->email), $mail_content);
				$mail_content		= str_replace("{postcode}", functions::deformat_string($this->postcode), $mail_content);
				$mail_content		= str_replace("{phone}", functions::deformat_string($this->phone), $mail_content);						
				$mail_content		= str_replace("{address}", functions::deformat_string($this->address), $mail_content);
				$mail_content		= str_replace("{address1}", functions::deformat_string($this->address1), $mail_content);
				$mail_content		= str_replace("{address2}", functions::deformat_string($this->address2), $mail_content);
				$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
		
			
				$mailer				= new mailer();
				$mailer->from		=$this->email;
				$mailer->to			= ADMIN_EMAIL_ID;
				$mailer->subject	= $email_template->subject;
				$mailer->body		= $mail_content;
				$mailer->send();
				
				/**** Member notification mail code end here  ***/
			}
			
			$this->message = cnst11;
		}
		
		// Validate logo login information
		public function validate_login()
		{
			$this->message	= "";
			
			$database	= new database();
			
			$sql		= "SELECT * FROM logo WHERE status = 'Y' AND username = '" . $database->real_escape_string($this->username) . "' AND password = '" . md5($database->real_escape_string($this->password)) . "'";
			
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
		
		// Validate password recovery details
		public function validate_logo_details()
		{
			$this->message	= "";
			$output			= false;
			$database		= new database();
			
			if($this->email != '')
			{
				echo $sql		= "SELECT * FROM logo WHERE email = '" . $database->real_escape_string($this->email) . "'";
				
				$result		= $database->query($sql);
				
				if ($result->num_rows > 0)
				{
					$this->_properties = $result->fetch_assoc();
										
					$output			= true;
				}
				else
				{
					$this->message 	= "Email is not valid!";
					$this->warning	= true;
					$output			= false;
				}
			}
			else if($this->email != '')
			{
				$sql		= "SELECT * FROM logo WHERE email = '" . $database->real_escape_string($this->email) . "'";
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
				$this->message	= "Password reset information sent to your email. Please follow the instruction in the mail!";
				$this->warning	= false;
				
				$unique_code	= $this->get_unique_code();
				$this->update_unique_code($this->logo_id, $unique_code);
				$reset_password_url = URI_ROOT . 'reset_password.php?mid=' . $this->logo_id . '&uc=' . $unique_code;
				
				/**** Forgot password mail code stats here  ***/
				$mail_content		= '';
				$email_template		= new email_template('logo.forgot-password');
				//Replace template content with original values
				$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
				$mail_content		= str_replace("{name}", functions::deformat_string($this->name), $mail_content);
				$mail_content		= str_replace("{URL}", $reset_password_url, $mail_content);
				$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
				
				$mailer				= new mailer();
				$mailer->from		= ADMIN_EMAIL_ID;
				$mailer->to			= $this->email;
				$mailer->subject	= $email_template->subject;
				$mailer->body		= $mail_content;
							
				$mailer->send();
				/**** Forgot password mail code end here  ***/
			}
			return $output;
		}
		// The function return a random number
		public function get_unique_code()
		{
			$database 	= new database();
			$random_num = rand(12345,199999)+rand(123,999);
			$timestamp	= time();
			$unique_code= $random_num . ($timestamp + rand(10,999));
			$sql		= "SELECT * FROM logo WHERE unique_code = '" . $unique_code . "'";
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
		
		// The function return a random number
		public function validate_unique_code($logo_id, $unique_code)
		{
			$database	= new database();
			$logo_id	= $logo_id > 0 ? $logo_id : 0;
			$sql		= "SELECT * FROM logo WHERE logo_id = '" . $database->real_escape_string($logo_id) . "' AND unique_code = '" . $database->real_escape_string($unique_code) . "'";
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
		//The function check the module name eixst or not
		public function check_logoname_exist($name='', $logo_id=0)
		{
			$output		= false;
			$database	= new database();
			if($name == '')
			{
				$this->message	= "Title should not be empty!";
				$this->warning	= true;
			}
			else
			{
				if($logo_id > 0)
				{
					$sql	= "SELECT *	 FROM logo WHERE logo_name = '" . $database->real_escape_string($name) . "' AND logo_id != '" . $logo_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM logo WHERE logo_name = '" . $database->real_escape_string($name) . "'";
				}
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					$this->message	= "Title is already exist!";
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
		
		//The function check the module name eixst or not
		public function check_email_exist($email='', $logo_id=0)
		{
			$output		= false;
			$database	= new database();
			if($email == '')
			{
				$this->message	= "Email  should not be empty!";
				$this->warning	= true;
			}
			else
			{
				if($logo_id > 0)
				{
					$sql	= "SELECT *	 FROM logo WHERE email = '" . $database->real_escape_string($email) . "' AND logo_id != '" . $logo_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM logo WHERE email = '" . $database->real_escape_string($email) . "'";
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
		// Validate logo id
		public static function validate_logo_id($logo_id)
		{
			$output		= false;
			$database	= new database();
			$sql		= "SELECT logo_id FROM logo WHERE logo_id = '" . $logo_id . "'";
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$output		= true;
			}
			return $output;
		}
		
		// The function is used to change the password.
		public function change_password($old_password, $password)
		{		
			$database	= new database();
			$sql		= "SELECT *	 FROM logo WHERE logo_id = '" . $this->logo_id . "' AND password = '" . md5($database->real_escape_string($old_password)) . "'";
			
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
				
		// The function is used to change the password.
		public function update_password($password, $send_notification_mail=true)
		{		
			$database	= new database();
			
			$sql		= "UPDATE logo 
						SET password = '". md5($database->real_escape_string($password)) . "' 
						WHERE logo_id = '" . $this->logo_id . "'";
			$result 	= $database->query($sql);
			$this->initialize($this->logo_id);
			$this->message = "Password successfully updated!";
			$this->warning = false;
			
			/**** Reset password mail code stats here  ***/
			if($send_notification_mail)
			{
				$mail_content	= '';
				$email_template	= new email_template('logo.reset-password');
				
				//Replace template content with original values
				$mail_content	= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
				$mail_content	= str_replace("{name}", functions::deformat_string($this->name), $mail_content);
				$mail_content	= str_replace("{username}", functions::deformat_string($this->username), $mail_content);
				$mail_content	= str_replace("{password}", functions::deformat_string($password), $mail_content);
				$mail_content	= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
				
				$mailer				= new mailer();
				$mailer->from		= ADMIN_EMAIL_ID;
				$mailer->to			= $this->email;
				$mailer->subject	= $email_template->subject;
				$mailer->body		= $mail_content;
				
				$mailer->send();
			}
			
			/**** Reset password mail code end here  ***/
			return true;
		}
		
		// The function is used to change the status.
		public static function update_status($logo_id, $status = '')
		{	
			$database		= new database();
			$logo			= new logo($logo_id);
			//$current_status = $logo->status;
			if($status == '')
			{
				 $status =  $logo->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE logo 
						SET status = '". $status . "'
						WHERE logo_id = '" . $logo_id . "'";
			$result 	= $database->query($sql);
			
			
			//if($current_status != $status)
			//{
				/**** Status update mail code stats here  ***/
				/*$mail_content		= '';
				if($status == 'Y')
				{
					$email_template		= new email_template('logo.status-approved');
				}
				else
				{
					$email_template		= new email_template('logo.status-disabled');
				}
				//Replace template content with original values
				$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
				$mail_content		= str_replace("{name}", functions::deformat_string($logo->name), $mail_content);
				$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
				
				$mailer				= new mailer();
				$mailer->from		= ADMIN_EMAIL_ID;
				$mailer->to			= $logo->email;
				$mailer->subject	= $email_template->subject;
				$mailer->body		= $mail_content;
				
				
				$mailer->send();*/
				/**** Status update mail code end here  ***/
			//}
			return $status;
		}
		
		// The function is used to change the theme.
		public static function update_theme($logo_id, $theme = 'default')
		{		
			$database	= new database();
			
			 $sql		= "UPDATE logo 
						SET theme = '". $theme . "'
						WHERE logo_id = '" . $logo_id . "'";
						
			$result 	= $database->query($sql);
		}
		
		// The function is used to update unique_code value.
		public function update_unique_code($logo_id, $unique_code = '')
		{		
			$database	= new database();
			
			$sql		= "UPDATE logo 
						SET unique_code = '". $unique_code . "'
						WHERE logo_id = '" . $logo_id . "'";
			$result 	= $database->query($sql);
		}
		
		// Remove selected items
		function remove_selected($logo_ids)
		{
			$database	= new database();
			if(count($logo_ids)>0)
			{		
				foreach($logo_ids as $logo_id)
				{	
				
					$logo		= new logo($logo_id);
					$image_name = $logo->image_name;
					
					if(file_exists(DIR_LOGO . $image_name))
					{
						unlink(DIR_LOGO . $image_name);
						
					}
					if(file_exists(DIR_LOGO ."thumb_". $image_name))
					{
												
						unlink(DIR_LOGO ."thumb_". $image_name);
					}
					if(file_exists(DIR_LOGO ."thumb1_". $image_name))
					{
												
						unlink(DIR_LOGO ."thumb1_". $image_name);
					}
					if(file_exists(DIR_LOGO ."thumbresize_". $image_name))
					{
												
						unlink(DIR_LOGO ."thumbresize_". $image_name);
					}
					
					
					
					
					
					$sql = "DELETE FROM logo WHERE logo_id = '" . $logo_id . "'";
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
		
		public function display_list()
		{
			$database					= new database();
			$validation					= new validation(); 
			$param_array				= array();
			 $sql 						= "SELECT  * from logo  ";
			
			if ($this->category_id > 0 || $this->search_word != "")
			//if ($this->search_word != "")
			{	
				if($this->category_id != 0 || $this->category_id !='')
				{
					$param_array[]			= "category_id=" . $this->category_id;
					$search_cond_array[]	= "category_id = '" . $this->category_id . "'";
				} 
				
				if($this->search_word != "") 
				{
					$param_array[]			= "search_word=" . htmlentities($this->search_word);
					$search_word_array		= explode(" ", $this->search_word);
					for($i = 0; $i < count($search_word_array); $i++)
					{
												$search_cond_array[]	= " (
												logo_name like '%" . $database->real_escape_string($search_word_array[$i]) . "%' 
											 ) ";	
					}
				}
				$drag_drop 						= ' nodrag nodrop ';
			}	
			//print_r ($param_array);
			
			if(count($search_cond_array)>0) 
			{
				$search_condition	= " WHERE " . join(" AND ", $search_cond_array); 
				$sql				.= $search_condition;
			}
			
			$sql 			= $sql . " ORDER BY order_id ASC";
			
			/*if(isset($_REQUEST['sort']))
			{
				$sortField		= $_REQUEST['sort'];
				$sortOrder		= $_REQUEST['odr'];
				$sql			.= " ORDER BY ".$sortField." ".$sortOrder;	
				$param_array[]	= "sort=".$_REQUEST['sort'];	
				$param_array[]	= "odr=".$_REQUEST['odr'];			
			}
			else
			{
				$sortField	= "p.order_id";
				$sortOrder	= "ASC";
				$sql		.= " ORDER BY ".$sortField." ".$sortOrder;
			}*/
			
		
			
			$result				= $database->query($sql);
			$this->num_rows		= $result->num_rows;
			$param				= join("&amp;",$param_array); 
			$this->pager_param	= $param;
			functions::paginate($this->num_rows);
			$start	= functions::$startfrom;
			$limit	= functions::$limits;
			
			$sql	= $sql . " limit $start, $limit";
			$result	= $database->query($sql);
			if ($result->num_rows > 0)
			{				
				$i			= 0;
				$row_num	= functions::$startfrom;
			   	echo '
				<tr class="lightColorRow nodrop nodrag" style="display:none;">
					<td colspan="7"  class="noBorder">
						<input type="hidden" id="show"  name="show" value="0" />
						<input type="hidden" id="logo_id" name="logo_id" value="0" />
						<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					</td>
                </tr>';
				while($data=$result->fetch_object())
				{
					$i++;
					$row_num++;
					$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
					$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	
					
					$date_arr				= explode(" ", $data->registration_date);
					$registration_date_arr	= explode("-", $date_arr[0]);
					$registration_date		= $registration_date_arr[2]."-".$registration_date_arr[1]."-".$registration_date_arr[0];
					$category_array=$this->get_logo_category();
					
					
					echo '
						<tr id="' . $data->logo_id . '" class="' . $class_name . $drag_drop .  '" >
							<td class="noBorder alignCenter">' . $row_num . '</td>
							<td class="noBorder "> <a onclick="javascript: show_logo(\'' . $data->logo_id . '\', \'' . $i . '\');"  title="Click here to view details">' . functions::deformat_string($data->logo_name) . '</a></td>
							<td class="noBorder handCursor" onclick="javascript: show_logo(\'' . $data->logo_id . '\', \'' . $i . '\');"  title="Click here to view details">' . functions::deformat_string($category_array[$data->category_id]) . '</td>';
														
							echo '
							<td class="alignCenter">
								<a title="Click here to update status" class="handCursor" onclick="javascript: change_logo_status(\'' . $data->logo_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a>
							</td>
							
							<td class="alignCenter">';
						if($data->logo_id > 0 && $data->image_name !='')
						{
							echo '<a style="cursor:pointer;" onclick="popup_crop_image('.$data->logo_id.');"><img src="images/icon-portfolio.png" alt="Create Thumbnail" title="Create Thumbnail" width="15" height="16" /></a>';
						}
						else
						{
							echo '&nbsp;';
						}
						
						echo '</td>
							
							<td class="alignCenter">
								<a href="register_logo.php?logo_id=' . $data->logo_id . '" class="handCursor" ><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
							</td>
							<td class="alignCenter">
								<input type="checkbox" name="checkbox[' . $data->logo_id . ']" id="checkbox" />
							</td>
						<tr>
						<tr id="details' . $data->admin_id . '" class="expandRow">
							<td id="details_' . $i . '" colspan="11" height="1" ></td>
						</tr>';
					$row_type++;
				}
				
				if(empty($_REQUEST['page']))
				{
					$this->pager_start=1;
				}
				else
				{
					$this->pager_start=$_REQUEST['page'];
				}
				$param=join("&amp;",$param_array);
				if (count($param_array) > 0){
					$this->pager_param='search=Go&'.$param;
				}else{ 
					$this->pager_param=$param;
				}	
			}
			
			if($result->num_rows == 0)
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
						$urlQuery = 'manage_logo.php?page='.$currentPage;
					}
					else
					{
						$urlQuery = 'manage_logo.php?'.$this->pager_param1.'&page='.$currentPage;	
					}
					functions::redirect($urlQuery);
				}
				else
				{
					echo "<tr><td colspan='7' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
				}
			}
		}
		
		public static function get_logo_array($status = '', $order = '')
	{
		$database		= new database();
		$logo_array	= array();
		$sql			= "SELECT * FROM logo ";
		if($status != '')
		{
			$sql	.= " WHERE status = '".$status."' ";
		}
		else
		{
			$sql	.= " WHERE 1 ";
		}		
		if($order != '')
		{
			$sql	.= " ORDER BY " . $order;
		}
		else
		{
			$sql	.= " ORDER BY logo_name ASC ";
		}
		
		$result		= $database->query($sql);
		if ($result->num_rows > 0)
		{
			while($data=$result->fetch_assoc())
			{
				$logo_array[] = $data;
			}
		}
		return $logo_array;
	}
		
		public static function get_featured_list($logo_type_id, $count = 0)
		{
			$database	= new database();
			
			$sql		= "SELECT DISTINCT m.* FROM logo as m  INNER JOIN logo_album as ma ON m.logo_id = ma.logo_id WHERE m.logo_type_id = '". $logo_type_id. "' AND m.featured = 'Y' AND m.status = 'Y' ORDER BY m.registration_date DESC"; 
			
			if($count > 0)
			{
				$sql	.= " Limit 0, $count";
			}
			
			//print $sql;
			$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				echo '<ul class="thumbs noscript">';
				while($data = $result->fetch_object())
				{
					
					$logo_album_sql		= "SELECT * FROM logo_album WHERE logo_id = '" . $data->logo_id . "' ORDER BY added_date DESC Limit 0, 1";
					//print $logo_album_sql;
					$logo_album_result	= $database->query($logo_album_sql);
					if ($logo_album_result->num_rows > 0)
					{
						$logo_album_data = $logo_album_result->fetch_object();
					?>
<li> <a class="thumb" name="<?php echo $logo_type_id . '_' . $data->logo_id; ?>" href="<?php echo URI_MEMBER . $logo_album_data->image_name; ?>" title="<?php echo functions::format_text_field($logo_album_data->title); ?>"><img src="<?php echo URI_MEMBER . 'thumb_' . $logo_album_data->image_name; ?>" alt="<?php echo functions::format_text_field($logo_album_data->alt); ?>" width="78" height="78" /> </a> </li>
<?php
					}
				}
				echo '</ul>';
			}
		}
		
		public function get_image_list($logo_id, $featured = false, $count = 0)
		{
			$database	= new database();
			
			if($featured)
			{
				$sql		= "SELECT DISTINCT ma.* FROM logo as m  INNER JOIN logo_album as ma ON m.logo_id = ma.logo_id WHERE m.logo_id = '". $logo_id. "' AND m.featured = 'Y' AND m.status = 'Y' ORDER BY ma.added_date DESC"; 
			}
			else
			{
				$sql		= "SELECT DISTINCT ma.* FROM logo as m  INNER JOIN logo_album as ma ON m.logo_id = ma.logo_id WHERE m.logo_id = '". $logo_id. "' AND m.status = 'Y' ORDER BY ma.added_date DESC"; 
			}
			
			if($count > 0)
			{
				$sql	.= " Limit 0, $count";
			}
						
			//print $sql;
			$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				echo '<ul class="thumbs noscript">';
				while($data = $result->fetch_object())
				{
					?>
<li> <a class="thumb" name="<?php echo $data->logo_album_id; ?>" href="<?php echo URI_MEMBER . $data->image_name; ?>" title="<?php echo functions::format_text_field($data->title); ?>"><img src="<?php echo URI_MEMBER . 'thumb_' . $data->image_name; ?>" alt="<?php echo functions::format_text_field($data->alt); ?>" width="78" height="78" /> </a> </li>
<?php
				}
				echo '</ul>';
			}
		}
		
		
		public function get_logo_list($logo_type_id)
		{
			$database			= new database();
			$param_array		= array();
			$search_condition	= " WHERE logo_type_id = '" . $logo_type_id . "' AND status = 'Y'";
			$sql 				= "SELECT * FROM logo";
					
			$sql				.= $search_condition;
			$sql 				= $sql . " ORDER BY registration_date DESC";
			$result				= $database->query($sql);
			
			$this->num_rows = $result->num_rows;
			functions::paginateclient($this->num_rows, 0, 0, 'CLIENT');
			$start			= functions::$startfrom;
			$limit			= functions::$limits;
			$sql 			= $sql . " limit $start, $limit";
			//print $sql;
			$result			= $database->query($sql);
			
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			$news_array		= array();
			if ($result->num_rows > 0)
			{				
				$i 			= 0;
				$row_num	= functions::$startfrom;
				$page		= functions::$startfrom > 0 ? (functions::$startfrom / FRONT_PAGE_LIMIT) + 1 : 1;
				$param		= join("&amp;",$param_array); 
				$this->pager_param = $param;
				
				echo '<div id="fashionaires_content">
						<div id="gallery_content">';	
				while($data=$result->fetch_object())
				{
					$i++;					
					$logo_album_sql		= "SELECT * FROM logo_album WHERE logo_id = '" . $data->logo_id . "' ORDER BY added_date DESC Limit 0, 1";
					$logo_album_result	= $database->query($logo_album_sql);
					if ($logo_album_result->num_rows > 0)
					{
						$logo_album_data	= $logo_album_result->fetch_object();
						$url				= ($logo_type_id == 1 ? 'browse_models.php' : 'browse_photographer.php') . '?id=' . $data->logo_id . '&page=' . $page;
						?>
<div class="gallery_post_img"><a href="<?php echo $url; ?>"><img alt="" src="<?php echo URI_MEMBER . 'thumb_' .  $logo_album_data->image_name; ?>" border="0" /></a></div>
<?php
					}
				}
				
				echo '		</div>
						</div>';
			}
			else
			{
				echo "<div align='center' class='warningMesg'>Sorry.. No records found !!</div>";
			}
		}
		
		
		public function get_latest_logo_id($logo_type_id)
		{
			$logo_id	= 0;
			$database	= new database();
			
			$sql		= "SELECT logo_id FROM logo WHERE logo_type_id = '". $logo_type_id. "' AND status = 'Y' ORDER BY registration_date DESC ";
			$result		= $database->query($sql);
			
			$this->num_rows = $result->num_rows;
			functions::paginateclient($this->num_rows, 0, 0, 'CLIENT');
			$start			= functions::$startfrom;
			$limit			= functions::$limits;
			$sql 			= $sql . " limit $start, $limit";
			
			
			//print $sql;
			$result		= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data		= $result->fetch_object();
				$logo_id	= $data->logo_id;
			}
			return $logo_id;
		}
		
		public function get_profile_images($logo_id)
		{
			$database	= new database();
			
			$sql		= "SELECT logo_album_id,image_name FROM logo_album WHERE logo_id = '". $logo_id. "' ORDER BY logo_album_id DESC LIMIT 4";
			$result		= $database->query($sql);
			$i=0;
			while($data=$result->fetch_object()) 
			{
			    if(!file_exists(DIR_MEMBER . 'thumb_' . $data->image_name))
			    {
				   $functions	= new functions();
				   $functions->generate_thumb_image($data->image_name, DIR_MEMBER, MEMBER_THUMB_WIDTH, MEMBER_THUMB_HEIGHT);
			    }
			          //$thumb_image	= DIR_MEMBER . 'thumb_' . $data1->image_name; 
				echo '<li><a class="thumb" name="'.$data->logo_album_id.'" href="userfiles/logo/'.$data->image_name.'" title="Photo '.$i.'">
						  <img src="userfiles/logo/thumb_'.$data->image_name.'" alt="Photo '.$i.'" width="82" height="74" /></a></li>';
		     
			    $i++;
				//echo '<li><a class="thumb" name="'.$data->logo_album_id.'" href="userfiles/logo/'.$data->image_name.'" title="Photo '.$i.'">
						 // <img src="userfiles/logo/'.$data->image_name.'" alt="Photo '.$i.'" width="82" height="74" /></a></li>';
		    }				  
			
		}
		
		public function get_logo_details($gender='all')
		{
			$database	= new database();
			
			if($this->search_word != "") 
			{
				$param_array[]			= "search_word=" . htmlentities($this->search_word);
				$search_word_array		= explode(" ", $this->search_word);
				for($i = 0; $i < count($search_word_array); $i++)
				{
					$search_cond_array[]	= " (
			  					name like '%" . $database->real_escape_string($search_word_array[$i]) . "%' OR 
								logo_code like '%" . $database->real_escape_string($search_word_array[$i]) . "%' ) ";	
					
				}
			}	
			
			if(count($search_cond_array)>0) 
			{
				$search_condition	= " WHERE status='Y' AND " . join(" OR ", $search_cond_array); 
			}
			
						
			if($gender=='all')       $sql		= "SELECT logo_id,name,profile_details FROM logo WHERE status='Y' ORDER BY logo_id DESC";
			else if($gender=='search')  $sql    = "SELECT logo_id,name,profile_details FROM logo ".$search_condition." ORDER BY logo_id DESC";
			else if($gender=='men')  $sql       = "SELECT logo_id,name,profile_details FROM logo WHERE gender='Male' AND status='Y' ORDER BY logo_id DESC";
			else                     $sql       = "SELECT logo_id,name,profile_details FROM logo WHERE gender='Female' AND status='Y' ORDER BY logo_id DESC";
			$result		= $database->query($sql);
			$this->num_rows	= $result->num_rows;
			
			
			/*$param_array		= array();
		    $param_array[]		= "id=" . htmlentities($logo_id);
		    $param				= join("&amp;", $param_array); 
		    $this->pager_param	= $param; */
			
			$max_num_rows	= 2;
		    //, ($max_num_rows * $item_per_page)
			functions::paginateclient($this->num_rows, 0, 0, 'CLIENT');	
			$start			= functions::$startfrom;
  		    $limit			= functions::$limits;
			$sql			= $sql . " limit $start, $limit";
			$result		= $database->query($sql);
			$num_rows	= $result->num_rows;
			
			$i=0;
			if ($result->num_rows > 0)
		    {
			  while($data=$result->fetch_object()) 
			  {
			     $sql1		= "SELECT logo_album_id,image_name FROM logo_album WHERE logo_id='".$data->logo_id."' ORDER BY logo_album_id DESC LIMIT 1";
				 $result1		= $database->query($sql1);
				 $data1=$result1->fetch_object();
				 $num_rows1	= $result1->num_rows;
			     $i++;
 					 ?>
<div class="model_box">
  <div class="model_box_image">
    <?php 
				    if($num_rows1>0) { 
					   if($data1->image_name!='') 
		               {				
			             if(!file_exists(DIR_MEMBER . 'thumb_' . $data1->image_name))
			             {
					        $functions	= new functions();
					        $functions->generate_thumb_image($data1->image_name, DIR_MEMBER, MEMBER_THUMB_WIDTH, MEMBER_THUMB_HEIGHT);
			             }
			             //$thumb_image	= DIR_MEMBER . 'thumb_' . $data1->image_name; ?>
    <a href="profile.php?logo_id=<?php echo $data->logo_id ?>" ><img src="userfiles/logo/thumb_<?php echo $data1->image_name ?>"  /></a>
    <?php      } else { ?>
    <a href="profile.php?logo_id=<?php echo $data->logo_id ?>" ><img src="images/noimage.jpg" width="198" height="178" /></a>
    <?php      }
					
					?>
    <!--    <a href="profile.php?logo_id=<?php echo $data->
    logo_id ?>" ><img src="userfiles/logo/thumb_<?php echo $data1->image_name ?>"  /></a> <a href="profile.php?logo_id=<?php echo $data->logo_id ?>" ><img src="userfiles/logo/<?php echo $data1->image_name ?>" width="198" height="178" /></a> -->
    <?php }
				      else  { ?>
    <a href="profile.php?logo_id=<?php echo $data->logo_id ?>" ><img src="images/noimage.jpg" width="198" height="178" /></a>
    <?php  }  ?>
  </div>
  <div class="model_box_details">
    <h2>
      <?php  echo strtoupper(functions::deformat_string($data->name)) ?>
    </h2>
    <div class="model_box_details_content">
      <?php  echo functions::get_sub_string(functions::deformat_string($data->profile_details),145) ?>
      <a href="profile.php?logo_id=<?php echo $data->logo_id ?>" >read more</a></div>
    <br />
    <div class="vote_bttn"><a style="cursor:pointer;" onclick="vote('<?php echo $data->logo_id ?>');"><img src="images/vote.jpg" /></a></div>
  </div>
</div>
<?php 
				 
				    if($i%4!=0) echo '<div class="model_box_space"></div>'; 
   		        }
			      ?>
<?php	  
		   } 
		   else
		   {
			 echo "<br/><div align='center' class='warningMesg'>Sorry.. No records found !!</div>";
	   	   }
		}
		
		public function export_logo_list()
		{
$logo_list			= '';
			$database				= new database();
			
			$param_array				= array();
			$sql 						= "SELECT * FROM logo ";
			
			if ($this->search_word != "")
			{	
				
								
				if($this->search_word != "") 
				{
					$param_array[]			= "search_word=" . htmlentities($this->search_word);
					$search_word_array		= explode(" ", $this->search_word);
					for($i = 0; $i < count($search_word_array); $i++)
					{
						$search_cond_array[]	= " (												
												name like '%" . $database->real_escape_string($search_word_array[$i]) . "%' OR 
												logo_code like '%" . $database->real_escape_string($search_word_array[$i]) . "%' OR 
												category like '%" . $database->real_escape_string($search_word_array[$i]) . "%' OR 
												postcode like '%" . $database->real_escape_string($search_word_array[$i]) . "%' OR 
												email like '%" . $database->real_escape_string($search_word_array[$i]) . "%' 
												) ";
					}
				}
			}	
			
			if(count($search_cond_array)>0) 
			{
				$search_condition	= " WHERE " . join(" AND ", $search_cond_array); 
				$sql				.= $search_condition;
			}
			
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
				$sortField	= "name,logo_code,registration_date";
				$sortOrder	= "ASC";
				$sql		.= " ORDER BY ".$sortField." ".$sortOrder;
			}
			
			//echo $sql; exit;
			
			$result						= $database->query($sql);
			$this->num_rows				= $result->num_rows;
			if ($result->num_rows > 0)
			{
				$logo_list	.= functions::array_to_csvstring(array('Forename','Surname','Job Title','Bodyshop Name','Email','Telephone','Address','Address1', 'Address2','Postcode','How did you hear about us','Member Status','Joining Date'));
				while($data=$result->fetch_object())
				{					
					$reg_date			= date('d-m-Y', strtotime($data->registration_date));	
					$status				= $data->status == 'Y' ? 'Active' : 'Inactive';					
						
					$logo_list	.= functions::array_to_csvstring(
											array(
												
												functions::deformat_string($data->name),
												functions::deformat_string($data->logo_code),
												functions::deformat_string($data->title),
												functions::deformat_string($data->category),	
												functions::deformat_string($data->email),
												functions::deformat_string($data->phone),
												functions::deformat_string($data->address),
												functions::deformat_string($data->address1),
												functions::deformat_string($data->address2),												
												functions::deformat_string($data->postcode),
												functions::deformat_string($data->aboutus),
												functions::deformat_string($status),
												functions::deformat_string($reg_date)											
											)
										);
									
				}
			}
			
			//echo  $logo_list;
			
			return $logo_list;
		}
		
		// Remove the current object details.
	public function remove($category_id)
	{
		$database	= new database();
		/*if ( isset($this->_properties['testimonial_id']) && $this->_properties['testimonial_id'] > 0) 
		{*/
			$sql = "DELETE FROM logo WHERE category_id = '" . $category_id . "'";
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
		//}
	}
	
	public function getBaseCategory($category_id){
		$database			= new database();		
		$sql				= "SELECT * FROM category WHERE parent_id = '0' ORDER BY name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($category_id == $data->category_id)
					echo '<option value="'.$data->category_id.'" selected="selected">'.$data->name.'</option>';
				else
					echo '<option value="'.$data->category_id.'">'.$data->name.'</option>';	
					
				//to display sub acategories
				$sql				= "SELECT * FROM category WHERE parent_id = '".$data->category_id."' ORDER BY name ASC";
				$result1			= $database->query($sql);		
				if ($result1->num_rows > 0)
				{
					while($data1 = $result1->fetch_object())
					{
						if ($category_id == $data1->category_id)
							echo '<option value="'.$data1->category_id.'" style="padding-left:2em" selected="selected"> >> '.$data1->name.'</option>';
						else
							echo '<option value="'.$data1->category_id.'" style="padding-left:2em"> >> '.$data1->name.'</option>';	
						
						//to display sub acategories
						$sql				= "SELECT * FROM category WHERE parent_id = '".$data1->category_id."' ORDER BY name ASC";
						$result2			= $database->query($sql);		
						if ($result2->num_rows > 0)
						{
							while($data2 = $result2->fetch_object())
							{
								if ($category_id == $data2->category_id)
									echo '<option value="'.$data2->category_id.'" style="padding-left:4em" selected="selected"> >> '.$data2->name.'</option>';
								else
									echo '<option value="'.$data2->category_id.'" style="padding-left:4em"> >> '.$data2->name.'</option>';	
							}
						}
					
					}
				}		
			}
		}
		return;
	}
	
	public function getProductSubCategory($category_id,$parent_id){
		$database			= new database();
		if ($parent_id > 0){		
			$sql				= "SELECT * FROM category WHERE parent_id = '".$parent_id."' ORDER BY name ASC";
			$result				= $database->query($sql);		
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					if ($category_id == $data->category_id)
						echo '<option value="'.$data->category_id.'" selected="selected">'.$data->name.'</option>';
					else
						echo '<option value="'.$data->category_id.'">'.$data->name.'</option>';		
				}
			}
		}	
		return;
	}
	
	public function getProductSubCategoryChange($parent_id){
		$database			= new database();
		$msg = '<select id="category_id" name="category_id" class="dropdown" size="1" tabindex="4">
					<option value="" selected="selected">Select Sub Category</option>';
													
		if ($parent_id > 0){		
			$sql				= "SELECT * FROM category WHERE parent_id = '".$parent_id."' ORDER BY name ASC";
			$result				= $database->query($sql);
				
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					if ($category_id == $data->category_id)
						$msg .= '<option value="'.$data->category_id.'" selected="selected">'.$data->name.'</option>';
					else
						$msg .= '<option value="'.$data->category_id.'">'.$data->name.'</option>';		
				}
			}
		}
		$msg .= '</select>';
			
		return $msg;
	}
	
	public function getProductCategory($category_id){
		$database			= new database();		
		$sql				= "SELECT * FROM category WHERE parent_id > 0 ORDER BY name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($category_id == $data->category_id)
					echo '<option value="'.$data->category_id.'" selected="selected">'.$data->name.'</option>';
				else
					echo '<option value="'.$data->category_id.'">'.$data->name.'</option>';		
			}
		}
		return;
	}	
	
	public function getProductBrand($brand_id){
		$database			= new database();		
		$sql				= "SELECT * FROM brand WHERE 1 ORDER BY title ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($brand_id == $data->brand_id)
					echo '<option value="'.$data->brand_id.'" selected="selected">'.$data->title.'</option>';
				else
					echo '<option value="'.$data->brand_id.'">'.$data->title.'</option>';		
			}
		}
		return;
	}
	
	public function getSimilarProduct($logo_id){
		$database			= new database();
		$similar_array  	= array();
		$sql				= "SELECT * FROM similar_logo WHERE logo_id = '".$logo_id."'";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$similar_array[] = $data->related_logo_id;
			}
		}	
		//print_r($similar_array);
		//status = 'Y' AND		
		$sql				= "SELECT * FROM logo WHERE logo_id != '".$logo_id."' ORDER BY logo_name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if (in_array($data->logo_id, $similar_array))
					echo '<option value="'.$data->logo_id.'" selected="selected">'.$data->logo_name.'</option>';
				else
					echo '<option value="'.$data->logo_id.'">'.$data->logo_name.'</option>';		
			}
		}
		return;
	}
	
	public function getSimilarProductsName($logo_id){
		$database			= new database();
		$similar_array  	= array();
		$sql				= "SELECT s.*,p.logo_name FROM similar_logo s 
							   INNER JOIN logo p ON s.related_logo_id = p.logo_id 
							   WHERE s.logo_id = '".$logo_id."'";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$similar_array[] = $data->logo_name;
			}
		}
		
		return implode(",",$similar_array);
	
	}
	
	public function getProductVariantCount($logo_id){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT count(*) as cnt FROM logo_variant WHERE logo_id = '".$logo_id."' ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$data = $result->fetch_object();			
		}
		return $data->cnt; 
	}
	
	public function getHomeLatestProducts(){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT p.*, g.image_name FROM logo p
							   LEFT JOIN category c ON c.category_id = p.category_id 
							   LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id AND g.valid_image != 'N' AND g.default_image != 'N'
							   WHERE p.status = 'Y' AND c.status = 'Y' 
							   GROUP BY p.logo_id 
							   ORDER BY p.logo_id DESC LIMIT 0,4 ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '
			<div class="box">
      			<div>
        			<h1 class="title_module"><span>Latest Products</span></h1>
        			<div class="box-content">';
			
					while($data = $result->fetch_object())
					{
						//print_r ($data);
						if ($data->image_name != ''){
							$prod_img_path = DIR_FOOD_GALLERY.'thumb_'.$data->image_name;				
							if (!file_exists($prod_img_path)){					
								$functions->autoResizeImageNotCropped(DIR_FOOD_GALLERY,$data->image_name,'thumb_',FOOD_GALLERY_THUMB_WIDTH,FOOD_GALLERY_THUMB_HEIGHT);																		
							}
							$img_path = URI_FOOD_GALLERY.'thumb_'.$data->image_name;
						}else{
							$img_path = URI_FOOD_GALLERY.'no_image.jpg';
						}
						if ($data->disc_price > 0){
							$sale_banner = '<span class="new">Sale</span>';							
						}else{
							$sale_banner = '';							
						}												     
					  	echo '<div class="box-logo last-item"> 
									<a class="image" href="logo.php?pid='.$data->logo_id.'" title="View more">
										<img src="'.$img_path.'" height="179" alt="">
										'.$sale_banner.'	 
									</a>
									<h3 class="name"><a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($data->logo_name).'</a></h3>
									<p class="wrap_price">';									
						
						if ($data->disc_price > 0)		
							echo 	'<span class="price-old">'.CURRENCY_SYMBOL.number_format($data->show_price,'2','.',',').'</span><span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
						else
							echo    '<span class="price">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
															
						echo		'</p>
									<p class="submit">';
									
									if ($this->getProductVariantCount($data->logo_id) > 0){			
										echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: show_variant(\''.$data->logo_id.'\')">';
									}else{
										echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\'1\',\''.$data->logo_id.'\',\'\',\'\',\'\')">';
									}
									
						echo		'</p>
							   </div>';
        
					}
					
			echo '</div>
      			</div>
    		  </div>';			
		}
		
		return;
	
	}
	
	public function getHomeSpecialProducts(){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT p.*, g.image_name FROM logo p
							   LEFT JOIN category c ON c.category_id = p.category_id 
							   LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id AND g.valid_image != 'N' AND g.default_image != 'N'
							   WHERE p.special_logo = 'Y' AND p.status = 'Y' AND c.status = 'Y' 
							   GROUP BY p.logo_id 
							   ORDER BY p.logo_id DESC LIMIT 0,4 ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '
			<div class="box">
      			<div>
        			<h1 class="title_module"><span>Special Products</span></h1>
        			<div class="box-content">';
			
					while($data = $result->fetch_object())
					{
						if ($data->image_name != ''){
							$prod_img_path = DIR_FOOD_GALLERY.'thumb_'.$data->image_name;				
							if (!file_exists($prod_img_path)){
								$functions->autoResizeImageNotCropped(DIR_FOOD_GALLERY,$data->image_name,'thumb_',FOOD_GALLERY_THUMB_WIDTH,FOOD_GALLERY_THUMB_HEIGHT);														
							}
							$img_path = URI_FOOD_GALLERY.'thumb_'.$data->image_name;
						}else{
							$img_path = URI_FOOD_GALLERY.'no_image.jpg';
						}
						if ($data->disc_price > 0){
							$sale_banner = '<span class="new">Sale</span>';							
						}else{
							$sale_banner = '';							
						}					     
					  	echo '<div class="box-logo last-item"> 
									<a class="image" href="logo.php?pid='.$data->logo_id.'" title="View more">
										<img src="'.$img_path.'" height="179" alt="">
										'.$sale_banner.' 
									</a>
									<h3 class="name"><a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($data->logo_name).'</a></h3>
									<p class="wrap_price">';									
						
						if ($data->disc_price > 0)		
							echo 	'<span class="price-old">'.CURRENCY_SYMBOL.number_format($data->show_price,'2','.',',').'</span><span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
						else
							echo    '<span class="price">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
															
						echo		'</p>
									<p class="submit">';
									
									if ($this->getProductVariantCount($data->logo_id) > 0){			
										echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: show_variant(\''.$data->logo_id.'\')">';
									}else{
										echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\'1\',\''.$data->logo_id.'\',\'\',\'\',\'\')">';
									}
									
						echo	'</p>
							   </div>';
        
					}
					
			echo '</div>
      			</div>
    		  </div>';			
		}
		
		return;
	
	}
	
	public function getHomeFeaturedProducts(){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT p.*, g.image_name FROM logo p 
							   LEFT JOIN category c ON c.category_id = p.category_id
							   LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id  AND g.valid_image != 'N' AND g.default_image != 'N'
							   WHERE p.featured_logo = 'Y' AND p.status = 'Y' AND c.status = 'Y'
							   GROUP BY p.logo_id 
							   ORDER BY p.logo_id DESC LIMIT 0,4 ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '
			<div class="box">
      			<div>
        			<h1 class="title_module"><span>Featured Products</span></h1>
        			<div class="box-content">';
			
					while($data = $result->fetch_object())
					{
						if ($data->image_name != ''){
							$prod_img_path = DIR_FOOD_GALLERY.'thumb_'.$data->image_name;				
							if (!file_exists($prod_img_path)){					
								$functions->autoResizeImageNotCropped(DIR_FOOD_GALLERY,$data->image_name,'thumb_',FOOD_GALLERY_THUMB_WIDTH,FOOD_GALLERY_THUMB_HEIGHT);													
							}
							$img_path = URI_FOOD_GALLERY.'thumb_'.$data->image_name;
						}else{
							$img_path = URI_FOOD_GALLERY.'no_image.jpg';
						}	
						if ($data->disc_price > 0){
							$sale_banner = '<span class="new">Sale</span>';							
						}else{
							$sale_banner = '';							
						}				     
					  	echo '<div class="box-logo last-item"> 
									<a class="image" href="logo.php?pid='.$data->logo_id.'" title="View more">
										<img src="'.$img_path.'" height="179" alt="">
										'.$sale_banner.' 
									</a>
									<h3 class="name"><a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($data->logo_name).'</a></h3>
									<p class="wrap_price">';									
						
						if ($data->disc_price > 0)		
							echo 	'<span class="price-old">'.CURRENCY_SYMBOL.number_format($data->show_price,'2','.',',').'</span><span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
						else
							echo    '<span class="price">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
															
						echo		'</p>
									<p class="submit">';
									
									if ($this->getProductVariantCount($data->logo_id) > 0){			
										echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: show_variant(\''.$data->logo_id.'\')">';
									}else{
										echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\'1\',\''.$data->logo_id.'\',\'\',\'\',\'\')">';
									}	
								
						echo	'</p>
							 </div>';
        
					}
					
			echo '</div>
      			</div>
    		  </div>';			
		}
		
		return;
	
	}
	
	function getHomeBrandCarrousel(){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT * FROM brand WHERE status = 'Y' ORDER BY rand() ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '<div id="carousel">
      				<ul class="jcarousel-skin-tfc">';
			
					while($data = $result->fetch_object())
					{
					  	$file_img_path = DIR_BRAND.'thumb_'.$data->image_name;				
						if ($data->image_name != '' and file_exists($file_img_path)){					
							$img_path = URI_BRAND.'thumb_'.$data->image_name;				
						}else{										
							$functions->autoResizeImageNotCropped(DIR_BRAND,$data->image_name,'thumb_',BRAND_MIN_WIDTH,BRAND_MIN_HEIGHT);						
							$img_path = URI_BRAND.'thumb_'.$data->image_name;
						}											     
					  	echo '<li><a href="category.php?bid='.$data->brand_id.'"><img src="'.$img_path.'" width="80" height="80" alt="" title="'.functions::deformat_string($data->title).'"></a></li>';
        
					}
					
			echo ' </ul>
    			</div>';			
		}
		
		return;
	}
	
	public function displaySimilarProducts($logo_id){
		$database			= new database();
		$functions 			= new functions();								   
		$sql				= "SELECT p.*, g.image_name FROM similar_logo s 
							   LEFT JOIN logo p ON s.related_logo_id = p.logo_id
							   LEFT JOIN category c ON c.category_id = p.category_id  
							   LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id AND g.valid_image != 'N' AND g.default_image != 'N'							    
		                       WHERE s.logo_id = '".$logo_id."' AND p.status = 'Y' AND c.status = 'Y'
							   GROUP BY p.logo_id
							   ORDER BY p.logo_id DESC ";
							   					   							   
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '
			<div class="box">
      			<div>
        			<h1 class="title_module"><span>Similar Products</span></h1>
        			<div class="box-content">';
					$rec_count = '1';
					while($data = $result->fetch_object())
					{
						if ($result->num_rows == $rec_count)
							$class_main_last = ' last-item';
						else
							$class_main_last = '';
							
						if ($data->image_name != ''){	
							$prod_img_path = DIR_FOOD_GALLERY.'thumbnail/'.$data->image_name;				
							if (!file_exists($prod_img_path)){													
								$thumb_img_path = DIR_FOOD_GALLERY . 'thumb_' . $data->image_name;
								if (file_exists($thumb_img_path)){
									$functions->autoResizeImageNotCroppedThumbnail(DIR_FOOD_GALLERY,$data->image_name,'thumbnail/',FOOD_GALLERY_ICON_WIDTH,FOOD_GALLERY_ICON_HEIGHT);
								}else{
									$functions->autoResizeImageNotCropped(DIR_FOOD_GALLERY,$data->image_name,'thumb_',FOOD_GALLERY_THUMB_WIDTH,FOOD_GALLERY_THUMB_HEIGHT);					
									$functions->autoResizeImageNotCroppedThumbnail(DIR_FOOD_GALLERY,$data->image_name,'thumbnail/',FOOD_GALLERY_ICON_WIDTH,FOOD_GALLERY_ICON_HEIGHT);									
								}															
							}
							$img_path = URI_FOOD_GALLERY.'thumbnail/'.$data->image_name;				     					  	
						}else{
							$img_path = URI_FOOD_GALLERY.'no_image_small.jpg';
						}
						
						$logo_name = (strlen($data->logo_name) > 40) ? substr($data->logo_name,0,40).'..' : $data->logo_name; 
							   
						echo '<div class="box-logo '.$class_main_last.'"> 
								<a class="image" href="logo.php?pid='.$data->logo_id.'" title="View more"> 
									<img src="'.$img_path.'" width="55" alt=""> 
								</a>
            					<h3 class="name"><a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($logo_name).'</a></h3>
            					<p class="wrap_price">';
								
						if ($data->disc_price > 0)		
							echo 	'<span class="price-old">'.CURRENCY_SYMBOL.number_format($data->show_price,'2','.',',').'</span><span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
						else
							echo    '<span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
								
						echo	'</p>
            					<p class="submit">';
								
						if ($this->getProductVariantCount($data->logo_id) > 0){			
              				echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\''.$data->logo_id.'\',\'\')">';
            			}else{
							echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\'1\',\''.$data->logo_id.'\',\'\',\'\',\'\')">';            			
						}
						
						echo	'</p>
          					</div>';
								   
        				$rec_count++;
					}
					
			echo '</div>
      			</div>
    		  </div>';			
		}
		
		return;
	
	}
	
	public function displayLeftFeaturedProducts(){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT p.*, g.image_name FROM logo p
						       LEFT JOIN category c ON c.category_id = p.category_id 
							   LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id AND g.valid_image != 'N' AND g.default_image != 'N'
							   WHERE p.featured_logo = 'Y' AND p.status = 'Y' AND c.status = 'Y'  
							   GROUP BY p.logo_id 
							   ORDER BY p.logo_id DESC LIMIT 0,5 ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '
			<div class="box">
      			<div>
        			<h1 class="title_module"><span>Featured</span></h1>
        			<div class="box-content">';
					$rec_count = '1';
					while($data = $result->fetch_object())
					{
						if ($result->num_rows == $rec_count)
							$class_main_last = ' last-item';
						else
							$class_main_last = '';
							
						if ($data->image_name != ''){	
							$prod_img_path = DIR_FOOD_GALLERY.'thumbnail/'.$data->image_name;				
							if (!file_exists($prod_img_path)){													
								$thumb_img_path = DIR_FOOD_GALLERY . 'thumb_' . $data->image_name;
								if (file_exists($thumb_img_path)){
									$functions->autoResizeImageNotCroppedThumbnail(DIR_FOOD_GALLERY,$data->image_name,'thumbnail/',FOOD_GALLERY_ICON_WIDTH,FOOD_GALLERY_ICON_HEIGHT);
								}else{
									$functions->autoResizeImageNotCropped(DIR_FOOD_GALLERY,$data->image_name,'thumb_',FOOD_GALLERY_THUMB_WIDTH,FOOD_GALLERY_THUMB_HEIGHT);					
									$functions->autoResizeImageNotCroppedThumbnail(DIR_FOOD_GALLERY,$data->image_name,'thumbnail/',FOOD_GALLERY_ICON_WIDTH,FOOD_GALLERY_ICON_HEIGHT);									
								}															
							}
							$img_path = URI_FOOD_GALLERY.'thumbnail/'.$data->image_name;				     					  	
						}else{
							$img_path = URI_FOOD_GALLERY.'no_image_small.jpg';
						}
						
						$logo_name = (strlen($data->logo_name) > 40) ? substr($data->logo_name,0,40).'..' : $data->logo_name; 
							   
						echo '<div class="box-logo '.$class_main_last.'"> 
								<a class="image" href="logo.php?pid='.$data->logo_id.'" title="View more"> 
									<img src="'.$img_path.'" width="55" alt=""> 
								</a>
            					<h3 class="name"><a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($logo_name).'</a></h3>
            					<p class="wrap_price">';
								
						if ($data->disc_price > 0)		
							echo 	'<span class="price-old">'.CURRENCY_SYMBOL.number_format($data->show_price,'2','.',',').'</span><span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
						else
							echo    '<span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
								
						echo	'</p>
            					<p class="submit">';
								
						if ($this->getProductVariantCount($data->logo_id) > 0){			
              				echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\''.$data->logo_id.'\',\'\')">';
            			}else{
							echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\'1\',\''.$data->logo_id.'\',\'\',\'\',\'\')">';            			
						}
						
						echo	'</p>
          					</div>';
								   
        				$rec_count++;
					}
					
			echo '</div>
      			</div>
    		  </div>';			
		}
		
		return;
	
	}	
	
	public function displayLeftSpecialProducts(){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT p.*, g.image_name FROM logo p
							   LEFT JOIN category c ON c.category_id = p.category_id 
							   LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id AND g.valid_image != 'N' AND g.default_image != 'N'
							   WHERE p.special_logo = 'Y' AND p.status = 'Y' AND c.status = 'Y'  
							   GROUP BY p.logo_id 
							   ORDER BY p.logo_id DESC LIMIT 0,5 ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '
			<div class="box">
      			<div>
        			<h1 class="title_module"><span>Specials</span></h1>
        			<div class="box-content">';
					$rec_count = '1';
					while($data = $result->fetch_object())
					{
						if ($result->num_rows == $rec_count)
							$class_main_last = ' last-item';
						else
							$class_main_last = '';
						if ($data->image_name != ''){	
							$prod_img_path = DIR_FOOD_GALLERY.'thumbnail/'.$data->image_name;				
							if (!file_exists($prod_img_path)){													
								$thumb_img_path = DIR_FOOD_GALLERY . 'thumb_' . $data->image_name;
								if (file_exists($thumb_img_path)){
									$functions->autoResizeImageNotCroppedThumbnail(DIR_FOOD_GALLERY,$data->image_name,'thumbnail/',FOOD_GALLERY_ICON_WIDTH,FOOD_GALLERY_ICON_HEIGHT);
								}else{
									$functions->autoResizeImageNotCropped(DIR_FOOD_GALLERY,$data->image_name,'thumb_',FOOD_GALLERY_THUMB_WIDTH,FOOD_GALLERY_THUMB_HEIGHT);					
									$functions->autoResizeImageNotCroppedThumbnail(DIR_FOOD_GALLERY,$data->image_name,'thumbnail/',FOOD_GALLERY_ICON_WIDTH,FOOD_GALLERY_ICON_HEIGHT);									
								}															
							}
							$img_path = URI_FOOD_GALLERY.'thumbnail/'.$data->image_name;				     					  	
						}else{
							$img_path = URI_FOOD_GALLERY.'no_image_small.jpg';
						}
						$logo_name = (strlen($data->logo_name) > 40) ? substr($data->logo_name,0,40).'..' : $data->logo_name; 
							   
						echo '<div class="box-logo '.$class_main_last.'"> 
								<a class="image" href="logo.php?pid='.$data->logo_id.'" title="View more"> 
									<img src="'.$img_path.'" width="55" alt=""> 
								</a>
            					<h3 class="name"><a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($logo_name).'</a></h3>
            					<p class="wrap_price">';
						if ($data->disc_price > 0)		
							echo 	'<span class="price-old">'.CURRENCY_SYMBOL.number_format($data->show_price,'2','.',',').'</span><span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
						else
							echo    '<span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
								
						echo	'</p>
            					<p class="submit">';
								
						if ($this->getProductVariantCount($data->logo_id) > 0){			
              				echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\''.$data->logo_id.'\',\'\')">';
            			}else{
							echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\'1\',\''.$data->logo_id.'\',\'\',\'\',\'\')">';            			
						}
						
						echo	'</p>
          					</div>';
								   
        				$rec_count++;
					}
					
			echo '</div>
      			</div>
    		  </div>';			
		}
		
		return;
	
	}
	
	public function displayLeftLatestProducts(){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT p.*, g.image_name FROM logo p 
		                       LEFT JOIN category c ON c.category_id = p.category_id
							   LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id AND g.valid_image != 'N' AND g.default_image != 'N' 
							   WHERE p.status = 'Y' AND c.status = 'Y'  
							   GROUP BY p.logo_id 
							   ORDER BY p.logo_id DESC LIMIT 0,5 ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '
			<div class="box">
      			<div>
        			<h1 class="title_module"><span>Latest</span></h1>
        			<div class="box-content">';
					$rec_count = '1';
					while($data = $result->fetch_object())
					{
						if ($result->num_rows == $rec_count)
							$class_main_last = ' last-item';
						else
							$class_main_last = '';
						if ($data->image_name != ''){	
							$prod_img_path = DIR_FOOD_GALLERY.'thumbnail/'.$data->image_name;				
							if (!file_exists($prod_img_path)){													
								$thumb_img_path = DIR_FOOD_GALLERY . 'thumb_' . $data->image_name;
								if (file_exists($thumb_img_path)){
									$functions->autoResizeImageNotCroppedThumbnail(DIR_FOOD_GALLERY,$data->image_name,'thumbnail/',FOOD_GALLERY_ICON_WIDTH,FOOD_GALLERY_ICON_HEIGHT);
								}else{
									$functions->autoResizeImageNotCropped(DIR_FOOD_GALLERY,$data->image_name,'thumb_',FOOD_GALLERY_THUMB_WIDTH,FOOD_GALLERY_THUMB_HEIGHT);					
									$functions->autoResizeImageNotCroppedThumbnail(DIR_FOOD_GALLERY,$data->image_name,'thumbnail/',FOOD_GALLERY_ICON_WIDTH,FOOD_GALLERY_ICON_HEIGHT);									
								}															
							}
							$img_path = URI_FOOD_GALLERY.'thumbnail/'.$data->image_name;				     					  	
						}else{
							$img_path = URI_FOOD_GALLERY.'no_image_small.jpg';
						}
						$logo_name = (strlen($data->logo_name) > 40) ? substr($data->logo_name,0,40).'..' : $data->logo_name; 
							   
						echo '<div class="box-logo '.$class_main_last.'"> 
								<a class="image" href="logo.php?pid='.$data->logo_id.'" title="View more"> 
									<img src="'.$img_path.'" width="55" alt=""> 
								</a>
            					<h3 class="name"><a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($logo_name).'</a></h3>
            					<p class="wrap_price">';
						if ($data->disc_price > 0)		
							echo 	'<span class="price-old">'.CURRENCY_SYMBOL.number_format($data->show_price,'2','.',',').'</span><span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
						else
							echo    '<span class="price-new">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</span>';
								
						echo	'</p>
            					<p class="submit">';
								
						if ($this->getProductVariantCount($data->logo_id) > 0){			
              				echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\''.$data->logo_id.'\',\'\')">';
            			}else{
							echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\'1\',\''.$data->logo_id.'\',\'\',\'\',\'\')">';            			
						}
						
						echo	'</p>
          					</div>';
								   
        				$rec_count++;
					}
					
			echo '</div>
      			</div>
    		  </div>';			
		}
		
		return;
	
	}
	
	//to display logos on category
	
	/*public function display_category_logos()
	{
		$database					= new database();
		$validation					= new validation(); 
		$param_array				= array();
		$sql 						= "SELECT * FROM logo p 
							   		   LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id 
							           WHERE p.category_id = '" . $this->cid . "' AND p.featured_logo = 'Y' AND p.status = 'Y' AND g.status = 'Y'";
		
		if ($this->cid > 0)		
		{				
			$param_array[]			= "cid=" . $this->cid;
			$search_cond_array[]	= "p.category_id = '" . $this->cid . "'";			
		}	
		//print_r ($param_array);
		
		if(count($search_cond_array)>0) 
		{
			$search_condition	= " AND " . join(" AND ", $search_cond_array); 
			$sql				.= $search_condition;
		}
		
		//print $sql;
		
		if(isset($_REQUEST['sort']))
		{
			$sortField		= $_REQUEST['sort'];
			$sortOrder		= $_REQUEST['odr'];
			$sql		   .= " GROUP BY p.logo_id ORDER BY ".$sortField." ".$sortOrder;
				
			$param_array[]	= "sort=".$_REQUEST['sort'];	
			$param_array[]	= "odr=".$_REQUEST['odr'];			
		}
		else
		{
			$sortField	= "p.logo_id";
			$sortOrder	= "DESC";
			$sql	   .= " GROUP BY p.logo_id ORDER BY ".$sortField." ".$sortOrder;
		}
		
		echo $sql;
		
		$result				= $database->query($sql);
		$this->num_rows		= $result->num_rows;
		$param				= join("&amp;",$param_array); 
		$this->pager_param	= $param;
		functions::paginate($this->num_rows);
		$start	= functions::$startfrom;
		echo 'limits'.$limit	= '2'; //functions::$limits;
		
		$sql	= $sql . " limit $start, $limit";
		$result	= $database->query($sql);
		if ($result->num_rows > 0)
		{				
			$i			= 0;
			$row_num	= functions::$startfrom;
			echo '';
			
			while($data=$result->fetch_object())
			{
				$i++;
				$row_num++;
				
				if ($result->num_rows == $rec_count)
					$class_main_last = ' last-item"';
				else
					$class_main_last = '';
					
				$prod_img_path = DIR_FOOD_GALLERY.'thumb_'.$data->image_name;				
				if ($data->image_name != '' and file_exists($prod_img_path)){					
					$img_path = URI_FOOD_GALLERY.'thumb_'.$data->image_name;				
				}
								
				echo '
				<div class="box-logo '.$class_main_last.'">
					<a class="image" href="logo.php?pid='.$data->logo_id.'" title="View more"> 
						<img src="'.$img_path.'" width="184" alt="">
					</a>
					<div class="list_grid_right">
					  <h3 class="name">
					  	<a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($data->logo_name).'</a>
					  </h3>
					  <p class="wrap_price">';
					  
				if ($data->show_price > 0)	   
					echo 	'<span class="price-old">'.CURRENCY_SYMBOL.$data->show_price.' </span>
							 <span class="price">'.CURRENCY_SYMBOL.$data->price.'</span>';
				else
					echo 	'<span class="price">'.CURRENCY_SYMBOL.$data->price.'</span>';				
						 
				echo  '</p>
					  <p class="description">'.functions::deformat_string($data->logo_description).'</p>
					  <p class="submit">
						<input type="button" value="Add to Cart" class="button">
					  </p>					  
					</div>
				</div>';
					
				$row_type++;
			}
			
			if(empty($_REQUEST['page']))
			{
				$this->pager_start=1;
			}
			else
			{
				$this->pager_start=$_REQUEST['page'];
			}
			$param=join("&amp;",$param_array);
			if (count($param_array) > 0){
				$this->pager_param='search=Go&'.$param;
			}else{ 
				$this->pager_param=$param;
			}	
		}
		
		if($result->num_rows == 0)
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
					$urlQuery = 'category.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'category.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='7' align='center'><div align='center' class='warningMesg'>Sorry.. No logos found !!</div></td></tr>";
			}
		}
	}*/
	
	public function display_category_logos()

	{

		$database				= new database();

		$param_array			= array();

		$sql 					= "SELECT p.*, g.image_name FROM logo p 
								   LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id AND g.valid_image != 'N' AND g.default_image != 'N' 
								   WHERE p.status = 'Y' ";
	
		$search_condition		= '';
		
		if($this->cid > 0)		

		{
			$category	= new category($this->cid);
			
			if ($category->parent_id > 0){
			
				$param_array[] 			= "cid=" . $this->cid;

				$search_cond_array[]	= " p.category_id = '" . $this->cid . "' ";
				
			}else{
			
				$strIds = $category->getSubCategoryIdList($this->cid);
				
				$param_array[] 			= "cid=" . $this->cid;

				$search_cond_array[]	= " p.category_id IN (" . $strIds . ") ";
					
			}						   

		}
		
		if($this->bid > 0)		

		{

			$param_array[] 			= "bid=" . $this->bid;

			$search_cond_array[]	= " p.brand_id = '" . $this->bid . "' ";					   

		}
		
		if($this->keyword != '')		

		{

			$param_array[] 			= "keyword=" . $this->keyword;

			$search_cond_array[]	= " (p.logo_name LIKE '%" . $this->keyword . "%' OR p.logo_code LIKE '%" . $this->keyword . "%' OR p.logo_description LIKE '%" . $this->keyword . "%') ";					   

		}
		
		if($this->new_logo == '1')		

		{

			$param_array[] 			= "new_logo=1";

			//$search_cond_array[]	= " p.category_id = '" . $this->cid . "' ";					   

		}
		
		if($this->all_logo == '1')		

		{

			$param_array[] 			= "all_logo=1";

			//$search_cond_array[]	= " p.category_id = '" . $this->cid . "' ";					   

		}	
		
				
		if($_REQUEST['sort'] != '')		

		{

			$param_array[] 			= "sort=" . $_REQUEST['sort'];

			//$search_cond_array[]	= " p.category_id = '" . $this->cid . "' ";					   

		}	
		
		if($_REQUEST['page_limit'] != '')		

		{

			$param_array[] 			= "page_limit=" . $_REQUEST['page_limit'];

			//$search_cond_array[]	= " p.category_id = '" . $this->cid . "' ";					   

		}	

		

		if(count($search_cond_array)>0) 

		{ 

			//$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
			$search_condition	=  " AND " . join(" AND ",$search_cond_array); 

		}

				

		$sql			.= $search_condition;

		//$sql 			= $sql . " ORDER BY c.counsellor_name  ";
		
		if($_REQUEST['sort'] > 0)
		{
			$sortField		= $_REQUEST['sort'];
			//$sortOrder		= $_REQUEST['odr'];
			switch ($sortField){
				case '1' :						
					$sql		   .= " GROUP BY p.logo_id ORDER BY p.logo_name ASC ";
					break;
				case '2' :						
					$sql		   .= " GROUP BY p.logo_id ORDER BY p.logo_name DESC ";
					break;
				case '3' :						
					$sql		   .= " GROUP BY p.logo_id ORDER BY p.price ASC ";
					break;
				case '4' :						
					$sql		   .= " GROUP BY p.logo_id ORDER BY p.price DESC ";
					break;			
				default :						
					$sql		   .= " GROUP BY p.logo_id ORDER BY ".$sortField." ".$sortOrder;
					break;	
			}		
				
			//$param_array[]	= "sort=".$_REQUEST['sort'];	
			//$param_array[]	= "odr=".$_REQUEST['odr'];			
		}
		else
		{
			$sortField	= "p.logo_id";
			$sortOrder	= "DESC";
			$sql	   .= " GROUP BY p.logo_id ORDER BY ".$sortField." ".$sortOrder;
		}
		
		//echo $sql;

		$result			= $database->query($sql);

		$this->num_rows = $result->num_rows;

		//functions::paginate($this->num_rows);

		functions::paginate_listing($this->num_rows, 0, 0, 'CLIENT');

		$start			= functions::$startfrom;

		if ($_REQUEST['page_limit'] > 0){
			$limit		= $_REQUEST['page_limit'];
		}else{
			$limit		= functions::$limits;
		}
		
		$sql 			= $sql . " limit $start, $limit";

		//echo  ($sql);

		$result			= $database->query($sql);
		

		$param=join("&amp;",$param_array); 

		$this->pager_param=$param;

		
		$blog_array		= array();
		$functions 		= new functions();

		if ($result->num_rows > 0)

		{				

			$i 			= 0;
			
			$rec_count  = '1';

			$row_num	= functions::$startfrom;

			$page		= functions::$startfrom > 0 ? (functions::$startfrom / FRONT_PAGE_LIMIT) + 1 : 1;						

			while($data=$result->fetch_object())

			{
				if ($rec_count%3 == '1' and $rec_count != '1')
					$class_main_last = 'last-item row-first';
				else
					$class_main_last = '';
				if ($data->image_name != ''){	
					$prod_img_path = DIR_FOOD_GALLERY.'thumb_'.$data->image_name;				
					if ($data->image_name != '' and file_exists($prod_img_path)){					
						$img_path = URI_FOOD_GALLERY.'thumb_'.$data->image_name;				
					}else{
						//$functions->generate_thumb_image($data->image_name, DIR_FOOD_GALLERY, FOOD_GALLERY_THUMB_WIDTH, FOOD_GALLERY_THUMB_HEIGHT);
						$functions->autoResizeImageNotCropped(DIR_FOOD_GALLERY,$data->image_name,'thumb_',FOOD_GALLERY_THUMB_WIDTH,FOOD_GALLERY_THUMB_HEIGHT);						
						$img_path = URI_FOOD_GALLERY.'thumb_'.$data->image_name;	
					}
				}else{
					$img_path = URI_FOOD_GALLERY.'no_image.jpg';
				}
				
				if ($data->disc_price > 0){
					$sale_banner1 = '<span class="new">Sale</span>';
					$sale_banner2 = '<span class="new2">Sale</span>';					
				}else{
					$sale_banner1 = '';	
					$sale_banner2 = '';					
				}				
				echo '
				<div class="box-logo '.$class_main_last.'">
					'.$sale_banner1.'			
					<a class="image" href="logo.php?pid='.$data->logo_id.'" title="View more">						 
						<img src="'.$img_path.'" width="184" alt="">
						'.$sale_banner2.'
					</a>					
					<div class="list_grid_right">
					  <h3 class="name">
					  	<a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($data->logo_name).'</a>
					  </h3>
					  <p class="wrap_price">';
					  
				if ($data->disc_price > 0)	   
					echo 	'<span class="price-old">'.CURRENCY_SYMBOL.$data->show_price.' </span>
							 <span class="price-new">'.CURRENCY_SYMBOL.$data->price.'</span>';
				else
					echo 	'<span class="price-new">'.CURRENCY_SYMBOL.$data->price.'</span>';				
						 
				echo  '</p>
					  <p class="description">'.functions::deformat_string($data->logo_description).'</p>
					  <p class="submit">';
								
				if ($this->getProductVariantCount($data->logo_id) > 0){							
					echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: show_variant(\''.$data->logo_id.'\')">';
				}else{
					echo '<input type="button" value="Add to Cart" class="button" onclick="javascript: addto_cart(\'1\',\''.$data->logo_id.'\',\'\',\'\',\'\')">';
				}	  
										
				echo  '</p>					  
					</div>
				</div>';
					
				$rec_count++;					
				
							
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

					$urlQuery = 'category.php?page='.$currentPage;

				}

				else

				{

					$urlQuery = 'category.php?'.$this->pager_param1.'&page='.$currentPage;	

				}

				functions::redirect($urlQuery);

			}

			else

			{

				echo "<div align='center' class='warningMesg'>Sorry.. No logos found !!</div>";

			}

		}

	}
	
	public function getProductDefaultImage($pid){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT * FROM logo_gallery WHERE logo_id = '".$pid."' 
							   AND status = 'Y' AND default_image = 'Y' AND valid_image = 'Y' 							  
							   ORDER BY logo_id DESC LIMIT 0,1 ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$data = $result->fetch_object();
		}
		return $data->image_name;	
	}
	
	public function getProductAllImage($pid){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT * FROM logo_gallery WHERE logo_id = '".$pid."' 
							   AND status = 'Y' AND valid_image = 'Y' 							  
							   ORDER BY order_id DESC ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '
			<div class="image-additional">
         		<div id="carousel-p">
        			<ul class="jcarousel-skin-tfc">';
					
					while ($data = $result->fetch_object()){
						
						$img_name = $data->image_name;
						if ($img_name != ''){ 
							$prod_img_path = DIR_FOOD_GALLERY.'thumb_'.$img_name;				
							if (!file_exists($prod_img_path)){ 																		
								$functions->autoResizeImageNotCropped(DIR_FOOD_GALLERY,$img_name,'thumb_',FOOD_GALLERY_THUMB_WIDTH,FOOD_GALLERY_THUMB_HEIGHT);								
							}
							$big_img_path   = URI_FOOD_GALLERY.'thumb_'.$img_name;
							$large_img_path = URI_FOOD_GALLERY.$img_name;
							
							$thumb_img_path = DIR_FOOD_GALLERY.'thumbnail/'.$img_name;
							if (!file_exists($thumb_img_path)){
								$functions->autoResizeImageNotCroppedThumbnail(DIR_FOOD_GALLERY,$img_name,'thumbnail/',FOOD_GALLERY_ICON_WIDTH,FOOD_GALLERY_ICON_HEIGHT);
							}
							$small_img_path = URI_FOOD_GALLERY.'thumbnail/'.$img_name;
						}else{
							$small_img_path = URI_FOOD_GALLERY.'no_image_small.jpg';					
							$big_img_path   = URI_FOOD_GALLERY.'no_image.jpg';
							$large_img_path = URI_FOOD_GALLERY.'no_image.jpg';	
						}
			
						echo '<li><a href="'.$large_img_path.'" title="" class="cloud-zoom-gallery" rel="useZoom: '."'".'zoom1'."'".', smallImage: '."'".$big_img_path."'".' "><img src="'.$small_img_path.'" title="'.$data->title.'" alt="" /></a></li>';
						
					}
					
					echo '
					</ul>
        		</div>
        	</div>';
		}
		return;	
	}
	
	function getVariantDetails($pid){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT * FROM logo_variant WHERE logo_id = '".$pid."' 
							   AND logo_variant_type = 'Color' AND status = 'Y' ORDER BY logo_variant_id DESC ";
		$result				= $database->query($sql);
		
		echo '<form name="frm_prod_details" id="frm_prod_details" action="" method="post">
				<div>';
						   				
		if ($result->num_rows > 0)
		{
			echo 'Color 
		   			<select name="color_variant_id" id="color_variant_id" class="selectBox">
					<option value="">Select color</option>';
					
			while ($data = $result->fetch_object()){
				echo '<option value="'.$data->logo_variant_id.'">'.$data->logo_variant_value.'</option>';			   		
			}
			echo '</select>';
			$color_variant_ctrl = 'color_variant_id';		  
		}else{
			$color_variant_ctrl = '';
		}
		
		$sql		= "SELECT * FROM logo_variant WHERE logo_id = '".$pid."' 
							   AND logo_variant_type = 'Size' AND status = 'Y' ORDER BY logo_variant_id DESC ";
		$result		= $database->query($sql);
		if ($result->num_rows > 0)
		{
			echo 'Size 
		   			<select name="size_variant_id" id="size_variant_id" class="selectBox">
					<option value="">Select size</option>';
					
			while ($data = $result->fetch_object()){
				echo '<option value="'.$data->logo_variant_id.'">'.$data->logo_variant_value.'</option>';			   		
			}
			echo '</select>';		  
			$size_variant_ctrl = 'size_variant_id';		  
		}else{
			$size_variant_ctrl = '';
		}
		
		echo '</div>
			<div>
				Qty:
            	<input type="text" name="prod_details_quantity" id="prod_details_quantity" size="2" value="1">&nbsp;
            	<input type="button" value="Add to Cart" id="button-cart" class="button" onclick="javascript: addto_cart(\'2\',\''.$pid.'\',\'prod_details_quantity\',\''.$color_variant_ctrl.'\',\''.$size_variant_ctrl.'\')" >           
				<div id="logo_details_error"></div>  
		  	</div>
		  </form>';		
	}
	
	function getVariantDropdowns($pid){
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT * FROM logo_variant WHERE logo_id = '".$pid."' 
							   AND logo_variant_type = 'Color' AND status = 'Y' ORDER BY logo_variant_id DESC ";
		$result				= $database->query($sql);
		
		$msg = '<form name="frm_prod_variant" id="frm_prod_variant" action="" method="post">
		  Select logo variant<br/><br/>
		  <div id="modal_variant_message">';	
		  					   				
		if ($result->num_rows > 0)
		{
			$msg .= 'Color 
		   			<select name="color_variant_id" id="color_variant_id" class="selectBox">
					<option value="">Select color</option>';
					
			while ($data = $result->fetch_object()){
				$msg .=  '<option value="'.$data->logo_variant_id.'">'.$data->logo_variant_value.'</option>';			   		
			}
			$msg .= '</select>';
			$color_variant_ctrl = 'color_variant_id';		  
		}else{
			$color_variant_ctrl = '';
		}
		
		$sql		= "SELECT * FROM logo_variant WHERE logo_id = '".$pid."' 
							   AND logo_variant_type = 'Size' AND status = 'Y' ORDER BY logo_variant_id DESC ";
		$result		= $database->query($sql);
		if ($result->num_rows > 0)
		{
			$msg .= 'Size 
		   			<select name="size_variant_id" id="size_variant_id" class="selectBox">
					<option value="">Select size</option>';
					
			while ($data = $result->fetch_object()){
				$msg .= '<option value="'.$data->logo_variant_id.'">'.$data->logo_variant_value.'</option>';			   		
			}
			$msg .= '</select>';		  
			$size_variant_ctrl = 'size_variant_id';		  
		}else{
			$size_variant_ctrl = '';
		}
		
		$msg .= '</div><br />
		  <div id="variant_details_error"></div><br />
          <input value="Add to Cart" onclick="javascript: addto_cart(\'1\',\''.$pid.'\',\'\',\''.$color_variant_ctrl.'\',\''.$size_variant_ctrl.'\')" type="button" class="bymore-btn marginRight marginLeft" />
		  <input value="Cancel" onclick="Popup.hide(\'modal_variant\')" type="button" class="checkout-btn" />		  
		</form>';
		
		return $msg;		
	}
	
	function getNumberProductsInBrand($bid){
		$database			= new database();
		$functions 			= new functions();
		$sql				= " SELECT p.*, g.image_name FROM logo p 
								LEFT JOIN logo_gallery g ON g.logo_id = p.logo_id AND g.valid_image != 'N' AND g.default_image != 'N' 
								WHERE p.status = 'Y' AND p.brand_id = '".$bid."' 
								GROUP BY p.logo_id ORDER BY p.logo_id DESC ";
		
		$result				= $database->query($sql);						   				
		return $result->num_rows;
	}
	
	public function display_search_logos()

	{

		$database				= new database();

		$param_array			= array();

		$sql 					= "SELECT * FROM logo WHERE status = 'Y' ";
	
		$search_condition		= '';
				
		if($this->keyword != '')		

		{

			$param_array[] 			= "keyword=" . $this->keyword;

			$search_cond_array[]	= " (logo_name LIKE '%" . $this->keyword . "%' OR logo_code LIKE '%" . $this->keyword . "%' OR logo_description LIKE '%" . $this->keyword . "%') ";					   

		}						

		if(count($search_cond_array)>0) 

		{ 

			//$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
			$search_condition	=  " AND " . join(" AND ",$search_cond_array); 

		}

				

		$sql			.= $search_condition;

		//$sql 			= $sql . " ORDER BY c.counsellor_name  ";		
		
		$sortField	= "logo_id";
		$sortOrder	= "DESC";
		$sql	   .= "ORDER BY ".$sortField." ".$sortOrder;
				
		//echo $sql;

		$result			= $database->query($sql);

		$this->num_rows = $result->num_rows;

		//functions::paginate($this->num_rows);

		functions::paginate_listing($this->num_rows, 0, 0, 'CLIENT');

		$start			= functions::$startfrom;

		
		$limit			= functions::$limits;
		
		
		$sql 			= $sql . " limit $start, $limit";

		//echo  ($sql);

		$result			= $database->query($sql);
		

		$param=join("&amp;",$param_array); 

		$this->pager_param=$param;

		
		$blog_array		= array();
		$functions 		= new functions();

		if ($result->num_rows > 0)

		{				

			$i 			= 0;
			
			$rec_count  = '1';

			$row_num	= functions::$startfrom;

			$page		= functions::$startfrom > 0 ? (functions::$startfrom / FRONT_PAGE_LIMIT) + 1 : 1;						

			while($data=$result->fetch_object())

			{
												
				echo '<p><a href="logo.php?pid='.$data->logo_id.'" title="">'.functions::deformat_string($data->logo_name).'</a></p>';	 
				echo  '<p>'.functions::deformat_string($data->logo_description).'</p>';
					  					
				$rec_count++;					
											
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

					$urlQuery = 'search_result.php?page='.$currentPage;

				}

				else

				{

					$urlQuery = 'search_result.php?'.$this->pager_param1.'&page='.$currentPage;	

				}

				functions::redirect($urlQuery);

			}

			else

			{

				echo "<div align='center' class='warningMesg'>Sorry.. No results found !!</div>";

			}

		}

	}
	
	public function getHomeProductImagesScroller(){
	
		$database			= new database();
		$functions 			= new functions();
		$sql				= "SELECT * FROM logo p INNER JOIN category c ON p.category_id = c.category_id 
		  					   WHERE p.status = 'Y' AND c.status = 'Y' ORDER BY p.order_id ASC ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0){
		
			echo '
			<div id="banner-slider">
      			<section>
        			<div id="amazon_scroller1" class="amazon_scroller">
          				<div class="list_carousel">
            				<ul id="foo2">';
		
			while ($data = $result->fetch_object()){
		
				$logo_id = $data->logo_id;
				$img_name	= $data->image_name;
				if ($img_name != ''){				 
					$prod_img_path = DIR_FOOD.'thumb_'.$img_name;				
					if (file_exists($prod_img_path)){
						$src_file = URI_FOOD.'thumb_'.$img_name;
					}else{
						$src_file = URI_FOOD.$img_name;
					}		
					$large_icon_path = DIR_FOOD.'large_icon_'.$img_name;
					if (file_exists($large_icon_path)){
						$dis_image_path = URI_FOOD.'large_icon_'.$img_name;
					}else{	
						$functions->autoResizeImageNotCropped(DIR_FOOD,$img_name,'large_icon_',FOOD_LARGE_ICON_WIDTH,FOOD_LARGE_ICON_HEIGHT);						
						$dis_image_path = URI_FOOD.'large_icon_'.$img_name;
					}																																									
					echo '<li><span class="img-slide"><a href="logo.php?pid='.$logo_id.'"><img src="'.$dis_image_path.'" border="0"></a></span></li>';
					//echo '<li><span class="img-slide"><a href="logo.php?pid='.$logo_id.'"><img src="'.$dis_image_path.'" border="0"></a></span></li>';
				}
			}
			
			echo '
					</ul>
					<div class="clearfix"></div>
					<a id="prev2" class="prev" href="#"><img src="images/slider-lft-arrow.png" /></a> <a id="next2" class="next" href="#"><img src="images/slider-rghtt-arrow.png" /></a>
					<div id="pager2" class="pager"></div>
				  </div>
				</div>
			  </section>
			</div>';
	
		}		
	
	}
	
	// Returns the max order id
	public static function get_max_order_id()
	{
		$database	= new database();
		$sql		= "SELECT MAX(order_id) AS order_id FROM logo WHERE 1 ";
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
	
	// Functoion update the list order
	public function update_list_order($list_array, $page_number)
	{
		$database		= new database();
		$limit			= PAGE_LIMIT;
		$id_array		= array();
		
		//print_r($list_array);
		
		foreach ($list_array as $id)
		{
			if($id == '')
			{
				continue;
			}
			$id_array[] = $id;
		}
		
		//print_r($id_array);
		if($page_number > 1)
		{
			$order_id = (($page_number - 1) * PAGE_LIMIT) + 1 ; //1
		}
		else
		{
			$order_id = count($id_array);
		}
		
		//echo count($id_array);
		for($i = 0; $i < count($id_array); $i++)
		{
			$sql = "UPDATE logo SET order_id = '" . $order_id . "' WHERE logo_id = '" . $id_array[$i] . "'";
			//echo $sql;
			$database->query($sql);
			$order_id++;
		}
	}
	
	public function getProductsContactUs($logo_name){
		$database			= new database();		
		$sql				= "SELECT * FROM logo p INNER JOIN category c ON p.category_id = c.category_id 
		  					   WHERE p.status = 'Y' AND c.status = 'Y' ORDER BY p.order_id ASC ";
							   
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($logo_name == functions::deformat_string($data->logo_name))
					echo '<option value="'.functions::deformat_string($data->logo_name).'" selected="selected">'.functions::deformat_string($data->logo_name).'</option>';
				else
					echo '<option value="'.functions::deformat_string($data->logo_name).'">'.functions::deformat_string($data->logo_name).'</option>';								
						
			}
		}
		return;
	}
		public function display_sponsors()
		{
	
		

			$database				= new database();
	
		
	
			$sql 					= " SELECT * FROM logo where status ='Y' and category_id=2 order by order_id ASC LIMIT 0,16 "; 
		
		
	
			$result			= $database->query($sql);
	
			
			$blog_array		= array();
			$functions 		= new functions();
	
			if ($result->num_rows > 0)
	
			{	
			echo '<ul>';										
				while($data=$result->fetch_array())
	
				{
					
					 $image_name	= $data['image_name'];	
					 if(file_exists(DIR_LOGO.'thumb_'.$image_name) && $image_name != '')
					 {
						 $img1		= 'thumb_'.$image_name;
					 }
					 else
					 {
					 	$img1		= $image_name;
					 }
					 $size_1	= getimagesize(DIR_LOGO.$img1);
						$imageLib = new imageLib(DIR_LOGO.$img1);
						$imageLib->resizeImage(SPONSOR_THUMB_WIDTH, SPONSOR_THUMB_HEIGHT, 0);
						$imageLib->saveImage(DIR_LOGO.'thumb2_'.$image_name, 90);
						unset($imageLib);
						$image		= 'thumb2_'.$image_name;
					 				
					
				
				
					$url=$data['url'];
					if (!preg_match("/^(http|ftp):/", $url)) {
					$url = 'http://'.$url;
					}
								
							
						echo ' <li><a href="'.$url.'" target="_blank"> <img src="'.URI_LOGO.$image.'"  title="'.$data['logo_name'].'" alt="'.$data[' logo_name'].'"/></a></li>'	;
						//echo'	<span class="partners-img"></span>	';				
				}
	
				
	
			echo '</ul>';
	
			}
	
			
		}	
	
			public function display_partners()
		{
	
		

			$database				= new database();
	
		
	
			$sql 					= " SELECT * FROM logo where status ='Y' and category_id=1 order by order_id ASC LIMIT 0,3 "; 
		
		
	
			$result			= $database->query($sql);
	
			
			$blog_array		= array();
			$functions 		= new functions();
	
			if ($result->num_rows > 0)
	
			{	
			echo '<div class="partners">
				<span class="partners-arrow"></span>
				<span class="partners-hdrtxt">Major Partners</span>	';											
				while($data=$result->fetch_array())
	
				{
					
					 $image_name	= $data['image_name'];	
					 if(file_exists(DIR_LOGO.'thumb_'.$image_name) && $image_name != '')
					 {
						 $image		= 'thumb_'.$image_name;
					 }
					 else
					 {
					 	$size_1	= getimagesize(DIR_LOGO.$image_name);
						$imageLib = new imageLib(DIR_LOGO.$image_name);
						$imageLib->resizeImage(LOGO_THUMB_WIDTH, LOGO_THUMB_HEIGHT, 0);
						$imageLib->saveImage(DIR_LOGO.'thumb1_'.$image_name, 90);
						unset($imageLib);
						$image		= 'thumb1_'.$image_name;
					 }
					 				
					
				
				
					$url=$data['url'];
					if (!preg_match("/^(http|ftp):/", $url)) {
					$url = 'http://'.$url;
					}
								
							
							
						echo'	<span class="partners-img"><a href="'.$url.'" target="_blank"> <img src="'.URI_LOGO.$image.'"  title="'.$data['logo_name'].'" alt="'.$data[' logo_name'].'"/></a></span>	';				
				}
	
				
	
			echo '</div>';
	
			}
	
			
		}	
}
?>
