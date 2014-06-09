<?php

/*********************************************************************************************

	Author 	: V V VIJESH

	Date	: 14-April-2011

	Purpose	: Page content class

*********************************************************************************************/

    class page_content

	{

		protected $_properties		= array();

		public    $error			= '';

		public    $message			= '';

		public    $warning			= '';



        function __construct($page_content_id = 0)

		{

            $this->error	= '';

			$this->message	= '';

			$this->warning	= false;

			

			if($page_content_id > 0)

			{

				$this->initialize($page_content_id);

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

		private function initialize($page_content_id)

		{

			$database	= new database();

			$sql		= "SELECT *	 FROM page_content WHERE page_content_id = '$page_content_id'";

			$result		= $database->query($sql);

			

			if ($result->num_rows > 0)

			{

				$this->_properties	= $result->fetch_assoc();

			}

		}

		

		// Save the Page content details

		public function save()

		{

			$database	= new database();

			if ( isset($this->_properties['page_content_id']) && $this->_properties['page_content_id'] > 0) 

			{

				$sql	= "UPDATE page_content SET page_name = '". $database->real_escape_string($this->page_name)  ."',  title = '". $database->real_escape_string($this->title)  ."', content = '". $database->real_escape_string($this->content) . "', modified_date = NOW() WHERE page_content_id = '$this->page_content_id'";

			}

			else 

			{

				$order_id	= 0;

				$sql		= "INSERT INTO page_content 

							(page_name, title, content, added_date, modified_date, status, order_id) 

							VALUES ('" . $database->real_escape_string($this->page_name) . "',

									'" . $database->real_escape_string($this->title) . "',

									'" . $database->real_escape_string($this->content) . "',

									NOW(),

									NOW(),

									'Y',

									'" . $order_id . "'

									)";

			}

			//print $sql;

			$result			= $database->query($sql);

			

			if($database->affected_rows == 1)

			{

				if($this->page_content_id == 0)

				{

					$this->page_content_id	= $database->insert_id;

				}

			}

			$this->initialize($this->page_content_id);

			$this->message = cnst11;

			return true;

		}

		

		//The function check the page_content category eixst or not

		public function check_page_content_exist($description='', $page_content_id=0)

		{

			$output		= false;

			$database	= new database();

			if($description == '')

			{

				$this->message	= "Page content number should not be empty!";

				$this->warning	= true;

			}

			else

			{

				if($page_content_id > 0)

				{

					$sql	= "SELECT *	 FROM page_content WHERE description = '" . $database->real_escape_string($description) . "' AND page_content_id != '" . $page_content_id . "'";

				}

				else

				{

					$sql	= "SELECT *	 FROM page_content WHERE description = '" . $database->real_escape_string($description) . "'";

				}

				//print $sql;

				$result 	= $database->query($sql);

				if ($result->num_rows > 0)

				{

					$this->message	= "Page content number is already exist!";

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

			if ( isset($this->_properties['page_content_id']) && $this->_properties['page_content_id'] > 0) 

			{

				$sql = "DELETE FROM page_content WHERE page_content_id = '" . $this->page_content_id . "'";

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

		public function remove_selected($page_content_ids)

		{

			$database	= new database();

			if(count($page_content_ids)>0)

			{		

				foreach($page_content_ids as $page_content_id)

				{				

					$sql = "DELETE FROM page_content WHERE page_content_id = '" . $page_content_id . "'";

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

		

		public function get_my_page_content()

		{

			$database	= new database();

			$title	= $_SESSION[MEMBER_ID];

			$sql		= "SELECT * FROM page_content WHERE title = $title ORDER BY page_content_date DESC";

			$result		= $database->query($sql);

			$idate		= 0;

			if ($result->num_rows > 0)

			{	

				while($data=$result->fetch_object())

				{

					$i++;

					$page_content_serial_value++;

					$row_num++;

			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	

					

					$idate			= explode('-', $data->page_content_date);

				  	$page_content_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];

					echo "<tr>

							<td align='center'>$i</td>

							<td>$page_content_date</td>

							<td>$data->description</td>

							<td><a href='$data->page_content_url' target='_blank'><img src='images/view-page_content.png' border='0' title='View'></a></td>

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

			$sql					= "SELECT * FROM page_content ";

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

						$search_cond_array[]	= " page_name like '%" . $database->real_escape_string($search_word) . "%' OR title like '%" . $database->real_escape_string($search_word) . "%' ";	

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

						

			$sql 			= $sql . " ORDER BY page_name ASC, title ASC, page_content_id ASC";

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

               			<input type="hidden" id="page_content_id" name="page_content_id" value="0" />

						<input type="hidden" id="show_page_content_id" name="show_page_content_id" value="0" />

						<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />

						<input type="hidden" id="page" name="page" value="' . $page . '" />

					</td>

                </tr>';

				

				while($data=$result->fetch_object())

				{

					$i++;

					$page_content_serial_value++;

					$row_num++;

			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";

					$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
					$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';

					echo '

						<tr id="' . $data->page_content_id . '" class="' . $class_name . $drag_drop . '" >

							<td class="alignCenter pageNumberCol">' . $row_num . '</td>

							<td class="noBorder handCursor" onclick="javascript: open_page_content_details(\''.$data->page_content_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$page_content_serial_value.'\');"  title="Click here to view details">';

							

							//<td class="widthAuto"><a href="#" title="Click here to view details" onClick="javascript:open_page_content_details(\''.$data->page_content_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$page_content_serial_value.'\');return false;">';

					

					if($data->title != '')

					{

						echo functions::deformat_string($data->title);

					}

					else

					{

						echo '<font color="#CCCCCC">No Title</font>';

					}

					echo '</a></td>

							<td class="widthAuto">' . functions::deformat_string($data->page_name) . '</td>

							<td class="widthAuto">'.substr(functions::deformat_string($data->content),0,60).'</td>

							
							<td class="alignCenter"><a title="Click here to update status" class="handCursor" onclick="javascript: change_page_content_status(\'' . $data->page_content_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a></td>
							<td class="alignCenter">

								<a href="register_page_content.php?page_content_id=' . $data->page_content_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>

							</td>

							<td class="alignCenter deleteCol">

								<label><input type="checkbox" name="checkbox[' . $data->page_content_id . ']" id="checkbox" /></label>

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

						$urlQuery = 'manage_page_content.php?page='.$currentPage;

					}

					else

					{

						$urlQuery = 'manage_page_content.php?'.$this->pager_param1.'&page='.$currentPage;	

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

				$sql = "UPDATE page_content SET order_id = '" . $order_id . "' WHERE page_content_id = '" . $id_array[$i] . "'";

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

				$sql	= "SELECT * FROM page_content ORDER BY page_content_date DESC Limit 0, $count";

			}

			else

			{

				$sql	= "SELECT * FROM page_content ORDER BY page_content_date DESC";

			}

			//print $sql;

			$result				= $database->query($sql);

			if ($result->num_rows > 0)

			{

				while($data = $result->fetch_object())

				{

					?>

					<div class="page_content">

					<?php echo functions::get_sub_string(functions::deformat_string($data->description),180); ?> <a href="page_content.php#page_content<?php echo $data->page_content_id; ?>">Read more</a>

					</div>

					<?php

				}

			}

		}

		

		public static function get_random_page_content()

		{

			$database	= new database();

			$sql		= "SELECT * FROM page_content ORDER BY Rand() Limit 0, 1";

			//print $sql;

			$result		= $database->query($sql);

			if ($result->num_rows > 0)

			{

				$data = $result->fetch_object();

				echo functions::deformat_string($data->description);

			}

		}

		

		public function get_page_content_list()

		{

			$database			= new database();

			$param_array		= array();

			$search_condition	= '';

			$sql 				= "SELECT * FROM page_content";

					

			$sql				.= $search_condition;

			$sql 				= $sql . " ORDER BY page_content_date DESC";

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

			

			$page_content_array		= array();

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

						echo '<div id="page_content_content_crossline"></div>';	

					}

					

					?>

					<a name="page_content<?php echo $data->page_content_id; ?>"></a>

					<div id="page_content_black_heading">

						<div id="page_content_white_area">

							<div id="page_content_image"><img src="<?php echo URI_NEWS . 'thumb_' . $data->image_name; ?>" /></div>

							<div id="page_content_date"><?php echo functions::get_format_date($data->page_content_date, "dS M");	?></div>

						</div>

						<div id="page_content_black_area">

							<div id="affliates_content">

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
		public static function update_status($page_content_status, $status = '')
		{		
			$database		= new database();
			$page_content			= new page_content($page_content_status);
			//$current_status = $page_content->status;
			if($status == '')
			{
				$status =  $page_content->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE page_content 
						SET  status = '". $status . "'
						WHERE page_content_id= '" . $page_content_status . "'";
						//echo $sql;
			$result 	= $database->query($sql);
			return $status;
		}

	}

?>