<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

 $member_id		= $_SESSION[MEMBER_ID]; 
 $title			= functions::clean_string($_POST['title']);
 $contents		= functions::clean_string($_POST['content']);
 $topic_category1	=  $_REQUEST['topic_category'];
 $topic_category	= $topic_category1[0];
 $seo_url			= functions::clean_string($_POST['seo_url']);

 $member = new member($member_id);
 $content_id  = 0;
 if($member->member_id > 0)
 {
	$content	= new content();
	$content->content_id	 		= 0;
	$content->title    		 		=  $title;
	$content->name    		 		=  $title;
	$content->content_status 		=  'publish';
	$content->content_comment_status	 = 'open';
	$content->content	 	 		= $contents;
	$content->content_author 		= $member->member_id;
	$content->content_type 			= 'community';
	$content->category_id	 		=   $topic_category;
	$content->content_is_premium 	= 'N';
	$content->seo_url		 		= $seo_url. '.' . CONTENT_EXTENSION;
	$content->seo_url1		 		= $seo_url;

	$content_id  = $content->save_topic();
 }

 echo $content_id;

?>