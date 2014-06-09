<?php
/*********************************************************************************************
		Author 	: V V VIJESH
		Date	: 25-July-2012
		Purpose	: Provide general validation
**********************************************************************************************/
class validation
{
	private $errors	= array();

	private function is_error_exists($error_name)
	{
		if (array_key_exists($error_name, $this->errors))
		{
			if (strlen($this->errors[$error_name]) == 0)
			{	return false;	}
			else
			{	return true;	}
		}
		else
		{	return false;		}
	}

    public function check_blank($input, $field_name, $error_name)
	{
		if (strlen(trim($input)) == 0 && !$this->is_error_exists($error_name) )
		{
			$this->errors[$error_name] = $field_name . " is required!";
		}
    }
	public function check_array($input, $field_name, $error_name)
	{
		if (empty($input) && !$this->is_error_exists($error_name) )
		{
			$this->errors[$error_name] = $field_name . " is required!";
		}
    }
	
	public function check_selection($input, $field_name, $error_name)
	{
		if (trim($input) == 0 && !$this->is_error_exists($error_name) )
		{
			$this->errors[$error_name] = "You should select ". $field_name . "!";
		}
    }
	
	public function check_both_textandcombo($input, $input1, $field_name, $error_name) 
	{
		if (strlen(trim($input)) == 0 && !$this->is_error_exists($error_name) && $input1 == 0)
		{
			$this->errors[$error_name] = "You should ". $field_name . "!";
		}
    }
	
	public function check_three_object($input, $input1, $input2, $field_name, $error_name)
	{
		
		if (strlen(trim($input)) == 0 && !$this->is_error_exists($error_name) && empty($input1) && empty($input2))
		{
			$this->errors[$error_name] = "You should ". $field_name . "!";
		}
    }	
	
	
	public function check_captcha($input, $field_name, $error_name)
	{
		if (strlen(trim($input)) == 0 && !$this->is_error_exists($error_name) )
		{
			$this->errors[$error_name] = $field_name . " is required";
		}
		else if ((trim($input) != $_SESSION["captcha_code"]) && !$this->is_error_exists($error_name) )
		{
			$this->errors[$error_name] = $field_name . " is not valid!";
		}
    }

	public function check_length($input, $min, $max, $field_name, $error_name)
	{
		if ( (strlen(trim($input)) < $min || strlen(trim($input)) > $max) && !$this->is_error_exists($error_name) )
		{
			$this->errors[$error_name]	= $field_name . " should be between " . $min . " and " . $max . " characters!";
		}
	}

	public function check_range($input, $min, $max, $field_name, $error_name)
	{
		if ( (trim($input) < $min || trim($input) > $max) && !$this->is_error_exists($error_name) )
		{
			$this->errors[$error_name]	= $field_name . " should be between " . $min . " and " . $max . " characters!";
		}
	}
	
	public function check_compare($input, $input2, $field_name, $error_name)
	{
		if (strlen(trim($input)) > 0 && strlen(trim($input2)) > 0)
		{
			if ( (trim($input) != trim($input2)) && !$this->is_error_exists($error_name) )
			{
				$this->errors[$error_name]	= $field_name . " is not matching!";
			}
		}
	}
	
	public function check_combo($input, $val, $field_name, $error_name)
	{
        if ( ($input == $val) && !$this->is_error_exists($error_name) )
		{
            $this->errors[$error_name]	= "Select " . $field_name."!";
        }
	}

    public function check_radio($input, $val, $field_name, $error_name)
    {
        if ( ($input == $val) && !$this->is_error_exists($error_name) )
		{
            $this->errors[$error_name]	= "Select " . $field_name."!";
        }
    }

	public function check_number($input, $field_name, $error_name)
	{
		if ( (preg_match("/[^0-9]+$/", $input)) && !$this->is_error_exists($error_name))
        {
            $this->errors[$error_name]	= $field_name . " required only digits!";
        }
	}

	public function check_currency($input, $field_name, $error_name)
	{
		echo "<br />Inside Validation ".$input;
		if ( (preg_match("/^([0-9]+(\.))([0-9]{2})$/", $input)) && !$this->is_error_exists($error_name))
        {
            echo "<br />Inside Error";
			$this->errors[$error_name]	= $field_name . " required only alphabets!";
        }
	}

