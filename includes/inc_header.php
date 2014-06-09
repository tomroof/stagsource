<?php 
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

?>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<?php if($page_name=="index.php" || $page_name=="entertainment.php")
{
?>
    
   <!-- <script type='text/javascript' src='js/jQuery.js'></script>
    <script type='text/javascript' src='js/Slideshow.js' charset='utf-8'></script>
    <link rel='stylesheet' type='text/css' href='css/Slideshow.css' />-->
 <?php
}
else if($page_name=="food-stall.php" || $page_name=="wineries.php")
{?> 
   <!-- <script src="js/jquery.js"></script> --> 
   <!-- <script src="js/jquery1.js"></script>-->
 <?php
}  
else if($page_name=="tickets.php" || $page_name=="contact.php")
{?>
	<!--<script type="text/javascript" src="js/textbox.js"></script>-->
 <?php
}
  
?>

</head>



<div id="header">
<div class="header_container">
<div class="logo"><a href="<?php echo URI_ROOT;?>" title="<?php echo SITE_NAME;?>"><img src="images/logo.png"  border="0" alt="<?php echo SITE_NAME;?>"/></a></div>
<div class="purchase-btn"><input name="" type="button" value="" /></div>
</div>
<div id="navigation">
<ul>
<?php
	/*$database	= new database();
	$sql="SELECT * FROM `page_content` WHERE `menu_name` <> '' order by `page_content_id` ASC";
	$result		= $database->query($sql);
	while($data=$result->fetch_object())
	{ 	
	$link=str_replace(".php", "", $data->page_name);
		if($data->page_content_id==1)
		$link=URI_ROOT;
		$page=$link.".php";
		echo'<li ';
		echo  $page_name==$page ?  'class="active"' : '' ;
		echo' > <a href="'.functions::deformat_string($link).'">'. $data->menu_name.'</a> </li>';
	
	}*/
?>










<!--<li <?php echo  $page_name=="index.php" ?  'class="active"' : '' ;?> > <a href="<?php echo URI_ROOT;?>">Home</a> </li>
<li <?php echo  $page_name=="about.php" ?  'class="active"' : '' ;?> > <a href="about">About</a> </li>
<li <?php echo  $page_name=="degustation.php" ?  'class="active"' : '' ;?> > <a href="degustation">Degustation</a> </li>
<li <?php echo  $page_name=="food-stall.php" ?  'class="active"' : '' ;?> > <a href="food-stall">Food stalls</a> </li>
<li <?php echo  $page_name=="wineries.php" ?  'class="active"' : '' ;?> > <a href="wineries">Wineries</a> </li>
<li <?php echo  $page_name=="entertainment.php" ?  'class="active"' : '' ;?> ><a href="entertainment">Entertainment</a> </li>
<li <?php echo  $page_name=="tickets.php" ?  'class="active"' : '' ;?> > <a href="tickets">Tickets</a> </li>
<li <?php echo  $page_name=="contact.php" ?  'class="active"' : '' ;?> > <a href="contact">Contact</a> </li>-->
</ul>
</div>
</div>