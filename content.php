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
$template->css				= '<link rel="stylesheet" href="'.URI_ROOT.'css/styles_content.css" type="text/css" media="screen">
								';
$template->right_menu		= true;
$template->heading();

$member_id 		= (isset($_SESSION[MEMBER_ID])) ? $_SESSION[MEMBER_ID] : 0;
$member			= new member($member_id);

?>

<script defer src="<?php echo URI_ROOT ?>js/jquery.flexslider.js"></script>
<link rel="stylesheet" href="<?php echo URI_ROOT ?>css/flexslider.css" type="text/css" media="screen">
<script >

$(document).ready(function(){
	// The slider being synced must be initialized first
	$('#carousel2').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: true,
    itemWidth: 84,
    itemMargin: 6,
	
    asNavFor: '#slider2'
  });
   
  $('#slider2').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: true,
    sync: "#carousel2"
  });
});



function validate_comment()
{
	var comments = $('#text-com').val();

	
	if(comments == "" || comments == "Write your comment here.")
	{
		$('#comment_error').html('Comment cannot be blank');	
		$('#comment_error').show();
		return false;
	}
	else
	{
		$('#comment_error').hide();
		$.ajax(
			{
				type: "POST",
				cache: false,
				url: "<?php echo URI_ROOT ?>ajax_content_comment.php",
				data: $('#comments-form').serialize(),
				success: function (data)
				{
					window.location.reload(true);
				}
			});
	}
	return false;
}
</script>


