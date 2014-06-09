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
?>



<?php
$name 	= ucfirst(functions::deformat_string($member->first_name)) .' '. strtoupper(substr($member->last_name, 0, 1)) .'.';

?>

<script type="text/javascript" src="<?php echo URI_LIBRARY ?>customSelect/jquery.customSelect.js"></script>
<script>

$(document).ready( function()
{
	$('#demo-select_1').customSelect();
	
    $('#show_pass').click(function() {
	 if($('#existing_password').attr('type') == 'text') {
		  $('#existing_password').prop('type', 'password');
		  $(this).html('Show Password');
	   }
	   else
	   {
	   		$('#existing_password').prop('type', 'text');
			$(this).html('Hide Password');
	   }
	});
	
	$('#show_pass1').click(function() {
	 if($('#new_password').attr('type') == 'text') {
		  $('#new_password').prop('type', 'password');
		  $(this).html('Show Password');
	   }
	   else
	   {
	   		$('#new_password').prop('type', 'text');
			$(this).html('Hide Password');
	   }
	});


	$('#demo-select_1').change(function()
	{
		var select_id = $(this).val();
		$('#recent_form').submit();
		
	});
	
	$("#frm_contact").validate({		
		rules: {
			first_name: "required",
			last_name: "required",
			email: {
			   required:true,
			   email: true,
			  minlength: 4,
			  maxlength: 25
			}
		},
		messages: {
			first_name : "First name is required",
			last_name : "Last name is required",
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

	$("#frm_password").validate({		
		rules: {
			existing_password: "required",
			new_password: {
				required: true,
				/*maxlength: 15,*/
				minlength: 4
			}
		},
		messages: {
			existing_password : "Existing password cannot be blank",
			new_password: {
				required: "New password cannot be blank",
				minlength: "Password should be atleast {0} characters"
				/*maxlength: "Password not more than {0} characters"*/
			}
			
		},
		showErrors: function (errorMap, errorList) {
   			this.defaultShowErrors();
    		$.each(errorList, function (i, error) {
				$('label.error').css("padding-left", ".0em");
    		});
		}		
	});

});



function validate_password()
    { 
   		if($("#frm_password").valid())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function validate_contact()
    { 
   		if($("#frm_contact").valid())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

function show_notification(id)
{   if(id == 1)
	{
    	$('#msg_noti').html('Your password has been changed successfully');
	}
	else
	{
		$('#msg_noti').html('Your contact information has been saved successfully');
	}
	$('#msgBox').reveal();
}
</script>


<style type="text/css">
span.customSelect {
	font-size:11px;
	background: url("../images/select-bg.gif") no-repeat scroll right 0 #FFF;
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

$mesg_error = '';
$mesg 		= '';
$mesg_error1 = '';
$mesg1		= '';

if(isset($_REQUEST['save']))
{
	$member->member_id			= $member->member_id;
	$member->username			= functions::clean_string($_POST['email']);
	$member->email				= functions::clean_string($_POST['email']);
	$member->first_name			= functions::clean_string($_POST['first_name']);
	$member->last_name			= functions::clean_string($_POST['last_name']);
	$member->city				= functions::clean_string($_POST['city']);
	$member->state_id			= functions::clean_string($_POST['state_id']);
	
	$validation		= new validation();
	$validation->check_blank($member->email, "Email", "email");
	$validation->check_email($member->email, "Email", "email");
	$validation->check_blank($member->first_name, "First name", "first_name");
	$validation->check_blank($member->last_name, "Last name", "last_name");
	//$validation->check_blank($member->city, "City", "city");
	//validation->check_blank($member->state_id, "State", "state_id");

	if (!$validation->checkErrors())
	{
		if($member->update_contact_info())
		{
			$mesg = $member->message;
		}
		else
		{
			$mesg_error = $member->message;
		}
	}
	else
	{
		$member->error	= $validation->getallerrors();
	}
}

if(isset($_REQUEST['save1']))
{
    $member->member_id					= $member->member_id;
	$member->existing_password			= functions::clean_string($_POST['existing_password']);
	$member->new_password				= functions::clean_string($_POST['new_password']);
	
	$validation		= new validation();
	$validation->check_blank($member->existing_password, "Existing password", "existing_password");
	$validation->check_blank($member->new_password, "New password", "new_password");
	$validation->check_length($member->new_password, 4, 15, "New password", "new_password");
	if (!$validation->checkErrors())
	{
		if($member->update_password_user())
		{
			$mesg1 = $member->message;
		}
		else
		{
			$mesg_error1 = $member->message;
		}
	}
	else
	{
		$member->error	= $validation->getallerrors();
	}
}


if($mesg1 != '' )
{
	echo '<script>'; ?>
	show_notification(1);

	<?php
	echo '</script>';
}

if($mesg != '' )
{
	echo '<script>'; ?>
	show_notification(2);

	<?php
	echo '</script>';
}


?>




<section class="contentwrapper">
	
	<div class="content_inner clearfix">
	
	
	
	<section class="about_heading">
	<h2><span>MY PROFILE</span></h2>
	</section>
	
	
	<?php include_once DIR_ROOT . 'inc_profile_left.php'; 
	

	?>
	
    <section class="about_right account">
	
	<form  name ="frm_contact" id="frm_contact" method="post" action="" onsubmit="return validate_contact()"> 
	<div class="login_error" id="contact_error" <?php echo ($mesg_error == '') ? 'style="display:none;"' : ''; ?>><?php echo $mesg_error ?></div>
	<button type="submit" class="but-big but-red">Save</button>
	<h3>Contact Information</h3>
	<div class="block-profile-line" style="padding-bottom:10px;"></div>
	
	<!--<div class="myprfl_line"></div>-->
	
	
	<div class="block-profile-col">
                <div class="control-group">
                    <label class="required" ><span class="required">*</span>First Name:</label> 
					
				<input type="text" maxlength="255" id="first_name" name="first_name" value="<?php echo functions::format_text_field($member->first_name)?>" />      
				  </div>


                <!--                Last Name-->
                <div class="control-group">
                    <label class="required" ><span class="required">*</span>Last Name:</label>  
					                  <input type="text" maxlength="255" id="last_name" name="last_name" value="<?php echo functions::format_text_field($member->last_name)?>" />   
									                                   </div>
            </div>
			
			<div class="block-profile-col">
                <div class="control-group">
                    <label class="required" for="User_email"><span class="required">*</span>Email:</label>   
					
					<input type="text" value="<?php echo functions::format_text_field($member->email)?>" maxlength="255" id="email" name="email">    
					                                </div>


                <div class="control-group sel-2">
                    <label for="User_state">State</label>
                    <p class="label" style="width:310px;">
                        <select name="state_id" id="demo-select_1">
        <optgroup label="">
            <option value="">--State--</option>
            
            <?php 
				$database 	= new database();
				$sql 		= "SELECT * FROM tsn_states WHERE country_id=223 AND state_name_en != '' ORDER BY state_name_en ASC";
            	$result 	= $database->query($sql);
				if($result->num_rows > 0)
				{
					
					while($data   = $result->fetch_object())
					{
					    $sel = '';
						if($data->state_code == $member->state_id)
						{
							$sel = 'selected';
						}
						echo '<option value="'.$data->state_code .'" '. $sel . ' >'. $data->state_name_en.'</option>';	
					}
				}
			?>
        </optgroup>
        </select>          </p>

                                    </div>

                <div class="control-group sel-2">
                    <div>

                        <label for="User_city">City</label>                        <p class="label">
                            <input type="text" value="<?php echo functions::format_text_field($member->city)?>" id="city" name="city" style="width:136px;">                        </p>
                                            </div>

                </div>
            </div>
			
			<input type="hidden" name="save" id="save" value="save" />
            </form>
			
			<h3>Change Password</h3>
			<div class="block-profile-line" style="padding-bottom:10px;"></div>
			
			<div class="login_error" id="password_error" <?php echo ($mesg_error1 == '') ? 'style="display:none;"' : ''; ?>><?php echo $mesg_error1 ?></div>
			
            <form  name ="frm_password" id="frm_password" method="post" action="" onsubmit="return validate_password()">    
			        <div class="block-change_password">
                <div class="block-profile-col">
                    <div class="control-group" style="height: 65px;">
                        <label><span class="required">*</span>Enter Existing Password: </label>

                        <input type="password" id="existing_password" name="existing_password">                        
                    <a style="cursor:pointer;" id="show_pass"  class="link-show_password" style="left: 144px; top: 40px;">Show Password</a><input type="text" class="password-showing" style="display: none; left: 0px; top: 27px;"></div>
                </div>
                <div class="block-profile-col">
                    <div class="control-group" style="height: 65px;">
                        <label><span class="required">*</span>Enter New Password:</label>
                        <input type="password" id="new_password" name="new_password">                                            
						<a style="cursor:pointer;" id="show_pass1" class="link-show_password" style="left: 144px; top: 40px;">Show Password</a><input type="text" class="password-showing" style="display: none; left: 0px; top: 27px;"></div>
                </div>
                 <button style="float:right;" class="but-big but-green" type="submit"> Change password</button>
            </div>
			
			<input type="hidden" name="save1" id="save1" value="save1" />
            </form>            <div class="box-account_bot">
                <div class="block-gray">
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td>
                                <p>USERNAME:</p>
                                <span><?php echo $name ?></span>
                            </td>
                            <td>
                                <p>MEMBER SINCE:</p>
                                <?php echo date(' M d , Y', strtotime($member->join_date))?><span> </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>ACCOUNT NUMBER:</p>
                                <span><?php echo $member->member_id ?></span>
                            </td>
                            <td>
                            <p>ACCOUNT TYPE:</p>
    									<span><?php echo ($member->role_id == 1 ) ? 'Admin': 'Standard'; ?></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
       
			

	</section> 
	 

	
	
	
	</div>
	
	</section>