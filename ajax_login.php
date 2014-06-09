<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

$username	= (isset($_REQUEST['username']) &&  $_REQUEST['username'])!= ""? functions::clean_string($_REQUEST['username']) : '';
$password	= (isset($_REQUEST['password']) &&  $_REQUEST['password'])!= ""? functions::clean_string($_REQUEST['password']) : '';
$remember	= (isset($_REQUEST['remember']) &&  $_REQUEST['remember'])> 0 ? 'Y' : 'N';

$member = new member();

if($username != '' &&  $password != '')
{
	$member->username = $username;
	$member->password = $password;
	
	if($member->validate_login_ajax())
	{
		$_SESSION[MEMBER_ID]		= $member->member_id;			
		//functions::redirect('index.php');
		
		if($remember == 'Y') {
			$year = time() + 31536000;
			setcookie('remember_me', $_REQUEST['username'], $year);
			setcookie('remember_pass', $member->password_text, $year);
			setcookie('remember', $remember, $year);
		}
		else {
			if(isset($_COOKIE['remember'])) {
				$past = time() - 200;
				//setcookie(remember_me, gone, $past);
				setcookie('remember_me', '', $year);
				setcookie('remember_pass', '', $year);
				setcookie('remember', '', $year);
			}		
		}
		
		echo "1<>Success";
	}
	else
	{
		echo "3<>".$message	= $member->message;
	}
}
else
{
	echo "2<>Username/Password can not be empty!";	
}
?>