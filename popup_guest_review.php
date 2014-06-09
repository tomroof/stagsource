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

?>
<div class="signup_now_conent">
   <p align="center"  style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:16px; width:600px;">Guest Reviews</p>
	<div class="guest_reviewitem">      
        <?php planning_rating::get_reviews($planning_id, 0, true); ?>
    </div>

</div>