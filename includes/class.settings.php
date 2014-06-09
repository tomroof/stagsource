<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 04-Nov-2010
	Purpose	: settings class
*********************************************************************************************/
    class settings
	{
		protected $_properties;
		public $error;
		public $message;
		public $warning;

        function __construct($settings_id = 0)
		{
			$this->_properties	= array();
			$this->error		= '';
			$this->message		= '';
			$this->warning		= false;
			
			if($settings_id > 0)
			{
				$this->initialize($settings_id);
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
			unset($this->warning);
		}
		
		//Initialize object variables.
		private function initialize($settings_id)
		{
			$database	= new database();
			$sql		= "SELECT *	 FROM settings WHERE settings_id = '$settings_id'";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
		}
		
		// Save the settings details
		public function save()
		{
			$database		= new database();
			if ( isset($this->_properties['keys']) && $this->_properties['keys'] !='') 
			{
				$sql	= "UPDATE settings SET `values` = '". $database->real_escape_string($this->values)  ."' WHERE `keys` = '" . $database->real_escape_string($this->keys) . "'";
				$result			= $database->query($sql);
				
				if($database->affected_rows == 1)
				{
					if($this->settings_id == 0)
					{
						$this->settings_id	= $database->insert_id;
					}
					$this->initialize($this->settings_id);
				}
				
				$this->message = cnst11;
			}
		}
	}	// End of class login
?>