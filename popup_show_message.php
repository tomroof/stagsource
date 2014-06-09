<?php
/*********************************************************************************************
Date	: 28-March-2012
Purpose	: Content page
*********************************************************************************************/


if(!isset($_REQUEST['popup']))
{
	functions::redirect("page-not-found.html");
	exit;
}
$message = isset($_REQUEST['message']) && $_REQUEST['message'] != '' ? $_REQUEST['message'] : '';
?>
<div class="signup_now_conent"> 
<p align="center"  style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:16px; width:550px;">Thank You</p>
	<div class="guest_reviewitem">      
        <p align="center"><?php echo $message; ?></p>
    </div>
</div>