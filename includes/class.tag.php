<?php
/*********************************************************************************************
Author 	: V V VIJESH
Date	: 14-April-2011
Purpose	: Case Studies class
*********************************************************************************************/
class tag
{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';
	
	function __construct($tag_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		
		if($tag_id > 0)
		{
			$this->initialize($tag_id);
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
	private function initialize($tag_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM tag WHERE tag_id = '$tag_id'";
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
		if(!$this->check_tag_exist($this->name, $this->_properties['tag_id']))
		{
			if ( isset($this->_properties['tag_id']) && $this->_properties['tag_id'] > 0) 
			{
				$sql	= "UPDATE tag SET name = '". $database->real_escape_string($this->name)  ."', status = '". $database->real_escape_string($this->status)  ."' WHERE tag_id = '$this->tag_id'";
			}
			else 
			{
				$order_id	= self::get_max_order_id() + 1;
				$sql		= "INSERT INTO tag 
							( name,   order_id, status) 
							VALUES ('" . $database->real_escape_string($this->name) . "',
														   '".$order_id."', 
							   '" . $database->real_escape_string($this->status) . "'
							    )";
			}
			//print $sql; exit;
			$result			= $database->query($sql);
			
			if($database->affected_rows == 1)
			{
				if($this->tag_id == 0)
				{
					$this->tag_id	= $database->insert_id;
				}
				$this->initialize($this->tag_id);
			}
		
			$this->message = cnst11;
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	//The function check the tag name eixst or not
	public function check_tag_exist($name='', $tag_id=0)
	{
		$output		= false;
		$database	= new database();
		if($name == '')
		{
			$this->message	= "  tag name should not be empty";
			$this->warning	= true;
		}
		else
		{
			if($tag_id > 0)
			{
				$sql	= "SELECT *	 FROM tag WHERE name = '" . $database->real_escape_string($name) . "' AND tag_id != '" . $tag_id . "'";
			}
			else
			{
				$sql	= "SELECT *	 FROM tag WHERE name = '" . $database->real_escape_string($name) . "'";
			}
			//print $sql;
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$this->message	= " tag name is already exists";
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
		if ( isset($this->_properties['tag_id']) && $this->_properties['tag_id'] > 0) 
		{
			$sql = "DELETE FROM tag WHERE tag_id = '" . $this->tag_id . "'";
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
	public function remove_selected($tag_ids)
	{
		$database	= new database();
		if(count($tag_ids)>0)
		{		
			foreach($tag_ids as $tag_id)
			{
								
					$sql="DELETE FROM wineries_link  WHERE tag_id = '" . $tag_id . "'";
					$result1 	= $database->query($sql);
										
					$sql = "DELETE FROM tag  WHERE tag_id = '" . $tag_id . "'";
					
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
	
	public static function get_tag_options()
	{
		$database			= new database();
		$tag_options 	= array();
		$sql				= "SELECT * FROM tag ORDER BY name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$tag_array = array();
			while($data = $result->fetch_object())
			{
				$tag_options[$data->tag_id]	= $data->name;
			}
		}
		return $tag_options;
	}
	
	public static function get_distinct_tag_options($tag_id)
	{
		$database			= new database();
		$tag_options 	= array();
		$sql				= "SELECT DISTINCT tag.*
														FROM tag LEFT JOIN club ON tag.tag_id = club.tag_id
														WHERE (club.club_id IS NULL
														OR tag.tag_id NOT IN (club.tag_id) 
														OR tag.tag_id IN ('$tag_id'))
														AND tag.status='Y'   
														ORDER BY tag.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$tag_array = array();
			while($data = $result->fetch_object())
			{
				$tag_options[$data->tag_id]	= $data->name;
			}
		}
		return $tag_options;
	}
	
	public static function get_distinct_tag_member_options($member_id)
	{
		$database			= new database();
		$tag_options 	= array();
		$sql				= "SELECT DISTINCT tag.*

														FROM tag

														LEFT JOIN member ON tag.name = member.tag

														WHERE (member.member_id IS NULL

														OR tag.name NOT IN (member.tag) 

														OR tag.name IN ('$member_id'))

														AND tag.status='Y'   

														ORDER BY tag.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$tag_array = array();
			while($data = $result->fetch_object())
			{
				$tag_options[$data->tag_id]	= $data->name;
			}
		}
		return $tag_options;
	}
	
	public static function get_tag_list()
	{
		$database			= new database();
		$tag_options 	= array();
		$sql				= "SELECT DISTINCT bc.tag_id, bc.name FROM tag as bc LEFT JOIN image as b on b.tag_id = b.tag_id ORDER BY bc.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$tag_array = array();
			while($data = $result->fetch_object())
			{
				$tag_array['tag_id'] = $data->tag_id;
				$tag_array['name']	= $data->name;
				$tag_options[]	= $tag_array;
			}
		}
		return $tag_options;
	}
	
	public static function get_listing_id()
	{
		$database			= new database();
		$listing_id_array 	= array();
		$sql						= "SELECT listing_id FROM tag  ORDER BY listing_id ASC";
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
	
	public static function get_next_id($tag_id)
	{
		$database				= new database();
		$next_tag_id	= 0;
		 $sql					= "SELECT tag_id FROM tag WHERE tag_id < '$tag_id' ORDER BY tag_date DESC LIMIT 0, 1";
		//echo $sql;
		$result					= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$data 					= $result->fetch_object();
			$next_tag_id	= $data->tag_id;
		}
		return $next_tag_id;
	}
	
	public function get_tag_of_month()
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM tag WHERE tag_of_month = 'Y' LIMIT 0, 1";
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
		$sql 					= "SELECT * FROM tag  ";
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
					$search_cond_array[]	= " name like '%" . $database->real_escape_string($search_word) . "%' ";	
				}
			}
			// Drag and dorp ordering is not available in search
			//$drag_drop 						= ' nodrag nodrop ';
		}
		
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
				
		$sql			.= $search_condition;
		$sql 			= $sql . " ORDER BY order_id ASC ";
		
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
					<input type="hidden" id="tag_id" name="tag_id" value="0" />
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
				$tag_of_month	= $data->tag_of_month == 'Y' ? '<img src="images/icon-active.png">' : '';
				
				echo '
					<tr id="' . $data->tag_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td  class="widthAuto">' . functions::deformat_string($data->name) . '</td>
						<td class="alignCenter joiningDateCol"><a title="Click here to update status" class="handCursor" onclick="javascript: change_tag_status(\'' . $data->tag_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a></td>
						<td class="alignCenter">
							<a href="register_tag.php?tag_id=' . $data->tag_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>
						<td class="alignCenter deleteCol">
							<!--<label><input type="checkbox" name="checkbox[' . $data->tag_id . ']" id="checkbox" /></label>-->
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
					$urlQuery = 'manage_tag.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_tag.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='7' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
	
	public static function get_breadcrumbs($tag_id, $client_side=false)
	{
		$tag 		= new tag($tag_id);			
		if($client_side)
		{
			$bread_crumb[]			= "<a href='tag.php'>Gallery</a>";
		}
		else
		{
			$bread_crumb[]			= "<a href='manage_tag.php'>Gallery</a>";
			
		}
					
		$bread_crumb[]			= functions::deformat_string($tag->name);
		
		if(count($bread_crumb)>0)
		{
			$bread_crumbs=join(" >> ",$bread_crumb);
		}
		return $bread_crumbs;
	}
	
	public function get_latest_tag_list($tag_tag_id = 0, $max_limit)
	{
		$database			= new database();
		$tag_array 	= array();
		$sql			= "SELECT * FROM tag WHERE tag_tag_id='".$tag_tag_id."' ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$tag_gallery_sql				= "SELECT * FROM tag_gallery WHERE tag_id='".$data->tag_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$tag_gallery_result				= $database->query($tag_gallery_sql);				
				if ($tag_gallery_result->num_rows > 0)
				{
					$tag_gallery_data = $tag_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_tag . 'thumb_' . $tag_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_tag, tag_THUMB_WIDTH, tag_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_tag . 'thumb_' . $tag_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
				<div class="sidebar">
					<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
						<h2><a href="tag.php?cid=<?php echo $tag_tag_id; ?>&pid=<?php echo $data->tag_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
						<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="tag.php?cid=<?php echo $tag_tag_id; ?>&pid=<?php echo $data->tag_id; ?>">Read More</a></p>
					</div>
				</div>
				<?php
			}
		}
	}
	
	/*
	public static function get_tag_list22()
	{
		$database			= new database();
		$sql				= "SELECT DISTINCT ic.* FROM tag as ic INNER JOIN tag_gallery as ig ON ic.tag_id = ig.tag_id ORDER BY ic.tag_id DESC";
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
						
						$tag1		= '';
						$tag2		= '';
						
						for($j = 0; $j <= $counter; $j++)
						{
							if($j < ceil($counter/2))
							{
								$tag1	.= $name[$j] . ' ';
							}
							else
							{
								$tag2	.= $name[$j] . ' ';
							}
						}
						echo '<h1>' . $tag1 . ' <span>' . $tag2 . '</span></h1>';
						?>
						<br />
						
						<?php
						$image_sql		= "SELECT * FROM tag_gallery WHERE tag_id='".$data->tag_id."' ORDER BY added_date DESC";
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
	
	public function get_tag_all_list($tag_tag_id = 0)
	{
		$database			= new database();
		$tag_array 	= array();
		$sql				= "SELECT * FROM tag WHERE tag_tag_id='".$tag_tag_id."' ORDER BY added_date DESC LIMIT 0, 5";
		$result				= $database->query($sql);
		$num_rows			= $result->num_rows;
		if ($result->num_rows > 0)
		{
			$counter		= 0;
			$i				= 0;
			while($data = $result->fetch_object())
			{
				$i++;
				$tag_gallery_sql	= "SELECT * FROM tag_gallery WHERE tag_id='".$data->tag_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$tag_gallery_result	= $database->query($tag_gallery_sql);				
				if ($tag_gallery_result->num_rows > 0)
				{
					$tag_gallery_data = $tag_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_tag . 'thumb_' . $tag_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_tag, tag_THUMB_WIDTH, tag_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_tag . 'thumb_' . $tag_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/gallery_image.png';
				}
				?>	
				<div class="portfoilio_image_space"></div>
				<div class="portfoilio_image_outer" style="cursor:pointer;" onclick="select_tag_details('<?php echo $tag_tag_id; ?>', '<?php echo $data->tag_id; ?>');">
					<div class="portfoilio_image_box"><img src="<?php echo $thumb_image; ?>" width="132" height="127" /></div>
					<div class="portfoilio_image_title"><?php echo functions::deformat_string($data->name); ?></div>
				</div>
				<?php
				$counter++;
			}
		}
	}
	
	public function get_latest_tag_by_tag_list($max_limit)
	{
		$database			= new database();
		$tag_array 	= array();
		$sql			= "SELECT * FROM tag GROUP BY tag_tag_id ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$tag_gallery_sql				= "SELECT * FROM tag_gallery WHERE tag_id='".$data->tag_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$tag_gallery_result				= $database->query($tag_gallery_sql);				
				if ($tag_gallery_result->num_rows > 0)
				{
					$tag_gallery_data = $tag_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_tag . 'thumb_' . $tag_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_tag, tag_THUMB_WIDTH, tag_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_tag . 'thumb_' . $tag_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
				<div class="sidebar">
					<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
						<h2><a href="tag.php?cid=<?php echo $data->tag_tag_id; ?>&pid=<?php echo $data->tag_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
						<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="tag.php?cid=<?php echo $tag_tag_id; ?>&pid=<?php echo $data->tag_id; ?>">Read More</a></p>
					</div>
				</div>
				<?php
			}
		}
	}
	
	public function get_tag_list_08_05_2013()
	{
		$database				= new database();
		$param_array			= array();
		$sql 					= "SELECT cs.* FROM tag AS cs ";
		
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
		
		//$sql 			= $sql . " ORDER BY tag_date DESC";		
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
				$tag_id=$data->tag_id;
				
				//$i++;
				//$thumb_image = tag_gallery::get_default_image($data->tag_id);
				
				
				$sql1="SELECT * FROM tag_gallery where tag_id= '".$tag_id."'";
			
						$result1	= $database->query($sql);
					//while($data=$result->fetch_object($result1))
					//{
				
				?>
              
                <?php  //} ?>
                
         		      
                <?php if($i%1==0) { ?>        
                <div class="box">
                <div class="case-studies-no-dv"><div class="case-studies-no"> <?php echo functions::deformat_string($data->listing_id); ?></div></div>
                <div class="head">
                <a href="casestudy_details.php?cid=<?php echo $data->tag_id;?>"><span class="caption">
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
		public static function update_status($tag_id, $status = '')
		{		
			$database		= new database();
			$tag			= new tag($tag_id);
			//$current_status = $tag->status;
			if($status == '')
			{
				$status =  $tag->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE tag 
						SET status = '". $status . "'
						WHERE tag_id = '" . $tag_id . "'";
						
						
			$result 	= $database->query($sql);
			
			
			$sql		= "UPDATE wineries_link
						SET status = '". $status . "'
						WHERE tag_id = '" . $tag_id . "'";
						
						
			$result1 	= $database->query($sql);
			return $status;
		}	
	/*public function get_tag_list()
	{
		$raw_style			= array(
											0=>array(1,2,1,3,1,2),
											1=>array(2,1,2,1,2,1),
											2=>array(1,2,1,2,1,3),
											3=>array(2,1,3,1,2,1)
											);
		$tag_array	= array();
		
		$database			= new database();
		$param_array		= array();
		$search_condition	= '';
		$sql 						= "SELECT * FROM tag";
		$sql						.= $search_condition;
		$sql 						= $sql . " ORDER BY listing_id ASC ";
		$result					= $database->query($sql);
		$this->num_rows = $result->num_rows;
		functions::paginate_tag($this->num_rows, 0, 0, 'CLIENT');
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
				$tag_array[$i] = array($data->tag_id, $data->listing_id, $data->name,$data->description);
				$i++;
			}
		}
		
		$count			= 0;
		$total_item	= count($tag_array);
		if ($total_item > 0)
		{
			if(count($tag_array) > 0 && count($tag_array) <=3)
			{
				$rows = 1;
			}
			else if(count($tag_array) > 3 && count($tag_array) <= 6)
			{
				$rows = 2;
			}
			else if(count($tag_array) > 6 && count($tag_array) <= 9)
			{
				$rows = 3;
			}
			else if(count($tag_array) > 9 && count($tag_array) <= 12)
			{
				$rows = 4;
			}
			
			$image_array	= tag_gallery::get_random_images();
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
						<div class="case-studies-no-dv"><div class="case-studies-no"><?php echo $tag_array[$count][1]; ?></div></div>
						<div class="head">
						<a href="casestudy_details.php?cid=<?php echo $tag_array[$count][0]; ?>"><span class="caption">
						<h4><?php //echo $tag_array[$count][1]; 
						echo  functions::get_sub_string(functions::deformat_string($tag_array[$count][2]),8,true);?></h4>
						<h5><?php echo functions::get_sub_string(functions::deformat_string($tag_array[$count][3]),90,true);; ?></h5></span></a>
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
							echo '<img src="' .  URI_tag . 'thumb_' .  $image_array[$image_count] . '" />';
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
	
	public function getBasetag($parent_id){
		$database			= new database();		
		$sql				= "SELECT * FROM tag WHERE parent_id = '0' ORDER BY name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($parent_id == $data->tag_id)
					echo '<option value="'.$data->tag_id.'" selected="selected">'.$data->name.'</option>';
				else
					echo '<option value="'.$data->tag_id.'">'.$data->name.'</option>';	
					
				//to display sub acategories
				$sql				= "SELECT * FROM tag WHERE parent_id = '".$data->tag_id."' ORDER BY name ASC";
				$result1				= $database->query($sql);		
				if ($result1->num_rows > 0)
				{
					while($data1 = $result1->fetch_object())
					{
						if ($parent_id == $data1->tag_id)
							echo '<option value="'.$data1->tag_id.'" style="padding-left:2em" selected="selected"> >> '.$data1->name.'</option>';
						else
							echo '<option value="'.$data1->tag_id.'" style="padding-left:2em"> >> '.$data1->name.'</option>';	
					}
				}			
						
			}
		}
		return;
	}
	
	public function productsExists($parent_id){
		$flag = '0';
		$database			= new database();		
		$sql				= "SELECT * FROM tag  WHERE parent_id = '$parent_id' AND status = 'Y' ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$sql 		= "SELECT * FROM product p LEFT JOIN product_gallery g ON p.product_id = g.product_id AND g.valid_image = 'Y'  
							   WHERE p.tag_id = '".$data->tag_id."' AND p.status = 'Y'  ";
				$result1	= $database->query($sql);		
				if ($result1->num_rows > 0)
				{
					$flag = '1';
				}
			}
		}
		return $flag;
	}
	
	public function displayToptagMenu(){
		$database			= new database();
		
		//to find categories with products
		$catid_arr  	= array();
		$catid_arr[]	= '0'; 
		$str_id     	= ''; 
		$sql			= "SELECT * FROM tag  WHERE parent_id = '0' AND status = 'Y' ORDER BY tag_id ASC";
		$result			= $database->query($sql);				
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($this->productsExists($data->tag_id) > 0){
					$catid_arr[] = $data->tag_id;					
				}
			}				
			$str_id     = implode (",",$catid_arr);	
		}			
				
		//$sql				= "SELECT * FROM tag  WHERE parent_id = '0' ORDER BY tag_id ASC";
		$sql				= "SELECT * FROM tag  WHERE tag_id IN (".$str_id.") AND status = 'Y' ORDER BY tag_id ASC";
		$result				= $database->query($sql);				
		if ($result->num_rows > 0)
		{
			echo '	
				<div id="menu">
					<ul>';
					
			$main_cat_cnt = '1';		
			while($data = $result->fetch_object())
			{
				//if ($this->productsExists($data->tag_id) > 0){
					//echo $result->num_rows.' == '.$main_cat_cnt;
					if ($result->num_rows == $main_cat_cnt)
						$class_main_last = 'class="last_item menu_item down"';
					else
						$class_main_last = 'class="menu_item down"';
				
					echo '<li '.$class_main_last.'><a href="tag.php?cid='.$data->tag_id.'">'.$data->name.'</a>';
					
					$sql 		= "SELECT * FROM tag c 
								   INNER JOIN product p ON c.tag_id = p.tag_id
								   LEFT JOIN product_gallery g ON p.product_id = g.product_id AND g.valid_image = 'Y'  
								   WHERE c.parent_id = '".$data->tag_id."' AND c.status = 'Y' AND p.status = 'Y'  
								   GROUP BY c.tag_id
								   ORDER BY c.tag_id ASC";
								   
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
								
								/*$sql 		= "SELECT * FROM product WHERE tag_id = '".$data1->tag_id."' AND status = 'Y' ";
								$result3	= $database->query($sql);		
								if ($result3->num_rows > 0)
								{*/		
						
								echo '<li><a href="tag.php?cid='.$data1->tag_id.'">'.$data1->name.'</a></li>';
								
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
	
	public function getSubtagIdList($tag_id){
		$database	= new database();
		
		//newly added
		$catid_arr  = array();
		$catid_arr[]= '0'; 
		$sql		= "SELECT * FROM tag WHERE parent_id = '".$tag_id."' AND status = 'Y' ORDER BY tag_id ASC";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{				
				$catid_arr[] = $data->tag_id;					
			}
		}				
		$str_id     = implode (",",$catid_arr);	
		return $str_id;
	}
	
	public function getParentCategId($cid){
		$database	= new database();
		$sql		= "SELECT * FROM tag WHERE tag_id = '".$cid."' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$data = $result->fetch_object();
		}
		return $data->parent_id;	
	}	
	
