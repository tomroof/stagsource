<?php
ob_start("ob_gzhandler");
session_start();

include_once("includes/config.php");

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= 'Full List';
$template->meta_keywords	= 'Stagsource';
$template->meta_description	= 'Stagsource';
$template->footer_content	= true;
$template->js				= '<script type="text/javascript" src="'.URI_LIBRARY.'select/jquery.selectbox-0.2.js"></script>
								<script type="text/javascript" src="'.URI_LIBRARY.'select/functions.js"></script>
								<script src="js/ion.rangeSlider.js"></script>';
$template->css				= '<link rel="stylesheet" href="css/demo_rangeslider.css">
								<link rel="stylesheet" href="css/ion.rangeSlider.css">
								<link rel="stylesheet" href="css/skin1.css" id="skinCss">
								<link href="'.URI_LIBRARY.'select/jquery.selectbox.css" type="text/css" rel="stylesheet"/>
								';
$template->heading();

$party_type 	= (isset($_REQUEST['party_type']) && $_REQUEST['party_type'] > 0) ? $_REQUEST['party_type']: 1;
$location_id 	= (isset($_REQUEST['location']) && $_REQUEST['location'] > 0) ? $_REQUEST['location']: 1;
$vendor_type_id = (isset($_REQUEST['vendor_type']) && $_REQUEST['vendor_type'] > 0) ? $_REQUEST['vendor_type']: 1;
$price_range_id = (isset($_REQUEST['p_id']) && $_REQUEST['p_id'] > 0) ? $_REQUEST['p_id']: (isset($_REQUEST['minprice']) ? 0:  1);
$party_size 	= (isset($_REQUEST['party_size']) && $_REQUEST['party_size'] > 0) ? $_REQUEST['party_size']: 2;
$wed_date 		=  (isset($_REQUEST['wed_date']) && $_REQUEST['wed_date'] != '') ? $_REQUEST['wed_date']: '';


$planning 					= new planning();
$planning->party_type_id	= $party_type;
$planning->location_id 		= $location_id;
$planning->vendor_type_id 	= $vendor_type_id;
$planning->price_range_id   = $price_range_id;
$planning->party_size   	= $party_size;
$planning->wed_date   		= $wed_date;

$location 		=  new location($location_id);

if($party_type ==  2)
{
	$start_min_price	= 0; //planning::get_minprice($party_type); //100;
	$end_max_price		= 35000; //planning::get_maxprice($party_type); //2000;
}
else 
{
	$start_min_price	= 0; //planning::get_minprice($party_type); //100;
	$end_max_price		= 2000; //planning::get_maxprice($party_type); //2000;
}

if(isset($_REQUEST['minprice']))
{
	$planning->minprice = $_REQUEST['minprice'];	
}
if(isset($_REQUEST['maxprice']))
{
	$planning->maxprice = $_REQUEST['maxprice'];	
}

if($price_range_id > 0)
{
	$price_range	= new price_range($price_range_id);	
	
	if($party_type ==  1)
	{
		$row = explode('<',$price_range->bachelor_value);
		if(count($row) >  1)
		{
			$planning->minprice    = 0;
			$planning->maxprice    = $row[1];
		}
		else
		{
			$row = explode('>',$price_range->bachelor_value);
			if(count($row) >  1)
			{
				$planning->minprice    = $row[1];
				$planning->maxprice    = $row[1];
			}
			else
			{
				$row = explode('-',$price_range->bachelor_value);
				if(count($row) >  1)
				{
					$planning->minprice    = $row[0];
					$planning->maxprice    = $row[1];
				}
			}
		}
		
	}
	
	if($party_type ==  2)
	{
		$row = explode('<',$price_range->wedding_value);
		if(count($row) >  1)
		{
			$planning->minprice    = 0;
			$planning->maxprice    = $row[1];
		}
		else
		{
			$row = explode('>',$price_range->wedding_value);
			if(count($row) >  1)
			{
				$planning->minprice    = $row[1];
				$planning->maxprice    = $row[1];
			}
			else
			{
				$row = explode('-',$price_range->wedding_value);
				if(count($row) >  1)
				{
					$planning->minprice    = $row[0];
					$planning->maxprice    = $row[1];
				}
			}
		}
		
	}
}


