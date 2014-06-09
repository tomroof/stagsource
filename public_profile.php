<?php
/*********************************************************************************************
Author 	: V. V. VIJESH
Date	: 10-Nov-2011
Purpose	: Content page
*********************************************************************************************/
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

//$page_name = functions::get_page_name();


$member_id	= (isset($_REQUEST['id']) &&  $_REQUEST['id']) != '' ? $_REQUEST['id'] : '';
$member	= new member($member_id);

if(!isset($_SESSION[MEMBER_ID]))
{
	functions::redirect(URI_ROOT);
	exit;	
}

if($member->member_id == 0)
{
	functions::redirect(URI_ROOT);
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
								<link rel="stylesheet" href="'.URI_ROOT.'css/tab.css" />';
$template->right_menu		= true;
$template->heading();

?>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "e0ce4108-d273-4cdd-a512-5e481503e37b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
 
 
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false,  "ui_use_css":true };</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50a0cd6c4f80d325"></script> 

<script type="text/javascript">

$(document).ready(function() {

	//$(".tab_content").hide();
	$(".tab_content:first").show(); 

	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
});

</script>

<?php
  $name 	= ucfirst(functions::deformat_string($member->first_name)) .' '. strtoupper(substr($member->last_name, 0, 1)) .'.';
?>
<section class="contentwrapper">
	
	<div class="content_inner clearfix">
	
	
	
	<section class="about_heading">
	<h2><span><?php echo $name ?></span></h2>

	</section>
	
	
	<div class="profile_left">
	
	
	<div class="profile_box">
	<span class="profile_img">
      <?php if(file_exists(DIR_MEMBER . $member->avatar) && $member->avatar != '')
	  {
		  $image_name = $member->avatar;
		  $size_1	= getimagesize(DIR_MEMBER.$image_name);
		  $imageLib = new imageLib(DIR_MEMBER.$image_name);
		  $imageLib->resizeImage(84, 84, 0);	
		  $imageLib->saveImage(DIR_MEMBER.'thumb1_'.$image_name, 90);
		  unset($imageLib);
		  echo ' <img src="'.URI_MEMBER.'thumb1_'.$image_name.'">'; 
	  } 
	  else if($member->fb_id != '')
	  {
		echo '<img src="https://graph.facebook.com/'.$member->fb_id.'/picture" width="84px" >';  
	  }
	  else
	  {
		 echo ' <img src="'.URI_ROOT.'images/picture.jpg">'; 
	  }?>
    
   
    
    
    </span>
    <?php if($member->member_id == $_SESSION[MEMBER_ID]) { ?>
    	<a href="<?php echo URI_ROOT ?>user/profile"><span class="profile_but1">EDIT PROFILE</span></a>
    <?php } else { ?> 
		<a href="<?php echo URI_ROOT ?>user/addmessage?uid=<?php echo $member->member_id ?>"><span class="profile_but">MESSAGE</span></a>
    <?php }?>
    
	<span class="profile_name"><?php echo $name ?></span>
	</div>
	
	<?php 
	if($member->favorites_1 != '')
	{
		echo '<aside class="about_left">
        <div class="about_left_h1">Proposal Ideas</div>
        <div class="about_left_list">
        <div class="user_detl">'.functions::deformat_string($member->favorites_1).'</div>
        </div>
		</aside>';
	}
	
	if($member->favorites_2 != '')
	{
		echo '<aside class="about_left">
        <div class="about_left_h1">The Bachelor Party</div>
        <div class="about_left_list">
        <div class="user_detl">'.functions::deformat_string($member->favorites_2).'</div>
        </div>
		</aside>';
	}
	
	if($member->favorites_3 != '')
	{
		echo '<aside class="about_left">
        <div class="about_left_h1">Wedding Locations</div>
        <div class="about_left_list">
        <div class="user_detl">'.functions::deformat_string($member->favorites_3).'</div>
        </div>
		</aside>';
	}
	
	if($member->favorites_4 != '')
	{
		echo '<aside class="about_left">
        <div class="about_left_h1">The Honeymoon</div>
        <div class="about_left_list">
        <div class="user_detl">'.functions::deformat_string($member->favorites_4).'</div>
        </div>
		</aside>';
	}
	?>
	
	</div>
	
	
	
	<section class="profil_right">
	
	<div id="container">

    <ul class="tabs"> 
        <li class="active" rel="tab1">Comments</li>
		<li rel="tab2">Favorites</li>
    </ul>
    
    <div class="tab_container"> 

    <div id="tab1" class="tab_content">  
    <div class="tab_inner">
	
		<div class="line"></div>
        
        <?php $comment_array = content_comment::get_profile_comments($member->member_id); 
		if(count($comment_array) > 0)
		{
			for($i=0; $i < count($comment_array); $i++)
			{
			?>
            	<div class="profil_rghtrow">
		
                <div class="profil_rght_sm">
                    <a href="<?php echo URI_ROOT?>user/PublicProfile/<?php echo $member->member_id?>"><span class="profil_sm_round">
                     <?php if($member->avatar != '')
							{
								echo '<img alt="" src="'.URI_MEMBER.'thumb1_'.$member->avatar.'">';
							}
							else
							{
								echo '<img src="'.URI_ROOT.'images/profile_img.png">';
							}
							 ?>
                    <!--<img src="<?php echo  URI_ROOT ?>images/profile_img.png">--></span></a>
                    <span class="profil_sm_h1"><?php echo $name ?></span>
                </div>
		
		<div class="profil_inner">
		<span class="profile_inner_arow"></span>
		<div class="profile_qut">
		<span class="profile_qut_img"><img src="<?php echo  URI_ROOT ?>images/profl_quotes.png"></span>
        
		<span class="profile_qut_text"><a href="<?php echo URI_ROOT?>user/PublicProfile/<?php echo $member->member_id?>"><strong><?php echo $name?> wrote:</strong></a> 
          <?php echo nl2br(functions::deformat_string($comment_array[$i]->comment));?>
         </span>
		</div>
        
        <div class="block-comment-bot">
        
            <p><?php echo date('m/d/Y', strtotime($comment_array[$i]->created_at)) ?> at  <?php echo date('h:i A', strtotime($comment_array[$i]->created_at)) ?></p>
            <div class="block-comment-bot-in">
            
                <div class="activity-block share">
                                    
                    <div class="count">
                        <span><a class="addthis_counter addthis_bubble_style" layout="button_count"></a></span>
                    </div>
                    
                    <a class="share-btn addthis_button"></a>
                   
                </div>
            </div>
                            <div class="block-comment-bot-in">
                             <div class="active activity-block heart"><div class="count"><span class="like-count" id="cmnt_like_<?php echo $comment_array[$i]->content_comment_id ?>"><?php echo content_like::get_comment_like_total($comment_array[$i]->content_comment_id, 'like'); ?></span></div>
                             <a style="cursor:pointer;" class="comment3" id="like_<?php echo $comment_array[$i]->content_comment_id ?>"></a>
                             
                             </div>                           
                            </div>
                            <div class="block-comment-bot-in"> 
                            
                                <div class="active activity-block plus"><div class="count"><span class="like-count" id="cmnt_favorite_<?php echo $comment_array[$i]->content_comment_id ?>"><?php echo content_like::get_comment_like_total($comment_array[$i]->content_comment_id, 'favorite'); ?></span></div>
                                <a style="cursor:pointer;" class="fav3" id="favorite_<?php echo $comment_array[$i]->content_comment_id ?>"></a>
                                </div> 
                                                           
                            </div>
                        </div>

            </div>
            
            </div>
            <?php	
			}
		}
		else
		{
			echo '<span class="empty">No results found.</span>';	
		}
		?>
	
		
    </div>
    </div>
    
    
    <div id="tab2" class="tab_content">
 	<div class="tab_inner">
	<div class="line"></div>
	
    <?php 
	
		$favorite_array = content_like::get_profile_favorites($member->member_id); 
	    if(count($favorite_array) > 0)
		{
			//print_r($favorite_array);
			for($i = 0; $i < count($favorite_array); $i++)
			{
				if($favorite_array[$i]->model_name == 'Contents')
				{
					$content = new content($favorite_array[$i]->content_id);
					$dec   =  (strlen(strip_tags($content->content)) > 40) ? $content->title. '...': strip_tags($content->content);	
				}
				else
				{
					$content_comment = new content_comment($favorite_array[$i]->content_id);
					$dec   =  $content_comment->comment;	
					$content		 = new content($content_comment->content_id);
				}
				
				
				if($content->content_id == '' || $content->content_id == 0) continue;
				
				if($content->content_type == 'community')
				{
					$url = 	URI_ROOT.'community/contents/'.$content->seo_url1;
				}
				else if($content->content_type == 'vendor')
				{
					$url = 	URI_ROOT.'vendor/'.$content->seo_url1;
				}
				else
				{
					$url = 	URI_ROOT.'contents/'.$content->seo_url1;
				}
				
			?>
               <div class="profil_rghtrow">
		
                    <div class="profil_rght_sm">
                    <span class="profil_sm_round">
                     <?php if($member->avatar != '')
							{
								echo '<img alt="" src="'.URI_MEMBER.'thumb1_'.$member->avatar.'">';
							}
							else
							{
								echo '<img src="'.URI_ROOT.'images/profile_img.png">';
							}
							 ?>
                   <!-- <img src="<?php echo URI_ROOT ?>images/profile_img.png">--></span>
                    <span class="profil_sm_h1"><?php echo $name ?></span>
                    </div>
                    
                    <div class="profil_inner">
                    <span class="profile_inner_arow"></span>
                    
                    <div class="profile_add">
                    <a href="#"><strong><?php echo $name ?></strong></a> added <a href="<?php echo $url ?>" class="profile_add_colr"><?php echo functions::deformat_string($content->title)?></a> to Favorites
                    </div>
                    
                    <div class="profile_qut">
                    <span class="profile_qut_img"><img src="<?php echo URI_ROOT ?>images/profl_quotes.png"></span>
                    <span class="profile_qut_text"><?php echo functions::deformat_string($dec) ?></span>
                    </div>
                    
                    <div class="block-comment-bot">
                        <p><?php echo date('m/d/Y', strtotime($favorite_array[$i]->created_at)) ?> at  <?php echo date('h:i A', strtotime($favorite_array[$i]->created_at)) ?></p>
                    	<div class="block-comment-bot-in">
                             <div class="active activity-block heart"><div class="count"><span class="like-count" id="cnt_like_<?php echo $content->content_id ?>"><?php echo content_like::get_like_total($content->content_id, 'like'); ?></span></div>
                             <a style="cursor:pointer;" class="comment1" id="like_<?php echo $content->content_id ?>"></a>
                             
                             </div>                           
                            </div>
                            <div class="block-comment-bot-in"> 
                            
                                <div class="active activity-block plus"><div class="count"><span class="like-count" id="cnt_favorite_<?php echo $content->content_id ?>"><?php echo content_like::get_like_total($content->content_id, 'favorite'); ?></span></div>
                                <a style="cursor:pointer;" class="fav1" id="favorite_<?php echo $content->content_id ?>"></a>
                                </div> 
                                                           
                            </div>
                    </div>
                    
                    </div>
		
				</div>
            <?php
			}
		}
		else
		{
			echo '<span class="empty">No results found.</span>';
		}
    ?>
    
    
     
    </div>
    </div>
	
	 
    
    
    
    
    
    

	</div>
	</div>
	
	
	</section>
	
	
	
	
	
	</div>
	
	</section>


<?php
$template->footer();
?>
