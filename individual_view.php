<?php
ob_start("ob_gzhandler");
session_start();

include_once("includes/config.php");

$planning_id 	= (isset($_REQUEST['planning_id']) && $_REQUEST['planning_id'] > 0) ? $_REQUEST['planning_id']: 0;

$planning		=  new planning($planning_id);
if($planning->planning_id == 0)
{
	functions::redirect('full_list.php');
	exit;	
}


// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= 'Listing View';
$template->meta_keywords	= 'Stagsource';
$template->meta_description	= 'Stagsource';
$template->footer_content	= true;
$template->js				= '
								<script type="text/javascript" src="js/PictureSlides-jquery-2.0.js"></script>
								<script type="text/javascript" src="'.URI_LIBRARY.'simpleexpand/src/simple-expand.js"></script>
								<!--<script src="'.URI_LIBRARY.'colorbox/jquery.colorbox.js"></script>-->
								<script src="'.URI_LIBRARY.'lightbox/js/lightbox.min.js"></script>';
$template->css				= '<link rel="stylesheet" href="css/picture-slides.css" type="text/css">
								<link rel="stylesheet" href="css/paginate-style.css" type="text/css">
								<link rel="stylesheet" type="text/css" href="css/component.css" />
								
								<!--<link rel="stylesheet" href="'.URI_LIBRARY.'colorbox/colorbox.css" />-->
								<link href="'.URI_LIBRARY.'lightbox/css/lightbox.css" rel="stylesheet" />';
$template->heading();

$all_image_array 	= planning_gallery::get_all_images($planning->planning_id);

/*$img_array 	= array();

if(count($all_image_array) > 0)
{
	for($i = 0; $i< count($all_image_array); $i++)
	{
		$alt	=  ($all_image_array[0]->title != '') ?  functions::deformat_string($all_image_array[0]->title) : functions::deformat_string($all_image_array[0]->image_name);
		$text	=  'This is '. ($all_image_array[0]->title != '') ?  functions::deformat_string($all_image_array[0]->title) : functions::deformat_string($all_image_array[0]->image_name);
	
		$img_array[] = array('image'=>URI_PLANNING_GALLERY.'resize1_'.$all_image_array[$i]->image_name, 'alt'=>$alt, 'text'=>$text);	
	}
}
else
{
	$img_array[] = array('image'=>'images/noimagelarge.jpg', 'alt'=>'No Image', 'text'=>'No Image');	
}*/

?>


<script type="text/javascript">

	$(document).ready(function() {
  
	});
</script>


<script>
    function setupLabel() {
        if ($('.label_check input').length) {
            $('.label_check').each(function(){ 
                $(this).removeClass('c_on');
            });
            $('.label_check input:checked').each(function(){ 
                $(this).parent('label').addClass('c_on');
            });                
        };
        if ($('.label_radio input').length) {
            $('.label_radio').each(function(){ 
                $(this).removeClass('r_on');
            });
            $('.label_radio input:checked').each(function(){ 
                $(this).parent('label').addClass('r_on');
            });
        };
    };
	
    $(document).ready(function(){
		//$(".group1").colorbox({rel:'group1'});
		
        $('body').addClass('has-js');
        $('.label_check, .label_radio').click(function(){
            setupLabel();
        });
        setupLabel(); 
    });
</script>

<style>            
        .content {display:none;}
                
</style>


<!-- Itinerary -->
<link href="<?php echo URI_ROOT ?>css/itinerary.css" type="text/css" rel="stylesheet"/>

<?php 
	
	$location 	= new location($planning->location_id);
	$address =  functions::deformat_string($planning->address).', '. functions::deformat_string($location->name);
	$vendor_type	= new vendor_type($planning->vendor_type_id);
	$rating_value = planning_rating::get_rating($planning->planning_id);
	$total_rating = planning_rating::get_total_rating($planning->planning_id);
		 