?>


	  <script>
		 $(document).ready(function() {
       	//	alert($('#p_type').val());
			var miniprice1='<?php echo $planning->minprice; ?>';
			var maxprice1='<?php echo $planning->maxprice; ?>';
						
			if(miniprice1=='')
			{
				var miniprice1=<?php echo $start_min_price;?>;	
			}
			if(maxprice1=='')
			{
				var maxprice1=<?php echo $end_max_price;?>;	
			}
			
			//minprice1 = $('#minprice').val();
			//alert(miniprice1);
					
			/*$("#amount").ionRangeSlider({
				range: true,
				
				min: 500,
				max: 2000,
				from: 500,
				to: 2000,
				type: 'double',
				step: 500,
				postfix: " &dollar;",
				hasGrid: false
			});*/ 
			$("#amount_slide").ionRangeSlider({
				range: true,
				min: <?php echo $start_min_price;?>,
				max: <?php echo $end_max_price;?>,
				from: miniprice1,
				to: maxprice1,
				//values: [700, 1000],  
				type: 'double',
				<?php if($party_type == 2) { ?>
					step: 5000,
				<?php } else { ?>
					step: 250,
				<?php } ?>
				//prefix: " &dollar;",
				postfix: " &dollar;",
				hasGrid: false,
				onLoad: function(obj) {
					//obj.fromNumber = 1000;
				},
				onChange: function (obj) {  // callback is called on every slider change
					$("#amount" ).html( "&dollar;" + obj.fromNumber + " - &dollar;" + obj.toNumber );
				},
				onFinish: function (obj) {  // callback is called on slider action is finished
					//console.log(obj);
					//alert(obj.fromNumber);
					//alert(obj.toNumber);
					
					$("#amount" ).html( "&dollar;" + obj.fromNumber + " - &dollar;" + obj.toNumber );
					$("#minprice").val(obj.fromNumber);
					$("#maxprice").val(obj.toNumber);
					
					var min1='<?php echo $planning->minprice; ?>';
					var max1='<?php echo $planning->maxprice; ?>';
			
					if((obj.fromNumber !=  min1 || obj.toNumber != max1) && $('#vendor_type').val() == 1 )
					{
						if($('#p_type').val() != 0)
						{
							window.location = 'full_list.php?party_type='+$('#p_type').val()+'&location='+$('#location').val()+'&vendor_type='+ $('#vendor_type').val()+'&minprice='+obj.fromNumber+'&maxprice='+obj.toNumber;
						}
						else
						{
							window.location = 'full_list.php?location='+$('#location').val()+'&vendor_type='+ $('#vendor_type').val()+'&minprice='+obj.fromNumber+'&maxprice='+obj.toNumber;
						}
					}
				}
			});
			
			$( "#amount_slide" ).ionRangeSlider('update',{from: miniprice1, to: maxprice1});
			
			
			<?php if($party_type ==  1 && $planning->minprice == 2000) { ?>
				$( "#amount" ).html( ">&dollar;" + miniprice1 );
			<?php } else if($party_type == 2 && $planning->minprice == 35000) { ?>
					$( "#amount" ).html( ">&dollar;" + miniprice1 );
			<?php } else { ?>
				$( "#amount" ).html( "&dollar;" + miniprice1 + " - &dollar;" + maxprice1 );
			<?php } ?>
        
    	});
		
		
		
 $(document).ready(function() {
	
	$('#4').change(function() {
		var loc_id =$(this).val();
		
		//window.location = 'full_list.php?location='+loc_id+'&vendor_type='+$('#vendor_type').val()+'&minprice='+$('#minprice').val()+'&maxprice='+$('#maxprice').val();
		if($('#p_type').val() != 0)
		{
			window.location = 'full_list.php?party_type='+$('#p_type').val()+'&location='+loc_id;
		}
		else
		{
			window.location = 'full_list.php?location='+loc_id;
		}
	});
	
	$('#5').change(function() {
		
		var vendor_id =$(this).val();
		
		//window.location = 'full_list.php?location='+$('#location').val()+'&vendor_type='+ vendor_id+'&minprice='+$('#minprice').val()+'&maxprice='+$('#maxprice').val();
		if($('#p_type').val() != 0)
		{
			window.location = 'full_list.php?party_type='+$('#p_type').val()+'&location='+$('#location').val()+'&vendor_type='+ vendor_id;
		}
		else
		{
			window.location = 'full_list.php?location='+$('#location').val()+'&vendor_type='+ vendor_id;
		}
	});
	
	 
	$('.more').click(function() {
		var id =$(this).attr('id');
		var ids= id.split('more_');
		id= ids[1];
		
		//alert(id);
	});
 });

		</script>




	<section class="inner_banner"></section>
	<section class="contentwrapper">
	<div class="content_inner">
	<aside class="left_box">
	  <div class="left_seach_heading"><i class="left_seach_heading_icn"><img src="images/curated_hed_icn.jpg" width="74" height="62"></i>
      	<div class="left_seach_headingtxt">Rate</div>
      </div>
      <div class="left_searchbox">
      	<h1>Find the best hotel deals</h1>
        <div class="search_select">
        <select name="type_annonce" class="ordinnary_text_form" id="2">
          <option value="%">Check In</option>
					<option value="1">Sample1</option>
					<option value="2">Sample2</option>
					<option value="3">Sample3</option>
			</select>
        </div>
        <div class="search_select">
        <select name="type_annonce" class="ordinnary_text_form" id="3">
          <option value="%">Check Out</option>
					<option value="1">Sample1</option>
					<option value="2">Sample2</option>
					<option value="3">Sample3</option>
			</select>
        </div>
                
        <div class="grey_btn mr_left">
        <input name="" type="button" value="Search">
        </div>
      </div>
      
      <label for="4" class="price_txt" style="padding-left:12px;">Location</label>
    
   	  <div class="search_select">
        <select name="location_id" class="ordinnary_text_form" id="4">
          <!--<option value="%">Location</option>
					<option value="1">Sample1</option>
					<option value="2">Sample2</option>
					<option value="3">Sample3</option>-->
          <?php

			$location_array = location::get_location_options();

			for($i = 0; $i < count($location_array); $i++)
			{
				$select = ' ';

				if($location_array[$i]->location_id == $location_id)
				{
					$select = ' selected ';
				}                         

				echo '<option  value="' . $location_array[$i]->location_id  . '" ' . $select . '>' . functions::deformat_string($location_array[$i]->name ) . '</option>';
			}

			?>
		</select>
      </div>
      
      <label for="5" class="price_txt" style="padding-left:12px;">Vendor Type</label>
    
   	  <div class="search_select">
        <select name="vendor_type"  class="ordinnary_text_form" id="5">
          <!--<option value="%">Location</option>
					<option value="1">Sample1</option>
					<option value="2">Sample2</option>
					<option value="3">Sample3</option>-->
        <?php

           $vendor_type_array = vendor_type::get_vendor_type_options_by_location($location_id);
		
			$selected_id =0;
		   for($i = 0; $i < count($vendor_type_array); $i++)
		   {
				  $select = ' ';

				  if($vendor_type_array[$i]->vendor_type_id == $vendor_type_id)
				  {
					  $select = ' selected ';
					  $selected_id = $i;
				  }                         

				  echo '<option  value="' . $vendor_type_array[$i]->vendor_type_id  . '" ' . $select . '>' . functions::deformat_string($vendor_type_array[$i]->name ) . '</option>';

		  }
		  
		   if($selected_id == 0)
		   {
				$planning->vendor_type_id = $vendor_type_array[0]->vendor_type_id ;  
		   }
		  
		  
			  ?>    
		</select>
      </div>
      
      
      <div class="price_range" >
      <div class="price_rangebox" style="margin-top:17px; <?php echo ($planning->vendor_type_id != 1  ) ? 'display:none;' : ''; ?>" >
              <p>
            <label for="amount" class="price_txt" style="width:67px !important;">Price</label>
           <!--<input type="text" id="amount" class="price_box" >-->
            <span  id="amount" class="price_box" style="width:150px !important;" ></span>
        </p>
        
        
      </div>