	public function check_alphabets($input, $space, $field_name, $error_name)
	{
		if ($space)
		{
			$regExp = "/[^A-Za-z\ ]+$/";
		}
		else
		{
			$regExp = "/[^A-Za-z]+$/";
		}
		
		if ( (preg_match($regExp, $input)) && !$this->is_error_exists($error_name))
        {
            $this->errors[$error_name]	= $field_name . " required only alphabets!";
        }
	}
	
	// Function check the entered string contains only smaller case alphabets and underscore(_)
	public function check_module_name($input, $field_name, $error_name)
	{
		if ( (preg_match("/[^a-z\_]/", $input)) && !$this->is_error_exists($error_name))
        {
            $this->errors[$error_name]	= $field_name . " allowed only smaller case alphabets and underscore(_)!";
        }
	}
	
	public function check_alphanumeric($input, $space, $field_name, $error_name)
	{
		if ($space)
		{
			$regExp = "/^[A-Za-z0-9\ ]+$/";
		}
		else
		{
			$regExp = "/^[A-Za-z0-9]+$/";
		}

        if (preg_match($regExp, $input, $matches, PREG_OFFSET_CAPTURE) && !$this->is_error_exists($error_name))
        {
            $this->errors[$error_name]	= $field_name . " required only alphanumeric character!";
        }
	}

	public function check_email($input, $field_name, $error_name)
	{
		//if (!preg_match("/^[a-zA-Z0-9._-][\w\.]*@[\w\-]+[\w\.]+\.[a-zA-Z.]{2,3}/i", $input))
		//if (!preg_match("'^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,3}$'", $input))
		//if (!preg_match("/^([a-zA-Z0-9._-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/", $input))

        $this->check_length($input, "7", "100", $field_name, $error_name);
		#(!preg_match("^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$", $input) && !$this->is_error_exists($error_name))
        //if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $input) && !$this->is_error_exists($error_name))
		
		if(!filter_var($input, FILTER_VALIDATE_EMAIL) && !$this->is_error_exists($error_name))
        {	
            $this->errors[$error_name]	= $field_name . " is invalid!";
        }
	}

	public function check_date($day, $mon, $year, $field_name, $error_name)
	{
        if (!checkdate($mon, $day, $year) && !$this->is_error_exists($error_name))
        {
            $this->errors[$error_name]	= $field_name . " is invalid!";
        }
	}
	
	public function check_checkbox_checked($fld,  $field_name, $error_name)
	{
		if(count($fld) == 0 )
		{
			$this->errors[$error_name]	= "At least one checkbox for ".$field_name . " should check!";
		}
	}

	public function check_specialchar($input, $mesg)
	{
		$check	= "";
		$retval	= "";

		$RegEx	= "/[\`~!@#$%\^&*()-=+\/:;<>?\[\]{|}\\\"\s\.'\-]/u";

		preg_match($RegEx, $input, $matches, PREG_OFFSET_CAPTURE);

		if (count($matches) > 0)
		{	$retval = $mesg;	}
		else
		{	$retval = "";		}

		return $retval;
	}

	public function validate_phone($input, $field_name, $error_name)
	{
		if ( (!preg_match("/^(\d{3})\-(\d{3})\-(\d{4})/", $input)) && !$this->is_error_exists($error_name))
        {
            $this->errors[$error_name] = $field_name . " number or format is invalid!";
        }
	}
/*
	public function check_allowspecial($input, $field_name, $error_name, $special_char="\`~!@#$%\^&*()=+\/:;<>?\[\]{|}\\\"\.'")
	{
		$check	= "";
		$retval	= "";
		/*
		if($special_char == '')
		{
			$RegEx	= "/[\`~!@#$%\^&*()=+\/:;<>?\[\]{|}\\\"\.']/u";
		}
		else
		{
			* * /
			$RegEx	= "/[" . $special_char . "]/u";
		//}

		preg_match($RegEx, $input, $matches, PREG_OFFSET_CAPTURE);

		if (count($matches) > 0 && !$this->is_error_exists($error_name))
        {
            $this->errors[$error_name]	= $field_name . " accept only letters and " . $special_char;
        }
	}
	*/
	public function check_allowspecial($input, $field_name, $error_name, $special_char="\`~!@#$%\^&*()=+\/:;<>?\[\]{|}\\\"\.'")
	{
		$check	= "";
		$retval	= "";
		$RegEx	= "/[" . $special_char . "]/u";

		preg_match($RegEx, $input, $matches, PREG_OFFSET_CAPTURE);

		if (count($matches) > 0 && !$this->is_error_exists($error_name))
        {
            $this->errors[$error_name]	= $field_name . " accept only letters and " . $special_char."!";
        }
	}

