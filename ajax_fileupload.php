<?php
//ob_start("ob_gzhandler");
ob_start();
session_start();
include_once("includes/config.php");
set_time_limit(0);

$member  =  new member($_SESSION[MEMBER_ID]);

$max_upload_limit	= 1024 * 3;
$allowed_extensions	= 'jpg,jpeg';
$image_size				= array(MEMBER_MIN_WIDTH,MEMBER_MIN_HEIGHT,MEMBER_MAX_WIDTH,MEMBER_MAX_HEIGHT, MEMBER_THUMB_WIDTH, MEMBER_THUMB_HEIGHT, 0, 0);

$uploaded_file		= $_FILES['userImage'];

$error = "";
$msg = "";

$fileElementName = 'userImage';
$upload_dir	=  DIR_MEMBER. $_FILES['userImage']['name'];
			
$validation		= new validation();
if(is_uploaded_file($uploaded_file['tmp_name']))
{
	$validation->is_uploaded($uploaded_file, 'File' , "userImage");
	$validation->check_min_image_size($uploaded_file, 'Image' , "userImage", $image_size);
}
if (!$validation->checkErrors())
{
	$functions		= new functions;
	if(is_uploaded_file($uploaded_file['tmp_name']))
	{
		$file_name		=  $functions->upload_file($uploaded_file, DIR_MEMBER, $allowed_extensions, $max_upload_limit, true, '');
	}
					
	if(!$functions->warning)
	{
		$file_size = round(filesize(DIR_MEMBER .$file_name)/(1024 * 1024), 2).' MB';
		$image_name = $file_name;
		$size_1	= getimagesize(DIR_MEMBER.$image_name);
		$imageLib = new imageLib(DIR_MEMBER.$image_name);
		$imageLib->resizeImage(86, 87, 0);	
		$imageLib->saveImage(DIR_MEMBER.'thumb1_'.$image_name, 90);
		unset($imageLib);
		
		
		if($member->avatar != '')
		{
			if(file_exists(DIR_MEMBER . $member->avatar))
			{
				unlink(DIR_MEMBER . $member->avatar);
			}
			if(file_exists(DIR_MEMBER . 'thumb_'. $member->avatar))
			{
				unlink(DIR_MEMBER . 'thumb_'. $member->avatar);
			}
			if(file_exists(DIR_MEMBER . 'thumb1_'. $member->avatar))
			{
				unlink(DIR_MEMBER . 'thumb1_'.$member->avatar);
			}
			if(file_exists(DIR_MEMBER . 'thumbresize_'. $member->avatar))
			{
				unlink(DIR_MEMBER . 'thumbresize_'.$member->avatar);
			}
		}
		
		$database = new database();
		$sql 	 = "UPDATE member SET avatar = '". $file_name. "' WHERE member_id =".$_SESSION[MEMBER_ID];
		$result 	= $database->query($sql);
		  
		echo "1<>". substr($file_name, 33)." ".$file_size."<>".$file_name;
	}
	else
	{
		echo "0<>".$functions->message;
	} 
}
else
{
	$va = $validation->getallerrors();
	echo "0<>".$validation->error['userImage'];
}  
 
	


?>