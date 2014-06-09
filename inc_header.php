<?php
/*********************************************************************************************
Author 	: V V VIJESH
Date	: 02-April-2011
Purpose	: 
*********************************************************************************************/

ob_start();
session_start();

require_once ('includes/config.php');
$page_name = functions::get_page_name();

if($page_name=='content.php')
{
   $page_name = functions::get_page_name_only();
}
//$page =explode('/',$_SERVER['REQUEST_URI']);

if($_SERVER['QUERY_STRING']!='' && $page_name != 'faq.php')
{
	$page = explode('id=',$_SERVER['QUERY_STRING']);
	
	$page_id = $page[1];
}


//echo $_SESSION[MEMBER_ID];

// ------------- FACEBOOK ------------------
$facebook = unserialize(FBOBJECT);
// Get User ID
$user = $facebook->getUser();

$member = new member();

if(!isset($_SESSION[MEMBER_ID]))
{
	if ($user) {
	   try {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = $facebook->api('/me');
			//print_r($user_profile);
			$member_id = $member->get_member_id_by_fbid($user);
			if($member_id == 0)
			{
				$member_id = $member->add_fb_user($user_profile);	
			}
			
			if($member_id > 0)
			{
				$_SESSION[MEMBER_ID] = $member_id;
				functions::redirect('index.php');
			}			
			
	  } catch (FacebookApiException $e) {
			//error_log($e);
			$user = null;
	  }
	  
	  $permissions = $facebook->api("/me/permissions");
	  
	  //print_r($permissions);
	  if( array_key_exists('publish_stream', $permissions['data'][0]) ) {
			// Permission is granted!
			//$post_id = $facebook->api('/me/feed', 'post', array('message'=>'Hello World!'));
			//$post_id = $facebook->api('/me/feed');
			//print_r($post_id);
			//echo "Permission is granted";
	  } else {
			// We don't have the permission
			// Alert the user or ask for the permission!
		   //header( "Location: " . $facebook->getLoginUrl(array("scope" => "publish_stream")) );
	  }
   }
}


// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl(array( 'next' => (URI_ROOT.'logout.php') ));
} else {
	$params = array(
	
  //'scope' => 'read_stream, friends_likes, email, user_about_me,  public_profile, friend_list, user_friends, publish_stream,  user_birthday', //publish_actions,
  'scope' => 'public_profile, email, publish_stream',
  'redirect_uri' => URI_ROOT.'index.php'
);
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl($params);
}

//if($page_name != 'public_profile.php' && $page_name != 'user.php') {
?>

<script src="<?php echo URI_ROOT ?>js/textbox.js"></script>
<script src="<?php echo URI_ROOT ?>js/ion.rangeSlider.js"></script>
<script type="text/javascript" src="<?php echo URI_LIBRARY ?>select/jquery.selectbox-0.2.js"></script>

<script type="text/javascript" src="<?php echo URI_LIBRARY ?>select/functions.js"></script>
<link rel="stylesheet" href="<?php echo URI_ROOT ?>css/demo_rangeslider.css">
<link rel="stylesheet" href="<?php echo URI_ROOT ?>css/ion.rangeSlider.css">
<link rel="stylesheet" href="<?php echo URI_ROOT ?>css/skin1.css" id="skinCss">

<link href="<?php echo URI_LIBRARY ?>select/jquery.selectbox.css" type="text/css" rel="stylesheet"/>

<!-- For Calendar -->
	<script src="<?php echo URI_LIBRARY ?>jquery/jquery-ui-min.js" type="text/javascript" ></script>
    <script type="text/javascript" src="<?php echo URI_LIBRARY ?>datetimepicker/dist/jquery-ui-timepicker-addon.js"></script>
    <link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" media="all" type="text/css" href="<?php echo URI_LIBRARY ?>datetimepicker/dist/jquery-ui-timepicker-addon.css" />
<!--  End Of Calendar -->
                                
<?php //} ?>

