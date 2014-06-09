<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

$email	= (isset($_REQUEST['email']) &&  $_REQUEST['email'])!= ""? functions::clean_string($_REQUEST['email']) : '';

$member = new member();

if($email != '' )
{
	$member->email = $email;
		
	if($member->validate_member_details())
	{
		echo '1<>' . $member->message;
	}
	else
	{
		echo '0<>' . $member->message;
	}
}
else
{
	echo "0<>Email can not be empty!";	
}
?>