	public function check_ip($input, $field_name, $error_name)
	{
		$RegEx	= "/^(25[0-5]|2[0-4]\d|[01]?\d\d\d)\.25[0-5]|2[0-4]\d|[01]?\d\d\d)\.25[0-5]|2[0-4]\d|[01]?\d\d\d)\.25[0-5]|2[0-4]\d|[01]?\d\d\d))$";

		if (!preg_match($RegEx, $input) && !$this->is_error_exists($error_name) )
		{
            $this->errors[$error_name] = $field_name . " is invalid!";
        }
	}
	public function check_url($input, $field_name, $error_name)
	 {
	  $RegEx = "/^((http|https):\/\/)?((w){3}$\.)?[a-z0-9\-]+?\.((.*))$/";
	
	  if (!preg_match($RegEx, $input) && !$this->is_error_exists($error_name) )
	  {
				$this->errors[$error_name] = $field_name . " is invalid!";
			}
	 }

	public function check_vdo($filename, $field_name, $error_name)
	{
		$type		= strtolower($filename);
		$extArray	= array("application/octet-stream", "video/x-flv");

		//	video/x-ms-wmv for .WMV file
		//if ( ($type == "application/octet-stream") || ($type == "video/x-ms-wmv") || ($type == "video/mpeg") )
        if (!in_array(strtolower(strrchr($type, ".")), $extArray) && !$this->is_error_exists($error_name)) 
        {
            $this->errors[$error_name]	= "Invalid image file format!";
        }
	}

	public function check_file($filename, $allwd, $error_name)
	{
		$type		= strtolower($filename);
        $extArray	= $allwd;

        if (!in_array(strtolower(strrchr($type, ".")), $extArray) && !$this->is_error_exists($error_name)) 
        {
            $this->errors[$error_name]	= "Invalid file format!";
        }
	}
	
	public function is_uploaded($file_object, $field_name, $error_name)
	{
		if(!is_uploaded_file($file_object['tmp_name']))
		{
            $this->errors[$error_name]	= $field_name . " File required!";
        }
	}
	
	public function check_image($filename, $field_name, $error_name)
	{
		$type		= strtolower($filename);
        $extArray	= array("image/pjpeg", "image/jpeg", "image/gif", "image/png");

        if (!in_array(strtolower(strrchr($type, ".")), $extArray) && !$this->is_error_exists($error_name)) 
        {
            $this->errors[$error_name]	= "Invalid image file format!";
        }
	}
	
	public function check_image_size($file_object, $field_name, $error_name, $size = array())
	{
		$uploaded_image_info=getimagesize($file_object['tmp_name']);
		
		if(count($size) == 4 || count($size) == 6 || count($size) == 8)
		{
			if(($uploaded_image_info[0] < $size [0]) || ($uploaded_image_info[1] < $size [1]) || ($uploaded_image_info[0] > $size [2]) || ($uploaded_image_info[1] > $size [3]))
			{
				
				$this->errors[$error_name]	= "Please upload the correct size image. " . $field_name . " size should be between ". $size [0] ." X ".$size [1]." and ".$size [2]." X ".$size [3]." pixels";
			}
		}
		else if(count($size) == 2)
		{
			if(($uploaded_image_info[0] < $size [0])|| ($uploaded_image_info[1] < $size [1]))
			{
				$this->errors[$error_name]	= "Please upload the correct size image. " . $field_name . " size should be ". $size [0] ." X ".$size [1]."  pixels";
			}
		}
	}
	
	public function check_image_mimimum_size($file, $min_width, $min_height, $type)
	{
		if ($type == '1'){
			$uploaded_image_info = getimagesize($file);
		}else{
			$uploaded_image_info = getimagesize($file['tmp_name']);
		}	
		if(($uploaded_image_info[0] < $min_width) || ($uploaded_image_info[1] < $min_height)){
			return 0;
		}else{
			return 1;
		}		
	}
	
	// Audio, VDO file
	public function check_av_type($filename,  $error_name)
	{   
		$extArray = array(".mp2", ".mpeg", ".dat", ".mov", ".avi", ".ram", ".rm", ".3gp",".mp3", ".wav", ".wma", ".au", ".sam", ".smp", ".mp2", ".ram", ".rm");
		
		if (!in_array(strtolower(strrchr($filename, ".")), $extArray) && !$this->is_error_exists($error_name)) 
		{
			$this->errors[$error_name]	= "Incorrect audio/video file format!";
		}
	}

