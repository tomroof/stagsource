<?php
ob_start("ob_gzhandler");
session_start();

include_once("includes/config.php");

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= 'Stagsource';
$template->meta_keywords	= 'Stagsource';
$template->meta_description	= 'Stagsource';
$template->footer_content	= true;
$template->js				= '<script type="text/javascript" src="'.URI_LIBRARY.'select/jquery.selectbox-0.2.js"></script>
								<script type="text/javascript" src="'.URI_LIBRARY.'select/functions.js"></script>';
$template->css				= ' <link href="'.URI_ROOT.'css/hover_content.css" rel="stylesheet" type="text/css"/>
								<link href="'.URI_LIBRARY.'select/jquery.selectbox.css" type="text/css" rel="stylesheet"/>
								<link rel="stylesheet" type="text/css" href="css/component.css" />';
$template->heading();
$content   = new content();

$id 	= (isset($_REQUEST['id']) &&  $_REQUEST['id']) != '' ? $_REQUEST['id'] : '';
$id		= str_replace('/', '', $id);
$category_id 	= category::get_category_id_byname($id);

if($category_id == 0)
{
	functions::redirect(URI_ROOT);
	exit;	
}

$category 		= new category($category_id);

?>

	<section class="contentwrapper">
	<div class="content_inner">
		<div class="adbox">
			<!--<div class="ad1">
				<img src="<?php echo URI_ROOT ?>images/ad1.png" width="100%" height="auto">
               
			</div>-->
            
            <!--<div class="ad1">
				<h3 style="text-align:center; vertical-align:middle; font-size:48px; color:#FFF; padding-top:15px;"><?php echo strtoupper(functions::deformat_string($category ->name));?></h3>
			</div>-->
            
            
            <h2><span><?php echo functions::deformat_string($category ->name);?></span></h2>
             
			<!--<div class="filter">
				<select name="type_annonce" class="ordinnary_text_form" id="2">
					<option value="%">Filter Items By Type</option>
					<option value="1">Sample New</option>
					<option value="2">Sample old</option>
					<option value="3">Sample New</option>
				</select>
			</div>-->
		</div>
		
        <section class="product_box_outer">
		<ul class="grid effect-1 caption-style-2" id="grid">
        
			<?php
			
				$content->get_article_array($category_id);
					
		?>
        
        </ul>
        
        
        
        <?php 
		
		functions::paginateclient_article($content->num_rows, 1, $content->pager_param, 'CLIENT'); ?>
        	<!--<a href="#"><div class="pagination_left"><img src="images/pagination_arrow_left.jpg" width="22" height="11"></div></a>
     		<ul>
            	<a href="#"><li class="paginationactive">1</li></a>
                <a href="#"><li>2</li></a>
                <a href="#"><li>3</li></a>
                <a href="#"><li>4</li></a>
                <a href="#"><li>5</li></a>
            </ul>
            <a href="#"> <div class="pagination_right"><img src="images/pagination_arrow_right.jpg" width="22" height="11"></div></a>-->

        
        
	  </section>
        


	</div>
	</section>

	<?php
		$template->footer();
	?>
    
	  <script src="<?php echo URI_ROOT ?>js/masonry.pkgd.min.js"></script>
	  <script src="<?php echo URI_ROOT ?>js/imagesloaded.js"></script>
	  <script src="<?php echo URI_ROOT ?>js/AnimOnScroll.js"></script>
	  <script>
			new AnimOnScroll( document.getElementById( 'grid' ), {
				minDuration : 0.4,
				maxDuration : 0.7,
				viewportFactor : 0.2
			} );
			
			
			$(document).ready(function ()
			{
				
			});
	
		</script>
