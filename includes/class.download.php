<?php

/*********************************************************************************************

Date	: 14-April-2011

Purpose	: Member album class

*********************************************************************************************/

class download

{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';
	// private $download_type_array	= array(1 => 'Landlord', 2 => 'Tenant',3=>'Property');
	function __construct($download_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		if($download_id > 0)
		{
			$this->initialize($download_id);
		}
	}

	

	function __get($category_name)
	{
		if (array_key_exists($category_name, $this->_properties))
		{
			return $this->_properties[$category_name];
		}
		return null;
	}
	public function __set($category_name, $value)
	{
		return $this->_properties[$category_name] = $value;
	}
	public function get_download_type_array_value($id)
		{
			return $this->download_type_array[$id];
		}

		public function get_download_type_array()
		{
			$database	= new database();

			$sql		= "SELECT *	 FROM download";

			$result		= $database->query($sql);

			

			if ($result->num_rows > 0)

			{

				return $result->fetch_object();

			}

			

		}

	public function __destruct() 

	{

		unset($this->_properties);

		unset($this->error);

		unset($this->message);

	}

	

	//Initialize object variables.

	private function initialize($download_id)

	{

		$database	= new database();

		$sql		= "SELECT *	 FROM download WHERE download_id = '$download_id'";

		$result		= $database->query($sql);

		

		if ($result->num_rows > 0)

		{

			$this->_properties	= $result->fetch_assoc();

		}

	}



	// Save the Member album details

	public function save()

	{

		$database	= new database();
		//if(!$this->check_download_exist($this->title, $this->download_id))
//			{
			if ( isset($this->_properties['download_id']) && $this->_properties['download_id'] > 0) 
			{
				$sql	= "UPDATE download SET title = '". $database->real_escape_string($this->title)  ."', item_name = '". $database->real_escape_string($this->item_name)  ."', status = '".  $database->real_escape_string($this->status)  ."' WHERE download_id = '$this->download_id'";
			}
			else 
			{
				$order_id	= self::get_max_order_id() + 1;
				  $sql		= "INSERT INTO download 
							( title,item_name, status, order_id, added_date) 
							VALUES (
									'" . $database->real_escape_string($this->title) . "',
									'" . $database->real_escape_string($this->item_name) . "',
									'" . $database->real_escape_string($this->status) . "',
									'". $order_id."',
									NOW()								
									)";
	
			}		
	
			
			//echo $sql;exit;
			$result			= $database->query($sql);
			if($database->affected_rows == 1)
			{
				if($this->download_id == 0)
				{
					$this->download_id	= $database->insert_id;
				}
				$this->initialize($this->download_id);
			}
	
			$this->message = cnst11;
			return true;
		//	}
//			else
//			{
//				return false;
//			}
	}

	

	

	// Returns the max order id

	public static function get_max_order_id()

