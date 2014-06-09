<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

$email				= functions::clean_string($_REQUEST['email']);
$password			=  functions::clean_string($_REQUEST['password']);
$ps					= functions::clean_string($_REQUEST['ps']);
$first_name			= functions::clean_string($_REQUEST['first_name']);
$last_name			= functions::clean_string($_REQUEST['last_name']);

$member 				= new member();
$member->member_id  	= 0;
$member->username 		= $email;
$member->email 			= $email;
$member->password		= $password;
$member->password_text 	= $ps;
$member->first_name 	= $first_name;
$member->last_name 		= $last_name;
$member->role_id		= 2;
$member->status			= 'Y';
$member->user_side		= 'Y';

$fb_existing			= member::check_fb_user_existing($email);
if($fb_existing > 0)
{
	$member_id 					= $member->update_fb_user_info();
	$_SESSION[MEMBER_ID]		= $member_id;
	echo "1<>Success";
}
else
{
	if($member->save())
	{
		$_SESSION[MEMBER_ID]		= $member->member_id;			
		echo "1<>Success";
	}
	else
	{
		echo "2<>".$message	= $member->message;
	}
}

?>