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
$template->css				= '<link rel="stylesheet" href="'.URI_ROOT.'css/styles_content.css" type="text/css" media="screen">';
$template->right_menu		= true;
$template->heading();


$member_id 		= (isset($_SESSION[MEMBER_ID])) ? $_SESSION[MEMBER_ID] : 0;
$member			= new member($member_id);

?>

<script >
$(document).ready(function(){
	
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


<section class="contentwrapper">
	
	
	
	
	<div id="content">
           

<div class="block-content-dark">
    <div class="details-main-block ">
        <div class="wrap">

               
        
        
         
        
       
        
        

            
        
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
            
            <div class="block-community_create">
           
                          <a style="cursor:pointer;" class="but-big but-red" data-reveal-id="topicBox" data-animation="fadeAndPop" id="community_create">Start a Topic</a>
                            </div>
            
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
                                           <!--  <label for="text-com">Write your comment here.</label> -->
                                            <textarea size="20"  maxlength="255" id="text-com" name="text-com" onfocus="clearText(this)" onblur="fillText(this)">Write your comment here.</textarea>
                                                                                        
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
        
        <?php $content->get_community_details($content->category_id); ?>
        
                    
        
        
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








