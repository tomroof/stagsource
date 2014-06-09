<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 02-March-2010
	Purpose	: Country class. Handles the customised ISO 3166 country table
*********************************************************************************************/
class country
{
	protected $_properties;
	public $error;
	public $message;
	public $warning;

	function __construct($country_id = '')
	{
		$this->_properties	= array();
		$this->error		= '';
		$this->message		= '';
		$this->warning		= false;
		
		$country_id = $this->validate_country($country_id);
		if($country_id > 0)
		{
			$this->initialize($country_id);
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
	private function initialize($country_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM country WHERE country_id = '$country_id'";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$this->_properties	= $result->fetch_assoc();
		}
	}
	
	// Validate country code
	public function validate_country($country_id = '')
	{
		if(is_numeric($country_id))
		{
			$country_id = $this->check_numeric_code($country_id);
		}
		else if (strlen($country_id) == 2)
		{
			$country_id = $this->check_alpha_2($country_id);
		}
		else if (strlen($country_id) == 3)
		{
			$country_id = $this->check_alpha_3($country_id);
		}
		else if (strlen($country_id) > 3 && strpos($country_id, 'ISO 3166-2:') == 1)
		{
			$country_id = $this->check_iso3166_2($country_id);
		}
		
		if($country_id != 0)
		{
			return $country_id;
		}
		else
		{
			return false;	
		}
	}
	
	//The function check the ISO 3166 numeric country code and return the country_id
	private function check_numeric_code($country_id	= '')
	{
		$database	= new database();
		if($country_id == '')
		{
			$this->message	= "Country code should not be empty";
			$this->warning	= true;
		}
		else
		{
			$sql		= "SELECT country_id FROM country WHERE country_id = '" . $country_id . "'";
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data	= $result->fetch_object();
				return $data->country_id;
			}
		}
		return $country_id;	
	}
	
	//The function check the ISO 3166-2 country code and return the country_id
	private function check_alpha_2($alpha_2	= '')
	{
		$country_id	= 0;
		$database	= new database();
		if($alpha_2 == '')
		{
			$this->message	= "Country code should not be empty";
			$this->warning	= true;
		}
		else
		{
			$sql		= "SELECT country_id FROM country WHERE alpha_2 = '" . $alpha_2 . "'";
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data	= $result->fetch_object();
				return $data->country_id;
			}
		}
		return $country_id;	
	}
	
	//The function check the ISO 3166-3 country code and return the country_id
	private function check_alpha_3($alpha_3	= '')
	{
		$country_id	= 0;
		$database	= new database();
		if($alpha_3 == '')
		{
			$this->message	= "Country code should not be empty";
			$this->warning	= true;
		}
		else
		{
			$sql		= "SELECT country_id FROM country WHERE alpha_3 = '" . $alpha_3 . "'";
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data	= $result->fetch_object();
				return $data->country_id;
			}
		}
		return $country_id;	
	}
	
	//The function check the ISO 3166-iso3166_2 country code and return the country_id
	private function check_iso3166_2($iso3166_2	= '')
	{
		$country_id	= 0;
		$database	= new database();
		if($iso3166_2 == '')
		{
			$this->message	= "Country code should not be empty";
			$this->warning	= true;
		}
		else
		{
			$sql		= "SELECT country_id FROM country WHERE alpha_3 = '" . $iso3166_2 . "'";
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data	= $result->fetch_object();
				return $data->country_id;
			}
		}
		return $country_id;	
	}
	
	public function get_country_name($country_code = '')
	{
		$country_id	 = $this->validate_country($country_code);
		if($country_id > 0)
		{
			$database	= new database();
			$sql		= "SELECT country_name FROM country WHERE country_id = '" . $country_id . "'";
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data	= $result->fetch_object();
				return $data->country_name;
			}
		}		
	}
	
	public static function get_country_options()
	{
		$database			= new database();
		$output			 	= array();
		$sql				= "SELECT * FROM country ORDER BY country_name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$category_array = array();
			while($data = $result->fetch_object())
			{
				$output[] = $data;
			}
		}
		return $output;
	}
}
?>