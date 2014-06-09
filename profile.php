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
	
	$('#demo-select_1').change(function()
	{
		var select_id = $(this).val();
		$('#recent_form').submit();
		
	});

	$("#frm_profile").validate({		
		rules: {
			first_name: "required",
			last_name: "required",
			city: "required",
			state_id: "required",
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
			city	   : "City is required",
			state_id: "State is required",
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
	

	$('#submit_profile').click(function() {
		
		if($("#frm_profile").valid())
		{
			$('#frm_profile').submit();
		}
	});
});



$(document).ready(function()
{
	
	$("#uploadForm").on('change',(function(e){
		e.preventDefault();
		var file = $('input[type="file"]').val();
	
	    $('#loading').show();
		$('#pic_size').hide();
		 if(!isValidImage(file))
		 {
		 	$('#pic_error').show();
		  	$('#pic_error').html("Please select jpg/jpeg image");
			return false;
	     }
		 
		 $('#pic_error').hide();
		
		
		
		$.ajax(
			{
				type: "POST",
				cache: false,
				
				url: "<?php echo URI_ROOT ?>ajax_fileupload.php",
				data:  new FormData(this),
				contentType: false,
				processData:false,
				success: function (data)
				{
				//alert(data);
				    var row = data.split('<>');
					if(row[0] == 1)
					{
					var img 	= '<?php echo URI_MEMBER ?>thumb1_'+ row[2];
						$('#pic_size').show();
						$('#pic_size').html(row[1]);
						$('#profile_img').html('<img src="'+img+'">');
					}
					else
					{
						$('#pic_error').show();
						$('#pic_error').html(row[1]);
					}
					$('#loading').hide();
				}
			});
		
		
		
	}));
	
	
}); 

function isValidImage(filename)
    { 
   		var file_value = filename;
		var checkimg = file_value.toLowerCase();
		if (!checkimg.match(/(\.jpg|\.jpeg|\.)$/))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

function show_profile_notification()
{
	$('#profileBox').reveal();
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

if(isset($_REQUEST['save']))
{
	$member->member_id			= $member->member_id;
	$member->username			= functions::clean_string($_POST['email']);
	$member->email				= functions::clean_string($_POST['email']);
	$member->first_name			= functions::clean_string($_POST['first_name']);
	$member->last_name			= functions::clean_string($_POST['last_name']);
	$member->city				= functions::clean_string($_POST['city']);
	$member->state_id			= functions::clean_string($_POST['state_id']);
	$member->zip				= functions::clean_string($_POST['zip']);
	$member->favorites_1				= functions::clean_string($_POST['favorites_1']);
	$member->favorites_2				= functions::clean_string($_POST['favorites_2']);
	$member->favorites_3				= functions::clean_string($_POST['favorites_3']);
	$member->favorites_4				= functions::clean_string($_POST['favorites_4']);
	
	$validation		= new validation();
	$validation->check_blank($member->email, "Email", "email");
	$validation->check_email($member->email, "Email", "email");
	$validation->check_blank($member->first_name, "First name", "first_name");
	$validation->check_blank($member->last_name, "Last name", "last_name");
	$validation->check_blank($member->city, "City", "city");
	$validation->check_blank($member->state_id, "State", "state_id");

	if (!$validation->checkErrors())
	{
		if($member->update_profile_details())
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

if($mesg != '')
{
	echo '<script>'; ?>
	show_profile_notification();

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
	
      
    
    
  

	
	<section class="about_right">
	
	<span class="myprfl_h1">Enter Your Information Below</span>
	
	<div class="myprfl_line"></div>
	
	<div class="upload_section">
	
	<div class="upload_h1"><span class="upload_h1_sub"><sup>*</sup></span> Upload Photo</div>
	
	<div class="upload_img" id="profile_img">
    <?php if(file_exists(DIR_MEMBER . $member->avatar) && $member->avatar != '')
	  {
		  $image_name = $member->avatar;
		  $size_1	= getimagesize(DIR_MEMBER.$image_name);
		  $imageLib = new imageLib(DIR_MEMBER.$image_name);
		  $imageLib->resizeImage(86, 87, 0);	
		  $imageLib->saveImage(DIR_MEMBER.'thumb1_'.$image_name, 90);
		  unset($imageLib);
		  echo ' <img src="'.URI_MEMBER.'thumb1_'.$image_name.'">'; 
	  } 
	  /*else if($member->fb_id != '')
	  {
		//echo '<img src="https://graph.facebook.com/'.$member->fb_id.'/picture" width="84px" height="52px">';  
	  }*/
	  else
	  {
		 echo ' <img src="'.URI_ROOT.'images/upload_img.png">'; 
	  }
	?>
    
    
    
    </div>
	
   <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
  


<div class="fileUpload">
	<span >BROWSE</span>
    <input name="userImage" id="userImage" type="file" class="upload" accept="image/*" />
</div>
<div class="loading">
<img id="loading" src="<?php echo URI_ROOT ?>images/loading.gif"  style="display:none;" width="20" height="20">
</div>
<div class="pic_error" id="pic_error" ></div>
<div class="pic_size" id="pic_size" ></div>
</form>
	<!--<a href="#"><span class="upload_borws">BROWSE</span></a>-->
	
    <div id='preview'>
    </div>

	</div>
	
	
	<div class="myprfl_frmline"></div>
	
	 <div class="login_error" id="profile_error" <?php echo ($mesg_error == '') ? 'style="display:none;"' : ''; ?>><?php echo $mesg_error ?></div>
    
    
    <form name="frm_profile" id="frm_profile" method="post" autocomplete="off" />
	
	<div class="myprfl_frmh1"><span class="upload_h1_sub"><sup>*</sup></span> Profile Information</div>
	
	<div class="myprfl_frmoutr">
    
            
	<div class="myprfl_frmrbox ">
    <div class="placeholder-wrap">
        <input type="text" id="first_name" name="first_name" value="<?php echo functions::format_text_field($member->first_name) ?>" onblur="fillText2(this)" onfocus="clearText2(this)"/>
        
        <span class="placeholder" id="hold_first_name" <?php if($member->first_name != '') { echo 'style="display:none;"'; }?>>
            First Name <span class="required">*</span>
        </span>
    </div>
		
    
    <!--<input name="first_name" id="first_name" value="<?php echo functions::format_text_field($member->first_name) ?>" type="text" placeholder="First Name *" val1="First Name*" onblur="fillText1(this)" onfocus="clearText1(this)">-->
    </div>
	<div class="myprfl_frmrbox myprfl_frmrbox_rght">
    <div class="placeholder-wrap">
        <input type="text" id="last_name" name="last_name" value="<?php echo functions::format_text_field($member->last_name) ?>" onblur="fillText2(this)" onfocus="clearText2(this)"/>
        
        <span class="placeholder" id="hold_last_name" <?php if($member->last_name != '') { echo 'style="display:none;"'; }?>>
            Last Name <span class="required">*</span>
        </span>
    </div>
    </div>
	</div>
	
	<div class="myprfl_frmoutr">
	<div class="myprfl_frmrbox"><div class="placeholder-wrap">
        <input type="text" id="city" name="city" value="<?php echo functions::format_text_field($member->city) ?>" onblur="fillText2(this)" onfocus="clearText2(this)"/>
        
        <span class="placeholder" id="hold_city" <?php if($member->city != '') { echo 'style="display:none;"'; }?>>
            City <span class="required">*</span>
        </span>
    </div></div>
	<div class="myprfl_frmrbox myprfl_frmrbox_rght">
    	<select name="state_id" id="demo-select_1" style="width:268px;">
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
        </select>
    </div>
	</div>

	<div class="myprfl_frmoutr">
	<div class="myprfl_frmrbox">
    <div class="placeholder-wrap">
        <input type="text" id="email" name="email" value="<?php echo functions::format_text_field($member->email) ?>" onblur="fillText2(this)" onfocus="clearText2(this)"/>
        
        <span class="placeholder" id="hold_email" <?php if($member->email != '') { echo 'style="display:none;"'; }?>>
            Email <span class="required">*</span>
        </span>
    </div>
    
    </div>
	<div class="myprfl_frmrbox myprfl_frmrbox_rght">
    <div class="placeholder-wrap">
        <input type="text" id="zip" name="zip" value="<?php echo functions::format_text_field($member->zip) ?>" onblur="fillText2(this)" onfocus="clearText2(this)"/>
        
        <span class="placeholder" id="hold_zip" <?php if($member->zip != '') { echo 'style="display:none;"'; }?>>
            Zip
        </span>
    </div>
    </div>
	</div>


	<div class="myprfl_frmline"></div>
	
	<div class="myprfl_frmh1">Favorites</div>
	
	<div class="myprfl_txtareabox">
    <p class="label text-5"><textarea onblur="fillText1(this)" onfocus="clearText1(this)" name="favorites_1" id="favorites_1" val1="List your favorite proposal ideas..."><?php echo ($member->favorites_1 != '') ? $member->favorites_1 : 'List your favorite proposal ideas...'; ?></textarea>                                                                  
   </p>
    
    <!--<textarea name="favorites_1" id="favorites_1"  onblur="fillText(this)" onfocus="clearText(this)">List your favorite proposal ideas...</textarea>--></div>
	
	<div class="myprfl_txtareabox">
     <p class="label text-5"><textarea onblur="fillText1(this)" onfocus="clearText1(this)" name="favorites_2" id="favorites_2" val1="List your favorite bachelor party destinations..."><?php echo ($member->favorites_2 != '') ? $member->favorites_2 : 'List your favorite bachelor party destinations...'; ?></textarea>                                                                  
   </p>
   </div>
	
	<div class="myprfl_txtareabox">
    <p class="label text-5"><textarea onblur="fillText1(this)" onfocus="clearText1(this)" name="favorites_3" id="favorites_3" val1="List your favorite wedding locations..."><?php echo ($member->favorites_3 != '') ? $member->favorites_3 : 'List your favorite wedding locations...'; ?></textarea>                                                                  
   </p>
    </div>
	
	<div class="myprfl_txtareabox">
    <p class="label text-5"><textarea onblur="fillText1(this)" onfocus="clearText1(this)" name="favorites_4" id="favorites_4" val1="List your favorite honeymoon destinations..."><?php echo ($member->favorites_4 != '') ? $member->favorites_4 : 'List your favorite honeymoon destinations...'; ?></textarea>                                                                  
   </p>
  
    
    </div>
	
	
    
    
	
	
	
	</section>
	
	<input type="hidden" name="member_id" id="member_id" value="<?php echo $member->member_id ?>" />
	<input type="hidden" name="save" id="save" value="save" />
    
    </form>
    
    
	
	
	<div class="myprfl_bottom">
	<div class="myprfl_bttmline"></div>
	
	
	<a style="cursor:pointer;" id="submit_profile"><span class="saveprofile_but">SAVE PROFILE</span></a>
	</div>
	
	
	</div>
	
	</section>