<script src="//connect.facebook.net/en_US/all.js"></script>
	<script>
 
	window.fbAsyncInit = function() {
		
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>',
          cookie: false,
          xfbml: true,
          oauth: true,
		  status:false,
		  redirect_uri:'index.php'
        });
       FB.Event.subscribe('auth.login', function(response) {
         // window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        }); 
      };
	  
	  function FacebookInviteFriends()
		{
			FB.ui({
					method: 'apprequests',
					message: 'Invitation'
		//                        display:'dialog'
				}
			);
		}
	  
	function logout()
	{
		
		FB.logout(function(response) {
       		 //console.log(response.status);
			 <?php //echo $facebook->destroySession(); ?>
			window.location.reload();
    	});
	}
	</script>
    
    <script type='text/javascript'>
if (top.location!= self.location)
{
top.location = self.location
}
</script>


	<script type="text/javascript" src="<?php echo URI_ROOT ?>js/jquery.reveal.js"></script>
   <!-- <script type="text/javascript" src="js/foundation.min.js"></script>-->
	<link rel="stylesheet" href="<?php echo URI_ROOT ?>css/reveal.css">

	<script type="text/javascript" src="<?php echo URI_LIBRARY; ?>fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="<?php echo URI_LIBRARY; ?>fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo URI_LIBRARY; ?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />


<script src="<?php echo URI_LIBRARY; ?>jquery/jquery-validate.js" ></script>
<script type="text/javascript" src="<?php echo URI_ROOT ?>js/md5.js"></script>

<script type="text/javascript">
$(document).ready(function ()
{
	$('#login_btn, #login_btn1').click(function(e) {
		e.preventDefault();
		
		<?php if(!isset($_COOKIE['remember'])) { ?>
			$('#username').val('');
			$('#password').val('');
		<?php } ?>	
		
		$('label.error').hide();
		$('.error').removeClass('error');
		$('#login_error').hide();
		$('.close-reveal-modal').focus().click();
		var modalLocation = $(this).attr('data-reveal-id');
		$('#'+modalLocation).reveal($(this).data());
	});
	
	$('#signup_btn').click(function(e) {
		e.preventDefault();
				
		$('label.error').hide();
		$('.error').removeClass('error');
		$('#signup_error').hide();
		
		var modalLocation = $(this).attr('data-reveal-id');
		$('#'+modalLocation).reveal($(this).data());
	});
	
	$('#forgot_btn').click(function(e) {
		e.preventDefault();
		$('#email').val('');
		$('label.error').hide();
		$('.error').removeClass('error');
		$('#forgot_error').hide();
		$('.close-reveal-modal').focus().click();
		var modalLocation = $(this).attr('data-reveal-id');
		$('#'+modalLocation).reveal($(this).data());
	});
	
	
	$('#message_btn').click(function(e) {
		e.preventDefault();
		$('#email_message').val('');
		$('label.error').hide();
		$('.error').removeClass('error');
		$('#message_error').hide();
		var modalLocation = $(this).attr('data-reveal-id');
		var mem_id =  '<?php echo $_SESSION[MEMBER_ID] ?>';
		if(mem_id != '')
		{ 
			$('#'+modalLocation).reveal($(this).data());
		}
	});
	
	/*$('#bachelorparty_btn').click(function(e) {
		e.preventDefault();
		var modalLocation = $(this).attr('data-reveal-id');
		$('#'+modalLocation).reveal($(this).data());
	});*/
	
	
		
	
	$("#frm_login").validate({
/*		errorLabelContainer: "ul",
		errorElement: "em",
		wrapper: "li",*/
		wrapper:'span',
		
		rules: {
			username: {
			   required:true,
			   minlength: 4,
			   maxlength: 25
			},
           password: {
				required: true,
				maxlength: 15,
				minlength: 5
			}
		},
		messages: {
			username: {
				required: "Username is required",
				minlength: "Username should be atleast {0} characters ",
				maxlength: "Username not more than {0} characters"
			},
			password: {
				required: "Password is required",
				minlength: "Password should be atleast {0} characters",
				maxlength: "Password not more than {0} characters"
			}
		},
		showErrors: function (errorMap, errorList) {
   			this.defaultShowErrors();
    		$.each(errorList, function (i, error) {
				$('label.error').css("padding-left", ".0em");
    		});
		}
		
		
		/*errorPlacement: function(error, element) {         
       		//error.insertBefore(element);
			//error.css("margin", "0 0 0 5px");
			
			//$(element).attr("placeHolder", error[0].innerHTML);
			//error.insertBefore(element.parent().next('div').children().first());
			//error.addClass('arrow');
        	//error.insertAfter(element);
   		}*/
		
			
	}); 
	
	$("#frm_signup").validate({
		wrapper:'span',
		
		rules: {
			first_name: {
			   required:true,
			   maxlength: 255
			},
			last_name: {
			   required:true,
			   maxlength: 255
			},
			email_signup: {
				required:true,
				email: true,
				minlength: 6,
				maxlength:100
			},
           password_signup: {
				required: true,
				maxlength: 15,
				minlength: 5
			}
		},
		messages: {
			first_name: {
				required: "First name is required",
				maxlength: "First name not more than {0} characters "
			},
			last_name: {
				required: "Last name is required",
				maxlength: "Last name not more than {0} characters "
			},
			email_signup: {
				required: "Email is required",
				email: "Invalid email address",
				maxlength: "Email not more than {0} characters "
			},
			password_signup: {
				required: "Password is required",
				minlength: "Password should be atleast {0} characters",
				maxlength: "Password not more than {0} characters"
			}
		},
		showErrors: function (errorMap, errorList) {
   			this.defaultShowErrors();
    		$.each(errorList, function (i, error) {
				$('label.error').css("padding-left", ".0em");
    		});
		}
		
		
	}); 
	
	
	$("#frm_forgot").validate({		
		rules: {
			email: {
			   required:true,
			   email: true,
			  minlength: 4,
			  maxlength: 25
			}
		},
		messages: {
			email: {
						required:"Email is required",
						email	: "Please enter a valid email address",
						minlength: "Email should be atleast {0} characters ",
						maxlength: "Email not more than {0} characters " 
					}
		},
		showErrors: function (errorMap, errorList) {
   			this.defaultShowErrors();
    		$.each(errorList, function (i, error) {
				$('label.error').css("padding-left", ".0em");
    		});
		}		
	}); 
	
	$("#frm_message").validate({		
		rules: {
			email_message: {
			   required:true,
			   email: true,
			  minlength: 4,
			  maxlength: 25
			}
		},
		messages: {
			email_message: {
						required:"Email is required",
						email	: "Please enter a valid email address",
						minlength: "Email should be atleast {0} characters ",
						maxlength: "Email not more than {0} characters " 
					}
		},
		showErrors: function (errorMap, errorList) {
   			this.defaultShowErrors();
    		$.each(errorList, function (i, error) {
				$('label.error').css("padding-left", ".0em");
    		});
		}		
	}); 
	
	
	$('.login_txtfield').keypress(function(e) {
		$('#message').hide();
        if(e.which == 13) {
            jQuery(this).blur();
            jQuery('#save').focus().click();
        }
    });
	
	
	$('#save').click(function() {
		if($("#frm_login").valid())
		{
			var remember = 0;
			if($('#remember').attr('checked')) {
    			remember = 1;
			} else {
    			remember= 0;
			}
			
			var pass_hash = CryptoJS.MD5($('#password').val());
			$.ajax(
			{
				type: "POST",
				cache: false,
				url: "<?php echo URI_ROOT ?>ajax_login.php?username="+$('#username').val()+"&password="+pass_hash+"&remember="+remember,
				success: function (data)
				{
					//alert(data);
					var row = data.split('<>');
					if(row[0] == 1)
					{
						window.location='<?php echo URI_ROOT ?>index.php';	
					}
					else 
					{
						$('#login_error').html(row[1]);
						$('#login_error').show();
					}
				}
			});
		}
	});
	
	$('#forgot').click(function() {
		if($("#frm_forgot").valid())
		{
			$.ajax(
			{
				type: "POST",
				cache: false,
				url: "<?php echo URI_ROOT ?>ajax_forgot_password.php?email="+$('#email').val(),
				success: function (data)
				{
					var row = data.split('<>');
					if(row[0] == 1)
					{
						$('.close-reveal-modal').focus().click();
						//Password reset instructions have been sent to your email.
						
						//var modalLocation = $('#confirm').attr('data-reveal-id');
						$('#confirm').reveal($(this).data());
		
						/*$('#forgot_error').html('Password reset instructions have been sent to your email.');
						$('#forgot_error').show();*/
						
						//window.location='index.php';	
					}
					else 
					{
						$('#forgot_error').html(row[1]);
						$('#forgot_error').show();
					}
				}
			});
		}
	});
	
	
	$('#message_submit').click(function() {
		if($("#frm_message").valid())
		{
			
			$.ajax(
			{
				type: "POST",
				cache: false,
				url: "<?php echo URI_ROOT ?>ajax_newsletter.php?email="+$('#email_message').val(),
				success: function (data)
				{
					//alert(data);
					var row = data.split('<>');
					if(row[0] == 1)
					{
						$('.close-reveal-modal').focus().click();
						$('#confirm_message').reveal($(this).data());
						//show_message("Thank you for subscribing, stay tuned for news! ");
					}
					else  if(row[0] == 0)
					{
						$('#message_error').html(row[1]);
						$('#message_error').show();
					}
					else
					{
						window.location = '<?php echo URI_ROOT ."logout.php"; ?>';
					}
				}
			});
			
			
		}
	});
	
	
	$('#signup').click(function() {
		if($("#frm_signup").valid())
		{
			var pass_hash = CryptoJS.MD5($('#password_signup').val());
			$.ajax(
			{
				type: "POST",
				cache: false,
				url: "<?php echo URI_ROOT ?>ajax_signup.php?email="+$('#email_signup').val()+"&ps="+$('#password_signup').val()+"&password="+pass_hash+"&first_name="+$('#first_name').val()+"&last_name="+$('#last_name').val(),
				success: function (data)
				{
					//alert(data);
					var row = data.split('<>');
					if(row[0] == 1)
					{
						window.location='<?php echo URI_ROOT ?>index.php';	
					}
					else 
					{
						$('#signup_error').html(row[1]);
						$('#signup_error').show();
					}
				}
			});
		}
	});
	
	
	
	$('.comment,  .fav').click(function(){ 

		var member_id 		= '<?php echo $_SESSION[MEMBER_ID]; ?>';
		var content_id	  	= $(this).attr('id');
		//var like_type 		= $(this).attr('class');
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
				url: "<?php echo URI_ROOT ?>ajax_page_like.php?member_id="+member_id+"&content_id="+content_id,
				success: function (data)
				{
					
					$('#'+content_id).html(data);
				}
			});
		}
	});
	
	$('.comment1, .comment2, .comment3, .comment3a, .comment1a, .fav2, .fav1, .fav1a, .fav3, .fav3a').click(function(){ 

		var member_id 		= '<?php echo $_SESSION[MEMBER_ID]; ?>';
		var content_id	  	= $(this).attr('id');
		var like_type 		= $(this).attr('class');
		
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
			if(like_type == 'comment3' || like_type == 'comment3a' || like_type == 'fav3' || like_type == 'fav3a')
			{
				$.ajax(
				{
					type: "POST",
					cache: false,
					url: "<?php echo URI_ROOT ?>ajax_page_like.php?member_id="+member_id+"&content_id="+content_id+"&comment=1",
					success: function (data)
					{
						if(like_type == 'comment3'  || like_type == 'fav3' )
						{
							$('#cmnt_'+content_id).html(data);
						}
						else
						{
								$('#cmnta_'+content_id).html(data);
						}
						
					}
				});
			}
			else
			{
				$.ajax(
				{
					type: "POST",
					cache: false,
					url: "<?php echo URI_ROOT ?>ajax_page_like.php?member_id="+member_id+"&content_id="+content_id,
					success: function (data)
					{
						//alert(data);
						//alert($('#cnt_'+content_id).html())
						//var con = content_id.split('_');
						if(like_type == 'comment2' || like_type == 'fav2')
						{
							$('#cnt1_'+content_id).html(data);
						}
						if(like_type == 'comment1a' || like_type == 'fav1a')
						{
							$('#cnta_'+content_id).html(data);
						}
						else
						{
							$('#cnt_'+content_id).html(data);
						}
					}
				});
			}
		}
	});

	
});


