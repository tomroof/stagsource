<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= '';
$template->meta_keywords	= '';
$template->meta_description	= '';
$template->footer_content	= true;
$template->js				= '<script type="text/javascript" src="js/Slideshow.js" charset="utf-8"></script>';
$template->css				= '<link rel="stylesheet" type="text/css" href="css/Slideshow.css" />';
$template->heading();

$main_content = new page_content(1);

if ($main_content->status == 'Y'){
	$main_content_title = $main_content->title;
	$main_content_text  = $main_content->content;
}

?>



<div id="contentarea">
<div class="content_container">
<div class="contentbox">
<div class="content_lft">

<h1 class="hdrtxt botom_line"><?php echo functions::deformat_string($main_content_title); ?></h1>
		<?php echo functions::deformat_string($main_content_text); ?>
   
<?php
$input = array("Food", "Wineries");
$rand_keys =array_rand($input,1);
$rand =  $input[$rand_keys];
$rand=="Food";
if($rand=="Food")
{
	$food=new food();
	$food->display_featured_stall;
	
}
else if($rand=="Wineries")
{
	$wineries=new wineries();
	$wineries->display_featured_stall;
	
}



?>

		
		

<div class="featured_box">
<span class="featured-arrow"></span>
<span class="featured_lft_hdr">Featured Stall </span>
<div id='tmpSlideshow'>
<?php
$input = array("Food", "Wineries");
$rand_keys =array_rand($input,1);
$rand =  $input[$rand_keys];
$rand="Food";
if($rand=="Food")
{
	$food=new food();
	$food->display_featured_stall();
	
}
else if($rand=="Wineries")
{
	$wineries=new wineries();
	$wineries->display_featured_stall();;
	
}



?>

  </div>

</div>


</div>

<div class="content_rght">

<?php  include("inc_right_menu.php"); ?>

</div>
</div>

<?php include("inc_subscribe_box.php"); ?>

</div>
</div>



<?php
	include ('inc_footer.php');
?>