	{

		$database	= new database();

		$sql		= "SELECT MAX(order_id) AS order_id FROM download";

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
			$sql = "UPDATE download SET order_id = '" . $order_id . "' WHERE download_id = '" . $id_array[$i] . "'";
			$database->query($sql);
			$order_id++;
		}
	}
	

	// Remove the current object details.

	public function remove()

	{

		$database	= new database();

		if ( isset($this->_properties['download_id']) && $this->_properties['download_id'] > 0) 

		{

			$sql = "DELETE FROM download WHERE download_id = '" . $this->download_id . "'";

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

	public function remove_selected($download_ids)

	{

		$database	= new database();

		if(count($download_ids)>0)

		{		

			foreach($download_ids as $download_id)

			{

				$download	= new download($download_id);

				$item_name		= $download->item_name;
				
				$image_name		= $download->image_name;

				if(file_exists(DIR_DOWNLOADS . $item_name))

				{

					unlink(DIR_DOWNLOADS . $item_name);

				}
				
				if(file_exists(DIR_DOWNLOADS . $image_name))

				{

					unlink(DIR_DOWNLOADS . $image_name);

				}

				

				$sql = "DELETE FROM download WHERE download_id = '" . $download_id . "'";

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

	public static function remove_by_category_id($category_id)
	{
		$database	= new database();
	    $sql		= "SELECT * FROM download WHERE category_id = '" . $category_id . "'";
		$result 	= $database->query($sql);
		while($data	= $result->fetch_object())
		{
			$item_name		= $data->item_name;
			$image_name		= $data->image_name;

			if(file_exists(DIR_DOWNLOADS . $item_name))

			{

				unlink(DIR_DOWNLOADS . $item_name);

			}
			if(file_exists(DIR_DOWNLOADS . $image_name))

			{

				unlink(DIR_DOWNLOADS . $image_name);

			}
		}
		
		$sql = "DELETE FROM download WHERE category_id = '" . $category_id . "'";
		$result 	= $database->query($sql);
	}

	// public static function remove_by_category($category_id)

	  // {

		  // $database	= new database();

		  

		  // $sql		= "SELECT * FROM download WHERE category_id = '" . $category_id . "'";

		  // $result 	= $database->query($sql);

		  // while($data	= $result->fetch_object())

		  // {

			  // if(file_exists(DIR_DOWNLOADS . $data->item_name))

				// {

					// unlink(DIR_DOWNLOADS . $data->item_name);

				// }

		  // }

		  

		  // $sql		= "DELETE FROM download WHERE category_id = '" . $category_id . "'";

		  // $result 	= $database->query($sql);

			  

	  // }

	

	

	

	// Remove by category

	public function remove_by_category($member_id)

	{

		$database		= new database();

    

    	$sql			= "SELECT * FROM download WHERE member_id='".$member_id."' ORDER BY added_date DESC";

		$result			= $database->query($sql);

		$image_list	= '';

		if ($result->num_rows > 0)

		{

			while($data = $result->fetch_object())

			{

				$download	= new download($data->download_id);

				$item_name	= $download->item_name;

				

				if(file_exists(DIR_MEMBER . $item_name))

				{

					unlink(DIR_MEMBER . $item_name);

				}

				if(file_exists(DIR_MEMBER . 'thumb_' . $item_name))

				{

					unlink(DIR_MEMBER . 'thumb_' . $item_name);

				}

				

				$sql_del = "DELETE FROM download WHERE download_id = '" . $download->download_id . "'";

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
		$sql					= "SELECT * FROM download ";

		if ($this->category_type > 0 || $this->search_word != "")
		{
		if($this->category_type != 0 && $this->category_type !='')
				{
					$param_array[]			= "category_type=" . $this->category_type;
					$search_cond_array[]	= "category_id = '" . $this->category_type . "'";
				}
		$drag_drop				= '';
		//$param_array[]			= "member_id=$this->member_id";
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
		}

			// Drag and dorp ordering is not available in search
			$drag_drop 						= ' nodrag nodrop ';
		}

		

		

		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND  ",$search_cond_array); 
			$sql				.= $search_condition;
		}
		$sql 			= $sql . " ORDER BY download_id DESC";
		//$sql 			= $sql . " ORDER BY order_id DESC";
		$result			= $database->query($sql);

		$this->num_rows = $result->num_rows;
		functions::paginate($this->num_rows);
		$start			= functions::$startfrom;
		$limit			= functions::$limits;
		$sql 			= $sql . " limit $start, $limit";
		$result			= $database->query($sql);

		//echo $sql ;

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
					<input type="hidden" id="show_download_id" name="show_download_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
					<input type="hidden" id="page" name="page" value="' . $page . '" />
				</td>
			</tr>';

			

			while($data=$result->fetch_object())
			{
				$i++;
				$row_num++;
				$class_name= (($row_type%2) == 0) ? "even" : "odd";
				//$name		= $data->title != '' ? $data->title : $data->alt;
				//$name		= $name != '' ? $name : $data->item_name;
				$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
				$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
				$download=new download();
				echo '
					<tr id="' . $data->download_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td class="widthAuto " >' . functions::deformat_string($data->title) . '</td>

						

						<!--<td class="widthAuto " onclick="javascript: open_category_details(\'' . $data->download_id . '\', \'' . $i . '\');" title="Click here to view details">'. functions::get_sub_string(functions::deformat_string(nl2br($data->description)),70).'</td>-->

						<td class="alignCenter"><a href="download.php?download_id=' . $data->download_id . '"><img src="images/download.png" alt="Download" title="Download" width="15" height="16" /></a></td>

						<td class="alignCenter joiningDateCol"><a title="Click here to update status" class="handCursor" onclick="javascript: change_download_status(\'' . $data->download_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a></td>

						<td class="alignCenter">

							<a href="register_download.php?category_id=' . $data->category_id .'&download_id=' . $data->download_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>

						</td>

						

						<td class="alignCenter deleteCol">

							<label><input type="checkbox" name="checkbox[' . $data->download_id . ']" id="checkbox" /></label>

						</td>

					</tr>

					

					<tr id="details' . $data->admin_id . '" class="expandRow">

							<td id="details_div_' . $i . '" colspan="9" height="1" ></td>

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

	

	// The function is used to change the status.

		public static function update_status($download_id, $status = '')

		{		

			$database				= new database();

			$download		= new download($download_id);

			

			if($status == '')

			{

				$status =  $download->status == 'Y' ? 'N' : 'Y';

			}

			

			$sql		= "UPDATE download 

						SET status = '". $status . "'

						WHERE download_id = '" . $download_id . "'";

			$result 	= $database->query($sql);			

			

			return $status;

		}

	

 public static function display_files()

  {

	    $database	= new database();

		$sql		= "SELECT *	 FROM download";

		$result		= $database->query($sql);

		

		if ($result->num_rows > 0)

		{ 

		 echo '<div><table width="690" border="0">

  

';

			while($data=$result->fetch_object())

			{

			  echo  '<tr>

				<td><a href="download_item.php?download_id=' . $data->download_id . '" alt="' . functions::format_text_field($data->title) . '" title="' . functions::format_text_field($data->title) . '">'.functions::format_text_field($data->title).'<img src="images/download.png" alt="Download" title="Download" width="15" height="16" /></td>

			  </tr>

			  <tr> <td>dfsgdfghjg</td>

			  <td>dfsgdfghjg2</td>

			  

			  </tr>

			  </a>';

			  echo '<br>';

			}

		echo '</table></div>';

		}

  }

  

  		public function get_all_download()

		{

			$databae	= new database();

			

			$query		="SELECT * FROM download_category WHERE status = 'Y' AND parent_id=0 ";	

			

			$result		= $databae->query($query);

			

			$this->num_rows = $result->num_rows;

			functions::paginatedownload($this->num_rows);

			$start			= functions::$startfrom;

			$limit			= functions::$limits;

			$query 			= $query . " limit $start, $limit";

			$result			= $databae->query($query);

			

			if($result->num_rows >0)

			{	

				while($data	= $result->fetch_object())

				{	

					$sql			=	"SELECT * FROM download_category WHERE status = 'Y' AND parent_id=$data->download_id";	

					$res_new		=	$databae->query($sql);

					

				

					echo '<a class="menuitem submenuheader" href="#" style="background-image:url(images/scliding-bg4.png); background-repeat:repeat-x;" >'.$data->category_name.'</a><div class="submenu">

					<div class="profile-box1">

					<div class="profile-box-content">'.functions::deformat_string($data->description).'&nbsp;</div>

					<div class="profile-box-img"><img src='. URI_DOWNLOAD_CATEGORY . 'thumb_' . $data->image_name.' border="0" width="115" height="132"/></div>';

					

					while($row=$res_new->fetch_object())

					{

						echo '<div><a href="documents_details.php?id='. $row->ategory_download_id.'">'.$row->category_name.'</a></div>';	

					}

						echo '</div></div>';					

				}

			}

			

			else

			{

				//$this->pager_param1 = join("&",$param_array);

				if(isset($_GET['page']))

				{

					$currentPage = $_GET['page'];

				}

				if($currentPage>1)

				{

					$currentPage = $currentPage-1;

					if($this->pager_param=="")

					{

						$urlQuery = 'documents.php?page='.$currentPage;

					}

					else

					{

						$urlQuery = 'documents.php?'.$this->pager_param1.'&page='.$currentPage;	

					}

					functions::redirect($urlQuery);

				}

				else

				{

					echo "<tr><td colspan='4' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";

				}

			}

		}

		

		

		

		// The function is used to change the status.

		public static function get_email($category_id,$page_type)

		{		

			$database		= new database();

			$category			= new category($category_id);

			

		$sql		= "SELECT * FROM category WHERE category_id = '" . $category_id . "'";

			if($page_type == '1')

			{

		$sql		= "SELECT * FROM category WHERE category_id = '" . $category_id . "'";

			}

			else if($page_type == '2')

			{

		$sql		= "SELECT * FROM category WHERE category_id = '" . $category_id . "'";

			 }

		 //echo  $sql;

		$result		= $database->query($sql);

		$data	= $result->fetch_object();

		if ($result->num_rows > 0)

			{

			//$client_details= new client($data->client_id);

			if($page_type == '1')

			{

				$client_details= new client($data->client_id);

				$client_emails = $client_details->email;

			}

			else if($page_type == '2')

			{

	                if(substr_count($data->client_ids,",")>0)

						{

							$clients_list=explode(",",$data->client_ids);

							$client_emails="";

							for($j=0;$j<count($clients_list);$j++)

							{

								$client_details = new client($clients_list[$j]);

								$client_emails.= functions::deformat_string($client_details->email);

								if($j<count($clients_list)-1)

								{

									$client_emails.= ", ";

								}

							}

						}

						else

						{

							

						$client_details= new client($data->client_ids);

						$client_emails = functions::deformat_string($client_details->email);

						}		

			

			}

			

			return $client_emails;

			}

			else

			{

			

			return ;

				

		     }

			

			

				

		}

  		

		public function list_documents_detail($category_download_id)

		{

			$database				= new database();

			

			$sql 					= "SELECT a.*,b.* FROM download AS a JOIN category AS b ON a.category_id=b.category_id WHERE a.download_id=$download_id";

			$result					= $database->query($sql);

			

			if($result->num_rows>0)

			{

				while($data=$result->fetch_object())

				{

				 echo '<h1>'.functions::deformat_string($data->category_name).'</h1>

					   <p><a href="download_item.php?download_id=' . $data->download_id . '" alt="' . functions::format_text_field($data->title) . '" title="' . functions::format_text_field($data->title) . '"><img src="images/download.png" alt="Download" title="Download" width="15" height="16" /></a></p>

					 <p>'.functions::deformat_string($data->title).'</p>

					 ';

				}

			}

			else

			{

				echo "<div align='center' class='warningMesg'>Sorry.. No records found !!</div>";

			}

		}

		

		

		public static function list_documents($category_id)

		{

			$databae	= new database();

			$sql		="SELECT * FROM download WHERE category_id= '".$category_id."' and category_status='Y'  order by added_date desc limit 0,3";	

			//echo $sql;

			$result		= $databae->query($sql);

			echo '<div class="button_outer">';

			if($result->num_rows>0)

			{

				while($data=$result->fetch_object())

				{

					echo '<a href="download_item.php?download_id='.$data->download_id.'"> <div ';

					if(strlen($data->title)<=15)

					{

					echo 'class="btn_lndlord_gascert"';

					}

					else

					{

					echo 'class="btn_lndlord_elecert"';	

					}

					echo '>'.$data->title.'</div></a>';

					

				}

			}

			else

			{

				echo "<div align='center' class='warningMesg' style='margin-top:40px;' >Sorry.. No documents found !!</div>";

			}

			 echo '</div>';

	    }
		
		
		public static function download_list($category_id)
		{
			$databae	= new database();
			$sql		="SELECT * FROM download WHERE category_id= '".$category_id."' and status='Y'  ORDER BY order_id DESC";	
			$result		= $databae->query($sql);

			if($result->num_rows>0)
			{
				$i = 0;
				$j = 0;
			    while($data=$result->fetch_object())
				{
					$item  		= $data->item_name;
					$path  		= DIR_DOWNLOADS. $item;
					$path_parts = pathinfo($path);
			
					$image_icon   = '';
					if($path_parts['extension'] == 'pdf')  $image_icon   =  'images/pdf.png';
					if($path_parts['extension'] == 'doc' || $path_parts['extension'] == 'docx')  $image_icon   =  'images/doc.png';
					if($path_parts['extension'] == 'mp4')  $image_icon   =  'images/mp4-staf-trng.png';
					
			?>
            
            
                   <div class="staff-traning-box"> <?php if($j == 1) { echo '<br />'; } ?>
                    <div class="staff-traning-box-img">
                     <a href="download.php?id=<?php echo $data->download_id ?>" title="<?php echo functions::deformat_string($data->title) ?>"> <img src="<?php echo $image_icon ?>" border="0" width="129px" height="129px"/> </a>
                    </div>
                    <div class="staff-traning-box-content">
                    <h3><?php echo functions::deformat_string($data->title) ?></h3>
                    <p><?php echo (strlen($data->description) > 150) ? strip_tags(substr(functions::deformat_string($data->description), 0, 150)).'....<br /><a style="cursor:pointer;" >
					<div class="view_more" onclick="view_more('.$data->download_id.')" id="view_more" title="View More">View More</div></a>' : strip_tags(functions::deformat_string($data->description)); ?></p>
                    </div>
                    </div>
                    
            <?php	
					if($i < 3 )
					{					
						echo '<div class="staff-traning-box-space"></div>';
						$i++;
						
					}
					else if($i == 3)	
					{
						$i = 0;
						$j = 1;
					}
				}
			}
			else
			{
				echo "Sorry... No documents found!";	
			}
			
		}
		
		
		public static function get_home_documents()
		{
			$databae	= new database();
			$sql 		= "SELECT * FROM category WHERE category_type='1' LIMIT 1";
			$result		= $databae->query($sql);
			if($result->num_rows>0)
			{
				$data = $result->fetch_object();
			
				$sql1		="SELECT * FROM download WHERE category_id= '".$data->category_id."' and status='Y'  ORDER BY order_id DESC";	
				$result1		= $databae->query($sql1);

				if($result1->num_rows>0)
				{
					$i = 0;
					$j = 0;
					while($data1=$result1->fetch_object())
					{
						$item  		= $data1->item_name;
						$path  		= DIR_DOWNLOADS. $item;
						$path_parts = pathinfo($path);
				
						$image_icon   = '';
						if($path_parts['extension'] == 'pdf')  $image_icon   =  'images/pdf_home_icon.png';
						if($path_parts['extension'] == 'doc' || $path_parts['extension'] == 'docx')  $image_icon   =  'images/carol-doc-home.png';
						if($path_parts['extension'] == 'mp4')  $image_icon   =  'images/mp4_icon.png';
						
					?>
            			<div class="download-box"><?php if($j == 1) { echo '<br />'; } ?><a href="download.php?id=<?php echo $data1->download_id ?>" title="<?php echo functions::deformat_string($data1->title) ?>"><img src="<?php echo $image_icon ?> " /></a>
                        
                         <div class="download-pdf"><?php if($j == 1) { echo '<br />'; } ?><span class="document_span"><a href="download.php?id=<?php echo $data1->download_id ?>" title="<?php echo functions::deformat_string($data1->title) ?>"><?php echo functions::deformat_string($data1->title) ?></a></span></div>
                         
                         </div>
                         
                    
				<?php	
                        if($i < 2 )
                        {					
                            echo '<div class="download-box-space"></div>';
                            $i++;
                            
                        }
                        else if($i == 2)	
                        {
                            $i = 0;
                            $j = 1;
                        }
                    }
                }
                else
                {
                    echo "Sorry... No documents found!";	
                }
			}
			else
			{
				echo "Sorry... No documents found!";	
			}
			
		}
		
		
		public static function get_home_documents_stop()
		{
			$databae	= new database();
			$sql 		= "SELECT * FROM category WHERE category_type='3' LIMIT 1";
			$result		= $databae->query($sql);
			
			//echo '<div class="home-right-box-content">
			//<div class="home-right-box-content-text">';
			
			if($result->num_rows>0)
			{
				$data = $result->fetch_object();
							
				$sql1		="SELECT * FROM download WHERE category_id= '".$data->category_id."' and status='Y'  ORDER BY order_id DESC";	
				$result1		= $databae->query($sql1);

				echo '<div class="home-right-box-top"><h2>'. functions::deformat_string($data->name).'</h2></div>';
				
				if($result1->num_rows>0)
				{
					while($data1=$result1->fetch_object())
					{
						$item  		= $data1->item_name;
						$path  		= DIR_DOWNLOADS. $item;
						$path_parts = pathinfo($path);
				
						$image_icon   = '';
						$down_text   = '';
						/*if($path_parts['extension'] == 'pdf')  $image_icon   =  'images/pdf.png';
						if($path_parts['extension'] == 'doc' || $path_parts['extension'] == 'docx')  $image_icon   =  'images/doc.png';
						if($path_parts['extension'] == 'mp4')  $image_icon   =  'images/mp4.png';*/
						if($path_parts['extension'] == 'pdf')  $down_text   =  'PDF';
						if($path_parts['extension'] == 'doc' || $path_parts['extension'] == 'docx')  $down_text   =  'DOC';
						if($path_parts['extension'] == 'mp4')  $down_text   =  'MP$';
						

					?>
                    
                    <div class="home-right-box-content">
						<div class="home-right-box-content-text">
            
                    <?php echo nl2br(functions::deformat_string($data->description)); ?>
                    
                    	<div class="download-pdf"><a href="download.php?id=<?php echo $data1->download_id ?>" title="<?php echo functions::deformat_string($data1->title) ?>">Download <?php echo $down_text; ?></a></div>
                        
            			</div>
			
			<div class="home-right-box-content-img"><img src="images/stop-press-image.jpg" /></div> </div>                                         
                    
				<?php	
                        
                    }
                }
                else
                {
					echo '<div class="home-right-box-content">
						<div class="home-right-box-content-text">';
                    echo "Sorry... No documents found!";
					echo '</div></div>';	
                }	
			}
		}
		
		public static function get_home_name()
		{
			$databae	= new database();
			$sql 		= "SELECT * FROM category WHERE category_type='1' LIMIT 1";
			$result		= $databae->query($sql);
			if($result->num_rows>0)
			{
				$data = $result->fetch_object();
				return  $data->name;	
			}
			
		}
		
		public static function get_home_name_stop()
		{
			$databae	= new database();
			$sql 		= "SELECT * FROM category WHERE category_type='3' LIMIT 1";
			$result		= $databae->query($sql);
			if($result->num_rows>0)
			{
				$data = $result->fetch_object();
				return  $data->name;	
			}
			
		}
			public function check_download_exist($title='', $download_id=0)
		{
			$output		= false;
			$database	= new database();
			if($title == '')
			{
				$this->message	= "Title should not be empty!";
				$this->warning	= true;
			}
			else
			{
				if($download_id > 0)
				{
					$sql	= "SELECT *	 FROM download WHERE title = '" . $database->real_escape_string($title) . "' AND download_id != '" . $download_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM download WHERE title = '" . $database->real_escape_string($title) . "'";
				}
				//print $sql;
				$result 	= $database->query($sql);
				if ($result->num_rows > 0)
				{
					 $this->message	= "Title already exist!";
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

  public function download_latest()
  {
	  
	 		 $databae	= new database();
			$sql 		= "SELECT * FROM download where status= 'Y' order by download_id DESC LIMIT 1";
			$result		= $databae->query($sql);
			if($result->num_rows>0)
			{
				$data = $result->fetch_object();
				
				echo '<a href="admin/download.php?download_id=' . $data->download_id . '"><div class="download"><input name="" type="button" value="" /></div></a>';	
			}
  }

}

?>