	/**	* Create a thumbnail image from $inputFileName no taller or wider than      
		* $maxSize. Returns the new image resource or false on error.     
		* Author: mthorn.net     
	*/
	public function thumbnail($inputFileName, $maxSize = 100)
	{
		$info = getimagesize($inputFileName);
		$type = isset($info['type']) ? $info['type'] : $info[2];
	
		// Check support of file type
		if ( !(imagetypes() & $type) )
		{
			// Server does not support file type
			return false;
		}
	
		$width  = isset($info['width'])  ? $info['width']  : $info[0];
		$height = isset($info['height']) ? $info['height'] : $info[1];
	
		// Calculate aspect ratio
		$wRatio = $maxSize / $width;
		$hRatio = $maxSize / $height;
	
		// Using imagecreatefromstring will automatically detect the file type
		$sourceImage = imagecreatefromstring(file_get_contents($inputFileName));
	
		// Calculate a proportional width and height no larger than the max size.
		if ( ($width <= $maxSize) && ($height <= $maxSize) )
		{
			// Input is smaller than thumbnail, do nothing
			return $sourceImage;
		}
		elseif ( ($wRatio * $height) < $maxSize )
		{
			// Image is horizontal
			$tHeight = ceil($wRatio * $height);
			$tWidth  = $maxSize;
		}
		else
		{
			// Image is vertical
			$tWidth  = ceil($hRatio * $width);
			$tHeight = $maxSize;
		}
	
		$thumb = imagecreatetruecolor($tWidth, $tHeight);
		if ( $sourceImage === false )
		{
			// Could not load image
			return false;
		}
	
		// Copy resampled makes a smooth thumbnail
		imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $tWidth, $tHeight, $width, $height);
		imagedestroy($sourceImage);
	
