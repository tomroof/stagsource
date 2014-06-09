<?php
/*********************************************************************************************
Author 	: V V VIJESH
Date	: 14-April-2011
Purpose	: Case Studies class
*********************************************************************************************/
class spam_report
{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';
	
	public $status_array	= array(0=>'Not Read', 1=>'Read');
	public $comment_due_array	= array(1=>'Explicit language', 2=>'Attacks on groups or individual', 3=>'Invades my privacy', 4=>'Hateful speech or symbols', 5=>'Spam or scam', 6=>'Other');
	
	function __construct($spam_report_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		
		if($spam_report_id > 0)
		{
			$this->initialize($spam_report_id);
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
	private function initialize($spam_report_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM spam_report WHERE spam_report_id = '$spam_report_id'";
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
		/*if(!$this->check_spam_report_exist($this->name, $this->_properties['spam_report_id']))
		{*/
			
			
			if ( isset($this->_properties['spam_report_id']) && $this->_properties['spam_report_id'] > 0) 
			{
				$sql	= "UPDATE spam_report SET  status = '". $database->real_escape_string($this->status)  ."' WHERE spam_report_id = '$this->spam_report_id'";
			}
			else 
			{
				$causes		= implode(',', $this->cause);
				$content_comment = new content_comment($this->model_id);
				$content 		= new content($content_comment->content_id);
			
				$order_id	= self::get_max_order_id() + 1;
				$sql		= "INSERT INTO spam_report 
							( model, model_id, user_reported, causes, status, create_datetime) 
							VALUES ('" . $database->real_escape_string($content->name) . "',
									'" . $database->real_escape_string($this->model_id) . "',
									'" . $database->real_escape_string($this->user_reported) . "',
									'" . $database->real_escape_string($causes) . "',
									'0',
							   		NOW()
							    )";
			}
			//print $sql;
			// exit;
			$result			= $database->query($sql);
			
			if($database->affected_rows == 1)
			{
				if($this->spam_report_id == 0)
				{
					$this->spam_report_id	= $database->insert_id;
				}
				$this->initialize($this->spam_report_id);
			}
		
			$this->message = cnst11;
			return true;
		/*}
		else
		{
			return false;	
		}*/
	}
	
	//The function check the spam_report name eixst or not
	public function check_spam_report_exist($name='', $spam_report_id=0)
	{
		$output		= false;
		$database	= new database();
		if($name == '')
		{
			$this->message	= "  spam_report name should not be empty";
			$this->warning	= true;
		}
		else
		{
			if($spam_report_id > 0)
			{
				$sql	= "SELECT *	 FROM spam_report WHERE name = '" . $database->real_escape_string($name) . "' AND spam_report_id != '" . $spam_report_id . "'";
			}
			else
			{
				$sql	= "SELECT *	 FROM spam_report WHERE name = '" . $database->real_escape_string($name) . "'";
			}
			//print $sql;
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$this->message	= " spam_report name is already exists";
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
		if ( isset($this->_properties['spam_report_id']) && $this->_properties['spam_report_id'] > 0) 
		{
			$sql = "DELETE FROM spam_report WHERE spam_report_id = '" . $this->spam_report_id . "'";
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
	public function remove_selected($spam_report_ids)
	{
		$database	= new database();
		if(count($spam_report_ids)>0)
		{		
			foreach($spam_report_ids as $spam_report_id)
			{										
					$sql = "DELETE FROM spam_report  WHERE spam_report_id = '" . $spam_report_id . "'";
					
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
	
	public static function get_spam_report_options()
	{
		$database			= new database();
		$spam_report_options 	= array();
		$sql				= "SELECT * FROM spam_report ORDER BY name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$spam_report_array = array();
			while($data = $result->fetch_object())
			{
				$spam_report_options[$data->spam_report_id]	= $data->name;
			}
		}
		return $spam_report_options;
	}
	
	public static function get_distinct_spam_report_options($spam_report_id)
	{
		$database			= new database();
		$spam_report_options 	= array();
		$sql				= "SELECT DISTINCT spam_report.*
														FROM spam_report LEFT JOIN club ON spam_report.spam_report_id = club.spam_report_id
														WHERE (club.club_id IS NULL
														OR spam_report.spam_report_id NOT IN (club.spam_report_id) 
														OR spam_report.spam_report_id IN ('$spam_report_id'))
														AND spam_report.status='Y'   
														ORDER BY spam_report.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$spam_report_array = array();
			while($data = $result->fetch_object())
			{
				$spam_report_options[$data->spam_report_id]	= $data->name;
			}
		}
		return $spam_report_options;
	}
	
	public static function get_distinct_spam_report_member_options($member_id)
	{
		$database			= new database();
		$spam_report_options 	= array();
		$sql				= "SELECT DISTINCT spam_report.*

														FROM spam_report

														LEFT JOIN member ON spam_report.name = member.spam_report

														WHERE (member.member_id IS NULL

														OR spam_report.name NOT IN (member.spam_report) 

														OR spam_report.name IN ('$member_id'))

														AND spam_report.status='Y'   

														ORDER BY spam_report.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$spam_report_array = array();
			while($data = $result->fetch_object())
			{
				$spam_report_options[$data->spam_report_id]	= $data->name;
			}
		}
		return $spam_report_options;
	}
	
	public static function get_spam_report_list()
	{
		$database			= new database();
		$spam_report_options 	= array();
		$sql				= "SELECT DISTINCT bc.spam_report_id, bc.name FROM spam_report as bc LEFT JOIN image as b on b.spam_report_id = b.spam_report_id ORDER BY bc.name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$spam_report_array = array();
			while($data = $result->fetch_object())
			{
				$spam_report_array['spam_report_id'] = $data->spam_report_id;
				$spam_report_array['name']	= $data->name;
				$spam_report_options[]	= $spam_report_array;
			}
		}
		return $spam_report_options;
	}
	
	public static function get_listing_id()
	{
		$database			= new database();
		$listing_id_array 	= array();
		$sql						= "SELECT listing_id FROM spam_report  ORDER BY listing_id ASC";
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
	
	public static function get_next_id($spam_report_id)
	{
		$database				= new database();
		$next_spam_report_id	= 0;
		 $sql					= "SELECT spam_report_id FROM spam_report WHERE spam_report_id < '$spam_report_id' ORDER BY spam_report_date DESC LIMIT 0, 1";
		//echo $sql;
		$result					= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$data 					= $result->fetch_object();
			$next_spam_report_id	= $data->spam_report_id;
		}
		return $next_spam_report_id;
	}
	
	public function get_spam_report_of_month()
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM spam_report WHERE spam_report_of_month = 'Y' LIMIT 0, 1";
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
		$sql 					= "SELECT * FROM spam_report  ";
		$drag_drop 				= '';
		$search_condition		= '';
				
		if(isset($_REQUEST['search_word']) || $_REQUEST['cause'] > 0 ) 
		{
			$search_word	= functions::clean_string($_REQUEST['search_word']);
			if(!empty($search_word))
			{
				$validation->check_blank($search_word, 'Search word', 'search_word');					
				if (!$validation->checkErrors())
				{
					$param_array[]			= "search=true";
					$param_array[]			= "search_word=" . htmlentities($search_word);
					$search_cond_array[]	= " model like '%" . $database->real_escape_string($search_word) . "%' ";	
				}
			}
			
			if($_REQUEST['cause'] > 0)
			{
				$param_array[]			= "cause=" . htmlentities($cause);	
				$search_cond_array[]	= " FIND_IN_SET($this->cause, causes)";	
			}
			
			// Drag and dorp ordering is not available in search
			//$drag_drop 						= ' nodrag nodrop ';
		}
		
		if(count($search_cond_array)>0) 
		{ 
			$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
		}
				
		$sql			.= $search_condition;
		$sql 			= $sql . " ORDER BY create_datetime DESC ";
		
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
					<input type="hidden" id="spam_report_id" name="spam_report_id" value="0" />
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
				$spam_report_of_month	= $data->spam_report_of_month == 'Y' ? '<img src="images/icon-active.png">' : '';
				
				$content_comment 		= new content_comment($data->model_id);
				$member 				 = new member($data->user_reported);
				
				$causes		= '';
				$cause 		= explode(',',$data->causes);
				foreach($cause as $key=>$val)
				{
					$causes		.= $this->comment_due_array[$val].'<br />';
				}
				
				
				
				
				
				echo '
					<tr id="' . $data->spam_report_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td  class="widthAuto">' . functions::deformat_string($data->model) . '</td>
						<td  class="widthAuto">' . functions::deformat_string($content_comment->comment) . '</td>
						<td  class="widthAuto">' . functions::deformat_string($member->first_name) . ' '. functions::deformat_string($member->last_name). '</td>
						<td  class="widthAuto">' . date('m/d/Y h:i:s', strtotime($data->create_datetime)) . '</td>
						<td  class="widthAuto">' . $causes . '</td>
						<td  class="widthAuto">' . $this->status_array[$data->status] . '</td>
						<td class="alignCenter">
							<a href="register_spam_report.php?spam_report_id=' . $data->spam_report_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>
						<td class="alignCenter deleteCol">
							<label><input type="checkbox" name="checkbox[' . $data->spam_report_id . ']" id="checkbox" /></label>
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
					$urlQuery = 'manage_spam_report.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_spam_report.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='7' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
	
	public static function get_breadcrumbs($spam_report_id, $client_side=false)
	{
		$spam_report 		= new spam_report($spam_report_id);			
		if($client_side)
		{
			$bread_crumb[]			= "<a href='spam_report.php'>Gallery</a>";
		}
		else
		{
			$bread_crumb[]			= "<a href='manage_spam_report.php'>Gallery</a>";
			
		}
					
		$bread_crumb[]			= functions::deformat_string($spam_report->name);
		
		if(count($bread_crumb)>0)
		{
			$bread_crumbs=join(" >> ",$bread_crumb);
		}
		return $bread_crumbs;
	}
	
	public function get_latest_spam_report_list($spam_report_spam_report_id = 0, $max_limit)
	{
		$database			= new database();
		$spam_report_array 	= array();
		$sql			= "SELECT * FROM spam_report WHERE spam_report_spam_report_id='".$spam_report_spam_report_id."' ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$spam_report_gallery_sql				= "SELECT * FROM spam_report_gallery WHERE spam_report_id='".$data->spam_report_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$spam_report_gallery_result				= $database->query($spam_report_gallery_sql);				
				if ($spam_report_gallery_result->num_rows > 0)
				{
					$spam_report_gallery_data = $spam_report_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_spam_report . 'thumb_' . $spam_report_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_spam_report, spam_report_THUMB_WIDTH, spam_report_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_spam_report . 'thumb_' . $spam_report_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
				<div class="sidebar">
					<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
						<h2><a href="spam_report.php?cid=<?php echo $spam_report_spam_report_id; ?>&pid=<?php echo $data->spam_report_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
						<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="spam_report.php?cid=<?php echo $spam_report_spam_report_id; ?>&pid=<?php echo $data->spam_report_id; ?>">Read More</a></p>
					</div>
				</div>
				<?php
			}
		}
	}
	
	/*
	public static function get_spam_report_list22()
	{
		$database			= new database();
		$sql				= "SELECT DISTINCT ic.* FROM spam_report as ic INNER JOIN spam_report_gallery as ig ON ic.spam_report_id = ig.spam_report_id ORDER BY ic.spam_report_id DESC";
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
						
						$spam_report1		= '';
						$spam_report2		= '';
						
						for($j = 0; $j <= $counter; $j++)
						{
							if($j < ceil($counter/2))
							{
								$spam_report1	.= $name[$j] . ' ';
							}
							else
							{
								$spam_report2	.= $name[$j] . ' ';
							}
						}
						echo '<h1>' . $spam_report1 . ' <span>' . $spam_report2 . '</span></h1>';
						?>
						<br />
						
						<?php
						$image_sql		= "SELECT * FROM spam_report_gallery WHERE spam_report_id='".$data->spam_report_id."' ORDER BY added_date DESC";
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
	
	public function get_spam_report_all_list($spam_report_spam_report_id = 0)
	{
		$database			= new database();
		$spam_report_array 	= array();
		$sql				= "SELECT * FROM spam_report WHERE spam_report_spam_report_id='".$spam_report_spam_report_id."' ORDER BY added_date DESC LIMIT 0, 5";
		$result				= $database->query($sql);
		$num_rows			= $result->num_rows;
		if ($result->num_rows > 0)
		{
			$counter		= 0;
			$i				= 0;
			while($data = $result->fetch_object())
			{
				$i++;
				$spam_report_gallery_sql	= "SELECT * FROM spam_report_gallery WHERE spam_report_id='".$data->spam_report_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$spam_report_gallery_result	= $database->query($spam_report_gallery_sql);				
				if ($spam_report_gallery_result->num_rows > 0)
				{
					$spam_report_gallery_data = $spam_report_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_spam_report . 'thumb_' . $spam_report_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_spam_report, spam_report_THUMB_WIDTH, spam_report_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_spam_report . 'thumb_' . $spam_report_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/gallery_image.png';
				}
				?>	
				<div class="portfoilio_image_space"></div>
				<div class="portfoilio_image_outer" style="cursor:pointer;" onclick="select_spam_report_details('<?php echo $spam_report_spam_report_id; ?>', '<?php echo $data->spam_report_id; ?>');">
					<div class="portfoilio_image_box"><img src="<?php echo $thumb_image; ?>" width="132" height="127" /></div>
					<div class="portfoilio_image_title"><?php echo functions::deformat_string($data->name); ?></div>
				</div>
				<?php
				$counter++;
			}
		}
	}
	
	public function get_latest_spam_report_by_spam_report_list($max_limit)
	{
		$database			= new database();
		$spam_report_array 	= array();
		$sql			= "SELECT * FROM spam_report GROUP BY spam_report_spam_report_id ORDER BY added_date DESC LIMIT 0, $max_limit";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$spam_report_gallery_sql				= "SELECT * FROM spam_report_gallery WHERE spam_report_id='".$data->spam_report_id."' ORDER BY added_date DESC LIMIT 0, 1";
				$spam_report_gallery_result				= $database->query($spam_report_gallery_sql);				
				if ($spam_report_gallery_result->num_rows > 0)
				{
					$spam_report_gallery_data = $spam_report_gallery_result->fetch_object();
				
				
					$thumb_image	= '';
					$url			= '';
					
					if(!file_exists(DIR_spam_report . 'thumb_' . $spam_report_gallery_data->image_name))
					{
						$functions	= new functions();
						$functions->generate_thumb_image($data->image_name, DIR_spam_report, spam_report_THUMB_WIDTH, spam_report_THUMB_HEIGHT);
					}
					
					$thumb_image	= URI_spam_report . 'thumb_' . $spam_report_gallery_data->image_name;
				}
				else
				{
					$thumb_image	= 'images/web5.jpg';
				}
				?>
				<div class="sidebar">
					<div class="home_display"><img src="<?php echo $thumb_image; ?>" />
						<h2><a href="spam_report.php?cid=<?php echo $data->spam_report_spam_report_id; ?>&pid=<?php echo $data->spam_report_id; ?>"><?php echo functions::deformat_string($data->name); ?></a></h2>
						<p><?php echo functions::get_sub_words(functions::deformat_string($data->description), 20); ?> <a href="spam_report.php?cid=<?php echo $spam_report_spam_report_id; ?>&pid=<?php echo $data->spam_report_id; ?>">Read More</a></p>
					</div>
				</div>
				<?php
			}
		}
	}
	
	public function get_spam_report_list_08_05_2013()
	{
		$database				= new database();
		$param_array			= array();
		$sql 					= "SELECT cs.* FROM spam_report AS cs ";
		
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
		
		//$sql 			= $sql . " ORDER BY spam_report_date DESC";		
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
				$spam_report_id=$data->spam_report_id;
				
				//$i++;
				//$thumb_image = spam_report_gallery::get_default_image($data->spam_report_id);
				
				
				$sql1="SELECT * FROM spam_report_gallery where spam_report_id= '".$spam_report_id."'";
			
						$result1	= $database->query($sql);
					//while($data=$result->fetch_object($result1))
					//{
				
				?>
              
                <?php  //} ?>
                
         		      
                <?php if($i%1==0) { ?>        
                <div class="box">
                <div class="case-studies-no-dv"><div class="case-studies-no"> <?php echo functions::deformat_string($data->listing_id); ?></div></div>
                <div class="head">
                <a href="casestudy_details.php?cid=<?php echo $data->spam_report_id;?>"><span class="caption">
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
		public static function update_status($spam_report_id, $status = '')
		{		
			$database		= new database();
			$spam_report			= new spam_report($spam_report_id);
			//$current_status = $spam_report->status;
			if($status == '')
			{
				$status =  $spam_report->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE spam_report 
						SET status = '". $status . "'
						WHERE spam_report_id = '" . $spam_report_id . "'";
						
						
			$result 	= $database->query($sql);
			
			
			$sql		= "UPDATE wineries_link
						SET status = '". $status . "'
						WHERE spam_report_id = '" . $spam_report_id . "'";
						
						
			$result1 	= $database->query($sql);
			return $status;
		}	
	/*public function get_spam_report_list()
	{
		$raw_style			= array(
											0=>array(1,2,1,3,1,2),
											1=>array(2,1,2,1,2,1),
											2=>array(1,2,1,2,1,3),
											3=>array(2,1,3,1,2,1)
											);
		$spam_report_array	= array();
		
		$database			= new database();
		$param_array		= array();
		$search_condition	= '';
		$sql 						= "SELECT * FROM spam_report";
		$sql						.= $search_condition;
		$sql 						= $sql . " ORDER BY listing_id ASC ";
		$result					= $database->query($sql);
		$this->num_rows = $result->num_rows;
		functions::paginate_spam_report($this->num_rows, 0, 0, 'CLIENT');
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
				$spam_report_array[$i] = array($data->spam_report_id, $data->listing_id, $data->name,$data->description);
				$i++;
			}
		}
		
		$count			= 0;
		$total_item	= count($spam_report_array);
		if ($total_item > 0)
		{
			if(count($spam_report_array) > 0 && count($spam_report_array) <=3)
			{
				$rows = 1;
			}
			else if(count($spam_report_array) > 3 && count($spam_report_array) <= 6)
			{
				$rows = 2;
			}
			else if(count($spam_report_array) > 6 && count($spam_report_array) <= 9)
			{
				$rows = 3;
			}
			else if(count($spam_report_array) > 9 && count($spam_report_array) <= 12)
			{
				$rows = 4;
			}
			
			$image_array	= spam_report_gallery::get_random_images();
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
						<div class="case-studies-no-dv"><div class="case-studies-no"><?php echo $spam_report_array[$count][1]; ?></div></div>
						<div class="head">
						<a href="casestudy_details.php?cid=<?php echo $spam_report_array[$count][0]; ?>"><span class="caption">
						<h4><?php //echo $spam_report_array[$count][1]; 
						echo  functions::get_sub_string(functions::deformat_string($spam_report_array[$count][2]),8,true);?></h4>
						<h5><?php echo functions::get_sub_string(functions::deformat_string($spam_report_array[$count][3]),90,true);; ?></h5></span></a>
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
							echo '<img src="' .  URI_spam_report . 'thumb_' .  $image_array[$image_count] . '" />';
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
	
	public function getBasespam_report($parent_id){
		$database			= new database();		
		$sql				= "SELECT * FROM spam_report WHERE parent_id = '0' ORDER BY name ASC";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($parent_id == $data->spam_report_id)
					echo '<option value="'.$data->spam_report_id.'" selected="selected">'.$data->name.'</option>';
				else
					echo '<option value="'.$data->spam_report_id.'">'.$data->name.'</option>';	
					
				//to display sub acategories
				$sql				= "SELECT * FROM spam_report WHERE parent_id = '".$data->spam_report_id."' ORDER BY name ASC";
				$result1				= $database->query($sql);		
				if ($result1->num_rows > 0)
				{
					while($data1 = $result1->fetch_object())
					{
						if ($parent_id == $data1->spam_report_id)
							echo '<option value="'.$data1->spam_report_id.'" style="padding-left:2em" selected="selected"> >> '.$data1->name.'</option>';
						else
							echo '<option value="'.$data1->spam_report_id.'" style="padding-left:2em"> >> '.$data1->name.'</option>';	
					}
				}			
						
			}
		}
		return;
	}
	
	public function productsExists($parent_id){
		$flag = '0';
		$database			= new database();		
		$sql				= "SELECT * FROM spam_report  WHERE parent_id = '$parent_id' AND status = 'Y' ";
		$result				= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				$sql 		= "SELECT * FROM product p LEFT JOIN product_gallery g ON p.product_id = g.product_id AND g.valid_image = 'Y'  
							   WHERE p.spam_report_id = '".$data->spam_report_id."' AND p.status = 'Y'  ";
				$result1	= $database->query($sql);		
				if ($result1->num_rows > 0)
				{
					$flag = '1';
				}
			}
		}
		return $flag;
	}
	
	public function displayTopspam_reportMenu(){
		$database			= new database();
		
		//to find categories with products
		$catid_arr  	= array();
		$catid_arr[]	= '0'; 
		$str_id     	= ''; 
		$sql			= "SELECT * FROM spam_report  WHERE parent_id = '0' AND status = 'Y' ORDER BY spam_report_id ASC";
		$result			= $database->query($sql);				
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{
				if ($this->productsExists($data->spam_report_id) > 0){
					$catid_arr[] = $data->spam_report_id;					
				}
			}				
			$str_id     = implode (",",$catid_arr);	
		}			
				
		//$sql				= "SELECT * FROM spam_report  WHERE parent_id = '0' ORDER BY spam_report_id ASC";
		$sql				= "SELECT * FROM spam_report  WHERE spam_report_id IN (".$str_id.") AND status = 'Y' ORDER BY spam_report_id ASC";
		$result				= $database->query($sql);				
		if ($result->num_rows > 0)
		{
			echo '	
				<div id="menu">
					<ul>';
					
			$main_cat_cnt = '1';		
			while($data = $result->fetch_object())
			{
				//if ($this->productsExists($data->spam_report_id) > 0){
					//echo $result->num_rows.' == '.$main_cat_cnt;
					if ($result->num_rows == $main_cat_cnt)
						$class_main_last = 'class="last_item menu_item down"';
					else
						$class_main_last = 'class="menu_item down"';
				
					echo '<li '.$class_main_last.'><a href="spam_report.php?cid='.$data->spam_report_id.'">'.$data->name.'</a>';
					
					$sql 		= "SELECT * FROM spam_report c 
								   INNER JOIN product p ON c.spam_report_id = p.spam_report_id
								   LEFT JOIN product_gallery g ON p.product_id = g.product_id AND g.valid_image = 'Y'  
								   WHERE c.parent_id = '".$data->spam_report_id."' AND c.status = 'Y' AND p.status = 'Y'  
								   GROUP BY c.spam_report_id
								   ORDER BY c.spam_report_id ASC";
								   
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
								
								/*$sql 		= "SELECT * FROM product WHERE spam_report_id = '".$data1->spam_report_id."' AND status = 'Y' ";
								$result3	= $database->query($sql);		
								if ($result3->num_rows > 0)
								{*/		
						
								echo '<li><a href="spam_report.php?cid='.$data1->spam_report_id.'">'.$data1->name.'</a></li>';
								
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
	
	public function getSubspam_reportIdList($spam_report_id){
		$database	= new database();
		
		//newly added
		$catid_arr  = array();
		$catid_arr[]= '0'; 
		$sql		= "SELECT * FROM spam_report WHERE parent_id = '".$spam_report_id."' AND status = 'Y' ORDER BY spam_report_id ASC";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			while($data = $result->fetch_object())
			{				
				$catid_arr[] = $data->spam_report_id;					
			}
		}				
		$str_id     = implode (",",$catid_arr);	
		return $str_id;
	}
	
	public function getParentCategId($cid){
		$database	= new database();
		$sql		= "SELECT * FROM spam_report WHERE spam_report_id = '".$cid."' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{
			$data = $result->fetch_object();
		}
		return $data->parent_id;	
	}	
	
	public function getBasespam_reportListWithProducts(){
		$database	= new database();
		$baseCatListArr = array();
		$sql		= "SELECT * FROM spam_report WHERE parent_id = '0' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->spam_report_id;
						
				$sql1		= "SELECT * FROM spam_report WHERE parent_id = '".$data->spam_report_id."'AND status = 'Y' ";
				$result1	= $database->query($sql1);		
				if ($result1->num_rows > 0)
				{			
					while ($data1 = $result1->fetch_object()){
						$catIdListArray[] = $data1->spam_report_id;
						$sql2		= "SELECT * FROM spam_report WHERE parent_id = '".$data->spam_report_id."' AND status = 'Y' ";
						$result2	= $database->query($sql2);		
						if ($result2->num_rows > 0)
						{			
							while ($data2 = $result2->fetch_object()){
								$catIdListArray[] = $data2->spam_report_id;
							}
						}
					}
				}
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE spam_report_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->spam_report_id;
					 					
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
	
	public function getSubspam_reportListWithProducts($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM spam_report WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->spam_report_id;
						
				$sql1		= "SELECT * FROM spam_report WHERE parent_id = '".$data->spam_report_id."' AND status = 'Y' ";
				$result1	= $database->query($sql1);		
				if ($result1->num_rows > 0)
				{			
					while ($data1 = $result1->fetch_object()){
						$catIdListArray[] = $data1->spam_report_id;						
					}
				}
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE spam_report_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->spam_report_id;
					 					
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
	
	public function subArrowSubspam_report($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM spam_report WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->spam_report_id;
						
				$sql1		= "SELECT * FROM spam_report WHERE parent_id = '".$data->spam_report_id."' AND status = 'Y' ";
				$result1	= $database->query($sql1);		
				if ($result1->num_rows > 0)
				{			
					while ($data1 = $result1->fetch_object()){
						$catIdListArray[] = $data1->spam_report_id;						
					}
				}
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE spam_report_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->spam_report_id;
					 					
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
	
	public function getSubSubspam_reportListWithProducts($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM spam_report WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->spam_report_id;
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE spam_report_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->spam_report_id;
					 					
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
	
	public function subArrowSubSubspam_report($cat_id){
		$database	= new database();
		$baseCatListArr = array();
		$baseCatListArr[] = $cat_id;
		$sql		= "SELECT * FROM spam_report WHERE parent_id = '".$cat_id."' AND status = 'Y' ";
		$result		= $database->query($sql);		
		if ($result->num_rows > 0)
		{			
			while ($data = $result->fetch_object()){
				$catIdListArray   = array();
				$catIdListArray[] = $data->spam_report_id;
								 		
				$sql3		= "SELECT count(*) as cnt FROM product WHERE spam_report_id IN (".implode(",",$catIdListArray).") AND status = 'Y' ";
				$result3	= $database->query($sql3);		
				if ($result3->num_rows > 0)
				{			
					$data3 = $result3->fetch_object();
					if ($data3->cnt > 0) $baseCatListArr[] = $data->spam_report_id;
					 					
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
	
	public function getspam_reportDropMenuList(){
		$database			= new database();
		$baseCatIdList 		= $this->getBasespam_reportListWithProducts();
		$baseCatIdListStr 	= implode(",",$baseCatIdList);
		$sql			= "SELECT * FROM spam_report WHERE spam_report_id IN (".$baseCatIdListStr.") AND parent_id = '0' AND status = 'Y' ORDER BY order_id ";
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
				  
				  		//to display subspam_report list
				  		$subCatIdList 	= $this->getSubspam_reportListWithProducts($data->spam_report_id);
						$sql1			= "SELECT * FROM spam_report WHERE spam_report_id IN (".implode(",",$subCatIdList).") AND parent_id = '".$data->spam_report_id."' AND status = 'Y' ORDER BY order_id ";
						$result1		= $database->query($sql1);
						
						$sql4		= "SELECT * FROM product WHERE spam_report_id = '".$data->spam_report_id."' AND status = 'Y' ORDER BY order_id ";
						$result4	= $database->query($sql4);
														
						if ($result1->num_rows > 0 or $result4->num_rows > 0){
					   		echo '
					  		<div class="product-list">';
						
					   			while ($data1 = $result1->fetch_object()){
					   				
									//to check whether sub arrow
									$subArrowneeded = $this->subArrowSubspam_report($data1->spam_report_id);										
									$arrowClass 	= ($subArrowneeded == '1') ? 'pro_arrow' : '';
									//end to check whether sub arrow									
									
									echo '
									<li class="'.$arrowClass.'">
										<a href="#">'.functions::deformat_string($data1->name).'</a>';
							
										$subSubCatIdList 	= $this->getSubSubspam_reportListWithProducts($data1->spam_report_id);
										$sql2				= "SELECT * FROM spam_report WHERE spam_report_id IN (".implode(",",$subSubCatIdList).") AND parent_id = '".$data1->spam_report_id."' AND status = 'Y' ORDER BY order_id ";
										$result2			= $database->query($sql2);	
										
										$sql5		= "SELECT * FROM product WHERE spam_report_id = '".$data1->spam_report_id."' AND status = 'Y' ORDER BY order_id ";
										$result5	= $database->query($sql5);
																					
										if ($result2->num_rows > 0 or $result5->num_rows > 0){
															
											echo  '
											<ul>';
											
											//to display sub sub spam_report
											while ($data2 = $result2->fetch_object()){
											
												//to check whether sub arrow
												$subSubArrowneeded 	= $this->subArrowSubSubspam_report($data2->spam_report_id);										
												$arrowClass1 		= ($subSubArrowneeded == '1') ? 'pro_arrow' : '';
												//end to check whether sub arrow											
											
												echo '
												<li class="'.$arrowClass1.'">
													<a href="#">'.functions::deformat_string($data2->name).'</a>';
													
													//display sub sub spam_report products
													$sql3		= "SELECT * FROM product WHERE spam_report_id = '".$data2->spam_report_id."' AND status = 'Y' ORDER BY order_id ";
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
											//end of sub sub spam_report
											
											//display sub spam_report products													
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
								
								//display main spam_report products										
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
						//end to display subspam_report list
						  
				  
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
	
	public function getleftspam_reportMenu($pid){
	
		$product 		= new product($pid);
		$spam_report_id 	= $product->spam_report_id; 
		$selcat_flag 	= '0';
		
		if ($spam_report_id > 0){
			$spam_report 		= new spam_report($spam_report_id);
			if ($spam_report->parent_id > 0){
				$sub_spam_report = new spam_report($spam_report->parent_id);
				if ($sub_spam_report->parent_id > 0){
					$sub_sub_spam_report = new spam_report($sub_spam_report->parent_id);
					
					$main_cat_id 	= $sub_sub_spam_report->spam_report_id;
					$sub_cat_id	 	= $sub_spam_report->spam_report_id;
					$sub_sub_cat_id	= $spam_report_id;
												
				}else{
					$main_cat_id = $sub_spam_report->spam_report_id;
					$sub_cat_id	 = $spam_report_id;
				}
				
			}else{
				$main_cat_id = $spam_report_id;
			}
		}
		
		if ($main_cat_id > 0){
		
			$disp_main_spam_report = new spam_report($main_cat_id);
		
			echo '
			  <div class="product-detail_first">
				<div class="pro_hdr">'.functions::deformat_string($disp_main_spam_report->name).'</div>
				<div class="product-list">
				  <ul id="example1">';
			  
			$database	= new database();
				
			//$sql		= "SELECT * FROM spam_report WHERE parent_id = '".$main_cat_id."' AND status = 'Y' ";
			//$result		= $database->query($sql);
			
			$subCatIdList 	= $this->getSubspam_reportListWithProducts($main_cat_id);
			$sql			= "SELECT * FROM spam_report WHERE spam_report_id IN (".implode(",",$subCatIdList).") AND parent_id = '".$main_cat_id."' AND status = 'Y' ORDER BY order_id ASC ";
			$result			= $database->query($sql);
					
			if ($result->num_rows > 0)
			{			
				while ($data = $result->fetch_object()){
				  
				   echo    '<li><a href="#">'.functions::deformat_string($data->name).'</a>';
				   
				   //$sql1	= "SELECT * FROM spam_report WHERE parent_id = '".$data->spam_report_id."' AND status = 'Y' ";
				   //$result1	= $database->query($sql1);
				   
				   $subSubCatIdList = $this->getSubSubspam_reportListWithProducts($data->spam_report_id);
				   $sql1			= "SELECT * FROM spam_report WHERE spam_report_id IN (".implode(",",$subSubCatIdList).") AND parent_id = '".$data->spam_report_id."' AND status = 'Y' ORDER BY order_id ASC ";
				   $result1			= $database->query($sql1);	
														   		
				   if ($result1->num_rows > 0)
				   {
						if ($sub_cat_id == $data->spam_report_id){
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
		  //onMouseOver="javascript: disable_selspam_report();"
		  //store selected spam_report
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
	
	public function getHomespam_reportMenuList(){
		$database		= new database();
		$functions 			= new functions();
		
		$baseCatIdList 	= $this->getBasespam_reportListWithProducts();
		$sql			= "SELECT * FROM spam_report WHERE spam_report_id IN (".implode(",",$baseCatIdList).") AND parent_id = '0' AND status = 'Y' ORDER BY rand() LIMIT 0,3 ";
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
								  
					//to display subspam_report list
					$subCatIdList 	= $this->getSubspam_reportListWithProducts($data->spam_report_id);
					$sql1			= "SELECT * FROM spam_report WHERE spam_report_id IN (".implode(",",$subCatIdList).") AND parent_id = '".$data->spam_report_id."' AND status = 'Y' ORDER BY order_id ASC ";
					$result1		= $database->query($sql1);
					
					$sql4		= "SELECT * FROM product WHERE spam_report_id IN (".implode(",",$subCatIdList).") AND status = 'Y' ORDER BY rand() LIMIT 0,1 ";
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
						
						
						$sql5		= "SELECT * FROM product WHERE spam_report_id = '".$data->spam_report_id."' AND status = 'Y' ORDER BY order_id ASC ";
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
								
								//display main spam_report products																																										   									
								while ($data5 = $result5->fetch_object()){
									echo '
									<li>'.functions::deformat_string($data5->product_name).'</li>';
								}														
								//end of products
						
							echo '</ul>
							</div>
							<div class="readmore"><a href="product.php?pid='.$data4->product_id.'">Read More</a></div>';		  
						}
						//end to display subspam_report list
						  
				  
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
		$sql		= "SELECT MAX(order_id) AS order_id FROM spam_report WHERE 1 ";
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
			$sql = "UPDATE spam_report SET order_id = '" . $order_id . "' WHERE spam_report_id = '" . $id_array[$i] . "'";
			//echo $sql;
			$database->query($sql);
			$order_id++;
		}
	}
	
	public function getspam_reportBreadCrumb($spam_report_id){
		//$database		= new database();
		//$functions 	= new functions();
		$cat_array      = array();
		$spam_report1      = new spam_report($spam_report_id);
				
		if ($spam_report1->name != ''){		
			$cat_array[] = $spam_report1->name;	
			if ($spam_report1->parent_id > 0){
				$spam_report2      = new spam_report($spam_report1->parent_id);	
				if ($spam_report2->name != ''){				
					$cat_array[] = $spam_report2->name;	
					if ($spam_report2->parent_id > 0){
						$spam_report3      = new spam_report($spam_report2->parent_id);	
						$cat_array[]    = $spam_report3->name;			
					}
				}
			}
		}
		$cat_array = array_reverse($cat_array);
		return implode(" >> ",$cat_array);
	}
		

	public function get_spam_report($id=0)
		{
			$database		= new database();
			if($id>0)
			{
				 $sql="	SELECT p.*
 						FROM spam_report p INNER JOIN wineries_link l ON p.spam_report_id = l.spam_report_id order by order_id";	
					
			}else
			{
			 $sql 			= "SELECT * FROM spam_report  order by order_id ";
			}
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
				{
					$array = array();
					while($data = $result->fetch_object())
					{
						$array['spam_report_id'] = $data->spam_report_id;
						$array['name']	= $data->name;
						$spam_report []	= $array;
					}
				}
				return $spam_report;
		
	
			
		}
		
		
		public function get_spam_report_userside()
		{
			$database		= new database();
		//	$sql 			= "SELECT * FROM spam_report  WHERE status='Y' order by order_id ";
			$sql 			= "SELECT DISTINCT b . *
			FROM spam_report b
			INNER JOIN wineries a ON FIND_IN_SET( b.`spam_report_id` , a.spam_report )
			WHERE b.status = 'Y'
			AND a.status = 'Y' order by b.order_id ";
			$spam_report  = array();
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
				{
					$array = array();
					while($data = $result->fetch_object())
					{
						$spam_report []	= $data;
					}
				}
				return $spam_report;
		
	
			
		}
		
		
		//Menu Top
		
		public static function get_top_menu($page_name ='', $page_id= '', $responsive=false)
		{
			$page_id = str_replace('/','', $page_id);
			$database		= new database();
			
			$sql 			= "SELECT * FROM spam_report WHERE status='Y' AND spam_report_id!=1 ORDER BY order_id ASC";
			$result			= $database->query($sql);	
			
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{ 
					if($responsive)
					{
						?>
                        <a href="<?php echo URI_ROOT .'spam_report/'. strtolower(functions::deformat_string($data->name)) ?>"><li><?php echo functions::deformat_string($data->name) ?></li></a>
                        <?php
					}
					else
					{
						if($data->spam_report_id == 10) {
						 ?>
                         	<a style="cursor:pointer;" id="bachelorparty_btn" class="big-link" data-reveal-id="bachelorparty"  data-animation="fadeAndPop">
                         
                         <?php } else if($data->spam_report_id == 2) { ?>
                         	<a style="cursor:pointer;" id="wedding_btn" class="big-link" data-reveal-id="bachelorparty" data-animation="fadeAndPop">
                         <?php } else {
						 ?>
                			<a href="<?php echo URI_ROOT.'spam_report/'. strtolower(functions::deformat_string($data->name)) ?>">
                        <?php } ?>
                        
							<li <?php echo ($page_name =='spam_report.php' && $page_id == strtolower(functions::deformat_string($data->name))) ? 'class="active"' : ''; ?>><?php echo functions::deformat_string($data->name) ?>
                            
                            
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
			
			$sql 			= "SELECT * FROM spam_report WHERE status='Y' ORDER BY order_id ASC";
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
		
		public static function get_spam_report_id_byname($name= '')
		{
			$database		= new database();
			$sql 			= "SELECT spam_report_id FROM spam_report WHERE name='$name'";
			
			$result			= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data = $result->fetch_object();
				return $data->spam_report_id;
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
			$sql 			= "SELECT spam_report_id FROM spam_report WHERE model_id='$model_id'";
			$result			= $database->query($sql);
			return $result->num_rows;
		}
		
    }
?>