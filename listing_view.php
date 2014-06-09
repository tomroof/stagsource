<?php
ob_start("ob_gzhandler");
session_start();

include_once("includes/config.php");

// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= 'Listing View';
$template->meta_keywords	= 'Stagsource';
$template->meta_description	= 'Stagsource';
$template->footer_content	= true;
$template->js				= '<script type="text/javascript" src="'.URI_LIBRARY.'select/jquery.selectbox-0.2.js"></script>
								<script type="text/javascript" src="'.URI_LIBRARY.'select/functions.js"></script>
								 <script src="js/ion.rangeSlider.js"></script>';
$template->css				= '<link href="css/hover_content.css" rel="stylesheet" type="text/css"/>
								<link rel="stylesheet" href="css/demo_rangeslider.css">
								<link rel="stylesheet" href="css/ion.rangeSlider.css">
								<link rel="stylesheet" href="css/skin1.css" id="skinCss">
								<link href="css/selectbox.css" rel="stylesheet" type="text/css"/>
								<link href="'.URI_LIBRARY.'select/jquery.selectbox.css" type="text/css" rel="stylesheet"/>
								';
$template->heading();

$location_id 	= (isset($_REQUEST['location']) && $_REQUEST['location'] > 0) ? $_REQUEST['location']: 1;
$planning 					= new planning();
$planning->location_id 		= $location_id;
$planning->vendor_type_id 	= 1;

//if($_REQUEST['location'] != '')
//{
	$location 		=  new location($location_id);
//}

$start_min_price	= planning::get_minprice(); //100;
$end_max_price		= planning::get_maxprice(); //2000;

if(isset($_REQUEST['minprice']))
{
	$planning->minprice = $_REQUEST['minprice'];	
}
if(isset($_REQUEST['maxprice']))
{
	$planning->maxprice = $_REQUEST['maxprice'];	
}

?>


	<script>
		 $(document).ready(function() {
       		
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
 
			$("#amount_slide").ionRangeSlider({
				range: true,
				min: <?php echo $start_min_price;?>,
				max: <?php echo $end_max_price;?>,
				from: miniprice1,
				to: maxprice1,
				//values: [700, 1000],  
				type: 'double',
				step: 100,
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
					$("#amount" ).html( "&dollar;" + obj.fromNumber + " - &dollar;" + obj.toNumber );
					$("#minprice").val(obj.fromNumber);
					$("#maxprice").val(obj.toNumber);
					
					var min1='<?php echo $planning->minprice; ?>';
					var max1='<?php echo $planning->maxprice; ?>';
			
					if((obj.fromNumber !=  min1 || obj.toNumber != max1) && $('#vendor_type').val() == 1 )
					{
						window.location = 'full_list.php?location='+$('#location').val()+'&vendor_type='+ $('#vendor_type').val()+'&minprice='+obj.fromNumber+'&maxprice='+obj.toNumber;
					}
				}
			});
			
			$( "#amount_slide" ).ionRangeSlider('update',{from: miniprice1, to: maxprice1});
			$( "#amount" ).html( "&dollar;" + miniprice1 + " - &dollar;" + maxprice1 );

        
    	});
		
		
		
/* $(document).ready(function() {
	$('#5').change(function() {
		var loc_id =$(this).val();
		window.location = 'full_list.php?location='+loc_id+'&vendor_type='+$('#vendor_type').val()+'&minprice='+$('#minprice').val()+'&maxprice='+$('#maxprice').val();
	});
	
	$('#6').change(function() {
		var vendor_id =$(this).val();
		window.location = 'full_list.php?location='+$('#location').val()+'&vendor_type='+ vendor_id+'&minprice='+$('#minprice').val()+'&maxprice='+$('#maxprice').val();
	});
	 
	$('.more').click(function() {
		var id =$(this).attr('id');
		var ids= id.split('more_');
		id= ids[1];
		
		//alert(id);
	});
 });*/

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
		
		
		$('#loc_search').click(function() {
			alert(1);
		});
    });
