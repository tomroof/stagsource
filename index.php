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
$template->js				= '<!--<script type="text/javascript" src="'.URI_LIBRARY.'select/jquery.selectbox-0.2.js"></script>
								<script type="text/javascript" src="'.URI_LIBRARY.'select/functions.js"></script>
								<script src="js/ion.rangeSlider.js"></script>-->';

$template->css				= '	<!--<link rel="stylesheet" href="css/demo_rangeslider.css">
								<link rel="stylesheet" href="css/ion.rangeSlider.css">
								<link rel="stylesheet" href="css/skin1.css" id="skinCss">-->
								<link href="css/hover_content.css" rel="stylesheet" type="text/css"/>
								<!--<link href="'.URI_LIBRARY.'select/jquery.selectbox.css" type="text/css" rel="stylesheet"/>-->
								<link rel="stylesheet" type="text/css" href="css/component.css" />
								';
$template->heading();

$content   = new content();


?>


	<section class="banner">
	<div class="banner_inner">
		<div class="banner_content">
			 <p class="banner_text">
                        Let us help you plan for your next wedding event.
                    </p>
                    
                    <div class="signup_box">
                        <div class="hm_baner_btn hm_mrlft"  style="cursor:pointer;"  id="bachelorparty_btn1" class="big-link" data-reveal-id="bachelorparty"  data-animation="fadeAndPop" >BACHELOR PARTY</div>
                        <div class="hm_baner_btn" style="cursor:pointer;" id="wedding_btn1" class="big-link" data-reveal-id="weddingparty" data-animation="fadeAndPop">WEDDING</div>
                        <div class="hm_baner_btn">HONEYMOON</div>
                    </div>
                </div>
	</div>
    
	</section>
	<section class="contentwrapper">
	<div class="content_inner">
		<div class="adbox">
			<div class="ad1">
				<img src="images/ad1.png" width="100%" height="auto">
			</div>
			<!--<div class="filter">
				<select name="type_annonce" class="ordinnary_text_form" id="2">
					<option value="%">Filter Items By Type</option>
					<option value="1">Sample New</option>
					<option value="2">Sample old</option>
					<option value="3">Sample New</option>
				</select>
			</div>-->
		</div>
		
        <section class="product_box_outer">
		<ul class="grid effect-1 caption-style-2" id="grid">
        
			<?php
				$content->get_article_array();					
		    ?>
        
        </ul>
        

        <!--<div class="pagination">
        <span class="pagination_inner"><a class="prev" href="http://clients.rainend.com/cmtequipment.com.au/products/liquid-limit-cassagrande/1"> </a><span class="current">1</span><a href="http://clients.rainend.com/cmtequipment.com.au/products/liquid-limit-cassagrande/2" class="pgntin_a">2</a><a class="next" href="http://clients.rainend.com/cmtequipment.com.au/products/liquid-limit-cassagrande/2"></a>
        </span></div>-->
        <?php functions::paginateclient_article($content->num_rows, 1, $content->pager_param, 'CLIENT'); ?>
 
        	<!--<a href="#"><div class="pagination_left"><img src="images/pagination_arrow_left.jpg" width="22" height="11"></div></a>
     		<ul>
            	<a href="#"><li class="paginationactive">1</li></a>
                <a href="#"><li>2</li></a>
                <a href="#"><li>3</li></a>
                <a href="#"><li>4</li></a>
                <a href="#"><li>5</li></a>
            </ul>
            <a href="#"> <div class="pagination_right"><img src="images/pagination_arrow_right.jpg" width="22" height="11"></div></a>-->
        
        
        <?php
				/*$param_array			= array();
				$page 			= (isset($_REQUEST['page']) && $_REQUEST['page'] > 0) ? $_REQUEST['page'] : 1;
				 
				$big_array 		=  $content->get_article_big_array(); 
				$small_array 	=  $content->get_article_small_array(); 
								
				$reduce 		= 0;
				$limit 			= 9;
				if(count($big_array) == 0 && count($small_array) == 0)
				{
					echo "Sorry...... No Results found!";	
				}
				else
				{
					if(isset($big_array[$page-1]))
					{
						$reduce 		= 1;
						$content1		= new content($big_array[$page-1]);
						
						?>
                        <li>
                            <div class="product_box">
                                <div class="product_boximg ">
                                    <img src="<?php echo URI_CONTENT.'thumb1_'.$content1->content_thumbnail;?>" >
                                    <div class="caption" >
                                        <div class="blur" style="height:450px;">
                                        </div>
                                        <div class="caption-text">
                                             <h1><?php echo functions::deformat_string($content1->title); ?></h1>
                                            <p>
                                                 <?php echo substr(strip_tags(functions::deformat_string($content1->content)), 0, 400); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="prd_contentbox">
                                    <?php echo functions::deformat_string($content1->title); ?>
                                    <div class="comment_favbox">
                                        <div class="comment">
                                            0
                                        </div>
                                        <div class="fav">
                                            15
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </li>
                        <?php
					}
																
						
						for($i=0; $i< count($small_array)-16; $i++)
						{
							$content1		= new content($small_array[$i]);
						?>
                        	<li>
                                <div class="product_box">
                                    <div class="product_boximg ">
                                        <img src="<?php echo URI_CONTENT.'thumb1_'.$content1->content_thumbnail;?>" >
                                        <div class="caption">
                                            <div class="blur">
                                          </div>
                                            <div class="caption-text">
                                                <h1><?php echo functions::deformat_string($content1->title); ?></h1>
                                                <p>
                                                    <?php echo substr(strip_tags(functions::deformat_string($content1->content)), 0, 250); ?>
                                                </p>
                                            </div>
                                      </div>
                                  </div>
                                    <div class="prd_contentbox">
                                        <?php echo functions::deformat_string($content1->title); ?>
                                        <div class="comment_favbox">
                                            <div class="comment">
                                                0
                                            </div>
                                            <div class="fav">
                                                15
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        
                        <?php
						}
	
				}
				
				echo '</ul>';*/
				
				/*echo '<div class="pagination">
						<a href="#"><div class="pagination_left"><img src="images/pagination_arrow_left.jpg" width="22" height="11"></div></a>
						<ul>
							<a href="#"><li class="paginationactive">1</li></a>
							<a href="#"><li>2</li></a>
							<a href="#"><li>3</li></a>
							<a href="#"><li>4</li></a>
							<a href="#"><li>5</li></a>
						</ul>
						<a href="#"> <div class="pagination_right"><img src="images/pagination_arrow_right.jpg" width="22" height="11"></div></a>
					</div>';*/
			?>        	
        
			<!--<li>
			<div class="product_box">
				<div class="product_boximg ">
					<img src="images/thum_big.jpg" >
					<div class="caption" >
						<div class="blur" style="height:450px;">
						</div>
						<div class="caption-text">
							<h1>Amazing Caption</h1>
							<p>
								Whatever It Is - Always Awesome
							</p>
						</div>
					</div>
				</div>
				<div class="prd_contentbox">
					Lorem Ipsum
					<div class="comment_favbox">
						<div class="comment">
							0
						</div>
						<div class="fav">
							15
						</div>
					</div>
				</div>
			</div>
			</li>
            <li>
			<div class="product_box">
				<div class="product_boximg ">
					<img src="images/thum7.jpg" >
					<div class="caption">
						<div class="blur">
					  </div>
						<div class="caption-text">
							<h1>Amazing Caption</h1>
							<p>
								Whatever It Is - Always Awesome
							</p>
						</div>
				  </div>
			  </div>
				<div class="prd_contentbox">
					Lorem Ipsum
					<div class="comment_favbox">
						<div class="comment">
							0
						</div>
						<div class="fav">
							15
						</div>
					</div>
				</div>
			</div>
			</li>
            <li>
            <div class="corner_price">$9</div>
			<div class="product_box">
				<div class="product_boximg ">
					<img src="images/thum2.jpg" >
					<div class="caption">
						<div class="blur">
					  </div>
						<div class="caption-text">
							<h1>Amazing Caption</h1>
							<p>
								Whatever It Is - Always Awesome
							</p>
						</div>
				  </div>
			  </div>
				<div class="prd_contentbox">
					Lorem Ipsum
					<div class="comment_favbox">
						<div class="comment">
							0
						</div>
						<div class="fav">
							15
						</div>
					</div>
				</div>
			</div>
			</li>
            <li>
			<div class="product_box">
				<div class="product_boximg ">
					<img src="images/thum5.jpg" >
					<div class="caption">
						<div class="blur">
					  </div>
						<div class="caption-text">
							<h1>Amazing Caption</h1>
							<p>
								Whatever It Is - Always Awesome
							</p>
						</div>
				  </div>
			  </div>
				<div class="prd_contentbox">
					Lorem Ipsum
					<div class="comment_favbox">
						<div class="comment">
							0
						</div>
						<div class="fav">
							15
						</div>
					</div>
				</div>
			</div>
			</li>
            <li>
			<div class="product_box">
				<div class="product_boximg ">
					<img src="images/thum3.jpg" height="215" >
					<div class="caption">
						<div class="blur">
					  </div>
						<div class="caption-text">
							<h1>Amazing Caption</h1>
							<p>
								Whatever It Is - Always Awesome
							</p>
						</div>
				  </div>
			  </div>
				<div class="prd_contentbox">
					Lorem Ipsum
					<div class="comment_favbox">
						<div class="comment">
							0
						</div>
						<div class="fav">
							15
						</div>
					</div>
				</div>
			</div>
			</li>
            
            
            
            <li>
			<div class="product_box">
				<div class="product_boximg ">
					<img src="images/thum_big.jpg" >
					<div class="caption" >
						<div class="blur" style="height:450px;">
						</div>
						<div class="caption-text">
							<h1>Amazing Caption</h1>
							<p>
								Whatever It Is - Always Awesome
							</p>
						</div>
					</div>
				</div>
				<div class="prd_contentbox">
					Lorem Ipsum
					<div class="comment_favbox">
						<div class="comment">
							0
						</div>
						<div class="fav">
							15
						</div>
					</div>
				</div>
			</div>
			</li>
            <li>
			<div class="product_box">
				<div class="product_boximg ">
					<img src="images/thum7.jpg" >
					<div class="caption">
						<div class="blur">
					  </div>
						<div class="caption-text">
							<h1>Amazing Caption</h1>
							<p>
								Whatever It Is - Always Awesome
							</p>
						</div>
				  </div>
			  </div>
				<div class="prd_contentbox">
					Lorem Ipsum
					<div class="comment_favbox">
						<div class="comment">
							0
						</div>
						<div class="fav">
							15
						</div>
					</div>
				</div>
			</div>
			</li>
            <li>
            <div class="corner_price">$9</div>
			<div class="product_box">
				<div class="product_boximg ">
					<img src="images/thum2.jpg" >
					<div class="caption">
						<div class="blur">
					  </div>
						<div class="caption-text">
							<h1>Amazing Caption</h1>
							<p>
								Whatever It Is - Always Awesome
							</p>
						</div>
				  </div>
			  </div>
				<div class="prd_contentbox">
					Lorem Ipsum
					<div class="comment_favbox">
						<div class="comment">
							0
						</div>
						<div class="fav">
							15
						</div>
					</div>
				</div>
			</div>
			</li>-->
		<!--</ul>
        <div class="pagination">
        	<a href="#"><div class="pagination_left"><img src="images/pagination_arrow_left.jpg" width="22" height="11"></div></a>
     		<ul>
            	<a href="#"><li class="paginationactive">1</li></a>
                <a href="#"><li>2</li></a>
                <a href="#"><li>3</li></a>
                <a href="#"><li>4</li></a>
                <a href="#"><li>5</li></a>
            </ul>
            <a href="#"> <div class="pagination_right"><img src="images/pagination_arrow_right.jpg" width="22" height="11"></div></a>
        </div>-->
        
        
	  </section>
        


	</div>
	</section>

	<?php
		$template->footer();
	?>
    
    
    
    <script src="js/masonry.pkgd.min.js"></script>
	  <script src="js/imagesloaded.js"></script>
	  <script src="js/AnimOnScroll.js"></script>
	  <script>
			new AnimOnScroll( document.getElementById( 'grid' ), {
				minDuration : 0.4,
				maxDuration : 0.7,
				viewportFactor : 0.2
			} );
			
	 </script>
