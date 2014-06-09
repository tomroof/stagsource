<?php
/*********************************************************************************************
Author 	: V V VIJESH
Date	: 14-April-2011
Purpose	: Case Studies class
*********************************************************************************************/
class page_content_category
{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';
	
	function __construct($page_content_category_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		
		if($page_content_category_id > 0)
		{
			$this->initialize($page_content_category_id);
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
	private function initialize($page_content_category_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM page_content_category WHERE page_content_category_id = '$page_content_category_id'";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$this->_properties	= $result->fetch_assoc();
		}
	}
	// Save the Case Studies details
	public function save()
	{
		$database	= new database();
		if(!$this->check_page_content_category_exist($this->page_content_category_name, $this->_properties['page_content_category_id']))
		{
			if ( isset($this->_properties['page_content_category_id']) && $this->_properties['page_content_category_id'] > 0) 
			{
				$sql	= "UPDATE page_content_category SET page_content_category_name = '". $database->real_escape_string($this->page_content_category_name)  ."' WHERE page_content_category_id = '$this->page_content_category_id'";
			}
			else 
			{
				$sql		= "INSERT INTO page_content_category 
							(page_content_category_name) 
							VALUES ('" . $database->real_escape_string($this->page_content_category_name) . "')";
			}
			//print $sql; exit;
			$result			= $database->query($sql);
			
			if($database->affected_rows == 1)
			{
				if($this->page_content_category_id == 0)
				{
					$this->page_content_category_id	= $database->insert_id;
				}
				$this->initialize($this->page_content_category_id);
			}
		
			$this->message = cnst11;
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	//The function check the page_content_category name eixst or not
	public function check_page_content_category_exist($page_content_category_name='', $page_content_category_id=0)
	{
		$output		= false;
		$database	= new database();
		if($page_content_category_name == '')
		{
			$this->message	= "Categories name should not be empty";
			$this->warning	= true;
		}
		else
		{
			if($page_content_category_id > 0)
			{
				$sql	= "SELECT *	 FROM page_content_category WHERE page_content_category_name = '" . $database->real_escape_string($page_content_category_name) . "' AND page_content_category_id != '" . $page_content_category_id . "'";
			}
			else
			{
				$sql	= "SELECT *	 FROM page_content_category WHERE page_content_category_name = '" . $database->real_escape_string($page_content_category_name) . "'";
			}
			//print $sql;exit;
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$this->message	= "Categories name is already exist";
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
		if ( isset($this->_properties['page_content_category_id']) && $this->_properties['page_content_category_id'] > 0) 
		{
			$sql = "DELETE FROM page_content_category WHERE page_content_category_id = '" . $this->page_content_category_id . "'";
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
	public function remove_selected($page_content_category_ids)
	{
		$database	= new database();
		if(count($page_content_category_ids)>0)
		{		
			foreach($page_content_category_ids as $page_content_category_id)
			{
				
					
				$page_content 									= new page_content();
				$page_content_category_id_			= $page_content->get_page_content_category($page_content_category_id);
				
				/*
						
				$club_directory_member 	= new club_directory_member();
				$club_directory_member->remove($page_content_category_id);
				
				$club_option 					= new club_option();
				$club_option->remove($page_content_category_id);
				
				$testimonial 					= new testimonial();
				$testimonial->remove($page_content_category_id);
				
				$supporters 					= new supporters();
				$supporters->remove($page_content_category_id);
				
				$member 						= new member();
				$member->remove($page_content_category_id);
				
				$banner 						= new banner();
				$banner->remove($page_content_category_id);
				
				$event 						= new event();
				$event->remove($page_content_category_id);*/	
				if(!$page_content_category_id_)
					{	
					$sql = "DELETE FROM page_content_category WHERE page_content_category_id = '" . $page_content_category_id . "'";
					try
					{
						if($result 	= $database->query($sql)) 
						{
							if ($database->affected_rows > 0)
							{
								$this->message	= cnst12;	// Data successfully removed!
								$this->warning	= false;
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
				else
				{
					$this->message	= "Cannot delete the selected page content category";
					$this->warning	= true;
				}
			}		  		   
		}
	}
	
	public static function get_page_content_category_options()
	{
		$database			= new database();
		$page_content_category_options 	= array();
		$sql				= "SELECT * FROM page_content_category ORDER BY page_content_category_name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$page_content_category_array = array();
			while($data = $result->fetch_object())
			{
				$page_content_category_options[$data->page_content_category_id]	= $data->name;
			}
		}
		return $page_content_category_options;
	}
	
	public static function get_distinct_page_content_category_options($page_content_category_id)
	{
		$database			= new database();
		$page_content_category_options 	= array();
		$sql				= "SELECT DISTINCT page_content_category.*
														FROM page_content_category LEFT JOIN club ON page_content_category.page_content_category_id = club.page_content_category_id
														WHERE (club.club_id IS NULL
														OR page_content_category.page_content_category_id NOT IN (club.page_content_category_id) 
														OR page_content_category.page_content_category_id IN ('$page_content_category_id'))
														AND page_content_category.status='Y'   
														ORDER BY page_content_category.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$page_content_category_array = array();
			while($data = $result->fetch_object())
			{
				$page_content_category_options[$data->page_content_category_id]	= $data->name;
			}
		}
		return $page_content_category_options;
	}
	
	public static function get_distinct_page_content_category_member_options($member_id)
	{
		$database			= new database();
		$page_content_category_options 	= array();
		$sql				= "SELECT DISTINCT page_content_category.*

														FROM page_content_category

														LEFT JOIN member ON page_content_category.name = member.page_content_category

														WHERE (member.member_id IS NULL

														OR page_content_category.name NOT IN (member.page_content_category) 

														OR page_content_category.name IN ('$member_id'))

														AND page_content_category.status='Y'   

														ORDER BY page_content_category.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$page_content_category_array = array();
			while($data = $result->fetch_object())
			{
				$page_content_category_options[$data->page_content_category_id]	= $data->name;
			}
		}
		return $page_content_category_options;
	}
	
	public static function get_page_content_category_list()
	{
		$database			= new database();
		$page_content_category_options 	= array();
		$sql				= "SELECT DISTINCT bc.page_content_category_id, bc.name FROM page_content_category as bc LEFT JOIN image as b on b.page_content_category_id = b.page_content_category_id ORDER BY bc.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$page_content_category_array = array();
			while($data = $result->fetch_object())
			{
				$page_content_category_array['page_content_category_id'] = $data->page_content_category_id;
				$page_content_category_array['name']	= $data->name;
				$page_content_category_options[]	= $page_content_category_array;
			}
		}
		return $page_content_category_options;
	}
	
	public static function get_listing_id()
	{
		$database			= new database();
		$listing_id_array 	= array();
		$sql						= "SELECT listing_id FROM page_content_category  ORDER BY listing_id ASC";
		$result					= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$listing_id_array[]	= $data->listing_id;
			}
		}
		return $listing_id_array;
	}
	
	public static function get_next_id($page_content_category_id)
	{
		$database				= new database();
		$next_page_content_category_id	= 0;
		 $sql					= "SELECT page_content_category_id FROM page_content_category WHERE page_content_category_id < '$page_content_category_id' ORDER BY page_content_category_date DESC LIMIT 0, 1";
		//echo $sql;
		$result					= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$data 					= $result->fetch_object();
			$next_page_content_category_id	= $data->page_content_category_id;
		}
		return $next_page_content_category_id;
	}
	
	public function get_page_content_category_of_month()
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM page_content_category WHERE page_content_category_of_month = 'Y' LIMIT 0, 1";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$this->_properties	= $result->fetch_assoc();
		}
	}
	
	public function display_list()
	{
		$database				= new database();
		$validation				= new validation(); 
		$param_array			= array();
		$sql 					= "SELECT * FROM page_content_category";
		$drag_drop 				= '';
		$search_condition		= '';
				
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
					$search_cond_array[]	= " page_content_category_name like '%" . $database->real_escape_string($search_word) . "%' ";	
				}
			}
			// Drag and dorp ordering is not available in search
			$drag_drop 						= ' nodrag nodrop ';
		}
		
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
				
		$sql			.= $search_condition;
		$sql 			= $sql . " ORDER BY page_content_category_id DESC";
		
		//echo $sql;
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
				<td colspan="7"  class="noBorder">
					<input type="hidden" id="show"  name="show" value="0" />
					<input type="hidden" id="page_content_category_id" name="page_content_category_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					<input type="hidden" id="page" name="page" value="' . $page . '" />
				</td>
			</tr>';
			
			while($data=$result->fetch_object())
			{
				$i++;
				$row_num++;
				$class_name		= (($row_type%2) == 0) ? "even" : "odd";
				$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
				
				$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
				$page_content_category_of_month	= $data->page_content_category_of_month == 'Y' ? '<img src="images/icon-active.png">' : '';
				
				echo '
					<tr id="' . $data->page_content_category_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td  class="widthAuto">' . functions::deformat_string($data->page_content_category_name) . '</td>
						<!--<td class="alignCenter joiningDateCol"><a title="Click here to update status" class="handCursor" onclick="javascript: change_page_content_category_status(\'' . $data->page_content_category_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a></td>-->
						<td class="alignCenter">
							<a href="register_page_content_category.php?page_content_category_id=' . $data->page_content_category_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>
						<td class="alignCenter deleteCol">
							<label><input type="checkbox" name="checkbox[' . $data->page_content_category_id . ']" id="checkbox" /></label>
						</td>
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
					$urlQuery = 'manage_page_content_category.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_page_content_category.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='7' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
	
	public static function get_breadcrumbs($page_content_category_id, $client_side=false)
	{
		$page_content_category 		= new page_content_category($page_content_category_id);			
		if($client_side)
		{
			$bread_crumb[]			= "<a href='page_content_category.php'>Gallery</a>";
		}
		else
		{
			$bread_crumb[]			= "<a href='manage_page_content_category.php'>Gallery</a>";
			
		}
					
		$bread_crumb[]			= functions::deformat_string($page_content_category->name);
		
		if(count($bread_crumb)>0)
		{
			$bread_crumbs=join(" >> ",$bread_crumb);
		}
		return $bread_crumbs;
	}
	
	public function get_latest_page_content_category_list($page_content_category_page_content_category_id = 0, $max_limit)
	{
		$database			= new database();
		$page_content_category_array 	= array();
		$sql			= "SELECT * FROM page_content_category WHERE page_content_category_page_content_category_id='".$page_content_category_page_content_category_id."' ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$page_content_category_gallery_sql				= "SELECT * FROM page_content_category_gallery WHERE page_content_category_id='".$data->page_content_category_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$page_content_category_gallery_result				= $database->query($page_content_category_gallery_sql);				
				if ($page_content_category_gallery_result->num_rows > 0)
				{
					$page_content_category_gallery_data = $page_content_category_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_CATEGORY . 'thumb_' . $page_content_category_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_CATEGORY, CATEGORY_THUMB_WIDTH, CATEGORY_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_CATEGORY . 'thumb_' . $page_content_category_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
				<div class="sidebar">
					<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
						<h2><a href="page_content_category.php?cid=<?php echo $page_content_category_page_content_category_id; ?>&pid=<?php echo $data->page_content_category_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
						<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="page_content_category.php?cid=<?php echo $page_content_category_page_content_category_id; ?>&pid=<?php echo $data->page_content_category_id; ?>">Read More</a></p>
					</div>
				</div>
				<?php
			}
		}
	}
	
	/*
	public static function get_page_content_category_list22()
	{
		$database			= new database();
		$sql				= "SELECT DISTINCT ic.* FROM page_content_category as ic INNER JOIN page_content_category_gallery as ig ON ic.page_content_category_id = ig.page_content_category_id ORDER BY ic.page_content_category_id DESC";
		$result				= $database->query($sql);
		if ($result->num_rows > 0)
		{
			$i				= 0;
			while($data = $result->fetch_object())
			{
				$i++;
				?>
				<div id="gallery_bg">
					<div id="gallery_image_bg">
						<p>
						<?php
						$name	= explode(' ', functions::deformat_string($data->name)); 
						$counter		= count($name);
						
						$page_content_category1		= '';
						$page_content_category2		= '';
						
						for($j = 0; $j <= $counter; $j++)
						{
							if($j < ceil($counter/2))
							{
								$page_content_category1	.= $name[$j] . ' ';
							}
							else
							{
								$page_content_category2	.= $name[$j] . ' ';
							}
						}
						echo '<h1>' . $page_content_category1 . ' <span>' . $page_content_category2 . '</span></h1>';
						?>
						<br />
						
						<?php
						$image_sql		= "SELECT * FROM page_content_category_gallery WHERE page_content_category_id='".$data->page_content_category_id."' ORDER BY added_date DESC";
						$image_result	= $database->query($image_sql);				
						if ($image_result->num_rows > 0)
						{
							while($image_data = $image_result->fetch_object())
							{
								$thumb_image	= '';
								
								if(!file_exists(DIR_IMAGE_GALLERY . 'thumb_' . $image_data->image_name))
								{
									$functions	= new functions();
									$functions->generate_thumb_image($data->image_name, DIR_IMAGE_GALLERY, IMAGE_GALLERY_THUMB_WIDTH,IMAGE_GALLERY_THUMB_HEIGHT);
								}
								
								$title 	= functions::format_text_field($image_data->title) . ($image_data->description != '' ? ': ' . functions::format_text_field($image_data->description) : '');
								?>
								<a rel="example_group<?php echo $i; ?>" href="<?php echo URI_IMAGE_GALLERY . $image_data->image_name; ?>" title="<?php echo $title; ?>"><img alt="<?php echo functions::format_text_field($image_data->alt); ?>" src="<?php echo URI_IMAGE_GALLERY . 'thumb_' . $image_data->image_name; ?>" border="0" width="<?php echo IMAGE_GALLERY_THUMB_WIDTH; ?>" height="<?php echo IMAGE_GALLERY_THUMB_HEIGHT; ?>" /></a>
								<?php
							}
						}
						else
						{
							echo "<div align='center' class='warningMesg'>Sorry.. No records found !!</div>";
						}
						?>
						</p>
					</div>
				</div>
				<?php
			}
		}
	}
	*/
	
	public function get_page_content_category_all_list($page_content_category_page_content_category_id = 0)
	{
		$database			= new database();
		$page_content_category_array 	= array();
		$sql				= "SELECT * FROM page_content_category WHERE page_content_category_page_content_category_id='".$page_content_category_page_content_category_id."' ORDER BY added_date DESC LIMIT 0, 5";
		$result				= $database->query($sql);
		$num_rows			= $result->num_rows;
		if ($result->num_rows > 0)
		{
			$counter		= 0;
			$i				= 0;
			while($data = $result->fetch_object())
			{
				$i++;
				$page_content_category_gallery_sql	= "SELECT * FROM page_content_category_gallery WHERE page_content_category_id='".$data->page_content_category_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$page_content_category_gallery_result	= $database->query($page_content_category_gallery_sql);				
				if ($page_content_category_gallery_result->num_rows > 0)
				{
					$page_content_category_gallery_data = $page_content_category_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_CATEGORY . 'thumb_' . $page_content_category_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_CATEGORY, CATEGORY_THUMB_WIDTH, CATEGORY_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_CATEGORY . 'thumb_' . $page_content_category_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/gallery_image.png';
				}
				?>	
				<div class="portfoilio_image_space"></div>
				<div class="portfoilio_image_outer" style="cursor:pointer;" onclick="select_page_content_category_details('<?php echo $page_content_category_page_content_category_id; ?>', '<?php echo $data->page_content_category_id; ?>');">
					<div class="portfoilio_image_box"><img src="<?php echo $thumb_image; ?>" width="132" height="127" /></div>
					<div class="portfoilio_image_title"><?php echo functions::deformat_string($data->name); ?></div>
				</div>
				<?php
				$counter++;
			}
		}
	}
	
	public function get_latest_page_content_category_by_page_content_category_list($max_limit)
	{
		$database			= new database();
		$page_content_category_array 	= array();
		$sql			= "SELECT * FROM page_content_category GROUP BY page_content_category_page_content_category_id ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$page_content_category_gallery_sql				= "SELECT * FROM page_content_category_gallery WHERE page_content_category_id='".$data->page_content_category_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$page_content_category_gallery_result				= $database->query($page_content_category_gallery_sql);				
				if ($page_content_category_gallery_result->num_rows > 0)
				{
					$page_content_category_gallery_data = $page_content_category_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_CATEGORY . 'thumb_' . $page_content_category_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_CATEGORY, CATEGORY_THUMB_WIDTH, CATEGORY_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_CATEGORY . 'thumb_' . $page_content_category_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
				<div class="sidebar">
					<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
						<h2><a href="page_content_category.php?cid=<?php echo $data->page_content_category_page_content_category_id; ?>&pid=<?php echo $data->page_content_category_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
						<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="page_content_category.php?cid=<?php echo $page_content_category_page_content_category_id; ?>&pid=<?php echo $data->page_content_category_id; ?>">Read More</a></p>
					</div>
				</div>
				<?php
			}
		}
	}
	
	public function get_page_content_category_list_08_05_2013()
	{
		$database				= new database();
		$param_array			= array();
		$sql 					= "SELECT cs.* FROM page_content_category AS cs ";
		
		$search_condition		= '';
		
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
		
		$sql			.= $search_condition;
		
		if(isset($_REQUEST['sort']))
		{
			$sortField		= $_REQUEST['sort'];
			$sortOrder		= $_REQUEST['odr'];
			$sql			.= " ORDER BY ".$sortField." ".$sortOrder;	
			$param_array[]	= "sort=".$_REQUEST['sort'];	
			$param_array[]	= "odr=".$_REQUEST['odr'];			
		}
		else
		{
			$sortField	= " cs.listing_id ";
			$sortOrder	= "ASC";
			$sql		.= " ORDER BY ".$sortField." ".$sortOrder;
		}
		
		//$sql 			= $sql . " ORDER BY page_content_category_date DESC";		
		$result			= $database->query($sql);
		
		$this->num_rows = $result->num_rows;
		//functions::paginate($this->num_rows);
		functions::paginateclient($this->num_rows, 0, 0, 'CLIENT');
		$start			= functions::$startfrom;
		$limit			= functions::$limits;
		$sql 			= $sql . " limit $start, $limit";
		print $sql;
		$result			= $database->query($sql);
		if ($result->num_rows > 0)
		{				
			$i=0;
			$row =1;
			$col = 0;			
			while($data=$result->fetch_object())
			{				
				$page_content_category_id=$data->page_content_category_id;
				
				//$i++;
				//$thumb_image = page_content_category_gallery::get_default_image($data->page_content_category_id);
				
				
				$sql1="SELECT * FROM page_content_category_gallery where page_content_category_id= '".$page_content_category_id."'";
			
						$result1	= $database->query($sql);
					//while($data=$result->fetch_object($result1))
					//{
				
				?>
              
                <?php  //} ?>
                
         		      
                <?php if($i%1==0) { ?>        
                <div class="box">
                <div class="case-studies-no-dv"><div class="case-studies-no"> <?php echo functions::deformat_string($data->listing_id); ?></div></div>
                <div class="head">
                <a href="casestudy_details.php?cid=<?php echo $data->page_content_category_id;?>"><span class="caption">
                <h4><?php echo   functions::get_sub_string(functions::deformat_string($data->name),15,true); ?> <?php //echo functions::deformat_string($data->listing_id); ?></h4>
                <h5><?php echo functions::get_sub_string(functions::deformat_string($data->description),15,true); ?></h5></span></a>
                </div> 
                </div>
                
                <?php 
				
				
				 if($row == '1' and $col == '3')
					{
						$row = 1;
						$col = '0';
					}
					
                    else if($col == '3')
					{ $col;
						$col = '3';
						 echo $row++;
							$col++;
					}
					$i++;
							
				?>
                    
                <?php 
				
		  }?>
			<?php 	
			 if (($row== '1' && $col== '1') || ($row== '1' && $col== '3')) { 
					echo $row;					
					echo $col;
					  ?>
			<div class="case-studies-no-img"></div>
            
            
            <?php }  ?>
            
            <?php  //if ($row!= '1' and $col != '2') {  
			
			//echo $col;
				
				?>
                 <!--<div class="case-studies-no-img"><img src="images/no-img.png" /></div>-->
                
                <?php  //} ?>
            
            
            
            
                            <?php 
							
				
							
							}?> 
			
						</div>
</div>
			<?php 
		}
		
			else
			{
				echo "<div align='center' class='warningMesg'>Sorry.. No records found !!</div>";
			}
		
		
	}
