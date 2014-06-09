<?php
/*********************************************************************************************
	Author 	: 
	Date	: 23-Nov-2010
	Purpose	: Module settings
*********************************************************************************************/
    class pdf_template
	{
		protected $_properties;
		public $error;
		public $message;
		public $warning;

        function __construct($pdf_template_id = 0)
		{
            $this->_properties	= array();
			$this->error		= '';
			$this->message		= '';
			$this->warning		= false;
			
			if($pdf_template_id != '')
			{
				$this->initialize($pdf_template_id);
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
		private function initialize($pdf_template_name)
		{			
			// Read the file content
			$file_name	= DIR_PDF_TEMPLATE . $pdf_template_name;
			
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
				
		//The function check the pdf_template name eixst or not
		public function check_template_exist($template_name = '', $pdf_template_id = 0)
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
				if($pdf_template_id != 0)
				{
					$sql	= "SELECT *	 FROM pdf_template WHERE template_name = '" . $template_name . "' AND pdf_template_id != '" . $pdf_template_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM pdf_template WHERE template_name = '" . $template_name . "'";
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
		
		//Get pdf_template id
		public function get_pdf_template_id($template_name)
		{
			$pdf_template_id	= 0;
			$database	= new database();
			if($template_name == '')
			{
				$this->message	= "Template name should not be empty";
				$this->warning	= true;
			}
			else
			{
				$sql	= "SELECT pdf_template_id FROM pdf_template WHERE template_name = '" . $database->real_escape_string($template_name) . "'";
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					$data		= $result->fetch_object();
					$pdf_template_id	= $data->pdf_template_id;
				}
				else
				{
					$this->message	= "Template name is not found";
					$this->warning	= true;
				}
			}
			return $pdf_template_id;	
		}
		
		//Get pdf_template id
		public function get_pdf_template_details($pdf_template_id)
		{
			$database	= new database();
			if(!is_numeric($pdf_template_id))
			{
				$template_name 		 = $pdf_template_id;
				$pdf_template_id	= $this->get_pdf_template_id($template_name);
			}
			
			$sql		= "SELECT * FROM pdf_template WHERE pdf_template_id = '$pdf_template_id'";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
			
			$file_name	= DIR_PDF_TEMPLATE . $this->file_name;
			
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
		
		// Remove the current object details.
		public static function removeby_module_id($module_id)
		{
			$database	= new database();
			$sql = "DELETE FROM pdf_template WHERE module_id = '" . $module_id . "'";
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