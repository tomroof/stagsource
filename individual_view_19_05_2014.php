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
$template->js				= '<script type="text/javascript" src="js/PictureSlides-jquery-2.0.js"></script>
								<script type="text/javascript" src="'.URI_LIBRARY.'simpleexpand/src/simple-expand.js"></script>';
$template->css				= '<link rel="stylesheet" href="css/picture-slides.css" type="text/css">
								<link rel="stylesheet" href="css/paginate-style.css" type="text/css">';
$template->heading();

$all_image_array 	= planning_gallery::get_all_images($planning->planning_id);

$img_array 	= array();

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
}

?>


	  <script type="text/javascript">
	  
	  $(document).ready(function() {
		 $('.get_map').click(function() {
			 var lat = 52.4746;
			 var lng = -1.9043;
			GetMap(lat, lng);

			$.colorbox({href:'#inline_content', inline:true});
		 });
		 
		 $('.expander').simpleexpand();
		 
		 $('#see_review').click(function() {
			 $.ajax(
			{
				
				type: "POST",
				cache: false,
				url: "popup_guest_review.php?popup=1&planning_id=<?php echo $planning_id ?>",
				success: function (data)
				{
					$.fancybox(data);
					/*$.fancybox({
				 'content':data,
    			 afterClose : function() {
					alert(1);
					//window.location = 'https://pdlive.gene.com/community/community/senior_leaders_conference_2014';
        			return;
    			}
			 });*/
				}
			});
		 });
		 
		 var cnt =0;
		 
		 $('#see_picks').click(function() {
			/* $.ajax(
			{
				
				type: "POST",
				cache: false,
				url: "popup_whatyoulove.php?popup=1&planning_id=<?php echo $planning_id ?>",
				success: function (data)
				{
					$.fancybox(data);
				}
			});*/
			
			if(cnt == 0)
			{
				$('#picks1').hide();
				$('.seealldetails').html('Close hotel details');
				cnt++;
			}
			else
			{
				$('#picks1').show();
				$('.seealldetails').html('See all hotel details');
				cnt = 0;	
			}
			
		 });

	  });
	  
	  
		jQuery.PictureSlides.set({
			// Switches to decide what features to use
			useFadingIn : true,
			useFadingOut : true,
			useFadeWhenNotSlideshow : true,
			useFadeForSlideshow : true,
			useDimBackgroundForSlideshow : true,
			loopSlideshow : true,
			usePreloading : true,
			useAltAsTooltip : true,
			useTextAsTooltip : false,
			
			// Fading settings
			fadeTime : 500, // Milliseconds	
			timeForSlideInSlideshow : 2000, // Milliseconds //2000

			// At page load
			startIndex : 1,	
			startSlideShowFromBeginning : true,
			startSlideshowAtLoad : false,
			dimBackgroundAtLoad : false,

			images: <?php echo json_encode($img_array); ?>,
			
			// Large images to use and thumbnail settings
			/*images : [
				{
					image : "images/gallery/1.jpg", 
					alt : "Picture 1",
					text : "This is picture 1"
				},
				{                                  
					image : "images/gallery/2.jpg", 
					alt : "Picture 2",
					text : "This is picture 2"
				},
				{                                  
					
					image : "images/gallery/3.jpg", 
					alt : "Picture 3",
					text : "This is picture 3",
					url : "http://456bereastreet.com"
				},
				{                                  
					
					image : "images/gallery/4.jpg", 
					alt : "Picture 4",
					text : "This is picture 4",
					url : "http://mozilla.com"
				},
				{                                  
					
					image : "images/gallery/5.jpg", 
					alt : "Picture 5",
					text : "This is picture 5"
				},
				{                                  
					
					image : "images/gallery/6.jpg", 
					alt : "Picture 6",
					text : "This is picture 6"
				},
				{                                  
					
					image : "images/gallery/7.jpg", 
					alt : "Picture 7",
					text : "This is picture 7"
				},
				{                                  
					
					image : "images/gallery/8.jpg", 
					alt : "Picture 8",
					text : "This is picture 8"
				}
			],*/
			thumbnailActivationEvent : "click",

			// Classes of HTML elements to use
			mainImageClass : "picture-slides-image", // Mandatory
			mainImageFailedToLoadClass : "picture-slides-image-load-fail",
			imageLinkClass : "picture-slides-image-link",
			fadeContainerClass : "picture-slides-fade-container",
			imageTextContainerClass : "picture-slides-image-text",
			previousLinkClass : "picture-slides-previous-image",
			nextLinkClass : "picture-slides-next-image",
			imageCounterClass : "picture-slides-image-counter",
			startSlideShowClass : "picture-slides-start-slideshow",
			stopSlideShowClass : "picture-slides-stop-slideshow",
			thumbnailContainerClass: "picture-slides-thumbnails",
			dimBackgroundOverlayClass : "picture-slides-dim-overlay"
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

<?php 
	
	$location 	= new location($planning->location_id);
	$address =  functions::deformat_string($planning->address).', '. functions::deformat_string($location->name);

	 $rating_value = planning_rating::get_rating($planning->planning_id);
	 $total_rating = planning_rating::get_total_rating($planning->planning_id);
		 
		
		?>
	<section class="inner_banner"></section>
	<section class="contentwrapper">
	<div class="content_inner clearfix">
    <section class="ind_view_headingbox">
    	<h1><?php echo  utf8_encode(functions::deformat_string($planning->vendor_name)) ?></h1>
        <div class="starrating">
         
         <?php 
		 if($rating_value == 0)
		 {
			echo '<i class="stardeactive"></i><i class="stardeactive"></i><i class="stardeactive"></i><i class="stardeactive"></i><i class="stardeactive"></i>'; 
		 }
		 else if($rating_value <= 3 ) { 
		 	 echo '<i class="staractive"></i><i class="stardeactive"></i><i class="stardeactive"></i><i class="stardeactive"></i><i class="stardeactive"></i>';
		 }
		 else if($rating_value <= 5 ) {
			  echo '<i class="staractive"></i><i class="staractive"></i><i class="stardeactive"></i><i class="stardeactive"></i><i class="stardeactive"></i>';
		 }
		 else if($rating_value <=7.5) {
			  echo '<i class="staractive"></i><i class="staractive"></i><i class="staractive"></i><i class="stardeactive"></i><i class="stardeactive"></i>';
		 }
		 else if($rating_value<=9) {
			 echo '<i class="staractive"></i><i class="staractive"></i><i class="staractive"></i><i class="staractive"></i><i class="stardeactive"></i>';
		 }
		 else if($rating_value > 9) 
		 {
			  echo '<i class="staractive"></i><i class="staractive"></i><i class="staractive"></i><i class="staractive"></i><i class="staractive"></i>';
		 }
		 ?>
        
       	  <!--<i class="staractive"></i><i class="staractive"></i><i class="staractive"></i><i class="stardeactive"></i><i class="stardeactive"></i>-->
          
          
        </div>
        <div class="ind_view_adressbox"><?php echo  functions::deformat_string($address) ?><img src="images/icn_location.png" width="14" height="21" class="get_map"  style="cursor:pointer;"> <span class="blutxt get_map"  style="cursor:pointer;">See Map</span></div>
    </section>
    
    
    
    <aside class="gallewry_box">
   	  <div class="picture-slides-container">
		  <div class="picture-slides-fade-container">
				<a class="picture-slides-image-link">
					<span class="picture-slides-image-load-fail">The image failed to load:</span>
					<!--<img class="picture-slides-image" src="images/gallery/1.jpg" alt="This is picture 1" />-->
                    
                    <?php
					if(count($all_image_array) > 0) { ?>
                    <img class="picture-slides-image" src="<?php echo URI_PLANNING_GALLERY.'resize1_'.$all_image_array[0]->image_name ?>" alt="<?php echo ($all_image_array[0]->title != '') ?  functions::deformat_string($all_image_array[0]->title) : functions::deformat_string($all_image_array[0]->image_name) ?>" />
                    <?php }
					else { ?>
						<img class="picture-slides-image" src="images/noimagelarge.jpg" alt="No Image" />	
					<?php } ?>
				</a>
		  </div>
			<ul class="picture-slides-thumbnails">
            	<?php 
				for($i =0; $i < count($all_image_array); $i++)
				{
					$alt	=  ($all_image_array[0]->title != '') ?  functions::deformat_string($all_image_array[0]->title) : functions::deformat_string($all_image_array[0]->image_name);
					echo '<li><a href="'.URI_PLANNING_GALLERY.'thumbnail/'.$all_image_array[$i]->image_name.'"><img src="'.URI_PLANNING_GALLERY.'thumbnail/'.$all_image_array[$i]->image_name.'" alt="'. $alt.'" title="'.$alt.'" /></a></li>';	
				}  ?>
                	
               
                
				<!--<li><a href="images/gallery/1.jpg"><img src="images/gallery/thumbnails/1.jpg" alt="" /></a></li>
				<li><a href="images/gallery/2.jpg"><img src="images/gallery/thumbnails/2.jpg" alt="" /></a></li>
				<li><a href="images/gallery/3.jpg"><img src="images/gallery/thumbnails/3.jpg" alt="" /></a></li>
				<li><a href="images/gallery/4.jpg"><img src="images/gallery/thumbnails/4.jpg" alt="" /></a></li>
				<li><a href="images/gallery/5.jpg"><img src="images/gallery/thumbnails/5.jpg" alt="" /></a></li>
				<li><a href="images/gallery/6.jpg"><img src="images/gallery/thumbnails/6.jpg" alt="" /></a></li>
				<li><a href="images/gallery/7.jpg"><img src="images/gallery/thumbnails/7.jpg" alt="" /></a></li>
				<li><a href="images/gallery/8.jpg"><img src="images/gallery/thumbnails/8.jpg" alt="" /></a></li>-->
                
			</ul>
		</div>
    </aside>
    
    
    
    <aside class="details_box">
    <div class="chooseroom clearfix">
    	<div class="chooseroomtxt">
        	<h1>Choose Your Room</h1>
            <p><span class="roomsfrom">Rooms From</span></p>
            <p><span class="room_price">&dollar;<?php echo (substr($planning->price, -3) == '.00') ? substr($planning->price, 0, -3): '0'; ?></span><span class="txt_night">/<?php echo functions::deformat_string($planning->price_type_array[$planning->price_type]) ?></span></p>
            <p><span class="txt_hfee"><?php echo ($planning->planning_fee == 'Y') ? 'Hotel Fee Included': 'Hotel Fee Not Included'; ?></span></p>
        </div>
        <div class="btn_chooseroom">Choose Room</div>
    </div>
    <div class="wtulove">
    	<h1>What You'll Love</h1>
        <div class="facility_box">
            
            <?php 
			  $your_picks  = explode(',',$planning->your_picks);
			  for($i =0; $i < count($your_picks); $i++)
			  {
				  $facility = new facility($your_picks[$i]);
				 if($your_picks[$i] == 1)
				 { 
						echo '<div class="facilityparking"><img src="images/parking.jpg" width="26" height="26">'. $facility->name.'</div>';
				 } else if($your_picks[$i] == 2)
				 {
					echo '<div class="facilityswimming"><img src="images/swimming_pool.jpg" width="41" height="26">'. $facility->name.'</div>';
				 }
				 else if($your_picks[$i] == 3)
				 {
					echo '<div class="facilitypets"><img src="images/pets.jpg" width="26" height="26">'. $facility->name.'</div>'; 
				 }
			  }
			?>
            
            
            <!--<div class="facilityparking">
                <img src="images/parking.jpg" width="26" height="26">
                Free <br>
                Parking </div>
                <div class="facilityswimming">
                <img src="images/swimming_pool.jpg" width="41" height="26">
                Swimming Pool
                </div>
                <div class="facilitypets">
                <img src="images/pets.jpg" width="26" height="26">
                Pets <br>
                Allowed 
            </div>-->
            
        </div>
        
        <?php 
			$desc = $planning->your_picks_description;
			$desc = (strlen($desc) > 350) ? substr(strip_tags($desc), 0, 350).' ...': $desc;
			
		?>
        
        <div class="facility_content" id="picks1">
        	<p><?php echo nl2br(functions::deformat_string($desc)) ?></p>
        </div>
        <?php if (strlen($planning->your_picks_description) > 350) { ?>
        	<div class="facility_content content" id="picks2">
            	<p><?php echo nl2br(functions::deformat_string($planning->your_picks_description)) ?><p>
        	</div>
        <a style="cursor:pointer;" id="see_picks" class="expander"><span class="seealldetails">See all hotel details</span></a>
        
        <?php } ?>
        <!--<div class="facility_content">
        	<p><?php echo nl2br(functions::deformat_string($planning->your_picks_description)) ?></p>
        </div>
        <a href="#"><span class="seealldetails">See all hotel details</span></a>
        -->

		<?php
		$item_per_page = 5;
		$total = planning_rating::get_total_rating_pagination($planning_id);
		$mod = $total % $item_per_page;
		$div  = $total / $item_per_page;
		
		if($div > $mod) $pages = $mod+1;
		else $pages = $mod;
		//$pages = planning_rating::get_total_rating_pagination($planning_id)/5;
		
		if($pages > 1)
		{
			$pagination	= '';
			$pagination	.= '<ul class="paginate">';
			for($i = 1; $i<= $pages; $i++)
			{
				$pagination .= '<li class="paginate_click"  id="'.$i.'-page" title="Page '.$i.'"><a  class="paginate_click" id="'.$i.'-page" title="Page '.$i.'">'.$i.'</a></li>';
			}
			$pagination .= '</ul>';
		}

		?>
        
        <script type="text/javascript">
$(document).ready(function() {
	$("#results").load("ajax_get_rating_pages.php", {'page':0, 'planning_id': '<?php echo $planning_id?>'}, function() {$("#1-page").addClass('active');});  //initial page number to load
	
	$(".paginate_click").click(function (e) {
		
		$("#results").prepend('<div class="loading-indication"><img src="images/ajax-loader.gif" /> Loading...</div>');
		
		var clicked_id = $(this).attr("id").split("-"); //ID of clicked element, split() to get page number.
		var page_num = parseInt(clicked_id[0]); //clicked_id[0] holds the page number we need 
		
		$('.paginate_click').removeClass('active'); //remove any active class
        //post page number and load returned data into result element
        //notice (page_num-1), subtract 1 to get actual starting point
		$("#results").load("ajax_get_rating_pages.php", {'page':(page_num-1), 'planning_id': '<?php echo $planning_id?>'}, function(){ });

		$(this).addClass('active'); //add active class to currently clicked element (style purpose)
		return false; //prevent going to herf link
	});	
});
</script>
        
        
        
        </div>
        <div class="reviewbox">
        	<h1>What Guests Are Saying</h1>
            <div class="review_ratingbox"><?php echo $rating_value ?>/10</div>
          <div class="review_number"><?php echo $total_rating ?> guest ratings</div>
            <div class="guest_reviewitem">
            	<div id="results"></div>
				
            	<?php //planning_rating::get_reviews($planning->planning_id, 5); ?>
            </div>
			<?php echo $pagination; ?>
           <!-- <?php if($total_rating > 5) { ?>
            <a style="cursor:pointer;" id="see_review"><span class="seealldetails">See all guest reviews</span>
            <?php } ?>-->
        </a>
        </div>
    	
    </aside>
    <section class="planning_featuresbox">
      
      
      <div class="features_box">
        <?php
		if($planning->features != '') { ?>
      		<h1>Hotel Features</h1>
        	<p><?php echo nl2br(functions::deformat_string($planning->features)) ?></p>
        <?php  } 
		if($planning->location_description != '') {
		?>
        	<h1>Hotel Location</h1>
        	<p><?php echo nl2br(functions::deformat_string($planning->location_description)) ?></p>
        <?php } 
		if($planning->guest_favourites != '') {
		?>
        	<h1>Guest Favourites</h1>
        	<p><?php echo nl2br(functions::deformat_string($planning->guest_favourites)) ?></p>
        <?php } ?>
      </div>
      
      
      
      <div class="topamenities_box">
      	<h1>Top Amenities</h1>
        <?php amenities::get_top_amenities($planning->amenities);   ?>    
        
        
        <!--<ul>
        	<li>Wireless internet connection in public ares</li>
            <li>Outdoor Pool</li>
            <li>Exercise gym</li>
            <li>Business center</li>
            <li>Pets allowed</li>
            <li>Restaurant</li>
        </ul>
        <ul>
        	<li>Non-smoking rooms(generic</li>
            <li>Free parking</li>
            <li>Cable television</li>
            <li>Hairdryer</li>
            <li>24-hour room service</li>
        </ul>-->
      </div>
    </section>
	</div>
	</section>

	<?php
$template->footer();
?>

<link rel="stylesheet" href="<?php echo URI_LIBRARY; ?>colorbox/colorbox.css" />

<script src="<?php echo URI_LIBRARY; ?>colorbox/jquery.colorbox.js"></script>

<style>
#map
	{
	position: relative;
	width: 100%;
	border-radius: 8px; 
	-moz-border-radius: 8px; 
	-webkit-border-radius: 8px; 
	-khtml-border-radius: 8px;
	margin: 0;
	}
	#map img {
	height: auto;
    width: 100%;
	border-radius: 8px;
	}
</style>

<div style="display:none" >

   <div id='inline_content' style="background:#fff;  padding:-10px; position:relative; width:715px; !importent height:550px; overflow:auto; ">

    <!--<div id='myMap' style="position:relative; width:710px; height:500px;border:1px solid #999999;"></div>-->
<!--You can pick up the pin and move it to the exact location of your planning. When you are happy with the location simply click the close button in the bottom right of this box.--> 

	<div id="map" style="height:417px;">

	<!--<img src="images/school-map.jpg">-->

	</div>
    
   </div>
   
	
  </div>
  
  <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>

<script type="text/javascript">
		
     	 var map = null;
		var searchManager = null;
		var latitude='<?php echo $planning->MouseLat;?>';
		var longitude='<?php echo $planning->MouseLng;?>';
		var pinInfobox = null;
		$(document).ready(function(){
			GetMap();
		}); 

      function GetMap()

      {	

		map = new Microsoft.Maps.Map(document.getElementById('map'), {credentials: '<?php echo BING_MAP_API_KEY;?>',mapTypeId: Microsoft.Maps.MapTypeId.road, zoom: 10});
		add_property();
	
        /*map = new Microsoft.Maps.Map(document.getElementById('myMap'), {credentials: '<?php echo BING_MAP_API_KEY;?>'

		,mapTypeId: Microsoft.Maps.MapTypeId.road,

		center: new Microsoft.Maps.Location(lat,lng),

							zoom: 10});

		

		//var pushpinOptions = new Microsoft.Maps.Pushpin(center, {icon: 'BluePushpin.png', width: 50, height: 50, draggable: true}); 

		//var pushpinOptions = new Microsoft.Maps.Pushpin(center, { text: '1', draggable: true });

		var pushpinOptions = {draggable:false}; 

		var pushpin= new Microsoft.Maps.Pushpin(map.getCenter(), pushpinOptions); 

		Microsoft.Maps.Events.addHandler(pushpin, 'dragstart', StartDragHandler);

		var pushpindrag= Microsoft.Maps.Events.addHandler(pushpin, 'drag', onDragDetails); 

		Microsoft.Maps.Events.addHandler(pushpin, 'dragend', EndDragHandler); 

		map.entities.push(pushpin); */

  }


  /*
function GetMap()

      {	

        map = new Microsoft.Maps.Map(document.getElementById('myMap'), {credentials: '<?php echo BING_MAP_API_KEY;?>'

		,mapTypeId: Microsoft.Maps.MapTypeId.road,

		center: new Microsoft.Maps.Location('<?php echo $planning->MouseLat;?>', '<?php echo $planning->MouseLng;?>'),

							zoom: 7});

		

		//var pushpinOptions = new Microsoft.Maps.Pushpin(center, {icon: 'BluePushpin.png', width: 50, height: 50, draggable: true}); 

		//var pushpinOptions = new Microsoft.Maps.Pushpin(center, { text: '1', draggable: true });

		var pushpinOptions = {draggable:true}; 

		var pushpin= new Microsoft.Maps.Pushpin(map.getCenter(), pushpinOptions); 

		Microsoft.Maps.Events.addHandler(pushpin, 'dragstart', StartDragHandler);

		var pushpindrag= Microsoft.Maps.Events.addHandler(pushpin, 'drag', onDragDetails); 

		Microsoft.Maps.Events.addHandler(pushpin, 'dragend', EndDragHandler); 

		map.entities.push(pushpin); 

  }  
*/  
function add_property()

{

	var offset = new Microsoft.Maps.Point(0, 5); 

	var pushpinOptions = {icon: 'images/singleprop-large.png'};

	var pushpin= new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(latitude, longitude), pushpinOptions); 

	map.setView( {center: new Microsoft.Maps.Location(latitude, longitude, null)}); 

	map.entities.push(pushpin);

}

	   function StartDragHandler(e) {

			//document.getElementById("mode").innerHTML = "Dragging started (dragstart event)."

		}

	  function EndDragHandler(e) {

			//document.getElementById("mode").innerHTML = "Dragging stopped (dragend event)."

		}

      function attachPushpinDragEvent()

      {

        

        alert('drag newly added pushpin to raise event');

      }

      

      onDragDetails = function (e) 

      {

       // alert("Event Info - start drag \n" + "Start Latitude/Longitude: " + e.entity.getLocation() ); 

	   var loc = e.entity.getLocation();

	    document.getElementById("MouseLat").value = loc.latitude.toFixed(4);

		document.getElementById("MouseLng").value = loc.longitude.toFixed(4);

	   

      }

      

</script>


