<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

 $member_id	= $_SESSION[MEMBER_ID]; 
 $content_id	= (isset($_REQUEST['content_id']) &&  $_REQUEST['content_id']!= "") ? functions::clean_string($_REQUEST['content_id']) : '';
 //$like_type		= (isset($_REQUEST['like_type']) &&  $_REQUEST['like_type'] !="") ? functions::clean_string($_REQUEST['like_type']) : '';
 $comment 		= $_REQUEST['comment'];
 
 $contents = explode('_',  $content_id);
 $member = new member($member_id);

if($comment == 1)
{
	if($member->member_id > 0)
	{
		content_like::update_comment_like($member->member_id, $content_id);
	}
	
	echo content_like::get_comment_like_total($contents[1], $contents[0]);
}
else
{
	if($member->member_id > 0)
	{
		content_like::update_page_like($member->member_id, $content_id);
	}
	
	echo content_like::get_like_total($contents[1], $contents[0]);
}

?>