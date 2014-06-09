<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 23-Nov-2010
	Purpose	: Module settings
*********************************************************************************************/
    class email_template
	{
		protected $_properties;
		public $error;
		public $message;
		public $warning;

        function __construct($email_template_id = 0)
		{
            $this->_properties	= array();
			$this->error		= '';
			$this->message		= '';
			$this->warning		= false;
			
			if($email_template_id != '')
			{
				$this->initialize($email_template_id);
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
		
		public function __destruct() 
		{
			unset($this->_properties);
			unset($this->error);
			unset($this->message);
		}
		
		//Initialize object variables.
		private function initialize($email_template_id)
		{
			$database	= new database();
			
			if(!is_numeric($email_template_id))
			{
				// If the value of $email_template_id is template name, then follow the action
				$template_name		= $email_template_id;
				$email_template_id	= $this->get_email_template_id($template_name);
			}
			
			 $sql		= "SELECT * FROM email_template WHERE email_template_id = '$email_template_id'";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
			
			
			// Read the file content
			 $file_name	= DIR_MAIL_TEMPLATE . $this->file_name;
			if(file_exists($file_name))
			{
				$fp 		= fopen($file_name, 'r');
				$content	= '';
				if($fp != '')
				{
					while(!feof($fp))
					{ 
					 	$content .= fgetc($fp);
					} 
					fclose($fp);
				}
			}
			
			  $this->_properties['content']	= $content;
		}
		
		// Save the email_template details
		public function save()
		{
			$database			= new database();
			$email_template_id	= $this->_properties['email_template_id'] > 0 ? $this->_properties['email_template_id'] : 0;
			if(!$this->check_template_exist($this->template_name, $email_template_id))
			{
				if ( isset($this->_properties['email_template_id']) && $this->_properties['email_template_id'] > 0) 
				{
					$sql	= "UPDATE email_template SET 
								module_id = '". $database->real_escape_string($this->module_id) ."', 
								template_name = '". $database->real_escape_string($this->template_name) ."', 
								file_name = '". $database->real_escape_string($this->file_name) ."',
								subject = '". $database->real_escape_string($this->subject) ."'
								WHERE email_template_id = '$this->email_template_id'";
				}
				else 
				{
					$sql	= "INSERT INTO email_template 
								(module_id, template_name, file_name, subject) 
								VALUES ('" . $database->real_escape_string($this->module_id) . "',
										'" . $database->real_escape_string($this->template_name) . "',
										'" . $database->real_escape_string($this->file_name) . "',
										'" . $database->real_escape_string($this->subject) . "')";
				}
				
				//print "<br/>" . $sql . "<br/>";
				
				$result			= $database->query($sql);
				
				if($database->affected_rows == 1)
				{
					if($this->email_template_id == 0)
					{
						$this->email_template_id	= $database->insert_id;
					}
					
					$this->initialize($this->email_template_id);
				}
				
				$this->message = cnst11;
			}
		}
		
		// Save the email_template details
		public function update()
		{
			$database	= new database();
			if ( isset($this->_properties['email_template_id']) && $this->_properties['email_template_id'] > 0) 
			{
				$this->set_default_email_template($this->email_template_id);
				$sql	= "UPDATE email_template SET 
							template_name = '". $database->real_escape_string($this->template_name) ."', 
							file_name = '". $database->real_escape_string($this->file_name) ."', 
							subject = '". $database->real_escape_string($this->subject) ."' 
							WHERE email_template_id = '$this->email_template_id'";
			}
			
			//print "<br/>" . $sql . "<br/>";
			$result			= $database->query($sql);		
			$this->message = cnst11;
		}
		
				
		//The function check the email_template name eixst or not
		public function check_template_exist($template_name = '', $email_template_id = 0)
		{
			$output		= false;
			$database	= new database();
			if($template_name == '')
			{
				$this->message	= "Template name should not be empty";
				$this->warning	= true;
			}
			else
			{
				if($email_template_id != 0)
				{
					$sql	= "SELECT *	 FROM email_template WHERE template_name = '" . $template_name . "' AND email_template_id != '" . $email_template_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM email_template WHERE template_name = '" . $template_name . "'";
				}
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					$this->message	= "Template name is already exist";
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
		
		//Get email_template id
		public function get_email_template_id($template_name)
		{
			$email_template_id	= 0;
			$database	= new database();
			if($template_name == '')
			{
				$this->message	= "Template name should not be empty";
				$this->warning	= true;
			}
			else
			{
				 $sql	= "SELECT email_template_id FROM email_template WHERE template_name = '" . $database->real_escape_string($template_name) . "'";
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					$data		= $result->fetch_object();
					$email_template_id	= $data->email_template_id;
				}
				else
				{
					$this->message	= "Template name is not found";
					$this->warning	= true;
				}
			}
			return $email_template_id;	
		}
		
		// Remove the current object details.
		public static function removeby_module_id($module_id)
		{
			$database	= new database();
			$sql = "DELETE FROM email_template WHERE module_id = '" . $module_id . "'";
			try
			{
				if($result 	= $database->query($sql)) 
				{
					if ($database->affected_rows > 0)
					{
						$self->message = cnst12;	// Data successfully removed!
					}
				}
				else 
				{
					throw new Exception(cnst13);	// Selected record is not found!
				}
			}
			catch (Exception $e)
			{
				$self->message	= "Exception: ".$e->getMessage();
				$self->warning	= true;
			}
		}	
	}
?>