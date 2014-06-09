<?php

/*********************************************************************************************

	Author 	: V V VIJESH

	Date	: 14-April-2011

	Purpose	: Testimonial class

*********************************************************************************************/

    class planning_rating

	{

		protected $_properties		= array();

		public    $error			= '';

		public    $message			= '';

		public    $warning			= '';



        function __construct($planning_rating_id = 0)

		{
            $this->error	= '';

			$this->message	= '';

			$this->warning	= false;

			if($planning_rating_id > 0)

			{
				$this->initialize($planning_rating_id);
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

		private function initialize($planning_rating_id)

		{

			$database	= new database();

			$sql		= "SELECT *	 FROM planning_rating WHERE planning_rating_id = '$planning_rating_id'";

			$result		= $database->query($sql);

			

			if ($result->num_rows > 0)

			{

				$this->_properties	= $result->fetch_assoc();

			}

		}

		

		// Save the review details

		public function save()

		{

			$database	= new database();
				$idate 		= explode('-', $this->date);
				$planning_rating_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];
				if ( isset($this->_properties['planning_rating_id']) && $this->_properties['planning_rating_id'] > 0) 
				{
					$sql	= "UPDATE planning_rating SET planning_id = '". $database->real_escape_string($this->planning_id) . "',rating = '". $database->real_escape_string($this->rating) . "', comment = '". $database->real_escape_string($this->comment) . "', rating_name = '". $database->real_escape_string($this->rating_name) . "', email = '". $database->real_escape_string($this->email) . "', status = '". $database->real_escape_string($this->status) . "' WHERE planning_rating_id = '$this->planning_rating_id'";
				}
				else 
				{
					$order_id	= self::get_max_order_id() + 1;
					
					$sql		= "INSERT INTO planning_rating 
								(planning_id, rating, comment, rating_name, email,order_id, status, added_date) 
								VALUES (
								        '" . $database->real_escape_string($this->planning_id) . "',
										'" . $database->real_escape_string($this->rating) . "',
										'" . $database->real_escape_string($this->comment) . "',
										'" . $database->real_escape_string($this->rating_name) . "',
										'" . $database->real_escape_string($this->email) . "',
										'".$order_id."',
										'" . $database->real_escape_string($this->status) . "',
										NOW()
										)";

				}
				echo $sql;
				//exit;
				$result			= $database->query($sql);
				if($database->affected_rows == 1)
				{
					if($this->planning_rating_id == 0)
					{
						$this->planning_rating_id	= $database->insert_id;
					}
				}
				$this->initialize($this->planning_rating_id);
				$this->message = cnst11;
				return true;
		}
		
			// Returns the max order id
		public static function get_max_order_id()
		{
			$database	= new database();
			$sql		= "SELECT MAX(order_id) AS order_id FROM planning_rating ";
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
		
		//The function check the planning_rating category eixst or not
		public function check_planning_rating_exist($details='', $planning_rating_id=0)

		{

			$output		= false;

			$database	= new database();

			if($details == '')

			{

				$this->message	= "Des should not be empty!";

				$this->warning	= true;

			}

			else

			{

				if($planning_rating_id > 0)

				{

					$sql	= "SELECT *	 FROM planning_rating WHERE title = '" . $database->real_escape_string($title) . "' AND planning_rating_id != '" . $planning_rating_id . "'";

				}

				else

				{

					$sql	= "SELECT *	 FROM planning_rating WHERE title = '" . $database->real_escape_string($title) . "'";

				}

				//print $sql;

				$result 	= $database->query($sql);

				if ($result->num_rows > 0)

				{

					$this->message	= "Testimonial number is already exist!";

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

			if ( isset($this->_properties['planning_rating_id']) && $this->_properties['planning_rating_id'] > 0) 

			{

				$sql = "DELETE FROM planning_rating WHERE planning_rating_id = '" . $this->planning_rating_id . "'";

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

		public function remove_selected($planning_rating_ids)

		{

			$database	= new database();

			if(count($planning_rating_ids)>0)

			{		

				foreach($planning_rating_ids as $planning_rating_id)

				{

					/*$planning_rating		= new planning_rating($planning_rating_id);

					$author_name = $planning_rating->author_name;

					if(file_exists(DIR_NEWS . $author_name))

					{

						unlink(DIR_NEWS . $author_name);

					}

					if(file_exists(DIR_NEWS . 'thumb_' . $author_name))

					{

						unlink(DIR_NEWS . 'thumb_' . $author_name);

					}  */

					

					$sql = "DELETE FROM planning_rating WHERE planning_rating_id = '" . $planning_rating_id . "'";

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

		

		public function get_my_planning_rating()

		{

			$database	= new database();

			$title	= $_SESSION[MEMBER_ID];

			$sql		= "SELECT * FROM planning_rating WHERE title = $title ORDER BY planning_rating_date DESC";

			$result		= $database->query($sql);

			$idate		= 0;

			if ($result->num_rows > 0)

			{	

				while($data=$result->fetch_object())

				{

					$i++;

					$planning_rating_serial_value++;

					$row_num++;

			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	

					

					$idate			= explode('-', $data->planning_rating_date);

				  	$planning_rating_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];

					echo "<tr>

							<td align='center'>$i</td>

							<td>$planning_rating_date</td>

							<td>$data->description</td>

							<td><a href='$data->planning_rating_url' target='_blank'><img src='images/view-planning_rating.png' border='0' title='View'></a></td>

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

			$sql					= "SELECT * FROM planning_rating ";

			$drag_drop				= '';

			

			$search_cond_array[]	= " planning_id = '$this->planning_id' ";

			$param_array[]			= "planning_id=$this->planning_id";

		

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

						$search_word_array		= explode(" ", $search_word);

					for($i = 0; $i < count($search_word_array); $i++)

					{

						$search_cond_array[]	= " (

												rating like '%" . $database->real_escape_string($search_word_array[$i]) . "%'  OR 
												comment like '%" . $database->real_escape_string($search_word_array[$i]) . "%'
												) ";	

					}

					//	$search_cond_array[]	= " small_desc like '%" . $database->real_escape_string($search_word) . "%' ";

						//$search_cond_array[]	= " details like '%" . $database->real_escape_string($search_word) . "%' ";

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

						

			$sql 			= $sql . " ORDER BY planning_rating_id  DESC";

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

					<td colspan="6"  class="noBorder">

						<input type="hidden" id="show"  name="show" value="0" />

               			<input type="hidden" id="planning_rating_id" name="planning_rating_id" value="0" />

						<input type="hidden" id="show_planning_rating_id" name="show_planning_rating_id" value="0" />

						<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />

						<input type="hidden" id="page" name="page" value="' . $page . '" />

					</td>

                </tr>';

				

				while($data=$result->fetch_object())

				{

					$i++;

					$planning_rating_serial_value++;

					$row_num++;

			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	

					

					$status			= $data->status == 'Y' ? 'Active' : 'Inactive';

					$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';

					

					

					$idate			= explode('-', $data->date);

				  	$planning_rating_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];
					echo '
						<tr id="' . $data->planning_rating_id . '" class="' . $class_name . $drag_drop . '" >
							<td class="alignCenter pageNumberCol">' . $row_num . '</td>
					 <td class="noBorder handCursor" onclick="javascript: open_planning_rating_details(\''.$data->planning_rating_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$planning_rating_serial_value.'\');"  title="Click here to view details" >'.functions::deformat_string($data->rating).'</td>
					 
					 <td class="noBorder handCursor" onclick="javascript: open_planning_rating_details(\''.$data->planning_rating_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$planning_rating_serial_value.'\');"  title="Click here to view details" >'.substr(strip_tags($data->comment),0, 100).'</td>
					 
					    <!--<td class="noBorder handCursor" onclick="javascript: open_planning_rating_details(\''.$data->planning_rating_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$planning_rating_serial_value.'\');"  title="Click here to view details" >'.functions::deformat_string($data->name).'</td>
						
						<td class="noBorder handCursor" onclick="javascript: open_planning_rating_details(\''.$data->planning_rating_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$planning_rating_serial_value.'\');"  title="Click here to view details" >'.functions::deformat_string($data->email).'</td>-->
						
						<td class="noBorder handCursor" onclick="javascript: open_planning_rating_details(\''.$data->planning_rating_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$planning_rating_serial_value.'\');"  title="Click here to view details" >'.date('d-m-Y', strtotime($data->added_date)).'</td>
						
					    <td class="alignCenter">
								<a title="Click here to update status" class="handCursor" onclick="javascript: change_status(\'' . $data->planning_rating_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a>
							</td>
						
						<td class="alignCenter">
								<a href="register_planning_rating.php?planning_id=' . $data->planning_id . '&planning_rating_id=' . $data->planning_rating_id . '"  title="Edit" ><img src="images/icon-edit.png" alt="Edit" description="Edit" width="15" height="16" title="Edit" /></a>
							</td>
							<td class="alignCenter deleteCol">
								<label><input type="checkbox" name="checkbox[' . $data->planning_rating_id. ']" id="checkbox" /></label>
							</td>
						</tr>

						<tr id="details'.$i.'" class="expandRow" >
								<td id="details_div_'.$i.'" colspan="7" height="1" ></td>
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
						$urlQuery = 'manage_planning_rating.php?page='.$currentPage;
					}
					else
					{
						$urlQuery = 'manage_planning_rating.php?'.$this->pager_param1.'&page='.$currentPage;	
					}
					functions::redirect($urlQuery);
				}
				else
				{
					echo "<tr><td colspan='4' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
				}
			}
		}
		public static function get_breadcrumbs($title, $client_side=false)
		{
			if($client_side)
			{
				$bread_crumb[]			= "<a href='tutorial.php'>Gallery</a>";
			}
			else
			{		
				$property_id				= page::get_property_id('manage_tutorial.php');	// Get the page id
				$page					= new page($property_id);
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

	
		// The function is used to change the status.
		public static function update_planning_rating_status($planning_rating_id, $status = '')
		{	
			$database	= new database();
			$planning_rating		= new planning_rating($planning_rating_id);
			//$current_status = $member->status;
			//echo $planning_gallery->status;
			if($status == '')
			{
				$status =  $planning_rating->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE planning_rating 
						SET status = '". $status . "'
						WHERE planning_rating_id = " . $planning_rating_id . "";
		
			$result 	= $database->query($sql);
			return $status;
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

				$sql = "UPDATE planning_rating SET order_id = '" . $order_id . "' WHERE planning_rating_id = '" . $id_array[$i] . "'";

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

				$sql	= "SELECT * FROM planning_rating ORDER BY planning_rating_date DESC Limit 0, $count";

			}

			else

			{

				$sql	= "SELECT * FROM planning_rating ORDER BY planning_rating_date DESC";

			}

			//print $sql;

			$result				= $database->query($sql);

			if ($result->num_rows > 0)

			{

				while($data = $result->fetch_object())

				{

					?>



<div class="planning_rating"> <?php echo functions::get_sub_string(functions::deformat_string($data->description),180); ?> <a href="planning_rating.php#planning_rating<?php echo $data->planning_rating_id; ?>">Read more</a> </div>

<?php

				}

			}

		}

		public static function get_propertyfeaturs_pdf($property_id = 0)

		{

			$database			= new database();
			$sql	= "SELECT * FROM planning_rating WHERE property_id='".$property_id."' ORDER BY planning_rating_id ASC";
			$result				= $database->query($sql);
			$feature =array();
			if ($result->num_rows > 0)
			{	
				while($data = $result->fetch_object())
				{
					$feature[]=$data->title;
				}
			}
			return $feature;
		}
		// The function is used to change the status.

		public static function update_status($property_id, $status = '')

		{		

			$database			= new database();

			$content			= new planning_rating($property_id);

			//$current_status = $content->status;

			if($status == '')

			{

				$status =  $content->status == 'Y' ? 'N' : 'Y';

			}

			

			$sql		= "UPDATE planning_rating 

						SET status = '". $status . "'

						WHERE planning_rating_id = '" . $property_id . "'";

			$result 	= $database->query($sql);

			return $status;

		}

		

		public static function get_random_planning_rating()

		{

			$database	= new database();

			$sql		= "SELECT * FROM planning_rating ORDER BY Rand() Limit 0, 1";

			//print $sql;

			$result		= $database->query($sql);

			if ($result->num_rows > 0)

			{

				$data = $result->fetch_object();

				echo functions::deformat_string($data->description);

			}

		}

		

		public function get_planning_rating_list()

		{

			$database			= new database();

			$param_array		= array();

			$search_condition	= '';

			$sql 				= "SELECT * FROM planning_rating";

					

			$sql				.= $search_condition;

			$sql 				= $sql . " ORDER BY planning_rating_date DESC";

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

			

			$planning_rating_array		= array();

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

						echo '<div id="planning_rating_content_crossline"></div>';	

					}

					

					?>

<a name="planning_rating<?php echo $data->planning_rating_id; ?>"></a>

<div id="planning_rating_black_heading">

	<div id="planning_rating_white_area">

		<div id="planning_rating_image"><img src="<?php echo URI_NEWS . 'thumb_' . $data->author_name; ?>" /></div>

		<div id="planning_rating_date"><?php echo functions::get_format_date($data->planning_rating_date, "dS M");	?></div>

	</div>

	<div id="planning_rating_black_area">

		<div id="affliates_content">

			<h1><?php echo functions::deformat_string($data->title); ?></h1>

			<?php echo nl2br(functions::deformat_string($data->description)); ?> </div>

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
		
		public static function get_rating($planning_id = 0)
		{
			$database			= new database();
			$output  			= 0;
			$sql 				= "SELECT *  FROM planning_rating WHERE planning_id='".$planning_id."' AND status='Y'";

			$result		= $database->query($sql);
			
			$total_rating = 0;
			$count 		  = $result->num_rows;
			if($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					$total_rating   += $data->rating;
				}
				
				$total_rating	=  $total_rating;
				$total	 		=  $total_rating/$count;
				$intpart = floor( $total );
				$fraction = $total - $intpart;
				
				$output = (($fraction < 0.25 && $fraction > 0) || $fraction == 0) ? $intpart : (($fraction > 0.25 && $fraction < 0.75) ? ($intpart+0.5):($intpart+1));
				
				/*if($fraction < 0.25 && $fraction > 0)
				{
					$output = $intpart;	
				}
				else if($fraction > 0.25 && $fraction < 0.75)
				{
					$output = $intpart+0.5;	
				}
				else if($fraction > 0.75)
				{
					$output = $intpart+1;	
				}*/
			}
			
			
			return  $output;
		}
		
		
	public static function remove_by_planning($planning_id)
	{
		$database	= new database();		
		$sql		= "DELETE FROM planning_rating WHERE planning_id = '" . $planning_id . "'";
		$result 	= $database->query($sql);
			
	}
		
		
		public static function get_reviews($planning_id, $limit= 0, $popup=false)
		{
			$database			= new database();
			if($limit > 0)
			{
				$sql 				= "SELECT *  FROM planning_rating WHERE planning_id='".$planning_id."' AND status='Y' ORDER BY planning_rating_id DESC LIMIT $limit";
			}
			else
			{
				$sql 				= "SELECT *  FROM planning_rating WHERE planning_id='".$planning_id."' AND status='Y' ORDER BY planning_rating_id DESC";
			}
			
			$result		= $database->query($sql);
			
			if($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					if($popup)
					{
						echo '<p style=" font-size:14px; width:600px;"><img src="images/quotes.jpg" width="18" height="16">'.nl2br(functions::deformat_string($data->comment)).'</p>';
					}
					else
					{
						echo '<p><img src="images/quotes.jpg" width="18" height="16">'.nl2br(functions::deformat_string($data->comment)).'</p>';
					}
				}
			}
		}
		
		
		public static function get_total_rating($planning_id = 0)
		{
			$database			= new database();

			$sql 				= "SELECT *  FROM planning_rating WHERE planning_id='".$planning_id."' AND status='Y'";

			$result		= $database->query($sql);
			
			return $result->num_rows;
		}
		
		public static function get_total_rating_pagination($planning_id = 0)
		{
			$database			= new database();

			$sql 				= "SELECT * FROM planning_rating WHERE planning_id='".$planning_id."' AND status='Y'";

			$result		= $database->query($sql);
			
			return $result->num_rows;
		}
		
		

	}

?>

