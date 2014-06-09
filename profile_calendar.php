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
    
    <div class="calendar_right">
                <div class="c1" style="padding-left:0px;">
                                    
                
                                    <iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showCalendars=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=stagsource.com_43ne4oqk5lb80t24nqgofgojoo%40group.calendar.google.com&amp;color=%232F6309&amp;ctz=America%2FNew_York" style=" border-width:0 " width="740" height="600" frameborder="0" scrolling="no"></iframe>
                                    

                </div>
     </div>
     
     	</div>
	
	</section>