</script>


	<section class="inner_banner"></section>
	<section class="contentwrapper">
	<div class="content_inner clearfix">
    <div class="listview_searchbox">
      <div class="listview_srchbox">
      <input name="location" id="location" type="text" placeholder="Las Vegas" value="<?php echo functions::deformat_string($location->name) ?>" class="listviewsearchfield">
      <input name="loc_search" id="loc_search" type="button" value="" class="btn_listsearch">
      </div>
      <a href="#"><div class="checkin_date"><img src="images/icn_calendar.jpg" width="19" height="20"><span class="checkin_txt">Check In</span></div></a>
      <a href="#"><div class="checkin_date"><img src="images/icn_calendar.jpg" width="19" height="20"><span class="checkin_txt">Check Out</span></div></a>
      <input name="search_btn" id="search_btn" type="button" value="Search" class="btn_searchbox">
    </div>
	<aside class="left_box">
    <h1 class="inner_left_hding">Filter by</h1>
    <div class="property_typebox">
    	<h1 class="property_typeboxhding">Property Type</h1>
        <ul>
        	<li>
            	<div class="property_listbox">
                	<div class="property_listicon"><img src="images/all_properties.png" width="22" height="20"></div>
                	<div class="property_listtxt">All Properties</div>
                    <div class="property_listnumber">29</div>
                
                </div>
            </li>
            <li>
            	<div class="property_listbox">
                	<div class="property_listicon"><img src="images/hotels.png" width="15" height="23"></div>
                	<div class="property_listtxt">Hotels</div>
                    <div class="property_listnumber">24</div>
                
                </div>
            </li>
            <li>
            	<div class="property_listbox">
                	<div class="property_listicon"><img src="images/home.png" width="21" height="20"></div>
                	<div class="property_listtxt">Homes</div>
                    <div class="property_listnumber">2</div>
                
                </div>
            </li>
        </ul>
    </div>
	  <div class="price_range">
	    <div class="price_rangebox">
      <p>
	<label for="amount" class="price_txt" style="width:67px !important;">Price</label>
	<input type="text" id="amount" class="price_box" style="width:150px !important;">
</p></div>
<div class="grey_line"></div>
<div class="price_sliderbox">
<div class="dm__left"><input id="amount_slide" type="text" name="" value="64000;69000" style="display: none;"></div>
</div>
<div class="grey_line"></div>
<div class="gest_select">
	<div class="price_txt">Guests</div>
    <div class="guest_selectbox">
		        <select name="type_annonce" class="ordinnary_text_form" id="4">
		          <option value="%">1</option>
		          <option value="1">2</option>
		          <option value="2">3</option>
		          <option value="3">4</option>
              </select>

    </div>
