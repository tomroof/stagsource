<?php
class pagination	{
/*
Script Name: *Digg Style Paginator Class
Script URI: http://www.mis-algoritmos.com/2007/05/27/digg-style-pagination-class/
Description: Class in PHP that allows to use a pagination like a digg or sabrosus style.
Script Version: 0.4
Author: Victor De la Rocha
Author URI: http://www.mis-algoritmos.com
*/
		/*Default values*/
		var $total_pages = -1;//items
		var $limit = null;
		var $target = ""; 
		var $page = 1;
		var $adjacents = 2;
		var $showCounter = false;
		var $className = "pagination";
		var $parameterName = "page";
		var $urlF = false;//urlFriendly

		/*Buttons next and previous*/
		var $nextT = "Next";
		var $nextI = "&#187;"; //&#9658;
		var $prevT = "Previous";
		var $prevI = "&#171;"; //&#9668;
			

		/*****/
		var $calculate = false;
		
		#Total items
		function items($value){$this->total_pages = (int) $value;}
		
		#how many items to show per page
		function limit($value){$this->limit = (int) $value;}
		
		#Page to sent the page value
		function target($value){$this->target = $value;}
		
		#Current page
		function currentPage($value){$this->page = (int) $value;}
		
		#How many adjacent pages should be shown on each side of the current page?
		function adjacents($value){$this->adjacents = (int) $value;}
		
		#show counter?
		function showCounter($value=""){$this->showCounter=($value===true)?true:false;}

		#to change the class name of the pagination div
		function changeClass($value=""){$this->className=$value;}

		function nextLabel($value){$this->nextT = $value;}
		function nextIcon($value){$this->nextI = $value;}
		function prevLabel($value){$this->prevT = $value;}
		function prevIcon($value){$this->prevI = $value;}

		#to change the class name of the pagination div
		function parameterName($value=""){$this->parameterName=$value;}

		#to change urlFriendly
		function urlFriendly($value="%"){
				if(eregi('^ *$',$value)){
						$this->urlF=false;
						return false;
					}
				$this->urlF=$value;
			}
		
		var $pagination;

		function pagination(){}
		function show(){
				//echo "<br />Inside Show";
				if(!$this->calculate){
					//echo "<br />Inside Show1";
					if($this->calculate()){
						//echo "<br />Inside Show2";
						echo "<div class=\"$this->className\">$this->pagination</div>\n";
					}
				}		
			}
			
		function show_article(){
				//echo "<br />Inside Show";
			if(!$this->calculate_article){
					//echo "<br />Inside Show1";
					if($this->calculate_article()){
						//echo "<br />Inside Show2";
						echo "<div class=\"pagination\">$this->pagination</div>\n";
					}
				}		
			}
			
		function getOutput(){
				if(!$this->calculate)
					if($this->calculate())
						return "<div class=\"$this->className\">$this->pagination</div>\n";
			}
		function get_pagenum_link($id){
				if(strpos($this->target,'?')===false)
						if($this->urlF)
								return str_replace($this->urlF,$id,$this->target);
							else
								return "$this->target?$this->parameterName=$id";
					else
						return "$this->target&$this->parameterName=$id";
			}
		
