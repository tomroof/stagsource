<?php
	/*********************************************************************************************
	Author 	: SUMITH
	Date	: 8-Feb-2013
	Purpose	: Logout
	*********************************************************************************************/
	ob_start();
	session_start();

	include_once("includes/config.php");
	$_SESSION[USER_ID]	= '';	
	session_unset($_SESSION[MEMBER_ID]);
	
	
	$token = $facebook->getAccessToken();
	//$url = 'example.php?logout=true';
	$facebook->destroySession();
	
	session_destroy();
	
	
	
	functions::redirect("index.php");
?>