?>
        
    <!--<section class="vagas_banner"> </section>-->
        
	<section class="vagas_banner">
	  <div class="banner_detailbox">
       	<a href="<?php echo 'full_list.php?party_type='.$planning->party_type_id.'&vendor_type='.$planning->vendor_type_id.'&location='.$planning->location_id; ?>"><div class="backto_prevbtn"><!--Back to Las Vegas Hotel-->Back to <?php echo functions::deformat_string($location->name).' '. $vendor_type->name; ?></div></a>
     <!-- <h1>The Cosmopolitan of Las Vegas</h1>-->
     <h1> <?php echo  utf8_encode(functions::deformat_string($planning->vendor_name)) ?></h1>
            <div class="btn_fullgallery">
              <!--<div class="arrow_bx">
                <div class="arrow_left"><img src="images/arrow_lft.png" width="8" height="27"></div>
                <div class="arrow_contnt">Impression of the Hotel #1</div>
                <div class="arrow_rit"><img src="images/arrow_rt.png" width="8" height="27"></div>
              </div>-->
             <!-- <div class="view_full_gallery"><a class="group1" href="images/gallery/9.jpg" title="Me and my grandfather on the Ohoopee.">Full Gallery</a></div>
              <a class="group1" href="images/gallery/8.jpg" title="Me and my grandfather on the Ohoopee.">-->
              
              <?php if(count($all_image_array) > 0) { ?>
              <div class="view_full_gallery"><a data-lightbox="image-1" href="<?php echo URI_PLANNING_GALLERY.$all_image_array[0]->image_name; ?>">Full Gallery</a></div>
              <?php  }
			  for($i =1; $i < count($all_image_array); $i++) { ?>
                           <a data-lightbox="image-1" href="<?php echo URI_PLANNING_GALLERY.$all_image_array[$i]->image_name; ?>" style="display:none;"></a>
              <?php } ?>
          </div>
      </div>
       <?php if(count($all_image_array) > 0) { ?>
      <a data-lightbox="image-2" href="<?php echo URI_PLANNING_GALLERY.$all_image_array[0]->image_name; ?>"><div class="flscrn"></div></a>
      <?php  }
			  for($i =1; $i < count($all_image_array); $i++) { ?>
                           <a data-lightbox="image-2" href="<?php echo URI_PLANNING_GALLERY.$all_image_array[$i]->image_name; ?>" style="display:none;"></a>
              <?php } ?>
	</section>
    
    
	<section class="contentwrapper">
    
	<div class="content_inner clearfix">
    
    <span class="techno_savy">
	<?php echo  functions::deformat_string($planning->comments); // ?>
	</span>
    
    <span class="techno_savy_p">
	<?php echo  functions::deformat_string($planning->overview); // ?>
	</span>
	
	<a href="#" class="itinerary-add" data-name="<?php echo  functions::deformat_string($planning->vendor_name) ?>" data-reveal-id="itinerary_dialog" data-planning-id="<?php echo $_GET['planning_id']; ?>"><span class="addto">Add to Itinerary</span></a>
	
	<!--<a href="#"><span class="book_box">Book</span></a>-->
     <?php if($planning->booking_id != '') { ?>
	<a href="http://secure.rezserver.com/hotels/hotel/?refid=6236&hotel_id=<?php echo $planning->booking_id; ?>" target="_blank"><span class="book_box">Book</span></a>
    <?php } ?>
    
    <!--<section class="ind_view_headingbox">
    	<h1><?php echo  utf8_encode(functions::deformat_string($planning->vendor_name)) ?></h1>-->

        <!--<div class="ind_view_adressbox"><?php echo  functions::deformat_string($address) ?><img src="images/icn_location.png" width="14" height="21" class="get_map"  style="cursor:pointer;"> <span class="blutxt get_map"  style="cursor:pointer;">See Map</span></div>-->
   
   <div class="listbox_row">
	
	
	<div class="listbox_clm">
	<span class="listbox_title">What makes this great</span>
	<div class="listbox_ul" style="font-family: 'HelveticaNeue-light'; color:ffffff">
    
    <?php echo ($planning->vendor_type_id ==1) ? $planning->your_picks_description : $planning->whywe_like; ?>
	<!--<ul>
	<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>
	<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </li>
	<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
	<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </li>
	</ul>-->
	</div>
	</div>
	
	
	<div class="listbox_clm">
	<span class="listbox_title">Useful Information</span>
	<div class="listbox_ul">
     <?php echo $planning->useful_information ?>
	<!--<ul>
	<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>
	<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </li>
	<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
	<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </li>
	</ul>-->
	</div>
	</div>
	
	
	<div class="listbox_bottm">
	
	<div class="listbox_bottm_box">
	<img src="images/bottom-icon1.png" >
	<h1>Our Editors have been here and it has met our standards</h1>
	</div>
	
	<div class="listbox_bottm_box">
	<img src="images/bottom-icon2.png" >
	<h1>Recommended by <br />
	 89% of 742 members</h1>
	</div>
	
	<div class="listbox_bottm_box">
	<img src="images/bottom-icon3.png" >
	<h2>TripAdvisor Traveler Rating:</h2>
    <!--<i class="rating_full"></i><i class="rating_half"></i><i class="rating_no"></i>-->
    
	<!--<img src="images/tripadvsr.jpg" >-->
    
    <?php 
	
		 if($rating_value == 0)
		 {
			echo '<i class="rating_no"></i><i class="rating_no"></i><i class="rating_no"></i><i class="rating_no"></i><i class="rating_no"></i>'; 
		 }
		 else if($rating_value < 2 &&  $rating_value > 0)
		 {
			echo '<i class="rating_half"></i><i class="rating_no"></i><i class="rating_no"></i><i class="rating_no"></i><i class="rating_no"></i>';  
		 }
		 else if($rating_value == 2 ) { 
		 	echo '<i class="rating_full"></i><i class="rating_no"></i><i class="rating_no"></i><i class="rating_no"></i><i class="rating_no"></i>'; 
		 }
		 else if($rating_value < 4  &&  $rating_value > 2) {
			  echo '<i class="rating_full"></i><i class="rating_half"></i><i class="rating_no"></i><i class="rating_no"></i><i class="rating_no"></i>'; 
		 }
		 else if($rating_value == 4 ) { 
		 	echo '<i class="rating_full"></i><i class="rating_full"></i><i class="rating_no"></i><i class="rating_no"></i><i class="rating_no"></i>'; 
		 }
		 else if($rating_value < 6  &&  $rating_value > 4) {
			  echo '<i class="rating_full"></i><i class="rating_full"></i><i class="rating_half"></i><i class="rating_no"></i><i class="rating_no"></i>'; 
		 }
		 else if($rating_value == 6 ) { 
		 	echo '<i class="rating_full"></i><i class="rating_full"></i><i class="rating_full"></i><i class="rating_no"></i><i class="rating_no"></i>'; 
		 }
		 else if($rating_value < 8  &&  $rating_value > 6) {
			  echo '<i class="rating_full"></i><i class="rating_full"></i><i class="rating_full"></i><i class="rating_half"></i><i class="rating_no"></i>'; 
		 }
		 else if($rating_value == 8 ) { 
		 	echo '<i class="rating_full"></i><i class="rating_full"></i><i class="rating_full"></i><i class="rating_full"></i><i class="rating_no"></i>'; 
		 }
		 else if($rating_value < 10  &&  $rating_value > 8) {
			  echo '<i class="rating_full"></i><i class="rating_full"></i><i class="rating_full"></i><i class="rating_full"></i><i class="rating_half"></i>'; 
		 }
		 else if($rating_value == 10 ) { 
		 	echo '<i class="rating_full"></i><i class="rating_full"></i><i class="rating_full"></i><i class="rating_full"></i><i class="rating_full"></i>'; 
		 }
		 
		 ?>
    
    
	<h3>
    Based on <?php echo $total_rating ?> traveller reviews
    <!--Based on 1,811 traveler reviews--></h3>
	</div>
	</div>
	</div>
      
	</div>
	</section>
	
	<link  href="<?php echo URI_LIBRARY; ?>jquery/datetimepicker/jquery-ui-timepicker-addon.css" rel="stylesheet" />
	<script src="<?php echo URI_LIBRARY; ?>jquery/datetimepicker/jquery-ui-sliderAccess.js" type="text/javascript"></script>
	<script src="<?php echo URI_LIBRARY; ?>jquery/datetimepicker/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
	
	<div class="reveal-modal" id="itinerary_dialog">
		<div class="login_box">
			<i class="left_seach_heading_icn"><img width="74" height="62" src="<?php echo URI_ROOT ?>images/curated_hed_icn.jpg"></i>
            <div class="bachelor_party_hd">Add to itinerary</div>
			<?php if(empty($_SESSION[MEMBER_ID])): ?>
			<div class="login-error">Sorry, but <a href="#" id="itinerary_login">you should login first</a></div>
			<?php else: ?>
			<div id="itinerary_dialog_msg"><span class="msg"></span><br />-- click to dismiss --</div>
			<input type="hidden" id="itinerary_action" />
			<input type="hidden" id="itinerary_planningid" />
			<div class="col col60">
				Date and time:
            	<div class="holder">
            		<input type="text" id="itinerary_datetime" />
                </div>
           	</div>
            <div class="col col40">
            	Duration:
            	<div class="holder">
            		<input type="text" id="itinerary_duration" />
                </div>
            </div>
            <div id="itinerary_checkbox"><input type="checkbox" id="itinerary_setdate" /> I don't want to set date and time now</div>
        	<input type="button" class="bc_btn_submit" value="Add this item" id="itinerary_btn">
        	<?php endif; ?>
        </div>
        <a class="close-reveal-modal">×</a>
    </div>
    
    
    <script>
		$(document).ready(function(){
			$("#itinerary_datetime").datetimepicker();
			$("#itinerary_duration").timepicker();

			$("#itinerary_login").click(function(e){
				e.preventDefault();
				$("#login_btn").click();
			});

			$(".itinerary-add").click(function(e) {
				e.preventDefault();
				var modalLocation = $(this).attr('data-reveal-id');
				$('#'+modalLocation).reveal($(this).data());

				$('#itinerary_action').val('add');
				$('#itinerary_planningid').val($(this).attr('data-planning-id'));

				$('#itinerary_dialog').show();
			});

			$("#itinerary_dialog_msg").click(function(){
				$(this).fadeOut(200);
			});

			$('#itinerary_btn').click(function(){
				var $this = $(this);
				$(this).val('Please wait ..');
				$.ajax({
					url: "<?php echo URI_ROOT; ?>ajax_itinerary.php",
					data: {
						action: $("#itinerary_action").val(), 
						planning_id: $("#itinerary_planningid").val(), 
						datetime: $("#itinerary_datetime").val(),
						duration: $("#itinerary_duration").val(),
						setdate: $("#itinerary_setdate").is(':checked')? 1: 0
					}, complete: function(XHR){
						$this.val('Add this item');
						var result = XHR.responseText.split('<>');
						$("#itinerary_dialog_msg").show().find(".msg").text(result[1]);
					}
				});
			});

			$(".selectbox").selectbox();
		});
	</script>
    
        
	<?php
		$template->footer();
	?>
