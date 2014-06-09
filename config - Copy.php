<?php
/*********************************************************************************************
Author 	: V. V. VIJESH
Date	: 20-Feb-2012
Company	: Rainend
Purpose	: Configuration file
*********************************************************************************************/
include_once "constant.php";
include_once "errors.php";
//ini_set("gd.jpeg_ignore_warning", 1); //added for image upload
date_default_timezone_set('America/Los_Angeles');
//error_reporting(E_ALL ^ E_NOTICE); 
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT)); 

//error_reporting(E_ALL); 
define("DEVELOPMENT_STAGE", false);						// Enable the development stage features
define("DEVELOPER_EMAIL", 'vijesh@rainend.com');	// Send a copy mail to developer when the DEVELOPMENT_STAGE is true
define("BCC_ADMIN_MAIL", false);						// Always send a Bcc mail to admin
define("MAIL_SEND", true);								//if set to true mail sending enabled, otherwise disabled
define("SMTP_MAIL_SEND", false);						//Mail sending method, if set to true(SMTP), false (normal mail)

switch ($_SERVER['SERVER_NAME'])
{
	case "localhost":
	{
		// Development server settings
		define("URI_ROOT","http://".$_SERVER['SERVER_NAME']."/toomroof/stagsource.com/");
		define('HOST', 'localhost');
		define('USERNAME', 'root');
		define('PASSWORD', 'root');
		define('DATABASE', 'tomroof_stagsource.com');
		break;
	}
	case "clients.rainend.com":
	{
		if(DEVELOPMENT_STAGE)
		{
			echo 'DEVELOPMENT_STAGE value must be false';	
		}
		// Test server settings
		define("URI_ROOT","http://".$_SERVER['SERVER_NAME']."/stagsource.com/");
		define('HOST', 'rainend.ipagemysql.com');
		define('DATABASE', 'client_stagsourc');
		define('USERNAME', 'client_stagsourc');
		define('PASSWORD', 'Pass1234');
		
		break;
	}
	default:
	{
		if(!DEVELOPMENT_STAGE)
		{
			//Live server settings
			define("URI_ROOT","http://".$_SERVER['SERVER_NAME']."/");
			define('HOST', 'rainend.ipagemysql.com');
			define('DATABASE', 'demo_cmtequipment');
			define('USERNAME', 'demo_cmtequipment');
			define('PASSWORD', 'Pass1234');
		}
		else
		{
			echo 'DEVELOPMENT_STAGE value must be false';
			exit;
		}
		break;
	}
}

define("DIR_ROOT", dirname(dirname(__FILE__)) . '/');

function __autoload($classname)
{
	if( file_exists(DIR_ROOT . 'includes/class.' . $classname . '.php'))
	{
		include_once DIR_ROOT . 'includes/class.' . $classname . '.php';
	}
}
	
define("URI_ADMIN", URI_ROOT . "admin/");
define("DIR_ADMIN", DIR_ROOT . "admin/");

define("URI_LIBRARY", URI_ROOT . "library/");
define("DIR_LIBRARY", DIR_ROOT . "library/");

define("URI_MAIL_TEMPLATE", URI_ROOT . "template/mail/");
define("DIR_MAIL_TEMPLATE", DIR_ROOT . "template/mail/");

define("FRONT_CSS_PATH", "css/");
define("ADMIN_CSS_PATH", "../css/");

define("FRONT_IMAGE_PATH", "images/");
define("ADMIN_IMAGE_PATH", "../images/");

define("FRONT_JS_PATH", "js/");
define("ADMIN_JS_PATH", "../js/");

require_once(DIR_LIBRARY . 'image-upload/server/class.UploadHandler.php');
require_once(DIR_LIBRARY . 'image-upload/server/class.UploadForm.php');
require_once(DIR_LIBRARY . 'phpmailer/class.phpmailer.php');


$con = new database();

// Fetching information from General settings table
$get_settings		= "SELECT * FROM settings";
$settings_result	= $con->query($get_settings);
if ($settings_result->num_rows > 0)
{
	while ($settings_row = $settings_result->fetch_assoc())
	{
		define($settings_row["keys"], functions::deformat_string($settings_row["values"]));
	}
}

// Fetching module settings
$get_settings		= "SELECT * FROM module_settings";
$settings_result	= $con->query($get_settings);
if ($settings_result->num_rows > 0)
{
	while ($settings_row = $settings_result->fetch_assoc())
	{
		$values = str_replace('"',"",$settings_row["values"]);
		$values = functions::deformat_string($values);
		if(strstr($values,"."))
		{
			list($name,$value) = explode(" . ",$values);
			$constVal = constant("$name");
			$values = str_replace($name .' . ',$constVal,$settings_row["values"]);
		}
		define($settings_row["keys"], $values);
	}
}


define('ADMIN_ID', 'admin_' . SITE_URL);
define('MEMBER_ID', 'member_' . SITE_URL);
//$location_type_array = array(1=>'Hotels', 2=>'Restaurants', 3=>'Venues');

?>