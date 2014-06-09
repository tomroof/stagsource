<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= '';
$template->meta_keywords	= '';
$template->meta_description	= '';
$template->footer_content	= true;
$template->js				= '';
$template->css				= '';
$template->heading();

$main_content = new page_content(3);
if ($main_content->status == 'Y'){
	$main_content_title = $main_content->title;
	$main_content_text  = $main_content->content;
}


?>


<div id="contentarea">
<div class="content_container">
<div class="contentbox">
<div class="subcontent_box">
<div class="subbox_first">
<h1 class="subhdrtxt"> <?php echo functions::deformat_string($main_content_title); ?></h1>
<h1 class="subhdrtxt-new"> RAC Food & Wine Night </h1>
</div>
<div class="subcontent_boxlft">
<?php echo functions::deformat_string($main_content_text); ?>
</div>
<div class="subcontent_boxrght">

<img src="images/degustation-img.jpg" />
</div>

</div>

<div class="subcontentarea">
<?php
$degustation=new degustation();
$degustation->display_degustation();
?>
<!--<div class="subcontentarea_box">

<div class="degustation-box">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image.jpg" />  </span>
</div>


<div class="degustation-box-new rightalign">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt_rght"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image2.jpg" />  </span>
</div>

 </div>-->
<!--<div class="subcontentarea_box">
<div class="degustation-box">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image.jpg" />  </span>
</div>

<div class="degustation-box-new rightalign">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt_rght"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image3.jpg" />  </span>
</div>

 </div>-->

<!--<div class="subcontentarea_box">
<div class="degustation-box">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image.jpg" />  </span>
</div>

<div class="degustation-box-new rightalign">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt_rght"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image2.jpg" />  </span>
</div>

 </div>-->
 
<!--<div class="subcontentarea_box">
<div class="degustation-box">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image.jpg" />  </span>
</div>

<div class="degustation-box-new rightalign">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt_rght"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image3.jpg" />  </span>
</div>

 </div>-->
 
<!--<div class="subcontentarea_box">
<div class="degustation-box">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image.jpg" />  </span>
</div>

<div class="degustation-box-new rightalign">
<span class="partners-arrow"></span>
<span class="degustation-lft">
<span class="degustation-hdrtxt">Seared Scallops With Fennel & Bacon</span>
<span class="degustation_txt_rght"> if the degustation leaves any room at all in your belly, then the best thing to do is head around to over 80 produce and 40 winery stalls for complimentary tastings all night long. </span>
</span>
<span class="degustation_img"> <img src="images/degustation-image2.jpg" />  </span>
</div>

 </div>-->
 
<div class="subcontentarea_rght"> </div>
</div>

</div>

<?php include("inc_subscribe_box.php"); ?>

</div>
</div>


<?php
include ('inc_footer.php');
?>

