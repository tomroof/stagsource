<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 14-April-2011
	Purpose	: content_like class
*********************************************************************************************/
    class content_like
	{
		protected	$_properties		= array();
		public		$error				= '';
		public		$message			= '';
		public		$warning			= '';
		private		$no_content_like_option	= array();
		
		

        function __construct($content_like_id = 0)
		{
            $this->error	= '';
			$this->message	= '';
			$this->warning	= false;
			
			if($content_like_id > 0 || $content_like_id != '')
			{
				$this->initialize($content_like_id);
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
		private function initialize($content_like_id)
		{
			$database	= new database();
			
			
			if(is_numeric( $content_like_id ))
			{
				$sql	= "SELECT *	 FROM content_like WHERE content_like_id = '$content_like_id'";
			}
			else
			{
				$sql	= "SELECT *	 FROM content_like WHERE seo_url = '$content_like_id'";
			}
			//print $sql;
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
		}
		
		// Save the content_like details
		public function save()
		{
			$database	= new database();
			if(!$this->check_content_like_exist($this->name, $this->content_like_id) && !$this->check_seo_url_exist($this->seo_url, $this->content_like_id))
			{
				if ( isset($this->_properties['content_like_id']) && $this->_properties['content_like_id'] > 0) 
				{
					$sql	= "UPDATE content_like SET 
								name = '". $database->real_escape_string($this->name)  ."',
								category_id = '". $database->real_escape_string($this->category_id)  ."',
								seo_url = '". $database->real_escape_string($this->seo_url)  ."',
								title = '". $database->real_escape_string($this->title)  ."',
								meta_description = '". $database->real_escape_string($this->meta_description)  ."',
								meta_keywords = '". $database->real_escape_string($this->meta_keywords)  ."',
								content_like = '". $database->real_escape_string($this->content_like)  ."',
								author = '". $database->real_escape_string($this->author)  ."',
								modified_date = NOW() 
								WHERE content_like_id = '$this->content_like_id'";
				}
				else 
				{
					$sql		= "INSERT INTO content_like 
								(name,category_id, seo_url, title, meta_description, meta_keywords, content_like, author, added_date, modified_date, order_id) 
								VALUES ('" . $database->real_escape_string($this->name) . "',
										'" . $database->real_escape_string($this->category_id) . "',
										'" . $database->real_escape_string($this->seo_url) . "',
										'" . $database->real_escape_string($this->title) . "',
										'" . $database->real_escape_string($this->meta_description) . "',
										'" . $database->real_escape_string($this->meta_keywords) . "',
										'" . $database->real_escape_string($this->content_like) . "',
										'" . $database->real_escape_string($this->author) . "',
										NOW(),
										NOW(),
										'" . $database->real_escape_string($this->order_id) . "'
										)";
				}
				//print $sql;
				$result			= $database->query($sql);
				
				if($database->affected_rows == 1)
				{
					if($this->content_like_id == 0)
					{
						$this->content_like_id	= $database->insert_id;
					}
				}
				$this->initialize($this->content_like_id);
				$this->message = cnst11;
				return true;
			}
			else
			{
				return false;	
			}
		}
		
		//The function check the content_like name exist or not
		public function check_content_like_exist($name='', $content_like_id=0)
		{
			$output		= false;
			$database	= new database();
			if($name == '')
			{
				$this->message	= "Page name should not be empty!";
				$this->warning	= true;
			}
			else
			{
				if($content_like_id > 0)
				{
					$sql	= "SELECT *	 FROM content_like WHERE name = '" . $database->real_escape_string($name) . "' AND content_like_id != '" . $content_like_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM content_like WHERE name = '" . $database->real_escape_string($name) . "'";
				}
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					$this->message	= "Page name is already exist!";
					$this->warning	= true;
					$output 		= true;
				}
				else
				{
					$output			= false;
				}
			}
			return $output;	
		}
		
		//The function check the seo url exist or not
		public function check_seo_url_exist($seo_url='', $content_like_id=0)
		{
			$output		= false;
			$database	= new database();
			if($seo_url == '')
			{
				$this->message	= "SEO URL should not be empty!";
				$this->warning	= true;
			}
			else
			{
				if($content_like_id > 0)
				{
					$sql	= "SELECT *	 FROM content_like WHERE seo_url = '" . $database->real_escape_string($seo_url) . "' AND content_like_id != '" . $content_like_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM content_like WHERE seo_url = '" . $database->real_escape_string($seo_url) . "'";
				}
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					$this->message	= "SEO URL is already exist!";
					$this->warning	= true;
					$output 		= true;
				}
				else
				{
					$output			= false;
				}
			}
			return $output;	
		}
		
		// Remove the current object details.
		public function remove()
		{
			$database	= new database();
			if ( isset($this->_properties['content_like_id']) && $this->_properties['content_like_id'] > 0) 
			{
				$sql = "DELETE FROM content_like WHERE content_like_id = '" . $this->content_like_id . "'";
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
		public function remove_selected($content_like_ids)
		{
			$database	= new database();
			if(count($content_like_ids)>0)
			{		
				foreach($content_like_ids as $content_like_id)
				{
					$content_like		= new content_like($content_like_id);
					$image_seo_url = $content_like->image_name;
					if(file_exists(DIR_NEWS . $image_name))
					{
						unlink(DIR_NEWS . $image_name);
					}
					if(file_exists(DIR_NEWS . 'thumb_' . $image_name))
					{
						unlink(DIR_NEWS . 'thumb_' . $image_name);
					}
					
					$sql = "DELETE FROM content_like WHERE content_like_id = '" . $content_like_id . "'";
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
		
		public function get_my_content_like()
		{
			$database	= new database();
			$title	= $_SESSION[MEMBER_ID];
			$sql		= "SELECT * FROM content_like WHERE title = $title ORDER BY content_like_date DESC";
			$result		= $database->query($sql);
			$idate		= 0;
			if ($result->num_rows > 0)
			{	
				while($data=$result->fetch_object())
				{
					$i++;
					$content_like_serial_value++;
					$row_num++;
			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	
					
					$idate			= explode('-', $data->content_like_date);
				  	$content_like_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];
					echo "<tr>
							<td align='center'>$i</td>
							<td>$content_like_date</td>
							<td>$data->description</td>
							<td><a href='$data->content_like_url' target='_blank'><img src='images/view-content_like.png' border='0' title='View'></a></td>
						</tr>";
				}
			}
			else
			{
				echo "<tr><td colspan='4' align='center'>Sorry.. No records found !!</td></tr>";
			}
		}
		
		public function display_list()
		{
			$database				= new database();
			$validation				= new validation(); 
			$param_array			= array();
			$sql					= "SELECT * FROM content_like ";
			$drag_drop				= '';
			
			//$search_cond_array[]	= " title = '$this->title' ";
			//$param_array[]			= "title=$this->title";
			if(isset($_REQUEST['search_word']) || $_REQUEST['category_id'] > 0 ) 
			{
				$search_word	= functions::clean_string($_REQUEST['search_word']);
				if(!empty($search_word))
				{
					$validation->check_blank($search_word, 'Search word', 'search_word');					
					if (!$validation->checkErrors())
					{
						$param_array[]			= "search=true";
						$param_array[]			= "search_word=" . htmlentities($search_word);
						$search_cond_array[]	= " name like '%" . $database->real_escape_string($search_word) . "%' OR title like '%" . $database->real_escape_string($search_word) . "%' OR seo_url like '%" . $database->real_escape_string($search_word) . "%'";	
					}
				}
				
				if($_REQUEST['category_id'] > 0)
				{
						$param_array[]="category_id =".$_REQUEST['category_id'];			
						$search_cond_array[]="category_id  = '".$database->real_escape_string($_REQUEST['category_id'])."'";		
				}
				// Drag and dorp ordering is not available in search
				$drag_drop 						= ' nodrag nodrop ';
			}
			
			if(count($search_cond_array)>0) 
			{ 
				$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
				$sql				.= $search_condition;
			}
						
			$sql 			= $sql . " ORDER BY created_date DESC, content_like_id DESC";
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
					<td colspan="9"  class="noBorder">
						<input type="hidden" id="show"  name="show" value="0" />
               			<input type="hidden" id="content_like_id" name="content_like_id" value="0" />
						<input type="hidden" id="show_content_like_id" name="show_content_like_id" value="0" />
						<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
						<input type="hidden" id="page" name="page" value="' . $page . '" />
					</td>
                </tr>';
				
				while($data=$result->fetch_object())
				{
					$i++;
					$content_like_serial_value++;
					$row_num++;
			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	
					$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
					$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
					
					$show_menu			= $data->show_menu == 'Y' ? 'Active' : 'Inactive';
					$show_menu_image	= $data->show_menu == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
					$category			= new category($data->category_id);
					
					echo '
						<tr id="' . $data->content_like_id . '" class="' . $class_name . $drag_drop . '" >
							<td class="alignCenter pageNumberCol">' . $row_num . '</td>
							<td class="noBorder handCursor" onclick="javascript: open_content_like_details(\''.$data->content_like_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$content_like_serial_value.'\');"  title="Click here to view details">' . functions::deformat_string($data->name) . '</td>
							<td class="noBorder " >' . functions::deformat_string($category->name) . '</td>';
							//<td class="widthAuto"><a href="#" title="Click here to view details" onClick="javascript:open_content_like_details(\''.$data->content_like_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$content_like_serial_value.'\');return false;">' . functions::deformat_string($data->name) . '</a></td>
							
						echo '<td class="widthAuto">'. $data->seo_url .'<!--<a href="'. URI_ROOT .  $data->seo_url .'" target="_blank"><img  src="images/external_link.png"></a>--></td>
							<!--<td class="alignCenter">'.  functions::get_format_date($data->modified_date, "d-m-Y") .'</td>-->
							<td class="alignCenter">';
							
								if(!in_array($data->content_like_id, $this->no_content_like_option) && $data->content_like_id > 4)
								{
									/*echo '<a href="manage_content_like_option.php?content_like_id=' . $data->content_like_id . '"><img src="images/icon-content_like_option.png" alt="Option" title="Option" width="15" height="16" /></a>';*/
								}
								echo '
							</td>
							<td class="alignCenter">';
							if($data->status_edit == 'Y')
							{
								echo '<a title="Click here to update status" class="handCursor" onclick="javascript: change_content_like_status(\'' . $data->content_like_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a>';
							}
							else if($data->content_like_id < 5)
							{
								echo '<img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '">';	
							}
							echo '</td>
							<td class="alignCenter">';
							if($data->show_menu_edit == 'Y')
							{
								echo '<a title="Click here to update menu option" class="handCursor" onclick="javascript: change_menu_option(\'' . $data->content_like_id . '\', \'' . $i . '\');" ><img id="menu_option_image_' . $i . '" src="images/' . $show_menu_image . '" alt ="' . $show_menu  . '" title ="' . $show_menu  . '"></a>';
							}
							/*else
							{
								echo '<img id="menu_option_image_' . $i . '" src="images/' . $show_menu_image . '" alt ="' . $show_menu  . '" title ="' . $show_menu  . '">';	
							}*/
							echo '</td>
							<td class="alignCenter">
								<!--<a href="register_content_like.php?content_like_id=' . $data->content_like_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>-->
							</td>
							<td class="alignCenter deleteCol">';
							if($data->status_edit == 'Y')
							{
								echo '
								<!--<label><input type="checkbox" name="checkbox[' . $data->content_like_id . ']" id="checkbox" /></label>-->';
							}
							echo '</td>
						</tr>
						<tr id="details'.$i.'" class="expandRow" >
								<td id="details_div_'.$i.'" colspan="10" height="1" ></td>
							</tr>
						';
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
						$urlQuery = 'manage_content_like.php?page='.$currentPage;
					}
					else
					{
						$urlQuery = 'manage_content_like.php?'.$this->pager_param1.'&page='.$currentPage;	
					}
					functions::redirect($urlQuery);
				}
				else
				{
					echo "<tr><td colspan='7' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
				}
			}
		}
		
		// The function is used to change the status.
		public static function update_status($content_like_id, $status = '')
		{		
			$database		= new database();
			$content_like			= new content_like($content_like_id);
			//$current_status = $content_like->status;
			if($status == '')
			{
				$status =  $content_like->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE content_like 
						SET status = '". $status . "'
						WHERE content_like_id = '" . $content_like_id . "'";
			$result 	= $database->query($sql);
			return $status;
		}
		
		// The function is used to change the status.
		public static function update_show_menu($content_like_id, $show_menu = '')
		{		
			$database		= new database();
			$content_like		= new content_like($content_like_id);
			//$current_show_menu = $content_like->show_menu;
			if($show_menu == '')
			{
				$show_menu =  $content_like->show_menu == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE content_like 
						SET show_menu = '". $show_menu . "'
						WHERE content_like_id = '" . $content_like_id . "'";
			$result 	= $database->query($sql);
			return $show_menu;
		}
		
		public static function get_breadcrumbs($title, $client_side=false)
		{
			if($client_side)
			{
				$bread_crumb[]			= "<a href='tutorial.php'>Gallery</a>";
			}
			else
			{		
				$page_id				= page::get_page_id('manage_tutorial.php');	// Get the page id
				$page					= new page($page_id);
				$bread_crumb[]			= "<a href='". functions::deformat_string($page->name) ."'>" . functions::deformat_string($page->description) . "</a>";
			}
			
			$tutorial_category 		= new tutorial_category($title);
			$bread_crumb[]			= functions::deformat_string($tutorial_category->name);
			
			if(count($bread_crumb)>0)
			{
				$bread_crumbs=join(" >> ",$bread_crumb);
			}
			return $bread_crumbs;
		}
		
		// Functoion update the list order
		public function update_list_order($list_array, $page_number)
	{
		$database		= new database();
		$limit			= PAGE_LIMIT;
		$id_array		= array();
		
		//print_r($list_array);
		
		foreach ($list_array as $id)
		{
			if($id == '')
			{
				continue;
			}
			$id_array[] = $id;
		}
		
		//print_r($id_array);
		if($page_number > 1)
		{
			$order_id = (($page_number - 1) * PAGE_LIMIT) + 1 ; //1
		}
		else
		{
			$order_id = count($id_array);
		}
		
		//echo count($id_array);
		for($i = 0; $i < count($id_array); $i++ )
		{
			$sql = "UPDATE content_like SET order_id = '" . $order_id . "' WHERE content_like_id = '" . $id_array[$i] . "'";
			echo $sql;
			$database->query($sql);
			$order_id++;
		}
	}
	
		
		public static function get_latest_list($count = 0)
		{
			$database			= new database();
			$portfolio_array 	= array();
			if($count > 0)
			{
				$sql	= "SELECT * FROM content_like ORDER BY content_like_date DESC Limit 0, $count";
			}
			else
			{
				$sql	= "SELECT * FROM content_like ORDER BY content_like_date DESC";
			}
			//print $sql;
			$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					?>
					<div class="content_like">
					<?php echo functions::get_sub_string(functions::deformat_string($data->description),180); ?> <a href="content_like.php#content_like<?php echo $data->content_like_id; ?>">Read more</a>
					</div>
					<?php
				}
			}
		}
		
		public static function get_menu($static_menu = '')
		{
			$database			= new database();
			$portfolio_array 	= array();
			$sql				= "SELECT * FROM content_like WHERE  show_menu = 'Y' AND status = 'Y' ORDER BY name DESC";
			//print $sql;
			$result				= $database->query($sql);
			echo '<ul><li><a href="' . URI_ROOT . '">Home</a></li>';
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					?>
					<li><a href="<?php echo functions::deformat_string($data->seo_url); ?>"><?php echo functions::deformat_string($data->name); ?></a></li>
					<?php
				}
			}
			echo $static_menu . '</ul>';
		}
		
		public static function get_random_content_like()
		{
			$database	= new database();
			$sql		= "SELECT * FROM content_like ORDER BY Rand() Limit 0, 1";
			//print $sql;
			$result		= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data = $result->fetch_object();
				echo functions::deformat_string($data->description);
			}
		}
		
		public function get_content_like_list()
		{
			$database			= new database();
			$param_array		= array();
			$search_condition	= '';
			$sql 				= "SELECT * FROM content_like";
					
			$sql				.= $search_condition;
			$sql 				= $sql . " ORDER BY content_like_date DESC";
			$result				= $database->query($sql);
			
			$this->num_rows = $result->num_rows;
			//functions::paginate($this->num_rows);
			functions::paginateclient($this->num_rows, 0, 0, 'CLIENT');
			$start			= functions::$startfrom;
			$limit			= functions::$limits;
			$sql 			= $sql . " limit $start, $limit";
			//print $sql;
			$result			= $database->query($sql);
			
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			$content_like_array		= array();
			if ($result->num_rows > 0)
			{				
				$i 			= 0;
				$row_num	= functions::$startfrom;
				$page		= functions::$startfrom > 0 ? (functions::$startfrom / FRONT_PAGE_LIMIT) + 1 : 1;			
				while($data=$result->fetch_object())
				{
					$i++;
					
					if($i != 1)
					{
						echo '<div id="content_like_content_like_crossline"></div>';	
					}
					
					?>
					<a name="content_like<?php echo $data->content_like_id; ?>"></a>
					<div id="content_like_black_heading">
						<div id="content_like_white_area">
							<div id="content_like_image"><img src="<?php echo URI_NEWS . 'thumb_' . $data->image_name; ?>" /></div>
							<div id="content_like_date"><?php echo functions::get_format_date($data->content_like_date, "dS M");	?></div>
						</div>
						<div id="content_like_black_area">
							<div id="affliates_content_like">
								<h1><?php echo functions::deformat_string($data->title); ?></h1>
								<?php echo nl2br(functions::deformat_string($data->description)); ?>	
							</div>
						</div>
					</div>
					<?php
				}
				$param=join("&amp;",$param_array); 
				$this->pager_param=$param;
			}
			else
			{
				echo "<div align='center' class='warningMesg'>Sorry.. No records found !!</div>";
			}
		}
			
		
		public function get_article_big_array()
		{
			$big_array		= array();
			$database		= new database();
			$sql 			= "SELECT * FROM content_like WHERE content_like_type='article' AND image_size='1' AND status='Y' ORDER BY content_like_id DESC";
			$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data=$result->fetch_object())
				{
					$big_array[] 	= $data->content_like_id;	
					$image_name 	= $data->content_like_thumbnail;
					if(!file_exists(DIR_content_like.'thumb_'.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_content_like.$image_name);
						$imageLib = new imageLib(DIR_content_like.$image_name);
						//$imageLib->resizeImage(BOOK_MIN_WIDTH, BOOK_MIN_HEIGHT,3);
						/*if($size_1[0] > $size_1[1])
						{
							$imageLib->resizeImage(BOOK_MIN_WIDTH, BOOK_MIN_HEIGHT, 2);
						}
						else if($size_1[0] < $size_1[1])
						{
							$imageLib->resizeImage(BOOK_MIN_WIDTH, BOOK_MIN_HEIGHT, 1);
						}
						else
						{
							$imageLib->resizeImage(BOOK_MIN_WIDTH, BOOK_MIN_HEIGHT, 3);	
						}*/
						$imageLib->resizeImage(content_like_BIG_THUMB_WIDTH, content_like_BIG_THUMB_HEIGHT, 0);	
						$imageLib->saveImage(DIR_content_like.'thumb1_'.$image_name, 90);
						unset($imageLib);
					}
				}
			}
			
			return $big_array;
			
		}
		
		
		public static function get_like_total($content_id = 0, $like_type = '')
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_like WHERE model_name='Contents' AND content_id=$content_id AND like_type='$like_type'";
			$result				= $database->query($sql);
			return $result->num_rows;			
		}
		
		public static function get_favorite_total($member_id)
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_like WHERE like_type='favorite' AND member_id=$member_id ";
			$result				= $database->query($sql);
			$cid	= '';
			$i =0;
			while($data 	= $result->fetch_object())
			{
				if($data->model_name =='Contents')
				{
					$cid 	.=($i == 0) ? 'content_id='.$data->content_id : ' OR content_id='.$data->content_id; 
				}
				else
				{
					$content_comment = new content_comment($data->content_id);
					$cid 	.= ($i == 0) ? 'content_id='.$content_comment->content_id : ' OR content_id='.$content_comment->content_id;	
				}
				
				$i++;
			}
			
			if($cid != '')
			{
				$sql 			= "SELECT DISTINCT content_id FROM content WHERE $cid";;
				$result				= $database->query($sql);
				return $result->num_rows;			
			}
			else
			{
				return 0;	
			}
		}
		
		
		public static function get_comment_like_total($content_id = 0, $like_type = '')
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_like WHERE model_name='ContentComments' AND content_id=$content_id AND like_type='$like_type'";
			$result				= $database->query($sql);
			return $result->num_rows;			
		}
		
		public static function get_fan_total($content_id = 0)
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_like WHERE model_name='Contents' AND content_id=$content_id AND like_type='fans'";
			$result				= $database->query($sql);
			return $result->num_rows;			
		}
		
		
		public static function update_page_like($member_id = 0, $contents = '')
		{
			$content_id		= explode('_', $contents);
			$database		= new database();
			$sql 			= "SELECT * FROM content_like WHERE model_name='Contents' AND member_id=$member_id AND content_id=$content_id[1] AND like_type='$content_id[0]'";
			$result				= $database->query($sql);
			if($result->num_rows > 0)
			{
				$sql 			= "DELETE FROM content_like WHERE model_name='Contents' AND member_id=$member_id AND content_id=$content_id[1] AND like_type='$content_id[0]'";
				$result			= $database->query($sql);	
			}
			else
			{
				$sql 		= "INSERT INTO content_like 
								(model_name, content_id, member_id, like_type, created_at) 
								VALUES ('Contents',
								'" . $database->real_escape_string($content_id[1]) . "',
								'" . $database->real_escape_string($member_id) . "',
								'" . $database->real_escape_string($content_id[0]) . "',
								NOW())";
				$result			= $database->query($sql);
			}
		}
		
		public static function update_comment_like($member_id = 0, $contents = '')
		{
			$content_id		= explode('_', $contents);
			$database		= new database();
			$sql 			= "SELECT * FROM content_like WHERE model_name='ContentComments' AND member_id=$member_id AND content_id=$content_id[1] AND like_type='$content_id[0]'";
			$result				= $database->query($sql);
			if($result->num_rows > 0)
			{
				$sql 			= "DELETE FROM content_like WHERE model_name='ContentComments' AND member_id=$member_id AND content_id=$content_id[1] AND like_type='$content_id[0]'";
				$result			= $database->query($sql);	
			}
			else
			{
				$sql 		= "INSERT INTO content_like 
								(model_name, content_id, member_id, like_type, created_at) 
								VALUES ('ContentComments',
								'" . $database->real_escape_string($content_id[1]) . "',
								'" . $database->real_escape_string($member_id) . "',
								'" . $database->real_escape_string($content_id[0]) . "',
								NOW())";
				$result			= $database->query($sql);
			}
		}
		
		
		public static function update_fan($member_id = 0, $content_id = 0)
		{
			
			$database		= new database();
			$sql 			= "SELECT * FROM content_like WHERE model_name='Contents' AND member_id=$member_id AND content_id=$content_id AND like_type='fans'";
			$result				= $database->query($sql);
			$result->num_rows;
			if($result->num_rows > 0)
			{
				$sql 			= "DELETE FROM content_like WHERE model_name='Contents' AND member_id=$member_id AND content_id=$content_id AND like_type='fans'";
				$result			= $database->query($sql);	
			}
			else
			{
				$sql 		= "INSERT INTO content_like 
								(model_name, content_id, member_id, like_type, created_at) 
								VALUES ('Contents',
								'" . $database->real_escape_string($content_id) . "',
								'" . $database->real_escape_string($member_id) . "',
								'fans',
								NOW())";
				$result			= $database->query($sql);
			}
		}
		
		public static function get_profile_favorites($member_id)
		{
			$output 		= array();
			$database		= new database();
			$sql 			= "SELECT * FROM content_like WHERE member_id=$member_id AND like_type='favorite'";
			$result				= $database->query($sql);
			$result->num_rows;
			if($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					$output[] = $data;
				}
			}	
			
			return $output;
		}
		
	}
?>