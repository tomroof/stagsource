<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

 $member_id		= $_SESSION[MEMBER_ID]; 
 $comment_id	= $_REQUEST['comment_id'];
 $cause			= $_REQUEST['report_cause'];
 
 $member = new member($member_id);

 if($member->member_id > 0)
 {
	//print_r($cause);
	$spam_report	= new spam_report();
	$spam_report->spam_report_id = 0;
	$spam_report->cause    		 =  $cause;
	$spam_report->user_reported	 = $member->member_id;
	$spam_report->model_id		 = $comment_id;
	$spam_report->save();
 }


?>