		function calculate(){
				//echo "<br />Inside Calculate";
				$this->pagination = "";
				$this->calculate == true;
				$error = false;
				if($this->urlF and $this->urlF != '%' and strpos($this->target,$this->urlF)===false){
						//Es necesario especificar el comodin para sustituir
						echo "Especificaste un wildcard para sustituir, pero no existe en el target<br />";
						$error = true;
					}elseif($this->urlF and $this->urlF == '%' and strpos($this->target,$this->urlF)===false){
						echo "Es necesario especificar en el target el comodin % para sustituir el número de página<br />";
						$error = true;
					}

				if($this->total_pages < 0){
						echo "It is necessary to specify the <strong>number of pages</strong> (\$class->items(1000))<br />";
						$error = true;
					}
				if($this->limit == null){
						echo "It is necessary to specify the <strong>limit of items</strong> to show per page (\$class->limit(10))<br />";
						$error = true;
					}
				if($error)return false;
				
				$n = trim($this->nextT.' '.$this->nextI);
				$p = trim($this->prevI.' '.$this->prevT);
				
				/* Setup vars for query. */
				//echo "<br />Page is : ".$this->page;
				if($this->page) 
					$start = ($this->page - 1) * $this->limit;             //first item to display on this page
				else
					$start = 0;                                //if no page var is given, set start to 0
			
				/* Setup page vars for display. */
				$prev = $this->page - 1;                            //previous page is page - 1
				$next = $this->page + 1;                            //next page is page + 1
				//echo "<br />In Pagination Class. Total Pages are : ".$this->total_pages;
				$lastpage = ceil($this->total_pages/$this->limit);        //lastpage is = total pages / items per page, rounded up.
				$lpm1 = $lastpage - 1;                        //last page minus 1
				$current_page = $_GET['page'];
				
				/*if( ($current_page>1) && ($this->total_pages==$this->limit) ){
					
					if($lastpage >= 1){
						if($this->page){
								//anterior button
								if($this->page > 1)
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($prev)."\" class=\"prev\">$p</a>";
									//else $this->pagination .= "<span class=\"disabled\">$p</span>"; //commented by Merin on QCs comment
							}
						//pages	
						if ($lastpage < 7 + ($this->adjacents * 2)){//not enough pages to bother breaking it up
								for ($counter = 1; $counter <= $lastpage; $counter++){
										if ($counter == $this->page)
												$this->pagination .= "<span class=\"current\">$counter</span>";
											else
												$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
									}
							}
						elseif($lastpage > 5 + ($this->adjacents * 2)){//enough pages to hide some
								//close to beginning; only hide later pages
								if($this->page < 1 + ($this->adjacents * 2)){
										for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++){
												if ($counter == $this->page)
														$this->pagination .= "<span class=\"current\">$counter</span>";
													else
														$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
											}
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\">$lastpage</a>";
									}
								//in middle; hide some front and some back
								elseif($lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)){
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\">$lastpage</a>";
									}
								//close to end; only hide early pages
								else{
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
									}
							}
							//echo "<br />This Page is : ".$this->page;
						if($this->page){
								//siguiente button
								if ($this->page < $counter - 1)
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($next)."\" class=\"next\">$n</a>";
									//else $this->pagination .= "<span class=\"disabled\">$n</span>"; //commented by Merin on QCs comment
									if($this->showCounter)$this->pagination .= "<div class=\"pagination_data\">($this->total_pages Pages)</div>";
							}
					}					
				}
				else{*/
					
					if($lastpage > 1){
						if($this->page){
								//anterior button
								if($this->page > 1)
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($prev)."\" class=\"prev\">$p</a>";
									//else $this->pagination .= "<span class=\"disabled\">$p</span>"; //commented by Merin on QCs comment
							}
						//pages	
						if ($lastpage < 7 + ($this->adjacents * 2)){//not enough pages to bother breaking it up
								for ($counter = 1; $counter <= $lastpage; $counter++){
										if ($counter == $this->page)
												$this->pagination .= "<span class=\"current\">$counter</span>";
											else
												$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
									}
							}
						elseif($lastpage > 5 + ($this->adjacents * 2)){//enough pages to hide some
								//close to beginning; only hide later pages
								if($this->page < 1 + ($this->adjacents * 2)){
										for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++){
												if ($counter == $this->page)
														$this->pagination .= "<span class=\"current\">$counter</span>";
													else
														$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
											}
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\">$lastpage</a>";
									}
								//in middle; hide some front and some back
								elseif($lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)){
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\">$lastpage</a>";
									}
								//close to end; only hide early pages
								else{
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
									}
							}
							//echo "<br />This Page is : ".$this->page;
						if($this->page){
								//siguiente button
								if ($this->page < $counter - 1)
									$this->pagination .= "<a href=\"".$this->get_pagenum_link($next)."\" class=\"next\">$n</a>";
									//else $this->pagination .= "<span class=\"disabled\">$n</span>"; //commented by Merin on QCs comment
									if($this->showCounter)$this->pagination .= "<div class=\"pagination_data\">($this->total_pages Pages)</div>";
							}
					//}					
				}
				
				

				return true;
			}
			
			function calculate_article(){
				//echo "<br />Inside Calculate";
				
				if($this->total_pages <= $this->limit) return false;
				$this->pagination = "<span class=\"pagination_inner\">";
				$this->calculate == true;
				$error = false;
				if($this->urlF and $this->urlF != '%' and strpos($this->target,$this->urlF)===false){
						//Es necesario especificar el comodin para sustituir
						echo "Especificaste un wildcard para sustituir, pero no existe en el target<br />";
						$error = true;
					}elseif($this->urlF and $this->urlF == '%' and strpos($this->target,$this->urlF)===false){
						echo "Es necesario especificar en el target el comodin % para sustituir el número de página<br />";
						$error = true;
					}

				if($this->total_pages < 0){
						echo "It is necessary to specify the <strong>number of pages</strong> (\$class->items(1000))<br />";
						$error = true;
					}
				if($this->limit == null){
						echo "It is necessary to specify the <strong>limit of items</strong> to show per page (\$class->limit(10))<br />";
						$error = true;
					}
				if($error)return false;
				
				//$nextT1 = '<a class="next" "></a>';
				//$prevT1 = '<a class="prev" "></a>';
				
				$n = trim($nextT1); //$n = trim($this->nextT.' '.$this->nextI);
				$p = trim($prevT1); //$p = trim($this->prevI.' '.$this->prevT1);
				
				/* Setup vars for query. */
				//echo "<br />Page is : ".$this->page;
				if($this->page) 
					$start = ($this->page - 1) * $this->limit;             //first item to display on this page
				else
					$start = 0;                                //if no page var is given, set start to 0
			
				/* Setup page vars for display. */
				$prev = $this->page - 1;                            //previous page is page - 1
				$next = $this->page + 1;                            //next page is page + 1
				//echo "<br />In Pagination Class. Total Pages are : ".$this->total_pages;
				$lastpage = ceil($this->total_pages/$this->limit);        //lastpage is = total pages / items per page, rounded up.
				$lpm1 = $lastpage - 1;                        //last page minus 1
				$current_page = $_GET['page'];
				
				
					
					if($lastpage > 1){
						if($this->page){
								//anterior button
								if($this->page > 1)
									$this->pagination .= "<a href=\"".$this->get_pagenum_link($prev)."\" class=\"prev\">$p</a>";
									//else $this->pagination .= "<span class=\"disabled\">$p</span>"; //commented by Merin on QCs comment
							}
						//pages	
						
						//$this->pagination .= '<ul>';
						if ($lastpage < 7 + ($this->adjacents * 2)){//not enough pages to bother breaking it up
								for ($counter = 1; $counter <= $lastpage; $counter++){
									if($counter ==  1 && $this->page < 2 )
									{
										if ($counter == $this->page)
												$this->pagination .= "<span class=\"current\" style=\"border-left:none;\">$counter</span>";
											else
												$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\" class=\"pgntin_a\" style=\"border-left:none;\">$counter</a>";
										
									}
									else
									{
										if ($counter == $this->page)
												$this->pagination .= "<span class=\"current\" >$counter</span>";
											else
												$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\" class=\"pgntin_a\">$counter</a>";
									}
								}
							}
						elseif($lastpage > 5 + ($this->adjacents * 2)){//enough pages to hide some
								//close to beginning; only hide later pages
								if($this->page < 1 + ($this->adjacents * 2)){
										for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++){
											if($counter ==  1 && $this->page < 2 )
											{
												if ($counter == $this->page)
														$this->pagination .= "<span class=\"current\" style=\"border-left:none;\">$counter</span>";
													else
														$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\" class=\"pgntin_a\" style=\"border-left:none;\">$counter</a>";
											}
											else
											{
												if ($counter == $this->page)
														$this->pagination .= "<span class=\"current\">$counter</span>";
													else
														$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\" class=\"pgntin_a\">$counter</a>";
											}
										}
										
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\" class=\"pgntin_a\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\" class=\"pgntin_a\">$lastpage</a>";
									}
								//in middle; hide some front and some back
								elseif($lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)){
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\" class=\"pgntin_a\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\" class=\"pgntin_a\">2</a>";
										$this->pagination .= "...";
										for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\" class=\"pgntin_a\">$counter</a>";
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\" class=\"pgntin_a\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\" class=\"pgntin_a\">$lastpage</a>";
									}
								//close to end; only hide early pages
								else{
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\" class=\"pgntin_a\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\" class=\"pgntin_a\">2</a>";
										$this->pagination .= "...";
										for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\" class=\"pgntin_a\">$counter</a>";
									}
							}
							
							
							//$this->pagination .= '</ul>';
							//echo "<br />This Page is : ".$this->page;
						if($this->page){
								//siguiente button
								if ($this->page < $counter - 1)
									$this->pagination .= "<a href=\"".$this->get_pagenum_link($next)."\" class=\"next\">$n</a>";
									//else $this->pagination .= "<span class=\"disabled\">$n</span>"; //commented by Merin on QCs comment
									if($this->showCounter)$this->pagination .= "<div class=\"pagination_data\">($this->total_pages Pages)</div>";
							}
					//}					
				}
				
				$this->pagination .="</span>";

				return true;
			}
			
			function calculate_article1(){
				//echo "<br />Inside Calculate";
				
				if($this->total_pages <= $this->limit) return false;
				$this->pagination = "";
				$this->calculate == true;
				$error = false;
				if($this->urlF and $this->urlF != '%' and strpos($this->target,$this->urlF)===false){
						//Es necesario especificar el comodin para sustituir
						echo "Especificaste un wildcard para sustituir, pero no existe en el target<br />";
						$error = true;
					}elseif($this->urlF and $this->urlF == '%' and strpos($this->target,$this->urlF)===false){
						echo "Es necesario especificar en el target el comodin % para sustituir el número de página<br />";
						$error = true;
					}

				if($this->total_pages < 0){
						echo "It is necessary to specify the <strong>number of pages</strong> (\$class->items(1000))<br />";
						$error = true;
					}
				if($this->limit == null){
						echo "It is necessary to specify the <strong>limit of items</strong> to show per page (\$class->limit(10))<br />";
						$error = true;
					}
				if($error)return false;
				
				$nextT1 = '<div class="pagination_right"><img src="'. URI_ROOT.'images/pagination_arrow_right.jpg" width="22" height="11"></div>';
				$prevT1 = '<div class="pagination_left"><img src="'. URI_ROOT .'images/pagination_arrow_left.jpg" width="22" height="11"></div>';
				
				$n = trim($nextT1); //$n = trim($this->nextT.' '.$this->nextI);
				$p = trim($prevT1); //$p = trim($this->prevI.' '.$this->prevT1);
				
				/* Setup vars for query. */
				//echo "<br />Page is : ".$this->page;
				if($this->page) 
					$start = ($this->page - 1) * $this->limit;             //first item to display on this page
				else
					$start = 0;                                //if no page var is given, set start to 0
			
				/* Setup page vars for display. */
				$prev = $this->page - 1;                            //previous page is page - 1
				$next = $this->page + 1;                            //next page is page + 1
				//echo "<br />In Pagination Class. Total Pages are : ".$this->total_pages;
				$lastpage = ceil($this->total_pages/$this->limit);        //lastpage is = total pages / items per page, rounded up.
				$lpm1 = $lastpage - 1;                        //last page minus 1
				$current_page = $_GET['page'];
				
				
					
					if($lastpage > 1){
						if($this->page){
								//anterior button
								if($this->page > 1)
									$this->pagination .= "<a href=\"".$this->get_pagenum_link($prev)."\" class=\"prev\">$p</a>";
									//else $this->pagination .= "<span class=\"disabled\">$p</span>"; //commented by Merin on QCs comment
							}
						//pages	
						
						$this->pagination .= '<ul>';
						if ($lastpage < 7 + ($this->adjacents * 2)){//not enough pages to bother breaking it up
								for ($counter = 1; $counter <= $lastpage; $counter++){
										if ($counter == $this->page)
												$this->pagination .= "<li class=\"paginationactive\">$counter</li>";
											else
												$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\"><li>$counter</li></a>";
									}
							}
						elseif($lastpage > 5 + ($this->adjacents * 2)){//enough pages to hide some
								//close to beginning; only hide later pages
								if($this->page < 1 + ($this->adjacents * 2)){
										for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++){
												if ($counter == $this->page)
														$this->pagination .= "<li class=\"paginationactive\">$counter</li>";
													else
														$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\"><li>$counter</li></a>";
											}
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\">$lastpage</a>";
									}
								//in middle; hide some front and some back
								elseif($lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)){
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<li class=\"paginationactive\">$counter</li>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\">$lastpage</a>";
									}
								//close to end; only hide early pages
								else{
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
									}
							}
							
							
							$this->pagination .= '</ul>';
							//echo "<br />This Page is : ".$this->page;
						if($this->page){
								//siguiente button
								if ($this->page < $counter - 1)
									$this->pagination .= "<a href=\"".$this->get_pagenum_link($next)."\" class=\"next\">$n</a>";
									//else $this->pagination .= "<span class=\"disabled\">$n</span>"; //commented by Merin on QCs comment
									if($this->showCounter)$this->pagination .= "<div class=\"pagination_data\">($this->total_pages Pages)</div>";
							}
					//}					
				}
				
				

				return true;
			}
	}
?>