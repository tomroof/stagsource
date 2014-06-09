<?php
/*********************************************************************************************
Date	: 14-April-2011
Purpose	: poll class
*********************************************************************************************/
class poll
{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';
	
	public  $poll_type_array	= array(1=>'When can you go?', 2=>'Where do you want to go?');
	
	
	function __construct($poll_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		
		if($poll_id > 0)
		{
			$this->initialize($poll_id);
		}
	}
	
	function __get($name)
	{
		if (array_key_exists($name, $this->_properties))
		{
			return $this->_properties[$name];
		}
		return null;
	}
	public function __set($name, $value)
	{
		return $this->_properties[$name] = $value;
	}
	
	public function __destruct() 
	{
		unset($this->_properties);
		unset($this->error);
		unset($this->message);
	}
	
	//Initialize object variables.
	private function initialize($poll_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM poll WHERE poll_id = '$poll_id'";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$this->_properties	= $result->fetch_assoc();
		}
	}
	// Save the poll details
	public function save()
	{
		$database	= new database();
		
		if(!$this->check_poll_exist($this->vendor_name, $this->vendor_type_id, $this->_properties['poll_id']))
		{	
			$your_picks = (count($this->your_picks) > 0) ? implode(',', $this->your_picks) : '';
			$amenities	= (count($this->amenities) > 0) ? implode(',', $this->amenities): '';
			
			if ( isset($this->_properties['poll_id']) && $this->_properties['poll_id'] > 0) 
			{
				$sql	= "UPDATE poll SET
							party_type_id = '". $database->real_escape_string($this->party_type_id)  ."', 
							vendor_type_id = '". $database->real_escape_string($this->vendor_type_id)  ."',
							property_type_id = '". $database->real_escape_string($this->property_type_id)  ."',
				 			vendor_name = '". utf8_decode($database->real_escape_string($this->vendor_name))  ."',
							phone = '". $database->real_escape_string($this->phone) ."',
							address = '". $database->real_escape_string($this->address)  ."',
							postcode = '". $database->real_escape_string($this->postcode) ."',
							country_id = '". $database->real_escape_string($this->country_id)."',
							MouseLat = '". $database->real_escape_string($this->MouseLat)."',
							MouseLng = '". $database->real_escape_string($this->MouseLng)."',
							location_id = '". $database->real_escape_string($this->location_id)."',
							website = '". $database->real_escape_string($this->website)."', 
							email = '". $database->real_escape_string($this->email)."', 
							budget_range = '". $database->real_escape_string($this->budget_range)."', 
							cost_range = '". $database->real_escape_string($this->cost_range)."', 
							price = '". $database->real_escape_string($this->price)."', 
							price_type = '". $database->real_escape_string($this->price_type)."',
							hotel_fee = '". $database->real_escape_string($this->hotel_fee) ."', 
							your_picks = '". $database->real_escape_string($your_picks)."',
							your_picks_description = '". $database->real_escape_string($this->your_picks_description)."',
							amenities = '". $database->real_escape_string($amenities)."',
							features = '". $database->real_escape_string($this->features)."',
							location_description = '". $database->real_escape_string($this->location_description)."',
							guest_favourites = '". $database->real_escape_string($this->guest_favourites)."',
							overview = '". utf8_decode($database->real_escape_string($this->overview))."',
							whywe_like = '". utf8_decode($database->real_escape_string($this->whywe_like))."',
							status = '". $database->real_escape_string($this->status)."'
							WHERE poll_id = '$this->poll_id'";
			}
			else 
			{  
				$order_id	= self::get_max_order_id() + 1;
				 
				$sql		= "INSERT INTO poll 
							(party_type_id, vendor_type_id,property_type_id, vendor_name, address, phone, postcode, country_id,MouseLat,MouseLng,location_id, website, email, budget_range, cost_range, price, price_type, hotel_fee, your_picks, your_picks_description, amenities, features, location_description, guest_favourites, overview, whywe_like, status, order_id, added_date) 
							VALUES ( '" . $database->real_escape_string($this->party_type_id) . "',
									'" . $database->real_escape_string($this->vendor_type_id) . "',
									 '" . $database->real_escape_string($this->property_type_id) . "',
							         '" . utf8_decode($database->real_escape_string($this->vendor_name)) . "',
							         '" . $database->real_escape_string($this->address) . "',
									'" . $database->real_escape_string($this->phone) . "',
									'" . $database->real_escape_string($this->postcode) . "',
									'" . $database->real_escape_string($this->country_id) . "',
									'" . $database->real_escape_string($this->MouseLat) . "',
									'" . $database->real_escape_string($this->MouseLng) . "',
									'" . $database->real_escape_string($this->location_id) . "',
									'" . $database->real_escape_string($this->website) . "',
									'" . $database->real_escape_string($this->email) . "',
									'" . $database->real_escape_string($this->budget_range) . "',
									'" . $database->real_escape_string($this->cost_range) . "',
									'" . $database->real_escape_string($this->price) . "',
									'" . $database->real_escape_string($this->price_type) . "',
									'" . $database->real_escape_string($this->hotel_fee) . "',
									'" . $database->real_escape_string($your_picks) . "',
									'" . $database->real_escape_string($this->your_picks_description) . "',
									'" . $database->real_escape_string($amenities) . "',
									'" . $database->real_escape_string($this->features) . "',
									'" . $database->real_escape_string($this->location_description) . "',									
									'" . $database->real_escape_string($this->guest_favourites) . "',
									'" . utf8_decode($database->real_escape_string($this->overview)) . "',
									'" . utf8_decode($database->real_escape_string($this->whywe_like)) . "',
									'" . $database->real_escape_string($this->status) . "',
									'" . $order_id . "',
									NOW()
									)";
			}
			
			//print $sql;
			// exit;
			$result			= $database->query($sql);
			
			if($database->affected_rows == 1)
			{
				if($this->poll_id == 0)
				{
					$this->poll_id	= $database->insert_id;
				}
				$this->initialize($this->poll_id);
			}
		
			$this->message = cnst11;
			return true;
		}
		else
		{
			return false;	
		}
		
	}
	
	//The function check the poll name eixst or not
	public function check_poll_exist($vendor_name='', $vendor_type_id =0, $poll_id=0)
	{
		$database	= new database();
		$output			= true;
		if($vendor_name == '')
		{
			$this->message	= "Vendor name should not be empty.";
			$this->warning	= true;
		}
		else
		{
			if($poll_id > 0)
			{
				$sql	= "SELECT *	 FROM poll WHERE vendor_name = '" . $database->real_escape_string($vendor_name) . "' AND vendor_type_id='". $vendor_type_id."' AND poll_id != '" . $poll_id . "'";
			}
			else
			{
				$sql	= "SELECT *	 FROM poll WHERE vendor_name = '" . $database->real_escape_string($vendor_name) . "' AND vendor_type_id='". $vendor_type_id."'";
			}
			//print $sql;
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$this->message	= "Vendor name is already exist.";
				$this->warning	= true;
			}
			else
			{
				$output			= false;
			}
			
		}
		return $output;	
	}
	
	public static function get_random_poll()
	{
		$poll_id	= 0;
		$database	= new database(); //
		$sql		= "SELECT * FROM poll as p INNER JOIN  poll_gallery AS pg ON p.poll_id = pg.poll_id WHERE  poll_status_id !=2 AND live_status='Y'";
		$result 	= $database->query($sql);
		$poll_ids =array();
		if ($result->num_rows > 0)
		{
			while($data				= $result->fetch_object()){
				$poll_ids[]	= $data->poll_id;
			}
			
		}
		return $poll_ids;
	}

	public static function get_homepage_background($start){
	
		$result_array=array();
		$result_array1=array();
		$result_array2=array();
		$poll_id_array1=array();
		$poll_id_array2=array();
		$database	= new database();
		
		//$start=0;
		$end=5;
		
		
		//ORDER BY RAND() LIMIT 1
		$sql		= "SELECT * FROM poll WHERE poll_status_id !=2 AND live_status='Y' LIMIT ".$start.",". $end;
		$result 	= $database->query($sql);
		
		while($data	= $result->fetch_object())
		{
		    
			$back_image=poll_gallery::getpoll_gallery_image($data->poll_id);
			
			$poll_id_array1[]=$data->poll_id;
			
			if( !empty($back_image) && file_exists(DIR_poll_GALLERY.'resize_'.$back_image)){
				$data->back_image=$back_image;
				$result_array[]=$data;
			}
			//print_r($data);
			
		}
		
		return $result_array;			
	}
	
	public static function get_homepage_background_total_count(){
	
		$result_array=array();
		$result_array1=array();
		$result_array2=array();
		$poll_id_array1=array();
		$poll_id_array2=array();
		$database	= new database();
		
		//$start=0;
		$end=5;
		
		
		//ORDER BY RAND() LIMIT 1
		$sql		= "SELECT * FROM poll WHERE poll_status_id !=2 AND live_status='Y' ";
		$result 	= $database->query($sql);
		
		while($data	= $result->fetch_object())
		{
		    
			$back_image=poll_gallery::getpoll_gallery_image($data->poll_id);
			
			$poll_id_array1[]=$data->poll_id;
			
			if( !empty($back_image) && file_exists(DIR_poll_GALLERY.'resize_'.$back_image)){
				$data->back_image=$back_image;
				$result_array[]=$data;
			}
			//print_r($data);
			
		}
		
		return sizeof($result_array);			
	}
	
	

	public static function get_homepage_background_1_7_14($start){
	
		$result_array=array();
		$result_array1=array();
		$result_array2=array();
		$poll_id_array1=array();
		$poll_id_array2=array();
		$database	= new database();
		
		//$start=0;
		$end=3;
		
		//ORDER BY RAND() LIMIT 1
		$sql		= "SELECT *, PTY.image_name as back_image FROM poll AS PT INNER JOIN  poll_gallery AS PTY ON PT.poll_id= PTY.poll_id WHERE PTY.background_image='Y' AND PT.poll_status_id !=2 AND PT.live_status='Y' LIMIT ".$start.",". $end;
		$result 	= $database->query($sql);
		
		while($data	= $result->fetch_object())
		{
			$poll_id_array1[]=$data->poll_id;
			$result_array1[]=$data;
			
			//echo URI_poll_GALLERY.'resize2_'.$data->back_image;
		}
		
		$sql1		= "SELECT *, PTY.image_name as back_image  FROM poll AS PT INNER JOIN  poll_gallery AS PTY ON PT.poll_id= PTY.poll_id WHERE PTY.background_image='Y' AND PT.poll_status_id !=2 AND PT.live_status='Y' GROUP BY PTY.poll_id ORDER BY PTY.poll_gallery_id ASC LIMIT ".$start.",". $end;
		$result1 	= $database->query($sql1);
		
		
		while($data1	= $result1->fetch_object())
		{
			$poll_id=$data1->poll_id;
			if(!in_array($poll_id,$poll_id_array1)){
				$poll_id_array1[]=$poll_id;
				$result_array2[]=$data1;
			}
		}
		$result_array= array_merge($result_array1,$result_array2);
		return $result_array;			
	}


	public static function get_homepage_background12_30_13($poll_id)
	{
		$image_list		= array();
		$database		= new database();
		$sql					= "SELECT * FROM poll_gallery  WHERE  poll_id = '" . $poll_id . "' ORDER BY order_id DESC";
		$result				= $database->query($sql);
		while($data		= $result->fetch_object())
		{
			$image_list[] = $data->image_name;
		}
		return $image_list;
	}

	public static function get_homepage_background_old(){
	
		$result_array=array();
		$database	= new database();
		//ORDER BY RAND() LIMIT 1
		$sql		= "SELECT *, PTY.image_name as background_image FROM poll AS PT INNER JOIN  poll_gallery AS PTY ON PT.poll_id= PTY.poll_id WHERE PTY.background_image='Y' AND PT.poll_status_id !=2 AND PT.live_status='Y'";
		$result 	= $database->query($sql);
		
		if ($result->num_rows <= 0)
		{   //LIMIT 1
			$sql		= "SELECT *, PTY.image_name as background_image FROM poll AS PT INNER JOIN  poll_gallery AS PTY ON PT.poll_id= PTY.poll_id WHERE PT.poll_status_id !=2 AND PT.live_status='Y' GROUP BY PTY.poll_id ORDER BY PTY.poll_gallery_id ASC ";
			$result 	= $database->query($sql);
		}
		while($data	= $result->fetch_object())
		{
			$result_array[]=$data;
		}
		return $result_array;			
	}
	
	
	
	
	
	
	
	
	public static function get_homepage_background_12_31_13(){
	
		$result_array=array();
		$database	= new database();
		//ORDER BY RAND() LIMIT 1
		$sql		= "SELECT *, PTY.image_name as back_image FROM poll AS PT INNER JOIN  poll_gallery AS PTY ON PT.poll_id= PTY.poll_id WHERE PTY.background_image='Y' AND PT.poll_status_id !=2 AND PT.live_status='Y'
		UNION
		SELECT *, PTY.image_name as back_image FROM poll AS PT INNER JOIN  poll_gallery AS PTY ON PT.poll_id= PTY.poll_id WHERE PT.poll_status_id !=2 AND PT.live_status='Y' GROUP BY PTY.poll_id ORDER BY poll_gallery_id  ASC
		 ";
		$result 	= $database->query($sql);
		//echo $result->num_rows;
		/*if ($result->num_rows <= 0)
		{   //LIMIT 1
			$sql		= "SELECT * FROM poll AS PT INNER JOIN  poll_gallery AS PTY ON PT.poll_id= PTY.poll_id WHERE PT.poll_status_id !=2 AND PT.live_status='Y' ORDER BY PTY.poll_gallery_id ASC ";
			$result 	= $database->query($sql);
		}*/
		while($data	= $result->fetch_object())
		{
			$result_array[]=$data;
		}
		return $result_array;			
	}
	
	// Remove the current object details.
	public function remove()
	{
		$database	= new database();
		if ( isset($this->_properties['poll_id']) && $this->_properties['poll_id'] > 0) 
		{
			$sql = "DELETE FROM poll WHERE poll_id = '" . $this->poll_id . "'";
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
	public function remove_selected($poll_ids)
	{
		$database	= new database();
		if(count($poll_ids)>0)
		{		
			foreach($poll_ids as $poll_id)
			{
				$poll_details= new poll($poll_id);
				
				poll_gallery::remove_by_poll($poll_id);
				poll_rating::remove_by_poll($poll_id);
								
				$sql = "DELETE FROM poll WHERE poll_id = '" . $poll_id . "'";
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
	
	public function display_list()
	{
		$database				= new database();
		$validation			 	= new validation(); 
		$functions              = new functions();
		$param_array			= array();
		$search_cond_array      = array();

		$sql 					= "SELECT * FROM poll";
		$drag_drop 				= '';

		if(isset($_REQUEST['search_word']) ||  $_REQUEST['poll_type'] > 0 ) 
		{
			$search_word	= functions::clean_string($_REQUEST['search_word']);
					
			if(!empty($_REQUEST['search_word']))
			{									   
				$param_array[]="search_word=".functions::clean_string($_REQUEST['search_word']);
				$search_word_array		= explode(" ", $this->search_word);
				for($i = 0; $i < count($search_word_array); $i++)
				{
					$search_cond	.= ($i == 0) ? " (poll_name like '%" . $database->real_escape_string($search_word_array[$i]) . "%' ) " : " OR  (poll_name like '%" . $database->real_escape_string($search_word_array[$i]) . "%' ) ";	
				}
				
				$search_cond_array[]	= $search_cond;
								
				//$search_cond_array[]="vendor_name like '%".$database->real_escape_string(addslashes(functions::clean_string($search_word)))."%'";		   
			}
			
			if($_REQUEST['poll_type'] > 0)
			{
					$param_array[]="poll_type=".$_REQUEST['poll_type'];			
					$search_cond_array[]="poll_type = '".$database->real_escape_string($_REQUEST['poll_type'])."'";		
			}

			// Drag and dorp ordering is not available in search
			$drag_drop 						= ' nodrag nodrop ';
		}
		
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
				
		$sql			.= $search_condition;
		$sql 			= $sql . " ORDER BY order_id DESC";
		$result			= $database->query($sql);
		
		$this->num_rows = $result->num_rows;
		$functions->paginate($this->num_rows);
		$start			= functions::$startfrom;
		$limit			= functions::$limits;
		$sql 			= $sql . " limit $start, $limit";
		$result			= $database->query($sql);
		//echo $sql;
		$param=join("&amp;",$param_array); 
		$this->pager_param=$param;
		
		if ($result->num_rows > 0)
		{				
			$i 			= 0;
			$row_num	= functions::$startfrom;
			$page		= functions::$startfrom > 0 ? (functions::$startfrom / PAGE_LIMIT) + 1 : 1;
			
			echo '
			<tr class="lightColorRow nodrop nodrag" style="display:none;">
				<td colspan="6" class="noBorder">
					<input type="hidden" id="show"  name="show" value="0" />
					<input type="hidden" id="poll_id" name="poll_id" value="0" />
					<input type="hidden" id="show_poll_id" name="show_poll_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					<input type="hidden" id="page" name="page" value="' . $page . '" />
				</td>
			</tr>';
			
			while($data=$result->fetch_object())
			{
				$i++;
				$row_num++;
				$poll_serial_value++;
				$class_name		= (($row_type%2) == 0) ? "even" : "odd";
				
				//$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
				//$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
				
				$sel = ($data->selected == 'Y') ?  'Selected': 'No';
				
				$location  = new location($data->location_id);
				$member		= new member($data->created_by); 
				$start_date = ($data->start_date != '0000-00-00') ? date('d-M-Y', strtotime($data->start_date)) : ''; //No date decided yet
				$end_date   = ($data->end_date != '0000-00-00') ? date('d-M-Y', strtotime($data->end_date)) : '';
				$location_name = ($location->name != '') ? $location->name: '';
				
				echo '
					<tr id="' . $data->poll_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td class="widthAuto ">'.functions::deformat_string($this->poll_type_array[$data->poll_type]) . '</td>
						<td class="alignCenter">' . $start_date . '</td>
						<td class="alignCenter">' . $end_date . '</td>
						<td class="widthAuto">' . functions::deformat_string($location_name) . '</td>						
						<td class="alignCenter">
							<a href="manage_poll.php?poll_id=' . $data->poll_id . '">10</a>
						</td>			
						
						<td class="alignCenter">'.$sel.'</td>';
						
						
						/*echo '
						
						
						
						<td class="alignCenter deleteCol">';
						if(poll::check_poll_assign($data->poll_id)==0)
						{
							echo '<label><input type="checkbox" name="checkbox[' . $data->poll_id . ']" id="checkbox" /></label>';
						}
						else
						{
						     echo '&nbsp';	
						}
							
						echo '</td>	*/
					echo '</tr>
					
					<tr id="details'.$i.'" class="expandRow nodrag nodrop" >
								<td id="details_div_'.$i.'" colspan="13" height="1" ></td>
							</tr>
					';
				$row_type++;
			}
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
		}
		else
		{
			/*$this->pager_param1 = join("&",$param_array);
			if(isset($_GET['page']))
			{
				$currentPage = $_GET['page'];
			}
			if($currentPage>1)
			{
				$currentPage = $currentPage-1;
				if($this->pager_param=="")
				{
					$urlQuery = 'manage_poll.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_poll.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{*/
				echo "<tr><td colspan='5' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			/*}*/
		}
	}
	
	
	
	public function display_poll_reminder()
	{
		$database				= new database();
		$validation				= new validation(); 
		$param_array			= array();
		$sql 					= "SELECT * FROM poll";
		$drag_drop 				= '';
		$search_condition		= '';
				
		if(isset($_REQUEST['search_word'])) 
		{
			$search_word	= functions::clean_string($_REQUEST['search_word']);
					
			if(!empty($_REQUEST['search_word']))
			{									   
				$param_array[]="search_word=".functions::clean_string($_REQUEST['search_word']);			
				$search_cond_array[]="title like '%".$database->real_escape_string(addslashes(functions::clean_string($search_word)))."%'";		
					   
			}
			if(!empty($_REQUEST['client_id']))
			{
				
					$param_array[]="client_id=".$_REQUEST['client_id'];			
					$search_cond_array[]="client_id = '".$database->real_escape_string($_REQUEST['client_id'])."'";		
			}
			
			if(!empty($_REQUEST['poll_category_id']))
			{
					$param_array[]="poll_category_id=".$_REQUEST['poll_category_id'];			
					$search_cond_array[]="poll_category_id = '".$database->real_escape_string($_REQUEST['poll_category_id'])."'";		
			}
			
			
			// Drag and dorp ordering is not available in search
			$drag_drop 						= ' nodrag nodrop ';
		}
		
		if(($this->poll_id!=0) && ($this->poll_id!=''))
		  {
			 $param_array[]="poll_id=".$this->poll_id;			
			$search_cond_array[]="poll_id = '".$this->poll_id."'";	  
			  
		}
		  $param_array[]="poll_date <='".date("Y-m-d",time())."'";			
		  $search_cond_array[]="poll_date <='".date("Y-m-d",time())."'";		
		  
		  
		  $param_array[]="poll_reminder_status ='N'";			
		  $search_cond_array[]="poll_reminder_status ='N'";	
		  
		  $param_array[]="read_status='N'";			
		  $search_cond_array[]="read_status = 'N'";	
		 
		  
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
				
		$sql			.= $search_condition;
		$sql 			= $sql . " ORDER BY order_id Asc";
		$result			= $database->query($sql);
		
		$this->num_rows = $result->num_rows;
		functions::paginate($this->num_rows);
		$start			= functions::$startfrom;
		$limit			= functions::$limits;
		$sql 			= $sql . " limit $start, $limit";
		$result			= $database->query($sql);
		//echo $sql;
		$param=join("&amp;",$param_array); 
		$this->pager_param=$param;
		
		if ($result->num_rows > 0)
		{				
			$i 			= 0;
			$row_num	= functions::$startfrom;
			$page		= functions::$startfrom > 0 ? (functions::$startfrom / PAGE_LIMIT) + 1 : 1;
			
			echo '
			<tr class="lightColorRow nodrop nodrag" style="display:none;">
				<td colspan="6" class="noBorder">
					<input type="hidden" id="show"  name="show" value="0" />
					<input type="hidden" id="poll_id" name="poll_id" value="'.$this->poll_id.'" />
					<input type="hidden" id="show_poll_id" name="show_poll_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					<input type="hidden" id="page" name="page" value="' . $page . '" />
				</td>
			</tr>';
			
			while($data=$result->fetch_object())
			{
				$i++;
				$row_num++;
				$poll_serial_value++;
				$class_name		= (($row_type%2) == 0) ? "even" : "odd";
				$poll_category	= new poll_category($data->poll_category_id);
			    $client_details= new client($data->client_id);
				
			
				echo '
					<tr id="' . $data->poll_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td class="widthAuto"><a style="cursor:pointer; " title="Click here to view details" onClick="javascript:open_poll_details(\''.$data->poll_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$poll_serial_value.'\');return false;">' . functions::deformat_string($data->title) . '</a></td>
						
						<td class="widthAuto"><a style="cursor:pointer; " title="Click here to view details" onClick="javascript:open_poll_details(\''.$data->poll_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$poll_serial_value.'\');return false;">' . functions::deformat_string($client_details->first_name)." ".functions::deformat_string($client_details->surname) . '</a></td>';
						echo '<td class="widthAuto">';
						if($data->assign_status =='Y')
						{
							$tenant= house::get_tenant($data->poll_id);
							
						if(substr_count($tenant->client_ids,",")>0)
						{
							$clients_list=explode(",",$tenant->client_ids);
							$client_names="";
							for($j=0;$j<count($clients_list);$j++)
							{
								$client_details = new client($clients_list[$j]);
								$client_names.= functions::deformat_string($client_details->first_name)." ".functions::deformat_string($client_details->surname);
								if($j<count($clients_list)-1)
								{
									$client_names.= ", ";
								}
							}
						}
						else
						{
						$client_details= new client($tenant->client_ids);
						$client_names = functions::deformat_string($client_details->first_name)." ".functions::deformat_string($client_details->surname);
						}
						echo '<a style="cursor:pointer; " title="Click here to view details"   onclick="show_tenant_details(\''.$tenant->client_ids.'\');">' . $client_names. '</a>';
						}
						else
						{
							 echo '&nbsp;';
						}
						echo  '</td>
						
						<td class="alignCenter">
								<a href="register_poll_message.php?poll_id=' . $data->poll_id . '"><img src="images/icon-message.png" alt="Inspection" title="Inspection" width="24" height="24" /></a>
						</td>
						<!--<td class="alignCenter">
							<a href="manage_poll_comment.php?poll_id=' . $data->poll_id . '"><img src="images/icon-comment.png" alt="Notes" title="Notes" width="24" height="24" /></a>
						</td>-->
						<td class="alignCenter">
							<a href="manage_poll_download.php?poll_id=' . $data->poll_id . '"><img src="images/icon-downloads.png" alt="Manage Documents" title="Manage Documents" width="15" height="16" /></a>
						</td>
						<!--<td class="alignCenter">
							<a href="manage_poll_gallery.php?poll_id=' . $data->poll_id . '"><img src="images/icon-image.png" alt="Manage Image" title="Manage Image" width="15" height="16" /></a>
						</td>-->
						<!--<td class="alignCenter">
							<a href="register_poll.php?poll_id=' . $data->poll_id . '&page=manage_poll_inspection.php';
							 if(($this->poll_id!=0) && ($this->poll_id!=''))
							{
							 echo '&poll_exists=1';
							}
							else
							{
								 echo '&poll_exists=0';
							}
							echo '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>-->
						<td class="alignCenter deleteCol">
							<label><input type="checkbox" name="checkbox[' . $data->poll_id . ']" id="checkbox" /></label>
						</td>	
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
					$urlQuery = 'manage_poll.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_poll.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='5' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
	
	
	public function get_tag_list()
	{
		$database		= new database();
		$poll_tag_array = array();
		$sql			= "SELECT * FROM poll ";
		$result			= $database->query($sql);
		$num_rows		= $result->num_rows;
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$tags = explode(',', $data->tag);
				for($i = 0; $i < count($tags); $i++)
				{
					$tag = trim(functions::deformat_string($tags[$i]));
					$poll_tag_array[] = $tag;
				}
			}
		}
		
		$poll_tags = array_unique($poll_tag_array);
		sort($poll_tags);
		
		for($i = 0; $i < count($poll_tags); $i++)
		{
			$style = rand(1,6);
			$tag = functions::deformat_string($poll_tags[$i]);
			echo '<h' . $style . '><a href="poll.php?tag=' . $tag . '">' . $tag . '</a></h' . $style . '>';
		}
	}
	
	public function get_poll_list()
	{
		$database				= new database();
		$poll_comment			= new poll_comment();
		$param_array			= array();
		$sql 					= "SELECT * FROM poll";
		$search_condition		= '';
		
		if($this->search_key != '' && $this->search_key == 'poll_category_id')		
		{
			$param_array[] 			= "poll_category_id=" . $this->search_value;
			$search_cond_array[]	= " poll_category_id = '" . $this->search_value . "' ";			   
		}
		else if($this->search_key != '' && $this->search_key == 'tag')
		{
			$param_array[] 			= "tag=" . $this->search_value;
			$search_cond_array[]	= " tag like '%" . $this->search_value . "%' ";			   
		}
		else if($this->search_key != '' && $this->search_key == 'date')
		{
			list($month, $year)		= explode('-',$this->search_value);
			$param_array[] 			= "date=" . $this->search_value;
			$search_cond_array[]	= " year(poll_date) = '" . $year . "' ";
			$search_cond_array[]	= " month(poll_date) = '" . $month . "' ";			   
		}
		
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
				
		$sql			.= $search_condition;
		$sql 			= $sql . " ORDER BY poll_date DESC";
		$result			= $database->query($sql);
		
		$this->num_rows = $result->num_rows;
		//functions::paginate($this->num_rows);
		functions::paginate_poll($this->num_rows, 0, 0, 'CLIENT');
		$start			= functions::$startfrom;
		$limit			= functions::$limits;
		$sql 			= $sql . " limit $start, $limit";
		//print $sql;
		$result			= $database->query($sql);
		
		$param=join("&amp;",$param_array); 
		$this->pager_param=$param;
		
		$poll_array		= array();
		$functions= new functions();
		if ($result->num_rows > 0)
		{				
			$i 			= 0;
			$row_num	= functions::$startfrom;
			$page		= functions::$startfrom > 0 ? (functions::$startfrom / FRONT_PAGE_LIMIT) + 1 : 1;			
			while($data=$result->fetch_object())
			{
				echo '<div class="poll_post_outer">
						<div class="poll_post">
							<h2><a href="poll_details.php?poll_id=' . $data->poll_id . '">' . functions::deformat_string($data->title) . '</a></h2>
							';
							$poll_comment_count = $poll_comment->get_poll_comment_count($data->poll_id, 'Y');
							if($poll_comment_count == 0)
							{
								echo 'No comments.';
							}
							else
							{
								echo '<a href="poll_details.php?poll_id=' . $data->poll_id . '#comments">' . $poll_comment_count . ' comments.</a>';
							}
							
							echo ' Posted by '. functions::deformat_string($data->poll_author) . ' in ';
							$tags = explode(',', $data->tag);
							for($i = 0; $i < count($tags); $i++)
							{
								$tag = trim(functions::deformat_string($tags[$i]));
								echo '<a href="poll.php?tag=' . $tag . '">' . $tag . '</a>';
								if($i < (count($tags)-1))
								{
									echo ', ';	
								}
							}
							echo ' on ' . functions::get_format_date($data->poll_date, "dS F  Y") . ' <br />
							<br />' . $functions->get_sub_string(functions::deformat_string($data->poll_post), 250) . '
							<a href="poll_details.php?poll_id=' . $data->poll_id . '">Read more >> </a>
							</div>';
							echo ' <!-- <div class="poll_post_img"> <img src="images/poll_image.jpg" /> </div> -->
					</div>';
				
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
					$urlQuery = 'poll.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'poll.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<div align='center' class='warningMesg'>Sorry.. No records found !!</div>";
			}
		}
	}
	
	public static function get_breadcrumbs($poll_id, $poll_side=false)
	{
		$poll 		= new poll($poll_id);			
		if($poll_side)
		{
			$bread_crumb[]			= "<a href='poll.php'>poll</a>";
		}
		else
		{
			$bread_crumb[]			= "<a href='manage_poll.php'>poll</a>";
			
		}
					
		$bread_crumb[]			= functions::deformat_string($poll->title);
		
		if(count($bread_crumb)>0)
		{
			$bread_crumbs=join(" >> ",$bread_crumb);
		}
		return $bread_crumbs;
	}
	
	public static function get_archive_list()
	{
		$database			= new database();
		$category_options 	= array();
		$sql				= "
								SELECT distinct 
								year(poll_date) as poll_year
								, month(poll_date) as poll_month ,
								DATE_FORMAT( poll_date, '%M %Y' ) AS poll_date 
								FROM poll 
								order 
								by year(poll_date) 
								, month(poll_date) DESC 
								";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$category_array = array();
			while($data = $result->fetch_object())
			{
				$category_array['poll_year'] = $data->poll_year;
				$category_array['poll_month']	= $data->poll_month;
				$category_array['poll_date']	= $data->poll_date;
				$category_options[]	= $category_array;
			}
		}
		return $category_options;
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
			$sql = "UPDATE poll SET order_id = '" . $order_id . "' WHERE poll_id = '" . $id_array[$i] . "'";
			$database->query($sql);
			$order_id++;
		}
	}
	
	public function get_latest_poll_list($poll_category_id = 0, $max_limit)
	{
		$database			= new database();
		$poll_array 	= array();
		$sql			= "SELECT * FROM poll WHERE poll_category_id='".$poll_category_id."' ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$poll_image_sql				= "SELECT * FROM poll_image WHERE poll_id='".$data->poll_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$poll_image_result				= $database->query($poll_image_sql);				
				if ($poll_image_result->num_rows > 0)
				{
					$poll_image_data = $poll_image_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_PORTFOLIO_IMAGE . 'thumb_' . $poll_image_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_PORTFOLIO_IMAGE, PORTFOLIO_THUMB_WIDTH, PORTFOLIO_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_PORTFOLIO_IMAGE . 'thumb_' . $poll_image_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>

<div class="sidebar">
	<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
		<h2><a href="poll.php?cid=<?php echo $poll_category_id; ?>&pid=<?php echo $data->poll_id; ?>"><?php echo functions::deformat_string($data->title); ?></a></h2>
		<p><?php echo functions::get_sub_words(functions::deformat_string($data->poll_post), 20); ?> <a href="poll.php?cid=<?php echo $poll_category_id; ?>&pid=<?php echo $data->poll_id; ?>">Read More</a></p>
	</div>
</div>
<?php
			}
		}
	}
	
	
	
	
	
	public function get_latest_poll_by_category_list($max_limit)
	{
		$database			= new database();
		$poll_array 	= array();
		$sql			= "SELECT * FROM poll GROUP BY poll_category_id ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$poll_image_sql				= "SELECT * FROM poll_image WHERE poll_id='".$data->poll_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$poll_image_result				= $database->query($poll_image_sql);				
				if ($poll_image_result->num_rows > 0)
				{
					$poll_image_data = $poll_image_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_PORTFOLIO_IMAGE . 'thumb_' . $poll_image_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_PORTFOLIO_IMAGE, PORTFOLIO_THUMB_WIDTH, PORTFOLIO_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_PORTFOLIO_IMAGE . 'thumb_' . $poll_image_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
<div class="sidebar">
	<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
		<h2><a href="poll.php?cid=<?php echo $data->poll_category_id; ?>&pid=<?php echo $data->poll_id; ?>"><?php echo functions::deformat_string($data->title); ?></a></h2>
		<p><?php echo functions::get_sub_words(functions::deformat_string($data->poll_post), 20); ?> <a href="poll.php?cid=<?php echo $poll_category_id; ?>&pid=<?php echo $data->poll_id; ?>">Read More</a></p>
	</div>
</div>
<?php
			}
		}
	}
	
	
	
	
	
		
		// Returns the max order id
		public static function get_max_order_id()
		{
			$database	= new database();
			$sql		= "SELECT MAX(order_id) AS order_id FROM poll";
			//echo $sql;
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
		
		
		public function export_poll_list()
	{
		$order_list			= '';
		$status               	= '';
		$database				= new database();
		
		$param_array			= array();
		$sql 					= "SELECT * FROM poll ";
		
	
		 #p.methodId=o.paymentMethod && p.status='Y'
		if ($this->search_word != "" || $this->poll_id != 0  || $this->poll_category_id != 0 )
		{
			
			
         if(($this->search_word != "") && ($this->search_word != " "))
			{		
									   
				$param_array[]="search_word=".$this->search_word;			
				$search_cond_array[]="title like '%".$this->search_word."%'";		
					   
			}
			 if(($this->poll_id != "") && ($this->poll_id != 0))
			{
					$param_array[]="poll_id=".$this->poll_id;			
					$search_cond_array[]="poll_id = '".$this->poll_id."'";		
			}
			 if(($this->poll_category_id != "") && ($this->poll_category_id != 0))
			{
					$param_array[]="poll_category_id=".$this->poll_category_id;			
					$search_cond_array[]="poll_category_id = '".$this->poll_category_id."'";		
			}
				
	}	
	
		
		if(count($search_cond_array)>0) 
		{
			$search_condition	= " WHERE " . join(" AND ", $search_cond_array); 
			$sql				.= $search_condition;
		}
		
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
			$sortField	= "order_id ";
			$sortOrder	= "Asc";
			$sql		.= " ORDER BY ".$sortField." ".$sortOrder;
		}
		
		//echo $sql;
		//exit;
		$result						= $database->query($sql);
		$this->num_rows				= $result->num_rows;
		if ($result->num_rows > 0)
		{
		
				$order_list	.= functions::array_to_csvstring(array('No:','poll Address','Landlord','Address Line 1','Address Line 2','Address Line 3','Town','Postcode','Category','poll Type','Furnish','Price','Bedroom','Bathroom','Inspection Date','Google Map Code','Managed','Description','Key Code','Access Notes','Alarm Codes','Key Available','Rent Protection','Insurance Cover Policy','Status','Featured Status'));
			
			
			
			
			
			
			$i=0;
			//poll_id 	title 	poll_id 	address1 	address2 	address3 	town 	postcode 	poll_category_id 	price 	bed_room 	bath_room 	square_feet 	poll_date 	description 	status 	added_date 	order_id
			while($data=$result->fetch_object())
			
			{
				
				    $i++;
					$newlines				= array("\r\n", "\n", "\r");
					
					
					$bdate		= explode('-', $data->poll_date);
			        $poll_date	= $bdate[2] . '-' .  $bdate[1] . '-' . $bdate[0];
					
					$client_details= new client($data->client_id);
					
					$poll_category = new poll_category($data->poll_category_id);
				 $poll_sub_category = new poll_category($data->sub_category_id);
				
				$poll 		= new poll($poll_id);
				$furnished	= $poll->get_furnished($data->furnished_id);
				
				 $manage	= $poll->get_manage($data->manage_id);
		       
				
		
				
					$order_list	.= functions::array_to_csvstring(
											array(
												$i,
												functions::deformat_string($data->title),
												functions::deformat_string($client_details->first_name ." ".$client_details->surname),
												functions::deformat_string($data->address1),
												functions::deformat_string($data->address2),
												functions::deformat_string($data->address3),
												functions::deformat_string($data->town),
												functions::deformat_string($data->postcode),
												functions::deformat_string($poll_category->category_name),
												functions::deformat_string($poll_sub_category->category_name),
												functions::deformat_string($furnished),
												functions::deformat_string($data->price),
												functions::deformat_string($data->bed_room),
												functions::deformat_string($data->bath_room),												
												functions::deformat_string($poll_date),												
												functions::deformat_string($manage),
												functions::deformat_string(spoll_tags(substr($data->description,0,100))),																					
												functions::deformat_string($data->key_code),
												functions::deformat_string($data->access_notes),
												functions::deformat_string($data->alarm_codes),
												functions::deformat_string($data->key_available),												
												functions::deformat_string($data->rent_protection),
												functions::deformat_string($data->insurance_cover_policy),
												functions::deformat_string($data->status),
												functions::deformat_string($data->featured_status),											
											)
										);
										
				
						
			}
		}
		return $order_list;
	}
	
	
	 function message_count()
	   {
		   
		  $database			= new database();
		$poll_message_array 	= array();
		$sql			= "SELECT * FROM poll   where  poll_date <= '".date("Y-m-d",time())."' AND poll_reminder_status='N' and  read_status='N'"; 
		
		$result			= $database->query($sql);
		return $result->num_rows;
		   
	  }
	  
	  
	  public  static function get_poll()
		{
			 
			$database	= new database();
			$sql		= "SELECT poll_id,title  FROM poll WHERE  status = 'Y' AND assign_status='N' ORDER BY order_id ASC ";
			//echo $sql;
			$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$poll_array = array();
			while($data = $result->fetch_object())
			{
				
				$poll_array['poll_id'] = $data->poll_id;
				$poll_array['title']	= $data->title;
				$poll[]	= $poll_array;
			  
			}
		}
		return $poll;
			
			
		}
	 
	 
	 	// The function is used to change the status.
		public static function update_terms_condition_status($poll_id, $status = '')
		{		
			$database		= new database();
			$poll			= new poll($poll_id);
			//$current_status = $member->status;
			if($status == '')
			{
				$status =  $poll->terms_condition_status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE poll 
						SET terms_condition_status = '". $status . "'
						WHERE poll_id = '" . $poll_id . "'";
						//echo $sql;
			$result 	= $database->query($sql);
			
				return $status;
		}
		
		
		
		// The function is used to change the status.
		public static function update_status($poll_id, $status = '')
		{		
			$database		= new database();
			$poll			= new poll($poll_id);
			$current_status = $poll->status;
			if($status == '')
			{
				$status =  $poll->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE poll 
						SET status = '". $status . "'
						WHERE poll_id = '" . $poll_id . "'";
			$result 	= $database->query($sql);
			
			
			
			return $status;
		}
		
		public function get_poll_status_array()
		{
			return $this->poll_status_array;
		}
		
	    public function get_poll_status($key)
		{
			return $this->poll_status_array[$key];
		}
		public function get_furnished_array()
		{
			return $this->furnished_array;
		}
		 public function get_furnished($key)
		{
			return $this->furnished_array[$key];
		}
		public function get_manage_array()
		{
			return $this->manage_array;
		}
		 public function get_manage($key)
		{
			return $this->manage_array[$key];
		}
		
		public function get_available_status_array()
		{
			return $this->available_status_array;
		}
		 public function get_available($key)
		{
			return $this->available_status_array[$key];
		}
		
		public function get_rent_protection_status_array()
		{
			return $this->rent_protection_status_array;
		}
		 public function get_rent_protection($key)
		{
			return $this->rent_protection_status_array[$key];
		}
		
		public function get_rent_sheild_array()
		{
			return $this->rent_sheild_array;
		}
		 public function get_rent_sheild($key)
		{
			return $this->rent_sheild_array[$key];
		}
		
		
		
		public function get_user_poll_list($poll_type_id=1)
		{
			$database			= new database();
			$param_array		= array();
			$functions= new functions();
			$search_condition	= '';
			$sql 				= "SELECT * FROM poll ";
			$search_condition		= '';
			//town bed_room  bath_room minprice  maxprice
			$param_array[]			= "page_number=" . $this->page_number;
			$search_cond_array[]="poll_type_id='".$database->real_escape_string($poll_type_id)."'";   
			
			
		if($this->search=="true" ||$this->search_condition=="true")
		{	$param_array[]			= "refine_search=" . $this->refine_search;
			if($this->beds!=""){
				$param_array[]="beds=".$this->beds;	
				$search_cond_array[]="beds='".$database->real_escape_string($this->beds)."'";   
			}
			if(($this->postcode!=0) && ($this->postcode!=""))
			{
					$param_array[]="postcode=".$this->postcode;			
					$search_cond_array[]="postcode ='".$database->real_escape_string($this->postcode)."'";		
			}
			if($poll_type_id==1){
				if(($this->minprice!=0) && ($this->minprice!="")&& ($this->maxprice!=0) && ($this->maxprice!="")){
					$param_array[]			= "minprice=" . $this->minprice;
					$param_array[]			= "maxprice=" . $this->maxprice;
					$search_cond_array[]	= "price >='" . $database->real_escape_string($this->minprice) . "'";	
					$search_cond_array[]	= "price <='" . $database->real_escape_string($this->maxprice) . "'";	
				}elseif($this->minprice=='1000000'){
					$param_array[]			= "minprice=" . $this->minprice;
					$search_cond_array[]	= "price >='" . $database->real_escape_string($this->minprice) . "'";
				}elseif($this->maxprice=='1000000'){
					$param_array[]			= "maxprice=" . $this->maxprice;
					$search_cond_array[]	= "price <='" . $database->real_escape_string($this->maxprice) . "'";
				}
			}else{
				
				if(($this->minprice!=0) && ($this->minprice!="")&& ($this->maxprice!=0) && ($this->maxprice!="")){
					$param_array[]			= "minprice=" . $this->minprice;
					$param_array[]			= "maxprice=" . $this->maxprice;
					$search_cond_array[]	= "price >='" . $database->real_escape_string($this->minprice) . "'";	
					$search_cond_array[]	= "price <='" . $database->real_escape_string($this->maxprice) . "'";	
				}elseif($this->minprice=='2500'){
					$param_array[]			= "minprice=" . $this->minprice;
					$search_cond_array[]	= "price >='" . $database->real_escape_string($this->minprice) . "'";
				}elseif($this->maxprice=='2500'){
					$param_array[]			= "maxprice=" . $this->maxprice;
					$search_cond_array[]	= "price <='" . $database->real_escape_string($this->maxprice) . "'";
				}
				
			}
			//echo $this->radius_miles,$this->postcode;exit;
			if((($this->radius_miles!=0) && ($this->radius_miles!=""))){
			
			//echo "fsdf";exit;
					
				   $param_array[]="postcode=".$this->postcode;
				   $param_array[]="radius_miles=".$this->radius_miles;	
				  
					//to calculate the distance
					$user_postcode = $this->postcode;
					$dist_zip	   = array();
					$user_sql 	   = "SELECT latitude, longitude FROM uk_postcode WHERE postcode = '$user_postcode'";	
					$user_result   = $database->query($user_sql);
					
					if ($user_result->num_rows > 0){				 
						
						$user_data 	= $user_result->fetch_object();	
						$l1			= $user_data->latitude;
						$o1			= $user_data->longitude;
										
						
						//$coords = array('latitude' => $l1, 'longitude' => $o1);				
						//$radius = $this->distance;
		
						// SQL FOR KILOMETERS
		
						//$sql = "SELECT zipcode, ( 6371 * acos( cos( radians( {$coords['latitude']} ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( {$coords['longitude']} ) ) + sin( radians( {$coords['latitude']} ) ) * sin( radians( latitude ) ) ) ) AS distance FROM zipcodes HAVING distance <= {$radius} ORDER BY distance";
		
						// SQL FOR MILES
		
						//$zip_sql = "SELECT zipcode, ( 3959 * acos( cos( radians( {$coords['latitude']} ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( {$coords['longitude']} ) ) + sin( radians( {$coords['latitude']} ) ) * sin( radians( latitude ) ) ) ) AS distance 
									//FROM zipcodes HAVING distance <= {$radius} ORDER BY distance";
									
						$zip_sql = "SELECT postcode, ( 3959 * acos( cos( radians( ".$l1." ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ".$o1." ) ) + sin( radians( ".$l1." ) ) * sin( radians( latitude ) ) ) ) AS distance 
									FROM uk_postcode HAVING distance <= ".$this->radius_miles." ORDER BY distance ";			
		
						// OUTPUT THE ZIPCODES AND DISTANCES
		
						$zip_result = $database->query($zip_sql);
						
						if ($zip_result->num_rows > 0){
		
							while($zip_data 	= $zip_result->fetch_object()){
			
								//echo "Zipcode : ".$zip_data->postcode." Distance : ".$zip_data->distance."<br/><br/>";
								$dist_zip[] = "'".$zip_data->postcode."'";
							}
						}
						//print_r ($dist_zip);
						
						if (count($dist_zip) > 0){
							$dist_zip_str   	= implode(',',$dist_zip);
							$search_cond_array[]	=  "postcode IN (".$dist_zip_str.") "; 		
						}							
						
					}	
								
		
				   
				   
				   
				   	 
			}
			$drag_drop 						= ' nodrag nodrop ';
		}
		
		 $search_cond_array[]="live_status = 'Y'";	 
		 $search_cond_array[]=" 	poll_status_id != '2'";
		 $search_cond_array[]=" 	draft = '0'";	 
		if(count($search_cond_array)>0) { 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
			
					
			$sql				.= $search_condition;
			
			//$sql				.=" group by poll_id ";
			
			if(($this->minprice!=0) && ($this->minprice!="")&& ($this->maxprice!=0) && ($this->maxprice!=""))
			{
			  $sort_order="";
			  
			  $sort_order= " ORDER BY price Desc";
			
			}
			else
			{
				$param_array[]			= "order=" . $this->order;
				$order="poll_id desc";
				
				if($this->order=='poll_desc'){ $order="poll_id desc";}
				if($this->order=='poll_asc'){ $order="poll_id asc";}
				if($this->order=='price_desc'){ $order="price desc";}
				if($this->order=='price_asc'){ $order="price asc";}
				if($this->order=='bed_desc'){ $order="beds desc";}
				if($this->order=='bed_asc'){ $order="beds asc";}
				
				$sort_order= " ORDER BY ".$order;
			}
			$sql 				= $sql .$sort_order;
			//echo $sql ;
			$result				= $database->query($sql);
			
			$this->num_rows = $result->num_rows;
			
			/*if($start==0){	
				$_SESSION[
			}*/
			//functions::paginate($this->num_rows);
			if($this->page_number !='all'){
				$functions->paginateclient_poll($this->num_rows, 0, 0, 'CLIENT');
				$start			= functions::$startfrom;
				$limit			= functions::$limits;
				$sql 			= $sql . " limit $start, $limit";
			}
			
			
			$result			= $database->query($sql);

			//print $sql;
			
						
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			$poll_array		= array();
			if ($result->num_rows > 0)
			{				
				$i 			= 0;
				$row_num	= functions::$startfrom;
				$page		= functions::$startfrom > 0 ? (functions::$startfrom / $this->page_number) + 1 : 1;	
				
				
				while($data=$result->fetch_object())
				{
					$i++;
				
				$poll_id	=$data->poll_id;
				$image_name=poll_gallery::getpoll_gallery_image($data->poll_id);
				
				$beds= $data->beds;
				switch($beds){
					case 0:
					$bed_no="Sero ";
					break;
					case 1:
					$bed_no="One ";
					break;
					case 2:
					$bed_no="Two ";
					break;
					case 3:
					$bed_no="Three ";
					break;
					case 4:
					$bed_no="Four ";
					break;
					case 5:
					$bed_no="Five ";
					break;
					case 6:
					$bed_no="Six ";
					break;
					case 7:
					$bed_no="Seven ";
					break;
					case 8:
					$bed_no="Eight ";
					break;
					case 9:
					$bed_no="Nine ";
					break;
					case 10:
					$bed_no="Ten ";
					break;
					default:
					$bed_no="Eight ";
					break;
					
				}
				?>
                
                
                
                <div id="listing_wrapper">
                <div id="listing_leftcol">
                <!----------listing img---------->
                <div id="listing_img">  <a href="poll_details.php?id=<?php echo $data->poll_id;?>">
                
                <?php 
				if(file_exists(DIR_poll_GALLERY.'thumb_'. $image_name) && $image_name != '')
				{
				?>
                <img src="<?php echo URI_poll_GALLERY.'thumb_'. $image_name;?>" alt="View" title="View" width="362" height="241" border="0" />
                
                <?php }elseif(file_exists(DIR_poll_GALLERY. $image_name) && $image_name != ''){
							//echo '<img src="'.URI_PRODUCT . 'thumb_' . $data->image_name.'"/>';
						?>
							<img src="image_resize.php?image=<?php echo $image_name; ?>&width=<?php echo poll_GALLERY_THUMB_WIDTH; ?>&height=<?php echo poll_GALLERY_THUMB_HEIGHT; ?>&dir=poll" border="0" width="362" height="241" />
                <?php  }else{
				?>
                <img src="images/no-image.png" border="0" width="362" height="241" />
                <?php 
				}?>
                </a></div>
                <!----------listing img---------->
                
                
                <!----------listing features---------->
                <div id="listing_features">
                
                
                <!----------bedrooms---------->
                <div class="feature_wrapper">
                <div class="feature_icon">
                <img src="images/sales/icons/bedrooms.png" />
                </div>
                <div class="feature_text">
                <?php echo $bed_no;?><br />
                Bedrooms
                </div>
                <div class="clearall"></div>
                </div>
                <!----------bedrooms---------->
                
                
                <!----------download---------->
                
                <div class="feature_wrapper">
                <div class="feature_icon">
                <img src="images/sales/icons/download.png" />
                </div>
                <div class="feature_text_link">
                <a href="download_poll.php?id=<?php echo $poll_id;?>" title="Download poll">Download<br />poll</a>
                </div>
                <div class="clearall"></div>
                </div>
                
                <!----------download---------->
                
                <!----------map---------->
                <div class="feature_wrapper">
                <div class="feature_icon">
                <img src="images/sales/icons/map.png" />
                </div>
                <div class="feature_text_link">
                <a href="map.php?id=<?php echo $poll_id;?>&school=0" title="Look on map">Look<br />on map</a>
                </div>
                <div class="clearall"></div>
                </div>
                
                <!----------map---------->
                
                <!----------school areas---------->
                
                <div class="feature_wrapper">
                <div class="feature_icon">
                <img src="images/sales/icons/schools.png" />
                </div>
                <div class="feature_text_link">
                <a href="map.php?id=<?php echo $poll_id;?>&school=1" title="Schools areas">Schools and Transport</a>
                </div>
                <div class="clearall"></div>
                </div>
                <!----------school areas---------->
                </div>
                <!----------listing features---------->
                </div>
                <div id="listing_rightcol">
                <div id="listing_details">
                <div id="details_header">
                <div id="details_title">
                <?php echo functions::deformat_string($data->house_number).", ".functions::deformat_string($data->street).", ".functions::deformat_string($data->town);?>
                </div>
                <div id="details_price">
                &pound;<?php echo number_format($data->price, 0, '.', ',');
				echo $data->suffix != '' ? ' ' . $data->suffix : '';
				?>
                </div>
                </div>
                <p>
               
                <?php echo functions::deformat_string($data->summary_overview);
				// echo substr(functions::deformat_string($data->poll_details),0,138);
				//if(strlen(functions::deformat_string($data->poll_details))>138){
				?>
                <!--...-->
                <br />
                
                <a href="poll_details.php?id=<?php echo $data->poll_id;?>" title="Read more">Read more</a>
                <?php // }?>
                </p>
                </div>
                </div>
                <div class="clearall"></div>
                </div>
                  

		<?php
				}
				$param=join("&amp;",$param_array); 
				$this->pager_param=$param;
			}
			else
			{
				echo "<div align='center' class='warningMesg' style='margin-top:20px; float:left; clear:both;rgb(45, 14, 75);'>Unfortunately there are no properties available under your search criteria. To discuss your needs in more detail, please visit our contact page to find your nearest office.</div>";
			}
		}
		
		
		
		
		
		
		
		public function get_user_poll_page_count($poll_type_id=1)
		{
			$database			= new database();
			$param_array		= array();
			$functions= new functions();
			$search_condition	= '';
			$sql 				= "SELECT * FROM poll ";
			$search_condition		= '';
			//town bed_room  bath_room minprice  maxprice
			$param_array[]			= "page_number=" . $this->page_number;
			$search_cond_array[]="poll_type_id='".$database->real_escape_string($poll_type_id)."'";   
			
			
		if($this->search=="true" ||$this->search_condition=="true")
		{	$param_array[]			= "refine_search=" . $this->refine_search;
			if($this->beds!=""){
				$param_array[]="beds=".$this->beds;	
				$search_cond_array[]="beds='".$database->real_escape_string($this->beds)."'";   
			}
			if(($this->postcode!=0) && ($this->postcode!=""))
			{
					$param_array[]="postcode=".$this->postcode;			
					$search_cond_array[]="postcode ='".$database->real_escape_string($this->postcode)."'";		
			}
			if(($this->minprice!=0) && ($this->minprice!="")&& ($this->maxprice!=0) && ($this->maxprice!="")){
				$param_array[]			= "minprice=" . $this->minprice;
				$param_array[]			= "maxprice=" . $this->maxprice;
				$search_cond_array[]	= "price >='" . $database->real_escape_string($this->minprice) . "'";	
				$search_cond_array[]	= "price <='" . $database->real_escape_string($this->maxprice) . "'";	
			}
			//echo $this->radius_miles,$this->postcode;exit;
			if((($this->radius_miles!=0) && ($this->radius_miles!=""))){
			
			//echo "fsdf";exit;
					
				   $param_array[]="postcode=".$this->postcode;
				   $param_array[]="radius_miles=".$this->radius_miles;	
				  
					//to calculate the distance
					$user_postcode = $this->postcode;
					$dist_zip	   = array();
					$user_sql 	   = "SELECT latitude, longitude FROM uk_postcode WHERE postcode = '$user_postcode'";	
					$user_result   = $database->query($user_sql);
					
					if ($user_result->num_rows > 0){				 
						
						$user_data 	= $user_result->fetch_object();	
						$l1			= $user_data->latitude;
						$o1			= $user_data->longitude;
						$zip_sql = "SELECT postcode, ( 3959 * acos( cos( radians( ".$l1." ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ".$o1." ) ) + sin( radians( ".$l1." ) ) * sin( radians( latitude ) ) ) ) AS distance 
									FROM uk_postcode HAVING distance <= ".$this->radius_miles." ORDER BY distance ";			
		
						// OUTPUT THE ZIPCODES AND DISTANCES
		
						$zip_result = $database->query($zip_sql);
						
						if ($zip_result->num_rows > 0){
		
							while($zip_data 	= $zip_result->fetch_object()){
			
								//echo "Zipcode : ".$zip_data->postcode." Distance : ".$zip_data->distance."<br/><br/>";
								$dist_zip[] = "'".$zip_data->postcode."'";
							}
						}
						//print_r ($dist_zip);
						
						if (count($dist_zip) > 0){
							$dist_zip_str   	= implode(',',$dist_zip);
							$search_cond_array[]	=  "postcode IN (".$dist_zip_str.") "; 		
						}							
						
					}	
								
		
				   
				   
				   
				   	 
			}
			$drag_drop 						= ' nodrag nodrop ';
		}
		
		 $search_cond_array[]="live_status = 'Y'";	 
		$search_cond_array[]=" 	poll_status_id != '2'";
		
		if(count($search_cond_array)>0) { 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
			
					
			$sql				.= $search_condition;
			
			//$sql				.=" group by poll_id ";
			
			if(($this->minprice!=0) && ($this->minprice!="")&& ($this->maxprice!=0) && ($this->maxprice!=""))
			{
			  $sort_order="";
			  
			  $sort_order= " ORDER BY price Desc";
			
			}
			else
			{
				$param_array[]			= "order=" . $this->order;
				$order="poll_id desc";
				
				if($this->order=='poll_desc'){ $order="poll_id desc";}
				if($this->order=='poll_asc'){ $order="poll_id asc";}
				if($this->order=='price_desc'){ $order="price desc";}
				if($this->order=='price_asc'){ $order="price asc";}
				if($this->order=='bed_desc'){ $order="beds desc";}
				if($this->order=='bed_asc'){ $order="beds asc";}
				
				$sort_order= " ORDER BY ".$order;
			}
			$sql 				= $sql .$sort_order;
			//echo $sql ;
			$result				= $database->query($sql);
			
			$this->num_rows = $result->num_rows;
			//functions::paginate($this->num_rows);
			if($this->page_number !='all'){
				$functions->paginateclient_poll($this->num_rows, 0, 0, 'CLIENT');
				$start			= functions::$startfrom;
				$limit			= functions::$limits;
				$sql 			= $sql . " limit $start, $limit";
			}
			//print $sql;
			$result			= $database->query($sql);
			
			
			unset($_SESSION['num_rows']);
			unset($_SESSION['start_page']);
			unset($_SESSION['end_page']);
			$_SESSION['num_rows']=$this->num_rows;
			$_SESSION['start_page']=$start+1;	
			$_SESSION['end_page']=$start+$result->num_rows;
			
			
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			$poll_array		= array();
			if ($result->num_rows > 0)
			{				
				$i 			= 0;
				$row_num	= functions::$startfrom;
				$page		= functions::$startfrom > 0 ? (functions::$startfrom / $this->page_number) + 1 : 1;	
				
				
				while($data=$result->fetch_object())
				{
					$i++;
				
				$poll_id	=$data->poll_id;
				//$image_name=poll_gallery::getpoll_gallery_image($data->poll_id);
				
				?>
                
                

		<?php
				}
				$param=join("&amp;",$param_array); 
				$this->pager_param=$param;
			}
			else
			{
				
			}
		}
		
		
		
		
		
		
		
	  public static function check_thumb_exist($image_name)
	   {
		if(file_exists(DIR_poll . 'thumb_' .$image_name))
		{
		  $status='Y';
		}
		else
		{
		$status='N';
		}
		return $status;
				  
	  }
	  
	  public static function get_random_images($background_image_id=0)
		{
			$database	= new database();
			$sql		= "SELECT * FROM background_image where background_image_id !='".$background_image_id."' ORDER BY Rand() Limit 0, 1";
			//echo $sql;
			$result		= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data = $result->fetch_object();
				$_SESSION['BACKGEROUND_IMAGE_ID']=$data->background_image_id; 
				return $data->image_name;
			}
		}
		
		
		
	   	// Returns the max order id
	public static function get_min_price()
	{
		$database	= new database();
		$sql		= "SELECT MIN(price) AS price FROM poll";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$data	= $result->fetch_object();
			return $data->price > 0 ? $data->price : 0;
		}
		else
		{
			return 0;
		}
	}
	
	
	   	// Returns the max order id
	public static function get_max_price()
	{
		$database	= new database();
		$sql		= "SELECT MAX(price) AS price FROM poll";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$data	= $result->fetch_object();
			return $data->price > 0 ? $data->price : 0;
		}
		else
		{
			return 0;
		}
	}
		
		
	public  function get_landlord_poll_old()
	{}	
  
  
  
     public  function get_landlord_poll()
	{}	
  
     public static function check_active_poll($poll_id)
	 {
		 $database			= new database();
		 $param_array		= array();
		$search_condition	= '';
		$sql 				= "SELECT * FROM poll ";
		$search_condition		= '';
			
		$search_cond_array[]="poll_id ='".$poll_id."'";
		$search_cond_array[]="(assign_date IS NULL OR assign_date  > NOW() - INTERVAL 2 WEEK)";
		  if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
			$sql				.= $search_condition;
			
			//echo $sql ;
			$result				= $database->query($sql);
			
			return  $result->num_rows;
		 
	}
	
	public static function get_key_features($poll_id)
	{
		$features_array	= array();
		$poll		= new poll($poll_id);
		if($poll->key_features != '')
		{
			$feature = explode("\n",$poll->key_features);
			for($i = 0; $i < count($feature); $i++)
			{
				if(trim($feature[$i]) != '')
				{
					$features_array[] = $feature[$i];
				}
			}
			
			echo '<div class="keyfeaturestitle">Key Features :</div>';
			$count		= count($features_array);
			$first_half	= $count/2;
			$second_half= $count - $first_half;
			$odd		= $count%2;
			$counter	= 0;
			
			echo '<div class="keyfeturesbox"><ul>';
			for($i = 0; $i < $first_half; $i++)
			{
				$counter++;
				echo  "<li>" . functions::deformat_string($features_array[$i]) ."</li>";
			}
			echo '</ul></div>';
			echo '<div class="keyfeturesbox"><ul>';
			for($i =0; $i < ($second_half - $odd); $i++)
			{
				echo   "<li>" . functions::deformat_string($features_array[$counter++]) ."</li>";
			}
			echo '</ul></div>';
		}
	}
	
	 function get_random_my_featured_poll($poll_id)
	 {
		  $database	= new database();
		  $client_id=$_SESSION[CLIENT_ID];
			$rows_count= 0;
			$rows_count1=0;
			$sql		= "SELECT * FROM poll where poll_id !='".$poll_id."'   and client_id='".$client_id."'  and  featured_status ='Y' ORDER BY Rand() Limit 0, 1";
			//echo $sql;
			$result		= $database->query($sql);
			 $rows_count=$result->num_rows;
			if($rows_count==0)
			{
			$sql		= "SELECT * FROM poll where featured_status ='Y'  and client_id='".$client_id."'  ORDER BY Rand() Limit 0, 1";
			//echo $sql;
			$result		= $database->query($sql);
			$rows_count1=$result->num_rows;	
			}
			if($rows_count1==0)
			{
			$sql		= "SELECT * FROM poll  where client_id='".$client_id."' ORDER BY Rand() Limit 0, 1";
			$result		= $database->query($sql);
			$rows_count2=$result->num_rows;	
			}
			if ($result->num_rows > 0)
			{
				$data = $result->fetch_object();
				$_SESSION['MY_poll_ID']=$data->poll_id; 
				echo '<div class="right_blackbox">
 	                  <div class="featuredprprtycontent">
                <h1>'.functions::deformat_string($data->title).'<br />'.functions::deformat_string($data->town).'</h1><div  style="width=100%;">' .functions::get_sub_string(functions::deformat_string($data->description ),300,true).'</div><div class="btn_enquire2" style="float:left;" onclick="show_poll_enquiry('.$data->poll_id.');"></div>
          <a href="poll_details.php?poll_id='.$data->poll_id.'"><div class="btn_moreinfo" style="float:left;"></div></a>
       </div>
 	</div>';
			} 
		 
		 
	}
	
	
	 	public static function check_poll_assign($poll_id = 0)
		{
			$database	= new database();
			$client_array = array();
			
			$sql		= "SELECT *	 FROM  house  where poll_id='".$poll_id."'";
			$result		= $database->query($sql);
			 return $result->num_rows;
			
		}
			
		
		public  function property_listing_all9()
		{
			$location 	= new location(1);
			$database	= new database();
			//$poll   = new poll();
			$functions= new functions();
			$param_array		= array();
			
			$sql 		= "SELECT v.vendor_type_id FROM vendor_type AS v JOIN poll AS p ON v.vendor_type_id = p.vendor_type_id WHERE v.status='Y' AND p.status='Y' GROUP BY  v.vendor_type_id ORDER BY v.vendor_type_id ASC"; 
			$result		= $database->query($sql);
			
			if($result->num_rows > 0)
			{
				while($data 	= $result->fetch_object())
				{
					$vendor_type 	= new vendor_type($data->vendor_type_id);
					$title = strtoupper($location->name.' '. $vendor_type->name);
					echo '<section class="curated_filter_box">
						  <div class="result_heading">'.functions::deformat_string($title).'</div>
						  <div class="filter_type"><span class="filter_typetxt">Filter by:</span>
							<a href="#"><div class="filter_typebox">Price</div></a>
							<a href="#"><div class="filter_typebox">Vibe</div></a>
						  </div>
						</section>';
						
					echo '<section class="curated_search_result_box">
							<ul>';
					$sql1			= "SELECT * FROM poll WHERE vendor_type_id ='". $data->vendor_type_id."' AND status='Y' ORDER BY order_id DESC LIMIT 3";
					$result1		= $database->query($sql1);
					/*$this->num_rows = $result1->num_rows;
					$functions->paginateclient_property($this->num_rows, 1, $this->pager_param, 'CLIENT');
					$start			= functions::$startfrom1;
					$limit			= functions::$limits1;
					$sql1 			= $sql1 . " limit $start, $limit";
					$result			= $database->query($sql);
			
					$param=join("&amp;",$param_array); 
					$this->pager_param=$param;*/
					
					
					while($data1 	= $result1->fetch_object())
					{
						$image_name = poll_gallery::get_cover_image($data1->poll_id);
						$name 		=(strlen($data1->vendor_name) > 25) ? substr($data1->vendor_name, 0, 25). '...': $data1->vendor_name;
						/*if($data->vendor_type_id == 1)
						{
							$desc       = (strlen($data1->features)> 95) ? substr(functions::deformat_string($data1->features), 0, 95).'...': functions::deformat_string($data1->features);
						}
						else
						{*/
							$desc       = (strlen($data1->overview)> 95) ? substr(functions::deformat_string($data1->overview), 0, 95).'...': functions::deformat_string($data1->overview);	
						//}
						
						$price		= (substr($data1->price, -3) == '.00') ? substr($data1->price, 0, -3): $data1->price;
						
						echo '<li>
								<!--<i class="time"></i>-->
								<a href="individual_view.php?poll_id='.$data1->poll_id.'">';
								if($image_name != '') {
									if(file_exists(DIR_poll_GALLERY.'thumb_'.$image_name))
									{
										echo '<img src="'.URI_poll_GALLERY.'thumb_'.$image_name.'" width="100%" height="auto">';
									}
									else
									{
										echo '<img src="'.URI_poll_GALLERY.'thumb2_'.$image_name.'" width="100%" height="auto">';
									}
									
								}
								echo '<h1>'.functions::deformat_string($name).'</h1>
								<p>'.$desc.'</p>';
								if($data->vendor_type_id == 1)
								{
									echo '<div class="curated_price">&dollar;'. functions::deformat_string($price).'<span class="curated_price_nght">/night</span></div>';
									echo '<i class="more" id="more_'.$data1->poll_id.'"></i>';	
								}
								
								
								echo '</a>
								</li>';	
					}
					
					echo '</ul>
						</section>';
				}
			}
			else
			{
				echo '<section class="curated_filter_box"><div class="result_heading">Sorry.... No results found!</div></section>';
	  	 	}
			//echo $result->num_rows;
			
			
			$sql		= "SELECT * FROM poll WHERE status='Y'";
			$result		= $database->query($sql);
			
			/*echo $sql 		= "select a.* AS cnt from poll a where  (select count(*) from poll as b  where a.vendor_type_id = b.vendor_type_id and a.poll_id >= b.poll_id ) <= 3 ORDER BY vendor_type_id ASC, order_id ASC";

			$result		= $database->query($sql);
			
			if($result->num_rows > 0)
			{
				$i = 0;
				while($data 	= $result->fetch_object())
				{
					if($i == 0 || $i%3 ==0)
					{
						echo '<section class="curated_filter_box">
						  <div class="result_heading">LAS VEGAS HOTEL</div>
						  <div class="filter_type"><span class="filter_typetxt">Filter by:</span>
							<a href="#"><div class="filter_typebox">Price</div></a>
							<a href="#"><div class="filter_typebox">Vibe</div></a>
						  </div>
						</section>';
						
						echo '<section class="curated_search_result_box">
							<ul>';
					}
    
						
							echo '<li>
								<i class="time"></i>
								<a href="#">
								<img src="images/thump1.jpg" width="100%" height="auto">
								<h1>The Palazzo</h1>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum ...</p>
								<div class="curated_price">$129<span class="curated_price_nght">/night</span></div>
								<i class="more"></i>
								</a>
								</li>';
					$i++;			
					if($i%3 == 0)
					{
						echo '</ul>
						</section>';
					}
						
				}
			}
			else
			{
				echo '<section class="curated_filter_box"><div class="result_heading">LAS VEGAS HOTEL</div></section>';
	  	 	}*/
			
		}
		
		public  function property_listing_all()
		{
			$location 	= new location($this>location_id);
			$vendor_type 	= new vendor_type($this->vendor_type_id);
			
			$database	= new database();
			$functions= new functions();
			$param_array		= array();
			
			$start_min_price	= ($this->minprice > 0) ? $this->minprice: poll::get_minprice();
			$end_max_price		= ($this->maxprice > 0) ? $this->maxprice : poll::get_maxprice();
			
			//echo $this->vendor_type_id;
			$param_array[]="location_id=".$this->location_id;
			$param_array[]="vendor_type_id=".$this->vendor_type_id;
			
			if($_REQUEST['odr'] == "ASC"){
				$odr = "DESC";
			}	
			else if($_REQUEST['odr'] == "DESC"){
				$odr = "ASC";
			}	
			else{
				$odr = "ASC";
			}
			
			$title = strtoupper($location->name.' '. $vendor_type->name);
			echo '<section class="curated_filter_box">
				  <div class="result_heading">'.functions::deformat_string($title).'</div>
				  <div class="filter_type"><span class="filter_typetxt">Filter by:</span>
					<a href="full_list.php?location='.$this->location_id.'&vendor_type='.$this->vendor_type_id.'&minprice='.$start_min_price.'&maxprice='.$end_max_price.'&sort=price&odr='.$odr.'"><div class="filter_typebox">Price</div></a>
					<a href="full_list.php?location='.$this->location_id.'&vendor_type='.$this->vendor_type_id.'&minprice='.$start_min_price.'&maxprice='.$end_max_price.'&sort=rating_order&odr='.$odr.'""><div class="filter_typebox">Vibe</div></a>
				  </div>
				</section>';	
											
			$sql 		= "SELECT * FROM poll WHERE location_id='".$this->location_id."' AND vendor_type_id='". $this->vendor_type_id."' AND status='Y'"; 
			
			
			if($this->vendor_type_id == 1)
			{
				if($this->minprice > 0)
				{
					if($start_min_price == $end_max_price)
					{
						$sql    .= " AND  price = $start_min_price";
					}
					else
					{
						$sql    .= " AND  price BETWEEN $start_min_price AND $end_max_price";
					}
				}
			}
			
			//echo $sql;
			
			$result		= $database->query($sql);
			while($data = $result->fetch_object())
			{
				$rate	= poll_rating::get_rating($data->poll_id);
				$sql1	= "UPDATE poll SET rating_order='". $rate."' WHERE poll_id='". $data->poll_id."'";
				$result1		= $database->query($sql1);
			}
						
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
				$sortField	= "poll_id";
				$sortOrder	= "DESC";
				$sql		.= " ORDER BY ".$sortField." ".$sortOrder;
			}
			
			
			$result		= $database->query($sql);
			$this->num_rows = $result->num_rows;
			$functions->paginateclient_property($this->num_rows, 0, $this->pager_param, 'CLIENT');
			$start			= functions::$startfrom1;
			$limit			= functions::$limits1;
			$sql 			= $sql . " limit $start, $limit";
			$result		= $database->query($sql);
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			if($result->num_rows > 0)
			{
				echo '<section class="curated_search_result_box">
					<ul>';
				
				while($data 	= $result->fetch_object())
				{
						$image_name = poll_gallery::get_cover_image($data->poll_id);
						$name 		=(strlen($data->vendor_name) > 25) ? substr($data->vendor_name, 0, 25). '...': $data->vendor_name;
						/*if($data->vendor_type_id == 1)
						{
							$desc       = (strlen($data1->features)> 95) ? substr(functions::deformat_string($data1->features), 0, 95).'...': functions::deformat_string($data1->features);
						}
						else
						{*/
							$desc       = (strlen($data->overview)> 125) ? substr(functions::deformat_string($data->overview), 0, 125).'...': functions::deformat_string($data->overview);	
						//}
						
						$price		= (substr($data->price, -3) == '.00') ? substr($data->price, 0, -3): $data->price;
						
						echo '<li>
								<!--<i class="time"></i>-->
								<a href="individual_view.php?poll_id='.$data->poll_id.'">';
								if($image_name != '') {
									if(file_exists(DIR_poll_GALLERY.'thumb_'.$image_name))
									{
										echo '<img src="'.URI_poll_GALLERY.'thumb_'.$image_name.'" width="100%" height="auto">';
									}
									else
									{
										echo '<img src="'.URI_poll_GALLERY.'thumb2_'.$image_name.'" width="100%" height="auto">';
									}
									
								}
								else
								{
									echo '<img src="images/noimage.jpg" width="100%" height="auto">';	
								}
								
								echo '<h1>'.utf8_encode(functions::deformat_string($name)).'</h1>
								<p>'.utf8_encode($desc).'</p>';
								if($data->vendor_type_id == 1)
								{
									//echo '<div class="curated_price">&dollar;'. functions::deformat_string($price).'<span class="curated_price_nght">/night</span></div>';
									//echo '<i class="more" id="more_'.$data1->poll_id.'"></i>';	
								}
								
								
								echo '</a>
								</li>';	
					
					
					
				}
				
				echo '</ul>
						</section>';
			}
			else
			{
				echo '<section class="curated_filter_box"><div class="result_heading" style="margin-left:250px;">Sorry.... No results found!</div></section>';
	  	 	}			
			
		}
		
		public static function  get_minprice()
		{
			$database	= new database();
			$sql		= "SELECT MIN(price) AS minprice FROM poll WHERE vendor_type_id =1 AND status='Y'";
			$result		= $database->query($sql);
			
			if($result->num_rows > 0)
			{
				$data =  $result->fetch_object();
				$min	= $data->minprice;
				if($min != NULL && $min > 0)
				{
					if($min % 100 > 0)
					{
						$min 	= $min-($min % 100);	
					}
				}
				else
				{
					$min = 100;	
				}
				return $min;
			}
			else
			{
				return 100;
			}
		}
		
		public static function  get_maxprice()
		{
			$database	= new database();
			$sql		= "SELECT MAX(price) AS maxprice FROM poll WHERE vendor_type_id =1 AND status='Y'";
			$result		= $database->query($sql);
			if($result->num_rows > 0)
			{
				$data =  $result->fetch_object();
				$max	= $data->maxprice;
				if($max != NULL && $max > 0)
				{
					if($max % 100 < 100)
					{
						$max = $max-($max %100)+100;	
					}
				}
				else
				{
					$max = 2000;
				}
				return $max;
			}
			else
			{
				return 2000;
			}
		}
		
		
		
		
}
?>
