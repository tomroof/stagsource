<?php
/*********************************************************************************************
Author 	: SUMITH
Date	: 18-Mar-2013
Purpose	: PNotify PHP class
*********************************************************************************************/
class notify
{
	protected $_properties;
	
	public function __construct($message_values='')	
	{
		$this->_properties	= array();
		$this->initialize($message_values);
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
	private function initialize($message_values='')
	{
		$message_values= json_decode($message_values);
		/*foreach( (array) $notify_values as $key => $value ) {
        	if( is_array( $value ) ) {
        	    //read( $notify_values1 );
       		}
        	//echo "$key = $value\n";
			
     	} */
		
		$this->_properties	= (array) $message_values;
	}
		
	public function show_message($message_values='')
	{	
		$this->initialize($message_values);
		
		$this->delay			= ($this->delay !='') ? $this->delay: '';
		$this->width			= ($this->width!='') ? $this->width: '';
		$this->history			= ($this->history!='') ? $this->history: '';
		$this->min_height		= ($this->min_height!='') ? $this->min_height: '';
		$this->animation		= ($this->animation!='') ? $this->animation: '';
		$this->animate_speed	= ($this->animate_speed!='') ? $this->animate_speed: '';
		$this->shadow			= ($this->shadow!='') ? $this->shadow: '';
		$this->closer			= ($this->closer!='') ? $this->closer: '';
		$this->sticker			= ($this->sticker!='') ? $this->sticker: '';
		$this->hide				= ($this->hide!='') ? $this->hide: '';
		$this->mouse_reset		= ($this->mouse_reset!='') ? $this->mouse_reset: '';
		$this->remove			= ($this->remove!='') ? $this->remove: ''; 
		$this->url				= ($this->url!='') ? $this->url: ''; 
		
		if($this->url!='')
		{
			//Redirect Page & Serialize Object(values)	
			$obj 	= serialize($this);
			$_SESSION['message_object']	= $obj;
			functions::redirect($this->url);
		}
		else
		{
			echo "<script type=\"text/javascript\">";
			echo "$(document).ready(function() { 
				show_message({
					title:'".$this->title."',
					text:'". $this->text."',
					type:'". $this->type."',
					width:'". $this->width."',
					delay:'".$this->delay."',
					history:'".$this->history."',
					animation:'". $this->animation."',
					min_height:'". $this->min_height."',
					animate_speed:'". $this->animate_speed."',
					shadow:'". $this->shadow."',
					closer:'". $this->closer."',
					sticker:'".$this->sticker."',
					hide:'".$this->hide."',
					mouse_reset:'". $this->mouse_reset."',
					remove:'". $this->remove."'
				});";
			echo "});</script>";
		}
	}
	
	public function show_message_redirect()
	{		
		echo "<script type=\"text/javascript\">";
		echo "$(document).ready(function() { 
			show_message({
				title:'".$this->title."',
				text:'". $this->text."',
				type:'". $this->type."',
				width:'". $this->width."',
				delay:'".$this->delay."',
				history:'".$this->history."',
				animation:'". $this->animation."',
				min_height:'". $this->min_height."',
				animate_speed:'". $this->animate_speed."',
				shadow:'". $this->shadow."',
				closer:'". $this->closer."',
				sticker:'".$this->sticker."',
				hide:'".$this->hide."',
				mouse_reset:'". $this->mouse_reset."',
				remove:'". $this->remove."'
			});";
		echo "});</script>";
	}
}
?>