
<?php
if(!isset($_SESSION[MEMBER_ID]))
{
	functions::redirect(URI_ROOT);
	exit;	
}

$member	= new member($_SESSION[MEMBER_ID]);

?>

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
		echo '<img src="https://graph.facebook.com/'.$member->fb_id.'/picture" width="84px" height="52px">';  
	  }
	  else
	  {
		 echo ' <img src="'.URI_ROOT.'images/picture.jpg">'; 
	  }?>
    
    </span>
	<a href="<?php echo URI_ROOT ?>user/PublicProfile/<?php echo $member->member_id ?>"><span class="profile_but">PROFILE</span></a>
	<span class="profile_name"><?php echo $name ?></span>
	</div>
	
	
	<aside class="about_left">
	<div class="about_left_h1">Dashboard</div>
	<!-- if($id == 'profile' || $id == 'profile/RecentActivity')
{ -->
	<div class="about_left_list">
	<a href="<?php echo URI_ROOT ?>user/RecentActivity"><span class="sb-icon1 <?php echo ($id == 'RecentActivity' || $id == 'profile/RecentActivity') ? 'sb-icon1a' : ''; ?>">MY DASHBOARD</span></a>
	<a href="<?php echo URI_ROOT ?>user/profile"><span class="sb-icon2 <?php echo ($id == 'profile') ? 'sb-icon1a' : ''; ?>"> MY PROFILE</span></a>
	<a href="<?php echo URI_ROOT ?>user/calendar"><span class="sb-icon3 <?php echo ($id == 'calendar') ? 'sb-icon1a' : ''; ?>"> CALENDAR </span></a>
	<a href="<?php echo URI_ROOT ?>user/accountsettings"><span class="sb-icon4  <?php echo ($id == 'accountsettings') ? 'sb-icon1a' : ''; ?>"> ACCOUNT SETTINGS</span></a>
	<a href="<?php echo URI_ROOT ?>user/InviteFriends"><span class="sb-icon5 <?php echo ($id == 'InviteFriends') ? 'sb-icon1a' : ''; ?>">INVITE FRIENDS</span></a>
	</div>
	
	</aside>
	
	
	
	
	</div>