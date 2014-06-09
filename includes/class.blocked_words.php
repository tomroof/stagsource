<?php
/*********************************************************************************************
Author 	: V V VIJESH
Date	: 14-April-2011
Purpose	: Case Studies class
*********************************************************************************************/
class blocked_words
{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';
	
	public $status_array	= array(1=>'Draft', 2=>'Published');
	
	
	function __construct($blocked_words_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		
		if($blocked_words_id > 0)
		{
			$this->initialize($blocked_words_id);
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
	private function initialize($blocked_words_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM blocked_words WHERE blocked_words_id = '$blocked_words_id'";
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
		if(!$this->check_blocked_words_exist($this->title, $this->_properties['blocked_words_id']))
		{
			if ( isset($this->_properties['blocked_words_id']) && $this->_properties['blocked_words_id'] > 0) 
			{
				$sql	= "UPDATE blocked_words SET  title = '". $database->real_escape_string($this->title)  ."', status = '". $database->real_escape_string($this->status)  ."' WHERE blocked_words_id = '$this->blocked_words_id'";
			}
			else 
			{
	
				$order_id	= self::get_max_order_id() + 1;
				$sql		= "INSERT INTO blocked_words 
							( title, status, created_at, updated_at) 
							VALUES ('" . $database->real_escape_string($this->title) . "',
									'" . $database->real_escape_string($this->status) . "',
							   		NOW(),
									NOW()
							    )";
			}
			print $sql;
			// exit;
			$result			= $database->query($sql);
			
			if($database->affected_rows == 1)
			{
				if($this->blocked_words_id == 0)
				{
					$this->blocked_words_id	= $database->insert_id;
				}
				$this->initialize($this->blocked_words_id);
			}
		
			$this->message = cnst11;
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	//The function check the blocked_words name eixst or not
	public function check_blocked_words_exist($title='', $blocked_words_id=0)
	{
		$output		= false;
		$database	= new database();
		if($title == '')
		{
			$this->message	= "Title should not be empty";
			$this->warning	= true;
		}
		else
		{
			if($blocked_words_id > 0)
			{
				$sql	= "SELECT *	 FROM blocked_words WHERE title = '" . $database->real_escape_string($title) . "' AND blocked_words_id != '" . $blocked_words_id . "'";
			}
			else
			{
				$sql	= "SELECT *	 FROM blocked_words WHERE title = '" . $database->real_escape_string($title) . "'";
			}
			//print $sql;
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$this->message	= " Title is already exists";
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
		if ( isset($this->_properties['blocked_words_id']) && $this->_properties['blocked_words_id'] > 0) 
		{
			$sql = "DELETE FROM blocked_words WHERE blocked_words_id = '" . $this->blocked_words_id . "'";
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
	public function remove_selected($blocked_words_ids)
	{
		$database	= new database();
		if(count($blocked_words_ids)>0)
		{		
			foreach($blocked_words_ids as $blocked_words_id)
			{
	
					$sql = "DELETE FROM blocked_words  WHERE blocked_words_id = '" . $blocked_words_id . "'";
					
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
		}
	}
	
	public static function get_blocked_words_options()
	{
		$database			= new database();
		$blocked_words_options 	= array();
		$sql				= "SELECT * FROM blocked_words ORDER BY name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$blocked_words_array = array();
			while($data = $result->fetch_object())
			{
				$blocked_words_options[$data->blocked_words_id]	= $data->name;
			}
		}
		return $blocked_words_options;
	}
	
	public static function get_distinct_blocked_words_options($blocked_words_id)
	{
		$database			= new database();
		$blocked_words_options 	= array();
		$sql				= "SELECT DISTINCT blocked_words.*
														FROM blocked_words LEFT JOIN club ON blocked_words.blocked_words_id = club.blocked_words_id
														WHERE (club.club_id IS NULL
														OR blocked_words.blocked_words_id NOT IN (club.blocked_words_id) 
														OR blocked_words.blocked_words_id IN ('$blocked_words_id'))
														AND blocked_words.status='Y'   
														ORDER BY blocked_words.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$blocked_words_array = array();
			while($data = $result->fetch_object())
			{
				$blocked_words_options[$data->blocked_words_id]	= $data->name;
			}
		}
		return $blocked_words_options;
	}
	
	public static function get_distinct_blocked_words_member_options($member_id)
	{
		$database			= new database();
		$blocked_words_options 	= array();
		$sql				= "SELECT DISTINCT blocked_words.*

														FROM blocked_words

														LEFT JOIN member ON blocked_words.name = member.blocked_words

														WHERE (member.member_id IS NULL

														OR blocked_words.name NOT IN (member.blocked_words) 

														OR blocked_words.name IN ('$member_id'))

														AND blocked_words.status='Y'   

														ORDER BY blocked_words.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$blocked_words_array = array();
			while($data = $result->fetch_object())
			{
				$blocked_words_options[$data->blocked_words_id]	= $data->name;
			}
		}
		return $blocked_words_options;
	}
	
	public static function get_blocked_words_list()
	{
		$database			= new database();
		$blocked_words_options 	= array();
		$sql				= "SELECT DISTINCT bc.blocked_words_id, bc.name FROM blocked_words as bc LEFT JOIN image as b on b.blocked_words_id = b.blocked_words_id ORDER BY bc.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$blocked_words_array = array();
			while($data = $result->fetch_object())
			{
				$blocked_words_array['blocked_words_id'] = $data->blocked_words_id;
				$blocked_words_array['name']	= $data->name;
				$blocked_words_options[]	= $blocked_words_array;
			}
		}
		return $blocked_words_options;
	}
	
	public static function get_listing_id()
	{
		$database			= new database();
		$listing_id_array 	= array();
		$sql						= "SELECT listing_id FROM blocked_words  ORDER BY listing_id ASC";
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
	
	public static function get_next_id($blocked_words_id)
	{
		$database				= new database();
		$next_blocked_words_id	= 0;
		 $sql					= "SELECT blocked_words_id FROM blocked_words WHERE blocked_words_id < '$blocked_words_id' ORDER BY blocked_words_date DESC LIMIT 0, 1";
		//echo $sql;
		$result					= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$data 					= $result->fetch_object();
			$next_blocked_words_id	= $data->blocked_words_id;
		}
		return $next_blocked_words_id;
	}
	
	public function get_blocked_words_of_month()
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM blocked_words WHERE blocked_words_of_month = 'Y' LIMIT 0, 1";
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
		$sql 					= "SELECT * FROM blocked_words  ";
		$drag_drop 				= '';
		$search_condition		= '';
				
		if(isset($_REQUEST['search_word']) || $_REQUEST['status'] > 0 ) 
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
			
			if($_REQUEST['status'] > 0)
			{
				$param_array[]			= "status=" . htmlentities($cause);	
				$search_cond_array[]	= "status = $this->status";	
			}
			
			// Drag and dorp ordering is not available in search
			//$drag_drop 						= ' nodrag nodrop ';
		}
		
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
				
		$sql			.= $search_condition;
		$sql 			= $sql . " ORDER BY title ASC ";
		
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
					<input type="hidden" id="blocked_words_id" name="blocked_words_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					<input type="hidden" id="page" name="page" value="' . $page . '" />
				</td>
			</tr>';
			
			while($data=$result->fetch_object())
			{
				$i++;
				$row_num++;
				$class_name		= (($row_type%2) == 0) ? "even" : "odd";
				
				
				echo '
					<tr id="' . $data->blocked_words_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td  class="widthAuto">' . functions::deformat_string($data->title) . '</td>
						<td  class="widthAuto">' . functions::deformat_string($this->status_array[$data->status]) . '</td>
						<td  class="widthAuto">' . date('m/d/Y h:i:s', strtotime($data->created_at)) . '</td>
						<td  class="widthAuto">' . date('m/d/Y h:i:s', strtotime($data->updated_at)) . '</td>
						
						<td class="alignCenter">
							<a href="register_blocked_words.php?blocked_words_id=' . $data->blocked_words_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>
						<td class="alignCenter deleteCol">
							<label><input type="checkbox" name="checkbox[' . $data->blocked_words_id . ']" id="checkbox" /></label>
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
					$urlQuery = 'manage_blocked_words.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_blocked_words.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='7' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
	
	public static function get_breadcrumbs($blocked_words_id, $client_side=false)
	{
		$blocked_words 		= new blocked_words($blocked_words_id);			
		if($client_side)
		{
			$bread_crumb[]			= "<a href='blocked_words.php'>Gallery</a>";
		}
		else
		{
			$bread_crumb[]			= "<a href='manage_blocked_words.php'>Gallery</a>";
			
		}
					
		$bread_crumb[]			= functions::deformat_string($blocked_words->name);
		
		if(count($bread_crumb)>0)
		{
			$bread_crumbs=join(" >> ",$bread_crumb);
		}
		return $bread_crumbs;
	}
	
	public function get_latest_blocked_words_list($blocked_words_blocked_words_id = 0, $max_limit)
	{
		$database			= new database();
		$blocked_words_array 	= array();
		$sql			= "SELECT * FROM blocked_words WHERE blocked_words_blocked_words_id='".$blocked_words_blocked_words_id."' ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$blocked_words_gallery_sql				= "SELECT * FROM blocked_words_gallery WHERE blocked_words_id='".$data->blocked_words_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$blocked_words_gallery_result				= $database->query($blocked_words_gallery_sql);				
				if ($blocked_words_gallery_result->num_rows > 0)
				{
					$blocked_words_gallery_data = $blocked_words_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_blocked_words . 'thumb_' . $blocked_words_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_blocked_words, blocked_words_THUMB_WIDTH, blocked_words_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_blocked_words . 'thumb_' . $blocked_words_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
				<div class="sidebar">
					<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
						<h2><a href="blocked_words.php?cid=<?php echo $blocked_words_blocked_words_id; ?>&pid=<?php echo $data->blocked_words_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
						<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="blocked_words.php?cid=<?php echo $blocked_words_blocked_words_id; ?>&pid=<?php echo $data->blocked_words_id; ?>">Read More</a></p>
					</div>
				</div>
				<?php
			}
		}
	}
	
	/*
	public static function get_blocked_words_list22()
	{
		$database			= new database();
		$sql				= "SELECT DISTINCT ic.* FROM blocked_words as ic INNER JOIN blocked_words_gallery as ig ON ic.blocked_words_id = ig.blocked_words_id ORDER BY ic.blocked_words_id DESC";
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
						
						$blocked_words1		= '';
						$blocked_words2		= '';
						
						for($j = 0; $j <= $counter; $j++)
						{
							if($j < ceil($counter/2))
							{
								$blocked_words1	.= $name[$j] . ' ';
							}
							else
							{
								$blocked_words2	.= $name[$j] . ' ';
							}
						}
						echo '<h1>' . $blocked_words1 . ' <span>' . $blocked_words2 . '</span></h1>';
						?>
						<br />
						
						<?php
						$image_sql		= "SELECT * FROM blocked_words_gallery WHERE blocked_words_id='".$data->blocked_words_id."' ORDER BY added_date DESC";
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
	
	public function get_blocked_words_all_list($blocked_words_blocked_words_id = 0)
	{
		$database			= new database();
		$blocked_words_array 	= array();
		$sql				= "SELECT * FROM blocked_words WHERE blocked_words_blocked_words_id='".$blocked_words_blocked_words_id."' ORDER BY added_date DESC LIMIT 0, 5";
		$result				= $database->query($sql);
		$num_rows			= $result->num_rows;
		if ($result->num_rows > 0)
		{
			$counter		= 0;
			$i				= 0;
			while($data = $result->fetch_object())
			{
				$i++;
				$blocked_words_gallery_sql	= "SELECT * FROM blocked_words_gallery WHERE blocked_words_id='".$data->blocked_words_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$blocked_words_gallery_result	= $database->query($blocked_words_gallery_sql);				
				if ($blocked_words_gallery_result->num_rows > 0)
				{
					$blocked_words_gallery_data = $blocked_words_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_blocked_words . 'thumb_' . $blocked_words_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_blocked_words, blocked_words_THUMB_WIDTH, blocked_words_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_blocked_words . 'thumb_' . $blocked_words_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/gallery_image.png';
				}
				?>	
				<div class="portfoilio_image_space"></div>
				<div class="portfoilio_image_outer" style="cursor:pointer;" onclick="select_blocked_words_details('<?php echo $blocked_words_blocked_words_id; ?>', '<?php echo $data->blocked_words_id; ?>');">
					<div class="portfoilio_image_box"><img src="<?php echo $thumb_image; ?>" width="132" height="127" /></div>
					<div class="portfoilio_image_title"><?php echo functions::deformat_string($data->name); ?></div>
				</div>
				<?php
				$counter++;
			}
		}
	}
	
	public function get_latest_blocked_words_by_blocked_words_list($max_limit)
	{
		$database			= new database();
		$blocked_words_array 	= array();
		$sql			= "SELECT * FROM blocked_words GROUP BY blocked_words_blocked_words_id ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$blocked_words_gallery_sql				= "SELECT * FROM blocked_words_gallery WHERE blocked_words_id='".$data->blocked_words_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$blocked_words_gallery_result				= $database->query($blocked_words_gallery_sql);				
				if ($blocked_words_gallery_result->num_rows > 0)
				{
					$blocked_words_gallery_data = $blocked_words_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_blocked_words . 'thumb_' . $blocked_words_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_blocked_words, blocked_words_THUMB_WIDTH, blocked_words_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_blocked_words . 'thumb_' . $blocked_words_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
				<div class="sidebar">
					<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
						<h2><a href="blocked_words.php?cid=<?php echo $data->blocked_words_blocked_words_id; ?>&pid=<?php echo $data->blocked_words_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
						<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="blocked_words.php?cid=<?php echo $blocked_words_blocked_words_id; ?>&pid=<?php echo $data->blocked_words_id; ?>">Read More</a></p>
					</div>
				</div>
				<?php
			}
		}
	}
	
	public function get_blocked_words_list_08_05_2013()
	{
		$database				= new database();
		$param_array			= array();
		$sql 					= "SELECT cs.* FROM blocked_words AS cs ";
		
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
		
		//$sql 			= $sql . " ORDER BY blocked_words_date DESC";		
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
				$blocked_words_id=$data->blocked_words_id;
				
				//$i++;
				//$thumb_image = blocked_words_gallery::get_default_image($data->blocked_words_id);
				
				
				$sql1="SELECT * FROM blocked_words_gallery where blocked_words_id= '".$blocked_words_id."'";
			
						$result1	= $database->query($sql);
					//while($data=$result->fetch_object($result1))
					//{
				
				?>
              
                <?php  //} ?>
                
         		      
                <?php if($i%1==0) { ?>        
                <div class="box">
                <div class="case-studies-no-dv"><div class="case-studies-no"> <?php echo functions::deformat_string($data->listing_id); ?></div></div>
                <div class="head">
                <a href="casestudy_details.php?cid=<?php echo $data->blocked_words_id;?>"><span class="caption">
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
		public static function update_status($blocked_words_id, $status = '')
		{		
			$database		= new database();
			$blocked_words			= new blocked_words($blocked_words_id);
			//$current_status = $blocked_words->status;
			if($status == '')
			{
				$status =  $blocked_words->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE blocked_words 
						SET status = '". $status . "'
						WHERE blocked_words_id = '" . $blocked_words_id . "'";
						
						
			$result 	= $database->query($sql);
			
			
			$sql		= "UPDATE wineries_link
						SET status = '". $status . "'
						WHERE blocked_words_id = '" . $blocked_words_id . "'";
						
						
			$result1 	= $database->query($sql);
			return $status;
		}	
	/*public function get_blocked_words_list()
	{
		$raw_style			= array(
											0=>array(1,2,1,3,1,2),
											1=>array(2,1,2,1,2,1),
											2=>array(1,2,1,2,1,3),
											3=>array(2,1,3,1,2,1)
											);
		$blocked_words_array	= array();
		
		$database			= new database();
		$param_array		= array();
		$search_condition	= '';
		$sql 						= "SELECT * FROM blocked_words";
		$sql						.= $search_condition;
		$sql 						= $sql . " ORDER BY listing_id ASC ";
		$result					= $database->query($sql);
		$this->num_rows = $result->num_rows;
		functions::paginate_blocked_words($this->num_rows, 0, 0, 'CLIENT');
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
				$blocked_words_array[$i] = array($data->blocked_words_id, $data->listing_id, $data->name,$data->description);
				$i++;
			}
		}
		
		$count			= 0;
		$total_item	= count($blocked_words_array);
		if ($total_item > 0)
		{
			if(count($blocked_words_array) > 0 && count($blocked_words_array) <=3)
			{
				$rows = 1;
			}
			else if(count($blocked_words_array) > 3 && count($blocked_words_array) <= 6)
			{
				$rows = 2;
			}
			else if(count($blocked_words_array) > 6 && count($blocked_words_array) <= 9)
			{
				$rows = 3;
			}
			else if(count($blocked_words_array) > 9 && count($blocked_words_array) <= 12)
			{
				$rows = 4;
			}
			
			$image_array	= blocked_words_gallery::get_random_images();
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
						<div class="case-studies-no-dv"><div class="case-studies-no"><?php echo $blocked_words_array[$count][1]; ?></div></div>
						<div class="head">
						<a href="casestudy_details.php?cid=<?php echo $blocked_words_array[$count][0]; ?>"><span class="caption">
						<h4><?php //echo $blocked_words_array[$count][1]; 
						echo  functions::get_sub_string(functions::deformat_string($blocked_words_array[$count][2]),8,true);?></h4>
						<h5><?php echo functions::get_sub_string(functions::deformat_string($blocked_words_array[$count][3]),90,true);; ?></h5></span></a>
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
							echo '<img src="' .  URI_blocked_words . 'thumb_' .  $image_array[$image_count] . '" />';
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
	
	public function getBaseblocked_words($parent_id){
		$database			= new database();		
		$sql				= "SELECT * FROM blocked_words WHERE parent_id = '0' ORDER BY name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($parent_id == $data->blocked_words_id)
					echo '<option value="'.$data->blocked_words_id.'" selected="selected">'.$data->name.'</option>';
				else
					echo '<option value="'.$data->blocked_words_id.'">'.$data->name.'</option>';	
					
				//to display sub acategories
				$sql				= "SELECT * FROM blocked_words WHERE parent_id = '".$data->blocked_words_id."' ORDER BY name ASC";
				$result1				= $database->query($sql);		
				if ($result1->num_rows > 0)
				{
					while($data1 = $result1->fetch_object())
					{
						if ($parent_id == $data1->blocked_words_id)
							echo '<option value="'.$data1->blocked_words_id.'" style="padding-left:2em" selected="selected"> >> '.$data1->name.'</option>';
						else
							echo '<option value="'.$data1->blocked_words_id.'" style="padding-left:2em"> >> '.$data1->name.'</option>';	
					}
				}			
						
			}
		}
		return;
	}
	
	public function productsExists($parent_id){
		$flag = '0';
		$database			= new database();		
		$sql				= "SELECT * FROM blocked_words  WHERE parent_id = '$parent_id' AND status = 'Y' ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$sql 		= "SELECT * FROM product p LEFT JOIN product_gallery g ON p.product_id = g.product_id AND g.valid_image = 'Y'  
							   WHERE p.blocked_words_id = '".$data->blocked_words_id."' AND p.status = 'Y'  ";
				$result1	= $database->query($sql);		
				if ($result1->num_rows > 0)
				{
					$flag = '1';
				}
			}
		}
		return $flag;
	}
	
	public function displayTopblocked_wordsMenu(){
		$database			= new database();
		
		//to find categories with products
		$catid_arr  	= array();
		$catid_arr[]	= '0'; 
		$str_id     	= ''; 
		$sql			= "SELECT * FROM blocked_words  WHERE parent_id = '0' AND status = 'Y' ORDER BY blocked_words_id ASC";
		$result			= $database->query($sql);				
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($this->productsExists($data->blocked_words_id) > 0){
					$catid_arr[] = $data->blocked_words_id;					
				}
			}				
			$str_id     = implode (",",$catid_arr);	
		}			
				
		//$sql				= "SELECT * FROM blocked_words  WHERE parent_id = '0' ORDER BY blocked_words_id ASC";
		$sql				= "SELECT * FROM blocked_words  WHERE blocked_words_id IN (".$str_id.") AND status = 'Y' ORDER BY blocked_words_id ASC";
		$result				= $database->query($sql);				
		if ($result->num_rows > 0)
		{
			echo '	
				<div id="menu">
					<ul>';
					
			$main_cat_cnt = '1';		
			while($data = $result->fetch_object())
			{
				//if ($this->productsExists($data->blocked_words_id) > 0){
					//echo $result->num_rows.' == '.$main_cat_cnt;
					if ($result->num_rows == $main_cat_cnt)
						$class_main_last = 'class="last_item menu_item down"';
					else
						$class_main_last = 'class="menu_item down"';
				
					echo '<li '.$class_main_last.'><a href="blocked_words.php?cid='.$data->blocked_words_id.'">'.$data->name.'</a>';
					
					$sql 		= "SELECT * FROM blocked_words c 
								   INNER JOIN product p ON c.blocked_words_id = p.blocked_words_id
								   LEFT JOIN product_gallery g ON p.product_id = g.product_id AND g.valid_image = 'Y'  
								   WHERE c.parent_id = '".$data->blocked_words_id."' AND c.status = 'Y' AND p.status = 'Y'  
								   GROUP BY c.blocked_words_id
								   ORDER BY c.blocked_words_id ASC";
								   
					$result1	= $database->query($sql);		
					if ($result1->num_rows > 0)
					{
						echo '	
							 <div class="sub_menu" style="">
							  <div class="bubble"></div>
							  <div class="sub_menu_block" style="width:163px">
								<ul>';
								
							while($data1 = $result1->fetch_object())
							{
								
								/*$sql 		= "SELECT * FROM product WHERE blocked_words_id = '".$data1->blocked_words_id."' AND status = 'Y' ";
								$result3	= $database->query($sql);		
								if ($result3->num_rows > 0)
								{*/		
						
								echo '<li><a href="blocked_words.php?cid='.$data1->blocked_words_id.'">'.$data1->name.'</a></li>';
								
								//}
							}
								
						echo '</ul>
							 </div>
						   </div>';
					}
							
					echo '</li>';
				//}
				$main_cat_cnt++;		
			}
			