	public function getBasetagListWithProducts(){
		$database	= new database();
		$baseCatListArr = array();
		$sql		= "SELECT * FROM tag WHERE parent_id = '0' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->tag_id;
						
				$sql1		= "SELECT * FROM tag WHERE parent_id = '".$data->tag_id."'AND status = 'Y' ";
				$result1	= $database->query($sql1);		
				if ($result1->num_rows > 0)
				{			
					while ($data1 = $result1->fetch_object()){
						$catIdListArray[] = $data1->tag_id;
						$sql2		= "SELECT * FROM tag WHERE parent_id = '".$data->tag_id."' AND status = 'Y' ";
						$result2	= $database->query($sql2);		
						if ($result2->num_rows > 0)
						{			
							while ($data2 = $result2->fetch_object()){
								$catIdListArray[] = $data2->tag_id;
							}
						}
					}
				}
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE tag_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->tag_id;
					 					
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
	
	public function getSubtagListWithProducts($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM tag WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->tag_id;
						
				$sql1		= "SELECT * FROM tag WHERE parent_id = '".$data->tag_id."' AND status = 'Y' ";
				$result1	= $database->query($sql1);		
				if ($result1->num_rows > 0)
				{			
					while ($data1 = $result1->fetch_object()){
						$catIdListArray[] = $data1->tag_id;						
					}
				}
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE tag_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->tag_id;
					 					
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
	
	public function subArrowSubtag($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM tag WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->tag_id;
						
				$sql1		= "SELECT * FROM tag WHERE parent_id = '".$data->tag_id."' AND status = 'Y' ";
				$result1	= $database->query($sql1);		
				if ($result1->num_rows > 0)
				{			
					while ($data1 = $result1->fetch_object()){
						$catIdListArray[] = $data1->tag_id;						
					}
				}
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE tag_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->tag_id;
					 					
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
	
	public function getSubSubtagListWithProducts($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM tag WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->tag_id;
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE tag_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->tag_id;
					 					
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
	
	public function subArrowSubSubtag($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM tag WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->tag_id;
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE tag_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->tag_id;
					 					
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
	
	public function gettagDropMenuList(){
		$database			= new database();
		$baseCatIdList 		= $this->getBasetagListWithProducts();
		$baseCatIdListStr 	= implode(",",$baseCatIdList);
		$sql			= "SELECT * FROM tag WHERE tag_id IN (".$baseCatIdListStr.") AND parent_id = '0' AND status = 'Y' ORDER BY order_id ";
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
				  
				  		//to display subtag list
				  		$subCatIdList 	= $this->getSubtagListWithProducts($data->tag_id);
						$sql1			= "SELECT * FROM tag WHERE tag_id IN (".implode(",",$subCatIdList).") AND parent_id = '".$data->tag_id."' AND status = 'Y' ORDER BY order_id ";
						$result1		= $database->query($sql1);
						
						$sql4		= "SELECT * FROM product WHERE tag_id = '".$data->tag_id."' AND status = 'Y' ORDER BY order_id ";
						$result4	= $database->query($sql4);
														
						if ($result1->num_rows > 0 or $result4->num_rows > 0){
					   		echo '
					  		<div class="product-list">';
						
					   			while ($data1 = $result1->fetch_object()){
					   				
									//to check whether sub arrow
									$subArrowneeded = $this->subArrowSubtag($data1->tag_id);										
									$arrowClass 	= ($subArrowneeded == '1') ? 'pro_arrow' : '';
									//end to check whether sub arrow									
									
									echo '
									<li class="'.$arrowClass.'">
										<a href="#">'.functions::deformat_string($data1->name).'</a>';
							
										$subSubCatIdList 	= $this->getSubSubtagListWithProducts($data1->tag_id);
										$sql2				= "SELECT * FROM tag WHERE tag_id IN (".implode(",",$subSubCatIdList).") AND parent_id = '".$data1->tag_id."' AND status = 'Y' ORDER BY order_id ";
										$result2			= $database->query($sql2);	
										
										$sql5		= "SELECT * FROM product WHERE tag_id = '".$data1->tag_id."' AND status = 'Y' ORDER BY order_id ";
										$result5	= $database->query($sql5);
																					
										if ($result2->num_rows > 0 or $result5->num_rows > 0){
															
											echo  '
											<ul>';
											
											//to display sub sub tag
											while ($data2 = $result2->fetch_object()){
											
												//to check whether sub arrow
												$subSubArrowneeded 	= $this->subArrowSubSubtag($data2->tag_id);										
												$arrowClass1 		= ($subSubArrowneeded == '1') ? 'pro_arrow' : '';
												//end to check whether sub arrow											
											
												echo '
												<li class="'.$arrowClass1.'">
													<a href="#">'.functions::deformat_string($data2->name).'</a>';
													
													//display sub sub tag products
													$sql3		= "SELECT * FROM product WHERE tag_id = '".$data2->tag_id."' AND status = 'Y' ORDER BY order_id ";
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
											//end of sub sub tag
											
											//display sub tag products													
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
								
								//display main tag products										
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
						//end to display subtag list
						  
				  
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
	
	public function getlefttagMenu($pid){
	
		$product 		= new product($pid);
		$tag_id 	= $product->tag_id; 
		$selcat_flag 	= '0';
		
		if ($tag_id > 0){
			$tag 		= new tag($tag_id);
			if ($tag->parent_id > 0){
				$sub_tag = new tag($tag->parent_id);
				if ($sub_tag->parent_id > 0){
					$sub_sub_tag = new tag($sub_tag->parent_id);
					
					$main_cat_id 	= $sub_sub_tag->tag_id;
					$sub_cat_id	 	= $sub_tag->tag_id;
					$sub_sub_cat_id	= $tag_id;
												
				}else{
					$main_cat_id = $sub_tag->tag_id;
					$sub_cat_id	 = $tag_id;
				}
				
			}else{
				$main_cat_id = $tag_id;
			}
		}
		
		if ($main_cat_id > 0){
		
			$disp_main_tag = new tag($main_cat_id);
		
			echo '
			  <div class="product-detail_first">
				<div class="pro_hdr">'.functions::deformat_string($disp_main_tag->name).'</div>
				<div class="product-list">
				  <ul id="example1">';
			  
			$database	= new database();
				
			//$sql		= "SELECT * FROM tag WHERE parent_id = '".$main_cat_id."' AND status = 'Y' ";
			//$result		= $database->query($sql);
			
			$subCatIdList 	= $this->getSubtagListWithProducts($main_cat_id);
			$sql			= "SELECT * FROM tag WHERE tag_id IN (".implode(",",$subCatIdList).") AND parent_id = '".$main_cat_id."' AND status = 'Y' ORDER BY order_id ASC ";
			$result			= $database->query($sql);
					
			if ($result->num_rows > 0)
			{			
				while ($data = $result->fetch_object()){
				  
				   echo    '<li><a href="#">'.functions::deformat_string($data->name).'</a>';
				   
				   //$sql1	= "SELECT * FROM tag WHERE parent_id = '".$data->tag_id."' AND status = 'Y' ";
				   //$result1	= $database->query($sql1);
				   
				   $subSubCatIdList = $this->getSubSubtagListWithProducts($data->tag_id);
				   $sql1			= "SELECT * FROM tag WHERE tag_id IN (".implode(",",$subSubCatIdList).") AND parent_id = '".$data->tag_id."' AND status = 'Y' ORDER BY order_id ASC ";
				   $result1			= $database->query($sql1);	
														   		
				   if ($result1->num_rows > 0)
				   {
						if ($sub_cat_id == $data->tag_id){
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
		  //onMouseOver="javascript: disable_seltag();"
		  //store selected tag
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
	
	public function getHometagMenuList(){
		$database		= new database();
		$functions 			= new functions();
		
		$baseCatIdList 	= $this->getBasetagListWithProducts();
		$sql			= "SELECT * FROM tag WHERE tag_id IN (".implode(",",$baseCatIdList).") AND parent_id = '0' AND status = 'Y' ORDER BY rand() LIMIT 0,3 ";
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
								  
					//to display subtag list
					$subCatIdList 	= $this->getSubtagListWithProducts($data->tag_id);
					$sql1			= "SELECT * FROM tag WHERE tag_id IN (".implode(",",$subCatIdList).") AND parent_id = '".$data->tag_id."' AND status = 'Y' ORDER BY order_id ASC ";
					$result1		= $database->query($sql1);
					
					$sql4		= "SELECT * FROM product WHERE tag_id IN (".implode(",",$subCatIdList).") AND status = 'Y' ORDER BY rand() LIMIT 0,1 ";
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
						
						
						$sql5		= "SELECT * FROM product WHERE tag_id = '".$data->tag_id."' AND status = 'Y' ORDER BY order_id ASC ";
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
								
								//display main tag products																																										   									
								while ($data5 = $result5->fetch_object()){
									echo '
									<li>'.functions::deformat_string($data5->product_name).'</li>';
								}														
								//end of products
						
							echo '</ul>
							</div>
							<div class="readmore"><a href="product.php?pid='.$data4->product_id.'">Read More</a></div>';		  
						}
						//end to display subtag list
						  
				  
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
		$sql		= "SELECT MAX(order_id) AS order_id FROM tag WHERE 1 ";
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
			$sql = "UPDATE tag SET order_id = '" . $order_id . "' WHERE tag_id = '" . $id_array[$i] . "'";
			//echo $sql;
			$database->query($sql);
			$order_id++;
		}
	}
	
	public function gettagBreadCrumb($tag_id){
		//$database		= new database();
		//$functions 	= new functions();
		$cat_array      = array();
		$tag1      = new tag($tag_id);
				
		if ($tag1->name != ''){		
			$cat_array[] = $tag1->name;	
			if ($tag1->parent_id > 0){
				$tag2      = new tag($tag1->parent_id);	
				if ($tag2->name != ''){				
					$cat_array[] = $tag2->name;	
					if ($tag2->parent_id > 0){
						$tag3      = new tag($tag2->parent_id);	
						$cat_array[]    = $tag3->name;			
					}
				}
			}
		}
		$cat_array = array_reverse($cat_array);
		return implode(" >> ",$cat_array);
	}
		

	public function get_tag($id=0)
		{
			$database		= new database();
			if($id>0)
			{
				 $sql="	SELECT p.*
 						FROM tag p INNER JOIN wineries_link l ON p.tag_id = l.tag_id order by order_id";	
					
			}else
			{
			 $sql 			= "SELECT * FROM tag  order by order_id ";
			}
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
				{
					$array = array();
					while($data = $result->fetch_object())
					{
						$array['tag_id'] = $data->tag_id;
						$array['name']	= $data->name;
						$tag []	= $array;
					}
				}
				return $tag;
		
	
			
		}
		
		
		public function get_tag_userside()
		{
			$database		= new database();
		//	$sql 			= "SELECT * FROM tag  WHERE status='Y' order by order_id ";
			$sql 			= "SELECT DISTINCT b . *
			FROM tag b
			INNER JOIN wineries a ON FIND_IN_SET( b.`tag_id` , a.tag )
			WHERE b.status = 'Y'
			AND a.status = 'Y' order by b.order_id ";
			$tag  = array();
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
				{
					$array = array();
					while($data = $result->fetch_object())
					{
						$tag []	= $data;
					}
				}
				return $tag;
		
	
			
		}
		
		
		//Menu Top
		
		public static function get_top_menu($page_name ='', $page_id= '', $responsive=false)
		{
			$page_id = str_replace('/','', $page_id);
			$database		= new database();
			
			$sql 			= "SELECT * FROM tag WHERE status='Y' AND tag_id!=1 ORDER BY order_id ASC";
			$result			= $database->query($sql);	
			
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{ 
					if($responsive)
					{
						?>
                        <a href="<?php echo URI_ROOT .'tag/'. strtolower(functions::deformat_string($data->name)) ?>"><li><?php echo functions::deformat_string($data->name) ?></li></a>
                        <?php
					}
					else
					{
						if($data->tag_id == 10) {
						 ?>
                         	<a style="cursor:pointer;" id="bachelorparty_btn" class="big-link" data-reveal-id="bachelorparty"  data-animation="fadeAndPop">
                         
                         <?php } else if($data->tag_id == 2) { ?>
                         	<a style="cursor:pointer;" id="wedding_btn" class="big-link" data-reveal-id="bachelorparty" data-animation="fadeAndPop">
                         <?php } else {
						 ?>
                			<a href="<?php echo URI_ROOT.'tag/'. strtolower(functions::deformat_string($data->name)) ?>">
                        <?php } ?>
                        
							<li <?php echo ($page_name =='tag.php' && $page_id == strtolower(functions::deformat_string($data->name))) ? 'class="active"' : ''; ?>><?php echo functions::deformat_string($data->name) ?>
                            
                            
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
			
			$sql 			= "SELECT * FROM tag WHERE status='Y' ORDER BY order_id ASC";
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
		
		public static function get_tag_id_byname($name= '')
		{
			$database		= new database();
			$sql 			= "SELECT tag_id FROM tag WHERE name='$name'";
			
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data = $result->fetch_object();
				return $data->tag_id;
			}
			else
			{
				return 0;
			}
		}
		
		public static function get_content_tag($content_id =0)
		{
			$output 		= array();
			$database		= new database();
			$sql 			= "SELECT tag_id FROM content_tag WHERE content_id='$content_id' ORDER BY content_tag_id ASC";
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					$sql1				= "SELECT * FROM tag WHERE tag_id='". $data->tag_id."' ORDER BY tag_id ASC";
					$result1			= $database->query($sql1);
					while($data1 = $result1->fetch_object())
					{
						$output[] = $data1;	
					}
				}
			}
			
			return $output;
		}
		
    }
?>