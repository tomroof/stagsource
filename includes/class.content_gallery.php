<?php
/*********************************************************************************************
Date	: 14-April-2011
Purpose	: Property gallery class
*********************************************************************************************/
class content_gallery
{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';

	function __construct($content_gallery_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		
		if($content_gallery_id > 0)
		{
			$this->initialize($content_gallery_id);
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
	private function initialize($content_gallery_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM content_gallery WHERE content_gallery_id = '$content_gallery_id'";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$this->_properties	= $result->fetch_assoc();
		}
	}

	// Save the Property gallery details
	public function save()
	{
		$database	= new database();
		if ( isset($this->_properties['content_gallery_id']) && $this->_properties['content_gallery_id'] > 0) 
		{
			$sql	= "UPDATE content_gallery SET  title = '". $database->real_escape_string($this->title)  ."', alt = '". $database->real_escape_string($this->alt)  ."', image_name = '". $database->real_escape_string($this->image_name)  ."', description = '".  $database->real_escape_string($this->description)  ."' WHERE content_gallery_id = '$this->content_gallery_id'";
		}
		else 
		{
			$order_id	= self::get_max_order_id() + 1;
			//$order_id	= self::get_default_image($content_id);
			$sql		= "INSERT INTO content_gallery 
						(content_id, title, alt, image_name, description, added_date, order_id, status) 
						VALUES (
								'" . $database->real_escape_string($this->content_id) . "',
								'" . $database->real_escape_string($this->title) . "',
								'" . $database->real_escape_string($this->alt) . "',
								'" . $database->real_escape_string($this->image_name) . "',
								'" . $database->real_escape_string($this->description) . "',
								NOW(),
								'" . $database->real_escape_string($order_id) . "',
								'Y'
								)";
		}
		//print $sql; 
		//exit;
		$result			= $database->query($sql);
		
		if($database->affected_rows == 1)
		{
			// $this->check_exists_in_temp_table($this->image_name);
			if($this->content_gallery_id == 0)
			{
				$this->content_gallery_id	= $database->insert_id;
				if($_SESSION['inserted_ids'] != '')
				{
				    $inserted_ids	= $_SESSION['inserted_ids']. ','. $database->insert_id;
				}
				else
				{
					$_SESSION['inserted_ids']	=  $database->insert_id;
				}
			}
			
			
			
			$this->initialize($this->content_gallery_id);
		}
	
		$this->message = cnst11;
		return true;
	}
	
	
	public static function image_resize_all($content_id = 0)
	{
		//$image_name=content_gallery::getcontent_gallery_image($content_id);			
		//$image_all_names=content_gallery::getcontent_gallery_image_all($content_id,$image_name,14);	
		
		
		
		if($image_name!="" && file_exists(DIR_CONTENT_GALLERY.$image_name))
		{
			$size_1	= getimagesize(DIR_CONTENT_GALLERY.$image_name);
			if(!file_exists(DIR_CONTENT_GALLERY.'resize_'.$image_name))
			{
				  $imageLib1 = new imageLib(DIR_CONTENT_GALLERY.$image_name);
				  if($size_1[0] >= 1440 && $size_1[1] >=  1080)
				  {
					  $imageLib1->resizeImage(1440, 1080, 0);
				  }
				  else if($size_1[0] >= 1440)
				  {
					  $imageLib1->resizeImage(1440, $size_1[1], 0);	
				  }
				  else if($size_1[1] >=  1080)
				  {
					  $imageLib1->resizeImage($size_1[0], 1080, 0);	
				  }
				  else
				  {
					  $imageLib1->resizeImage($size_1[0], $size_1[1], 0);
				  }
				  $imageLib1->saveImage(DIR_CONTENT_GALLERY.'resize_'.$image_name, 60); 
			}
			
			unset($imageLib1);
				  
			/*if(file_exists(DIR_CONTENT_GALLERY.'resize1_'.$image_name))
			{	
				unlink(DIR_CONTENT_GALLERY.'resize1_'.$image_name);
			}
			
			//$size_1	= getimagesize(DIR_CONTENT_GALLERY.$image_name);
			$imageLib1 = new imageLib(DIR_CONTENT_GALLERY.$image_name);*/
			/*if($size_1[0] >= 810 && $size_1[1] >=  543)
			{
				$imageLib1->resizeImage(810, 543, 0);
			}
			else if($size_1[0] >= 810)
			{
				$imageLib1->resizeImage(810, $size_1[1], 0);	
			}
			else if($size_1[1] >=  543)
			{
				$imageLib1->resizeImage($size_1[0], 543, 0);	
			}
			else
			{
				$imageLib1->resizeImage($size_1[0], $size_1[1], 0);
			}*/
			
			/*if($size_1[0] > $size_1[1])
			{   
				if($size_1[0] >= 810 && $size_1[1] >=  543)
				{
					$imageLib1->resizeImage(810, 543, 0);
				}
				else if($size_1[0] >= 810)
				{
					$imageLib1->resizeImage(810, $size_1[1], 0);	
				}
				else if($size_1[1] >=  543)
				{
					$imageLib1->resizeImage($size_1[0], 543, 0);	
				}
				else
				{
					$imageLib1->resizeImage($size_1[0], $size_1[1], 0);
				}
			}
			else if($size_1[0] < $size_1[1])
			{
				if($size_1[1] >= 810 && $size_1[0] >= 543)
				{
					$imageLib1->resizeImage(543,810, 0);
					$imageLib1->rotate(-90, 'transparent');
				}
				else if($size_1[1] >= 810)
				{
					$imageLib1->resizeImage($size_1[0],810, 0);
					$imageLib1->rotate(-90, 'transparent');
				}
				else if($size_1[0] >= 543)  
				{
					$imageLib1->resizeImage($size_1[1],543, 0);
				}	
				else
				{
					$imageLib1->resizeImage($size_1[0], $size_1[1], 0);	
				}
			}
			else
			{
				if($size_1[0] >= 810 && $size_1[1] >= 543)
				{
					$imageLib1->resizeImage(810,543, 0);
				}	
				else
				{
					$imageLib1->resizeImage($size_1[0], $size_1[1], 0);	
				}
			}*/
			
			
			
			//$imageLib->resizeImage(800, 423, 0);
			/*$imageLib1->saveImage(DIR_CONTENT_GALLERY.'resize1_'.$image_name, 75);
			
			unset($imageLib1);*/
			
		}
		
		//print_r($image_all_names);	
		
		for($i=0;$i<count($image_all_names);$i++)
		{
					
			$k=$i+1;
			
			if($image_all_names[$i] != '' && file_exists(DIR_CONTENT_GALLERY.$image_all_names[$i]))
			{
				$size_1	= getimagesize(DIR_CONTENT_GALLERY.$image_all_names[$i]);
				
								
				if(!file_exists(DIR_CONTENT_GALLERY.'resize_'.$image_all_names[$i]))
				{
					  $imageLib1 = new imageLib(DIR_CONTENT_GALLERY.$image_all_names[$i]);
					  if($size_1[0] >= 1440 && $size_1[1] >=  1080)
					  {
						  $imageLib1->resizeImage(1440, 1080, 0);
					  }
					  else if($size_1[0] >= 1440)
					  {
						  $imageLib1->resizeImage(1440, $size_1[1], 0);	
					  }
					  else if($size_1[1] >=  1080)
					  {
						  $imageLib1->resizeImage($size_1[0], 1080, 0);	
					  }
					  else
					  {
						  $imageLib1->resizeImage($size_1[0], $size_1[1], 0);
					  }
					  $imageLib1->saveImage(DIR_CONTENT_GALLERY.'resize_'.$image_all_names[$i], 60); 
				}
				unset($imageLib1);
				
				/*if(file_exists(DIR_CONTENT_GALLERY.'resize1_'.$image_all_names[$i]))
				{
					unlink(DIR_CONTENT_GALLERY.'resize1_'.$image_all_names[$i]);	
				}
				
				
				
				if($i == 0 || $i== 7 || $i == 10 || $i == 13)
				{
					
					$imageLib = new imageLib(DIR_CONTENT_GALLERY.$image_all_names[$i]);
			
					if($size_1[0] > $size_1[1])
					{   
						if($size_1[0] >= 1062 && $size_1[1] >= 742)
						{
							$imageLib->resizeImage(1062,742, 0);
							$imageLib->rotate(-90, 'transparent');
						}
						else if($size_1[0] >= 1062)
						{
							$imageLib->resizeImage(1062,$size_1[1], 0);
							$imageLib->rotate(-90, 'transparent');	
						}
						else if($size_1[0] >=  742)  
						{
							$imageLib->resizeImage(742,$size_1[1], 0);
						}
						else
						{
							$imageLib->resizeImage($size_1[0], $size_1[1], 0);
						}
					}
					else if($size_1[0] < $size_1[1])
					{
						if($size_1[0] >= 742 && $size_1[1] >= 1062)
						{
							$imageLib->resizeImage(742,1062, 0);
						}
						else if($size_1[0] >= 742)
						{
							$imageLib->resizeImage(742,$size_1[1], 0);
						}
						else if($size_1[1] >= 1062)  
						{
							$imageLib->resizeImage($size_1[0],1062, 0);
						}	
						else
						{
							$imageLib->resizeImage($size_1[0], $size_1[1], 0);	
						}
					}
					else
					{
						if($size_1[0] >= 742 && $size_1[1] >= 1062)
						{
							$imageLib->resizeImage(742,1062, 0);
						}	
						else
						{
							$imageLib->resizeImage($size_1[0], $size_1[1], 0);	
						}
					}
											
					
					$imageLib->saveImage(DIR_CONTENT_GALLERY.'resize1_'.$image_all_names[$i], 75);
					
													
				}
				else
				{*/
					/*//$size_1	= getimagesize(DIR_CONTENT_GALLERY.$image_all_names[$i]);
					$imageLib = new imageLib(DIR_CONTENT_GALLERY.$image_all_names[$i]);
					
					if($size_1[0] >= 742 && $size_1[1] >=  515)
					{
						$imageLib->resizeImage(742, 515, 0);
					}
					else if($size_1[0] >= 742)
					{
						$imageLib->resizeImage(742, $size_1[1], 0);	
					}
					else if($size_1[1] >=  515)
					{
						$imageLib->resizeImage($size_1[0], 515, 0);	
					}
					else
					{
						$imageLib->resizeImage($size_1[0], $size_1[1], 0);
					}*/
					
					
					/*$imageLib = new imageLib(DIR_CONTENT_GALLERY.$image_all_names[$i]);
			
					if($size_1[0] > $size_1[1])
					{   
						if($size_1[0] >= 742 && $size_1[1] >=  515)
						{
							$imageLib->resizeImage(742, 515, 0);
						}
						else if($size_1[0] >= 742)
						{
							$imageLib->resizeImage(742, $size_1[1], 0);	
						}
						else if($size_1[1] >=  515)
						{
							$imageLib->resizeImage($size_1[0], 515, 0);	
						}
						else
						{
							$imageLib->resizeImage($size_1[0], $size_1[1], 0);
						}
					}
					else if($size_1[0] < $size_1[1])
					{
						if($size_1[1] >= 742 && $size_1[0] >= 515)
						{
							$imageLib->resizeImage(515,742, 0);
							$imageLib->rotate(-90, 'transparent');
						}
						else if($size_1[1] >= 742)
						{
							$imageLib->resizeImage($size_1[0],742, 0);
							$imageLib->rotate(-90, 'transparent');
						}
						else if($size_1[0] >= 515)  
						{
							$imageLib->resizeImage($size_1[1],515, 0);
						}	
						else
						{
							$imageLib->resizeImage($size_1[0], $size_1[1], 0);	
						}
					}
					else
					{
						if($size_1[0] >= 742 && $size_1[1] >= 515)
						{
							$imageLib->resizeImage(742,515, 0);
						}	
						else
						{
							$imageLib->resizeImage($size_1[0], $size_1[1], 0);	
						}
					}
					
					
					$imageLib->saveImage(DIR_CONTENT_GALLERY.'resize1_'.$image_all_names[$i], 75);
				}*/
			}
			
			unset($imageLib);
									
		}
		
	}
	
	// Returns the max order id
	public static function get_max_order_id()
	{
		$database	= new database();
		$sql		= "SELECT MAX(order_id) AS order_id FROM content_gallery";
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
	
	public static function rename_image($content_id)
	{
		
		$database	= new database();
		$sql		= "SELECT * FROM content_gallery WHERE content_id = '$content_id'";
		$result		= $database->query($sql);
		while($data = $result->fetch_object())
		{
			$image_name = $data->image_name;
			$image1	= $image_name;
			
			$default = array(" ", "'", '"', '`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '', '+', '=', ';', ':', ',', '<', '>', '?', '/', '{',  '}', '[', ']');
		
			$image1	= str_replace($default, '_', $image1);	
			
			//$image1	= str_replace(' ', '_', $image1);
			//$image1	= str_replace(',', '_', $image1);
			
			if(file_exists(DIR_CONTENT_GALLERY.$image_name))
			{
				echo "here";
				rename(DIR_CONTENT_GALLERY.$image_name,DIR_CONTENT_GALLERY.$image1); 
			}
			if(file_exists(DIR_CONTENT_GALLERY.'resize_'.$image_name))
			{
				rename(DIR_CONTENT_GALLERY.'resize_'.$image_name,DIR_CONTENT_GALLERY.'resize_'.$image1); 
			}
			if(file_exists(DIR_CONTENT_GALLERY.'resize1_'.$image_name))
			{
				rename(DIR_CONTENT_GALLERY.'resize1_'.$image_name,DIR_CONTENT_GALLERY.'resize_'.$image1); 
			}
			
			if(file_exists(DIR_CONTENT_GALLERY.'thumb_'.$image_name))
			{
				rename(DIR_CONTENT_GALLERY.'thumb_'.$image_name,DIR_CONTENT_GALLERY.'thumb_'.$image1); 
			}
			
			
			if(file_exists(DIR_CONTENT_GALLERY.'thumbnail/'.$image_name))
			{
				rename(DIR_CONTENT_GALLERY.'thumbnail/'.$image_name,DIR_CONTENT_GALLERY.'thumbnail/'.$image1); 
			}
			
			if(file_exists(DIR_CONTENT_GALLERY.'thumbnail/thumbresize_'.$image_name))
			{
				rename(DIR_CONTENT_GALLERY.'thumbnail/thumbresize_'.$image_name,DIR_CONTENT_GALLERY.'thumbnail/thumbresize_'.$image1); 
			}
			
			$sql1	= "UPDATE content_gallery SET image_name ='". $image1."' WHERE content_gallery_id ='". $data->content_gallery_id."'";
			$result1 =$database->query($sql1);
			
		}
	}
	
	public function update_content_gallery_image_status($content_id){
		if($this->content_gallery_image=="Y"){
			$database		= new database();
			$sql = "UPDATE content_gallery SET content_gallery_image = 'N' WHERE content_id = '" . $content_id . "'";
				//echo $sql;
			$database->query($sql);
		}
	}
	
	// The function is used to change the status.
		public static function update_content_gallery_status($content_gallery_id, $status = '')
		{	
			$database	= new database();
			$content_gallery		= new content_gallery($content_gallery_id);
			//$current_status = $member->status;
			//echo $content_gallery->status;
			if($status == '')
			{
				$status =  $content_gallery->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE content_gallery 
						SET status = '". $status . "'
						WHERE content_gallery_id = " . $content_gallery_id . "";
		
			$result 	= $database->query($sql);
			return $status;
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
			$sql = "UPDATE content_gallery SET order_id = '" . $order_id . "' WHERE content_gallery_id = '" . $id_array[$i] . "'";
			//echo $sql;
			$database->query($sql);
			$order_id++;
		}
	}
	
	// Remove the current object details.
	public function remove()
	{
		$database	= new database();
		if ( isset($this->_properties['content_gallery_id']) && $this->_properties['content_gallery_id'] > 0) 
		{
			$sql = "DELETE FROM content_gallery WHERE content_gallery_id = '" . $this->content_gallery_id . "'";
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
	
	

	
	public static function remove_by_content($content_id)
	{
		$database	= new database();
		
		$sql		= "SELECT * FROM content_gallery WHERE content_id = '" . $content_id . "'";
		$result 	= $database->query($sql);
		while($data	= $result->fetch_object())
		{
			if(file_exists(DIR_CONTENT_GALLERY . $data->image_name))
			  {
				  unlink(DIR_CONTENT_GALLERY . $data->image_name);
			  }
			 	if(file_exists(DIR_CONTENT_GALLERY . 'thumb_' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumb_' . $data->image_name);
				}
			
			
				if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumbnail/' . $data->image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $data->image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumbresize_' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumbresize_' . $data->image_name);
				}
			
				if(file_exists(DIR_CONTENT_GALLERY . 'resize_' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'resize_' . $data->image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'resize1_' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'resize1_' . $data->image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumb1_' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumb1_' . $data->image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumb2_' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumb2_' . $data->image_name);
				}
				
				if(file_exists(DIR_CONTENT_GALLERY . 'thumb3_' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumb3_' . $data->image_name);
				}
		}
		
		$sql		= "DELETE FROM content_gallery WHERE content_id = '" . $content_id . "'";
		$result 	= $database->query($sql);
			
	}
	
	
	// Remove selected items
	public function remove_selected($content_gallery_ids)
	{
		//print_r($content_gallery_ids);
		$database	= new database();
		if(count($content_gallery_ids)>0)
		{		
			foreach($content_gallery_ids as $content_gallery_id)
			{
				$content_gallery	= new content_gallery($content_gallery_id);
				$image_name		= $content_gallery->image_name;
				if(file_exists(DIR_CONTENT_GALLERY . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . $image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumb_' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumb_' . $image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'resize_' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'resize_' . $image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'resize1_' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'resize1_' . $image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumb1_' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumb1_' . $image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumb2_' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumb2_' . $image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumbresize_' . $data->image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumbresize_' . $data->image_name);
				}
				
				$sql = "DELETE FROM content_gallery WHERE content_gallery_id = '" . $content_gallery_id . "'";
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
	
	public function display_list()
	{	
		$database				= new database();
		$validation				= new validation(); 
		$functions              = new functions();
		$param_array			= array();
		$sql					= "SELECT * FROM content_gallery ";
		$drag_drop				= '';
		
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
					$search_cond_array[]	= "( title like '%" . $database->real_escape_string($search_word) . "%' OR 
												 image_name like '%" . $database->real_escape_string($search_word) . "%' )";	
				}
			}
			// Drag and dorp ordering is not available in search
			$drag_drop 						= ' nodrag nodrop ';
		}
		
		$param_array[]			= "content_id=".$this->content_id;
		$search_cond_array[]	= "content_id=". $this->content_id;
		
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
			$sql				.= $search_condition;
		}
					
		$sql 			= $sql . " ORDER BY order_id DESC";
		$result			= $database->query($sql);
		
		
		//echo $sql;
		
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
				<td colspan="5"  class="noBorder">
					<input type="hidden" id="show"  name="show" value="0" />
					<input type="hidden" id="content_gallery_id" name="content_gallery_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					<input type="hidden" id="page" name="page" value="' . $page . '" />
				</td>
			</tr>';
			
			while($data=$result->fetch_object())
			{
				$i++;
				$row_num++;
				$class_name= (($row_type%2) == 0) ? "even" : "odd";	
				$title     = ($data->title != '') ? functions::format_text_field($data->title) : substr(functions::deformat_string($data->image_name), 15);
				$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
				$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
				
				echo '
					<tr id="' . $data->content_gallery_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td class="widthAuto">' . $title . '</td>
										
						<td ><a rel="example1" class="example1"  href="' . URI_CONTENT_GALLERY . $data->image_name . '" alt="' . functions::format_text_field($data->alt) . '" title="' . $title . '">';
						
						
						
						if(file_exists(DIR_CONTENT_GALLERY.'thumb_'. $data->image_name) && $data->image_name != '')
						{/*width="'.CONTENT_GALLERY_THUMB_WIDTH.'" height="'.CONTENT_GALLERY_THUMB_HEIGHT .'"*/
							echo '<img src="'. URI_CONTENT_GALLERY.'thumbnail/'. $data->image_name.'" alt="View" title="View" />';
						}
						else if(file_exists(DIR_CONTENT_GALLERY.'thumbnail/'. $data->image_name) && $data->image_name !='')
						{
							echo '<img src="'. URI_CONTENT_GALLERY.'thumbnail/'. $data->image_name.'" alt="View" title="View"  />';
							
						}
						else
						{ 
							echo '<img src="image_resize.php?image='.$data->image_name. '&width='. CONTENT_GALLERY_THUMB_WIDTH.'&height='. CONTENT_GALLERY_THUMB_HEIGHT.'&dir=content_gallery" border="0"  />';	
						}
						
						/*echo '<td class="alignCenter"><a class="grouped_elements" href="' . URI_CONTENT_GALLERY . $data->image_name . '" alt="' . functions::format_text_field($data->alt) . '" title="' . functions::format_text_field($data->title) . '">';
						if(file_exists(DIR_CONTENT_GALLERY . 'thumb_' . $data->image_name))
						{
						echo '<img src="image_resize.php?image='.$data->image_name. '&width='. content_gallery_SMALL_THUMB_WIDTH.'&height='. content_gallery_SMALL_THUMB_HEIGHT.'&dir=property" border="0" />';
						}
						else
						{
						echo '<img src="image_resize.php?image='.$data->image_name. '&width='. content_gallery_SMALL_THUMB_WIDTH.'&height='. content_gallery_SMALL_THUMB_HEIGHT.'&dir=property" border="0" />';	
						}*/
						
						echo '</a></td>';
						
						
						echo '<td class="alignCenter">';
						if($data->content_gallery_id > 0 && $data->image_name !='')
						{
							echo '<a style="cursor:pointer;" onclick="popup_crop_image('.$data->content_gallery_id.');"><img src="images/icon-portfolio.png" alt="Create Thumbnail" title="Create Thumbnail" width="15" height="16" /></a>';
						}
						else
						{
							echo '&nbsp;';
						}
						
						echo '</td>';
						
						
						/*echo '</a></td>
						<td class="alignCenter">
							<a href="register_content_gallery.php?content_id=' . $data->content_id . '&content_gallery_id=' . $data->content_gallery_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>'; */
						
						/*echo '
						
						<td class="alignCenter">';
						if($data->content_gallery_id > 0 && $data->image_name !='')
						{
							echo '<a style="cursor:pointer;" onclick="show_crop('.$data->content_gallery_id.');"><img src="images/icon-portfolio.png" alt="Create Thumbnail" title="Create Thumbnail" width="15" height="16" /></a>';
						}
						else
						{
							echo '&nbsp;';
						}
						
						echo '</td>*/
						
						echo '<td class="alignCenter">
								<a title="Click here to update status" class="handCursor" onclick="javascript: change_status(\'' . $data->content_gallery_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a>
							</td>';
						
						echo '<td class="alignCenter">
							<a href="edit_content_gallery.php?content_id='.$data->content_id.'&content_gallery_id='. $data->content_gallery_id .'"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>';
						
						
						echo '<td class="alignCenter deleteCol">
							<label><input type="checkbox" name="checkbox[' . $data->content_gallery_id . ']" id="checkbox" /></label>
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
				echo "<tr><td colspan='5' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
	
	//The function check the no images in a gallery
	public function no_image_in_gallery($content_id=0)
	{
		$output		= false;
		$database	= new database();
		$num_rows	= 0;
		$sql		= "SELECT *	 FROM content_gallery WHERE content_id = '" . $content_id . "'";
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
		$sql				= "SELECT * FROM content_gallery WHERE content_id='".$content_id."' ORDER BY added_date DESC";
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
				
				if(!file_exists(DIR_CASE_STUDIES . 'thumb_' . $data->image_name))
				{
					$functions	= new functions();
					$functions->generate_thumb_image1($data->image_name, DIR_CASE_STUDIES, GALLERY_THUMB_WIDTH, GALLERY_THUMB_HEIGHT);
				}
				$thumb_image	= URI_CASE_STUDIES . 'thumb1_' . $data->image_name;
				
				?>

<div class="productCategory">
	<div class="tumbHolder"><a rel="example4" href="<?php echo URI_CASE_STUDIES . $data->image_name; ?>"><img src="<?php echo $thumb_image; ?>" alt="<?php echo functions::format_text_field($data->alt); ?>" /></a></div>
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
	
	public function get_image_count($content_id)
	{
		$database			= new database();
		$sql				= "SELECT * FROM content_gallery WHERE content_id='".$content_id."' ORDER BY added_date DESC";
		//echo $sql;
		$result				= $database->query($sql);
		return $result->num_rows;
	}
	
	public function get_image_list($content_id)
	{
		$database			= new database();
		$sql				= "SELECT * FROM content_gallery WHERE content_id='".$content_id."' ORDER BY order_id DESC";
		$result				= $database->query($sql);
		$image_list			= '';
		$property_details= new property($content_id);
		echo '<div class="prop_detailBox">';
		if ($result->num_rows > 0)
		{ //class="thumbs noscript"
		//<a class="thumb"  href="'.$first_image .'" title="'.$data->title.'">
		echo '<div class="prop_detailgallerybox">
				<div id="gallery_header">
				 <div class="slideshow-container">
				  <div id="slideshow" class="slideshow"></div>
					</div>
					<div class="navigation-container">
					 <div id="thumbs" class="navigation">
						<a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
						  <div id="gallery"><ul >';
			while($data = $result->fetch_object())
			{
				if($data->image_name != '' && !file_exists(DIR_CONTENT_GALLERY .$data->image_name))
				{
					continue;
				}
				
				$thumb_image = '';
								
				if(!file_exists(DIR_CONTENT_GALLERY . 'thumb1_' . $data->image_name))
				{
					$functions	= new functions();
					//$functions->generate_thumb1_image($data->image_name, DIR_CONTENT_GALLERY, CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT);
				}
				//echo $data->image_name;
				
				/*if(!file_exists(DIR_CONTENT_GALLERY . 'thumbnail' . $data->image_name))
				{
					$imageLib = new imageLib(DIR_CONTENT_GALLERY.$data->image_name);
					$imageLib->resizeImage(80, 80, 3); //$height,$orientation(0-exact, 1-portrait, 2- landscape, 3-auto, 4-crop)
					$imageLib->saveImage(DIR_CONTENT_GALLERY.'thumbnail/'.$data->image_name, 75);
				}*/
				
				//$thumb_image	= URI_CONTENT_GALLERY . 'thumb1_' . $data->image_name;
				
				
				if(!file_exists(DIR_CONTENT_GALLERY . 'thumb_' . $data->image_name))
				{
					$functions	= new functions();
					$functions->generate_thumb_image($data->image_name, DIR_CONTENT_GALLERY, CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT);
					$first_image=URI_CONTENT_GALLERY . 'thumb_'.$data->image_name;
					
				}
				/*else
				{
					$thumb_image	= URI_CONTENT_GALLERY . 'thumb_' . $data->image_name;
					$first_image=URI_CONTENT_GALLERY . 'thumb_'.$data->image_name;
				}*/
				$thumb_image	= URI_CONTENT_GALLERY . 'thumb_' . $data->image_name;
				$first_image=URI_CONTENT_GALLERY . 'thumb_'.$data->image_name;
					  
				echo '<li><a class="fancybox" rel="gallery1" href="'.URI_CONTENT_GALLERY .$data->image_name.'" title="'.$data->title.'">
							<img src="' . $first_image . '" alt="'.$data->title.'" width="82" height="74" />
					  </a></li>';
			}
		
    echo '</ul></div>
		<a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>
		 </div>
		  </div>
		   </div>
		     </div>';
					
					
		}
		else
		{
		  echo '<div class="prop_detailgallerybox1"><img src="'.URI_ROOT.'images/large_thumb.jpg"></div>';	
			
		}
		
		echo '<div class="property_nameouter">
					<div class="property_namebox">
						<h1>'.functions::deformat_string($property_details->address1).'<br/> '.functions::deformat_string($property_details->town).'</h1>
						<div class="property_pricebox">
							'.PROPERTY_CURRENCY.functions::deformat_string($property_details->price);
					if($property_details->property_category_id==2)
					{
						echo " pa";
					}
					else
					{
						echo " pcm";
					}
						echo '</div>
					</div>
					<h2>';
					if($property_details->property_category_id==2)
					{
						echo "commerical";
					}
					else
					{
						if($property_details->sub_category_id > 0)
						{
							$propert_category	= new property_category($property_details->sub_category_id);
							
							if($property_details->bed_room>0)
							{
								echo $property_details->bed_room.' bedroom '.functions::deformat_string($propert_category->category_name);;
							}
							else
							{
								echo  functions::deformat_string($propert_category->category_name);
							}
						}
						else
						{
							echo 'Residential House';	
						}
						
						/*if($property_details->bed_room>0)
						{
							echo $property_details->bed_room.' bedroom apartment';
						}
						else
						{
						   echo 'apartment';	
						} */
					}
					echo '</h2>';
					
				property::get_key_features($property_details->content_id);
				echo '</div>
			</div>';
		echo '<div class="inner_titlebox2">
				<h1>Property Details:</h1>
				<h2>Call us on: '.PHONE.'</h2>
			</div>
			<div class="prop_detailcontent">'
				.functions::deformat_string($property_details->description);
				echo '<a style="cursor:pointer;" onclick="show_property_enquiry('.$property_details->content_id.')" >
			<div class="propertydetails_button">
					</div><br><br>
			</a>';
			 
			 /*if(substr_count(strtolower($property_details->google_map_code),"view larger map")>0)
			 {
				 $google_map_code=$property_details->google_map_code;
				 $google_map_code_lower_case=strtolower($property_details->google_map_code);
				 
				 $startsAt = strpos($google_map_code_lower_case, "<a") + strlen("<a");
				$endsAt = strpos($google_map_code_lower_case, ">view larger map", $startsAt);
				$checking_content = substr($google_map_code_lower_case, $startsAt, $endsAt - $startsAt);
				$link_details= explode("target",$checking_content);
				if(count($link_details)==1)
				{
					
					echo substr($google_map_code,0,$startsAt).' target="_blank" '.$link_details[0].substr($google_map_code,$endsAt);
				}
				else
				{
					
					echo $property_details->google_map_code;;
				}
				
			 }
				if($property_details->image_name!="") 
				{
				echo '<p>
					<a class="grouped_elements" href="' . URI_PROPERTY . $property_details->image_name . '" alt="' . functions::format_text_field($property_details->title) . '" title="' . functions::format_text_field($property_details->title) . '"><img src="'.URI_PROPERTY . 'thumb_'.$property_details->image_name .'" width="218" height="98"/></a>
				</p>';
				}*/
				
			if ($property_details->postcode != ''){
				$map_post_code = $property_details->postcode;						
				echo '<div id="map" style="width: 500px; height: 500px; "></div><p></p>';	
			}
			
			
			if($property_details->image_name!="") 
			{
			echo '<p>
				<a class="grouped_elements" href="' . URI_PROPERTY . $property_details->image_name . '" alt="' . functions::format_text_field($property_details->title) . '" title="' . functions::format_text_field($property_details->title) . '"><img src="'.URI_PROPERTY . 'thumb_'.$property_details->image_name .'" width="218" height="98"/></a>
			</p>';
			}	
				
			echo '</div>
			';
			
			
	}
	
	
	public function get_image_list1212($content_id)
	{
		$database			= new database();
		$sql				= "SELECT * FROM content_gallery WHERE content_id='".$content_id."' ORDER BY order_id ASC";
		$result				= $database->query($sql);
		$image_list			= '';
		$property_details= new property($content_id);
		echo '<div class="prop_detailBox">';
		if ($result->num_rows > 0)
		{
		echo '<div class="prop_detailgallerybox">
				<div id="gallery_header">
				 <div class="slideshow-container">
				  <div id="slideshow" class="slideshow"></div>
					</div>
					<div class="navigation-container">
					 <div id="thumbs" class="navigation">
						<a class="pageLink prev" style="visibility: hidden;" href="#" title="Previous Page"></a>
						  <ul class="thumbs noscript">';
			while($data = $result->fetch_object())
			{
				if($data->image_name != '' && !file_exists(DIR_CONTENT_GALLERY .$data->image_name))
				{
					continue;
				}
				
				$thumb_image = '';
								
				if(!file_exists(DIR_CONTENT_GALLERY . 'thumb1_' . $data->image_name))
				{
					$functions	= new functions();
					//$functions->generate_thumb1_image($data->image_name, DIR_CONTENT_GALLERY, CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT);
				}
				
				//$thumb_image	= URI_CONTENT_GALLERY . 'thumb1_' . $data->image_name;
				if(!file_exists(DIR_CONTENT_GALLERY . 'thumb_' . $data->image_name))
				{
					$functions	= new functions();
					$functions->generate_thumb_image($data->image_name, DIR_CONTENT_GALLERY, CONTENT_GALLERY_MAX_WIDTH, CONTENT_GALLERY_MAX_HEIGHT);
					$first_image=URI_CONTENT_GALLERY . 'thumb_'.$data->image_name;
				}
				$first_image=URI_CONTENT_GALLERY . 'thumb_'.$data->image_name;
				$thumb_image	= URI_CONTENT_GALLERY . 'thumb_' . $data->image_name;
				
			  echo '<li>
			  <a class="thumb" name="leaf" href="'.$first_image .'" title="'.$data->title.'">
		     <img src="' . $thumb_image . '" alt="'.$data->title.'" width="82" height="74"/></a></li>';
			}
		
    echo '</ul>
		<a class="pageLink next" style="visibility: hidden;" href="#" title="Next Page"></a>
		 </div>
		  </div>
		   </div>
		     </div>';
					
					
		}
		
		echo '<div class="property_nameouter">
					<div class="property_namebox">
						<h1>Dimsdale House<br/> Hertford</h1>
						<div class="property_pricebox">
							£795.00 pcm
						</div>
					</div>
					<h2>1 bedroom apartment</h2>
					<div class="keyfeaturestitle">
						Key Features :
					</div>
					<div class="keyfeturesbox">
						- 1 double bedroom<br/>
						- Town Centre Apartment<br/>
						- Kitchen white goods included
					</div>
					<div class="keyfeturesbox">
						- Gas central heating <br/>
						- Available immediatly<br/>
					</div>
				</div>';
		
		
		
		
		
		
		
			echo '</div>';
		echo '<div class="inner_titlebox2">
				<h1>Property Details:</h1>
				<h2>Call us on: '.PHONE.'</h2>
			</div>
			<div class="prop_detailcontent">'
				.functions::deformat_string($property_details->description);
				if($property_details->image_name!="") 
				{
				echo '<p>
					<a class="grouped_elements" href="' . URI_PROPERTY . $property_details->image_name . '" alt="' . functions::format_text_field($property_details->title) . '" title="' . functions::format_text_field($property_details->title) . '"><img src="'.URI_PROPERTY . 'thumb_'.$property_details->image_name .'" width="218" height="98"/></a>
				</p>';
				}
			echo '</div>
			<a style="cursor:pointer;" onclick="show_property_enquiry('.$property_details->content_id.')" >
			<div class="propertydetails_button">
			</div>
			</a>';
			
			
	}
	
	
	
	
	
	
	public static function get_default_image($content_id)
	{
		$database			= new database();
		$sql	= "SELECT * FROM content_gallery WHERE content_id='".$content_id."' ORDER BY order_id ASC LIMIT 0, 1";
		$result	= $database->query($sql);				
		if ($result->num_rows > 0)
		{
			$data = $result->fetch_object();
			return $data->image_name;
		}
		
		
		
	}
	
	// Returns the max order id
	//public static function get_default_image1($content_id)
//	{
//		$database	= new database();
//		$sql		= "SELECT * FROM content_gallery WHERE content_id = '$content_id'";
//		$result		= $database->query($sql);
//		
//		if ($result->num_rows > 0)
//		{
//			$data	= $result->fetch_object();
//			return 'N';
//		}
//		else
//		{
//			return 'Y';
//		}
//	}
	
	public static function get_slider_properties()
	{
		$database	= new database();
		
		$sql		= "SELECT DISTINCT `content_id` FROM `content_gallery` WHERE status='Y' ";
		//echo $sql;
		$result		= $database->query($sql);
		$num_rows	= $result->num_rows;
		
		$result		= $database->query($sql);
		if ($result->num_rows > 0)
		{
			$functions=new functions();
			 echo '<div class="images"><ul>';
			while($data = $result->fetch_object())
			{
				
				$property_details= new property($data->content_id);
				$sub_sql		= "SELECT * FROM content_gallery WHERE content_id = '$data->content_id' order by order_id Asc limit 0,1";
				//echo $sub_sql;
				$sub_result		= $database->query($sub_sql);
				if ($sub_result->num_rows > 0)
		     {
				 while($sub_data = $sub_result->fetch_object())
			{
				?>
<li>
	<div class="slidercontentbox">
	<div class="slidercontentbox_img"> <img src="image_resize.php?image=<?php echo $sub_data->image_name; ?>&width=<?php echo CONTENT_GALLERY_THUMB_WIDTH1; ?>&height=<?php echo CONTENT_GALLERY_THUMB_HEIGHT1; ?>&dir=property" border="0" /></div>
		<div class="slidercontent">
			<h1><?php echo $functions->get_sub_string(functions::deformat_string($property_details->title ),60,true); ?></h1>
			<?php echo $functions->get_sub_string(functions::deformat_string($property_details->description),190,true); ?> </div>
	</div>
	<a href="our_properties.php">
	<div class="slider_viewmorebutton"></div>
	</a>
	<div class="sliderbtn_space"></div>
	<a onclick="show_property_enquiry('<?php echo $property_details->content_id; ?>')" style="cursor:pointer">
	<div class="slider_enqebutton"></div>
	</a> </li>
<?php } }
			}
			
			echo '</ul></div>';
		}
	}
	
	
	 public static function check_thumb_exist($image_name)
	   {
		if(file_exists(DIR_CONTENT_GALLERY . 'thumb_' .$image_name))
		{
		  $status='Y';
		}
		else
		{
		$status='N';
		}
		return $status;
				  
	  }
	  
	  
	  
	  
	  public static function getcontent_gallery_details_page($content_id,$image_name=NULL,$limit=0){
		   $database	= new database();
		   	
			$image_name_back=content_gallery::getcontent_gallery_image($content_id);
		   
		   if($limit==0){
			   if($image_name=="")
			   {
		   			$sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND status='Y'  order by  order_id DESC ";
			   }
			   else
			   {
				  $sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND image_name !='".$image_name."' AND status='Y'  order by  order_id DESC "; 
			   }
		   }else{
			   if($image_name=="")
			   {
				   $sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND status='Y' order by  order_id DESC limit 0,".$limit;
			   }
			   else
			   {
				$sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND image_name !='".$image_name."' AND status='Y' order by  order_id DESC limit 0,".$limit;
			   }
		   }
			$result		= $database->query($sql1);
			$image_name=array();
			$image_name[]=$image_name_back;
			 while($data = $result->fetch_object()){
				$image_name[]=$data->image_name;  
			} 
			return  $image_name; 
	  }   
		   
	public static function getcontent_gallery_image_all($content_id,$image_name=NULL,$limit=0){
		   $database	= new database();
		   /*if($image_name=="" && $limit==0){
		   		$sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND status='Y'  order by  order_id DESC ";
		   }else{
				$sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND image_name !='".$image_name."' AND status='Y' order by  order_id DESC limit 0,".$limit;
		   }*/
		   
		   if($limit==0){
			   if($image_name=="")
			   {
		   			$sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND status='Y'  order by  order_id DESC ";
			   }
			   else
			   {
				  $sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND image_name !='".$image_name."' AND status='Y'  order by  order_id DESC "; 
			   }
		   }else{
			   if($image_name=="")
			   {
				   $sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND status='Y' order by  order_id DESC limit 0,".$limit;
			   }
			   else
			   {
				$sql1		= "SELECT * FROM content_gallery WHERE content_id = '$content_id' AND image_name !='".$image_name."' AND status='Y' order by  order_id DESC limit 0,".$limit;
			   }
		   }
		   
		   
			$result		= $database->query($sql1);
			$image_name=array();
			 while($data = $result->fetch_object()){
				$image_name[]=$data->image_name;  
			} 
			return  $image_name; 
	  }
	  public function save_temp_table()
	  {
		 $database	= new database();  
	    $sql	= "INSERT INTO  temp_content_gallery 
							(content_id,image_name, added_time) 
							VALUES ('" . $database->real_escape_string($this->content_id) . "',
									'" . $database->real_escape_string($this->image_name) . "',
									NOW()
									)";  
		 $result		= $database->query($sql);							
		   
	 }
	
	  public function check_exists_in_temp_table($image_name)
	  {
		 $database	= new database();  
		 $sql		= "SELECT * FROM temp_content_gallery WHERE  	image_name = '$image_name'";
		  $result		= $database->query($sql);
			if ($result->num_rows > 0)
		     {
				$delete_sql = "DELETE FROM temp_content_gallery WHERE  	image_name = '" . $image_name . "'"; 
				 $delete_result		= $database->query($delete_sql);
				 
			 }
		  
	}
	
	
	 public function remove_temp_table_data()
	{
		$database	= new database();
		
		 $main_sql		= "SELECT * FROM temp_content_gallery WHERE HOUR( TIMEDIFF( added_time, NOW( ) ) ) >1";
		  $main_result		= $database->query($main_sql);
  // echo $main_sql;
		if ($main_result->num_rows > 0)
		{		
			while($data = $main_result->fetch_object())
			{
				//$content_gallery	= new content_gallery($content_gallery_id);
				$image_name		= $data->image_name;
				if(file_exists(DIR_CONTENT_GALLERY . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . $image_name);
				}
				if(file_exists(DIR_CONTENT_GALLERY . 'thumb_' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumb_' . $image_name);
				}
				
				$sql = "DELETE FROM temp_content_gallery WHERE image_name = '" . $image_name . "'";
				//echo $sql;
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
	
	public function get_image_list_by_content_gallery($content_id = 0)
	{
		//echo $_SESSION['inserted_ids'];
		$database	= new database();
		$output		= array();
		if($content_id  > 0 && $_SESSION['inserted_ids'] !='')
		{
			//$sql		= "SELECT * FROM image_gallery WHERE image_category_id='". $category_id. "' ORDER BY image_gallery_id DESC"; //
			$sql		= "SELECT * FROM content_gallery WHERE content_id='". $content_id. "'  AND content_gallery_id IN (".$_SESSION['inserted_ids'].") ORDER BY content_gallery_id DESC";
			
			//echo $sql;
			
			$result		= $database->query($sql);
			//echo  $result->num_rows;
			
			if ($result->num_rows > 0)
			{
			    while($data	= $result->fetch_object())
				{
					$output [] = $data->image_name;
				}
			}
		}
		
		return $output;
	}
	
	public function remove_by_image($content_id = 0, $image_name ='')
	{
		$database	= new database();
		$sql		= "DELETE FROM content_gallery WHERE content_id='". $content_id. "' AND image_name='". $image_name."'";
		$result		= $database->query($sql);
		
		if(file_exists(DIR_CONTENT_GALLERY . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumb_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'thumb_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'resize_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'resize_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'resize1_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'resize1_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumb1_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'thumb1_' . $image_name);
			if(file_exists(DIR_CONTENT_GALLERY . 'thumbresize_' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumbresize_' . $image_name);
				}
		}
		
	}
	
	public function get_image_list_edit($content_gallery_id)
	{
		$database	= new database();
		$output		= array();
		
		//$sql		= "SELECT * FROM image_gallery WHERE image_category_id='". $category_id. "' ORDER BY image_gallery_id DESC";
		$sql		= "SELECT * FROM content_gallery WHERE content_gallery_id='". $content_gallery_id."' ORDER BY content_gallery_id DESC";
		//echo $sql;
		
		$result		= $database->query($sql);
	
		if ($result->num_rows > 0)
		{
			while($data	= $result->fetch_object())
			{
				$output [] = $data->image_name;
			}
		}
		
		//print_r($output);
		
		return $output;
	}
	
	public function get_timestamp_temp($image_name = '', $type ='')
	{
		$database	= new database();	
		$sql	= "SELECT temp_timestamp FROM upload_temp WHERE image_name = '" . $database->real_escape_string($image_name) . "' AND type='". $database->real_escape_string($type) ."'";
		$result 	= $database->query($sql);
		if ($result->num_rows > 0)
		{
			$data		= $result->fetch_object();
			$news_temp_id	= $data->temp_timestamp;
			return  $news_temp_id;
		}
		else return 0;
	}
	
	public function update_content_gallery_image()
	{		
		$database			= new database();
		
		$content_gallery 	= new content_gallery($this->content_gallery_id);
		$image_name 	= $content_gallery->image_name;
		
		if(file_exists(DIR_CONTENT_GALLERY . $image_name) && $image_name != '')
		{
			unlink(DIR_CONTENT_GALLERY . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name) && $image_name != '')
		{
			unlink(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name)&& $image_name != '')
		{
			unlink(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $image_name)&& $image_name != '')
		{
			unlink(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'resize_' . $image_name) && $image_name != '')
		{
			unlink(DIR_CONTENT_GALLERY . 'resize_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'resize1_' . $image_name) && $image_name != '')
		{
			unlink(DIR_CONTENT_GALLERY . 'resize1_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumb_' . $image_name) && $image_name != '')
		{
			unlink(DIR_CONTENT_GALLERY . 'thumb_' . $image_name);
		}
		
		if(file_exists(DIR_CONTENT_GALLERY . 'thumb1_' . $image_name) && $image_name != '')
		{
			unlink(DIR_CONTENT_GALLERY . 'thumb1_' . $image_name);
			
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumb2_' . $image_name) && $image_name != '')
		{
			unlink(DIR_CONTENT_GALLERY . 'thumb2_' . $image_name);
			
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumbresize_' . $image_name))
				{
					unlink(DIR_CONTENT_GALLERY . 'thumbresize_' . $image_name);
				}
		
		$sql				= "UPDATE content_gallery SET image_name='". $this->image_name."' WHERE content_gallery_id='". $this->content_gallery_id."'";
		//echo $sql;
		
		$result				= $database->query($sql);
		
		
		if($content_gallery->content_gallery_image == 'Y')
		{
			$size_array	= getimagesize(DIR_CONTENT_GALLERY.$this->image_name);
			$imageLib = new imageLib(DIR_CONTENT_GALLERY.$this->image_name);
			/*if($size_array[0] < $size_array[1])
			{
			$orientation	= 1;	
			}
			else if($size_array[0] > $size_array[1])
			{
				$orientation	=  2;
			}
			else
			{
				$orientation	= 3;	
			}*/
			
			
			if(file_exists(DIR_CONTENT_GALLERY.'resize_'.$this->image_name))
			{
				unlink(DIR_CONTENT_GALLERY.'resize_'.$this->image_name);	
			}
		
			if($size_array[0] >= 1440 && $size_array[1] >=  1080)
			{
				$imageLib->resizeImage(1440, 1080, 0);
			}
			else if($size_array[0] >= 1440)
			{
				$imageLib->resizeImage(1440, $size_array[1], 0);	
			}
			else if($size_array[1] >=  1080)
			{
				$imageLib->resizeImage($size_array[0], 1080, 0);	
			}
			else
			{
				$imageLib->resizeImage($size_array[0], $size_array[1], 0);
			}
		
		
			//$imageLib = new imageLib(DIR_CONTENT_GALLERY.$this->image_name);
			//$imageLib->resizeImage(CONTENT_GALLERY_MAX_WIDTH, CONTENT_GALLERY_MAX_HEIGHT, 0); //$orientation //$height,$orientation(0-exact, 1-portrait, 2- landscape, 3-auto, 4-crop)
			$imageLib->saveImage(DIR_CONTENT_GALLERY.'resize_'.$this->image_name, 75);
		
		}
		

	}
	
	public function delete_content_gallery_image($folder = '', $image_name ='')
	{		
		$database			= new database();
		$sql				= "UPDATE content_gallery SET image_name='' WHERE image_name='". $image_name."' AND content_gallery_id='". $this->content_gallery_id."'";
		$result				= $database->query($sql);

		if(file_exists(DIR_CONTENT_GALLERY . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'thumbnail/' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'thumbnail/thumbresize_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'resize_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'resize_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'resize1_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'resize1_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumb_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'thumb_' . $image_name);
		}
		if(file_exists(DIR_CONTENT_GALLERY . 'thumb1_' . $image_name))
		{
			unlink(DIR_CONTENT_GALLERY . 'thumb1_' . $image_name);
		}
	}
	
	
	public static function content_gallery_select_option($content_gallery_id=0)
	{
		  $database    = new database();
		  $sql     = "SELECT * FROM content_gallery ORDER BY order_id DESC";
		  $result   = $database->query($sql);
		  
		  if($result->num_rows > 0)
		  {
			   while($data  = $result->fetch_object())
			   { 
					$select = ($data->content_gallery_id == $content_gallery_id) ? 'selected': '';
					$image_name = ($data->title !='') ? $data->title: substr($data->image_name, 15);
					echo '<option  value="' . $data->content_gallery_id . '" ' . $select . '>' . functions::deformat_string($image_name) . '</option>'; 
			   }
		  }
		
	 }
	 
	 public static function content_count()
		{
			$database		= new database();
			$output 	= 0;
			$sql		= "SELECT * FROM  content";
			$result		= $database->query($sql);
			if($result->num_rows > 0)
			{
				while($data  = $result->fetch_object())
				{
					$sql1		= "SELECT * FROM content_gallery WHERE content_id='". $data->content_id."'";	
					$result1		= $database->query($sql1);
					if($result1->num_rows == 0)
					{
						$output++;	
					}
				}
			
			}
			
			return $output;
		}
		
		public static function is_delete($content_id)
		{
			$database		= new database();
			
			$sql		= "SELECT * FROM  content_gallery WHERE content_id='". $content_id."'";
			$result		= $database->query($sql);
			if($result->num_rows > 0)
			{
				return false;	
			}
			else
			{
				return true;
			}
		}
		
		
		public static function get_page_images($content_id)
		{
			$database		= new database();
			
			$sql		= "SELECT * FROM  content_gallery WHERE content_id='". $content_id."' ORDER BY order_id DESC";
			$result		= $database->query($sql);
			if($result->num_rows > 0)
			{
				$i = 0;
				while($data 	= $result->fetch_object())
				{
					if(!file_exists(DIR_CONTENT_GALLERY.'thumb_'.$data->image_name) && $data->image_name != "")
					{
						$size_1	= getimagesize(DIR_CONTENT_GALLERY.$data->image_name);
						$imageLib = new imageLib(DIR_CONTENT_GALLERY.$data->image_name);
						//$imageLib->resizeImage(CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT, 0);
						/*if($size_1[0] > $size_1[1])
						{
							$imageLib->resizeImage(CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT, 2);
						}
						else if($size_1[0] < $size_1[1])
						{
							$imageLib->resizeImage(CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT, 1);
						}
						else
						{
							$imageLib->resizeImage(CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT, 3);	
						}*/
						$imageLib->resizeImage(CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT, 0);
						$imageLib->saveImage(DIR_CONTENT_GALLERY.'thumb_'.$data->image_name, 90);
						unset($imageLib);
					}
							
					if($i == 0)
					{
						echo '<div id="cover" style="background-image:url('.URI_CONTENT_GALLERY.'thumb_'.$data->image_name.'); background-repeat:no-repeat;"> </div>';	
					}
					else
					{
						echo '<div class="feature pagefx hardpage" style="background-image:url('.URI_CONTENT_GALLERY.'thumb_'.$data->image_name.'); background-repeat:no-repeat;"></div>';
					}
					
					$i++;
				}
			}
		}
		
		
		public static function resize_all_images($content_id, $content_gallery_id = 0)
		{
			$database		= new database();
			if($content_gallery_id > 0)
			{
				$sql		= "SELECT * FROM  content_gallery WHERE content_id='". $content_id."' AND content_gallery_id ='". $content_gallery_id."' ORDER BY order_id DESC";
			}
			else
			{
				$sql		= "SELECT * FROM  content_gallery WHERE content_id='". $content_id."' ORDER BY order_id DESC";
			}
			
			$result		= $database->query($sql);
			if($result->num_rows > 0)
			{
				while($data 	= $result->fetch_object())
				{
					$size_1	= getimagesize(DIR_CONTENT_GALLERY.$data->image_name);
					$imageLib = new imageLib(DIR_CONTENT_GALLERY.$data->image_name);
					//$imageLib->resizeImage(CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT, 0);
					/*if($size_1[0] > $size_1[1])
					{
						$imageLib->resizeImage(CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT, 2);
					}
					else if($size_1[0] < $size_1[1])
					{
						$imageLib->resizeImage(CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT, 1);
					}
					else
					{
						$imageLib->resizeImage(CONTENT_GALLERY_THUMB_WIDTH, CONTENT_GALLERY_THUMB_HEIGHT, 3);	
					}*/
					$imageLib->resizeImage(509, 382, 0);
					$imageLib->saveImage(DIR_CONTENT_GALLERY.'resize1_'.$data->image_name, 90);
					unset($imageLib);
					
					$imageLib = new imageLib(DIR_CONTENT_GALLERY.$data->image_name);
					$imageLib->resizeImage(211, 125, 0);
					$imageLib->saveImage(DIR_CONTENT_GALLERY.'thumb2_'.$data->image_name, 90);
					unset($imageLib);
					
				}
			}
		}
		
		
		public static function get_page_image_count($content_id)
		{
			$database		= new database();
			
			$sql		= "SELECT * FROM  content_gallery WHERE content_id='". $content_id."' ORDER BY order_id DESC";
			$result		= $database->query($sql);
			return  $result->num_rows;
		}
		
		public static function get_all_images($content_id = 0)
		{
			$database		= new database();
			$output 		= array();
			$sql		= "SELECT * FROM  content_gallery WHERE content_id='". $content_id."' AND status='Y' ORDER BY order_id DESC";
			$result		= $database->query($sql);
			while($data 	= $result->fetch_object())
			{
				if($data->image_name != '' && !file_exists(DIR_CONTENT_GALLERY.'resize1_'.$data->image_name))
				{
					self::resize_all_images($content_id, $data->content_gallery_id);
				}
				$output[] = $data;	
			}
			return  $output;
		}	
		
		public static function get_slider_images($content_id = 0)
		{
			$database		= new database();
			$output 		= array();
			$sql		= "SELECT * FROM  content_gallery WHERE content_id='". $content_id."' AND status='Y' ORDER BY order_id DESC";
			$result		= $database->query($sql);
			while($data 	= $result->fetch_object())
			{
				$output[] 	= $data->image_name;	
			}
			return  $output;
		}
		
}
?>
