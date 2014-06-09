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
								<link rel="stylesheet" type="text/css" href="'.URI_ROOT.'css/component.css" />';
$template->heading();
$content   = new content();

$id 		= (isset($_REQUEST['id']) &&  $_REQUEST['id']) != '' ? $_REQUEST['id'] : '';
$from 		= $_REQUEST['from'];

?>

	<section class="contentwrapper">
	<div class="content_inner">
		<div class="adbox">       
            
            <h2><span>SEARCH</h2>
   
		</div>
		
        <section class="product_box_outer">
		<ul class="grid effect-1 caption-style-2" id="grid">
        
			<?php
			
			if($id  == "")
			{
				$content->get_article_array();
			}
			else if($from == 'tag')
			{
				$content->get_tag_search_lists($id);
				//$content->get_article_array();
			}
			else
			{
				$content->get_search_list($id);
			}
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
