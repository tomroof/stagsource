<?php
/*********************************************************************************************
Author 	: V. V. VIJESH
Date	: 10-Nov-2011
Purpose	: Content page
*********************************************************************************************/


$content	= new content(1073);

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= functions::deformat_string('PageNotFound');
$template->meta_keywords	= functions::format_text_field('PageNotFound');
$template->meta_description	= functions::format_text_field('PageNotFound');
$template->js				= '';
$template->css				= '<link rel="stylesheet" href="'.URI_ROOT.'css/styles_content.css" type="text/css" media="screen">';
$template->right_menu		= true;
$template->heading();
?>

<div id="content" class="error-page">
 

    <div class="wrap ">
        <div class="main-content static-pages">


<div class="block-error">
	<!--<big>404 error</big>-->
	<!--<b>oops! the page you were<br> looking for isn't here.</b>-->
    <big><?php echo functions::deformat_string($content->title); ?></big>
    <b><?php echo functions::deformat_string($content->content); ?></b>
	<div class="block-error-bot">
		<p>Go back to the <a href="<?php echo URI_ROOT ?>">Homepage</a></p>
	</div>
</div>        </div>
    </div>


        </div>
        
<!--<section class="contentwrapper error-page">
	
	<div class="content_inner clearfix">
	
		
	here
	</div>
	
	</section>-->



<?php
$template->footer();
?>
