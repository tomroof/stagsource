<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

 $member_id	= $_SESSION[MEMBER_ID]; 
 
 $member	= new member($member_id);
 
 if($member->member_id > 0)
 {
 		$content_comment 	= new content_comment();
		$content_comment->content_comment_id  = 0;
		$content_comment->comment			  = functions::clean_string($_REQUEST['text-com']);
		$content_comment->member_id			  = $member->member_id;
		$content_comment->content_id		  = $_REQUEST['content_id'];
		$content_comment->status			  = 1;
		
		$content_comment->save();
 }
 
 echo 1;
 
?>