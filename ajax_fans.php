<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

 $member_id	= $_SESSION[MEMBER_ID]; 
 $content_id	= (isset($_REQUEST['content_id']) &&  $_REQUEST['content_id']!= "") ? functions::clean_string($_REQUEST['content_id']) : '';

 $member = new member($member_id);


	if($member->member_id > 0)
	{
		content_like::update_fan($member->member_id, $content_id);
	}

	echo content_like::get_fan_total($content_id);



?>