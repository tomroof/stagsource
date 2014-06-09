<?php
/*********************************************************************************************
Date	: 14-April-2011
Purpose	: Property Category class
*********************************************************************************************/
class property_type
{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';
	
	

	
	function __construct($property_type_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		
		if($property_type_id > 0)
		{
			$this->initialize($property_type_id);
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
	private function initialize($property_type_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM property_type WHERE property_type_id = '$property_type_id'";
		//echo $sql;
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$this->_properties	= $result->fetch_assoc();
		}
	}

	// Save the Property Category details
	public function save()
	{
		$database	= new database();
		if(!$this->check_property_type_exist($this->name, $this->_properties['property_type_id']))
		{
			if ( isset($this->_properties['property_type_id']) && $this->_properties['property_type_id'] > 0) 
			{
				$sql	= "UPDATE property_type SET parent_id = '" . $database->real_escape_string($this->parent_id) . "',name = '". $database->real_escape_string($this->name)  . "',status = '". $database->real_escape_string($this->status)  ."' WHERE property_type_id = '$this->property_type_id'";
			}
			else 
			{
				$sql		= "INSERT INTO property_type 
							(parent_id,name,status) 
							VALUES ('" . $database->real_escape_string($this->parent_id) . "',
							'" . $database->real_escape_string($this->name) . "',
							'" . $database->real_escape_string($this->status) . "')";
			}
			//print $sql; exit;
			$result			= $database->query($sql);
			
			if($database->affected_rows == 1)
			{
				if($this->property_type_id == 0)
				{
					$this->property_type_id	= $database->insert_id;
				}
				$this->initialize($this->property_type_id);
			}
		
			$this->message = cnst11;
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	//The function check the property_type name eixst or not
	public function check_property_type_exist($name='', $property_type_id=0)
	{
		$output		= false;
		$database	= new database();
		if($name == '')
		{
			$this->message	= "Property category name should not be empty";
			$this->warning	= true;
		}
		else
		{
			if($property_type_id > 0)
			{
				$sql	= "SELECT *	 FROM property_type WHERE name = '" . $database->real_escape_string($name) . "' AND property_type_id != '" . $property_type_id . "'";
			}
			else
			{
				$sql	= "SELECT *	 FROM property_type WHERE name = '" . $database->real_escape_string($name) . "'";
			}
			//print $sql;
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$this->message	= "Property category name is already exist";
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
		if ( isset($this->_properties['property_type_id']) && $this->_properties['property_type_id'] > 0) 
		{
			$sql = "DELETE FROM property_type WHERE property_type_id = '" . $this->property_type_id . "'";
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
	public function remove_selected($property_type_ids)
	{
		$database	= new database();
		if(count($property_type_ids)>0)
		{		
			foreach($property_type_ids as $property_type_id)
			{
				$sql = "DELETE FROM property_type WHERE property_type_id = '" . $property_type_id . "'";
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
	
	public static function get_property_type_options()
	{
		$database			= new database();
		$output			 	= array();
		$sql				= "SELECT * FROM property_type WHERE status='Y' ORDER BY name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$category_array = array();
			while($data = $result->fetch_object())
			{
				$output[] = $data;
			}
		}
		return $output;
	}
	
	
	public static function get_sub_category_options($id)
	{
		$database			= new database();
		$category_options 	= array();
		$sql				= "SELECT * FROM property_type  where parent_id='".$id."' ORDER BY name ASC";
		//echo $sql;
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$category_array = array();
			while($data = $result->fetch_object())
			{
				$category_array['property_type_id'] = $data->property_type_id;
				$category_array['name']	= $data->name;
				$category_options[]	= $category_array;
			}
		}
		return $category_options;
	}
	
	public static function get_category_list()
	{
		$database			= new database();
		$category_options 	= array();
		$sql				= "SELECT DISTINCT bc.property_type_id, bc.name FROM property_type as bc LEFT JOIN property as b on b.property_type_id = b.property_type_id ORDER BY bc.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$category_array = array();
			while($data = $result->fetch_object())
			{
				$category_array['property_type_id'] = $data->property_type_id;
				$category_array['name']	= $data->name;
				$category_options[]	= $category_array;
			}
		}
		return $category_options;
	}
	
	public function display_list()
	{
		$database				= new database();
		$validation				= new validation(); 
		$functions              =new functions();
		$param_array			= array();
		$sql 					= "SELECT * FROM property_type";
		$drag_drop 				= '';
		$search_condition		= '';
		
		$search_cond_array[]	= " parent_id = '0' ";
				
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
					$search_cond_array[]	= " name like '%" . $database->real_escape_string($search_word) . "%' ";	
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
		$sql 			= $sql . " ORDER BY name ASC";
		$result			= $database->query($sql);
		
		$this->num_rows = $result->num_rows;
		$functions->paginate($this->num_rows);
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
				<td colspan="4"  class="noBorder">
					<input type="hidden" id="show"  name="show" value="0" />
					<input type="hidden" id="property_type_id" name="property_type_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					<input type="hidden" id="page" name="page" value="' . $page . '" />
				</td>
			</tr>';
			
			while($data=$result->fetch_object())
			{
				$i++;
				$row_num++;
				$class_name	= (($row_type%2) == 0) ? "even" : "odd";
				echo '
					<tr id="' . $data->property_type_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td class="widthAuto">' . functions::deformat_string($data->name) . '</td>
						<td class="alignCenter">
							<a href="manage_sub_category.php?id=' . $data->property_type_id . '"><img src="images/icon-campaign.png" alt="Manage Sub Category" title="Manage Sub Category" width="15" height="16" /></a>
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
					$urlQuery = 'manage_category.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_category.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='4' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
	
	public static function get_breadcrumbs($property_type_id, $client_side=false)
	{
		$property_type 		= new property_type($property_type_id);			
		if($client_side)
		{
			$bread_crumb[]			= "<a href='property_type.php'>Gallery</a>";
		}
		else
		{
			$bread_crumb[]			= "<a href='manage_category.php'>Gallery</a>";
			
		}
					
		$bread_crumb[]			= functions::deformat_string($property_type->name);
		
		if(count($bread_crumb)>0)
		{
			$bread_crumbs=join(" >> ",$bread_crumb);
		}
		return $bread_crumbs;
	}
	
	public function get_latest_property_type_list($property_type_category_id = 0, $max_limit)
	{
		$database			= new database();
		$property_type_array 	= array();
		$sql			= "SELECT * FROM property_type WHERE property_type_category_id='".$property_type_category_id."' ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$property_type_image_sql				= "SELECT * FROM property_type_image WHERE property_type_id='".$data->property_type_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$property_type_image_result				= $database->query($property_type_image_sql);				
				if ($property_type_image_result->num_rows > 0)
				{
					$property_type_image_data = $property_type_image_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_PORTFOLIO_IMAGE . 'thumb_' . $property_type_image_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_PORTFOLIO_IMAGE, PORTFOLIO_THUMB_WIDTH, PORTFOLIO_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_PORTFOLIO_IMAGE . 'thumb_' . $property_type_image_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>

<div class="sidebar">
	<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
		<h2><a href="property_type.php?cid=<?php echo $property_type_category_id; ?>&pid=<?php echo $data->property_type_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
		<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="property_type.php?cid=<?php echo $property_type_category_id; ?>&pid=<?php echo $data->property_type_id; ?>">Read More</a></p>
	</div>
</div>
<?php
			}
		}
	}
	
	public function get_property_type_list($property_type_category_id = 0)
	{
		$database			= new database();
		$property_type_array 	= array();
		$sql				= "SELECT * FROM property_type WHERE property_type_category_id='".$property_type_category_id."' ORDER BY added_date DESC";
		$result				= $database->query($sql);
		$num_rows			= $result->num_rows;
		if ($result->num_rows > 0)
		{
			$counter		= 0;
			$i				= 0;
			while($data = $result->fetch_object())
			{
				$i++;
				$property_type_image_sql	= "SELECT * FROM property_type_image WHERE property_type_id='".$data->property_type_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$property_type_image_result	= $database->query($property_type_image_sql);				
				if ($property_type_image_result->num_rows > 0)
				{
					$property_type_image_data = $property_type_image_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_PORTFOLIO_IMAGE . 'thumb_' . $property_type_image_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_PORTFOLIO_IMAGE, PORTFOLIO_THUMB_WIDTH, PORTFOLIO_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_PORTFOLIO_IMAGE . 'thumb_' . $property_type_image_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/gallery_image.png';
				}
				if($counter == 0)
				{
					echo '<div id="portfoilio_inner_bg">';	
				}
				?>
<div class="portfoilio_image_space"></div>
<div class="portfoilio_image_outer" style="cursor:pointer;" onclick="show_property_type_details('<?php echo $property_type_category_id; ?>', '<?php echo $data->property_type_id; ?>');"> <img src="<?php echo $thumb_image; ?>" width="132" height="127" />
	<div class="portfoilio_image_box"></div>
	<div class="portfoilio_image_title"><?php echo functions::deformat_string($data->name); ?></div>
</div>
<?php
				$counter++;
				
				if($counter == 5 || $i == $num_rows )
				{
					$counter=0;
					echo '<div class="portfoilio_image_space"></div>
				</div>';	
				}
			}
		}
	}
	
	public function get_property_type_all_list($property_type_category_id = 0)
	{
		$database			= new database();
		$property_type_array 	= array();
		$sql				= "SELECT * FROM property_type WHERE property_type_category_id='".$property_type_category_id."' ORDER BY added_date DESC LIMIT 0, 5";
		$result				= $database->query($sql);
		$num_rows			= $result->num_rows;
		if ($result->num_rows > 0)
		{
			$counter		= 0;
			$i				= 0;
			while($data = $result->fetch_object())
			{
				$i++;
				$property_type_image_sql	= "SELECT * FROM property_type_image WHERE property_type_id='".$data->property_type_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$property_type_image_result	= $database->query($property_type_image_sql);				
				if ($property_type_image_result->num_rows > 0)
				{
					$property_type_image_data = $property_type_image_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_PORTFOLIO_IMAGE . 'thumb_' . $property_type_image_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_PORTFOLIO_IMAGE, PORTFOLIO_THUMB_WIDTH, PORTFOLIO_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_PORTFOLIO_IMAGE . 'thumb_' . $property_type_image_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/gallery_image.png';
				}
				?>
<div class="portfoilio_image_space"></div>
<div class="portfoilio_image_outer" style="cursor:pointer;" onclick="select_property_type_details('<?php echo $property_type_category_id; ?>', '<?php echo $data->property_type_id; ?>');">
	<div class="portfoilio_image_box"><img src="<?php echo $thumb_image; ?>" width="132" height="127" /></div>
	<div class="portfoilio_image_title"><?php echo functions::deformat_string($data->name); ?></div>
</div>
<?php
				$counter++;
			}
		}
	}
	
	public function get_latest_property_type_by_category_list($max_limit)
	{
		$database			= new database();
		$property_type_array 	= array();
		$sql			= "SELECT * FROM property_type GROUP BY property_type_category_id ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$property_type_image_sql				= "SELECT * FROM property_type_image WHERE property_type_id='".$data->property_type_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$property_type_image_result				= $database->query($property_type_image_sql);				
				if ($property_type_image_result->num_rows > 0)
				{
					$property_type_image_data = $property_type_image_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_PORTFOLIO_IMAGE . 'thumb_' . $property_type_image_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_PORTFOLIO_IMAGE, PORTFOLIO_THUMB_WIDTH, PORTFOLIO_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_PORTFOLIO_IMAGE . 'thumb_' . $property_type_image_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
<div class="sidebar">
	<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
		<h2><a href="property_type.php?cid=<?php echo $data->property_type_category_id; ?>&pid=<?php echo $data->property_type_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
		<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="property_type.php?cid=<?php echo $property_type_category_id; ?>&pid=<?php echo $data->property_type_id; ?>">Read More</a></p>
	</div>
</div>
<?php
			}
		}
	}
	
	
	
	
	public function display_sub_list()
	{
		$database				= new database();
		$validation				= new validation(); 
		$param_array			= array();
		$sql 					= "SELECT * FROM property_type";
		$drag_drop 				= '';
		$search_condition		= '';
		$search_cond_array[]	= " parent_id = '$this->parent_id' ";	
		$param_array[]			= "parent_id=" . $this->parent_id;
		
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
					$search_cond_array[]	= " name like '%" . $database->real_escape_string($search_word) . "%' ";	
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
		$sql 			= $sql . " ORDER BY name ASC";
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
				<td colspan="4"  class="noBorder">
					<input type="hidden" id="show"  name="show" value="0" />
					<input type="hidden" id="show_property_type_id" name="show_property_type_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					<input type="hidden" id="page" name="page" value="' . $page . '" />
					<input type="hidden" id="parent_id" name="parent_id" value="' .$this->parent_id . '" />
				</td>
			</tr>';
			
			while($data=$result->fetch_object())
			{
				$i++;
				$row_num++;
				$class_name		= (($row_type%2) == 0) ? "even" : "odd";
				
				$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
				$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
				
				echo '
					<tr id="' . $data->property_type_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td class="widthAuto">' . functions::deformat_string( $data->name) . '</td>
						<td class="alignCenter">
							<a title="Click here to update status" class="handCursor" onclick="javascript: change_category_status(\'' . $data->property_type_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a>
						</td>
						<td class="alignCenter">
							<a href="register_sub_category.php?id=' . $data->parent_id . '&property_type_id=' . $data->property_type_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>
						<td class="alignCenter deleteCol">
							<label><input type="checkbox" name="checkbox[' . $data->property_type_id . ']" id="checkbox" /></label>
						</td>	
					</tr>
					 <tr id="details'.$i.'" class="expandRow" >
								<td id="details_div_'.$i.'" colspan="6" height="1" ></td>
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
					$urlQuery = 'manage_category.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_category.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='4' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
	
	public static function get_parent_category($property_type_id)
	{
		$database			= new database();
		$category_options 	= array();
		$sql				= "SELECT * FROM property_type  where property_type_id='".$property_type_id."' ORDER BY name ASC";
		//echo $sql;
		$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data=$result->fetch_object();
				return $data->parent_id;
		
			}
	}
	
	
	
	public static function check_parent_sub($property_type_id)
	{
		$database			= new database();
		$category_options 	= array();
		$sql				= "SELECT * FROM property_type  where property_type_id='".$property_type_id."' ORDER BY name ASC";
		$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data=$result->fetch_object();
				if($data->parent_id==0)
				{
				$sql1				="SELECT GROUP_CONCAT(property_type_id SEPARATOR ',' ) AS property_type_ids FROM property_type WHERE parent_id = '".$data->property_type_id."'";
				//echo $sql1;
				$result1				= $database->query($sql1);
				if ($result1->num_rows > 0)
				  {
					  $data1=$result1->fetch_object();
					  return $data1->property_type_ids;
				  }
				  else
				  {
					  return $property_type_id;
				  }
				}
				else
				{
					return $property_type_id;
				}
			}
		
	}
	
	
		
}
?>