<div class="grey_line" <?php echo ($planning->vendor_type_id != 1) ? 'style="display:none;"' : ''; ?>></div>

<div class="price_sliderbox" <?php echo ($planning->vendor_type_id != 1) ? 'style="display:none;"' : ''; ?>>
<div class="dm__left"><input id="amount_slide" type="text" name="" value="64000;69000" style="display: none;"></div>
<input type="hidden" id="minprice" name="minprice" value="<?php echo ($planning->minprice > 0) ? $planning->minprice: $start_min_price ; ?>">
<input type="hidden" id="maxprice" name="maxprice" value="<?php echo ($planning->maxprice > 0) ? $planning->maxprice: $end_max_price; ?>">
</div>

<div class="grey_line" <?php echo ($planning->party_type_id == '2') ? 'style="display:none;"' :''; ?>></div>
<div class="gest_select" <?php echo ($planning->party_type_id == '2') ? 'style="display:none;"' :''; ?>>
	<div class="price_txt">Guests</div>
    <div class="guest_selectbox">
		        <select name="type_annonce" class="ordinnary_text_form" id="1">
		          <option value="2" <?php echo ($party_size == 2) ? 'selected' : '' ?>>2</option>
		          <option value="3" <?php echo ($party_size == 3) ? 'selected' : '' ?>>3</option>
		          <option value="4" <?php echo ($party_size == 4) ? 'selected' : '' ?>>4</option>
                  <option value="5" <?php echo ($party_size == 5) ? 'selected' : '' ?>>5</option>
                  <option value="6" <?php echo ($party_size == 6) ? 'selected' : '' ?>>6</option>
                  <option value="7" <?php echo ($party_size == 7) ? 'selected' : '' ?>>7</option>
                  <option value="8" <?php echo ($party_size == 8) ? 'selected' : '' ?>>8</option>
                  <option value="9" <?php echo ($party_size == 9) ? 'selected' : '' ?>>9</option>
                  <option value="10" <?php echo ($party_size == 10) ? 'selected' : '' ?>>10+</option>
              </select>

    </div>
    