</div>
    </div>
    
    <div class="property_typebox">
    	<h1 class="property_typeboxhding brd_btm">Destinations</h1>
        <div class="property_listbox alldest">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-01"><input name="sample-checkbox-01" id="checkbox-01" value="1" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">All Destinations</div>
        </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-02"><input name="sample-checkbox-02" id="checkbox-02" value="2" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Las Vegas, Nevada</div>
                    <div class="property_listnumber">23</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-03"><input name="sample-checkbox-03" id="checkbox-03" value="3" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Henderson, Nevada</div>
                    <div class="property_listnumber">2</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-04"><input name="sample-checkbox-04" id="checkbox-04" value="4" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Nevada</div>
                    <div class="property_listnumber">1</div>
                
          </div>
    </div>
    
    
    <div class="property_typebox">
    	<?php amenities::get_amenities_list(); ?>
    	<!-- <h1 class="property_typeboxhding brd_btm">Amenities</h1>
       <div class="property_listbox alldest">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-05"><input name="sample-checkbox-05" id="checkbox-05" value="4" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">All Amenities</div>
        </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-06"><input name="sample-checkbox-06" id="checkbox-06" value="6" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Pool</div>
                    <div class="property_listnumber">22</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-07"><input name="sample-checkbox-07" id="checkbox-07" value="7" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Restaurants</div>
                    <div class="property_listnumber">21</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-08"><input name="sample-checkbox-08" id="checkbox-08" value="8" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Spa</div>
                    <div class="property_listnumber">20</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-09"><input name="sample-checkbox-09" id="checkbox-09" value="9" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Bar</div>
                    <div class="property_listnumber">19</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-10"><input name="sample-checkbox-10" id="checkbox-10" value="10" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Parking on site</div>
                    <div class="property_listnumber">18</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-11"><input name="sample-checkbox-11" id="checkbox-11" value="11" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Casino</div>
                    <div class="property_listnumber">18</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-12"><input name="sample-checkbox-12" id="checkbox-12" value="12" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Room Service</div>
                    <div class="property_listnumber">17</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-13"><input name="sample-checkbox-13" id="checkbox-13" value="13" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Gym</div>
                    <div class="property_listnumber">14</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-14"><input name="sample-checkbox-14" id="checkbox-14" value="14" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Handicap-accessible</div>
                    <div class="property_listnumber">12</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-15"><input name="sample-checkbox-15" id="checkbox-15" value="15" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Free WiFi</div>
                    <div class="property_listnumber">9</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-16"><input name="sample-checkbox-16" id="checkbox-16" value="16" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Golf Course</div>
                    <div class="property_listnumber">5</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-17"><input name="sample-checkbox-17" id="checkbox-17" value="17" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Pet-friendly</div>
                    <div class="property_listnumber">4</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-18"><input name="sample-checkbox-18" id="checkbox-18" value="18" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Babysitting</div>
                    <div class="property_listnumber">2</div>
                
          </div>
          <div class="property_listbox">
                	<div class="property_listicon">
                    <fieldset class="checkboxes">
                	  <label class="label_check" for="checkbox-19"><input name="sample-checkbox-19" id="checkbox-19" value="19" type="checkbox" /></label>
                    </fieldset>
                	</div>
                	<div class="property_listtxt">Eco-friendly</div>
                    <div class="property_listnumber">1</div>
                
          </div>-->
    </div>
    
	</aside>
    
    
    <aside class="inner_right clearfix">
      <div class="listview_onebox">
        <section class="listview_filterbox">
          <div class="result_num">26 Matches Found</div>
          <div class="sort_box">Sort: Relevance</div>
          <a href="#"><div class="btn_list">List</div></a>
          <a href="#"><div class="btn_map">Map</div></a>
        </section>
        <ul>
        	<li>
            	<figure class="listview_img_box">
                <div class="offer_item">4 Days Left</div>
                <img src="images/listview_thum.jpg" width="100%" height="auto"></figure>
                <div class="list_item_name_box">
                	<i class="list_item_icn"><img src="images/hotels.png" width="15" height="23"></i>
                    <div class="list_item_nameloc">
                    	<hgroup>
                        	<h1>The Palazzo</h1>
                            <h2>Las Vegas, Nevada</h2>
                        </hgroup>
                    </div>
                </div>
                <article class="list_item_short_note"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dumm</article>
               <div class="list_item_pricebx"> From <span class="list_item_pricebx_blue">$129</span> /night</div>
               <a href="#"><div class="view_sale">View Sale</div></a>
               <a href="#"><div class="list_viewitembtn">Overview</div></a>
               <a href="#"><div class="list_viewitembtn mrleft">Rooms</div></a>
            </li>
            <li>
            	<figure class="listview_img_box"><img src="images/listview_thum2.jpg" width="100%" height="auto"></figure>
                <div class="list_item_name_box">
                	<i class="list_item_icn"><img src="images/hotels.png" width="15" height="23"></i>
                    <div class="list_item_nameloc">
                    	<hgroup>
                        	<h1>The Palazzo</h1>
                            <h2>Las Vegas, Nevada</h2>
                        </hgroup>
                    </div>
                </div>
                <article class="list_item_short_note"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dumm</article>
               <div class="list_item_pricebx"> From <span class="list_item_pricebx_blue">$129</span> /night</div>
               <a href="#"><div class="view_sale">View Sale</div></a>
               <a href="#"><div class="list_viewitembtn">Overview</div></a>
               <a href="#"><div class="list_viewitembtn mrleft">Rooms</div></a>
            </li>
            <li>
            	<figure class="listview_img_box"><img src="images/listview_thum4.jpg" width="100%" height="auto"></figure>
                <div class="list_item_name_box">
                	<i class="list_item_icn"><img src="images/hotels.png" width="15" height="23"></i>
                    <div class="list_item_nameloc">
                    	<hgroup>
                        	<h1>The Palazzo</h1>
                            <h2>Las Vegas, Nevada</h2>
                        </hgroup>
                    </div>
                </div>
                <article class="list_item_short_note"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dumm</article>
               <div class="list_item_pricebx"> From <span class="list_item_pricebx_blue">$129</span> /night</div>
               <a href="#"><div class="view_sale">View Sale</div></a>
               <a href="#"><div class="list_viewitembtn">Overview</div></a>
               <a href="#"><div class="list_viewitembtn mrleft">Rooms</div></a>
            </li>
            <li>
            	<figure class="listview_img_box"><img src="images/listview_thum5.jpg" width="100%" height="auto"></figure>
                <div class="list_item_name_box">
                	<i class="list_item_icn"><img src="images/hotels.png" width="15" height="23"></i>
                    <div class="list_item_nameloc">
                    	<hgroup>
                        	<h1>The Palazzo</h1>
                            <h2>Las Vegas, Nevada</h2>
                        </hgroup>
                    </div>
                </div>
                <article class="list_item_short_note"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dumm</article>
               <div class="list_item_pricebx"> From <span class="list_item_pricebx_blue">$129</span> /night</div>
               <a href="#"><div class="view_sale">View Sale</div></a>
               <a href="#"><div class="list_viewitembtn">Overview</div></a>
               <a href="#"><div class="list_viewitembtn mrleft">Rooms</div></a>
            </li>
            <li>
            	<figure class="listview_img_box"><img src="images/listview_thum4.jpg" width="100%" height="auto"></figure>
                <div class="list_item_name_box">
                	<i class="list_item_icn"><img src="images/hotels.png" width="15" height="23"></i>
                    <div class="list_item_nameloc">
                    	<hgroup>
                        	<h1>The Palazzo</h1>
                            <h2>Las Vegas, Nevada</h2>
                        </hgroup>
                    </div>
                </div>
                <article class="list_item_short_note"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dumm</article>
               <div class="list_item_pricebx"> From <span class="list_item_pricebx_blue">$129</span> /night</div>
               <a href="#"><div class="view_sale">View Sale</div></a>
               <a href="#"><div class="list_viewitembtn">Overview</div></a>
               <a href="#"><div class="list_viewitembtn mrleft">Rooms</div></a>
            </li>
            <li>
            	<figure class="listview_img_box"><img src="images/listview_thum.jpg" width="100%" height="auto"></figure>
                <div class="list_item_name_box">
                	<i class="list_item_icn"><img src="images/hotels.png" width="15" height="23"></i>
                    <div class="list_item_nameloc">
                    	<hgroup>
                        	<h1>The Palazzo</h1>
                            <h2>Las Vegas, Nevada</h2>
                        </hgroup>
                    </div>
                </div>
                <article class="list_item_short_note"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dumm</article>
               <div class="list_item_pricebx"> From <span class="list_item_pricebx_blue">$129</span> /night</div>
               <a href="#"><div class="view_sale">View Sale</div></a>
               <a href="#"><div class="list_viewitembtn">Overview</div></a>
               <a href="#"><div class="list_viewitembtn mrleft">Rooms</div></a>
            </li>
            <li>
            	<figure class="listview_img_box"><img src="images/listview_thum3.jpg" width="100%" height="auto"></figure>
                <div class="list_item_name_box">
                	<i class="list_item_icn"><img src="images/hotels.png" width="15" height="23"></i>
                    <div class="list_item_nameloc">
                    	<hgroup>
                        	<h1>The Palazzo</h1>
                            <h2>Las Vegas, Nevada</h2>
                        </hgroup>
                    </div>
                </div>
                <article class="list_item_short_note"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dumm</article>
               <div class="list_item_pricebx"> From <span class="list_item_pricebx_blue">$129</span> /night</div>
               <a href="#"><div class="view_sale">View Sale</div></a>
               <a href="#"><div class="list_viewitembtn">Overview</div></a>
               <a href="#"><div class="list_viewitembtn mrleft">Rooms</div></a>
            </li>
        </ul>
      </div>
    </aside>

	</div>
	</section>

	<?php
$template->footer();
?>