function submit_search()
{
	location.href = '<?php echo URI_ROOT ?>'+'content/search/search_keyword='+$('#mes').val();	
	return false;
}

function expand_one(){
	
    $("#expand_first").show(300);
	//$("#content_first_"+id).hide(300);
}
function collaps_one(){
 
 $("#expand_first").hide(300); 

}


function show_contact_popup()
{
	$.ajax(
    {
        type: "POST",
        cache: false,
        url: "popup_contact.php",
        success: function (data)
	    {
            $.fancybox(data);
        }
    });
}

function show_message(message)
{
	$.ajax(
	{
		type: "POST",
		cache: false,
		url: "<?php echo URI_ROOT ?>popup_show_message.php?popup=1&message=" + message,
		success: function (data)
		{
			//alert(data);
			$.fancybox(data);
		}
	});
}


</script>


<header class="header">
	<section class="login_signupbox">
	<div class="login_signupboxinner">
		<div class="login_socialmediabox">
        
        <?php if(!isset($_SESSION[MEMBER_ID])) { ?>
			<div class="login">
				<!--<a href="#">Login</a>-->
                <a style="cursor:pointer;" id="login_btn" class="big-link" data-reveal-id="loginBox" data-animation="fadeAndPop">Login</a>
			</div>
			<div class="login">
				<!--<a href="#">Signup</a>-->
                <a style="cursor:pointer;" id="signup_btn" class="big-link" data-reveal-id="signupBox" data-animation="fadeAndPop">Signup</a>
			</div>
         <?php } else { ?>
         	<div class="login">
				<a href="<?php echo URI_ROOT ?>logout.php">Logout</a>
			</div>
			<div class="login">
				<a href="<?php echo URI_ROOT ?>user/profile">Profile</a>
			</div>
            
             <a style="cursor:pointer;" id="message_btn" class="big-link" data-reveal-id="messageBox" data-animation="fadeAndPop"><i class="icn_message"></i></a>
            <a href="<?php echo FACEBOOK_URL ?>" target="_blank"><i class="icn_fb"></i></a>
			<a href="<?php echo PINTREST_URL ?>" target="_blank"><i class="icn_pintrest" ></i></a>
			<a href="<?php echo TWITTER_URL ?>" target="_blank"><i class="icn_twitter"></i></a>
			<a href="<?php echo GOOGLEPLUS_URL ?>" target="_blank"><i class="icn_google"></i></a>
			<a href="<?php echo RSSFEED_URL ?>" target="_blank"><i class="icn_rss"></i></a>
         
         <?php } ?>
         
			 
		</div>
	</div>
	</section>
	<section class="nav_box">
	<div class="nav_box_inner">
		<figure class="logo"><a href="<?php echo URI_ROOT ?>"><img src="<?php echo URI_ROOT ?>images/logo.png" width="157" height="54"></a></figure>
        <div class="navmobile">
        	<div class="row">
				<a href="#hide1" class="hide" id="hide1" onClick="expand_one();"><b><img class="mrleft3" src="<?php echo URI_ROOT ?>images/nav-icon.png"></b></a> 
				<a href="#show1" class="show" id="show1" onClick="collaps_one();" ><b><img class="mrleft3" src="<?php echo URI_ROOT ?>images/nav-icon.png"></b></a>


