<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

// Cancel button action starts here
if(isset($_POST['cancel']))	
{
	functions::redirect('index.php');
}

$next_page		= false;
$member_id		= isset($_REQUEST['mid']) && $_REQUEST['mid'] > 0 ? $_REQUEST['mid'] : 0;
$unique_code	= isset($_REQUEST['uc']) && $_REQUEST['uc'] > 0 ? $_REQUEST['uc'] : 0;
$member			= new member();
if(!$member->validate_unique_code($member_id, $unique_code))
{
	functions::redirect('index.php');	
}

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= functions::deformat_string($content->title);
$template->meta_keywords	= functions::format_text_field($content->meta_keywords);
$template->meta_description	= functions::format_text_field($content->meta_description);
$template->js				= '';
$template->css				= '';
$template->heading();

// Save button action starts here
if(isset($_POST['save']))
{
	$member				= new member();
	$password			= functions::clean_string($_POST['password']);
	$confirm_password	= functions::clean_string($_POST['confirm_password']);
	
	$validation			= new validation();
	$validation->check_blank($password, "New password", "password");
	$validation->check_length($password, 5, 15, "New Password", "password");
	$validation->check_blank($confirm_password, "Confirmation password", "confirm_password");
	//$validation->check_length($confirm_password, 5, 15, "Confirmation password", "confirm_password");
	//$validation->check_compare($password, $confirm_password, "Confirmation password", "confirm_password");
	
	if (!$validation->checkErrors())
	{
		$member->member_id		= $member_id;
		$member->unique_code	= $unique_code;
		if($member->update_password($password, true))
		{
			$member->update_unique_code($member_id);
			$password			= '';
			$confirm_password	= '';
			$next_page			= true;
		}
	}
	else
	{
		$member->error	= $validation->getallerrors();
	}
	
	 
}
?>
<script type="text/javascript" language="javascript">

function validate_reset_password()
{
	$('.warningMesg').html('');
	$('.warningMesg').hide('');
	
	var valid_form 			= true;
	var focus_element		= '';
	
	
	var forms 				= document.frm_reset_password;
	var password			= forms.password.value;
	var confirm_password	= forms.confirm_password.value;
	
	
	/*var password			= $('#password').val();
	var confirm_password	= $('#confirm_password').val();*/
	
	
	if(password == '')
	{
		$('#message_password').html('Password cannot be empty');
		$('#message_password').show();
		valid_form 		= false;
		focus_element	= focus_element == '' ? 'password' : focus_element;
	}
	
	if(confirm_password == '')
	{
		$('#message_confirm_password').html('Confirmation password cannot be empty');
		$('#message_confirm_password').show();
		valid_form 		= false;
		focus_element	= focus_element == '' ? 'confirm_password' : focus_element;
	}
	
	if(password != confirm_password)
	{
		$('#message_confirm_password').html('Confirmation password is not matching');
		$('#message_confirm_password').show();
		valid_form 		= false;
		focus_element	= focus_element == '' ? 'confirm_email' : focus_element;
	}  
	
	if(focus_element != '')
	{
		$('#' + focus_element).focus();
	}
	
	if(valid_form)
	{
		$('#frm_reset_password').submit();
	}
}

$('input').keydown(function() {
	var selected_field	= ( $(this).attr('name') );
	if(trim($('#' + selected_field).val()) != '')
	{
		var message_box		= '#message_' + selected_field;
		$(message_box).html('');
		$(message_box).hide();
	}
});

$('.textbox3').keypress(function(e) {
	if(e.which == 13) {
		jQuery(this).blur();
		jQuery('#btn_reset_password').focus().click();
	}
});

</script>


<section class="inner_banner"></section>
<section class="contentwrapper">

<div class="content_inner clearfix" style="height:350px;">
    
    
				<?php
				if($next_page)
				{
					?>
					<br /><h1><img src="images/icon-tick1.png" style="vertical-align:bottom; height:36px; width:36px;" /> Your password has been reset!</h1><br />
				<?php
				}
				else
				{
					?>
                    <h1>Reset your password</h1> <br />
    
    				<span>Enter your new password to reset it.</span> <br />
                    
                     <br/ >
					<div id="message" class="warningMesg" style="display:none; "></div>
					<form name="frm_reset_password" id="frm_reset_password" method="post" action="" >
						<div class="signup-box1" style=" width:300px; height:60px; margin-bottom:30px;">
                         New password<br />  
							<input type="password" id="password" name="password" value="" class="login_txtfield" />
						<div id="message_password" class="warningMesg" <?php echo isset($member->error["password"]) ? ' style="display:block;" ' : ' style="display:none;" '; ?> ><?php echo $member->error["password"]; ?></div></div>
						
						<div class="signup-box1" style=" width:300px;  height:60px;">
						Confirm new password<br /> 
						<input type="password" id="confirm_password" name="confirm_password" value="" class="login_txtfield" />

						<div id="message_confirm_password" class="warningMesg" <?php echo isset($member->error["confirm_password"]) ? ' style="display:block;" ' : ' style="display:none;" '; ?> ><?php echo $member->error["confirm_password"]; ?></div>
						</div>
						<br />
						<input type="button" id="btn_reset_password" name="save" value="Reset Password" class="btn_forgot" title="Reset Password"  onclick="validate_reset_password();" />
						<br />
						<br />
						
						<input type="hidden" id="save" name="save" value="save" />
						<input type="hidden" id="mid" name="mid" value="<?php echo $member_id; ?>" />
						<input type="hidden" id="uc" name="uc" value="<?php echo $unique_code; ?>" />
					</form>
				<?php
				}
				?>
</div>
</section>
		
		


<?php $template->footer(); ?>
