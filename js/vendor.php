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

if($content->status == 'N')
{
	//functions::redirect("under-construction.html");
	//exit;
}
else if($content->content_id == 0)
{
	//functions::redirect("page-not-found.html");
	//exit;
}




if( $content_id	 == 'index.html') //$content->content_id == 1 ||
{
	//functions::redirect("index.php");
	//exit;
}

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= functions::deformat_string($content->title);
$template->meta_keywords	= functions::format_text_field($content->meta_keywords);
$template->meta_description	= functions::format_text_field($content->meta_description);
$template->js				= '';
$template->css				= '<link rel="stylesheet" href="'.URI_ROOT.'css/styles_content.css" type="text/css" media="screen">';
$template->right_menu		= true;
$template->heading();
$member_id 		= (isset($_SESSION[MEMBER_ID])) ? $_SESSION[MEMBER_ID] : 0;
$member			= new member($member_id);

?>

<script >
$(document).ready(function(){
	$('#fan_but').click(function() {
		var member_id 		= '<?php echo $_SESSION[MEMBER_ID]; ?>';
		var content_id = $(this).attr('value'); 
		if(member_id == '')
		{
			<?php if(!isset($_COOKIE['remember'])) { ?>
				$('#username').val('');
				$('#password').val('');
			<?php } ?>	
			
			$('label.error').hide();
			$('.error').removeClass('error');
			$('#login_error').hide();
			$('#loginBox').reveal($(this).data());		
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				cache: false,
				url: "<?php echo URI_ROOT ?>ajax_fans.php?member_id="+member_id+"&content_id="+content_id,
				success: function (data)
				{
					//alert(data);
					$('#fan_like').html(data);
				}
			});
		}
		
	});
});


</script>




<section class="contentwrapper">
	
	
	
	
	<div id="content">
    
    <div class="block-content-gray">
    <div class="wrap">
        <div class="block-content-in celebrity-top-block">
            <div class="connect-block-all">
               
                <div class="connect-block" style="font-weight:bold;">
                     <b style="font-weight:bold;">Connect</b>
                    <ul class="f-share">
                    <?php
						$social_links  	= unserialize($content->social_links);
						
						if($social_links['web'] != '')
						{
							echo '<li class="web"><a href="'. $social_links['web']. '" target="_blank">&nbsp;</a></li>';	
						}
						
						if($social_links['fb'] != '')
						{
							echo '<li class="fb"><a href="'. $social_links['fb']. '" target="_blank">&nbsp;</a></li>';	
						}
						
						if($social_links['twitter'] != '')
						{
							echo '<li class="twitter"><a href="'. $social_links['twitter']. '" target="_blank">&nbsp;</a></li>';	
						}
						
						if($social_links['instagram'] != '')
						{
							echo '<li class="instagram"><a href="'. $social_links['instagram']. '" target="_blank">&nbsp;</a></li>';	
						}
						
						if($social_links['g-plus'] != '')
						{
							echo '<li class="g-plus"><a href="'. $social_links['g-plus']. '" target="_blank">&nbsp;</a></li>';	
						}
						
						if($social_links['youtube'] != '')
						{
							echo '<li class="youtube"><a href="'. $social_links['youtube']. '" target="_blank">&nbsp;</a></li>';	
						}
						
					?>
                     <!--   <li class="web"><a href="https://ardenreed.com/" target="_blank">&nbsp;</a></li>
                        <li class="fb"><a href="https://www.facebook.com/ardenreed" target="_blank">&nbsp;</a></li>
                        <li class="twitter"><a href="https://twitter.com/arden_reed" target="_blank">&nbsp;</a></li>-->
                    </ul> 
                </div>
                
                
                <div class="active" style="font-weight:bold;">
                     <a style="cursor:pointer;" class="but-big but-green" id="fan_but" value="<?php echo $content->content_id?>" >Be a fan!</a><span class="but-big box-fans" style="font-weight:bold;">
                     <b><span class="like-count" id="fan_like" style="font-weight:bold;"><?php echo content_like::get_fan_total($content->content_id); ?></span></b> Fans</span></div>
                
               </div>
            <div class="content-info-all">
                <div class="content-img">
                    <div class="content-in-img">
                    
                    <?php
						$image_name 		= $content->content_thumbnail;
						if(file_exists(DIR_CONTENT.$image_name) && $image_name != '')
						{	
							$size_1	= getimagesize(DIR_CONTENT.$image_name);
							$imageLib = new imageLib(DIR_CONTENT.$image_name);
							
								//$imageLib->resizeImage(250, 248, 0);	
							$imageLib->resizeImage(185, 278, 0);	
							
							$imageLib->saveImage(DIR_CONTENT.'thumb3_'.$image_name, 90);
							unset($imageLib);
							$img	= 'thumb3_'.$image_name;
						}
					?>
                        <a title=""> <img src="<?php echo URI_CONTENT. $img?>" alt=""></a>
                                            </div>
                </div>
                <div class="content-info" >
                    <h2 ><?php  echo functions::deformat_string($content->title) ?></h2>
                    <span style="font-weight:bold;"><?php  echo functions::deformat_string($content->content_sub_title) ?></span>
                </div>
                <?php  echo functions::deformat_string($content->content) ?>
            </div>
            
            
            <?php 
				
					$tag_array  = tag::get_content_tag($content->content_id);
					
					if(count($tag_array) > 0) { 
				?>
                       
      			<div class="block-tags">
                	<span style="font-weight:bold;">Tags</span>
               		
                     <?php 
						for($i =0 ; $i < count($tag_array); $i++)
						{  ?>
							<a href="<?php echo URI_ROOT ?>content/search/tag=<?php echo $tag_array[$i]->tag ?>"><?php echo $tag_array[$i]->tag ?></a>	
					<?php	}
					  ?>
                </div>
                <?php } ?>

                    </div>
    </div>
</div>
    
    
    
    

    <div class="wrap">
       <div class="main-content" style="overflow: visible;">
             <h2 style=""><span>FEATURED</span></h2>
             </div>
        <div class="content-block-all">
          <div class="row">
          
          
        
        <div id="yw0" class="list-view">
		<div class="items">
        
        <?php  $content->get_vendor_details($content->content_id); ?>
        
                    
        
        
        </div>
        
        <div class="pagination-block"></div>
        
				</div>

            </div>
        </div>
        
        
    </div>
    
    
</div>

   
	




<?php
$template->footer();
?>
