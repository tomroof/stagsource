<?php
/*********************************************************************************************
Author 	: V V VIJESH
Date	: 22-March-2013
Purpose	: Mailer class
*********************************************************************************************/

class mailer extends PHPMailer
{
	protected $_properties;
	public $message;
	public $warning;
	
	function __construct()
	{
		parent::__construct();
		$this->_properties	= array();
		$this->message		= '';
		$this->warning		= false;
		
		$this->Host       	= SMTP_HOST;				// "mail.yourdomain.com";	// SMTP server
		$this->Port      	= SMTP_PORT;				// 26;						// set the SMTP port for the GMAIL server
		$this->Username  	= SMTP_USERNAME;			// "yourname@yourdomain";	// SMTP account username
		$this->Password   	= SMTP_PASSWORD;			// "yourpassword";			// SMTP account password
		
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
	}
	
		public function Send_old()
	{
		if(!isset($this->_properties['from']) || $this->_properties['from'] == '')
		{
			$this->message = 'Mail \'From\' property cannot be empty';
			$this->warning = true;
		}
		else if(!isset($this->_properties['to_address']) || $this->_properties['to_address'] == '')
		{
			$this->message = 'Mail \'To\' property cannot be empty';
			$this->warning = true;
		}
		else if(!isset($this->_properties['subject']) || $this->_properties['subject'] == '')
		{
			$this->message = 'Mail \'Subject\' property cannot be empty';
			$this->warning = true;
		}
		else if(!isset($this->_properties['body']) || $this->_properties['body'] == '')
		{
							
			$this->message = 'Mail \'Body\' property cannot be empty';
			$this->warning = true;
		}
		else
		{
			$headers  	= "MIME-Version: 1.0\r\n";
			$headers 	.= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
			if(isset($this->_properties['from_name']) && $this->_properties['from_name'] != '')
			{
				$from_name 	= $this->from_name;
			}
			else
			{
				$from_name 	= ADMIN_EMAIL_NAME;
			}
			 $headers 	.= "From: " . $from_name . " <" . $this->from . ">\r\n";

			/*$headers 	.= "Reply-To: " . SITE_NAME . " <" . ADMIN_REPLY_EMAIL_ID . ">\r\n";*/
			/*$headers 	.= "Reply-To: " . SITE_NAME . " <" . $this->from . ">\r\n";*/
			/*if(isset($this->_properties['bounceMail']) && $this->_properties['bounceMail'] != '')
			{
				$headers 	.= "Return-Path: -f".$this->_properties['bounceMail']. "\r\n";
				$headers 	.= "Return-Receipt-To: -f".$this->_properties['bounceMail']. "\r\n";
			}*/

			if(isset($this->_properties['cc']) && $this->_properties['cc'] != '')
			{
				$headers 	.= "Cc: " . $this->cc . "\r\n";
			}

			$bcc_details = 'Bcc: ';

			if(isset($this->_properties['bcc']) && $this->_properties['bcc'] != '')
			{
				$bcc_details	.= $this->bcc;
			}

			if(DEVELOPMENT_STAGE)
			{
				$bcc_details 	.= $bcc_details == 'Bcc: ' ? DEVELOPER_EMAIL : ', ' . DEVELOPER_EMAIL;
			}

			if(BCC_ADMIN_MAIL)
			{
				$bcc_details 	.= $bcc_details == 'Bcc: ' ? ADMIN_EMAIL_ID : ', ' . ADMIN_EMAIL_ID;
			}

			if($bcc_details !== 'Bcc: ')
			{
				$headers 	.= $bcc_details . "\r\n";
			}				
			
			return @mail($this->to_address, $this->_properties['subject'], $this->body, $headers);
		}
	
	}
	
	
	public function Send()
	{
		if(MAIL_SEND)
		{
			if(SMTP_MAIL_SEND)
			{
				$this->IsSMTP(); 				 // telling the class to use SMTP//
				//$mailer->SMTPDebug  = 2;
				$this->SMTPAuth   = true;      // enable SMTP authentication            
				
				if($this->from_name != '')
				{
					$this->SetFrom($this->from, $this->from_name);
				}
				else
				{
					$this->SetFrom($this->from);	
				}
				
				$this->Subject = ($this->subject != '') ? $this->subject: '';
				
				//$this->AddReplyTo($from_email, 'Discovery');
				//$this->Subject    = $this->subject;
				//$mailer->AltBody    = "dfsfdfsfsdf"; // optional, comment out and test
				//$mailer->AddAttachment(PDF_TEMPLATE_DIR . $file_name);
				
				if($this->to_name != '')
				{
					$this->AddAddress($this->to_address, $this->to_name);
				}
				else
				{
					$this->AddAddress($this->to_address);
				}
								
				if($this->attach != '')
				{
					$this->AddAttachment($this->attach);	
				}
				
				$this->MsgHTML($this->body);		
				return parent::Send();	
			}
			else
			{
				if(!isset($this->_properties['from']) || $this->_properties['from'] == '')
				{
					$this->message = 'Mail \'From\' property cannot be empty';
					$this->warning = true;
				}
				else if(!isset($this->_properties['to_address']) || $this->_properties['to_address'] == '')
				{
					$this->message = 'Mail \'To\' property cannot be empty';
					$this->warning = true;
				}
				else if(!isset($this->_properties['subject']) || $this->_properties['subject'] == '')
				{
					$this->message = 'Mail \'Subject\' property cannot be empty';
					$this->warning = true;
				}
				else if(!isset($this->_properties['body']) || $this->_properties['body'] == '')
				{
									
					$this->message = 'Mail \'Body\' property cannot be empty';
					$this->warning = true;
				}
				else
				{
					if(isset($this->_properties['from_name']) && $this->_properties['from_name'] != '')
					{
						$from_name 	= $this->from_name;
					}
					else
					{
						$from_name 	= ADMIN_EMAIL_NAME;
					}
					 $headers 	= "From: " . $from_name . " <" . $this->from . ">\r\n";
					 
					if(isset($this->_properties['cc']) && $this->_properties['cc'] != '')
					{
						$headers 	.= "Cc: " . $this->cc . "\r\n";
					}
		
					$bcc_details = 'Bcc: ';
		
					if(isset($this->_properties['bcc']) && $this->_properties['bcc'] != '')
					{
						$bcc_details	.= $this->bcc;
					}
		
					if(DEVELOPMENT_STAGE)
					{
						$bcc_details 	.= $bcc_details == 'Bcc: ' ? DEVELOPER_EMAIL : ', ' . DEVELOPER_EMAIL;
					}
		
					if(BCC_ADMIN_MAIL)
					{
						$bcc_details 	.= $bcc_details == 'Bcc: ' ? ADMIN_EMAIL_ID : ', ' . ADMIN_EMAIL_ID;
					}
		
					if($bcc_details !== 'Bcc: ')
					{
						$headers 	.= $bcc_details . "\r\n";
					} 
					
					
					/*$headers 	.= "Reply-To: " . SITE_NAME . " <" . ADMIN_REPLY_EMAIL_ID . ">\r\n";*/
					/*$headers 	.= "Reply-To: " . SITE_NAME . " <" . $this->from . ">\r\n";*/
					/*if(isset($this->_properties['bounceMail']) && $this->_properties['bounceMail'] != '')
					{
						$headers 	.= "Return-Path: -f".$this->_properties['bounceMail']. "\r\n";
						$headers 	.= "Return-Receipt-To: -f".$this->_properties['bounceMail']. "\r\n";
					}*/
					 
					 
					$headers  	.= "MIME-Version: 1.0\r\n";
										
					if($this->attach == '')
					{
						$headers 	.= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
						$headers .= $this->body."\r\n\r\n";		
					}
					else
					{
						$uid = md5(uniqid(time()));
						$file = $this->attach;
						$file_size = filesize($file);
						$handle = fopen($file, "r");
						$content = fread($handle, $file_size);
						fclose($handle);
						$content = chunk_split(base64_encode($content));
						$filename = basename($this->attach);
						
						$headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
						$header .= "This is a multi-part message in MIME format.\r\n";
						$headers .= "--".$uid."\r\n";
						$headers .= "Content-type:text/html; charset=iso-8859-1\r\n";
						$headers .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
						$headers .= $this->body."\r\n\r\n";
						$headers .= "--".$uid."\r\n";
						$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
						$headers .= "Content-Transfer-Encoding: base64\r\n";
						$headers .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
						$headers .= $content."\r\n\r\n";
						$headers .= "--".$uid."--";
					}
					
					return @mail($this->to_address, $this->_properties['subject'],"",  $headers);
		
				}
			}
		}
	}
	
}
?>