<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "e0ce4108-d273-4cdd-a512-5e481503e37b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
 
 
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false,  "ui_use_css":true };</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50a0cd6c4f80d325"></script> 
<style>
    .picture-poll-block-big .img-wrap:hover {border-color: #802483;}
    .picture-poll-block-big .img-wrap.active:hover {border-color: #fff;}
</style>
   
    
    <section class="contentwrapper">
	
	
	
	
	<div id="content">
           


<?php $res	= $content->get_article_slider_array($content->content_id);
	 $current  = array_search($content->content_id, $res);
	 if($current >= 0 )
	 {
		 if($current == 0)
		 {
			$prev_id =  $content->get_previous_article($content->content_id); 
			if(count($res) > $current)
		 	{
			    $next_id = $res[$current+1];
			}
			else
			{
				$next_id = $content->get_next_article($content->content_id);
			}
		 }
		 else 
		 {
			 if(count($res) > ($current+1))
		 	 {
				$prev_id = $res[$current-1];
			    $next_id = $res[$current+1];			
			 } 
			 else
			 {
				 $next_id = $content->get_next_article($content->content_id);
				 $prev_id = $res[$current-1];
			 }
		 }
	 }
	 else
	 {
		 $prev_id =  $content->get_previous_article($content->content_id);
		 $next_id = $content->get_next_article($content->content_id);
	 }
  
     if($prev_id == $next_id )
	 {
		$next_id = $content->get_next_article($next_id); 
	 }
	 
	 if($prev_id == 0)
	 {
		 $prev_id = 989; 
	 }
	 
	 if($next_id == 0)
	 {
		$next_id = 989; 
	 }
	 
 ?>


<?php 
	$content_prev 	= new content($prev_id);
	$content_next 	= new content($next_id);

	$prev_calss = 	 $content->class_array[$content_prev->content_type]; 
	$current_calss = $content->class_array[$content->content_type];
	$next_calss = 	 $content->class_array[$content_next->content_type];
?>

<div class="block-content-dark">
    <div class="details-main-block ">
        <div class="wrap">

            <div class="content-block <?php echo $prev_calss ?>">
            <?php 
            /*if(file_exists(DIR_CONTENT. $content_prev->content_thumbnail) && $content_prev->content_thumbnail != '') { 
					  	 	$image_name = $content_prev->content_thumbnail;
							$size_1	= getimagesize(DIR_CONTENT.$image_name);
							$imageLib = new imageLib(DIR_CONTENT.$image_name);
							$imageLib->resizeImage(508, 508, 0);	
							$imageLib->saveImage(DIR_CONTENT.'thumb2_'.$image_name, 90);
							unset($imageLib);
			}*/
            
             //$prev_id = $content->get_previous_article($content->content_id);
			    
				$title2    = (strlen($content_prev->title)>24) ? substr($content_prev->title,0, 24).'...': $content_prev->title;
				$member2	= new member($content_prev->content_author);
				$desc2     = (strlen(strip_tags($content_prev->content))>112) ? substr(strip_tags($content_prev->content),0, 112).'...': strip_tags($content_prev->content); 
			 ?>
              <!--<div class="content-block-wrap">
                    <div class="img-wrap">
                        <a href="" title="">
                        <?php if(file_exists(DIR_CONTENT. $content_prev->content_thumbnail) && $content_prev->content_thumbnail != '') { ?>
                            <img src="<?php echo URI_CONTENT. $content_prev->content_thumbnail?>" alt=""> 
                        <?php  } else { ?>
                        <div class="content-block answer-block-big">
                    		 <?php echo $content_prev->content_answer; ?>                   
                        </div>
                        <?php } ?>
                        </a>
                    </div>
                    <div class="bot-block">
                        <div class="bot-block-in1">
                            <a href="" title=""><?php echo functions::deformat_string($title2) ?></a>
                        </div>
                        <div class="bot-block-in2">
                            <p><?php echo functions::deformat_string($member2->first_name) .' '. strtoupper(substr($member2->last_name, 0, 1)) ?></p>
                            <p><?php echo date('m.d.Y', strtotime($content_prev->created_date)) ?></p>
                        </div>
                    </div>
                
                </div>-->
                
                
                                                      <?php 
					  
					  if(file_exists(DIR_CONTENT. $content_prev->content_thumbnail) && $content_prev->content_thumbnail != '') { 
					  	 	$image_name = $content_prev->content_thumbnail;
							$size_1	= getimagesize(DIR_CONTENT.$image_name);
							$imageLib = new imageLib(DIR_CONTENT.$image_name);
							$imageLib->resizeImage(508, 508, 0);	
							$imageLib->saveImage(DIR_CONTENT.'thumb2_'.$image_name, 90);
							unset($imageLib);
					  }
					  
	
							
							if($content_prev->content_type == 'poll')
							{
								echo functions::deformat_string($content_prev->title);
								
								$poll_array  	= content_poll_item::get_poll_result($content_prev->content_id);
								
								if(count($poll_array) > 0)
								{
									for($i=0; $i< count($poll_array); $i++)
									{
										$coutn += $poll_array[$i]->vote_count;	
									}
									
									for($i=0; $i< count($poll_array); $i++)
									{
										$percentage = 0;
										if($poll_array[$i]->vote_count > 0 && $coutn > 0)
										{
											$percentage = round((100/$coutn)*$poll_array[$i]->vote_count, 2);
										}
										
										
										//$percentage = 10/$poll_array[$i]->vote_count;
										echo '<div class="line">
                                			  <span class="label">'.functions::deformat_string($poll_array[$i]->title).'</span>
                                			  <span class="content-block-item-progress">
                                   				 <span class="progress-percent progress-full">'.$percentage.' %</span>
                                    			<span style="width:'.$percentage.'%" class="progress"></span>
                                			  </span>
                            				  </div>';	
									}
								}
								 //<!--<input type="hidden" id="poll_model_id" name="poll[model_id]" value="1003">
                                //<input type="hidden" id="poll_return_url" name="poll[return_url]">-->	
							}
							
							if($content_prev->content_type == 'picture_poll')
							{ 
								$poll_array  	= content_poll_item::get_poll_result($content_prev->content_id);
								
								echo '<div class="content-block-wrap">';
								echo '<p class="ttl">'.functions::deformat_string($content_prev->title).'</p>';
							
								//<form method="post" action="/contents/1055/Vegas-Or-Miami-" id="poll" class="poll_class_1055_"><input type="hidden" id="poll_model_id" name="poll[model_id]" value="1055"><input type="hidden" id="poll_return_url" name="poll[return_url]" value="/contents/1055/Vegas-Or-Miami-">
								//<input type="hidden" id="poll_old_poll_item_id" name="poll[old_poll_item_id]" value="4476">
							    if(count($poll_array) > 0)
								{
									for($i=0; $i< count($poll_array); $i++)
									{
										$coutn += $poll_array[$i]->vote_count;	
									}
									
									for($i=0; $i< count($poll_array); $i++)
									{
										$percentage = 0;
										if($poll_array[$i]->vote_count > 0 && $coutn > 0)
										{
											$percentage = round((100/$coutn)*$poll_array[$i]->vote_count, 2);
										}
										
										$img = '';
										$image_name = $poll_array[$i]->image_name;
										if(file_exists(DIR_POLL_ITEM. $image_name) && $image_name != '') { 
											if(file_exists(DIR_POLL_ITEM. 'thumb_'.$image_name))
											{
												$img = 'thumb_'.$image_name;
											}
											else
											{
												
												$size_1	= getimagesize(DIR_POLL_ITEM.$image_name);
												$imageLib = new imageLib(DIR_POLL_ITEM.$image_name);
												$imageLib->resizeImage(POLL_ITEM_THUMB_WIDTH, POLL_ITEM_THUMB_HEIGHT, 0);	
												$imageLib->saveImage(DIR_POLL_ITEM.'thumb1_'.$image_name, 90);
												unset($imageLib);
												$img = 'thumb1_'.$image_name;
											}
									   }
										
										
										if($i ==0 || $i%2 == 0)
										{
											echo '<div class="f-left ">
												<div class="img-wrap  ">
													<img alt="" src="'.URI_POLL_ITEM.$img.'">
												</div>
												<p>'.functions::deformat_string($poll_array[$i]->title).'</p>
												<span class="content-block-item-progress">
													<span class="progress-percent progress-full">'.$percentage.' %</span>
													<span style="width:'.$percentage.'%" class="progress"></span>
												</span>
											</div>';	
										}
										else
										{
											echo '<div class="f-left f-left-2">
													<div class="img-wrap  ">
														<img alt="" src="'. URI_POLL_ITEM.$img.'">
													</div>
													<p>'.functions::deformat_string($poll_array[$i]->title).'</p>
													<span class="content-block-item-progress">
														<span class="progress-percent progress-full">'.$percentage.' %</span>
														<span style="width:'.$percentage.'%" class="progress"></span>
													</span>
												</div>';	
										}
											
									}
								}
								
								//</form>
								echo '</div>';
							} 
							
							if(	$content_prev->content_type == 'question_answer' || $content_prev->content_type == 'quote')
							{
								if($content_prev->content_type == 'question_answer')
								{
									echo functions::deformat_string($content_prev->content_answer); 	
									echo '<p class="author"> - '.functions::deformat_string($member2->first_name) ." ". substr($member2->last_name, 0, 1).'.</p>';
								}
								else
								{
									echo '<p>'.functions::deformat_string($content_prev->title).'</p>';
									echo '<p class="author"> - '.functions::deformat_string($content_prev->quote_author).'</p>';
								}
							}
							
							if(	$content_prev->content_type == 'video')
							{
								echo '<div class="video-block-in">';
								echo '<div class="video-block-in">
                        				<a title="" href="'. URI_ROOT.'contents/'.$content_prev->seo_url1.'">
										'.$content_prev->content_video_embed .'</a>
                    				  </div>';
								echo '</div>';
								
                    			echo '<div class="video-block-bot">
										<a href="'. URI_ROOT.'contents/'.$content_prev->seo_url1.'">'.functions::deformat_string($titl2e).'</a>
									</div> ';
							}
							
							if($content_prev->content_type == 'image' || $content_prev->content_type == 'article' || $content_prev->content_type == 'product')
							{
								if($content_prev->content_type == 'product')
								{
									echo '<div class="content-block-wrap">';
								}
								
								echo  '<div class="img-wrap">';
								if(file_exists(DIR_CONTENT. $content_prev->content_thumbnail) && $content_prev->content_thumbnail != '') {
									echo '<img src="'. URI_CONTENT. 'thumb2_'.$content_prev->content_thumbnail.'" alt="">';
								}
								echo '</div>';	
								
								if($content_prev->content_type == 'article' || $content_prev->content_type == 'product')
								{
									echo '<div class="bot-block">';
									
									if($content_prev->content_type == 'article')
									{
                        					echo '<div class="bot-block-in1" >'.functions::deformat_string($title2).'</div>
                       					 	<div class="bot-block-in2">
                           						
                            					<p>'.functions::deformat_string($member2->first_name) ." ". functions::deformat_string($member2->last_name).'</p>
                           						<p> '.date("m.d.Y", strtotime($content_prev->created_date)) .'</p>
                       						</div>';
									}
									if($content_prev->content_type == 'product')
									{
										echo '<b><a title="" href="'. URI_ROOT.'contents/'.$content_prev->seo_url1.'">'.functions::deformat_string($title2).'</a></b>';
											echo (!is_null($content_prev->product_price)) ? '<div class="price-product">$'.$content_prev->product_price.'</div>': '';
											echo ($desc2 != '') ? '<p>'.$desc2.'</p>': '';
									}
									
                    				echo '</div>';
								}
								
								if($content_prev->content_type == 'product')
								{
									if($content_prev->content_source != '')
									{
										//echo '<a href="'.$content_next->content_source.'" target="_blank" class="but-big but-green">Buy now</a>';
									}
									echo '</div>';
								}
							}
					
							if($content_prev->content_type == 'slideshow_album') {
								$slider_images 			= content_gallery::get_slider_images($content_prev->content_id);	
								
								if(count($slider_images) > 0)
								{
									echo '<div id="slider2" class="flexslider-slideshow">';
									echo '<ul class="slides">';
									for($i =0 ; $i < count($slider_images); $i++)
									{
										echo ' <li><img src="'.URI_CONTENT_GALLERY.$slider_images[$i].'" /></li>';
									}
									echo '</ul>';
									
									echo '</div>
                    						<div id="carousel2" class="flexslider-slideshow carousel">';
									
									echo '<ul class="slides">';
									for($i =0 ; $i < count($slider_images); $i++)
									{
										echo ' <li><img src="'.URI_CONTENT_GALLERY.$slider_images[$i].'" /></li>';
									}
									echo '</ul>';
									echo '</div>';
								}
										
							}
					if($content_prev->content_is_premium == 'Y' && $content_prev->premium_color ==  1) { 
						echo '<div class="premium"></div>';
					}
					else if($content_prev->content_is_premium == 'Y')
					{
                    	echo '<div class="premium-white"></div>';
					}
					
					?>
                
                
                
                
                 
        </div>   
        
         <?php  //$next_id = $content->get_next_article($content->content_id);
			    
				$title1    = (strlen($content_next->title)>24) ? substr($content_next->title,0, 24).'...': $content_next->title;
				$member1	= new member($content_next->content_author);
				 $desc1     = (strlen(strip_tags($content_next->content))>112) ? substr(strip_tags($content_next->content),0, 112).'...': strip_tags($content_next->content); 
			 ?>
             
        
        <?php $title    = (strlen($content->title)>46) ? substr($content->title,0, 46).'...': $content->title; 
			  $desc     = (strlen(strip_tags($content->content))>112) ? substr(strip_tags($content->content),0, 112).'...': strip_tags($content->content); 
			  $member	= new member($content->content_author);
		?>         
        
        <div class="center-content-block">
            <a id="prev-sh" href="<?php echo URI_ROOT.'contents/'.$content_prev->seo_url1 ?>" class="" style="display: block;"></a>
        
            <div class="content-block <?php echo $current_calss ?>">
                  
                   	 
                      <?php 
					  
					  if(file_exists(DIR_CONTENT. $content->content_thumbnail) && $content->content_thumbnail != '') { 
					  	 	$image_name = $content->content_thumbnail;
							$size_1	= getimagesize(DIR_CONTENT.$image_name);
							$imageLib = new imageLib(DIR_CONTENT.$image_name);
							$imageLib->resizeImage(508, 508, 0);	
							$imageLib->saveImage(DIR_CONTENT.'thumb2_'.$image_name, 90);
							unset($imageLib);
					  }
					  
	
							
							if($content->content_type == 'poll')
							{
								echo functions::deformat_string($content->title);
								
								$poll_array  	= content_poll_item::get_poll_result($content->content_id);
								
								if(count($poll_array) > 0)
								{
									for($i=0; $i< count($poll_array); $i++)
									{
										$coutn += $poll_array[$i]->vote_count;	
									}
									
									for($i=0; $i< count($poll_array); $i++)
									{
										$percentage = 0;
										if($poll_array[$i]->vote_count > 0 && $coutn > 0)
										{
											$percentage = round((100/$coutn)*$poll_array[$i]->vote_count, 2);
										}
										
										
										//$percentage = 10/$poll_array[$i]->vote_count;
										echo '<div class="line">
                                			  <span class="label">'.functions::deformat_string($poll_array[$i]->title).'</span>
                                			  <span class="content-block-item-progress">
                                   				 <span class="progress-percent progress-full">'.$percentage.' %</span>
                                    			<span style="width:'.$percentage.'%" class="progress"></span>
                                			  </span>
                            				  </div>';	
									}
								}
								 //<!--<input type="hidden" id="poll_model_id" name="poll[model_id]" value="1003">
                                //<input type="hidden" id="poll_return_url" name="poll[return_url]">-->	
							}
							
							if($content->content_type == 'picture_poll')
							{ 
								$poll_array  	= content_poll_item::get_poll_result($content->content_id);
								
								echo '<div class="content-block-wrap">';
								echo '<p class="ttl">'.functions::deformat_string($content->title).'</p>';
							
								//<form method="post" action="/contents/1055/Vegas-Or-Miami-" id="poll" class="poll_class_1055_"><input type="hidden" id="poll_model_id" name="poll[model_id]" value="1055"><input type="hidden" id="poll_return_url" name="poll[return_url]" value="/contents/1055/Vegas-Or-Miami-">
								//<input type="hidden" id="poll_old_poll_item_id" name="poll[old_poll_item_id]" value="4476">
							    if(count($poll_array) > 0)
								{
									for($i=0; $i< count($poll_array); $i++)
									{
										$coutn += $poll_array[$i]->vote_count;	
									}
									
									for($i=0; $i< count($poll_array); $i++)
									{
										$percentage = 0;
										if($poll_array[$i]->vote_count > 0 && $coutn > 0)
										{
											$percentage = round((100/$coutn)*$poll_array[$i]->vote_count, 2);
										}
										
										$img = '';
										$image_name = $poll_array[$i]->image_name;
										if(file_exists(DIR_POLL_ITEM. $image_name) && $image_name != '') { 
											if(file_exists(DIR_POLL_ITEM. 'thumb_'.$image_name))
											{
												$img = 'thumb_'.$image_name;
											}
											else
											{
												
												$size_1	= getimagesize(DIR_POLL_ITEM.$image_name);
												$imageLib = new imageLib(DIR_POLL_ITEM.$image_name);
												$imageLib->resizeImage(POLL_ITEM_THUMB_WIDTH, POLL_ITEM_THUMB_HEIGHT, 0);	
												$imageLib->saveImage(DIR_POLL_ITEM.'thumb1_'.$image_name, 90);
												unset($imageLib);
												$img = 'thumb1_'.$image_name;
											}
									   }
										
										
										if($i ==0 || $i%2 == 0)
										{
											echo '<div class="f-left ">
												<div class="img-wrap  ">
													<img alt="" src="'.URI_POLL_ITEM.$img.'">
												</div>
												<p>'.functions::deformat_string($poll_array[$i]->title).'</p>
												<span class="content-block-item-progress">
													<span class="progress-percent progress-full">'.$percentage.' %</span>
													<span style="width:'.$percentage.'%" class="progress"></span>
												</span>
											</div>';	
										}
										else
										{
											echo '<div class="f-left f-left-2">
													<div class="img-wrap  ">
														<img alt="" src="'. URI_POLL_ITEM.$img.'">
													</div>
													<p>'.functions::deformat_string($poll_array[$i]->title).'</p>
													<span class="content-block-item-progress">
														<span class="progress-percent progress-full">'.$percentage.' %</span>
														<span style="width:'.$percentage.'%" class="progress"></span>
													</span>
												</div>';	
										}
											
									}
								}
								
								//</form>
								echo '</div>';
							} 
							
							if(	$content->content_type == 'question_answer' || $content->content_type == 'quote')
							{
								if($content->content_type == 'question_answer')
								{
									echo functions::deformat_string($content->content_answer); 	
									echo '<p class="author"> - '.functions::deformat_string($member->first_name) ." ". substr($member->last_name, 0, 1).'.</p>';
								}
								else
								{
									echo '<p>'.functions::deformat_string($content->title).'</p>';
									echo '<p class="author"> - '.functions::deformat_string($content->quote_author).'</p>';
								}
							}
							
							if(	$content->content_type == 'video')
							{
								echo '<div class="video-block-in">';
								echo '<div class="video-block-in">
                        				<a title="" href="'. URI_ROOT.'contents/'.$content->seo_url1.'">
										'.$content->content_video_embed .'</a>
                    				  </div>';
								echo '</div>';
								
                    			echo '<div class="video-block-bot">
										<a href="'. URI_ROOT.'contents/'.$content->seo_url1.'">'.functions::deformat_string($title).'</a>
									</div> ';
							}
							
							if($content->content_type == 'image' || $content->content_type == 'article' || $content->content_type == 'product')
							{
								if($content->content_type == 'product')
								{
									echo '<div class="content-block-wrap">';
								}
								
								echo  '<div class="img-wrap">';
								if(file_exists(DIR_CONTENT. $content->content_thumbnail) && $content->content_thumbnail != '') {
									echo '<img src="'. URI_CONTENT. 'thumb2_'.$content->content_thumbnail.'" alt="">';
								}
								echo '</div>';	
								
								if($content->content_type == 'article' || $content->content_type == 'product')
								{
									echo '<div class="bot-block">';
									
									if($content->content_type == 'article')
									{
                        					echo '<div class="bot-block-in1" >'.functions::deformat_string($title).'</div>
                       					 	<div class="bot-block-in2">
                           						
                            					<p>'.functions::deformat_string($member->first_name) ." ". functions::deformat_string($member->last_name).'</p>
                           						<p> '.date("m.d.Y", strtotime($content->created_date)) .'</p>
                       						</div>';
									}
									if($content->content_type == 'product')
									{
										echo '<b><a title="" href="'. URI_ROOT.'contents/'.$content->seo_url1.'">'.functions::deformat_string($title).'</a></b>';
											echo (!is_null($content->product_price)) ? '<div class="price-product">$'.$content->product_price.'</div>': '';
											echo ($desc != '') ? '<p>'.$desc.'</p>': '';
									}
									
                    				echo '</div>';
								}
								
								if($content->content_type == 'product')
								{
									if($content->content_source != '')
									{
										echo '<a href="'.$content->content_source.'" target="_blank" class="but-big but-green">Buy now</a>';
									}
									echo '</div>';
								}
							}
					
							if($content->content_type == 'slideshow_album') {
								$slider_images 			= content_gallery::get_slider_images($content->content_id);	
								
								if(count($slider_images) > 0)
								{
									echo '<div id="slider2" class="flexslider-slideshow">';
									echo '<ul class="slides">';
									for($i =0 ; $i < count($slider_images); $i++)
									{
										echo ' <li><img src="'.URI_CONTENT_GALLERY.$slider_images[$i].'" /></li>';
									}
									echo '</ul>';
									
									echo '</div>
                    						<div id="carousel2" class="flexslider-slideshow carousel">';
									
									echo '<ul class="slides">';
									for($i =0 ; $i < count($slider_images); $i++)
									{
										echo ' <li><img src="'.URI_CONTENT_GALLERY.$slider_images[$i].'" /></li>';
									}
									echo '</ul>';
									echo '</div>';
								}
										
							}
					?> 
                  
                    <?php if($content->content_is_premium == 'Y' && $content->premium_color ==  1) { 
						echo '<div class="premium"></div>';
					}
					else if($content->content_is_premium == 'Y')
					{
                    	echo '<div class="premium-white"></div>';
					} ?>
            </div>

            <a id="next-sh" href="<?php echo URI_ROOT.'contents/'.$content_next->seo_url1 ?>" class="" style="display: block;"></a>
       </div>

            <div class="content-block <?php echo $next_calss ?>">
                <!--<div class="content-block-wrap">
                    <div class="img-wrap">
                        <a href="<?php echo URI_ROOT.'contents/'.$content_next->seo_url1 ?>" title="">
                        
                        	<?php if(file_exists(DIR_CONTENT. $content_next->content_thumbnail) && $content_next->content_thumbnail != '') { ?>
                        
                            <img src="<?php echo URI_CONTENT. $content_next->content_thumbnail?>" alt=""> 
                            
                            <?php } else { ?>
                        		<div class="content-block answer-block-big">
                    		 <?php echo $content_next->content_answer; ?>                   
                        </div>
                        <?php } ?>
                                   </a>
                    </div>
                    <div class="bot-block">
                        <div class="bot-block-in1"><a href="<?php echo URI_ROOT.'contents/'.$content_next->seo_url1 ?>" title=""><?php echo functions::deformat_string($title1) ?></a></div>
                        <div class="bot-block-in2">
                            <p><?php echo functions::deformat_string($member1->first_name) .' '. strtoupper(substr($member1->last_name, 0, 1)) ?></p>
                            <p><?php echo date('m.d.Y', strtotime($content_next->created_date)) ?></p>
                        </div>
                    </div>
                </div>-->
    
                
                                      <?php 
					  
					  if(file_exists(DIR_CONTENT. $content_next->content_thumbnail) && $content_next->content_thumbnail != '') { 
					  	 	$image_name = $content_next->content_thumbnail;
							$size_1	= getimagesize(DIR_CONTENT.$image_name);
							$imageLib = new imageLib(DIR_CONTENT.$image_name);
							$imageLib->resizeImage(508, 508, 0);	
							$imageLib->saveImage(DIR_CONTENT.'thumb2_'.$image_name, 90);
							unset($imageLib);
					  }
					  
	
							
							if($content_next->content_type == 'poll')
							{
								echo functions::deformat_string($content_next->title);
								
								$poll_array  	= content_poll_item::get_poll_result($content_next->content_id);
								
								if(count($poll_array) > 0)
								{
									for($i=0; $i< count($poll_array); $i++)
									{
										$coutn += $poll_array[$i]->vote_count;	
									}
									
									for($i=0; $i< count($poll_array); $i++)
									{
										$percentage = 0;
										if($poll_array[$i]->vote_count > 0 && $coutn > 0)
										{
											$percentage = round((100/$coutn)*$poll_array[$i]->vote_count, 2);
										}
										
										
										//$percentage = 10/$poll_array[$i]->vote_count;
										echo '<div class="line">
                                			  <span class="label">'.functions::deformat_string($poll_array[$i]->title).'</span>
                                			  <span class="content-block-item-progress">
                                   				 <span class="progress-percent progress-full">'.$percentage.' %</span>
                                    			<span style="width:'.$percentage.'%" class="progress"></span>
                                			  </span>
                            				  </div>';	
									}
								}
								 //<!--<input type="hidden" id="poll_model_id" name="poll[model_id]" value="1003">
                                //<input type="hidden" id="poll_return_url" name="poll[return_url]">-->	
							}
							
							if($content_next->content_type == 'picture_poll')
							{ 
								$poll_array  	= content_poll_item::get_poll_result($content_next->content_id);
								
								echo '<div class="content-block-wrap">';
								echo '<p class="ttl">'.functions::deformat_string($content_next->title).'</p>';
							
								//<form method="post" action="/contents/1055/Vegas-Or-Miami-" id="poll" class="poll_class_1055_"><input type="hidden" id="poll_model_id" name="poll[model_id]" value="1055"><input type="hidden" id="poll_return_url" name="poll[return_url]" value="/contents/1055/Vegas-Or-Miami-">
								//<input type="hidden" id="poll_old_poll_item_id" name="poll[old_poll_item_id]" value="4476">
							    if(count($poll_array) > 0)
								{
									for($i=0; $i< count($poll_array); $i++)
									{
										$coutn += $poll_array[$i]->vote_count;	
									}
									
									for($i=0; $i< count($poll_array); $i++)
									{
										$percentage = 0;
										if($poll_array[$i]->vote_count > 0 && $coutn > 0)
										{
											$percentage = round((100/$coutn)*$poll_array[$i]->vote_count, 2);
										}
										
										$img = '';
										$image_name = $poll_array[$i]->image_name;
										if(file_exists(DIR_POLL_ITEM. $image_name) && $image_name != '') { 
											if(file_exists(DIR_POLL_ITEM. 'thumb_'.$image_name))
											{
												$img = 'thumb_'.$image_name;
											}
											else
											{
												
												$size_1	= getimagesize(DIR_POLL_ITEM.$image_name);
												$imageLib = new imageLib(DIR_POLL_ITEM.$image_name);
												$imageLib->resizeImage(POLL_ITEM_THUMB_WIDTH, POLL_ITEM_THUMB_HEIGHT, 0);	
												$imageLib->saveImage(DIR_POLL_ITEM.'thumb1_'.$image_name, 90);
												unset($imageLib);
												$img = 'thumb1_'.$image_name;
											}
									   }
										
										
										if($i ==0 || $i%2 == 0)
										{
											echo '<div class="f-left ">
												<div class="img-wrap  ">
													<img alt="" src="'.URI_POLL_ITEM.$img.'">
												</div>
												<p>'.functions::deformat_string($poll_array[$i]->title).'</p>
												<span class="content-block-item-progress">
													<span class="progress-percent progress-full">'.$percentage.' %</span>
													<span style="width:'.$percentage.'%" class="progress"></span>
												</span>
											</div>';	
										}
										else
										{
											echo '<div class="f-left f-left-2">
													<div class="img-wrap  ">
														<img alt="" src="'. URI_POLL_ITEM.$img.'">
													</div>
													<p>'.functions::deformat_string($poll_array[$i]->title).'</p>
													<span class="content-block-item-progress">
														<span class="progress-percent progress-full">'.$percentage.' %</span>
														<span style="width:'.$percentage.'%" class="progress"></span>
													</span>
												</div>';	
										}
											
									}
								}
								
								//</form>
								echo '</div>';
							} 
							
							if(	$content_next->content_type == 'question_answer' || $content_next->content_type == 'quote')
							{
								if($content_next->content_type == 'question_answer')
								{
									echo functions::deformat_string($content_next->content_answer); 	
									echo '<p class="author"> - '.functions::deformat_string($member1->first_name) ." ". substr($member1->last_name, 0, 1).'.</p>';
								}
								else
								{
									echo '<p>'.functions::deformat_string($content_next->title).'</p>';
									echo '<p class="author"> - '.functions::deformat_string($content_next->quote_author).'</p>';
								}
							}
							
							if(	$content_next->content_type == 'video')
							{
								echo '<div class="video-block-in">';
								echo '<div class="video-block-in">
                        				<a title="" href="'. URI_ROOT.'contents/'.$content_next->seo_url1.'">
										'.$content_next->content_video_embed .'</a>
                    				  </div>';
								echo '</div>';
								
                    			echo '<div class="video-block-bot">
										<a href="'. URI_ROOT.'contents/'.$content_next->seo_url1.'">'.functions::deformat_string($title).'</a>
									</div> ';
							}
							
							if($content_next->content_type == 'image' || $content_next->content_type == 'article' || $content_next->content_type == 'product')
							{
								if($content_next->content_type == 'product')
								{
									echo '<div class="content-block-wrap">';
								}
								
								echo  '<div class="img-wrap">';
								if(file_exists(DIR_CONTENT. $content_next->content_thumbnail) && $content_next->content_thumbnail != '') {
									echo '<img src="'. URI_CONTENT. 'thumb2_'.$content_next->content_thumbnail.'" alt="">';
								}
								echo '</div>';	
								
								if($content_next->content_type == 'article' || $content_next->content_type == 'product')
								{
									echo '<div class="bot-block">';
									
									if($content_next->content_type == 'article')
									{
                        					echo '<div class="bot-block-in1" >'.functions::deformat_string($title1).'</div>
                       					 	<div class="bot-block-in2">
                           						
                            					<p>'.functions::deformat_string($member1->first_name) ." ". functions::deformat_string($member1->last_name).'</p>
                           						<p> '.date("m.d.Y", strtotime($content_next->created_date)) .'</p>
                       						</div>';
									}
									if($content_next->content_type == 'product')
									{
										echo '<b><a title="" href="'. URI_ROOT.'contents/'.$content_next->seo_url1.'">'.functions::deformat_string($title1).'</a></b>';
											echo (!is_null($content_next->product_price)) ? '<div class="price-product">$'.$content_next->product_price.'</div>': '';
											echo ($desc1 != '') ? '<p>'.$desc1.'</p>': '';
									}
									
                    				echo '</div>';
								}
								
								if($content_next->content_type == 'product')
								{
									if($content_next->content_source != '')
									{
										//echo '<a href="'.$content_next->content_source.'" target="_blank" class="but-big but-green">Buy now</a>';
									}
									echo '</div>';
								}
							}
					
							if($content_next->content_type == 'slideshow_album') {
								$slider_images 			= content_gallery::get_slider_images($content_next->content_id);	
								
								if(count($slider_images) > 0)
								{
									echo '<div id="slider2" class="flexslider-slideshow">';
									echo '<ul class="slides">';
									for($i =0 ; $i < count($slider_images); $i++)
									{
										echo ' <li><img src="'.URI_CONTENT_GALLERY.$slider_images[$i].'" /></li>';
									}
									echo '</ul>';
									
									echo '</div>
                    						<div id="carousel2" class="flexslider-slideshow carousel">';
									
									echo '<ul class="slides">';
									for($i =0 ; $i < count($slider_images); $i++)
									{
										echo ' <li><img src="'.URI_CONTENT_GALLERY.$slider_images[$i].'" /></li>';
									}
									echo '</ul>';
									echo '</div>';
								}
										
							}
					?> 
                  
                    <?php if($content_next->content_is_premium == 'Y' && $content_next->premium_color ==  1) { 
						echo '<div class="premium"></div>';
					}
					else if($content_next->content_is_premium == 'Y')
					{
                    	echo '<div class="premium-white"></div>';
					} ?>
                    
                
        </div>
        
        </div>
    </div>
    <div class="bg-black">&nbsp;</div>
</div>


<div class="block-content-dark" style="overflow: visible;">
    <div class="wrap">
        <div class="main-content" style="overflow: visible;">
             <h2 style=""><span><?php  echo functions::deformat_string($content->title) ?></span></h2>
            <div class="content-block-all content-block-details">
                
				<?php  echo $content->content;
				
					$tag_array  = tag::get_content_tag($content->content_id);
					
					if(count($tag_array) > 0) { 
				?>
                       
      			<div class="block-tags" style="color: #48525C; text-transform: uppercase;"><span>Tags:</span>
               		 <!--<a href="<?php echo URI_ROOT ?>contents/content/search/tag=advice">ADVICE</a>-->
                     <?php 
					 	//print_r($tag_array);
						for($i =0 ; $i < count($tag_array); $i++)
						{  ?>
							<a href="<?php echo URI_ROOT ?>content/search/tag=<?php echo $tag_array[$i]->tag ?>"><?php echo $tag_array[$i]->tag ?></a>	
					<?php	}
					  ?>
                </div>
                <?php } ?>
            </div>
            <div class="content-block-details-bot">
               
                <div class="activity-block share">
                
   
   


    <div class="count">
     <span><a class="addthis_counter addthis_bubble_style" layout="button_count"></a></span>
        
    </div>
   
 	<a class="share-btn addthis_button"></a>
 </div>
 
 
<!--<div class="fav" id="favorite_<?php echo $content->content_id ?>">
     <?php echo content_like::get_like_total($content->content_id, 'favorite'); ?>
</div>-->
 
                <div class="active activity-block heart " >
                 <div class="count"><span class="like-count" id="cnt_like_<?php echo $content->content_id ?>"> <?php echo content_like::get_like_total($content->content_id, 'like'); ?></span></div><a style="cursor:pointer;" class="comment1" id="like_<?php echo $content->content_id ?>"></a></div> 
                
                <div class="active activity-block plus" >
                <div class="count"><span class="like-count" id="cnt_favorite_<?php echo $content->content_id ?>"><?php echo content_like::get_like_total($content->content_id, 'favorite'); ?></span></div>
                <a style="cursor:pointer;" class="fav1" id="favorite_<?php echo $content->content_id ?>"></a></div>
                  
                
                
      <div class="impression-block-soc">
      
      <span class='st_facebook_hcount' displayText='Facebook'   ></span>
          <span class='st_twitter_hcount' displayText='Tweet' ></span>
          <span class='st_email_custom' displayText='Email'> <img alt="" src="<?php echo URI_ROOT ?>images/mail-icon.png"></span> 
          <span class='st_fblike_hcount' displayText='Facebook Like'> </span> 
         <!-- <span><a class="addthis_button_facebook_like st_fblike_hcount" fb:like:layout="button_count"></a></span>-->

	</div>    



        </div>
            <div class="clear">&nbsp;</div>
        </div>
    </div>
</div>

 
<div class="block-content-light">
    <div class="wrap">
        <div class="block-content-in">
			<?php if(!isset($_SESSION[MEMBER_ID])) { ?>
           <span class="span_comment_sign_up">TO LEAVE A COMMENT, <a style="cursor:pointer;" class="link_comment_sign_up" id="login_btn"  data-reveal-id="signupBox" data-animation="fadeAndPop">SIGN UP</a> NOW</span>
           <?php }  else { ?>
           		
               <div class="block-comment block-comment-white block-comment-write">
                        <form autocomplete="off" class="add_comment_form" id="comments-form" name="comments-form" action="" method="post">
                        
                            <table cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="block-comment-img">
                                        <div class="photo-avatar">
                                        <?php if($member->fb_id != '') { ?>
                                      
                                            <img src="http://graph.facebook.com/<?php echo $member->fb_id ?>/picture?type=large" alt="">   
                                            
                                            <!--<div class="comment" id="like_<?php echo $content->content_id ?>">
                                            <?php //echo content_like::get_like_total($content->content_id, 'like'); ?>
                                        </div>-->
                                       <!-- <div class="fav" id="favorite_<?php echo $content->content_id ?>">
                                            <?php //echo content_like::get_like_total($content->content_id, 'favorite'); ?>
                                        </div>-->
                                          
                                        <?php } else {
											if(file_exists(DIR_MEMBER.$member->image_name)) { ?>
                                            	
                                            <?php } else { ?>
                                            
                                      			<img src="http://graph.facebook.com/<?php echo $member->fb_id ?>/picture?type=large" alt="">     
                                        
                                        <?php  }
										} ?>
                                        </div>
                                        <b><?php echo functions::deformat_string($member->first_name) .' '. strtoupper(substr($member->last_name, 0, 1)).'.' ?></b>
                                                                            </div>
                                </td>
                                <td>
                                    <div class="block-comment-gray">
                                        <span class="block-comment-arrow"> &nbsp; </span>

                                        <p class="label text-3">
                                           <!-- <label for="text-com">Write your comment here.</label>-->
                                            <textarea size="20" maxlength="255" id="text-com" name="text-com" onfocus="clearText(this)" onblur="fillText(this)" >Write your comment here.</textarea>
                                                                                        
                                            <button class="but-big but-red" onclick="return validate_comment()">Submit</button>
                                            
                                        </p><span class="cmnt_error" id="comment_error" style="display:none;" ></span>
                                                                            </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        
                        <input type="hidden" name="content_id" id="content_id" value="<?php echo $content->content_id ?>" />
                        <input type="hidden" name="save" id="save" value="save" />
                        <input type="hidden" name="member_id" id="member_id" value="<?php echo $_SESSION[MEMBER_ID]?>" />
                        
                        </form>                   
                         </div> 
                
           <?php } 
		   
		   if(content_comment::get_comment_total($content->content_id) > 0 && isset($_SESSION[MEMBER_ID]) && $member->member_id > 0)
		   {
		   	   ?>
           
           
                <div class="items">
                	<?php content_comment::get_comments($content->content_id) ?>
                </div>
                
                <!--<div class="block-comment block-comment-white">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="block-comment-img">
                                        <div class="photo-avatar">
                                            <a href="/user/publicProfile/339"><img src="http://graph.facebook.com/100006489162389/picture?type=large" alt=""></a>                       				 </div>
                         <b><?php echo functions::deformat_string($member->first_name) .' '. strtoupper(substr($member->last_name, 0, 1)).'.' ?></b>
                </div>
                                </td>
                                <td>
                                    <div class="block-comment-gray">
                                        <span class="block-comment-arrow"> &nbsp; </span>
                                        <div class="block-comment-center">
                                            <blockquote>
                                                <span>
                                                    <a href="/user/publicProfile/339">Rainend&nbsp;D.</a> wrote:
                                                </span>
                                                ffdfdf                            </blockquote>
                                        </div>
                                        <div class="block-comment-bot">
                                            <p>05/20/2014 at  02:49 AM</p>
                                                                            <div class="activity-block">
                
                                                </div>
                                       <div class="block-comment-bot-in">
                                                <div class="activity-block share">
                                                    
                                                    <div class="count">
     													<span><a class="addthis_counter addthis_bubble_style" layout="button_count"></a></span>
                                                    </div>
                                                    
                                                    <a class="share-btn addthis_button"></a>
                                                    
                                                   
                                                </div>
                                            </div>
                                            <div class="block-comment-bot-in">
                                                <div class="active activity-block heart" ><div class="count"><span class="like-count"><?php echo content_like::get_like_total($content->content_id, 'favorite'); ?></span></div><a href="javascript:void(0)"></a></div>                            </div>
                
                                            <div class="block-comment-bot-in">
                                                <div class="active activity-block plus fav1" ><div class="count"><span class="like-count"><?php echo content_like::get_like_total($content->content_id, 'like'); ?></span></div><a href="javascript:void(0)"></a></div>                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                </div>-->

		<?php } ?>
         
       </div>   
  
    
</div>

</div>


<div class="block-content-dark">
    <div class="wrap">
       
        <div class="content-block-all">
          <div class="row">
          
          
        
        <div id="yw0" class="list-view">
		<div class="items">
        
         <?php $content->get_article_details($content->category_id); ?>
        
        </div>
        
</div>

            </div>
        </div>
        
        
    </div>
</div>

        </div>
	

	</section>


<?php
$template->footer();
?>


