<?php
/*********************************************************************************************
Author 	: V. V. VIJESH
Date	: 10-Nov-2011
Purpose	: Content page
*********************************************************************************************/
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

$content_id	= (isset($_REQUEST['id']) &&  $_REQUEST['id']) != '' ? $_REQUEST['id'] : '';

$content	= new content($content_id);

if($content_id == 'PageNotFound')
{
	//functions::redirect(URI_ROOT.'pagenotfound.php');
	include_once(DIR_ROOT. 'pagenotfound.php');
	exit;	
}

if($content_id == 'page-not-found.html')
{
	functions::redirect(URI_ROOT."page/PageNotFound");
	exit;	
}

if($content->status == 'N')
{
	functions::redirect(URI_ROOT."page/under-construction.html");
	exit;
}
else if($content->content_id == 0)
{
	functions::redirect(URI_ROOT."page/page-not-found.html");
	exit;
}

if( $content_id	 == 'index.html') //$content->content_id == 1 ||
{
	functions::redirect(URI_ROOT."index.php");
	exit;
}

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= functions::deformat_string($content->title);
$template->meta_keywords	= functions::format_text_field($content->meta_keywords);
$template->meta_description	= functions::format_text_field($content->meta_description);
$template->js				= '';
$template->css				= '';
$template->right_menu		= true;
$template->heading();
?>

<section class="contentwrapper">
	
	<div class="content_inner clearfix">
	
	<div class="adbox" style="height:40px !important;">
            <h2><span><?php  echo functions::deformat_string($content->title) ?></span></h2>
		</div>
	
	<!--<section class="about_heading">
	<h1>About</h1>
	</section>-->
	
	
	
	<aside class="about_left">
	<div class="about_left_h1">Dashboard</div>
	
	<div class="about_left_list">
	<ul>
	<a href="<?php echo URI_ROOT ?>page/about"><li <?php echo ($content_id == 'about' || $content_id == 'about.html') ? 'class="active_colr"': ''; ?>>ABOUT</li></a>
	<a href="<?php echo URI_ROOT ?>page/who-we-are"><li <?php echo ($content_id == 'who-we-are' || $content_id == 'who-we-are.html') ? 'class="active_colr"': ''; ?>> WHO WE ARE</li></a>
	<a href="<?php echo URI_ROOT ?>page/terms-and-conditions"><li <?php echo ($content_id == 'terms-and-conditions' || $content_id == 'terms-and-conditions.html') ? 'class="active_colr"': ''; ?>> TERMS AND CONDITIONS </li></a>
	<a href="<?php echo URI_ROOT ?>page/privacy-policy"><li <?php echo ($content_id == 'privacy-policy' || $content_id == 'privacy-policy.html') ? 'class="active_colr"': ''; ?>> PRIVACY POLICY</li></a>
	<a href="<?php echo URI_ROOT ?>page/contact_us"><li <?php echo ($content_id == 'contact_us' || $content_id == 'contact_us.html') ? 'class="active_colr"': ''; ?>> CONTACT US</li></a>
	<a href="<?php echo URI_ROOT ?>page/advertise-on-stagsource"><li <?php echo ($content_id == 'advertise-on-stagsource' || $content_id == 'advertise-on-stagsource.html') ? 'class="active_colr"': ''; ?>> ADVERTISE ON STAGSOURCE</li></a>
	</ul>
	</div>
	
	</aside>
	
	
	
	<section class="about_right">
	 <?php  echo $content->content ?>
	<!--<p>
	Stagsource was founded in the summer of 2013 when Tristan grew frustrated with the lack of wedding planning material geared towards men on the web.
	
	<br /><br />
	Stagsource is revolutionizing the way guys plan for their bachelor party, wedding, and honeymoon. We are diligently working around the clock to bring you the best experience known to man when it comes to wedding planning and more will be revealed soon. In the meantime, please enjoy our curated content that we put together just for you!
	
	<br /><br />
	
	Thanks for visiting!
	
	</p>-->
	
	
	
	
	</section>
	
	
	
	
	
	</div>
	
	</section>


<!--<section class="contentwrapper">
	<div class="content_inner">
		<div class="adbox">
            <h2><span><?php  echo functions::deformat_string($content->title) ?></span></h2>
		</div>
        <div class="wrap">
        <div class="content-in">
            
        
            <div class="center">
                <div class="center-in block-contact">
                    <?php  echo $content->content ?>
                </div>
            </div>
        </div>
      </div>

	</div>
	</section>-->


<?php
$template->footer();
?>
