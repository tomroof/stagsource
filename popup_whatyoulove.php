<?php
/*********************************************************************************************
Date	: 28-March-2012
Purpose	: Content page
*********************************************************************************************/

include_once('includes/config.php');

if(!isset($_REQUEST['popup']))
{
	functions::redirect("page-not-found.html");
	exit;
}
$message = isset($_REQUEST['message']) && $_REQUEST['message'] != '' ? $_REQUEST['message'] : '';
$planning_id = isset($_REQUEST['planning_id']) && $_REQUEST['planning_id'] > 0 ? $_REQUEST['planning_id']: 0;

$planning	= new planning($planning_id);
?>
<div class="signup_now_conent">
   <p align="center"  style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:16px; width:600px;">What You'll Love</p>
	<div class="guest_reviewitem">      
        <p style=" font-size:14px; width:600px;"><?php echo nl2br(functions::deformat_string($planning->your_picks_description)) ?></p>
    </div>

</div>