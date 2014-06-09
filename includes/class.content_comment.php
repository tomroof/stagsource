<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 14-April-2011
	Purpose	: content_comment class
*********************************************************************************************/
    class content_comment
	{
		protected	$_properties		= array();
		public		$error				= '';
		public		$message			= '';
		public		$warning			= '';
		private		$no_content_comment_option	= array();
		public $status_array	= array(1=>'New', 2=>'Open', 3=>'Close');

        function __construct($content_comment_id = 0)
		{
            $this->error	= '';
			$this->message	= '';
			$this->warning	= false;
			
			if($content_comment_id > 0 || $content_comment_id != '')
			{
				$this->initialize($content_comment_id);
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
		private function initialize($content_comment_id)
		{
			$database	= new database();
			
			$sql	= "SELECT *	 FROM content_comment WHERE content_comment_id = '$content_comment_id'";

			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
		}
		
		// Save the content_comment details
		public function save()
		{
			$database	= new database();
			
			$member 	= new member($this->member_id);
				if ( isset($this->_properties['content_comment_id']) && $this->_properties['content_comment_id'] > 0) 
				{
					$sql	= "UPDATE content_comment SET 
								content_id = '". $database->real_escape_string($this->content_id)  ."',
								member_id = '". $database->real_escape_string($this->member_id)  ."',
								comment = '". $database->real_escape_string($this->comment)  ."',
								status = '". $database->real_escape_string($this->status)  ."',
								guest_name = '". $database->real_escape_string($member->first_name .' '. $member->last_name)  ."',
								guest_email = '". $database->real_escape_string($member->email)  ."'
								WHERE content_comment_id = '$this->content_comment_id'";
				}
				else 
				{
					$sql		= "INSERT INTO content_comment 
								(content_id, member_id, comment, status, guest_name, guest_email, created_date) 
								VALUES ('" . $database->real_escape_string($this->content_id) . "',
										'" . $database->real_escape_string($this->member_id) . "',
										'" . $database->real_escape_string($this->comment) . "',
										'" . $database->real_escape_string($this->status) . "',
										'" . $database->real_escape_string($member->first_name .' '. $member->last_name) . "',
										'" . $database->real_escape_string($member->email) . "',
										
										NOW()
										)";
				}
				//print $sql;
				$result			= $database->query($sql);
				
				if($database->affected_rows == 1)
				{
					if($this->content_comment_id == 0)
					{
						$this->content_comment_id	= $database->insert_id;
						
						$sql1	= "UPDATE content SET comment_count=(comment_count+1) WHERE content_id=$this->content_id";
						$result1			= $database->query($sql1);
					}
				}
				$this->initialize($this->content_comment_id);
				$this->message = cnst11;
				return true;
		}
		
		//The function check the content_comment name exist or not
		public function check_content_comment_exist($name='', $content_comment_id=0)
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
				if($content_comment_id > 0)
				{
					$sql	= "SELECT *	 FROM content_comment WHERE name = '" . $database->real_escape_string($name) . "' AND content_comment_id != '" . $content_comment_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM content_comment WHERE name = '" . $database->real_escape_string($name) . "'";
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
		public function check_seo_url_exist($seo_url='', $content_comment_id=0)
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
				if($content_comment_id > 0)
				{
					$sql	= "SELECT *	 FROM content_comment WHERE seo_url = '" . $database->real_escape_string($seo_url) . "' AND content_comment_id != '" . $content_comment_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM content_comment WHERE seo_url = '" . $database->real_escape_string($seo_url) . "'";
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
			if ( isset($this->_properties['content_comment_id']) && $this->_properties['content_comment_id'] > 0) 
			{
				$sql = "DELETE FROM content_comment WHERE content_comment_id = '" . $this->content_comment_id . "'";
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
		public function remove_selected($content_comment_ids)
		{
			$database	= new database();
			if(count($content_comment_ids)>0)
			{		
				foreach($content_comment_ids as $content_comment_id)
				{
					$content_comment	= new content_comment($content_comment_id);
					$sql1	= "UPDATE content SET comment_count=(comment_count-1) WHERE content_id=$content_comment->content_id";
					$result1			= $database->query($sql1);
					
					$sql = "DELETE FROM content_comment WHERE content_comment_id = '" . $content_comment_id . "'";
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
		
		public function get_my_content_comment()
		{
			$database	= new database();
			$title	= $_SESSION[MEMBER_ID];
			$sql		= "SELECT * FROM content_comment WHERE title = $title ORDER BY content_comment_date DESC";
			$result		= $database->query($sql);
			$idate		= 0;
			if ($result->num_rows > 0)
			{	
				while($data=$result->fetch_object())
				{
					$i++;
					$content_comment_serial_value++;
					$row_num++;
			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	
					
					$idate			= explode('-', $data->content_comment_date);
				  	$content_comment_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];
					echo "<tr>
							<td align='center'>$i</td>
							<td>$content_comment_date</td>
							<td>$data->description</td>
							<td><a href='$data->content_comment_url' target='_blank'><img src='images/view-content_comment.png' border='0' title='View'></a></td>
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
			$sql					= "SELECT * FROM content_comment ";
			$drag_drop				= '';
			
			//$search_cond_array[]	= " title = '$this->title' ";
			//$param_array[]			= "title=$this->title";
			if(isset($_REQUEST['search_word']) || $_REQUEST['content_id'] > 0 ) 
			{
				$search_word	= functions::clean_string($_REQUEST['search_word']);
				if(!empty($search_word))
				{
					$validation->check_blank($search_word, 'Search word', 'search_word');					
					if (!$validation->checkErrors())
					{
						$param_array[]			= "search=true";
						$param_array[]			= "search_word=" . htmlentities($search_word);
						$search_cond_array[]	= " comment like '%" . $database->real_escape_string($search_word) . "%' OR guest_name like '%" . $database->real_escape_string($search_word) . "%' OR guest_email like '%" . $database->real_escape_string($search_word) . "%'";	
					}
				}
				
				if($_REQUEST['content_id'] > 0)
				{
						$param_array[]="content_id =".$_REQUEST['content_id'];			
						$search_cond_array[]="content_id  = '".$database->real_escape_string($_REQUEST['content_id'])."'";		
				}
				// Drag and dorp ordering is not available in search
				$drag_drop 						= ' nodrag nodrop ';
			}
			
			if(count($search_cond_array)>0) 
			{ 
				$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
				$sql				.= $search_condition;
			}
						
			$sql 			= $sql . " ORDER BY created_date DESC";
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
               			<input type="hidden" id="content_comment_id" name="content_comment_id" value="0" />
						<input type="hidden" id="show_content_comment_id" name="show_content_comment_id" value="0" />
						<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
						<input type="hidden" id="page" name="page" value="' . $page . '" />
					</td>
                </tr>';
				
				while($data=$result->fetch_object())
				{
					$i++;
					$content_comment_serial_value++;
					$row_num++;
			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	
					$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
					$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
					
					$show_menu			= $data->show_menu == 'Y' ? 'Active' : 'Inactive';
					$show_menu_image	= $data->show_menu == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
					$member 	= new member($data->member_id);
					$content	= new content($data->content_id);
					
					echo '
						<tr id="' . $data->content_comment_id . '" class="' . $class_name . $drag_drop . '" >
							<td class="alignCenter pageNumberCol">' . $row_num . '</td>
							<td class="noBorder handCursor" onclick="javascript: open_content_comment_details(\''.$data->content_comment_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$content_comment_serial_value.'\');"  title="Click here to view details">' . functions::deformat_string($data->comment) . '</td>
							<td class="noBorder " >' . functions::deformat_string($this->status_array[$data->status]) . '</td>
							<td class="noBorder " >' . date('d-m-Y', strtotime($data->created_date)). '</td>';
						echo '
							<td >'.  functions::deformat_string($member->first_name) .' '. functions::deformat_string($member->last_name) .'</td>
							
							<td >'.  functions::deformat_string($member->email) .'</td>
							
							<td >'.  functions::deformat_string($content->name) .'</td>
							
							<td class="alignCenter">
								<a href="register_content_comment.php?content_comment_id=' . $data->content_comment_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
							</td>
							<td class="alignCenter deleteCol">';
															echo '
								<label><input type="checkbox" name="checkbox[' . $data->content_comment_id . ']" id="checkbox" /></label>';
							
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
						$urlQuery = 'manage_content_comment.php?page='.$currentPage;
					}
					else
					{
						$urlQuery = 'manage_content_comment.php?'.$this->pager_param1.'&page='.$currentPage;	
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
		public static function update_status($content_comment_id, $status = '')
		{		
			$database		= new database();
			$content_comment			= new content_comment($content_comment_id);
			//$current_status = $content_comment->status;
			if($status == '')
			{
				$status =  $content_comment->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE content_comment 
						SET status = '". $status . "'
						WHERE content_comment_id = '" . $content_comment_id . "'";
			$result 	= $database->query($sql);
			return $status;
		}
		
		// The function is used to change the status.
		public static function update_show_menu($content_comment_id, $show_menu = '')
		{		
			$database		= new database();
			$content_comment		= new content_comment($content_comment_id);
			//$current_show_menu = $content_comment->show_menu;
			if($show_menu == '')
			{
				$show_menu =  $content_comment->show_menu == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE content_comment 
						SET show_menu = '". $show_menu . "'
						WHERE content_comment_id = '" . $content_comment_id . "'";
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
			$sql = "UPDATE content_comment SET order_id = '" . $order_id . "' WHERE content_comment_id = '" . $id_array[$i] . "'";
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
				$sql	= "SELECT * FROM content_comment ORDER BY content_comment_date DESC Limit 0, $count";
			}
			else
			{
				$sql	= "SELECT * FROM content_comment ORDER BY content_comment_date DESC";
			}
			//print $sql;
			$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					?>
					<div class="content_comment">
					<?php echo functions::get_sub_string(functions::deformat_string($data->description),180); ?> <a href="content_comment.php#content_comment<?php echo $data->content_comment_id; ?>">Read more</a>
					</div>
					<?php
				}
			}
		}
		
		public static function get_menu($static_menu = '')
		{
			$database			= new database();
			$portfolio_array 	= array();
			$sql				= "SELECT * FROM content_comment WHERE  show_menu = 'Y' AND status = 'Y' ORDER BY name DESC";
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
		
		public static function get_random_content_comment()
		{
			$database	= new database();
			$sql		= "SELECT * FROM content_comment ORDER BY Rand() Limit 0, 1";
			//print $sql;
			$result		= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data = $result->fetch_object();
				echo functions::deformat_string($data->description);
			}
		}
		
		public function get_content_comment_list()
		{
			$database			= new database();
			$param_array		= array();
			$search_condition	= '';
			$sql 				= "SELECT * FROM content_comment";
					
			$sql				.= $search_condition;
			$sql 				= $sql . " ORDER BY content_comment_date DESC";
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
			
			$content_comment_array		= array();
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
						echo '<div id="content_comment_content_comment_crossline"></div>';	
					}
					
					?>
					<a name="content_comment<?php echo $data->content_comment_id; ?>"></a>
					<div id="content_comment_black_heading">
						<div id="content_comment_white_area">
							<div id="content_comment_image"><img src="<?php echo URI_NEWS . 'thumb_' . $data->image_name; ?>" /></div>
							<div id="content_comment_date"><?php echo functions::get_format_date($data->content_comment_date, "dS M");	?></div>
						</div>
						<div id="content_comment_black_area">
							<div id="affliates_content_comment">
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
			$sql 			= "SELECT * FROM content_comment WHERE content_comment_type='article' AND image_size='1' AND status='Y' ORDER BY content_comment_id DESC";
			$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data=$result->fetch_object())
				{
					$big_array[] 	= $data->content_comment_id;	
					$image_name 	= $data->content_comment_thumbnail;
					if(!file_exists(DIR_content_comment.'thumb_'.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_content_comment.$image_name);
						$imageLib = new imageLib(DIR_content_comment.$image_name);
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
						$imageLib->resizeImage(content_comment_BIG_THUMB_WIDTH, content_comment_BIG_THUMB_HEIGHT, 0);	
						$imageLib->saveImage(DIR_content_comment.'thumb1_'.$image_name, 90);
						unset($imageLib);
					}
				}
			}
			
			return $big_array;
			
		}
		
		
		public static function get_like_total($content_id = 0, $like_type = '')
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_comment WHERE content_id=$content_id AND like_type='$like_type'";
			$result				= $database->query($sql);
			return $result->num_rows;			
		}
		
		public static function update_page_like($member_id = 0, $contents = '')
		{
			$content_id		= explode('_', $contents);
			$database		= new database();
			$sql 			= "SELECT * FROM content_comment WHERE member_id=$member_id AND content_id=$content_id[1] AND like_type='$content_id[0]'";
			$result				= $database->query($sql);
			if($result->num_rows > 0)
			{
				$sql 			= "DELETE FROM content_comment WHERE member_id=$member_id AND content_id=$content_id[1] AND like_type='$content_id[0]'";
				$result			= $database->query($sql);	
			}
			else
			{
				$sql 		= "INSERT INTO content_comment 
								(model_name, content_id, member_id, like_type, created_at) 
								VALUES ('Contents',
								'" . $database->real_escape_string($content_id[1]) . "',
								'" . $database->real_escape_string($member_id) . "',
								'" . $database->real_escape_string($content_id[0]) . "',
								NOW())";
				$result			= $database->query($sql);
			}
		}
		
		public static function get_comment_total($content_id = 0)
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_comment WHERE content_id=$content_id";
			$result				= $database->query($sql);
			return $result->num_rows;			
		}
		
		public static function get_comment_total_by_member($member_id = 0)
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_comment WHERE member_id=$member_id";
			$result				= $database->query($sql);
			return $result->num_rows;			
		}
		
		public static function get_comments($content_id)
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_comment WHERE content_id=$content_id ORDER BY created_date DESC";
			$result				= $database->query($sql);	
			if($result->num_rows > 0)
			{
				while($data 	= $result->fetch_object())
				{
					$member_com		=  new member($data->member_id);
					?>
                    <div class="block-comment block-comment-white">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="block-comment-img">
                                        <div class="photo-avatar">
                                        <a href="<?php echo URI_ROOT ?>user/publicProfile/<?php echo $data->member_id ?>">
                                        <?php if($member_com->fb_id != '') { ?>
                                      
                                            <img src="http://graph.facebook.com/<?php echo $member_com->fb_id ?>/picture?type=large" alt="">   

                                        <?php } else {
											if(file_exists(DIR_MEMBER.$member_com->image_name)) { ?>
                                            	
                                            <?php } else { ?>
                                            
                                      			<img src="http://graph.facebook.com/<?php echo $member_com->fb_id ?>/picture?type=large" alt="">     
                                        
                                        <?php  }
										} ?>
                                        </a>
                                        
                          </div>
                         		<b><?php echo functions::deformat_string($member_com->first_name) .' '. strtoupper(substr($member_com->last_name, 0, 1)).'.' ?></b>
                			</div>
                                </td>
                                <td>
                                    <div class="block-comment-gray">
                                        <span class="block-comment-arrow"> &nbsp; </span>
                                        <div class="block-comment-center">
                                            <blockquote>
                                                <span>
                                                    <a href="<?php echo URI_ROOT ?>user/publicProfile/<?php echo $data->member_id ?>"><?php echo functions::deformat_string($member_com->first_name) .' '. strtoupper(substr($member_com->last_name, 0, 1)).'.' ?></a> wrote:
                                                </span>
                                                <?php echo functions::deformat_string($data->comment) ?>                           </blockquote>
                                        </div>
                                        <div class="block-comment-bot">
                                            <p><?php echo  date('m/d/Y', strtotime($data->created_date)) . ' at '. date('h:i A', strtotime($data->created_date)) ?> </p>
                                        <div class="activity-block">
                
                                                </div>
                                       <div class="block-comment-bot-in">
                                       
                                       
                                       <!--    Flag   -->
                                       <?php if(spam_report::get_spam_exist($data->content_comment_id) == 0 && $data->member_id != $_SESSION[MEMBER_ID]) {?>
                                       
                                       <div class="activity-block">
                                    
                                            <div style="display: inline" id="report_spam_button_ContentComments_<?php echo $data->content_comment_id ?>" class="report_spam_button">   
                                                <a style="cursor:pointer;" id="flag_btn_<?php echo $data->content_comment_id ?>"  data-reveal-id="flagBox" data-animation="fadeAndPop" class="link-flag spam_report">&nbsp;</a>
                                            </div>  
                                       </div>
                                       <?php } ?>
                                       <!--    Flag   -->
                                       
                                       
                                       
                                       
                                       
                                       
                                       
                                                <div class="activity-block share">
                                                    
                                                    <div class="count">
     													<span><a class="addthis_counter addthis_bubble_style" layout="button_count"></a></span>
                                                    </div>
                                                    
                                                    <a class="share-btn addthis_button"></a>
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="active activity-block heart " >
               									 <div class="count"><span class="like-count" id="cmnt_like_<?php echo $data->content_comment_id ?>"><?php echo content_like::get_comment_like_total($data->content_comment_id, 'like'); ?></span></div>
                <a style="cursor:pointer;" class="comment3" id="like_<?php echo $data->content_comment_id ?>"></a></div>
                
                <div class="active activity-block plus" ><div class="count"><span class="like-count" id="cmnt_favorite_<?php echo $data->content_comment_id ?>"> <?php echo content_like::get_comment_like_total($data->content_comment_id, 'favorite'); ?></span></div><a style="cursor:pointer;" class="fav3" id="favorite_<?php echo $data->content_comment_id ?>"></a></div>
                                            

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
               		 </div>
                    <?php	
				}
			}
		}
		
		public static function get_profile_comments($member_id = 0)
		{
			$output 		= array();
			$database		= new database();
			$sql 			= "SELECT * FROM content_comment WHERE member_id=$member_id ORDER BY created_date DESC";
			$result				= $database->query($sql);	
			if($result->num_rows > 0)
			{
				while($data 	= $result->fetch_object())
				{
					$output[]		= $data;
				}
			}
			
			return $output;
		}
		
	}
?>