// The function is used to change the status.
		public static function update_status($page_content_category_id, $status = '')
		{		
			$database		= new database();
			$page_content_category			= new page_content_category($page_content_category_id);
			//$current_status = $page_content_category->status;
			if($status == '')
			{
				$status =  $page_content_category->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE page_content_category 
						SET status = '". $status . "'
						WHERE page_content_category_id = '" . $page_content_category_id . "'";
			$result 	= $database->query($sql);
			return $status;
		}	
	/*public function get_page_content_category_list()
	{
		$raw_style			= array(
											0=>array(1,2,1,3,1,2),
											1=>array(2,1,2,1,2,1),
											2=>array(1,2,1,2,1,3),
											3=>array(2,1,3,1,2,1)
											);
		$page_content_category_array	= array();
		
		$database			= new database();
		$param_array		= array();
		$search_condition	= '';
		$sql 						= "SELECT * FROM page_content_category";
		$sql						.= $search_condition;
		$sql 						= $sql . " ORDER BY listing_id ASC ";
		$result					= $database->query($sql);
		$this->num_rows = $result->num_rows;
		functions::paginate_page_content_category($this->num_rows, 0, 0, 'CLIENT');
		$start					= functions::$startfrom;
		$limit					= functions::$limits;
		$sql 						= $sql . " limit $start, $limit";
       // echo $sql ;
		$result					= $database->query($sql);
       $param				=join("&amp;",$param_array); 
		$this->pager_param=$param;
		$num_rows	= $result->num_rows;
		if ($num_rows > 0)
		{
			$i	= 0;
			while($data = $result->fetch_object())
			{
				$page_content_category_array[$i] = array($data->page_content_category_id, $data->listing_id, $data->name,$data->description);
				$i++;
			}
		}
		
		$count			= 0;
		$total_item	= count($page_content_category_array);
		if ($total_item > 0)
		{
			if(count($page_content_category_array) > 0 && count($page_content_category_array) <=3)
			{
				$rows = 1;
			}
			else if(count($page_content_category_array) > 3 && count($page_content_category_array) <= 6)
			{
				$rows = 2;
			}
			else if(count($page_content_category_array) > 6 && count($page_content_category_array) <= 9)
			{
				$rows = 3;
			}
			else if(count($page_content_category_array) > 9 && count($page_content_category_array) <= 12)
			{
				$rows = 4;
			}
			
			$image_array	= page_content_category_gallery::get_random_images();
			//functions::pre($image_array);
			$image_count	= 0;
			for($i = 0; $i < $rows; $i++)
			{
				echo '<div class="hover-row"> <!-- row start -->';
				for($j= 0; $j < count($raw_style[$i]); $j++)
				{
					if($count == $total_item)
					{
						break;
					}
					
					if($raw_style[$i][$j] == 1)
					{
						?>
						<div class="box">
						<div class="case-studies-no-dv"><div class="case-studies-no"><?php echo $page_content_category_array[$count][1]; ?></div></div>
						<div class="head">
						<a href="casestudy_details.php?cid=<?php echo $page_content_category_array[$count][0]; ?>"><span class="caption">
						<h4><?php //echo $page_content_category_array[$count][1]; 
						echo  functions::get_sub_string(functions::deformat_string($page_content_category_array[$count][2]),8,true);?></h4>
						<h5><?php echo functions::get_sub_string(functions::deformat_string($page_content_category_array[$count][3]),90,true);; ?></h5></span></a>
						</div> 
						</div>
						<?php
						$count++;
					}
					else if($raw_style[$i][$j] == 2)
					{
						echo '<div class="case-studies-no-img"></div>';
					}
					else if($raw_style[$i][$j] == 3)
					{
						echo '<div class="case-studies-no-img">';
						if($image_array[$image_count] != '')
						{
							echo '<img src="' .  URI_CATEGORY . 'thumb_' .  $image_array[$image_count] . '" />';
						}
						$image_count++;
						echo '</div>';
					}
				}
				echo ' <!-- row end --> </div>';
			}
		}
		else
		{
			echo "<div align='center' class='warningMesg'>Sorry.. No records found !!</div>";
		}
	}*/
	
	public  static function check_page_category_active($page_category_id)
	{
		$database	= new database();			
		$sql		= "SELECT * FROM page_content_category WHERE page_content_category_id = '$page_category_id' AND status = 'Y' ";
		$result		= $database->query($sql);
		if ($result->num_rows > 0)
		{
			return 1;					
		}else{
			return 0;
		}
	}
}
?>