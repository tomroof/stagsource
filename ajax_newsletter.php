<?php
ob_start("ob_gzhandler");
session_start(); 
include('includes/config.php');
 $member_id	= $_SESSION[MEMBER_ID]; 
 

 $member = new member($member_id);
 if($member->member_id > 0)
 {
	$news_letter= new news_letter();
	$news_letter->email=$_REQUEST['email'];
	if($news_letter->save())
	{
		echo "1";	
	}
	else echo "0";
 }
 else
 {
	 functions:: redirect(URI_ROOT. 'logout.php');
	 echo "2"; 
 }

?>