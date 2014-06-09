<?php
/*********************************************************************************************
Author 	: V. V. VIJESH
Date	: 10-Nov-2011
Purpose	: Content page
*********************************************************************************************/


if(!isset($_SESSION[MEMBER_ID]))
{
	functions::redirect(URI_ROOT);
	exit;	
}

$member	= new member($_SESSION[MEMBER_ID]);

if($member->member_id == 0)
{
	functions::redirect(URI_ROOT);
	exit;
}

$cat_sel = $_POST['cat_sel'];
$view_sel = $_POST['view_sel'];

$name 	= ucfirst(functions::deformat_string($member->first_name)) .' '. strtoupper(substr($member->last_name, 0, 1)) .'.'; 
?>

<script type="text/javascript" src="<?php echo URI_LIBRARY ?>customSelect/jquery.customSelect.js"></script>

<script>
/*$(function(){
	$('select').not('#demo-select_2').CustomSelect();
	$('#demo-select_2').CustomSelect({visRows:10, search:true, modifier: 'mod'});
});*/

jQuery.validator.addMethod("valueNotEquals", function(value, element, params) {
    return this.optional(element) || (value != params[0]);
}, "Please specify a value that is not equal to {0}");

$(document).ready( function()
{
	$('#demo-select_1').customSelect();
	$('#demo-select_3').customSelect();
	
	var uid	= '<?php echo $uid ?>';
	var msg	= '<?php echo $msg ?>';
	if(uid > 0)
	{
		$("ul.tabs li").removeClass("active");
		$('#tab5').addClass('active');
		$('#tab5').css('display', 'block');
		$('#tab1').css('display', 'none');
	}
	
	if(msg == 'msg')
	{
		$("ul.tabs li").removeClass("active");
		$('li[rel="tab3"]').addClass('active');
		$('#tab3').css('display', 'block');
		$('#tab1').css('display', 'none');
	}
	
	$('#demo-select_1').change(function()
	{
		var select_id = $(this).val();
		$('#recent_form').submit();
		
	});
	
	$('#demo-select_3').change(function()
	{
		var select_id = $(this).val();
		$('#message_form').submit();
	});
	
	$("#frm_message1").validate({		
		rules: {
			subject_message: "required",
			content_message: { valueNotEquals: ["Write your message here.",""] }
		},
		messages: {
			subject_message : "Subject is required",
			content_message : { valueNotEquals: "Content is required" }
		},
		showErrors: function (errorMap, errorList) {
   			this.defaultShowErrors();
    		$.each(errorList, function (i, error) {
				$('label.error').css("padding-left", ".0em");
    		});
		}		
	});
	
});

function validate_message()
{
	if($("#frm_message1").valid())
	{
		return true;
	}
	else
	{	
		return false;
	}
}

function load_message(message_id)
{
	$("ul.tabs li").removeClass("active");
	$('#tab5').addClass('active');
	$('#tab5').css('display', 'block');
	$('#tab3').css('display', 'none');
	
	$('#user_msg').hide();
	
	$.ajax(
	{
		type: "POST",
		cache: false,
		url: "<?php echo URI_ROOT ?>ajax_read_message.php?message_id="+message_id,
		success: function (data)
		{
			//alert(data);
			var row = data.split('<>');
			$('#user_to').val(row[0]);
			$('#subject_message').val(row[1]);
			$('#messages_list_div1').show();
			$('#m_user').html(row[2]);
			$('#m_content').html(row[3]);
			$('#m_time').html(row[4]);
		}
	});
	
	
}
</script>

<style type="text/css">
span.customSelect {
	font-size:11px;
	background: url("<?php echo URI_ROOT ?>images/sel-3-bg.png") no-repeat scroll right 0 #E2E2E2;
	color: #AAAAAA;
	padding:8px 7px;
	border:1px solid #BABABA ;
	border-bottom:none;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px 5px;
	 font-family: 'Helvetica Neue';
	 font-size:13px;
	 font-weight:bold; letter-spacing:1px;
	 width:120px !important;
	 height:12px !important;
}
.hasCustomSelect option {padding:2px 5px; font-weight:bold;}
span.customSelect.changed {
	background-color: #f0dea4;
}
.customSelectInner {
	background:url(customSelect-arrow.gif) no-repeat center right;
}
  
