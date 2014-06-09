
<script>
	$(document).ready(function() {
	
		$("#subscribe").click(function()
		{
			validate();
		});
		
		$("#email_footer").keyup(function()
		{
			//validate();
		});
		
		function validate()
		{
			$('.warningMesg').html('');
 			$('.warningMesg').hide('');			
			var email =$.trim($("#email_footer").val());
			
			
			if(email=='')
			{
				show_alert('email_footer', 'Email cannot be blank');
			}
			else if(is_email(email))
			{
				show_alert( 'email_footer','Invalid email address');
			}
			else
			{
				$.ajax(
				{
					type: "POST",
					cache: false,
					url: "<?php echo URI_ROOT ?>ajax_subscribe.php?email="+email,
					success: function (data)
					{
						if( $.trim(data)=="1")
						{
							$("#email_footer").val("");
							$('#message_email_footer').hide();
							show_message("Thank you for subscribing, stay tuned for news! ");
						}
						else if( $.trim(data)=="0")
						{
							$('#message_email_footer').html("You are already subscribed news letter!");
							$('#message_email_footer').show();	
						}
						else
						{
							window.location = '<?php echo URI_ROOT ."logout.php"; ?>';
						}
					}
				});
			}
		}
	
	});
function show_alert(id, message)
{
	$('#message_' + id).html(message);
	$('#message_' + id).show();
}
function is_email(input)
{
    var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
   
        if (re.test(input))
        {
            return false;
        }

    return true;
}</script>


    <footer class="footer">
    <section class="keepintouch">
      <div class="keepintouch_inner">
      	<h1>Keep in touch</h1>
       <!-- <p>Stay where you are. We'll push the news to you.</p>-->
       <p>We'll inform you of anything new that is happening.</p>
        <!-- <div class="subscribe_box">
       <div class="sub_email">
        
        <form name="subform" id="subform" method="POST" action="">
        	<input name="email_footer" id="email_footer" type="text"  placeholder="Enter email address...">
            <div id="message_email_footer" class="warningMesg" style=" display:none;  float:left; width:100%; text-align:left; padding-top:0; color:#F00; font-size:12px; "></div>
            </div>-->
            
           
       
            <!--<div class="btn_subscribe">
            <input name="subscribe" id="subscribe" value="SUBSCRIBE" type="button">
            </div>
          </form>
        </div>-->
        
         <div class="email_fld">
         <form name="subform" id="subform" method="POST" action="">
         	<input name="email_footer" id="email_footer" type="text" placeholder="Enter your E-Mail Address">
	  			<a stye="cursor:pointer;" id="subscribe"> <img src="<?php echo URI_ROOT ?>images/fld-right-img.jpg" width="13" height="22" border="0" class="email_fld_arow"></a>
       	 </form>
         <div id="message_email_footer" class="warningMesg" style=" display:none;  float:left; width:100%; text-align:left; padding-top:0; color:#F00; font-size:12px; "></div>
      	 </div>
        
        <!--<div class="footer_social_link">
        	<a href="<?php echo TWITTER_URL ?>" target="_blank"><div class="twit_footer">TWITTER</div></a>
            <a href="<?php echo FACEBOOK_URL ?>" target="_blank"><div class="fb_footer">FACEBOOK</div></a>
            <a href="<?php echo GOOGLEPLUS_URL ?>" target="_blank"><div class="google_footer">GOOGLE+</div></a>
        </div>-->
      </div>
    </section>
    <section class="footer_nav">
      <div class="footer_nav_inner">
      	<div class="nav_footer">
        <div class="footer_navbox">
        STAGSOURCE
       	  <ul>
            
            	<li><a href="<?php echo URI_ROOT ?>">Home</a></li>
            	<li><a href="#">Writers</a></li>
            	<li><a href="<?php echo URI_ROOT ?>page/about">About</a></li>
            </ul>
            </div>
            <div class="footer_navbox">
        ABOUT
        	<ul>
            
            	<li><a href="http://stagsource.tumblr.com/">Blog</a></li>
            	<li><a href="<?php echo URI_ROOT ?>page/licence-agreement">License agreement</a></li>
            	<li><a href="<?php echo URI_ROOT ?>page/privacy-policy">Privacy policy</a></li>
            </ul>
            </div>
            <div class="footer_navbox">
        HELP
        	<ul>
            
            	<li><a href="#">Documentation</a></li>
            	<li><a href="#">Discussions</a></li>
            	<li><a href="<?php echo URI_ROOT ?>page/contact_us">Contact</a></li>
            </ul>
            </div>
            <div class="footer_navbox">
        STAGSOURCE
        	<ul>
            
            	<li><a href="<?php echo FACEBOOK_URL ?>" target="_blank">Facebook</a></li>
            	<li><a href="<?php echo TWITTER_URL ?>" target="_blank">Twitter</a></li>
            	<li><a href="<?php echo GOOGLEPLUS_URL ?>" target="_blank">Google+</a></li>
            	<li><a href="<?php echo PINTREST_URL ?>" target="_blank">App.net</a></li>
            </ul>
            </div>
        </div>
      </div>
      <div class="copyright_box">&copy; <?php echo functions::deformat_string(SITE_NAME); ?>. All rights reserved</div>
    </section>
    </footer>
    
   
   
   <!--        Reveal Box Section  --->
   
   
    
    
    <script>
  <!-- link-flag -->
  $(document).ready(function() {
	 $('.link-flag').click(function(){
		 var modalLocation = $(this).attr('data-reveal-id');
		 var kk = $(this).attr('id').split('flag_btn_');
		 $('#comment_id').val(kk[1]);
		$('#'+modalLocation).reveal($(this).data());
		
	 });
	 
	 $('#report_btn').click(function() {
		 var cnt = $('input.chk:checkbox:checked').length
		 if(cnt == 0)
		 {
			 $('#flag_error').show();
			 $('#flag_error').html('Please select one or more report causes'); 
		 }
		 else
		 {
			 $('#flag_error').hide();
			$.ajax(
			{
				type: "POST",
				cache: false,
				url: "<?php echo URI_ROOT ?>ajax_comment_flag.php",
				data: $('#flag_form').serialize(),
				success: function (data)
				{
					//alert(data);
					$('#report_spam_button_ContentComments_'+$('#comment_id').val()).hide();
					$('.close-reveal-modal').focus().click();
					//var modalLocation = $(this).attr('data-reveal-id');
					$('#flagBox1').reveal($(this).data());
				}
			}); 
		 }
	 });
	 
	 
	 $("#community-form").validate({
		wrapper:'span',
		
		rules: {
			title: {
			   required:true,
			   maxlength: 255
			},
			content: {
			   required:true
			},
			topic_category: "required"
			
		},
		messages: {
			title: {
				required: "Title is required",
				maxlength: "Title not more than {0} characters "
			},
			content: {
				required: "Content is required"
			},
			topic_category: "required"
		},
		showErrors: function (errorMap, errorList) {
   			this.defaultShowErrors();
    		$.each(errorList, function (i, error) {
				$('label.error').css("padding-left", ".0em");
    		});
		}
		
		
	}); 
	
	 
	 $('#community_create').click(function() {
		 var member_id 	= '<?php echo $_SESSION[MEMBER_ID] ?>';
		 if(member_id > 0)
		 {
			 $('label.error').hide();
			 $('.error').removeClass('error');
			 $('#topicBox').reveal($(this).data()); 
			  
		 }
		 else
		 {
			$('#signupBox').reveal($(this).data());  
		 }
	 });
	 
	 $('#topic_submit').click(function() {
		if($("#community-form").valid())
		{
			var title= $('#title').val();
			var seo = get_url_string(title);
			$('#seo_url').val(seo);
			
			$.ajax(
			{
				type: "POST",
				cache: false,
				url: "<?php echo URI_ROOT ?>ajax_add_community_topic.php",
				data: $('#community-form').serialize(),
				success: function (data)
				{					
					if(data > 0)
					{
						$('.close-reveal-modal').focus().click();
						//var modalLocation = $(this).attr('data-reveal-id');
						$('#topicBox1').reveal($(this).data());
					}
				}
			});
		}
	 });
  });
  
  
  function get_url_string(string)
  {
	string 		= string.toLowerCase();
	var seo_url = string.replace(/[^a-zA-Z 0-9]+/g,'-');
	seo_url 	= seo_url.replace(/ /g,'-');
	return seo_url;
  }