		return $thumb;
	}

	/**
		* Save the image to a file. Type is determined from the extension.
		* $quality is only used for jpegs.
		* Author: mthorn.net
	*/
	public function imageToFile($im, $fileName, $quality = 80)
	{
		if ( !$im || file_exists($fileName) )
		{
			return false;
		}
	
		$ext = strtolower(substr($fileName, strrpos($fileName, '.')));
	
		switch ($ext)
		{
			case '.gif':
				imagegif($im, $fileName);
				break;
			case '.jpg':
			case '.jpeg':
				imagejpeg($im, $fileName, $quality);
				break;
			case '.png':
				imagepng($im, $fileName);
				break;
			case '.bmp':
				imagewbmp($im, $fileName);
				break;
			default:
				return false;
		}
	
		return true;
	}
	
	// Below function are create some problem. SO DO NOT USE IT
	public function resize_image($src, $dst, $resize_to)
	{
		if (exif_imagetype($src) == IMAGETYPE_GIF)
		{
			$src_im	= imagecreatefromgif($src);
		}
		else if (exif_imagetype($src) == IMAGETYPE_JPEG)
		{
			$src_im	= imagecreatefromjpeg($src);
		}
		else if (exif_imagetype($src) == IMAGETYPE_PNG)
		{
			$src_im	= imagecreatefrompng($src);
		}
	
		if (!src_im)
		{
			$err_msg	= "Error with " . $src;
			return false;
		}
	
		$dst_dim = get_resized_dim(imagesx($src_im), imagesy($src_im), $resize_to);
		// Calculate the new dimension
		$dst_im = imagecreatetruecolor($dst_dim[0], $dst_dim[1]);
	
		if (!$dst_im)
		{
			$err_msg = "Error for resizing!";
			return false;
		}

		imagecopyresampled($dst_im, $src_im, 0, 0, 0, 0, $dst_dim[0], $dst_dim[1], imagesx($src_im), imagesy($src_im));

		if (exif_imagetype($src) == IMAGETYPE_GIF)
		{
			imagegif($dst_im, $dst);
		}
		else if (exif_imagetype($src) == IMAGETYPE_JPEG)
		{
			imagejpeg($dst_im, $dst);
		}
		else if (exif_imagetype($src) == IMAGETYPE_PNG)
		{
			imagepng($dst_im, $dst);
		}
		else
		{
			imagepng($dst_im, $dst);
		}

		imagedestroy($src_im);
		imagedestroy($dst_im);

		return true;
	}

	public function get_resized_dim($w, $h, $resize_to)
	{
		if ($w > $h)
		{
			$ratio = (double)($resize_to / $w);
		}
		else
		{
			$ratio = (double)($resit_to / $h);
		}
	
		return array($w * $ratio, $h * $ratio);
	}

	// check for errors
	public function checkErrors()
	{
		if (count($this->errors) > 0)
		{
			return true;
		}

		return false;
	}

	// return errors
	public function displayErrors($error_name)
	{
		if (array_key_exists($error_name, $this->errors))
		{
			return $this->errors[$error_name];
		}
		else
		{
			return "";
		}
	}

	// return errors
	public function getallerrors()
	{
		return $this->errors;
	}

	public function set_error($error_name, $error_message)
	{
		if(!$this->is_error_exists($error_name) )
		{
			$this->errors[$error_name]	= $error_message;
		}
	}
	
	function check_editor_content($input, $field_name, $error_name)
	{     
		if (strlen(trim($input)) == 0 || $input=="<br>" || $input=="<br />" || $input=="<br type=\"_moz\" />" || $input=="&nbsp;")
		{
			$this->errors[$error_name] = $field_name . " is required!";
		}
	}
	
	public function check_website($input, $field_name, $error_name)
		 {
		  //$RegEx = "/^(https?):\/\/(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{2,}$/";
		  $RegEx = "/^[https]*:?\/?\/?(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{2,}$/";
		
		  if (!preg_match($RegEx, $input) && !$this->is_error_exists($error_name) )
		  {
					$this->errors[$error_name] = $field_name . " is invalid!";
				}
		 }
	//
	public function check_positive_number($input, $field_name, $error_name)
	{
		if ( (!preg_match("/^[0-9]*\.?[0-9]{2}+$/", $input)) && !$this->is_error_exists($error_name))
        {
            $this->errors[$error_name]	= $field_name . " required only digits!";
        }
	}
	
	
	public function check_min_image_size($file_object, $field_name, $error_name, $size = array())
	{
		if($this->errors[$error_name]  == '')
		{
			$upload_size		= getimagesize($file_object['tmp_name']);
    	
			if ($upload_size[0] < $size[0] || $upload_size[1] <  $size[1])
			{
				$this->errors[$error_name]	= "Image dimensions are too small. " . $field_name . " minimum size should be ". $size [0] ." X ".$size [1]."  pixels";
       		// return array("error"=>"Image dimensions are too small. Minimum width is {$minimum['width']}px. Uploaded image width is $width px");
			}
		}
	}
	
	function check_ckeditor_content($input, $field_name, $error_name)
	{     
		if (strlen(trim($input)) == 0 || $input=="<br>" || $input=="<br />" || $input=="<br type=\"_moz\" />" || $input=="&nbsp;")
		{
			$this->errors[$error_name] = $field_name . " is required!";
		}
	}
	
	//Post Urls
   public function validateFacebookUrl($input, $field_name, $error_name)
   {
		//$RegEx = "/^(https?):\/\/(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{2,}$/";
		$RegEx = '/^(http|https):\/\/(www\.)?facebook\.com\/stagsource\/posts\/(\d)+$/';
  
		if (!preg_match($RegEx, $input) && !$this->is_error_exists($error_name) )
		{
			  $this->errors[$error_name] = $field_name . " is invalid!";
		}
   }
   
   public function validateTwitterUrl($input, $field_name, $error_name)
   {
		//$RegEx = "/^(https?):\/\/(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{2,}$/";
		$RegEx = '/^(http|https):\/\/(www\.)?twitter\.com\/.*(\d)+$/';
  
		if (!preg_match($RegEx, $input) && !$this->is_error_exists($error_name) )
		{
			  $this->errors[$error_name] = $field_name . " is invalid!";
		}
   }
   
   public function validateInstagramUrl($input, $field_name, $error_name)
   {
		//$RegEx = "/^(https?):\/\/(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{2,}$/";
		$RegEx = '/^(http|https):\/\/(www\.)?instagram\.com\/(\w)+\/(\w)+$/';
  
		if (!preg_match($RegEx, $input) && !$this->is_error_exists($error_name) )
		{
			  $this->errors[$error_name] = $field_name . " is invalid!";
		}
   }
   
}


?>