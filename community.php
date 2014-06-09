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
								<link rel="stylesheet" type="text/css" href="'.URI_ROOT.'css/component.css" />
								<link rel="stylesheet" href="'.URI_ROOT.'css/styles_content.css" type="text/css" media="screen">';
$template->heading();


$content   = new content();

 $id 	= (isset($_REQUEST['id']) &&  $_REQUEST['id']) != '' ? $_REQUEST['id'] : '';
 $id		= str_replace('/', '', $id);
 $category_id 	= category::get_category_id_byname($id);

if($category_id == 0)
{
	//functions::redirect(URI_ROOT);
	//exit;	
}

$category 		= new category($category_id);


if($id == '') {
?>
    
    
    <div class="banner-block-wrap">
<img title="" alt="" src="images/pokernight.jpg">
    <div class="banner-block banner-block-slider-in">
        <div class="slider-wrap">
            <div id="slides">
                <div class="slides_container" style="display: block;">
                    <div class="slides_control"><div class="slide" style="">
                        <h1>Stagsource Community</h1>
                        <p>Got questions? Got info? Link up!</p>
                       
                    <a style="cursor:pointer;"  class="but-big but-red link-create-topic" data-reveal-id="topicBox" data-animation="fadeAndPop" id="community_create" >Start a Topic</a>
               </div></div>
                </div>
               <!-- <a class="prev" href="#" style="display: none;"><img width="20" height="34" alt="Arrow Prev" src="images/bg-arrow-sh-l.png"></a>
                <a class="next" href="#" style="display: none;"><img width="20" height="34" alt="Arrow Next" src="images/bg-arrow-sh-r.png"></a>-->
            </div>
        </div>
    </div>
</div>

<?php } ?>

	<section class="contentwrapper">
 
	<div class="content_inner">
		<div class="adbox">
        	<?php if($id =='') { ?>
            <h2><span>Featured</span></h2>
            <?php } else { ?>
            <h2><span><?php echo functions::deformat_string($category ->name);?></span></h2>
            <?php } ?>
		</div>
		
        <section class="product_box_outer">
		<ul class="grid effect-1 caption-style-2" id="grid">
        
			<?php
			
				$content->get_community_array($category_id);					
		?>
        
        </ul>
        
        
        
        <?php functions::paginateclient_article($content->num_rows, 1, $content->pager_param, 'CLIENT'); ?>
   
        
        
	  </section>
        


	</div>
	</section>

	<?php
		$template->footer();
	?>
    



	  <script src="js/masonry.pkgd.min.js"></script>
	  <script src="js/imagesloaded.js"></script>
	  <script src="js/AnimOnScroll.js"></script>
	  <script>
			new AnimOnScroll( document.getElementById( 'grid' ), {
				minDuration : 0.4,
				maxDuration : 0.7,
				viewportFactor : 0.2
			} );
			
			
			$(document).ready(function ()
			{
				
				$('#bachelorparty_btn, #wedding_btn').click(function(e) {
					e.preventDefault();
					var modalLocation = $(this).attr('data-reveal-id');
					$('#'+modalLocation).reveal($(this).data());
				});
			});
	
		</script>