<!--LIST POSTS-->
<div class="list" id="expand_first" style="display:none;">
    <ul>
        <a href="<?php echo URI_ROOT ?>"><li>Home</li></a>
        <!--<a href="<?php echo URI_ROOT ?>category/bachelor"><li>Bachelor</li></a>
        <a href="<?php echo URI_ROOT ?>category/wedding"><li>Wedding</li></a>
        <a href="<?php echo URI_ROOT ?>category/honeymoon"><li>Honeymoon</li></a>
        <a href="<?php echo URI_ROOT ?>category/advice"><li>Advice</li></a>
        <a href="<?php echo URI_ROOT ?>category/style"><li>Style</li></a>
        <a href="<?php //echo URI_ROOT ?>category/gifts"><li>Gifts</li></a>-->
        
		<?php category::get_top_menu($page_name, $page_id, true); ?>
        
       <a href="<?php echo URI_ROOT ?>community"><li>Community
        
        
        
        </li></a>
            </ul>
</div>
</div>
        </div>
		<nav class="nav">
        <ul id="nav">
        
        <a href="<?php echo URI_ROOT ?>">
			<li <?php echo ($page_name =='index.php') ? 'class="active_nav"' : ''; ?>>Home</li>
		</a>
            
        <?php category::get_top_menu($page_name, $page_id); ?>
         <li><a href="http://shop.stagsource.com/">Gifts</a></li>
          <li><a href="http://blog.stagsource.com/">Blog</a></li>
       <li <?php echo ($page_name =='community.php' || $page_name =='content_community.php') ? 'class="active_nav"' : ''; ?>> 
			<a href="<?php echo URI_ROOT ?>community">Community</a>
       
          
            
                  <ul class="sub-menu">
                      
                      <?php category::get_sub_menu(); ?>
                  </ul>
            </li>
            
            <div class="block-search" >
                        <form method="post" action="" onsubmit="return submit_search()">                        <div>
                            <div class="sub-s" >
                                <input type="submit" value="" name="" id="search_but" ><input type="submit" value="" >
                            </div>
                            <p class="label">
                                <label for="mes" style="display: none;">Search</label>
                                <input type="text" name="search_keyword" value="" id="mes" placeholder="Search">                            </p>
                        </div>
                        </form>                    </div>
		
		
        	<?php
				//$page_1 = str_replace('/','', $page_id);
			?>
            
		<!--	
			<a href="<?php echo URI_ROOT ?>category/bachelor" >
				<li <?php echo ($page_name =='category.php' && $page_1 == 'bachelor') ? 'class="active_nav"' : ''; ?>>Bachelor</li>
			</a>
			
            <a href="<?php echo URI_ROOT ?>category/wedding">
			<li <?php echo ($page_name =='category.php' && $page_1 == 'wedding') ? 'class="active_nav"' : ''; ?>>Wedding</li>
			</a>
			<a href="<?php echo URI_ROOT ?>category/honeymoon">
			<li <?php echo ($page_name =='category.php' && $page_1 == 'honeymoon') ? 'class="active"' : ''; ?>>Honeymoon</li>
			</a>
            <a href="<?php echo URI_ROOT ?>category/advice">
			<li <?php echo ($page_name =='category.php' && $page_1 == 'advice') ? 'class="active"' : ''; ?>>Advice</li>
			</a>
			<a href="<?php echo URI_ROOT ?>category/style">
			<li <?php echo ($page_name =='category.php' && $page_1 == 'style') ? 'class="active"' : ''; ?>>Style</li>
			</a>
			 <a href="<?php //echo URI_ROOT ?>category/gifts">
			<li <?php //echo ($page_name =='category.php' && $page_1 == 'gifts') ? 'class="active"' : ''; ?>>Gifts</li>
			</a>
             --> 
            
		</ul>
		</nav>
	</div>
	</section>
	</header>
    
    
    <div id="loginBox" class="reveal-modal" style="left:60%;">
