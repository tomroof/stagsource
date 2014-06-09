<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 14-April-2011
	Purpose	: Contactus class
*********************************************************************************************/
    class contactus
	{
		protected $_properties		= array();
		public    $error			= '';
		public    $message			= '';
		public    $warning			= '';

        function __construct($contactus_id = 0)
		{
            $this->error	= '';
			$this->message	= '';
			$this->warning	= false;
			
			if($contactus_id > 0)
			{
				$this->initialize($contactus_id);
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
		private function initialize($contactus_id)
		{
			$database	= new database();
			$sql		= "SELECT *	 FROM contactus WHERE contactus_id = '$contactus_id'";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
		}
		
		// Save the Contactus details
		public function save()
		{
					
					
						$email_template	= new email_template('contactus.message');					
					
						
					
					$mail_content	= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
					//$mail_content	= str_replace("{SITE_NAME}", SITE_NAME,$mail_content);

					$mail_content	= str_replace("{EMAIL}", functions::deformat_string($this->email), $mail_content);
				
					$mail_content	= str_replace("{MESSAGE}", functions::deformat_string(nl2br($this->message)), $mail_content);
					$mail_content	= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
					$mailer				= new mailer();
					$mailer->from		= CONTACT_EMAIL_ID;
					$mailer->to			= ADMIN_EMAIL_ID;
					$mailer->subject	= $this->subject != '' ? functions::deformat_string($this->subject) : functions::deformat_string($email_template->subject);
					//$mailer->subject="Contact Information";
					 $mailer->body		= $mail_content;
				
					$mailer->send();
					
				
			$this->message = cnst11;
			return true;
		}
		
	
	
	
	   
	   
	  
	}
?>