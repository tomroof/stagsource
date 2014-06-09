<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 14-April-2011
	Purpose	: Contactus class
*********************************************************************************************/
    class subscribe
	{
		protected $_properties		= array();
		public    $error			= '';
		public    $message			= '';
		public    $warning			= '';

        function __construct($subscribe_id = 0)
		{
            $this->error	= '';
			$this->message	= '';
			$this->warning	= false;
			
			if($subscribe_id > 0)
			{
				$this->initialize($subscribe_id);
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
		private function initialize($subscribe_id)
		{
			$database	= new database();
			$sql		= "SELECT *	 FROM subscribe WHERE subscribe_id = '$subscribe_id'";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
		}
		public function check_subscribe_exist($email='')
		{
			$output		= false;
			$database	= new database();
	
			$sql	= "SELECT *	 FROM subscribe WHERE email = '" . $database->real_escape_string($email) . "'";
			
			$result 	= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$this->message	= "You are already subscribe news letter!";
				$output 		= true;
			}
			else
			{
				$output			= false;
			}
	
			return $output;	
		}
		// Save the Contactus details
		public function save()
		{			
			  $database	= new database();
			  if(!$this->check_subscribe_exist($this->email))
			  {
				   $sql		= "INSERT INTO subscribe ( email ,added_date) 
								VALUES ('" . $database->real_escape_string($this->email) . "',NOW())";
								
				  $result			= $database->query($sql);
				  if($database->affected_rows == 1)
				  {
					  $mail_content	= '';
					  $email_template	= new email_template('subscribe.message');	
										  
					  //$mail_content	= str_replace("{SITE_NAME}", SITE_NAME, $mail_content);
					  $mail_content	= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
					  $mail_content	= str_replace("{EMAIL}", functions::deformat_string($this->email), $mail_content);
					  $mail_content	= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
					  
					  $mailer				= new mailer();					  
					  $mailer->from			= ADMIN_EMAIL_ID;
					  $mailer->from_name	= functions::deformat_string(ADMIN_EMAIL_NAME);
					  $mailer->to_address	= ADMIN_EMAIL_ID;
					  $mailer->subject	= functions::deformat_string($email_template->subject);
					  //$mailer->attach		= DIR_BACKGROUND. 'background.jpg';  
					  $mailer->body		= $mail_content;
					  $mailer->Send();
				  }
		  
			  	  return true;
			  }
			  else
			  {
				  return false;	
			  }
		}
		
	
	public function display_list()
	{
		$database				= new database();
		$validation				= new validation(); 
		$param_array			= array();
		$sql 					= "SELECT * FROM subscribe  ";
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
					$search_cond_array[]	= " email like '%" . $database->real_escape_string($search_word) . "%' ";	
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
	$sql 			= $sql . " ORDER BY subscribe_id DESC ";
		
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
					<input type="hidden" id="subscribe_id" name="subscribe_id" value="0" />
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
				$subscribe_of_month	= $data->subscribe_of_month == 'Y' ? '<img src="images/icon-active.png">' : '';
			$date='';  
			if($data->added_date!= '0000-00-00 00:00:00')
			{
			$date= functions::get_format_date($data->added_date,'d-m-Y');
			}
				
				echo '
					<tr id="' . $data->subscribe_id . '" class="' . $class_name . $drag_drop . '" >
						<td class="alignCenter pageNumberCol">' . $row_num . '</td>
						<td  class="widthAuto">' . functions::deformat_string($data->email) . '</td>
						<td  class="widthAuto">' . functions::deformat_string($date) . '</td>
<!--						<td class="alignCenter joiningDateCol"><a title="Click here to update status" class="handCursor" onclick="javascript: change_subscribe_status(\'' . $data->subscribe_id . '\', \'' . $i . '\');" ><img id="status_image_' . $i . '" src="images/' . $status_image . '" alt ="' . $status  . '" title ="' . $status  . '"></a></td>-->
						<!--<td class="alignCenter">
							<a href="register_subscribe.php?subscribe_id=' . $data->subscribe_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>
						</td>-->
						<td class="alignCenter deleteCol">
							<label><input type="checkbox" name="checkbox[' . $data->subscribe_id . ']" id="checkbox" /></label>
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
					$urlQuery = 'manage_subscribe.php?page='.$currentPage;
				}
				else
				{
					$urlQuery = 'manage_subscribe.php?'.$this->pager_param1.'&page='.$currentPage;	
				}
				functions::redirect($urlQuery);
			}
			else
			{
				echo "<tr><td colspan='6' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
			}
		}
	}
		public function remove_selected($subscribe_ids)
	{
		$database	= new database();
		if(count($subscribe_ids)>0)
		{		
			foreach($subscribe_ids as $subscribe_id)
			{
								
					
										
					$sql = "DELETE FROM subscribe  WHERE subscribe_id = '" . $subscribe_id . "'";
					
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
	
	
	   
	   
	  
	}
?>