</div>
      </div>
	</aside>
    <aside class="inner_right">
    <h1 class="black_heading"><?php echo functions::deformat_string($location->name) ?></h1>
    <article class="curated_head_content">
    	<h1><?php echo functions::deformat_string($location->title) ?></h1>
        <p><?php echo nl2br(functions::deformat_string($location->description)) ?></p>
    </article>
    
   <?php  
   			$planning->property_listing_all(); ?>
   

   <?php 	$functions 		= new functions();
			$limit1			= functions::$limits1;
			$page =  $_GET['page'];
			//$functions->paginateclient_property($planning->num_rows, 1, $planning->pager_param, 'CLIENT');
			
			?>

  
    </aside>
	<?php $functions->paginateclient_property($planning->num_rows, 1, $planning->pager_param, 'CLIENT'); ?>
	</div>
	</section>
    
    <input type="hidden" name="party_type" id="p_type" value="<?php echo $planning->party_type_id ?>" />
    <input type="hidden" name="location" id="location" value="<?php echo $planning->location_id ?>" />
     <input type="hidden" name="vendor_type" id="vendor_type" value="<?php echo $planning->vendor_type_id ?>" />
	<script>
	$(document).ready(function() {
		<?php if($planning->num_rows > 9) { ?>
			$('.pagination').show();
			
		<?php } else { ?>
		 $('.pagination').hide();
		<?php  }?>
	});
	</script>
	<?php
		$template->footer();
	?>

