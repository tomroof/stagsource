<?php
/*********************************************************************************************
Author 	: V. V. VIJESH
Date	: 10-Nov-2011
Purpose	: Content page
*********************************************************************************************/


if(!isset($_SESSION[MEMBER_ID]))
{
	functions::redirect(URI_ROOT);
	exit;	
}

$member	= new member($_SESSION[MEMBER_ID]);


if($member->member_id == 0)
{
	functions::redirect(URI_ROOT);
	exit;
}
$cat_sel = $_POST['cat_sel'];
?>



<?php
$name 	= ucfirst(functions::deformat_string($member->first_name)) .' '. strtoupper(substr($member->last_name, 0, 1)) .'.';

?>

<section class="contentwrapper">
	
	<div class="content_inner clearfix">
	
	
	
	<section class="about_heading">
	<h2><span>CALENDAR</span></h2>
	</section>
	
	
	<?php include_once DIR_ROOT . 'inc_profile_left.php';  ?>
    
    	<section class="about_right">
	
	
    
    		<div style="text-align: center; font-size:12px;" >
                <a id="invitefriends" onclick="FacebookInviteFriends();" href="#">
                    <!--Invite 10 Clients and Receive a <span>One Year Free</span> Premium Membership!-->
                    INVITE FRIENDS
                </a>
            </div>
	
	
	
	</section>
    

	
	
	</div>
	
	</section>