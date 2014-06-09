<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 04-Nov-2010
	Purpose	: Admin class
*********************************************************************************************/
    class admin
	{
		protected $_properties;
		public $error;
		public $message;
		public $warning;

        function __construct($admin_id = 0)
		{
			$this->_properties	= array();
			$this->error		= '';
			$this->message		= '';
			$this->warning		= false;
			
			if($admin_id > 0)
			{
				$this->initialize($admin_id);
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
		private function initialize($admin_id)
		{
			$database	= new database();
			$sql		= "SELECT *	 FROM admin WHERE admin_id = '$admin_id'";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
		}
		
		// Validate member login information
		public function validate_login()
		{
			$this->message	= "";
			$database	= new database();
			$sql		= "SELECT * FROM admin WHERE status = 'Y' AND username = '" . $database->real_escape_string($this->username) . "' AND password = '" . md5($database->real_escape_string($this->password)) . "'";
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
		
		//The function check the module name eixst or not
		public function check_username_exist($username='', $admin_id=0)
		{
			$output		= false;
			$database	= new database();
			if($username == '')
			{
				$this->message	= "Username name should not be empty";
				$this->warning	= true;
			}
			else
			{
				if($admin_id > 0)
				{
					$sql	= "SELECT *	 FROM admin WHERE username = '" . $username . "' AND admin_id != '" . $admin_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM admin WHERE username = '" . $username . "'";
				}
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					$this->message	= "Username name is already exist";
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
		
		// Validate admin id
		public static function validate_admin_id($admin_id)
		{
			$output		= false;
			$database	= new database();
			$sql		= "SELECT admin_id FROM admin WHERE admin_id = '" . $admin_id . "'";
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$output		= true;
			}
			return $output;
		}
		
		// The function is used to change the password.
		public function change_password($old_password, $password, $admin_id=0)
		{		
			$database	= new database();
			
			if($admin_id > 0)
			{
				$sql		= "SELECT *	 FROM admin WHERE admin_id = '" . $admin_id . "' AND password = '" . md5($old_password) . "'";
			}
			else
			{
				$sql		= "SELECT *	 FROM admin WHERE admin_id = '" . $this->admin_id . "' AND password = '" . md5($old_password) . "'";
				$admin_id	= $this->admin_id;
			}
			//print $sql;
			$result			= $database->query($sql);
			if($result->num_rows > 0)
			{
				return $this->update_password($admin_id, $password);
			}
			else
			{
				$this->message = "Your current password is not matching!";
				$this->warning = true;
				return false;
			}
		}
				
		// The function is used to change the password.
		public function update_password($admin_id, $password)
		{		
			$database	= new database();
			
			$sql		= "UPDATE admin 
						SET password = '". md5($password) . "'
						WHERE admin_id = '" . $admin_id . "'";
			$result 	= $database->query($sql);
			$this->message = "Password successfully updated!";
			$this->warning = false;
			return true;
		}
		
		// The function is used to change the status.
		public static function update_status($admin_id, $status = '')
		{		
			$database	= new database();
			
			if($status == '')
			{
				$admin	= new admin($admin_id);
				$status =  $admin->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE admin 
						SET status = '". $status . "'
						WHERE admin_id = '" . $admin_id . "'";
			$result 	= $database->query($sql);
			return $status;
		}
		
		// The function is used to change the theme.
		public static function update_theme($admin_id, $theme = 'blue')
		{		
			$database	= new database();
			
			$sql		= "UPDATE admin 
						SET theme = '". $theme . "'
						WHERE admin_id = '" . $admin_id . "'";
			$result 	= $database->query($sql);
		}
	}
?>