<div class="login_box">
	<h1>User Login</h1>
   <a href="<?php echo $loginUrl; ?>"> <div class="connect_fb"></div></a>
    <div class="or"><img src="<?php echo URI_ROOT ?>images/or.jpg" ></div>
     <form id="frm_login" name="frm_login" method="post" autocomplete="off">
     
    <div class="login_error" id="login_error" style="display:none;"></div>
    <div class="login_fieldbox">
    	<input type="text" name="username" id="username"  value="<?php echo $_COOKIE['remember_me']; ?>" class="login_txtfield" placeholder="Username">
    </div>
    <div class="login_fieldbox">
    	<input type="password" name="password" id="password"  value="<?php echo $_COOKIE['remember_pass']; ?>" class="login_txtfield" placeholder="Password" maxlength="15">
    </div>
    <div class="forgot_remember">
    <div class="login_chkbox">
    <fieldset class="checkboxes"><label class="label_check" for="remember"><input name="remember" id="remember" value="1" type="checkbox" <?php if(isset($_COOKIE['remember'])) { echo 'checked="checked"'; } else { echo ''; }	?>/></label></fieldset>
    </div>
    <span class="reme">Remember me</span> <span class="frgtpwd"><a style="cursor:pointer;" id="forgot_btn" class="big-link" data-reveal-id="forgotPass" data-animation="fadeAndPop">Forgot password</a></span>
    <input name="save" id="save" type="button" value="Sign in" class="btn_signin">
    </form>
    </div>
