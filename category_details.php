<?php
ob_start("ob_gzhandler");
session_start();

include_once("includes/config.php");

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= 'Stagsource';
$template->meta_keywords	= 'Stagsource';
$template->meta_description	= 'Stagsource';
$template->footer_content	= true;
$template->js				= '<script type="text/javascript" src="'.URI_LIBRARY.'select/jquery.selectbox-0.2.js"></script>
								<script type="text/javascript" src="'.URI_LIBRARY.'select/functions.js"></script>';
$template->css				= ' <link href="'.URI_ROOT.'css/hover_content.css" rel="stylesheet" type="text/css"/>
								<link href="'.URI_LIBRARY.'select/jquery.selectbox.css" type="text/css" rel="stylesheet"/>
								<link rel="stylesheet" type="text/css" href="css/component.css" />';
$template->heading();
$content   = new content();

$id 	= (isset($_REQUEST['id']) &&  $_REQUEST['id']) != '' ? $_REQUEST['id'] : '';
echo $content_id 	= (isset($_REQUEST['content_id']) &&  $_REQUEST['content_id']) != '' ? $_REQUEST['content_id'] : '';

$id		= str_replace('/', '', $id);

echo $category_id 	= category::get_category_id_byname($id);


?>






<h2>
<span>Bachelor Party</span>
</h2>