			echo '
				</ul>
			</div>';
		}
		return;
	}
	
	public function getSubblocked_wordsIdList($blocked_words_id){
		$database	= new database();
		
		//newly added
		$catid_arr  = array();
		$catid_arr[]= '0'; 
		$sql		= "SELECT * FROM blocked_words WHERE parent_id = '".$blocked_words_id."' AND status = 'Y' ORDER BY blocked_words_id ASC";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{				
				$catid_arr[] = $data->blocked_words_id;					
			}
		}				
		$str_id     = implode (",",$catid_arr);	
		return $str_id;
	}
	
	public function getParentCategId($cid){
		$database	= new database();
		$sql		= "SELECT * FROM blocked_words WHERE blocked_words_id = '".$cid."' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$data = $result->fetch_object();
		}
		return $data->parent_id;	
	}	
	
	public function getBaseblocked_wordsListWithProducts(){
		$database	= new database();
		$baseCatListArr = array();
		$sql		= "SELECT * FROM blocked_words WHERE parent_id = '0' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->blocked_words_id;
						
				$sql1		= "SELECT * FROM blocked_words WHERE parent_id = '".$data->blocked_words_id."'AND status = 'Y' ";
				$result1	= $database->query($sql1);		
				if ($result1->num_rows > 0)
				{			
					while ($data1 = $result1->fetch_object()){
						$catIdListArray[] = $data1->blocked_words_id;
						$sql2		= "SELECT * FROM blocked_words WHERE parent_id = '".$data->blocked_words_id."' AND status = 'Y' ";
						$result2	= $database->query($sql2);		
						if ($result2->num_rows > 0)
						{			
							while ($data2 = $result2->fetch_object()){
								$catIdListArray[] = $data2->blocked_words_id;
							}
						}
					}
				}
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE blocked_words_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->blocked_words_id;
					 					
				}	
			}
		}
		if (count($baseCatListArr) > 0){
			//print_r ($baseCatListArr);
			$baseCatListArr = array_unique($baseCatListArr);
			return $baseCatListArr;			
		}else{
			$baseCatListArr[] = '0';
			return $baseCatListArr;				
		}
	} 
	
	public function getSubblocked_wordsListWithProducts($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM blocked_words WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->blocked_words_id;
						
				$sql1		= "SELECT * FROM blocked_words WHERE parent_id = '".$data->blocked_words_id."' AND status = 'Y' ";
				$result1	= $database->query($sql1);		
				if ($result1->num_rows > 0)
				{			
					while ($data1 = $result1->fetch_object()){
						$catIdListArray[] = $data1->blocked_words_id;						
					}
				}
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE blocked_words_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->blocked_words_id;
					 					
				}	
			}
		}
		if (count($baseCatListArr) > 0){
			//print_r ($baseCatListArr);
			$baseCatListArr = array_unique($baseCatListArr);
			return $baseCatListArr;			
		}else{
			$baseCatListArr[] = '0';
			return $baseCatListArr;				
		}
	}
	
	public function subArrowSubblocked_words($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM blocked_words WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->blocked_words_id;
						
				$sql1		= "SELECT * FROM blocked_words WHERE parent_id = '".$data->blocked_words_id."' AND status = 'Y' ";
				$result1	= $database->query($sql1);		
				if ($result1->num_rows > 0)
				{			
					while ($data1 = $result1->fetch_object()){
						$catIdListArray[] = $data1->blocked_words_id;						
					}
				}
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE blocked_words_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->blocked_words_id;
					 					
				}	
			}
		}
		if (count($baseCatListArr) > 0){
			//print_r ($baseCatListArr);
			//$baseCatListArr = array_unique($baseCatListArr);
			//return $baseCatListArr;
			return 1;			
		}else{
			//$baseCatListArr[] = '0';
			//return $baseCatListArr;
			return 0;				
		}
	}
	
	public function getSubSubblocked_wordsListWithProducts($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM blocked_words WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->blocked_words_id;
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE blocked_words_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->blocked_words_id;
					 					
				}	
			}
		}
		if (count($baseCatListArr) > 0){
			//print_r ($baseCatListArr);
			$baseCatListArr = array_unique($baseCatListArr);
			return $baseCatListArr;			
		}else{
			$baseCatListArr[] = '0';
			return $baseCatListArr;				
		}
	}
	
	public function subArrowSubSubblocked_words($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM blocked_words WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->blocked_words_id;
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE blocked_words_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->blocked_words_id;
					 					
				}	
			}
		}
		if (count($baseCatListArr) > 0){
			//print_r ($baseCatListArr);
			//$baseCatListArr = array_unique($baseCatListArr);
			return 1;			
		}else{
			//$baseCatListArr[] = '0';
			//return $baseCatListArr;
			return 0;				
		}
	}
	
	public function getblocked_wordsDropMenuList(){
		$database			= new database();
		$baseCatIdList 		= $this->getBaseblocked_wordsListWithProducts();
		$baseCatIdListStr 	= implode(",",$baseCatIdList);
		$sql			= "SELECT * FROM blocked_words WHERE blocked_words_id IN (".$baseCatIdListStr.") AND parent_id = '0' AND status = 'Y' ORDER BY order_id ";
		$result			= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			echo '
			<ul id="nav">		
			  	<div class="productbox-outer">';		  
				
				$box_count = '1';					
				while ($data = $result->fetch_object()){
					if ($box_count%4 == '0') $box_class = 'productbox_first last'; else $box_class = 'productbox_first'; 
					echo '
					<div class="'.$box_class.'">
				  		<div class="pro_hdr">'.functions::deformat_string($data->name).'</div>';
				  
				  		//to display subblocked_words list
				  		$subCatIdList 	= $this->getSubblocked_wordsListWithProducts($data->blocked_words_id);
						$sql1			= "SELECT * FROM blocked_words WHERE blocked_words_id IN (".implode(",",$subCatIdList).") AND parent_id = '".$data->blocked_words_id."' AND status = 'Y' ORDER BY order_id ";
						$result1		= $database->query($sql1);
						
						$sql4		= "SELECT * FROM product WHERE blocked_words_id = '".$data->blocked_words_id."' AND status = 'Y' ORDER BY order_id ";
						$result4	= $database->query($sql4);
														
						if ($result1->num_rows > 0 or $result4->num_rows > 0){
					   		echo '
					  		<div class="product-list">';
						
					   			while ($data1 = $result1->fetch_object()){
					   				
									//to check whether sub arrow
									$subArrowneeded = $this->subArrowSubblocked_words($data1->blocked_words_id);										
									$arrowClass 	= ($subArrowneeded == '1') ? 'pro_arrow' : '';
									//end to check whether sub arrow									
									
									echo '
									<li class="'.$arrowClass.'">
										<a href="#">'.functions::deformat_string($data1->name).'</a>';
							
										$subSubCatIdList 	= $this->getSubSubblocked_wordsListWithProducts($data1->blocked_words_id);
										$sql2				= "SELECT * FROM blocked_words WHERE blocked_words_id IN (".implode(",",$subSubCatIdList).") AND parent_id = '".$data1->blocked_words_id."' AND status = 'Y' ORDER BY order_id ";
										$result2			= $database->query($sql2);	
										
										$sql5		= "SELECT * FROM product WHERE blocked_words_id = '".$data1->blocked_words_id."' AND status = 'Y' ORDER BY order_id ";
										$result5	= $database->query($sql5);
																					
										if ($result2->num_rows > 0 or $result5->num_rows > 0){
															
											echo  '
											<ul>';
											
											//to display sub sub blocked_words
											while ($data2 = $result2->fetch_object()){
											
												//to check whether sub arrow
												$subSubArrowneeded 	= $this->subArrowSubSubblocked_words($data2->blocked_words_id);										
												$arrowClass1 		= ($subSubArrowneeded == '1') ? 'pro_arrow' : '';
												//end to check whether sub arrow											
											
												echo '
												<li class="'.$arrowClass1.'">
													<a href="#">'.functions::deformat_string($data2->name).'</a>';
													
													//display sub sub blocked_words products
													$sql3		= "SELECT * FROM product WHERE blocked_words_id = '".$data2->blocked_words_id."' AND status = 'Y' ORDER BY order_id ";
													$result3	= $database->query($sql3);		
													if ($result3->num_rows > 0){
																							   
														echo '																					  
														<ul>';
														while ($data3 = $result3->fetch_object()){
															echo '
															<li><a href="product.php?pid='.$data3->product_id.'">'.functions::deformat_string($data3->product_name).'</a></li>';
														}
											
														echo '	                        
														</ul>';
													}
												echo ' 
												</li>';		 
											}	
											//end of sub sub blocked_words
											
											//display sub blocked_words products													
											if ($result5->num_rows > 0){																		   									
												while ($data5 = $result5->fetch_object()){
													echo '
													<li><a href="product.php?pid='.$data5->product_id.'">'.functions::deformat_string($data5->product_name).'</a></li>';
												}						
											}
											//end of products
											
											
											echo '
											</ul>';
									}
									
									echo '
									</li>';
											
								}
								//end of subcategories
								
								//display main blocked_words products										
								if ($result4->num_rows > 0){																		   									
									while ($data4 = $result4->fetch_object()){
										echo '
										<li><a href="product.php?pid='.$data4->product_id.'">'.functions::deformat_string($data4->product_name).'</a></li>';
									}						
								}
								//end of products
						
							echo '
							</div>';		  
						}
						//end to display subblocked_words list
						  
				  
				  	echo '
					</div>';
				
					if ($box_count%4 == '0') echo '</div><div class="productbox-outer">';
					$box_count++;
				}
			
				echo '						            
			  	</div>		            
			</ul>';
			
		}else{
			echo '<div style="margin: 10px 0px 20px 0px;">Sorry, no products found.</div>';
		}				
		return;
	}
	
	public function getleftblocked_wordsMenu($pid){
	
		$product 		= new product($pid);
		$blocked_words_id 	= $product->blocked_words_id; 
		$selcat_flag 	= '0';
		
		if ($blocked_words_id > 0){
			$blocked_words 		= new blocked_words($blocked_words_id);
			if ($blocked_words->parent_id > 0){
				$sub_blocked_words = new blocked_words($blocked_words->parent_id);
				if ($sub_blocked_words->parent_id > 0){
					$sub_sub_blocked_words = new blocked_words($sub_blocked_words->parent_id);
					
					$main_cat_id 	= $sub_sub_blocked_words->blocked_words_id;
					$sub_cat_id	 	= $sub_blocked_words->blocked_words_id;
					$sub_sub_cat_id	= $blocked_words_id;
												
				}else{
					$main_cat_id = $sub_blocked_words->blocked_words_id;
					$sub_cat_id	 = $blocked_words_id;
				}
				
			}else{
				$main_cat_id = $blocked_words_id;
			}
		}
		
		if ($main_cat_id > 0){
		
			$disp_main_blocked_words = new blocked_words($main_cat_id);
		
			echo '
			  <div class="product-detail_first">
				<div class="pro_hdr">'.functions::deformat_string($disp_main_blocked_words->name).'</div>
				<div class="product-list">
				  <ul id="example1">';
			  
			$database	= new database();
				
			//$sql		= "SELECT * FROM blocked_words WHERE parent_id = '".$main_cat_id."' AND status = 'Y' ";
			//$result		= $database->query($sql);
			
			$subCatIdList 	= $this->getSubblocked_wordsListWithProducts($main_cat_id);
			$sql			= "SELECT * FROM blocked_words WHERE blocked_words_id IN (".implode(",",$subCatIdList).") AND parent_id = '".$main_cat_id."' AND status = 'Y' ORDER BY order_id ASC ";
			$result			= $database->query($sql);
					
			if ($result->num_rows > 0)
			{			
				while ($data = $result->fetch_object()){
				  
				   echo    '<li><a href="#">'.functions::deformat_string($data->name).'</a>';
				   
				   //$sql1	= "SELECT * FROM blocked_words WHERE parent_id = '".$data->blocked_words_id."' AND status = 'Y' ";
				   //$result1	= $database->query($sql1);
				   
				   $subSubCatIdList = $this->getSubSubblocked_wordsListWithProducts($data->blocked_words_id);
				   $sql1			= "SELECT * FROM blocked_words WHERE blocked_words_id IN (".implode(",",$subSubCatIdList).") AND parent_id = '".$data->blocked_words_id."' AND status = 'Y' ORDER BY order_id ASC ";
				   $result1			= $database->query($sql1);	
														   		
				   if ($result1->num_rows > 0)
				   {
						if ($sub_cat_id == $data->blocked_words_id){
							echo  '<ul class="sub sub1">';
							$selcat_flag = '1';
						}else{
							echo  '<ul class="sub">';
						}				
						while ($data1 = $result1->fetch_object()){						
							echo  '<li><a href="#">'.functions::deformat_string($data1->name).'</a></li>';						   
						}
						echo '</ul>';
				   }		   
							  
				   echo	   '</li>';
							
				}
		   }			
				              
      	  echo '</ul>
            </div>
          </div>';
		  
		  if ($selcat_flag == '1'){
		  	  echo '<input type="hidden" name="selcat_flag" id="selcat_flag" value="1" />';
		  }else{
		  	  echo '<input type="hidden" name="selcat_flag" id="selcat_flag" value="0" />';	  
		  }
		  //onMouseOver="javascript: disable_selblocked_words();"
		  //store selected blocked_words
	   }	  
	}
	
	
	/*'<div class="probox_first pro_last">
		<div class="probox_first_img"><img src="images/product_img.png"></div>
		<div class="protxt">Cement, Lime and Mortar</div>
		<div class="pro_list">
			<ul>
				<li>Air Content and Density</li>	
			</ul>
		</div>
		<div class="readmore">Read More</div>
	</div>'*/
	
	public function getHomeblocked_wordsMenuList(){
		$database		= new database();
		$functions 			= new functions();
		
		$baseCatIdList 	= $this->getBaseblocked_wordsListWithProducts();
		$sql			= "SELECT * FROM blocked_words WHERE blocked_words_id IN (".implode(",",$baseCatIdList).") AND parent_id = '0' AND status = 'Y' ORDER BY rand() LIMIT 0,3 ";
		$result			= $database->query($sql);		
		if ($result->num_rows > 0)
		{
				  				
				$box_count = '1';
				
				echo '
				<div id="product_area" class="clearfix">
					<div class="pro_hdrtxt">
						<h2>Products</h2>
					</div>
					<section>
						<div id="pro-box">';
													
				while ($data = $result->fetch_object()){
					if ($box_count%3 == '0') $box_class = 'probox_first pro_last'; else $box_class = 'probox_first'; 
								  
					//to display subblocked_words list
					$subCatIdList 	= $this->getSubblocked_wordsListWithProducts($data->blocked_words_id);
					$sql1			= "SELECT * FROM blocked_words WHERE blocked_words_id IN (".implode(",",$subCatIdList).") AND parent_id = '".$data->blocked_words_id."' AND status = 'Y' ORDER BY order_id ASC ";
					$result1		= $database->query($sql1);
					
					$sql4		= "SELECT * FROM product WHERE blocked_words_id IN (".implode(",",$subCatIdList).") AND status = 'Y' ORDER BY rand() LIMIT 0,1 ";
					$result4	= $database->query($sql4);
					
					if ($result4->num_rows > 0){
						$data4 = $result4->fetch_object();	
						$img_name	= $data4->image_name;
						if ($img_name != ''){				 
							$prod_img_path = DIR_PRODUCT.'thumb_'.$img_name;				
							if (file_exists($prod_img_path)){
								$src_file = URI_PRODUCT.'thumb_'.$img_name;
							}else{
								$src_file = URI_PRODUCT.$img_name;
							}		
							$large_icon_path = DIR_PRODUCT.'small_icon_'.$img_name;
							if (file_exists($large_icon_path)){
								$dis_image_path = URI_PRODUCT.'small_icon_'.$img_name;
							}else{	
								$functions->autoResizeImageNotCropped(DIR_PRODUCT,$img_name,'small_icon_',PRODUCT_SMALL_ICON_WIDTH,PRODUCT_SMALL_ICON_HEIGHT);						
								$dis_image_path = URI_PRODUCT.'small_icon_'.$img_name;
							}																																									
						}
					}
						
					echo '
					<div class="'.$box_class.'">
						<div class="probox_first_img"><img src="'.$dis_image_path.'"></div>
						<div class="protxt">'.functions::deformat_string($data->name).'</div>';	
						
						
						$sql5		= "SELECT * FROM product WHERE blocked_words_id = '".$data->blocked_words_id."' AND status = 'Y' ORDER BY order_id ASC ";
						$result5	= $database->query($sql5);
														
						if ($result1->num_rows > 0 or $result5->num_rows > 0){
						
					   		echo '
					  		<div class="pro_list">
								<ul>';
						
					   			while ($data1 = $result1->fetch_object()){
								
									echo '<li>'.functions::deformat_string($data1->name).'</li>';
											
								}
								
								//echo '<li>a a aasf afdsf sfds</li>';
								//end of subcategories
								
								//display main blocked_words products																																										   									
								while ($data5 = $result5->fetch_object()){
									echo '
									<li>'.functions::deformat_string($data5->product_name).'</li>';
								}														
								//end of products
						
							echo '</ul>
							</div>
							<div class="readmore"><a href="product.php?pid='.$data4->product_id.'">Read More</a></div>';		  
						}
						//end to display subblocked_words list
						  
				  
				  	echo '
					</div>';
					
					$box_count++;
				}
				
			echo '
			</section>
           </div>';
				
		}				
		return;
	}
	
	// Returns the max order id
	public static function get_max_order_id()
	{
		$database	= new database();
		$sql		= "SELECT MAX(order_id) AS order_id FROM blocked_words WHERE 1 ";
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
			$sql = "UPDATE blocked_words SET order_id = '" . $order_id . "' WHERE blocked_words_id = '" . $id_array[$i] . "'";
			//echo $sql;
			$database->query($sql);
			$order_id++;
		}
	}
	
	public function getblocked_wordsBreadCrumb($blocked_words_id){
		//$database		= new database();
		//$functions 	= new functions();
		$cat_array      = array();
		$blocked_words1      = new blocked_words($blocked_words_id);
				
		if ($blocked_words1->name != ''){		
			$cat_array[] = $blocked_words1->name;	
			if ($blocked_words1->parent_id > 0){
				$blocked_words2      = new blocked_words($blocked_words1->parent_id);	
				if ($blocked_words2->name != ''){				
					$cat_array[] = $blocked_words2->name;	
					if ($blocked_words2->parent_id > 0){
						$blocked_words3      = new blocked_words($blocked_words2->parent_id);	
						$cat_array[]    = $blocked_words3->name;			
					}
				}
			}
		}
		$cat_array = array_reverse($cat_array);
		return implode(" >> ",$cat_array);
	}
		

	public function get_blocked_words($id=0)
		{
			$database		= new database();
			if($id>0)
			{
				 $sql="	SELECT p.*
 						FROM blocked_words p INNER JOIN wineries_link l ON p.blocked_words_id = l.blocked_words_id order by order_id";	
					
			}else
			{
			 $sql 			= "SELECT * FROM blocked_words  order by order_id ";
			}
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
				{
					$array = array();
					while($data = $result->fetch_object())
					{
						$array['blocked_words_id'] = $data->blocked_words_id;
						$array['name']	= $data->name;
						$blocked_words []	= $array;
					}
				}
				return $blocked_words;
		
	
			
		}
		
		
		public function get_blocked_words_userside()
		{
			$database		= new database();
		//	$sql 			= "SELECT * FROM blocked_words  WHERE status='Y' order by order_id ";
			$sql 			= "SELECT DISTINCT b . *
			FROM blocked_words b
			INNER JOIN wineries a ON FIND_IN_SET( b.`blocked_words_id` , a.blocked_words )
			WHERE b.status = 'Y'
			AND a.status = 'Y' order by b.order_id ";
			$blocked_words  = array();
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
				{
					$array = array();
					while($data = $result->fetch_object())
					{
						$blocked_words []	= $data;
					}
				}
				return $blocked_words;
		
	
			
		}
		
		
		//Menu Top
		
		public static function get_top_menu($page_name ='', $page_id= '', $responsive=false)
		{
			$page_id = str_replace('/','', $page_id);
			$database		= new database();
			
			$sql 			= "SELECT * FROM blocked_words WHERE status='Y' AND blocked_words_id!=1 ORDER BY order_id ASC";
			$result			= $database->query($sql);	
			
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{ 
					if($responsive)
					{
						?>
                        <a href="<?php echo URI_ROOT .'blocked_words/'. strtolower(functions::deformat_string($data->name)) ?>"><li><?php echo functions::deformat_string($data->name) ?></li></a>
                        <?php
					}
					else
					{
						if($data->blocked_words_id == 10) {
						 ?>
                         	<a style="cursor:pointer;" id="bachelorparty_btn" class="big-link" data-reveal-id="bachelorparty"  data-animation="fadeAndPop">
                         
                         <?php } else if($data->blocked_words_id == 2) { ?>
                         	<a style="cursor:pointer;" id="wedding_btn" class="big-link" data-reveal-id="bachelorparty" data-animation="fadeAndPop">
                         <?php } else {
						 ?>
                			<a href="<?php echo URI_ROOT.'blocked_words/'. strtolower(functions::deformat_string($data->name)) ?>">
                        <?php } ?>
                        
							<li <?php echo ($page_name =='blocked_words.php' && $page_id == strtolower(functions::deformat_string($data->name))) ? 'class="active"' : ''; ?>><?php echo functions::deformat_string($data->name) ?>
                            
                            
                            </li>
						</a>
                <?php
					}
				}
			} 
		}
		
		public static function get_sub_menu($responsive=false)
		{
			$page_id = str_replace('/','', $page_id);
			$database		= new database();
			
			$sql 			= "SELECT * FROM blocked_words WHERE status='Y' ORDER BY order_id ASC";
			$result			= $database->query($sql);	
			
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{ 
					if($responsive)
					{
						?>
                        <a href="<?php echo URI_ROOT .'community/'. strtolower(functions::deformat_string($data->name)) ?>"><li><?php echo functions::deformat_string($data->name) ?></li></a>
                        <?php
					}
					else
					{
					?>
                    	<a href="<?php echo URI_ROOT .'community/'. strtolower(functions::deformat_string($data->name)) ?>"><li>
                          <?php echo functions::deformat_string($data->name) ?>
                      </li></a>
                		
                <?php
					}
				}
			} 
		}
		
		public static function get_blocked_words_id_byname($name= '')
		{
			$database		= new database();
			$sql 			= "SELECT blocked_words_id FROM blocked_words WHERE name='$name'";
			
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data = $result->fetch_object();
				return $data->blocked_words_id;
			}
			else
			{
				return 0;
			}
		}
		
		public static function get_spam_exist($model_id = 0)
		{
			$output 		= array();
			$database		= new database();
			$sql 			= "SELECT blocked_words_id FROM blocked_words WHERE model_id='$model_id'";
			$result			= $database->query($sql);
			return $result->num_rows;
		}
		
    }
?>