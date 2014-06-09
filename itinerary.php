<?php
ob_start("ob_gzhandler");
session_start();

include_once("includes/config.php");


// Set template details
$template 					= new template();
$template->type				= 'CLIENT';
$template->title			= 'Itinerary';
$template->meta_keywords	= 'Stagsource';
$template->meta_description	= 'Stagsource';
$template->footer_content	= true;
$template->js				= '<script type="text/javascript" src="js/tytabs.jquery.min.js"></script>';
$template->css				= '<link href="css/tab.css" rel="stylesheet" type="text/css" />';
$template->heading();

//$location_id 	= (isset($_REQUEST['location']) && $_REQUEST['location'] > 0) ? $_REQUEST['location']: 1;


?>

<script type="text/javascript">
<!--
$(document).ready(function(){
	$("#tabsholder").tytabs({
							tabinit:"3",
							fadespeed:"fast"
							});
	$("#tabsholder2").tytabs({
							prefixtabs:"tabz",
							prefixcontent:"contentz",
							classcontent:"tabscontent",
							tabinit:"3",
							catchget:"tab2",
							fadespeed:"normal"
							});
});
-->
</script>


<script type="text/javascript">
function expand_one(){
	
    $("#expand_first").show(300);
	//$("#content_first_"+id).hide(300);
}
function collaps_one(){
 
 $("#expand_first").hide(300); 

}
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
	


	<section class="inner_banner"></section>
	<section class="contentwrapper">
	<div class="content_inner clearfix">
    <section class="ind_view_headingbox">
    	<h1>Los Angeles</h1><div class="saveurtip"><span class="spnbx">Your trip isn't saved.</span> <a href="#">Save your trip</a></div>
    	<div class="ind_view_adressbox"><img src="images/icn_location.png" width="14" height="21"> Sun, Mar 2nd - Tue Mar 4th | Los Angeles</div>
        <div class="edit_profilebox">
       	  <div class="icn_user_edit"></div>
          <h1>Hello, Anonymous Traveller</h1>
            <a href="#"><span class="txt_editprofile">Edit Profile</span><span class="icn_edit_profile"><img src="images/edit_prfl.png" width="16" height="16"></span></a>
        </div>
    </section>
    <section class="tab_box">
      <div id="tabsholder">

        <ul class="tabs">
            <li id="tab1"><i class="tab_icn"><img src="images/planning.png" width="17" height="17"></i>Planning</li>
            <li id="tab2"><i class="tab_icn"><img src="images/invites.png" width="17" height="17"></i>Invites</li>
            <li id="tab3"><i class="tab_icn"><img src="images/itenerary.png" width="17" height="17"></i>Itenerary</li>
            <li id="tab4"><i class="tab_icn"><img src="images/expenses.png" width="17" height="17"></i>Expenses</li>
        </ul>
        <div class="contents marginbot">

            <div id="content1" class="tabscontent">
            Plan11111
            </div>
            <div id="content2" class="tabscontent">
           	2222222222222222222222
            </div>
            <div id="content3" class="tabscontent">
            <div class="itenerary_heading"><i class="itenerary_headingimg"><img src="images/itenerary_icn.png" width="23" height="29"></i><h1>Itenerary</h1>
    <div class="betatxt"><span class="spnbx2">This is in beta.</span> <a href="#"><strong>We'd love your feedback</strong></a></div>
    </div>
    
    <section class="itenery_icn_outer">
    	<div class="itenery_icnbx">
       	  <h1>What do you want to add to the itinerary?</h1>
            <div class="itenery_icnbx_circle_box">
              <a href="#"><div class="circle"><img src="images/thingstosee.jpg" width="41" height="41"><br>Things to<br><strong>See &amp; Do</strong></div></a>
              <a href="#"><div class="circle"><img src="images/eat.jpg" width="41" height="41"><br><strong>Eat &amp;<br>Drink</strong></div></a>
              <a href="#"><div class="circle"><img src="images/stay.jpg" width="41" height="41"><br>Where to<br><strong>Stay</strong></div></a>
              <a href="#"><div class="circle"><img src="images/transport.jpg" width="41" height="41"><br><strong>Transportation</strong></div></a>
              <a href="#"><div class="circle"><img src="images/general.jpg" width="41" height="41"><br><strong>General</strong></div></a>
            </div>
        </div>
    </section>
    <section class="itenery_list_box">
    	<div class="circle_day"><br>
    	<strong>DAY<br>
    	1</strong></div>
        <div class="itenery_list_box_inner">
        <div class="itenery_list_box_innerhd">Sun 3/2/2014 -<i class="icn_mp"><img src="images/icn_mp.jpg" width="19" height="22"></i> Los Angeles, CA</div>
        <ul>
        	<li>
        	  <div class="list_itm_lftbox">
              	<h1>All Day</h1>
               </div>
              <div class="itenery_list_contentbox">
               	<div class="itenery_list_img"><a href="#"><img src="images/itenery_itm1.jpg" width="100%" height="auto"></a></div>
                <div class="itenery_list_namebox"><h1>Shore Hotel</h1>
                	<div class="itenery_location">
                	<span class="itenery_itm_greytxt"><span class="grymap"><img src="images/greymap.jpg" width="7" height="10"></span> Near Santa Monica Pier</span>
                    </div>
                <div class="itenery_starbox">
                	<div class="icn_bluestar"><img src="images/icn_bluestar.jpg" width="10" height="10"></div> 
                    <div class="icn_bluestar"><img src="images/icn_bluestar.jpg" width="10" height="10"></div>
                    <div class="icn_bluestar"><img src="images/icn_bluestar.jpg" width="10" height="10"></div>
                    <div class="icn_bluestar"><img src="images/icn_bluestar.jpg" width="10" height="10"></div>
                    </div>
                </div>
              </div>
              <div class="booking_box">If you don't have a room yet, book it here:
              	<div class="booking_grey">
                <h2>Booking.com</h2>
                <h1>$287</h1>
                <h3>Avg/night</h3>
                </div>
                <a href="#"><div class="btn_book">Book</div></a>
              </div>
              <div class="edit_viewdetail_box">
                <div class="note">Nore: Hotel</div>
                <a href="#"><div class="edit_view"><span><img src="images/view.jpg" width="14" height="12"></span> View Details</div></a>
                <a href="#"><div class="edit_view"><span><img src="images/edit.jpg" width="14" height="12"></span> Edit</div></a>
              </div>
            </li>
            <li>
        	  <div class="list_itm_lftbox">
              	<h1>2:30 pm
              	  <h2>2 hours</h2>
              	</h1>
              </div>
              <div class="itenery_list_contentbox">
               	<div class="itenery_list_img"><a href="#"><img src="images/itenery_itm2.jpg" width="100%" height="auto"></a></div>
                <div class="itenery_list_namebox">
                  <h1>Pizzeria Mozza</h1>
                	<div class="itenery_location">
                	<span class="itenery_itm_greytxt"><span class="grymap"><img src="images/greymap.jpg" width="7" height="10"></span> 641 N, Highland Ave, Los Angeles, CA</span>
                    </div>
                <div class="itenery_phone">(323) 297-0101 <span class="itenery_phoneblue">@pizzeriamozza</span></div>
                <a href="#"><div class="view_websire">View Website</div></a>
                </div>
              </div>
              <div class="edit_viewdetail_box">
                <div class="note">Nore: Hotel</div>
                <a href="#"><div class="edit_view"><span><img src="images/view.jpg" width="14" height="12"></span> View Details</div></a>
                <a href="#"><div class="edit_view"><span><img src="images/edit.jpg" width="14" height="12"></span> Edit</div></a>
              </div>
            </li>
            <li>
        	  <div class="list_itm_lftbox">
              	<h1>2:30 pm
              	  <h2>2 hours</h2>
              	</h1>
              </div>
              <div class="itenery_list_contentbox">
               	<div class="itenery_list_img"><a href="#"><img src="images/itenery_itm3.jpg" width="100%" height="auto"></a></div>
                <div class="itenery_list_namebox">
          <h1>Philippe the Original</h1>
                	<div class="itenery_location">
                	<span class="itenery_itm_greytxt"><span class="grymap"><img src="images/greymap.jpg" width="7" height="10"></span> 641 N, Highland Ave, Los Angeles, CA</span>
                    </div>
                <div class="itenery_phone">(323) 297-0101 <span class="itenery_phoneblue">@pizzeriamozza</span>
                  </div>
                  <a href="#"><div class="view_websire">View Website</div></a>
                </div>
              </div>
              <div class="edit_viewdetail_box">
                <div class="note">Nore: Hotel</div>
                <a href="#"><div class="edit_view"><span><img src="images/view.jpg" width="14" height="12"></span> View Details</div></a>
                <a href="#"><div class="edit_view"><span><img src="images/edit.jpg" width="14" height="12"></span> Edit</div></a>
              </div>
            </li>
            <li>
        	  <div class="list_itm_lftbox">
              	<h1>2:30 pm
              	  <h2>2 hours</h2>
              	</h1>
              </div>
              <div class="itenery_list_contentbox">
               	<div class="itenery_list_img"><a href="#"><img src="images/itenery_itm2.jpg" width="100%" height="auto"></a></div>
                <div class="itenery_list_namebox">
            <h1>Pizzeria Mozza</h1>
                	<div class="itenery_location">
                	<span class="itenery_itm_greytxt"><span class="grymap"><img src="images/greymap.jpg" width="7" height="10"></span> 641 N, Highland Ave, Los Angeles, CA</span>
                    </div>
                <div class="itenery_phone">(323) 297-0101 <span class="itenery_phoneblue">@pizzeriamozza</span>
                  </div>
                  <a href="#"><div class="view_websire">View Website</div></a>
                </div>
              </div>
              <div class="edit_viewdetail_box">
                <div class="note">Nore: Hotel</div>
                <a href="#"><div class="edit_view"><span><img src="images/view.jpg" width="14" height="12"></span> View Details</div></a>
                <a href="#"><div class="edit_view"><span><img src="images/edit.jpg" width="14" height="12"></span> Edit</div></a>
              </div>
            </li>
        </ul>
        </div>
    </section>
			</div>
            <div id="content4" class="tabscontent">

           4444444444444444444
           	</div>
        </div>
    </div>
  </section>
	</div>
	</section>

	<?php
$template->footer();
?>