</script>


<div class="block-popup report-popup spam_rep reveal-modal" id="flagBox" style=" background:#313131;">

            <div class="block-popup-in" id="block-flag" style="min-height:505px;">
                <div class="title-popup-in">
                    <h2>Flag as inappropriate</h2>
                </div>

                <div class="block-popup-in-2">
                    <form method="post" action="" name="flag_form" id="flag_form">
                        <div>
                            <div class="line">
                                  Report this Comment due to:
                         </div>

							<?php $spam_report = new spam_report(); ?>
                            <div class="line">
                            
                            	<?php for($i =1; $i<= count($spam_report->comment_due_array); $i++)
								{?>
									<p>
                                    <input type="checkbox" value="<?php echo $i ?>" name="report_cause[]" class="chk" id="report_cause_<?php echo $i ?>" />
                                    <span><?php echo $spam_report->comment_due_array[$i] ?></span>
                                </p>
								<?php }
								?>
                                <!--<p>
                                    <input type="checkbox" value="1" name="report_cause">
                                    <span>Explicit language</span>
                                </p>

                                <p>
                                    <input type="checkbox" value="2" name="report_cause">
                                    <span>Attacks on groups or individual</span>
                                </p>

                                <p>
                                    <input type="checkbox" value="3" name="report_cause">
                                    <span>Invades my privacy</span>
                                </p>

                                <p>
                                    <input type="checkbox" value="4" name="report_cause">
                                    <span>Hateful speech or symbols</span>
                                </p>

                                <p>
                                    <input type="checkbox" value="5" name="report_cause">
                                    <span>Spam or scam</span>
                                </p>

                                <p>
                                    <input type="checkbox" value="6" name="report_cause">
                                    <span>Other</span>
                                </p>-->
                            </div>
                            
                            <div class="login_error" id="flag_error" style="display:none;"></div>
                            <div style="color:red; display: none;" class="line error">
                                Please select one or more report causes
                            </div>
                        </div>
                        <input type="hidden" id="comment_id" name="comment_id" value="0" />
                    </form>
                </div>
                <div class="block-popup-in-2">
                    <p class="guidelines-links">Read our <a target="_blank" href="<?php echo URI_ROOT ?>page/code-of-conduct">Code of Conduct</a></p>
                </div>
                <div class="block-popup-bot">
                    <a class="report but-big but-green" style="cursor:pointer;" id="report_btn">Report</a>
                </div>
            </div>
            <a class="close-reveal-modal">&#215;</a>
        </div>
        
        
 <div class="block-popup report-popup spam_rep reveal-modal" id="flagBox1" style=" background:#313131;">

            <div class="block-popup-in" id="block-flag" style="min-height:205px;">
                <div class="title-popup-in">
                    <h2>Notification</h2>
                </div>
				
                <div class="block-popup-in-2">
                        <div>
                            <div class="line">
                                  Thanks for reporting this content. We'll look into it.
                          </div>
                            
                        
                        </div>
                     

                </div>
                <div class="block-popup-in-2">
                	<?php $content1 = new content(1024); ?>
                    <p class="guidelines-links">See more at: <a target="_blank" href="<?php echo URI_ROOT ?>contents/<?php echo $content1->seo_url1 ?>"><?php echo URI_ROOT ?>contents/<?php echo $content1->name ?></a></p>
                </div>
            </div>
            <a class="close-reveal-modal">&#215;</a>
        </div>
        
      
      
      
      <div class="block-popup block-popup-signin reveal-modal" id="topicBox" style=" background:#313131; ">
    <div class="block-popup-in">
        <div class="title-popup-in">
            <h2>Create a topic</h2>
        </div>
        <div class="block-popup-in-2">
           <form method="post" name="community-form" id="community-form" autocomplete="off">
                       <div class="block-popup-in-3">
                            <div class="line">
                    <label style="font-weight:bold;"><b>*</b>Title:</label>

                    <p class="label inp-3">
                        <!--<label for="Contents_content_title">Title</label>-->
                        <input type="text" id="title" name="title" maxlength="255" size="20">
                    </p>
                       
                </div>
                <div class="line">
                    <label style="font-weight:bold;"><b>*</b>Message:</label>

                    <p class="label text-4">
                       <!-- <label for="Contents_content_content">Message</label>-->
                        <textarea id="content" name="content" size="20"></textarea>                    </p>
                </div>
                <div class="line topic-category">
                    <label style="font-weight:bold;"><b>*</b>Category:</label>
                    <span id="Contents_content_category_id">
                    <?php
					$database		= new database();
					$sql 			= "SELECT * FROM category WHERE status='Y' ORDER BY category_id ASC";
					$result				= $database->query($sql);	
					if($result->num_rows > 0)
					{
						while($data 	= $result->fetch_object())
						{
							?>
                            <div class="f-left">
                        	<p>
                            	<input type="radio" name="topic_category[]" <?php echo ($data->category_id  == 1) ? 'checked="checked"' : ''; ?> value="<?php echo $data->category_id; ?>" id="Contents_content_category_id_<?php echo $data->category_id; ?>">
                            	<label for="Contents_content_category_id_<?php echo $data->category_id; ?>"><?php echo $data->name; ?></label>
                       		</p>
                   			</div>
                            <?php
						}
						
					}
					
					?>
                    </span>
                    
           
                     </div>
            </div>
            <div class="guidelines">
                <div class="guidelines-label" style="font-weight:bold;">Posting Guidelines</div>
                <p class="guidelines-links" style="font-weight:bold;">Participation in the StagSource community is subject<br> to the <a target="_blank" href="<?php echo URI_ROOT?>page/terms-and-conditions">Terms and
                        Conditions</a> and our <a target="_blank" href="<?php echo URI_ROOT?>page/privacy-policy">Privacy Policy.</a></p>
            </div>
            <input type="hidden" id="seo_url" name="seo_url" value="" />
        </form></div>
        <div class="block-popup-bot">
            <input type="submit" id="topic_submit" value="Submit" class="but-big but-red">
            
        </div>
            </div>
            <a class="close-reveal-modal">&#215;</a>
</div>


<div class="block-popup report-popup spam_rep reveal-modal" id="topicBox1" style=" background:#313131;">

            <div class="block-popup-in" id="block-flag" style="min-height:205px;">
                <div class="title-popup-in">
                    <h2>Notification</h2>
                </div>
				
                <div class="block-popup-in-2">
                        <div>
                            <div class="line">
                                  Thanks for creating topic. Topic successfully added in the community.
                          </div>

                        </div>
                </div>
                
            </div>
            <a class="close-reveal-modal">&#215;</a>
        </div>
		
		