</div>
<a class="close-reveal-modal">&#215;</a>
</div>

<div id="forgotPass" class="reveal-modal">
<div class="forgot_box">
	<h1>Reset Your Password</h1>
   	<div class="reset_txt">Forgot your password? No problem! Enter your email and we will send you instructions on how to reset your password. </div>
    
     <div class="forgot_error" id="forgot_error" style="display:none;"></div>
     
	 <form id="frm_forgot" name="frm_forgot" method="post" autocomplete="on">
    <div class="login_fieldbox">
    	<input name="email" id="email" type="text" class="login_txtfield" placeholder="Email">
    </div>
   
   
    <div class="forgot_remember">
   
    <input name="forgot" id="forgot" type="button" value="Send Reset Password Email" class="btn_forgot">
    </form>
    </div>
</div>
<a class="close-reveal-modal" >&#215;</a>
</div>

<div id="messageBox" class="reveal-modal">
<div class="forgot_box">
	<h1>Newsletter</h1>
   	<div class="reset_txt">Sign up for our e-newletters by entering your email here. </div>
    
     <div class="forgot_error" id="forgot_message" style="display:none;"></div>
     
	 <form id="frm_message" name="frm_message" method="post" autocomplete="on">
    <div class="login_fieldbox">
    	<input name="email_message" id="email_message" type="text" class="login_txtfield" placeholder="Email">
    </div>
   
   
    <div class="forgot_remember">
   
    <input name="message_submit" id="message_submit" type="button" value="SUBMIT" class="btn_forgot">
    </form>
    </div>
</div>
<a class="close-reveal-modal" >&#215;</a>
</div>


<div id="confirm" class="reveal-modal">
<div class="forgot_box" style="min-height:70px">
   	<div class="reset_txt" style="margin-left:20px; font-size:12px">Password reset instructions have been sent to your email.</div>

</div>
<a class="close-reveal-modal" >&#215;</a>
</div>

<div id="confirm_message" class="reveal-modal">
<div class="forgot_box" style="min-height:70px">
   	<div class="reset_txt" style="margin-left:20px; font-size:12px">Thank you for subscribing, stay tuned for newsletters!</div>

</div>
<a class="close-reveal-modal" >&#215;</a>
</div>


<div id="signupBox" class="reveal-modal" style="left:60%;">
<div class="login_box" style="min-height:562px;">
	<h1>Sign Up</h1>
    <a href="<?php echo $loginUrl; ?>"><div class="connect_fb"></div></a>
    <div class="or"><img src="<?php echo URI_ROOT ?>images/or.jpg" ></div>
     <div class="login_error" id="signup_error" style="display:none;"></div>
     <form id="frm_signup" name="frm_signup" method="post" autocomplete="off">
     <div class="login_fieldbox">
    	<input name="first_name" id="first_name" type="text" class="login_txtfield" placeholder="First Name">
    </div>
     <div class="login_fieldbox">
    	<input name="last_name" id="last_name"  type="text" class="login_txtfield" placeholder="Last Name">
    </div>
    <div class="login_fieldbox">
    	<input name="email_signup" id="email_signup" type="text" class="login_txtfield" placeholder="Email">
    </div>
    <!--<div class="login_fieldbox">
    	<input name="" type="text" class="login_txtfield" placeholder="Confirm Email">
    </div>-->
    <div class="login_fieldbox">
    	<input name="password_signup" id="password_signup" type="text" class="login_txtfield" placeholder="Password">
    </div>
    <div class="forgot_remember">
    
    <span class="frgtpwd"><a style="cursor:pointer;" id="login_btn1" class="big-link" data-reveal-id="loginBox" data-animation="fadeAndPop">Already have an account</a></span>
    <input name="signup" id="signup" type="button" value="Register" class="btn_signin">
    </div>
    </form>
</div>
<a class="close-reveal-modal">&#215;</a>
</div>