</style>

<?php
if(isset($_POST['save_message']))
{
	$message1				 = new message();
	$message1->message_id    = 0;
	$message1->title    	 = functions::clean_string($_REQUEST['subject_message']);
	$message1->content    	 = functions::clean_string($_REQUEST['content_message']);
	$message1->from_user_id  = $_SESSION[MEMBER_ID];
	$message1->to_user_id	 = functions::clean_string($_REQUEST['user_to']);
	$validation		= new validation();
	$validation->check_blank($message1->title, "Subject", "subject_message");
	$validation->check_blank($message1->content, "Message", "content_message");
	
	if (!$validation->checkErrors())
	{
		if($message1->save())
		{
			$mesg1 = $message1->message;
			functions::redirect(URI_ROOT.'user/RecentActivity?msg');
		}
		else
		{
			$mesg_error1 = $message1->message;
		}
	}
	else
	{
		$message1->error	= $validation->getallerrors();
	}
}


?>




<section class="contentwrapper">
	
	<div class="content_inner clearfix">
	
	
	
	<section class="about_heading">
	<h2><span>MY DASHBOARD</span></h2>
	</section>
	
	
	<?php include_once DIR_ROOT . 'inc_profile_left.php'; ?>
	
	
	
	<section class="profil_right">
	
	<div id="container">

    <ul class="tabs"> 
        <li class="active" rel="tab1"> Recent Activity</li>
        <li rel="tab2">Comments (<?php echo content_comment::get_comment_total_by_member($member->member_id) ?>)</li>
		<li rel="tab3">Messaging (<?php echo message::get_message_notread($member->member_id) ?>)</li>
		<li rel="tab4">Favorites (<?php echo content_like::get_favorite_total($member->member_id) ?>)</li>
    </ul>
    
    <div class="tab_container"> 

    <div id="tab1" class="tab_content">  
    <div class="tab_inner">

	
	<span class="catgry">CATEGORY:</span>
	    <form name="recent_from" id="recent_form" action="<?php echo URI_ROOT ?>user/profile/RecentActivity" method="post" >
		<select name="cat_sel" id="demo-select_1">
                <optgroup label="">
                <option value="1" <?php echo ($cat_sel == 0 || $cat_sel ==1) ? 'selected': '' ?>>All</option>
                <option value="2" <?php echo ($cat_sel == 2) ? 'selected': '' ?>>Topic</option>
                <option value="3" <?php echo ($cat_sel == 3) ? 'selected': '' ?>>Favorites</option>
                <option value="4" <?php echo ($cat_sel == 4) ? 'selected': '' ?>>Comments</option>
                </optgroup>
        
        </select>
        </form>
		
		<div class="line"></div>
        
        
        <?php $recent 	= $member->recent_activity($cat_sel); 
		
			//print_r($recent);
			if(count($recent) > 0)
			{   $cur = '';
				for($i =0; $i< count($recent); $i++)
				{
					if($recent[$i]->type == 'Contents' || $recent[$i]->type == 'ContentComments')
					{
						if($recent[$i]->type == 'Contents')
						{
							$content = new content($recent[$i]->id);
							if($content->content_excerpt != '')
							{
								$dec   =  (strlen(strip_tags($content->content_excerpt)) > 40) ? $content->content_excerpt. '...': strip_tags($content->content_excerpt);	
							}
							else
							{
								$dec   =  (strlen(strip_tags($content->content)) > 40) ? $content->title. '...': strip_tags($content->content);	
							}
						}
						else
						{
							$content_comment = new content_comment($recent[$i]->id);
							$content		 = new content($content_comment->content_id);
							if($content->content_excerpt != '')
							{
								$dec   =  (strlen(strip_tags($content->content_excerpt)) > 40) ? $content->content_excerpt. '...': strip_tags($content->content_excerpt);
							}
							else
							{
								$dec   =  (strlen(strip_tags($content->content)) > 40) ? $content->title. '...': strip_tags($content->content);	
							}
						}
						if($content->content_id == '' || $content->content_id == 0) continue;
						if($cur == $content->content_id) continue;
						$cur = $content->content_id;
				
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
                           <a href="<?php echo URI_ROOT?>user/PublicProfile/<?php echo $member->member_id?>">
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
                            
                            
                           <!-- <img src="<?php echo  URI_ROOT ?>images/profile_img.png">--></span> </a>
                            <span class="profil_sm_h1"><?php echo $name ?></span>
                            </div>
                            
                            <div class="profil_inner">
                            <span class="profile_inner_arow"></span>
                                <div class="profile_add">
                                <a href="<?php echo URI_ROOT?>user/PublicProfile/<?php echo $member->member_id?>"><strong><?php echo $name ?></strong></a>  added <a href="<?php echo $url ?>" class="profile_add_colr"><?php echo functions::deformat_string($content->title)?></a> to Favorites
                                </div>
                                
                                <div class="profile_qut">
                                <span class="profile_qut_img"><img src="<?php echo  URI_ROOT ?>images/profl_quotes.png"></span>
                               <span class="profile_qut_text"><?php echo functions::deformat_string($dec) ?></span>
                                </div>
                    			
                               
                               <div class="block-comment-bot">
        
                                <p><?php echo date('m/d/Y', strtotime($recent[$i]->created_date)) ?> at  <?php echo date('h:i A', strtotime($recent[$i]->created_date)) ?></p>
                                
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
					else
					{
						$content_comment = new content_comment($recent[$i]->id);
						$content 	= new content($content_comment->content_id);
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
                           <a href="<?php echo URI_ROOT?>user/PublicProfile/<?php echo $member->member_id?>">
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
                           <!-- <img src="<?php echo  URI_ROOT ?>images/profile_img.png">--></span> </a>
                            <span class="profil_sm_h1"><?php echo $name ?></span>
                            </div>
                            
                            <div class="profil_inner">
                            	<span class="profile_inner_arow"></span>
                                <div class="profile_add">
                                <a href="<?php echo URI_ROOT?>user/PublicProfile/<?php echo $member->member_id?>"><strong><?php echo $name ?></strong></a>  commented on <a href="<?php echo $url ?>" class="profile_add_colr"><?php echo functions::deformat_string($content->title)?></a>
                                </div>
                                
                                <div class="profile_qut">
                                <span class="profile_qut_img"><img src="<?php echo  URI_ROOT ?>images/profl_quotes.png"></span>
                                <span class="profile_qut_text"><a href="<?php echo URI_ROOT?>user/PublicProfile/<?php echo $member->member_id?>"><strong><?php echo $name ?></strong></a> <strong>wrote</strong>: <?php echo functions::deformat_string($content_comment->comment)?> </span>
                                </div>
                    			
                               
                               <div class="block-comment-bot">
        
                                <p><?php echo date('m/d/Y', strtotime($recent[$i]->created_date)) ?> at  <?php echo date('h:i A', strtotime($recent[$i]->created_date)) ?></p>
                                <div class="block-comment-bot-in">
                                
                                    <div class="activity-block share">
                                                        
                                        <div class="count">
                                            <span><a class="addthis_counter addthis_bubble_style" layout="button_count"></a></span>
                                        </div>
                                        
                                        <a class="share-btn addthis_button"></a>
                                       
                                    </div>
                                </div>
                            <div class="block-comment-bot-in">
                             <div class="active activity-block heart"><div class="count"><span class="like-count" id="cmnt_like_<?php echo $content_comment->content_comment_id ?>"><?php echo content_like::get_comment_like_total($content_comment->content_comment_id, 'like'); ?></span></div>
                             <a style="cursor:pointer;" class="comment3" id="like_<?php echo $content_comment->content_comment_id ?>"></a>
                             
                             </div>                           
                            </div>
                            <div class="block-comment-bot-in"> 
                            
                                <div class="active activity-block plus"><div class="count"><span class="like-count" id="cmnt_favorite_<?php echo $content_comment->content_comment_id ?>"><?php echo content_like::get_comment_like_total($content_comment->content_comment_id, 'favorite'); ?></span></div>
                                <a style="cursor:pointer;" class="fav3" id="favorite_<?php echo $content_comment->content_comment_id ?>"></a>
                                </div> 
                                                           
                            </div>
                        </div>
                               
                            </div>
                        
                        </div>
                        <?php
					}

					
					
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
    
    <?php $comment_array	= content_comment::get_profile_comments($member->member_id); 
    
    	if(count($comment_array) > 0)
		{
			for($i=0; $i < count($comment_array); $i++)
			{
				$content_comment = new content_comment($comment_array[$i]->content_comment_id);
						$content 	= new content($content_comment->content_id);
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
						
						//echo $content_comment->content_comment_id;
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
               <!-- <img src="<?php echo URI_ROOT ?>images/profile_img.png">--></span></a>
                <span class="profil_sm_h1"><?php echo $name ?></span>
                </div>
                
                <div class="profil_inner">
                <span class="profile_inner_arow"></span>
                
                <div class="profile_add">
                <a href="<?php echo URI_ROOT?>user/PublicProfile/<?php echo $member->member_id?>"><strong><?php echo $name ?></strong></a> commented on <a href="<?php echo $url ?>" class="profile_add_colr"><?php echo functions::deformat_string($content->title)?></a>
                </div>
                
                <div class="profile_qut">
                <span class="profile_qut_img"><img src="<?php echo URI_ROOT?>images/profl_quotes.png"></span>
                <span class="profile_qut_text"><a href="<?php echo URI_ROOT?>user/PublicProfile/<?php echo $member->member_id?>"><strong><?php echo $name ?></strong></a> <strong>wrote</strong>: <?php echo functions::deformat_string($content_comment->comment)?></span>
                </div>
        
        <div class="block-comment-bot">
        
            <p><?php echo date('m/d/Y', strtotime($content_comment->created_date)) ?> at  <?php echo date('h:i A', strtotime($content_comment->created_date)) ?></p>
                        <div class="block-comment-bot-in">
                        
                            <div class="activity-block share">
                                                
                                <div class="count">
                                    <span><a class="addthis_counter addthis_bubble_style" layout="button_count"></a></span>
                                </div>
                                
                                <a class="share-btn addthis_button"></a>
                               
                            </div>
                        </div>
                        
                            <div class="block-comment-bot-in">
                             <div class="active activity-block heart"><div class="count"><span class="like-count" id="cmnta_like_<?php echo $content_comment->content_comment_id ?>"><?php echo content_like::get_comment_like_total($content_comment->content_comment_id, 'like'); ?></span></div>
                             <a style="cursor:pointer;" class="comment3a" id="like_<?php echo $content_comment->content_comment_id ?>"></a>
                             
                             </div>                           
                            </div>
                            <div class="block-comment-bot-in"> 
                            
                                <div class="active activity-block plus"><div class="count"><span class="like-count" id="cmnta_favorite_<?php echo $content_comment->content_comment_id ?>"><?php echo content_like::get_comment_like_total($content_comment->content_comment_id, 'favorite'); ?></span></div>
                                <a style="cursor:pointer;" class="fav3a" id="favorite_<?php echo $content_comment->content_comment_id ?>"></a>
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
	
	 <div id="tab3" class="tab_content">  
    <div class="tab_inner">
	<span class="catgry" style="width:50px;">VIEW:</span>
	 <form name="message_form" id="message_form" action="<?php echo URI_ROOT ?>user/profile/RecentActivity?msg" method="post" >
		<select class="demo-3" name="view_sel" id="demo-select_3">
                <optgroup label="">
                <option value="0" <?php echo ($view_sel == 0 || $view_sel == '') ? 'selected': '' ?>>All</option>
                <option value="1" <?php echo ($view_sel == 1) ? 'selected': '' ?>>Sent</option>
                <option value="2" <?php echo ($view_sel == 2) ? 'selected': '' ?>>Received</option>
                </optgroup>
        
        </select>
        </form>
        
<!--        <form name="recent_from" id="recent_form" action="<?php echo URI_ROOT ?>user/profile/RecentActivity" method="post" >
		<select name="cat_sel" id="demo-select_3">
                <optgroup label="">
                <option value="1" <?php echo ($cat_sel == 0 || $cat_sel ==1) ? 'selected': '' ?>>All</option>
                <option value="2" <?php echo ($cat_sel == 2) ? 'selected': '' ?>>Topic</option>
                <option value="3" <?php echo ($cat_sel == 3) ? 'selected': '' ?>>Favorites</option>
                <option value="4" <?php echo ($cat_sel == 4) ? 'selected': '' ?>>Comments</option>
                </optgroup>
        
        </select>
        </form>-->

		
		<div class="line"></div>
        
        <div class="list-view" id="messages_list_div">

            <table cellspacing="0" cellpadding="0" class="tab-color">
            <tbody>
                <tr>
                    <th><div>Sent</div></th>
           			<th><div>Message</div></th>
           			<th><div>Date/Time</div></th>
            	</tr>
                
                <?php $message_array = message::get_messages_list($view_sel, $member->member_id); 
				
				 if( count($message_array) > 0)
				 {
					for($i =0; $i < count($message_array); $i++)
					{
						$mem = new member($message_array[$i]->from_user_id);
						$name_msg 	= functions::deformat_string($mem->first_name) .' '. functions::deformat_string($mem->last_name);
						$msg_content = (strlen($message_array[$i]->content) > 40) ? functions::deformat_string(substr($message_array[$i]->content, 0, 40)) : functions::deformat_string($message_array[$i]->content).'...';
						
						echo '<tr class=""> 
                        <td>
                            <div class="img-mes">';
							if($mem->avatar != '')
							{
								echo '<a href="'.URI_ROOT.'user/PublicProfile/'.$mem->member_id.'"><img alt="" src="'.URI_MEMBER.'thumb1_'.$mem->avatar.'"></a> ';
							}
							else if($mem->fb_id != '')
							{
								echo '<a href="'.URI_ROOT.'user/PublicProfile/'.$mem->member_id.'"><img alt="" src="http://graph.facebook.com/'.$mem->fb_id.'/picture?type=large"></a>';
							}
							else
							{
								echo '<a href="'.URI_ROOT.'user/PublicProfile/'.$mem->member_id.'"><img alt="" src="'.URI_ROOT.'images/profile_image.jpg"></a> ';
							}
                               // <img alt="" src="http://live.stagsource.com/avatar/Desert.jpg"></a> 
								
						 echo ' </div>
                            <b><a href="'.URI_ROOT.'user/PublicProfile/'.$mem->member_id.'">'.$name_msg.'</a></b>
                            <p></p>
                        </td>
                        <td>
                            <b><a style="cursor:pointer;" onclick="load_message('.$message_array[$i]->message_id.')">'.strtoupper(functions::deformat_string($message_array[$i]->title)).'</a></b>
                            <p><a style="cursor:pointer;" onclick="load_message('.$message_array[$i]->message_id.')">'.$msg_content.'</a></p>
                        </td>
                        <td>
                            <b>'. date('F d, Y', strtotime($message_array[$i]->date)).'</b>
                            <p>'. date('h:i A', strtotime($message_array[$i]->date)).'</p>
                            <p></p>
                        </td>
                    </tr>';
					
					}
				 }
				?>

                </tbody>
            </table>
        </div>
		
		<!--<div class="mssgng_box">
		<span class="mssgng_sm mssgng_sm_a">SENT</span>
		<span class="mssgng_sm">MESSAGE</span>
		<span class="mssgng_sm mssgng_sm_last">DATE/TIME</span>
		</div>
        
        <div class="mssgng_box">
		<span class="mssgng_sm mssgng_sm_a">SENT</span>
		<span class="mssgng_sm">MESSAGE</span>
		<span class="mssgng_sm mssgng_sm_last">DATE/TIME</span>
		</div>-->
		
		
    </div>
    </div>
    
    
    <div id="tab4" class="tab_content">
 	<div class="tab_inner">
	<div class="line"></div>
   
	    <?php 
	
		$favorite_array = content_like::get_profile_favorites($member->member_id); 
	    if(count($favorite_array) > 0)
		{
			//print_r($favorite_array);
			$cid =0;
			for($i = 0; $i < count($favorite_array); $i++)
			{ 
				if($favorite_array[$i]->model_name == 'Contents')
				{
					$content = new content($favorite_array[$i]->content_id);
					if($content->content_excerpt != '')
					{
						$dec   =  (strlen(strip_tags($content->content_excerpt )) > 40) ? $content->content_excerpt. '...': strip_tags($content->content_excerpt );
					}
					else
					{
						$dec   =  (strlen(strip_tags($content->title )) > 40) ? $content->title. '...': strip_tags($content->title );	
					}
				}
				else
				{
					$content_comment = new content_comment($favorite_array[$i]->content_id);
					//$dec   =  $content_comment->comment;	
					$content		 = new content($content_comment->content_id);
					if($content->content_excerpt != '')
					{
						$dec   =  (strlen(strip_tags($content->content_excerpt)) > 40) ? $content->content_excerpt . '...': strip_tags($content->content_excerpt );	
					}
					else
					{
						$dec   =  (strlen(strip_tags($content->title )) > 40) ? $content->title. '...': strip_tags($content->title );		
					}
				}
				
				
				
				if($content->content_id == '' || $content->content_id == 0) continue;
				if($cid == $content->content_id) continue;
				$cid = $content->content_id;
				
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
                    <!--<img src="<?php echo URI_ROOT ?>images/profile_img.png">--></span>
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
                    
                    	<div class="block-comment-bot-in">
                             <div class="active activity-block heart"><div class="count"><span class="like-count" id="cnta_like_<?php echo $content->content_id ?>"><?php echo content_like::get_like_total($content->content_id, 'like'); ?></span></div>
                             <a style="cursor:pointer;" class="comment1a" id="like_<?php echo $content->content_id ?>"></a>
                             
                             </div>                           
                            </div>
                            <div class="block-comment-bot-in"> 
                            
                                <div class="active activity-block plus"><div class="count"><span class="like-count" id="cnta_favorite_<?php echo $content->content_id ?>"><?php echo content_like::get_like_total($content->content_id, 'favorite'); ?></span></div>
                                <a style="cursor:pointer;" class="fav1a" id="favorite_<?php echo $content->content_id ?>"></a>
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
    
    
    
    <div id="tab5" class="tab_content">
 	<div class="tab_inner">
	<div class="line"></div>
    
 
       <!-- <div class="profil_rghtrow">       -->    
       
				   <?php
                        $message_name 	= ucfirst(functions::deformat_string($member_message->first_name)) .' '. strtoupper(substr($member_message->last_name, 0, 1)) .'.'; 
                   ?> 

                    <div class="form-send-message">
                        <form method="post" action="" id="frm_message1" name="frm_message1">  
                        
                        <div class="control-group" id="user_msg">
                            <div class="inp-5">
                                <label>User to:</label>
                                <p style="line-height: 34px; color:#888888;"><?php echo $message_name ?></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="inp-5">
                                <label>Subject:</label>
                                <input type="text" id="subject_message" name="subject_message" style="width:490px;" tabindex="1">       
                            </div>
                        </div>
                        <button type="submit" onclick="return validate_message()" class="btn-big send" style="cursor:pointer;" tabindex="3"><span >Send</span></button>  

                        <div class="control-group text-2">                            
                            <p class="label">
                                <!--<label for="hide13">Write your message here.</label>-->

                          <textarea onblur="fillText(this)" onfocus="clearText(this)" name="content_message" id="content_message" cols="50" rows="6" tabindex="2">Write your message here.</textarea>                            </p>
                        </div>
                        <input type="hidden" name="user_to" id="user_to" value="<?php echo $member_message->member_id ?>" />
						<input type="hidden" name="save_message" id="save_message" value="save" />
                        </form>

                    </div>
                    
                    <br />
                    <div class="list-view" id="messages_list_div1" style="display:none;">
                        <table cellspacing="0" cellpadding="0" class="tab-color">
                            <tbody>
                                <tr>
                                    <th><div>Sent</div></th>
                            <th><div>Message</div></th>
                            <th><div>Date/Time</div></th>
                            </tr>
                            <tr class="">
                                <td id="m_user">
                                    

                                </td>
                                <td id="m_content">
                                 
                                </td>
                                <td id="m_time">
                                    
                                </td>
                            </tr>


                            </tbody>
                        </table>

                    </div>



    </div>
    </div>
    
    
    

	</div>
	</div>
	
	
	</section>
	
	
	
	
	
	</div>
	
	</section>