<?php
/*********************************************************************************************
Author 	: V. V. VIJESH
Date	: 10-Nov-2011
Purpose	: Content page
*********************************************************************************************/
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

$id	= (isset($_REQUEST['id']) &&  $_REQUEST['id']) != '' ? $_REQUEST['id'] : 'profile';

if(!isset($_SESSION[MEMBER_ID]))
{
	functions::redirect(URI_ROOT);
	exit;	
}

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= functions::deformat_string($content->title);
$template->meta_keywords	= functions::format_text_field($content->meta_keywords);
$template->meta_description	= functions::format_text_field($content->meta_description);
$template->js				= '';
$template->css				= '<link rel="stylesheet" href="'.URI_ROOT.'css/styles_content.css" type="text/css" media="screen">
								<link rel="stylesheet" href="'.URI_ROOT.'css/tab.css" />';
$template->right_menu		= true;
$template->heading();
?>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "e0ce4108-d273-4cdd-a512-5e481503e37b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
 
 
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false,  "ui_use_css":true };</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50a0cd6c4f80d325"></script> 

<script type="text/javascript">

$(document).ready(function() {
	//$(".tab_content").hide();
	$(".tab_content:first").show(); 

	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
});

</script>
<style type="text/css">
select {
	width:120px;
}
label {
	cursor: pointer;
}
</style>


<?php

if($id != 'RecentActivity'  && $id != 'profile/RecentActivity' && $id != 'profile' && $id != 'calendar' && $id != 'InviteFriends' && $id != 'accountsettings' && $id != 'addmessage')
{
	$id = 'profile';	
}

if($id == 'addmessage')
{
	 $uri = $_SERVER['REQUEST_URI'];
	 $uri_1 = explode('=', $uri);
	 if(isset($uri_1[1]))
	 {
		 $member_message  = new member($uri_1[1]);
		 if($member_message->member_id > 0)
		 {
			 $uid 	= $member_message->member_id;
			 include_once DIR_ROOT.'profile_dashboard.php';
		 }
		 else
		 {
			 $id  = 'profile';
		 }
	 }
	 else
	 {
		$id  = 'profile'; 
	 }
}

if($id == 'RecentActivity' || $id == 'profile/RecentActivity')
{
	$uri = $_SERVER['REQUEST_URI'];
	$uri_1 = explode('?', $uri);
	$msg = $uri_1[1];
	include_once DIR_ROOT.'profile_dashboard.php';
}

if($id == 'calendar')
{
	include_once DIR_ROOT.'profile_calendar.php';
}

if($id == 'profile' )
{
	include_once DIR_ROOT.'profile.php';
}
if($id == 'InviteFriends' )
{
	include_once DIR_ROOT.'profile_invitefreinds.php';
}

if($id == 'accountsettings' )
{
	include_once DIR_ROOT.'profile_accountsettings.php';
}

$template->footer();
?>