<?php
	$start_min_price	= planning::get_minprice(); 
	$end_max_price		= planning::get_maxprice(); 
	?>
    
    <script>
	$(document).ready(function() {
		
		$("#bachelor_search").validate({
			wrapper:'span',
			ignore: [],
			rules: {
				location_id1: "required"
			},
			messages: {
				location_id1:  "Location is required"
			},
			showErrors: function (errorMap, errorList) {
				this.defaultShowErrors();
				$.each(errorList, function (i, error) {
					$('label.error').css("padding-left", ".0em");
					$('label.error').css("padding-top", "3.5em");
				});
			}			
		});
		
		$("#wed_date" ).datepicker({
			dateFormat: 'dd/mm/yy',
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			showAnim : "show",
			closeText : "Done",
			//currentText: "Today",
			autoSize: false,
			dayNamesMin: 	["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"], 
			monthNamesShort:["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			nextText: "Next",
			prevText: "Prev",
			showMonthAfterYear: true,
			yearRange: '-100:+20',
			minDate:0,
			beforeShow: function (input) { 
				dpClearButton(input);    
				//dpMaxButton(input); 
			}
			
		});
		
		$('.ui-datepicker-current').hide();
		
		$('.login_box').mouseover(function(){
			//$("#wed_date" ).datepicker( "hide" );
			//$('#search_btn2').focus();
		});

		
		$('#search_btn1').click(function() {
			var location_id = $('#6').val();
			var party_size  = $('#8').val();
			var price_range = $('#7').val();
			
			//alert(	price_range);	
			window.location= '<?php echo URI_ROOT ?>full_list.php?party_type=1&location='+location_id+'&vendor_type=1&p_id='+price_range+'&party_size='+party_size;
		});
		
		$('#search_btn2').click(function() {
			var location_id = $('#9').val();
			var price_range = $('#10').val();
			var wed_date	= $('#wed_date').val();
			if(wed_date != '')
			{
				window.location= '<?php echo URI_ROOT ?>full_list.php?party_type=2&location='+location_id+'&vendor_type=1&p_id='+price_range+'&wed_date='+wed_date;
			}
			else
			{
				window.location= '<?php echo URI_ROOT ?>full_list.php?party_type=2&location='+location_id+'&vendor_type=1&p_id='+price_range;
			}
		});
	
	});
	
	function dpClearButton (input) {
		setTimeout(function () {
			var buttonPane = $(input)
			.datepicker("widget")
			.find(".ui-datepicker-buttonpane");
	
			$("<button>", {
				text: "Clear",
				click: function () { jQuery.datepicker._clearDate(input); }
			}).appendTo(buttonPane).addClass("ui-datepicker-clear ui-state-default ui-priority-primary ui-corner-all");
		}, 1)
	}
	function dpMaxButton (input) {
		setTimeout(function () {
			var buttonPane = $(input)
			.datepicker("widget")
			.find(".ui-datepicker-buttonpane");
			$("<button>", {
				text: "Max",
				click: function () { 
					 jQuery(input).datepicker('setDate', '31-Dec-9999');   
					 jQuery(input).datepicker('hide'); }
			}).appendTo(buttonPane).addClass("ui-datepicker-clear ui-state-default ui-priority-primary ui-corner-all");
		}, 1)
	}
	
	</script>
    
    <style>
	.ui-widget{ font-size:16px !important; }
	.ui-widget button {font-size:14px !important;}
	.ui-priority-primary {font-weight:normal;}
	</style>
    
    <form name="bachelor_search" method="post" id="bachelor_search" >
    <div id="bachelorparty" class="reveal-modal" style="left:60%;">
		<div class="login_box">
			<i class="left_seach_heading_icn"><img src="<?php echo URI_ROOT ?>images/curated_hed_icn.jpg" width="74" height="62"></i>
            <div class="bachelor_party_hd">Bachelor Party</div>
            <div class="pickur_loc">Pick your Location
                <div class="pickur_locselctlarge" id="bach_loc">
                    <select name="location_id1" class="ordinnary_text_form" id="6">
                       <!-- <option value="">Filter Items By Location</option>-->
                        <?php

                            $location_array = location::get_location_options();
                
                            for($i = 0; $i < count($location_array); $i++)
                            {
                                $select = ' ';
								
								if($location_array[$i]->location_id != 1) continue;
                
                                if($location_array[$i]->location_id == $location_id)
                                {
                                    $select = ' selected ';
                                }                         
                
                                echo '<option  value="' . $location_array[$i]->location_id  . '" ' . $select . '>' . functions::deformat_string($location_array[$i]->name ) . '</option>';
                            }
                
                            ?>
                        </select>
                </div>
            </div>
         
            <div class="price_rangeb">Price Range
          
           <!-- <input name="" type="text" class="price_rangetxt" value="$500 - $2000">-->
           <div class="price_rangetxt3">
           <select name="type_annonce" class="ordinnary_text_form" id="7">
			   <?php 
                $database 	= new database();
                $sql 		= "SELECT * FROM price_range WHERE status='Y' ORDER BY order_id ASC";
                $result		= $database->query($sql);
                if($result->num_rows > 0)
                {
                    while($data  = $result->fetch_object())
                    {
                        echo '<option value="'. $data->price_range_id.'">'.functions::deformat_string(($data->bachelor_title)).'</option>';
                    }
                }
               ?>
                         
             </select>
             </div>
            </div>
            
            
            
            <div class="price_rangeb1">Party Size
            <div class="price_rangetxt2 pd_lft">
            <select name="type_annonce" class="ordinnary_text_form" id="8">
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10+</option>
                        </select>
            </div>
            </div>
    	<input name="search_btn1" id="search_btn1" type="button" value="Submit" class="bc_btn_submit">
      <!--  <input type="hidden" name="party_type_bachelor" id="party_type_bachelor" value="0" />-->
        
        </div>
        <a class="close-reveal-modal">&#215;</a>
        </div>
</form>


     <form name="wedding_search" method="post" id="wedding_search" >
    <div id="weddingparty" class="reveal-modal" style="left:60%;">
		<div class="login_box">
			<i class="left_seach_heading_icn"><img src="<?php echo URI_ROOT ?>images/curated_hed_icn.jpg" width="74" height="62"></i>
            <div class="bachelor_party_hd">Wedding</div>
            <div class="pickur_loc">Pick your Location
                <div class="pickur_locselctlarge" >
					<select name="location_id2" class="ordinnary_text_form" id="9">
                       <!-- <option value="">Filter Items By Location</option>-->
                        <?php

                            $location_array = location::get_location_options();
                
                            for($i = 0; $i < count($location_array); $i++)
                            {
                                $select = ' ';
                				if($location_array[$i]->location_id != 2) continue;
                                if($location_array[$i]->location_id == $location_id)
                                {
                                    $select = ' selected ';
                                }                         
                
                                echo '<option  value="' . $location_array[$i]->location_id  . '" ' . $select . '>' . functions::deformat_string($location_array[$i]->name ) . '</option>';
                            }
                
                            ?>
                        </select>

                </div>

                
            </div>
            
                       
      
      
            <div class="price_rangeb">Price Range
          
           <!-- <input name="" type="text" class="price_rangetxt" value="$500 - $2000">-->
           <div class="price_rangetxt3">
           <select name="type_annonce2" class="ordinnary_text_form" id="10">
			   <?php 
                $database 	= new database();
                $sql 		= "SELECT * FROM price_range WHERE status='Y' ORDER BY order_id ASC";
                $result		= $database->query($sql);
                if($result->num_rows > 0)
                {
                    while($data  = $result->fetch_object())
                    {
                        echo '<option value="'. $data->price_range_id.'">'.functions::deformat_string(($data->wedding_title)).'</option>';
                    }
                }
               ?>
                         
             </select>
             </div>
            </div>
            
            <div class="price_rangeb1">Wedding Day
             
            	<input name="wed_date" id="wed_date" type="text" class="wed_datetxt dateid textfld-textarea-text" placeholder="Select date" value="" readonly="yes">
            </div>
    	<input name="search_btn1" id="search_btn2" type="button" value="Submit" class="bc_btn_submit">
        
        </div>
        <a class="close-reveal-modal">&#215;</a>
        </div>
	</form>

	 
	  <script>
					
			
			$(document).ready(function ()
			{
				$('#bachelorparty_btn, #bachelorparty_btn1, #wedding_btn, #wedding_btn1').click(function(e) {
					e.preventDefault();
					var modalLocation = $(this).attr('data-reveal-id');
					$('#'+modalLocation).reveal($(this).data());		
					$('#wed_date').val('');	
				});
		
			});
	
		</script>

		<div class="block-popup report-popup spam_rep reveal-modal" id="profileBox" style=" background:#313131;">

            <div class="block-popup-in" id="block-flag" style="min-height:205px;">
                <div class="title-popup-in">
                    <h2>Notification</h2>
                </div>
				
                <div class="block-popup-in-2">
                        <div>
                            <div class="line1" style="text-align:center;">
                                  Your profile information has been saved successfully
                          </div>

                        </div>
                </div>
                
            </div>
            <a class="close-reveal-modal">&#215;</a>
        </div>
		
		
				<div class="block-popup report-popup spam_rep reveal-modal" id="msgBox" style=" background:#313131;">

            <div class="block-popup-in" id="block-flag" style="min-height:205px;">
                <div class="title-popup-in">
                    <h2>Notification</h2>
                </div>
				
                <div class="block-popup-in-2">
                        <div>
                            <div class="line1" style="text-align:center;" id="msg_noti">
                               
                          </div>

                        </div>
                </div>
                
            </div>
            <a class="close-reveal-modal">&#215;</a>
        </div>
		