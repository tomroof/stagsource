<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");
	$out = '';
 $member_id	= $_SESSION[MEMBER_ID]; 
 $message_id	= (isset($_REQUEST['message_id']) &&  $_REQUEST['message_id'] > 0) ? functions::clean_string($_REQUEST['message_id']) : 0;
 $message 		= new message($message_id);
 
 if(isset($_SESSION[MEMBER_ID]))
 {
 	if($message->read_status == 1 && $message->from_user_id != $member_id)
 	{
		$message->update_read_status($message_id, $member_id);
 	}
 }
 
 $message 		= new message($message_id);
 if($member_id == $message->to_user_id)
 {
	 $out = $message->from_user_id.'<>'.$message->title;
 }
 else
 {
	 $out = $message->from_user_id.'<>'.$message->title;
 }
 
 $mem = new member($message->from_user_id);
 $name_msg 	= functions::deformat_string($mem->first_name) .' '. functions::deformat_string($mem->last_name);
 $out .= '<><div class="img-mes">';
  if($mem->avatar != '')
  {
	  $out .='<a href="'.URI_ROOT.'user/PublicProfile/'.$mem->member_id.'"><img alt="" src="'.URI_MEMBER.'thumb2_'.$mem->avatar.'"></a> ';
  }
  else if($mem->fb_id != '')
  {
	  $out .='<a href="'.URI_ROOT.'user/PublicProfile/'.$mem->member_id.'"><img alt="" src="http://graph.facebook.com/'.$mem->fb_id.'/picture?type=large" ></a>';
  }
  else
  {
	  $out .='<a href="'.URI_ROOT.'user/PublicProfile/'.$mem->member_id.'"><img alt="" src="'.URI_ROOT.'images/profile_image.jpg"></a> ';
  }
	   // <img alt="" src="http://live.stagsource.com/avatar/Desert.jpg"></a> 
		
 $out .=' </div>
	<b><a href="'.URI_ROOT.'user/PublicProfile/'.$mem->member_id.'">'.$name_msg.'</a></b>';
                         
							

 $out .='<><b>'.strtoupper(functions::deformat_string($message->title)).'</b>
       <p>'.functions::deformat_string($message->content).'</p>';
 
 $out .='<><b>'. date('F d, Y', strtotime($message->date)).'</b>
       <p>'. date('h:i A', strtotime($message->date)).'</p>';
	   
 echo $out;
 exit;
 
?>