<?php
/*********************************************************************************************
Author 	: V V VIJESH
Date	: 14-April-2011
Purpose	: Content option class
*********************************************************************************************/
class content_option
{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';

	function __construct($content_option_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		
		if($content_option_id > 0)
		{
			$this->initialize($content_option_id);
		}
	}
	
	function __get($property_name)
	{
		if (array_key_exists($property_name, $this->_properties))
		{
			return $this->_properties[$property_name];
		}

		return null;
	}

	public function __set($property_name, $value)
	{
		return $this->_properties[$property_name] = $value;
	}
	
	public function __destruct() 
	{
		unset($this->_properties);
		unset($this->error);
		unset($this->message);
	}
	
	//Initialize object variables.
	private function initialize($content_option_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM content_option WHERE content_option_id = '$content_option_id'";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$this->_properties	= $result->fetch_assoc();
		}
	}

	// Save the Content option details
	public function save()
	{
		//echo "news_date=".$this->news_date;
		//echo "<br>";
		$database	= new database();
		if ( isset($this->_properties['content_option_id']) && $this->_properties['content_option_id'] > 0) 
		{
			//$idate 		= explode('-', $this->news_date);
		//	$news_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];

			
			$sql	= "UPDATE content_option SET content_id = '". $database->real_escape_string($this->content_id)  ."',
			 title = '". $database->real_escape_string($this->title)  ."', 
			  description = '".  $database->real_escape_string($this->description)  ."'
			
			   WHERE content_option_id = '$this->content_option_id'";
		}
		else 
		{
				//$idate 		= explode('-', $this->news_date);
				//$news_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];
			
			
			$order_id	= self::get_max_order_id($this->content_id) + 1;
			$sql		= "INSERT INTO content_option 
						(content_id, title, description, added_date, status, order_id) 
						VALUES ('" . $database->real_escape_string($this->content_id) . "',
								'" . $database->real_escape_string($this->title) . "',
								'" . $database->real_escape_string($this->description) . "',
								NOW(),
								'Y', 
								'" . $order_id . "'
								
								)";
		}
		//print $sql; exit;
		$result			= $database->query($sql);
		
		if($database->affected_rows == 1)
		{
			if($this->content_option_id == 0)
			{
				$this->content_option_id	= $database->insert_id;
			}
			$this->initialize($this->content_option_id);
		}
	
		$this->message = cnst11;
		return true;
	}
	
	// Returns the max order id
	public static function get_max_order_id($content_id)
	{
		$database	= new database();
		$sql		= "SELECT MAX(order_id) AS order_id FROM content_option WHERE content_id = '$content_id'";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$data	= $result->fetch_object();
			return $data->order_id > 0 ? $data->order_id : 0;
		}
		else
		{
			return 0;
		}
	}
	
	// Functoion update the list order
	public function update_list_order($list_array, $page_number)
	{
		$database		= new database();
		$limit			= PAGE_LIMIT;
		$id_array		= array();
		
		foreach ($list_array as $id)
		{
			if($id == '')
			{
				continue;
			}
			$id_array[] = $id;
		}
		
		if($page_number > 1)
		{
			$order_id = (($page_number - 1) * PAGE_LIMIT) + 1 ;
		}
		else
		{
			$order_id = 1;
		}
		
		for($i = 0; $i < count($id_array); $i++ )
		{
			$sql = "UPDATE content_option SET order_id = '" . $order_id . "' WHERE content_option_id = '" . $id_array[$i] . "'";
			$database->query($sql);
			$order_id++;
		}
	}
	
	// Remove the current object details.
	public function remove()
	{
		$database	= new database();
		if ( isset($this->_properties['content_option_id']) && $this->_properties['content_option_id'] > 0) 
		{
			$sql = "DELETE FROM content_option WHERE content_option_id = '" . $this->content_option_id . "'";
			try
			{
				if($result 	= $database->query($sql)) 
				{
					if ($database->affected_rows > 0)
					{
						$this->message = cnst12;	// Data successfully removed!
					}
				}
				else 
				{
					throw new Exception(cnst13);	// Selected record is not found!
				}
			}
			catch (Exception $e)
			{
				$this->message	= "Exception: ".$e->getMessage();
				$this->warning	= true;
			}
		}
	}
	
	// Remove selected items
	public function remove_selected($content_option_ids)
	{
		$database	= new database();
		if(count($content_option_ids)>0)
		{		
			foreach($content_option_ids as $content_option_id)
			{
				$content_option	= new content_option($content_option_id);
				$image_name = $content_option->image_name;
					
					//echo DIR_CONTENT_OPTION . $image_name;
					if(file_exists(DIR_CONTENT_OPTION . $image_name))
					{
						unlink(DIR_CONTENT_OPTION . $image_name);
					}
				
				$sql = "DELETE FROM content_option WHERE content_option_id = '" . $content_option_id . "'";
				try
				{
					if($result 	= $database->query($sql)) 
					{
						if ($database->affected_rows > 0)
						{
							$this->message = cnst12;	// Data successfully removed!
						}
					}
					else 
					{
						throw new Exception(cnst13);	// Selected record is not found!
					}
				}
				catch (Exception $e)
				{
					$this->message	= "Exception: ".$e->getMessage();
					$this->warning	= true;
				}							   
			}		  		   
		}
	}
	
	// Remove by category
	public function remove_by_category($content_id)
	{
		$database		= new database();
    
    	$sql			= "SELECT * FROM content_option WHERE content_id='".$content_id."' ORDER BY added_date DESC";
		$result			= $database->query($sql);
		$image_list	= '';
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$content_option	= new content_option($data->content_option_id);
				$image_name		= $content_option->image_name;
				
				if(file_exists(DIR_CONTENT_OPTION . $image_name))
				{
					unlink(DIR_CONTENT_OPTION . $image_name);
				}
				if(file_exists(DIR_CONTENT_OPTION . 'thumb_' . $image_name))
				{
					unlink(DIR_CONTENT_OPTION . 'thumb_' . $image_name);
				}
				
				$sql_del = "DELETE FROM content_option WHERE content_option_id = '" . $content_option->content_option_id . "'";
				try
				{
					if($result_del 	= $database->query($sql_del)) 
					{
						if ($database->affected_rows > 0)
						{
							$this->message = cnst12;	// Data successfully removed!
						}
					}
					else 
					{
						throw new Exception(cnst13);	// Selected record is not found!
					}
				}
				catch (Exception $e)
				{
					$this->message	= "Exception: ".$e->getMessage();
					$this->warning	= true;
				}
			}
		}
	}
	
	public function display_list()
	{	
		$database				= new database();
		$validation				= new validation(); 
		$param_array			= array();
		$sql					= "SELECT * FROM content_option ";
		$drag_drop				= '';
		
		$search_cond_array[]	= " content_id = '$this->content_id' ";
		$param_array[]			= "content_id=$this->content_id";
		if(isset($_REQUEST['search_word'])) 
		{
			$search_word	= functions::clean_string($_REQUEST['search_word']);
			if(!empty($search_word))
			{
				$validation->check_blank($search_word, 'Search word', 'search_word');					
				if (!$validation->checkErrors())
				{
					$param_array[]			= "search=true";
					$param_array[]			= "search_word=" . htmlentities($search_word);
					$search_cond_array[]	= " title like '%" . $database->real_escape_string($search_word) . "%' ";	
				}
			}
			// Drag and dorp ordering is not available in search
			$drag_drop 						= ' nodrag nodrop ';
		}
		
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
			$sql				.= $search_condition;
		}
					
		$sql 			= $sql . " ORDER BY order_id ASC";
		$result			= $database->query($sql);
		
		$this->num_rows = $result->num_rows;
		functions::paginate($this->num_rows);
		$start			= functions::$startfrom;
		$limit			= functions::$limits;
		$sql 			= $sql . " limit $start, $limit";
		$result			= $database->query($sql);
		
		$param=join("&amp;",$param_array); 
		$this->pager_param=$param;
		
		if ($result->num_rows > 0)
		{				
			$i 			= 0;
			$row_num	= functions::$startfrom;
			$page		= functions::$startfrom > 0 ? (functions::$startfrom / PAGE_LIMIT) + 1 : 1;
			
			echo '
			<tr class="lightColorRow nodrop nodrag" style="display:none;">
				<td colspan="5"  class="noBorder">
					<input type="hidden" id="show"  name="show" value="0" />
					<input type="hidden" id="content_option_id" name="content_option_id" value="0" />
					<input type="hidden" id="show_content_option_id" name="show_content_option_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					<input type="hidden" id="page" name="page" value="' . $page . '" />
				</td>
			</tr>';
			
			while($data=$result->fetch_object())
			{
				$i++;
				$content_option_serial_value++;
				$row_num++;
				$class_name= (($row_type%2) == 0) ? "even" : "odd";
				$name		= $data->title != '' ? $data->title : $data->alt;
				$name		= $name != '' ? $name : $data->image_name;
				$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
					$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
				echo '
					<tr id="' . $data->content_option_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td class="widthAuto"><a href="#" title="Click here to view details" onClick="javascript:open_content_option_details(\''.$data->content_option_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$content_option_serial_value.'\');return false;">' .functions::deformat_string($data->title) . '</a></td>
						<td class="widthAuto"><a href="#" title="Click here to view details" onClick="javascript:open_content_option_details(\''.$data->content_option_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$content_option_serial_value.'\');return false;">' .substr(functions::deformat_string($data->description),0,60) . '</a></td>
						<td class="alignCenter"><a title="Click here to update status" class="handCursor" onclick="javascript: change_content_option_status(\'' . $data->content_option_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a></td>
						<td class="alignCenter">
							<a href="register_content_option.php?content_id=' . $data->content_id . '&content_option_id=' . $data->content_option_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>
						<td class="alignCenter deleteCol">
							<label><input type="checkbox" name="checkbox[' . $data->content_option_id . ']" id="checkbox" /></label>
						</td>
					</tr>
					
					
					<tr id="details'.$i.'" class="expandRow" >
								<td id="details_div_'.$i.'" colspan="7" height="1" ></td>
							</tr>';
				$row_type++;
			}
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
		}
		else
		{
			$this->pager_param1 = join("&",$param_array);
			if(isset($_GET['page']))
			{
				$currentPage = $_GET['page'];
			}
			if($currentPage>1)
			{
				$currentPage = $currentPage-1;
				if($this->pager_param=="")
				{
					$urlQuery = 'manage_image.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_image.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='4' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
	
	//The function check the no images in a gallery
	public function no_image_in_gallery($content_id=0)
	{
		$output		= false;
		$database	= new database();
		$num_rows	= 0;
		$sql		= "SELECT *	 FROM content_option WHERE content_id = '" . $content_id . "'";
		//print $sql;
		$result 	= $database->query($sql);
		if ($result->num_rows > 0)
		{
			$num_rows	= $result->num_rows;
		}
		return $num_rows;	
	}
	
	public function get_gallery_list($content_id, $item_per_row = 4, $pagination = true, $item_per_page = 0)
	{
		$database			= new database();
		$gallery_array 	= array();
		$sql				= "SELECT * FROM content_option WHERE content_id='".$content_id."' ORDER BY added_date DESC";
		$result				= $database->query($sql);
		$this->num_rows		= $result->num_rows;
		
		$param_array		= array();
		$param_array[]		= "content_id=" . htmlentities($content_id);
		$param				= join("&amp;", $param_array); 
		$this->pager_param	= $param;
		
		if($pagination == true)
		{
			functions::paginateclient_cat($this->num_rows, 0, 0, 'CLIENT', $item_per_page);
			$start				= isset(functions::$startfrom1) ? functions::$startfrom1 : 0;
			$limit				= isset(functions::$limits1) ? functions::$limits1 : FRONT_PAGE_LIMIT*4;		
			$sql 				= $sql . " limit $start, $limit";
		}
		
		$result				= $database->query($sql);
		$num_rows			= $result->num_rows;
		
		if ($num_rows > 0)
		{
			$counter		= 0;
			$items_per_row	= 4;
			while($data = $result->fetch_object())
			{
				$counter++;
				$thumb_image	= '';
				$url			= '';
				
				if(!file_exists(DIR_CONTENT_OPTION . 'thumb_' . $data->image_name))
				{
					$functions	= new functions();
					$functions->generate_thumb_image($data->image_name, DIR_CONTENT_OPTION, GALLERY_THUMB_WIDTH, GALLERY_THUMB_HEIGHT);
				}
				$thumb_image	= URI_MEMBER . 'thumb_' . $data->image_name;
				
				?>
				<div class="productCategory">
				<div class="tumbHolder"><a rel="example4" href="<?php echo URI_MEMBER . $data->image_name; ?>"><img src="<?php echo $thumb_image; ?>" alt="<?php echo functions::format_text_field($data->alt); ?>" /></a></div>
				<p><?php echo functions::deformat_string($data->title);?></p>
				</div>
				<?php
				if($counter == $items_per_row)
				{
					$counter		= 0;
					?>
					<div class="clearFloat"></div>
					<div class="spacer"></div>
					<?php
				}
			}
		}
		else
		{
			functions::redirect('warning.php?eid=ER_00003');
		}
	}
	
	
	public function get_image_list($content_id)
	{
		$database			= new database();
		$gallery_array 	= array();
		$sql				= "SELECT * FROM content_option WHERE content_id='".$content_id."' ORDER BY added_date DESC";
		$result				= $database->query($sql);
		$image_list			= '';
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				/*
				$image_list .= '<li> <a class="thumb" name="leaf" href="'. URI_MEMBER . $data->image_name . '" title="' . $data->title . '"> <img src="'. URI_MEMBER . 'thumb_' . $data->image_name . '" alt="' . $data->alt . '" width="75" height="75" /></a> </li>';
				*/
				
				$image_list .= '<li> <a class="thumb" name="leaf" href="show_image.php?path='. DIR_CONTENT_OPTION . $data->image_name . '&width=310&height=250" title="' . $data->title . '"><img src="'. URI_MEMBER . 'thumb_' . $data->image_name . '" alt="' . $data->alt . '" width="70" height="50" /></a> </li>';
			}
		}
		$str = '<a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
						<ul class="thumbs noscript" id="gallery">
							' . $image_list . '
						</ul>
						<a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>';
		return $str;
	}
	
	public static function get_option22($content_id, $id)
	{
		
		$bg_array	= array('blue_bg.jpg', 'purple-bg.jpg', 'green_bg.jpg');
		$database	= new database();
		$sql		= "SELECT * FROM content_option WHERE content_id='".$content_id."' AND status = 'Y' ORDER BY order_id ASC";
		$result		= $database->query($sql);
		if ($result->num_rows > 0)
		{
			$i = 0;
			$j = 0;
			echo '
			<div class="welcome-welcome">.</div>';
			
			
			//-------------
			echo '<div id="menu' . $id . '" class="three-color">';
			while($data = $result->fetch_object())
			{
			    
				if($j==0 || $j%3==0) $div_str ='<div class="blue">';
				else if($j%2 ==0) $div_str ='<div class="green">';
				else 			$div_str ='<div class="purple">';
					
				if($content_id == 4)
				{
					if($data->content_option_id==23)
					{
						if(isset($_SESSION[MEMBER_ID]))
						{
							$url= 'news.php';
						}
						else
						{
						   	$url = 'join_community.php';
						}
						$target='';
					}
					else if($data->content_option_id==24)
					{
					 	//$url = URI_ROOT.'userfiles/SustainableEventsSummit_Sponsors.pdf';
						$url = URI_ROOT.'userfiles/SustainableEventsSummitStory.pdf';
						$target='_blank';
					}
					else if($data->content_option_id==25)
					{
						 //$url = URI_ROOT.'userfiles/SustainableEventsSummit_Exhibitors.pdf';
						 $url = URI_ROOT.'userfiles/SustainableEventsSummitStory.pdf';
						 $target='_blank';
					}
					else continue;
										
					echo '
						<a href="'. $url .'" target="'. $target.'">'.$div_str.'' . functions::deformat_string($data->title) .'</div></a>
						';
				}
			    else if($content_id == 5)
				{
				    if(isset($_SESSION[MEMBER_ID]))
					{
						$url= 'news.php';
					}
					else
					{
					   $url = 'join_community.php';
					}
					
					echo '
						<a href="'. $url .'" target="">'.$div_str.'' . functions::deformat_string($data->title) .'</div></a>
						';
				}
				else
				{
					continue;
				}
				if($i == 2)
				{
					$i = 0;
				}
				else
				{
					$i++;
				}
				$j++; 
				
			}
			echo '</div>';
			//----------------
			
			echo '<div id="menu' . $id . '" class="sdmenu">';
			$i=0;
			while($data = $result->fetch_object())
			{
				echo '<div class="collapsed" style=" background-image:url(images/' . $bg_array[$i] . '); background-repeat:repeat-x; margin-top:0px; height:20px;"> <span class="rail">' . functions::deformat_string($data->title) .'</span>
						<p><a href="#">' . functions::deformat_string(nl2br($data->description)) .'</a> </p>
					</div>';
				
				if($i == 2)
				{
					$i = 0;
				}
				else
				{
					$i++;
				}
			}
			echo '</div>';
			
		}
	}
	
	public static function get_option3334($content_id, $id)
	{
		
		$bg_array	= array('blue_bg.jpg', 'purple-bg.jpg', 'green_bg.jpg');
		$database	= new database();
		$sql		= "SELECT * FROM content_option WHERE content_id='".$content_id."' AND status = 'Y' ORDER BY order_id ASC";
		$result		= $database->query($sql);
		if ($result->num_rows > 0)
		{
			$i = 0;
			$j = 0;
			echo '
			<div class="welcome-welcome">.</div>';
			
			
			//-------------
			echo '<div id="menu' . $id . '" class="three-color">';
			while($data = $result->fetch_object())
			{
			    
				if($j==0 || $j%3==0) $div_str ='<div class="blue">';
				else if($j%2 ==0) $div_str ='<div class="green">';
				else 			$div_str ='<div class="purple">';
					
				if($content_id == 4)
				{
					if($data->content_option_id==23)
					{
						if(isset($_SESSION[MEMBER_ID]))
						{
							$url= 'news.php';
						}
						else
						{
						   	$url = 'join_community.php';
						}
						$target='';
					}
					else if($data->content_option_id==24)
					{
					 	//$url = URI_ROOT.'userfiles/SustainableEventsSummit_Sponsors.pdf';
						$url = URI_ROOT.'userfiles/SustainableEventsSummitStory.pdf';
						$target='_blank';
					}
					else if($data->content_option_id==25)
					{
						 //$url = URI_ROOT.'userfiles/SustainableEventsSummit_Exhibitors.pdf';
						 $url = URI_ROOT.'userfiles/SustainableEventsSummitStory.pdf';
						 $target='_blank';
					}
					else continue;
										
					echo '
						<a href="'. $url .'" target="'. $target.'">'.$div_str.'' . functions::deformat_string($data->title) .'</div></a>
						';
				}
			    else if($content_id == 5)
				{
				    if(isset($_SESSION[MEMBER_ID]))
					{
						$url= 'news.php';
					}
					else
					{
					   $url = 'join_community.php';
					}
					
					echo '
						<a href="'. $url .'" target="">'.$div_str.'' . functions::deformat_string($data->title) .'</div></a>
						';
				}
				else
				{
					continue;
				}
				if($i == 2)
				{
					$i = 0;
				}
				else
				{
					$i++;
				}
				$j++; 
				
			}
			echo '</div>';
			//----------------
			/*
			echo '<div id="menu' . $id . '" class="sdmenu">';
			$i=0;
			while($data = $result->fetch_object())
			{
				echo '<div class="collapsed" style=" background-image:url(images/' . $bg_array[$i] . '); background-repeat:repeat-x; margin-top:0px; height:20px;"> <span class="rail">' . functions::deformat_string($data->title) .'</span>
						<p><a href="#">' . functions::deformat_string(nl2br($data->description)) .'</a> </p>
					</div>';
				
				if($i == 2)
				{
					$i = 0;
				}
				else
				{
					$i++;
				}
			}
			echo '</div>';
			*/
		}
	}
	
	public static function get_option($content_id, $id)
	{
		
		$bg_array	= array('blue', 'purple', 'green');
		$database	= new database();
		$sql		= "SELECT * FROM content_option WHERE content_id='".$content_id."' AND status = 'Y' ORDER BY order_id ASC";
		$result		= $database->query($sql);
		if ($result->num_rows > 0)
		{
			$i = 0;
			$j = 0;
			echo '
			<div class="welcome-welcome">.</div>';
			echo '<div id="menu' . $id . '" class="sdmenu">';
			$i=0;
			while($data = $result->fetch_object())
			{
				if($content_id == 4)
				{
					if($data->content_option_id==23)
					{
						if(isset($_SESSION[MEMBER_ID]))
						{
							$url= 'news.php';
						}
						else
						{
						   	$url = 'join_community.php';
						}
						$target='';
					}
					else if($data->content_option_id==24)
					{
					 	//$url = URI_ROOT.'userfiles/SustainableEventsSummit_Sponsors.pdf';
						$url = URI_ROOT.'userfiles/SustainableEventsSummitStory.pdf';
						$target='_blank';
					}
					else if($data->content_option_id==25)
					{
						 //$url = URI_ROOT.'userfiles/SustainableEventsSummit_Exhibitors.pdf';
						 $url = URI_ROOT.'userfiles/SustainableEventsSummitStory.pdf';
						 $target='_blank';
					}
					else continue;
										
					echo '<div class="collapsed" style=" background-image:url(images/' . $bg_array[$i] . '_bg.jpg); background-repeat:repeat-x; margin-top:0px; height:20px;"><a href="'. $url .'" target="'. $target.'"><span class="rail">' . functions::deformat_string($data->title) .'</span></a></div>';
					
					/*echo '<div class="collapsed" style=" background-image:url(images/' . $bg_array[$i] . '_bg.jpg); background-repeat:repeat-x; margin-top:0px; height:20px;"><a style="cursor:pointer;" onclick="show_registration_closed();"><span class="rail">' . functions::deformat_string($data->title) .'</span></a></div>';*/
					
				}
			    else if($content_id == 5)
				{
				    if(isset($_SESSION[MEMBER_ID]))
					{
						$url= 'news.php';
					}
					else
					{
					   $url = 'join_community.php';
					}
					
					echo '<div class="collapsed" style=" background-image:url(images/' . $bg_array[$i] . '_bg.jpg); background-repeat:repeat-x; margin-top:0px; height:20px;"><a href="'. $url .'" target=""><span class="rail">' . functions::deformat_string($data->title) .'</span></a></div> ';
				}
				else
				{
					echo '<div class="collapsed" style=" background-image:url(images/' . $bg_array[$i] . '_bg.jpg); background-repeat:repeat-x; margin-top:0px; height:20px;"> <span class="rail">' . functions::deformat_string($data->title) .'</span>
						<p><a href="#">' . functions::deformat_string(nl2br($data->description)) .'</a> </p>
					</div>';
				}
				
				if($i == 2)
				{
					$i = 0;
				}
				else
				{
					$i++;
				}
			}
			echo '</div>';
			
		}
	}
		public static function update_status($content_option_status, $status = '')
		{		
			$database		= new database();
			$content_option			= new content_option($content_option_status);
			//$current_status = $content_option->status;
			if($status == '')
			{
				$status =  $content_option->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE content_option 
						SET  status = '". $status . "'
						WHERE content_option_id= '" . $content_option_status . "'";
						//echo $sql;
			$result 	= $database->query($sql);
			return $status;
		}
		
		public function get_content_option()
		{
			$database		= new database();	
				
			 $sql 			= "SELECT * FROM content_option where status ='Y' order by order_id LIMIT 0 , 6";
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
				{
					$array = array();
					while($data = $result->fetch_object())
					{
						$array['description']	= $data->description;
						$array['image_name']	= $data->image_name;
						$content_option []	= $array;
					}
				}
				return $content_option;
		
	
			
		}
}
	
?>