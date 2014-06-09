<?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 14-April-2011
	Purpose	: Content class
*********************************************************************************************/
    class content
	{
		protected	$_properties		= array();
		public		$error				= '';
		public		$message			= '';
		public		$warning			= '';
		private		$no_content_option	= array();
		
		public $content_type_array		= array('article'=>'Article', 'product'=>'Product', 'quote'=>'Quote', 'question_answer'=>'Question Answer', 'community'=>'Community', 'vendor'=>'Vendor', 'facebook'=>'Facebook', 'twitter'=>'Twitter', 'instagram'=>'Instagram', 'poll'=>'Poll', 'picture_poll'=>'Picture Poll', 'video'=>'Video', 'image'=>'Image', 'slideshow_album'=>'Slide show album', 'content'=>'Content'); //'dancer'=>'Dancer', 'event'=>'Event',

		public $content_status_array	= array('publish'=>'Publish', 'draft'=>'Draft', 'archive'=>'Archive');
		public $comment_status_array	= array('open'=>'Open', 'close'=>'Close');

		public $class_array				= array('article'=>'article-block-big', 'image'=>'image-block-big', 'slideshow_album'=>'slideshow-block-big', 'product'=>'article-block-big product', 'video'=>'video-block-big','question_answer'=>'answer-block-big','quote'=>'quote-block-big','poll'=>'poll-block-big','picture_poll'=>'picture-poll-block-big');
        function __construct($content_id = 0)
		{
            $this->error	= '';
			$this->message	= '';
			$this->warning	= false;
			
			if($content_id > 0 || $content_id != '')
			{
				$this->initialize($content_id);
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
		private function initialize($content_id)
		{
			$database	= new database();
			
			
			if(is_numeric( $content_id ))
			{
				$sql	= "SELECT *	 FROM content WHERE content_id = '$content_id'";
			}
			else
			{
				if(strstr($content_id,'.html'))
				{
					$sql	= "SELECT *	 FROM content WHERE seo_url = '$content_id'";
				}
				else
				{
					$sql	= "SELECT *	 FROM content WHERE seo_url1 = '$content_id'";
				}
			}
			//print $sql;
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				$this->_properties	= $result->fetch_assoc();
			}
		}
		
		// Save the Content details
		public function save()
		{
			$database	= new database();
			if(!$this->check_content_exist($this->name, $this->content_id) && !$this->check_seo_url_exist($this->seo_url, $this->content_id))
			{
				if ( isset($this->_properties['content_id']) && $this->_properties['content_id'] > 0) 
				{
					$sql	= "UPDATE content SET 
								
								category_id = '". $database->real_escape_string($this->category_id)  ."',
								name = '". $database->real_escape_string($this->name)  ."',
								title = '". $database->real_escape_string($this->title)  ."',
								seo_url = '". $database->real_escape_string($this->seo_url)  ."',
								seo_url1 = '". $database->real_escape_string($this->seo_url1)  ."',
								content = '". $database->real_escape_string($this->content)  ."',
								content_author = '". $database->real_escape_string($this->content_author)  ."',
								quote_author = '". $database->real_escape_string($this->quote_author)  ."',
								content_excerpt = '". $database->real_escape_string($this->content_excerpt)  ."',
								content_source = '". $database->real_escape_string($this->content_source)  ."',
								content_thumbnail = '". $database->real_escape_string($this->content_thumbnail)  ."',
								content_status = '". $database->real_escape_string($this->content_status)  ."',
								content_comment_status = '". $database->real_escape_string($this->content_comment_status)  ."',
								image_size = '". $database->real_escape_string($this->image_size)  ."',
								content_is_premium = '". $database->real_escape_string($this->content_is_premium)  ."',
								premium_color = '". $database->real_escape_string($this->premium_color)  ."',
								product_price  = '". $database->real_escape_string($this->product_price)  ."',
								celebrity_social_links  = '". $database->real_escape_string($this->celebrity_social_links)  ."',
								social_links  = '". $database->real_escape_string($this->social_links)  ."',
								content_question  = '". $database->real_escape_string($this->content_question)  ."',
								content_answer  = '". $database->real_escape_string($this->content_answer)  ."',
								instagram_author = '". $database->real_escape_string($this->instagram_author)  ."',
								content_video_embed  = '". $database->real_escape_string($this->content_video_embed)  ."',
								modified_date = NOW() 
								WHERE content_id = '$this->content_id'";
				}
				else 
				{
					$sql		= "INSERT INTO content 
								(content_type, category_id, name, title, seo_url, seo_url1,  content, content_author,quote_author, content_excerpt, content_source, content_thumbnail, content_status, content_comment_status, image_size, content_is_premium, premium_color, product_price, celebrity_social_links, social_links, content_question, content_answer, instagram_author, content_video_embed, created_date,  modified_date, status) 
								VALUES (
										'" . $database->real_escape_string($this->content_type) . "',
										'" . $database->real_escape_string($this->category_id) . "',
										'" . $database->real_escape_string($this->name) . "',
										'" . $database->real_escape_string($this->title) . "',
										'" . $database->real_escape_string($this->seo_url) . "',
										'" . $database->real_escape_string($this->seo_url1) . "',
										'" . $database->real_escape_string($this->content) . "',
										'" . $database->real_escape_string($this->content_author) . "',
										'" . $database->real_escape_string($this->quote_author) . "',
										'" . $database->real_escape_string($this->content_excerpt) . "',
										
										'" . $database->real_escape_string($this->content_source) . "',
										'" . $database->real_escape_string($this->content_thumbnail) . "',
										'" . $database->real_escape_string($this->content_status) . "',
										'" . $database->real_escape_string($this->content_comment_status) . "',
										'" . $database->real_escape_string($this->image_size) . "',
										'" . $database->real_escape_string($this->content_is_premium) . "',
										'" . $database->real_escape_string($this->premium_color) . "',
										'" . $database->real_escape_string($this->product_price) . "',
										
										'" . $database->real_escape_string($this->celebrity_social_links) . "',
										'" . $database->real_escape_string($this->social_links) . "',
										'" . $database->real_escape_string($this->content_question) . "',
										'" . $database->real_escape_string($this->content_answer) . "',
										'" . $database->real_escape_string($this->instagram_author) . "',
										'" . $database->real_escape_string($this->content_video_embed) . "',
										NOW(),
										NOW(),
										'Y'
										)";
				}
				
				//print $sql;
				$result			= $database->query($sql);
				
				if($database->affected_rows == 1)
				{
					if($this->content_id == 0)
					{
						$this->content_id	= $database->insert_id;
					}
				}
				
				if($this->content_id > 0)
				{
				    if($this->content_type != 'content' && $this->content_type != 'vendor')
					{
						if(count($this->vendor_id) > 0)
						{
							$this->update_vendor_type();	
						}
					}
					
					if($this->seo_title != '' || $this->seo_description != '')
					{
						$this->update_seo();
					}
					
					if($this->tag != '')
					{
						$this->update_tags();
					}
				}
				
				$this->initialize($this->content_id);
				$this->message = cnst11;
				return true;
			}
			else
			{
				return false;	
			}
		}
		
		public function update_vendor_type()
		{
			$database	= new database();
			
			$sql		= "SELECT * FROM post_vendor_relation WHERE post_id='". $this->content_id."' "; 
			$result		= $database->query($sql);
				
			if($result->num_rows > 0)
				{
					while($data  = $result->fetch_object())
					{
						$flag  =0;
						for($i = 0; $i < count($this->vendor_id); $i++)
						{
							$flag =0;
							if($data->vendor_id ==  $this->vendor_id[$i])
							{
								$flag =1;
								break;
							}
						}
						
						if($flag == 0)
						{
							$sql1 = "DELETE FROM post_vendor_relation WHERE id=$data->id";	
							$result1		= $database->query($sql1);
						}
					}
					
					for($i = 0; $i < count($this->vendor_id); $i++)
					{
						$sql1		= "SELECT * FROM post_vendor_relation WHERE post_id='". $this->content_id."' AND vendor_id = '".$this->vendor_id[$i]."'"; 
						$result1		= $database->query($sql1);
						if($result1->num_rows == 0)
						{
							 $sql2	= "INSERT INTO post_vendor_relation(post_id, vendor_id) VALUES (
							'" . $database->real_escape_string($this->content_id) . "', 
							'" . $database->real_escape_string($this->vendor_id[$i]) . "' )";
							$result2		= $database->query($sql2);
						}
					}
				}
				else
				{
					for($i = 0; $i < count($this->vendor_id); $i++)
					{
						$sql1	= "INSERT INTO post_vendor_relation(post_id, vendor_id) VALUES (
							'" . $database->real_escape_string($this->content_id) . "', 
							'" . $database->real_escape_string($this->vendor_id[$i]) . "' )";
						$result1		= $database->query($sql1);
					}
				}
		}
		
		public function  update_tags()
		{
			$database	= new database();
			$tags 		= explode(',', $this->tag);
			$tag_ids	= array();
			for($i =0;$i < count($tags); $i++)
			{
				$sql		= "SELECT * FROM tag WHERE tag='". $database->real_escape_string($tags[$i])."' LIMIT 1"; 
				$result		= $database->query($sql);
				if($result->num_rows == 0)
				{
					$sql1	= "INSERT INTO tag(tag, count_used, data_last_add) VALUES (
								'" . $database->real_escape_string($tags[$i]) . "',
								'0',
								NOW() )";
					$result1		= $database->query($sql1);			
					$tag_ids[]  	= $database->insert_id;				
				}
				else
				{
					$data 	= $result->fetch_object();
					$tag_ids[] = $data->tag_id;	
				}
			}
			
			$ta		= implode(',', $tag_ids);
			$sql		= "DELETE FROM content_tag WHERE tag_id NOT IN($ta) AND content_id=$this->content_id";
			$result		= $database->query($sql);
			
						
			for($i =0; $i< count($tag_ids); $i++)
			{			
				$sql		= "SELECT * FROM content_tag WHERE tag_id='". $tag_ids[$i]."' AND content_id=$this->content_id";
				$result		= $database->query($sql);
				if($result->num_rows == 0)
				{
					$sql1	= "INSERT INTO content_tag(content_id, tag_id, created_at) VALUES (
								'" . $database->real_escape_string($this->content_id) . "',
								'" . $database->real_escape_string($tag_ids[$i]) . "',
								NOW() )";
					$result1		= $database->query($sql1);
					$sql1	= "UPDATE tag SET count_used = (count_used+1) WHERE tag_id=$tag_ids[$i]";
					$result1		= $database->query($sql1);
				}
			}
			
			
		}
		
		
		public function update_seo()
		{
			$database	= new database();
		
			$sql		= "SELECT * FROM content_seopack WHERE content_id='". $this->content_id."'"; 
			$result		= $database->query($sql);
			if($result->num_rows > 0)
			{
				$data 	= $result->fetch_object();
				$sql1	= "UPDATE  content_seopack SET seo_title='". $this->seo_title."', seo_description='". $this->seo_description."' WHERE content_id='". $this->content_id."'";
				$result1		= $database->query($sql1);
			}
			else
			{
				$sql1	= "INSERT INTO content_seopack(model_name, content_id, seo_title, seo_description) VALUES (
							'Contents', 
							'" . $database->real_escape_string($this->content_id) . "', 
							'" . $database->real_escape_string($this->seo_title) . "', 
							'" . $database->real_escape_string($this->seo_description) . "' )";
				$result1		= $database->query($sql1);
			}
			
		}
		
		
		public function remove_content_image($content_id)
		{
			$database	= new database();

			$sql		= "SELECT * FROM content  WHERE content_id='". $content_id."'";
			$result		= $database->query($sql);

			if ($result->num_rows > 0)
			{
				$image_name = '';
				while($data = $result->fetch_object())
				{
					$image_name = $data->content_thumbnail;	
				}
				
				if(file_exists(DIR_CONTENT . $image_name))
				{
					unlink(DIR_CONTENT . $image_name);
				}

				if(file_exists(DIR_CONTENT . 'thumb_' . $image_name))
				{
					unlink(DIR_CONTENT . 'thumb_' . $image_name);
				}
				
				if(file_exists(DIR_CONTENT . 'thumb1_' . $image_name))
				{
					unlink(DIR_CONTENT . 'thumb1_' . $image_name);
				}
				
				if(file_exists(DIR_CONTENT . 'thumb2_' . $image_name))
				{
					unlink(DIR_CONTENT . 'thumb2_' . $image_name);
				}
				
				if(file_exists(DIR_CONTENT . 'thumb3_' . $image_name))
				{
					unlink(DIR_CONTENT . 'thumb3_' . $image_name);
				}
				
				if(file_exists(DIR_CONTENT . 'thumbresize_' . $image_name))
				{
					unlink(DIR_CONTENT . 'thumbresize_' . $image_name);
				}
				
				
				$sql1		= "UPDATE content  SET content_thumbnail ='' WHERE content_id='". $content_id."'";
				
				
				$result1		= $database->query($sql1);
			
			}	
		}
		
		//The function check the content name exist or not
		public function check_content_exist($name='', $content_id=0)
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
				if($content_id > 0)
				{
					$sql	= "SELECT *	 FROM content WHERE name = '" . $database->real_escape_string($name) . "' AND content_id != '" . $content_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM content WHERE name = '" . $database->real_escape_string($name) . "'";
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
		public function check_seo_url_exist($seo_url='', $content_id=0)
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
				if($content_id > 0)
				{
					$sql	= "SELECT *	 FROM content WHERE seo_url = '" . $database->real_escape_string($seo_url) . "' AND content_id != '" . $content_id . "'";
				}
				else
				{
					$sql	= "SELECT *	 FROM content WHERE seo_url = '" . $database->real_escape_string($seo_url) . "'";
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
			if ( isset($this->_properties['content_id']) && $this->_properties['content_id'] > 0) 
			{
				$sql = "DELETE FROM content WHERE content_id = '" . $this->content_id . "'";
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
		public function remove_selected($content_ids)
		{
			$database	= new database();
			if(count($content_ids)>0)
			{		
				foreach($content_ids as $content_id)
				{
					$content		= new content($content_id);
					$image_name 	= $content->content_thumbnail;
					
					if($image_name  != '')
					{
						if(file_exists(DIR_CONTENT . $image_name))
						{
							unlink(DIR_CONTENT . $image_name);
						}
		
						if(file_exists(DIR_CONTENT . 'thumb_' . $image_name))
						{
							unlink(DIR_CONTENT . 'thumb_' . $image_name);
						}
						
						if(file_exists(DIR_CONTENT . 'thumb1_' . $image_name))
						{
							unlink(DIR_CONTENT . 'thumb1_' . $image_name);
						}
						
						if(file_exists(DIR_CONTENT . 'thumb2_' . $image_name))
						{
							unlink(DIR_CONTENT . 'thumb2_' . $image_name);
						}
						
						if(file_exists(DIR_CONTENT . 'thumb3_' . $image_name))
						{
							unlink(DIR_CONTENT . 'thumb3_' . $image_name);
						}
						
						if(file_exists(DIR_CONTENT . 'thumbresize_' . $image_name))
						{
							unlink(DIR_CONTENT . 'thumbresize_' . $image_name);
						}
					
					}
					
					if($content->content_type == 'picture_poll' || $content->content_type == 'poll')
					{
						$content_poll_item	= new content_poll_item();	
						$content_poll_item->remove_by_content($content->content_id);
					}
					
					if($content->content_type == 'slideshow_album')
					{
						content_gallery::remove_by_content($content->content_id);	
					}
					
					
					$sql = "DELETE FROM content WHERE content_id = '" . $content_id . "'";
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
		
		public function get_my_content()
		{
			$database	= new database();
			$title	= $_SESSION[MEMBER_ID];
			$sql		= "SELECT * FROM content WHERE title = $title ORDER BY content_date DESC";
			$result		= $database->query($sql);
			$idate		= 0;
			if ($result->num_rows > 0)
			{	
				while($data=$result->fetch_object())
				{
					$i++;
					$content_serial_value++;
					$row_num++;
			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	
					
					$idate			= explode('-', $data->content_date);
				  	$content_date	= $idate[2] . '-' .  $idate[1] . '-' . $idate[0];
					echo "<tr>
							<td align='center'>$i</td>
							<td>$content_date</td>
							<td>$data->description</td>
							<td><a href='$data->content_url' target='_blank'><img src='images/view-content.png' border='0' title='View'></a></td>
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
			$sql					= "SELECT * FROM content ";
			$drag_drop				= '';
			
			//echo $_REQUEST['category_id'];
			//$search_cond_array[]	= " title = '$this->title' ";
			//$param_array[]			= "title=$this->title";
			if(isset($_REQUEST['search_word']) || $_REQUEST['category_id'] != '' ||  $_REQUEST['content_type'] != '' ||  $_REQUEST['content_status'] != '') 
			{
				$search_word	= functions::clean_string($_REQUEST['search_word']);
				if(!empty($search_word))
				{
					$validation->check_blank($search_word, 'Search word', 'search_word');					
					if (!$validation->checkErrors())
					{
						$param_array[]			= "search=true";
						$param_array[]			= "search_word=" . htmlentities($search_word);
						$search_cond_array[]	= " name like '%" . $database->real_escape_string($search_word) . "%' OR title like '%" . $database->real_escape_string($search_word) . "%' OR seo_url like '%" . $database->real_escape_string($search_word) . "%'";	
					}
				}
				
				if($_REQUEST['category_id'] != '')
				{
						$param_array[]="category_id =".$_REQUEST['category_id'];			
						$search_cond_array[]="category_id  = '".$database->real_escape_string($_REQUEST['category_id'])."'";		
				}
				
				if($_REQUEST['content_type'] != '')
				{
						$param_array[]="content_type =".$_REQUEST['content_type'];			
						$search_cond_array[]="content_type  = '".$database->real_escape_string($_REQUEST['content_type'])."'";		
				}
				
				if($_REQUEST['content_status'] != '')
				{
						$param_array[]="content_status =".$_REQUEST['content_status'];			
						$search_cond_array[]="content_status  = '".$database->real_escape_string($_REQUEST['content_status'])."'";		
				}
				
				
				// Drag and dorp ordering is not available in search
				$drag_drop 						= ' nodrag nodrop ';
			}
			
			if(count($search_cond_array)>0) 
			{ 
				$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
				$sql				.= $search_condition;
			}
						
			$sql 			= $sql . " ORDER BY created_date DESC, content_id DESC";
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
               			<input type="hidden" id="content_id" name="content_id" value="0" />
						<input type="hidden" id="show_content_id" name="show_content_id" value="0" />
						<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
						<input type="hidden" id="page" name="page" value="' . $page . '" />
					</td>
                </tr>';
				
				while($data=$result->fetch_object())
				{
					$i++;
					$content_serial_value++;
					$row_num++;
			      	$class_name= (($row_type%2) == 0) ? "even" : "odd";	
					$status			= $data->status == 'Y' ? 'Active' : 'Inactive';
					$status_image	= $data->status == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
					
					$show_menu			= $data->show_menu == 'Y' ? 'Active' : 'Inactive';
					$show_menu_image	= $data->show_menu == 'Y' ? 'icon-active.png' : 'icon-inactive.png';
					$category			= new category($data->category_id);
					$content_type		= ($data->content_type != 'content') ? $this->content_type_array[$data->content_type] : 'Content';
					
					echo '
						<tr id="' . $data->content_id . '" class="' . $class_name . $drag_drop . '" >
							<td class="alignCenter pageNumberCol">' . $row_num . '</td>
							<td class="widthAuto noBorder handCursor" onclick="javascript: open_content_details(\''.$data->content_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$content_serial_value.'\');"  title="Click here to view details">' . functions::deformat_string($data->title) . '</td>
							<td class="noBorder " >' . functions::deformat_string($category->name) . '</td>';
							//<td class="widthAuto"><a href="#" title="Click here to view details" onClick="javascript:open_content_details(\''.$data->content_id.'\',\'details_div_'.$i.'\',false,\'\',\''.$content_serial_value.'\');return false;">' . functions::deformat_string($data->name) . '</a></td>
							
						echo '<td class="noBorder">'. functions::deformat_string($content_type) .'</td>
							<td class="alignCenter">'.  functions::get_format_date($data->created_date, "d-m-Y") .'</td>
							<td class="alignCenter">';
							if($data->content_type == 'poll' || $data->content_type == 'picture_poll')
							{
								echo '<a href="manage_content_poll_item.php?content_id=' . $data->content_id . '"><img src="images/icon-poll.png" alt="Manage Poll Items" title="Manage Poll Items" width="15" height="16" /></a>';
							}
								echo '
							</td>
							
							<td class="alignCenter">';
							if($data->content_type == 'slideshow_album')
							{
								echo '<a href="manage_content_gallery.php?content_id=' . $data->content_id . '"><img src="images/icon-image.png" alt="Manage Slider Images" title="Manage Slider Images" width="15" height="16" /></a>';
							}
							 echo '</td>
							
							<td class="alignCenter">';
								echo functions::deformat_string($this->content_status_array[$data->content_status]);
							
							echo '</td>
							<td class="alignCenter">';
							
							echo functions::deformat_string($this->comment_status_array[$data->content_comment_status]);
							/*if($data->show_menu_edit == 'Y')
							{
								echo '<a title="Click here to update menu option" class="handCursor" onclick="javascript: change_menu_option(\'' . $data->content_id . '\', \'' . $i . '\');" ><img id="menu_option_image_' . $i . '" src="images/' . $show_menu_image . '" alt ="' . $show_menu  . '" title ="' . $show_menu  . '"></a>';
							}*/
							
							echo '</td>
							<td class="alignCenter">';
							
							$ty = $data->content_type;
							if($ty != 'picture_poll' )
							{
								echo '<a href="register_content.php?content_id=' . $data->content_id . '"><img src="images/icon-edit.png" alt="Edit" title="Edit" width="15" height="16" /></a>';
							}
							echo '</td>
							<td class="alignCenter deleteCol">';
							if($data->status_edit == 'Y')
							{
								echo '
								<label><input type="checkbox" name="checkbox[' . $data->content_id . ']" id="checkbox" /></label>';
							}
							echo '</td>
						</tr>
						<tr id="details'.$i.'" class="expandRow" >
								<td id="details_div_'.$i.'" colspan="11" height="1" ></td>
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
						$urlQuery = 'manage_content.php?page='.$currentPage;
					}
					else
					{
						$urlQuery = 'manage_content.php?'.$this->pager_param1.'&page='.$currentPage;	
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
		public static function update_status($content_id, $status = '')
		{		
			$database		= new database();
			$content			= new content($content_id);
			//$current_status = $content->status;
			if($status == '')
			{
				$status =  $content->status == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE content 
						SET status = '". $status . "'
						WHERE content_id = '" . $content_id . "'";
			$result 	= $database->query($sql);
			return $status;
		}
		
		// The function is used to change the status.
		public static function update_show_menu($content_id, $show_menu = '')
		{		
			$database		= new database();
			$content		= new content($content_id);
			//$current_show_menu = $content->show_menu;
			if($show_menu == '')
			{
				$show_menu =  $content->show_menu == 'Y' ? 'N' : 'Y';
			}
			
			$sql		= "UPDATE content 
						SET show_menu = '". $show_menu . "'
						WHERE content_id = '" . $content_id . "'";
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
			$sql = "UPDATE content SET order_id = '" . $order_id . "' WHERE content_id = '" . $id_array[$i] . "'";
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
				$sql	= "SELECT * FROM content ORDER BY content_date DESC Limit 0, $count";
			}
			else
			{
				$sql	= "SELECT * FROM content ORDER BY content_date DESC";
			}
			//print $sql;
			$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data = $result->fetch_object())
				{
					?>
					<div class="content">
					<?php echo functions::get_sub_string(functions::deformat_string($data->description),180); ?> <a href="content.php#content<?php echo $data->content_id; ?>">Read more</a>
					</div>
					<?php
				}
			}
		}
		
		public static function get_menu($static_menu = '')
		{
			$database			= new database();
			$portfolio_array 	= array();
			$sql				= "SELECT * FROM content WHERE  show_menu = 'Y' AND status = 'Y' ORDER BY name DESC";
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
		
		public static function get_random_content()
		{
			$database	= new database();
			$sql		= "SELECT * FROM content ORDER BY Rand() Limit 0, 1";
			//print $sql;
			$result		= $database->query($sql);
			if ($result->num_rows > 0)
			{
				$data = $result->fetch_object();
				echo functions::deformat_string($data->description);
			}
		}
		
		public function get_content_list()
		{
			$database			= new database();
			$param_array		= array();
			$search_condition	= '';
			$sql 				= "SELECT * FROM content";
					
			$sql				.= $search_condition;
			$sql 				= $sql . " ORDER BY created_date DESC";
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
			
			$content_array		= array();
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
						echo '<div id="content_content_crossline"></div>';	
					}
					
					?>
					<a name="content<?php echo $data->content_id; ?>"></a>
					<div id="content_black_heading">
						<div id="content_white_area">
							<div id="content_image"><img src="<?php echo URI_NEWS . 'thumb_' . $data->image_name; ?>" /></div>
							<div id="content_date"><?php echo functions::get_format_date($data->content_date, "dS M");	?></div>
						</div>
						<div id="content_black_area">
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
			
		
		public function get_article_big_array()
		{
			$big_array		= array();
			$database		= new database();
			$sql 			= "SELECT * FROM content WHERE content_type='article' AND image_size='1' AND status='Y' ORDER BY content_id DESC";
			$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data=$result->fetch_object())
				{
					$big_array[] 	= $data->content_id;	
					$image_name 	= $data->content_thumbnail;
					if(!file_exists(DIR_CONTENT.'thumb_'.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_CONTENT.$image_name);
						$imageLib = new imageLib(DIR_CONTENT.$image_name);
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
						$imageLib->resizeImage(CONTENT_BIG_THUMB_WIDTH, CONTENT_BIG_THUMB_HEIGHT, 0);	
						$imageLib->saveImage(DIR_CONTENT.'thumb1_'.$image_name, 90);
						unset($imageLib);
					}
				}
			}
			
			return $big_array;
			
		}
		
		
		public function get_article_small_array()
		{
			$small_array		= array();
			$database		= new database();
			$sql 			= "SELECT * FROM content WHERE content_type='article' AND image_size='0' AND status='Y' ORDER BY content_id DESC";
			$result				= $database->query($sql);
			if ($result->num_rows > 0)
			{
				while($data=$result->fetch_object())
				{
					$small_array[] = $data->content_id;
					$image_name 	= $data->content_thumbnail;
					
					if(!file_exists(DIR_CONTENT.'thumb_'.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_CONTENT.$image_name);
						$imageLib = new imageLib(DIR_CONTENT.$image_name);
						
						$imageLib->resizeImage(CONTENT_SMALL_THUMB_WIDTH, CONTENT_SMALL_THUMB_HEIGHT, 0);	
						$imageLib->saveImage(DIR_CONTENT.'thumb1_'.$image_name, 90);
						unset($imageLib);
					}
			
				}
			}
			
			return $small_array;
			
		}
		
		public function get_article_array($category_id = 0)
		{
			$param_array			= array();
			$database		= new database();
			if($category_id > 0)
			{
				$sql 			= "SELECT * FROM content WHERE content_type='article' AND category_id=$category_id  AND content_status='publish' ORDER BY created_date DESC";
			}
			else
			{
				$sql 			= "SELECT * FROM content WHERE content_type='article'  AND content_status='publish' ORDER BY created_date DESC";
			}
			
			$result				= $database->query($sql);
			$this->num_rows = $result->num_rows;
			functions::paginateclient_article($this->num_rows, 0, 0, 'CLIENT');
			$start			= functions::$startfrom1;
			$limit			= functions::$limits1;
			$sql 			= $sql . " limit $start, $limit";
			$result			= $database->query($sql);
			
			if(isset($_GET['id']))
			{
				//$param_array[] ="id=".$_GET['id'];
			}
			
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			if ($result->num_rows > 0)
			{
				while($data=$result->fetch_object())
				{
					//$small_array[] = $data->content_id;
					$image_name 	= $data->content_thumbnail;
					
					if(!file_exists(DIR_CONTENT.'thumb_'.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_CONTENT.$image_name);
						$imageLib = new imageLib(DIR_CONTENT.$image_name);
						if($data->image_size == 0)
						{
							$imageLib->resizeImage(CONTENT_SMALL_THUMB_WIDTH, CONTENT_SMALL_THUMB_HEIGHT, 0);	
						}
						else
						{
							$imageLib->resizeImage(CONTENT_BIG_THUMB_WIDTH, CONTENT_BIG_THUMB_HEIGHT, 0);
						}
						$imageLib->saveImage(DIR_CONTENT.'thumb1_'.$image_name, 90);
						unset($imageLib);
						$img	= 'thumb1_'.$image_name;
					}
					else
					{
						$img	= 'thumb_'.$image_name;
					}
					
					$title	  = functions::deformat_string($data->title);
					$title    = (strlen($title)>31) ? substr($title,0, 31).'...': $title;
					$desc     = strip_tags(functions::deformat_string($data->content));
					if($data->image_size == 0)
					{
						$desc	  = (strlen($desc)>250) ? substr($desc, 0, 250): $desc;
					}
					else
					{
						$desc	  = (strlen($desc)>400) ? substr($desc, 0, 400): $desc;	
					}
					
					
					$sub_url 	 = URI_ROOT.'contents/'.$data->seo_url1; 
					
					?>
					<li>
                    	<div class="product_box">
                    		<?php if($data->image_size == 0)
							{ ?>
                            	<a href="<?php echo $sub_url; ?>">
                                    <div class="product_boximg ">
                                        <img src="<?php echo URI_CONTENT.$img;?>" >
                                        <div class="caption">
                                            <div class="blur"> </div>
                                            <div class="caption-text">
                                                <h1><?php echo functions::deformat_string($data->title); ?></h1>
                                                <p>
                                                    <?php echo $desc; ?>
                                                </p>
                                            </div>
                                      </div>
                                  </div> </a>
                            <?php } else { ?>
                            	<a href="<?php echo $sub_url; ?>">
                                <div class="product_boximg ">
                                    <img src="<?php echo URI_CONTENT.$img;?>" style="height:450px;" >
                                    <div class="caption" >
                                        <div class="blur" style="height:506px;">
                                        </div>
                                        <div class="caption-text" >
                                             <h1><?php echo strtoupper($title); ?></h1>
                                            <p >
                                                 <?php echo $desc; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            <?php } ?>   
                                
                                
                                <div class="prd_contentbox">
                                    <?php echo strtoupper($title); ?>
                                    <div class="comment_favbox">
                                        <div class="comment" id="like_<?php echo $data->content_id ?>">
                                            <?php echo content_like::get_like_total($data->content_id, 'like'); ?>
                                        </div>
                                        <div class="fav" id="favorite_<?php echo $data->content_id ?>">
                                            <?php echo content_like::get_like_total($data->content_id, 'favorite'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </li>
					<?php
				}
			}
			else
			{
				echo '<li>Sorry..... No Results Found</li>';	
			}
						
		}
		
		public function get_community_array($category_id = 0)
		{
			$param_array			= array();
			$database		= new database();
			if($category_id > 0)
			{
				$sql 			= "SELECT * FROM content WHERE content_type='community' AND category_id=$category_id  AND content_status='publish' ORDER BY created_date DESC";
			}
			else
			{
				$sql 			= "SELECT * FROM content WHERE content_type='community'  AND content_status='publish' ORDER BY created_date DESC";
			}
			
			$result				= $database->query($sql);
			$this->num_rows = $result->num_rows;
			functions::paginateclient_article($this->num_rows, 0, 0, 'CLIENT');
			$start			= functions::$startfrom1;
			$limit			= functions::$limits1;
			$sql 			= $sql . " limit $start, $limit";
			$result			= $database->query($sql);
			
			if(isset($_GET['id']))
			{
				//$param_array[] ="id=".$_GET['id'];
			}
			
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			if ($result->num_rows > 0)
			{
				while($data=$result->fetch_object())
				{
					$image_name 	= $data->content_thumbnail;
					
					
					if(!file_exists(DIR_CONTENT.'thumb_'.$image_name) && $image_name != '')
					{
						$size_1	= getimagesize(DIR_CONTENT.$image_name);
						
							$imageLib = new imageLib(DIR_CONTENT.$image_name);
							if($data->image_size == 0)
							{
								$imageLib->resizeImage(CONTENT_SMALL_THUMB_WIDTH, CONTENT_SMALL_THUMB_HEIGHT, 0);	
							}
							else
							{
								$imageLib->resizeImage(CONTENT_BIG_THUMB_WIDTH, CONTENT_BIG_THUMB_HEIGHT, 0);
							}
							$imageLib->saveImage(DIR_CONTENT.'thumb1_'.$image_name, 90);
							unset($imageLib);
							$img	= 'thumb1_'.$image_name;
						
					}
					else if($image_name != '')
					{
						$img	= 'thumb_'.$image_name;
					}
					
					$title	  = functions::deformat_string($data->title);
					$title    = (strlen($title)>31) ? substr($title,0, 31).'...': $title;
					$desc     = strip_tags(functions::deformat_string($data->content));
					if($data->image_size == 0)
					{
						//$desc	  = (strlen($desc)>250) ? substr($desc, 0, 250): $desc;
					}
					else
					{
						//$desc	  = (strlen($desc)>400) ? substr($desc, 0, 400): $desc;	
					}
					
					if($data->content_type == 'vendor')
					{
						$sub_url 	 = URI_ROOT.'vendor/'.$data->seo_url1; 
					}
					else if($data->content_type == 'community')
					{
						$sub_url 	 = URI_ROOT.'community/contents/'.$data->seo_url1; 
					}
					else
					{
						$sub_url 	 = URI_ROOT.'contents/'.$data->seo_url1; 
					}
					
					
					//$sub_url 	 = URI_ROOT.'community/contents/'.$data->seo_url1; 
					
					?>
					<li>
                    	<div class="product_box">
                    		<?php if($data->image_size == 0)
							{ ?>
                            	<a href="<?php echo $sub_url; ?>">
                                    <div class="product_boximg ">
                                       <?php if($image_name != '') { ?>
                                        	<img src="<?php echo URI_CONTENT.$img;?>" >
										<?php } else {
										    echo '<span>'.$desc.'</span>';	
										}?>
                                        <div class="caption">
                                            <div class="blur"> </div>
                                            <div class="caption-text">
                                                <h1><?php echo functions::deformat_string($data->title); ?></h1>
                                                <p>
                                                    <?php echo $desc; ?>
                                                </p>
                                            </div>
                                      </div>
                                  </div> </a>
                            <?php } else { ?>
                            	<a href="<?php echo $sub_url; ?>">
                                <div class="product_boximg ">
                               	 <?php if($image_name != '') { ?>
                                    <img src="<?php echo URI_CONTENT.$img;?>" style="height:450px;" >
                                    <?php } ?>
                                    <div class="caption" >
                                        <div class="blur" style="height:506px;">
                                        </div>
                                        <div class="caption-text" >
                                             <h1><?php echo strtoupper($title); ?></h1>
                                            <p >
                                                 <?php echo $desc; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            <?php } ?>   
                                
                                
                                <div class="prd_contentbox">
                                    <?php echo strtoupper($title); ?>
                                    <div class="comment_favbox">
                                        <div class="comment" id="like_<?php echo $data->content_id ?>">
                                            <?php echo content_like::get_like_total($data->content_id, 'like'); ?>
                                        </div>
                                        <div class="fav" id="favorite_<?php echo $data->content_id ?>">
                                            <?php echo content_like::get_like_total($data->content_id, 'favorite'); ?>
                                        </div>
                                    </div>
                                    <!--<div class="comment_favbox">
                                        <div class="comment">
                                            0
                                        </div>
                                        <div class="fav">
                                            15
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                         </li>
					<?php
				}
			}
			else
			{
				echo '<li>Sorry..... No Results Found</li>';	
			}
						
		}
		
		
		public function get_tag_search_lists($search_word = 0)
		{
			$param_array			= array();
			$database		= new database();
			
			$sql 			= "SELECT ct.* FROM  tag AS  t JOIN content_tag AS ct ON t.tag_id = ct.tag_id WHERE t.tag='". $database->real_escape_string($search_word). "' ORDER BY ct.created_at DESC";
			$result				= $database->query($sql);
			if( $result->num_rows > 0)
			{
				$this->num_rows = $result->num_rows;
				functions::paginateclient_article($this->num_rows, 0, 0, 'CLIENT');
				$start			= functions::$startfrom1;
				$limit			= functions::$limits1;
				$sql 			= $sql . " limit $start, $limit";
				$result			= $database->query($sql);
				$param_array[] ="tag=".$search_word;
				$param=join("&amp;",$param_array); 
				$this->pager_param=$param;	
				
				
				while($data	=	$result->fetch_object())
				{
					$content_id  = $data->content_id;
					$content1	= new content($content_id);
					//$small_array[] = $data->content_id;
					$image_name 	= $content1->content_thumbnail;
					
					if(!file_exists(DIR_CONTENT.'thumb_'.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_CONTENT.$image_name);
						$imageLib = new imageLib(DIR_CONTENT.$image_name);
						if($data->image_size == 0)
						{
							$imageLib->resizeImage(CONTENT_SMALL_THUMB_WIDTH, CONTENT_SMALL_THUMB_HEIGHT, 0);	
						}
						else
						{
							$imageLib->resizeImage(CONTENT_BIG_THUMB_WIDTH, CONTENT_BIG_THUMB_HEIGHT, 0);
						}
						$imageLib->saveImage(DIR_CONTENT.'thumb1_'.$image_name, 90);
						unset($imageLib);
						$img	= 'thumb1_'.$image_name;
					}
					else
					{
						$img	= 'thumb_'.$image_name;
					}
					
					$title	  = functions::deformat_string($content1->title);
					$title    = (strlen($title)>31) ? substr($title,0, 31).'...': $title;
					$desc     = strip_tags(functions::deformat_string($content1->content));
					if($content1->image_size == 0)
					{
						$desc	  = (strlen($desc)>250) ? substr($desc, 0, 250): $desc;
					}
					else
					{
						$desc	  = (strlen($desc)>400) ? substr($desc, 0, 400): $desc;	
					}
					
					if($content1->content_type == 'vendor')
					{
						$sub_url 	 = URI_ROOT.'vendor/'.$content1->seo_url1; 
					}
					else if($content1->content_type == 'community')
					{
						$sub_url 	 = URI_ROOT.'community/contents/'.$content1->seo_url1; 
					}
					else
					{
						$sub_url 	 = URI_ROOT.'contents/'.$content1->seo_url1; 
					}
					
					//$sub_url 	 = URI_ROOT.'contents/'.$data->seo_url1; 
					
					?>
					<li>
                    <?php
					   if($content1->content_type == 'product')
					   { 
                       		echo '<div class="corner_price">$'.$content1->product_price.'</div>';
					   }
					   ?>
                    	<div class="product_box">
                    		<?php if($content1->image_size == 0)
							{ ?>
                            	<a href="<?php echo $sub_url; ?>">
                                    <div class="product_boximg ">
                                        <img src="<?php echo URI_CONTENT.$img;?>" >
                                        <div class="caption">
                                            <div class="blur"> </div>
                                            <div class="caption-text">
                                                <h1><?php echo functions::deformat_string($content1->title); ?></h1>
                                                <p>
                                                    <?php echo $desc; ?>
                                                </p>
                                            </div>
                                      </div>
                                  </div> </a>
                            <?php } else { ?>
                            	<a href="<?php echo $sub_url; ?>">
                                <div class="product_boximg ">
                                    <img src="<?php echo URI_CONTENT.$img;?>" style="height:450px;" >
                                    <div class="caption" >
                                        <div class="blur" style="height:506px;">
                                        </div>
                                        <div class="caption-text" >
                                             <h1><?php echo strtoupper($title); ?></h1>
                                            <p >
                                                 <?php echo $desc; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            <?php } ?>   
                                
                                
                                <div class="prd_contentbox">
                                    <?php echo strtoupper($title); ?>
                                    <div class="comment_favbox">
                                        <div class="comment" id="like_<?php echo $content1->content_id ?>">
                                            <?php echo content_like::get_like_total($content1->content_id, 'like'); ?>
                                        </div>
                                        <div class="fav" id="favorite_<?php echo $content1->content_id ?>">
                                            <?php echo content_like::get_like_total($content1->content_id, 'favorite'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </li>
					<?php
				}		
			}
			else
			{
				echo '<li>Sorry..... No Results Found</li>';
			}
			
		}
		
		
		public function get_search_list($search_word = '')
		{
			$param_array			= array();
			$database		= new database();
			
			 $sql 			= "SELECT * FROM content WHERE (content LIKE '%". $database->real_escape_string($search_word). "%') AND content_type!='content' ORDER BY created_date DESC";
			
			$result				= $database->query($sql);
			$this->num_rows = $result->num_rows;
			functions::paginateclient_article($this->num_rows, 0, 0, 'CLIENT');
			$start			= functions::$startfrom1;
			$limit			= functions::$limits1;
			$sql 			= $sql . " limit $start, $limit";
			$result			= $database->query($sql);
			
			if(isset($_GET['id']))
			{
				//$param_array[] ="id=".$_GET['id'];
			}
			
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
			
			if ($result->num_rows > 0)
			{
				while($data=$result->fetch_object())
				{
					//$small_array[] = $data->content_id;
					$image_name 	= $data->content_thumbnail;
					
					if(!file_exists(DIR_CONTENT.'thumb_'.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_CONTENT.$image_name);
						$imageLib = new imageLib(DIR_CONTENT.$image_name);
						if($data->image_size == 0)
						{
							$imageLib->resizeImage(CONTENT_SMALL_THUMB_WIDTH, CONTENT_SMALL_THUMB_HEIGHT, 0);	
						}
						else
						{
							$imageLib->resizeImage(CONTENT_BIG_THUMB_WIDTH, CONTENT_BIG_THUMB_HEIGHT, 0);
						}
						$imageLib->saveImage(DIR_CONTENT.'thumb1_'.$image_name, 90);
						unset($imageLib);
						$img	= 'thumb1_'.$image_name;
					}
					else
					{
						if(file_exists(DIR_CONTENT.$image_name))
						{
							$img	= 'thumb_'.$image_name;
						}
						else
						{
							$img	= '';	
						}
					}
					
					$title	  = functions::deformat_string($data->title);
					$title    = (strlen($title)>31) ? substr($title,0, 31).'...': $title;
					$desc     = strip_tags(functions::deformat_string($data->content));
					if($data->image_size == 0)
					{
						$desc	  = (strlen($desc)>250) ? substr($desc, 0, 250): $desc;
					}
					else
					{
						$desc	  = (strlen($desc)>400) ? substr($desc, 0, 400): $desc;	
					}
					
					if($data->content_type == 'vendor')
					{
						$sub_url 	 = URI_ROOT.'vendor/'.$data->seo_url1; 
					}
					else if($data->content_type == 'community')
					{
						$sub_url 	 = URI_ROOT.'community/contents/'.$data->seo_url1; 
					}
					else
					{
						$sub_url 	 = URI_ROOT.'contents/'.$data->seo_url1; 
					}
					
					?>
					<li>
                       <?php
					   if($data->content_type == 'product')
					   { 
                       		echo '<div class="corner_price">$'.$data->product_price.'</div>';
					   }
					   ?>
                       
                    	<div class="product_box">
                    		<?php if($data->image_size == 0)
							{ ?>
                            	<a href="<?php echo $sub_url; ?>">
                                    <div class="product_boximg ">
                                       <?php if(file_exists(DIR_CONTENT.$image_name) && $image_name != '') { ?>
                                        <img src="<?php echo URI_CONTENT.$img;?>" >
                                        <?php } ?>
                                        <div class="caption">
                                            <div class="blur"> </div>
                                            <div class="caption-text">
                                                <h1><?php echo functions::deformat_string($data->title); ?></h1>
                                                <p>
                                                    <?php echo $desc; ?>
                                                </p>
                                            </div>
                                      </div>
                                  </div> </a>
                            <?php } else { ?>
                            	<a href="<?php echo $sub_url; ?>">
                                <div class="product_boximg ">
                                    <?php if(file_exists(DIR_CONTENT.$image_name)  && $image_name != '') { ?>
                                    <img src="<?php echo URI_CONTENT.$img;?>" style="height:450px;" >
                                    <?php } ?>
                                    <div class="caption" >
                                        <div class="blur" style="height:506px;">
                                        </div>
                                        <div class="caption-text" >
                                             <h1><?php echo strtoupper($title); ?></h1>
                                            <p >
                                                 <?php echo $desc; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            <?php } ?>   
                                
                                
                                <div class="prd_contentbox">
                                    <?php echo strtoupper($title); ?>
                                    <div class="comment_favbox">
                                        <div class="comment" id="like_<?php echo $data->content_id ?>">
                                            <?php echo content_like::get_like_total($data->content_id, 'like'); ?>
                                        </div>
                                        <div class="fav" id="favorite_<?php echo $data->content_id ?>">
                                            <?php echo content_like::get_like_total($data->content_id, 'favorite'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </li>
					<?php
				}
			}
			else
			{
				echo '<li>Sorry..... No Results Found</li>';	
			}
						
		}
		
		
		public function get_article_details($category_id = 0)
		{
			$param_array			= array();
			$database		= new database();
			if($category_id > 0)
			{
				$sql 			= "SELECT * FROM content WHERE content_type='article' AND content_status='publish' ORDER BY created_date DESC LIMIT 8";
			}
			else
			{
				$sql 			= "SELECT * FROM content WHERE content_type='article' AND content_status='publish' ORDER BY created_date DESC LIMIT 8";
			}
			
			$result				= $database->query($sql);

			if ($result->num_rows > 0)
			{
				while($data	=	$result->fetch_object())
				{
					//$small_array[] = $data->content_id;
					$image_name 	= $data->content_thumbnail;
					
					if(file_exists(DIR_CONTENT.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_CONTENT.$image_name);
						$imageLib = new imageLib(DIR_CONTENT.$image_name);
						
							$imageLib->resizeImage(250, 248, 0);	
						
						$imageLib->saveImage(DIR_CONTENT.'thumb2_'.$image_name, 90);
						unset($imageLib);
						$img	= 'thumb2_'.$image_name;
					}
										
					$title	  = functions::deformat_string($data->title);
					$title    = (strlen($title)>25) ? substr($title,0, 25).'...': $title;
					$desc     = strip_tags(functions::deformat_string($data->content));
					//if($data->image_size == 0)
					//{
						$desc	  = (strlen($desc)>250) ? substr($desc, 0, 250): $desc;
					//}
					//else
					//{
					//	$desc	  = (strlen($desc)>400) ? substr($desc, 0, 400): $desc;	
					//}
					
					if($data->content_type == 'vendor')
					{
						$sub_url 	 = URI_ROOT.'vendor/'.$data->seo_url1; 
					}
					else if($data->content_type == 'community')
					{
						$sub_url 	 = URI_ROOT.'community/contents/'.$data->seo_url1; 
					}
					else
					{
						$sub_url 	 = URI_ROOT.'contents/'.$data->seo_url1; 
					}
					
					// $sub_url 	 = URI_ROOT.'contents/'.$data->seo_url1; 
						
					$member1	= new member($data->content_author);
					?>
						<div class="content-block article-block">
                            <div class="content-block-wrap">
                                 <div class="img-wrap">
                                    <a href="<?php echo $sub_url ?>" title="">
                                    <img src="<?php echo URI_CONTENT. $img ?>" alt=""></a>
                                </div>
                              <div class="bot-block">
                                <div class="bot-block-in1"><a href="<?php echo $sub_url ?>" title="<?php echo $title ?>"><?php echo $title ?></a></div>
                                <div class="bot-block-in2">
                                    <p><?php echo functions::deformat_string($member1->first_name).' '. strtoupper(substr($member1->last_name, 0, 1)); ?></p>
                                    <p><?php echo date('m.d.Y', strtotime($data->created_date)) ?></p>
                                </div>
                            </div>
                            
                             <?php if($data->content_is_premium == 'Y' && $data->premium_color ==  1) { 
									echo '<div class="premium"></div>';
								}
								else if($data->content_is_premium == 'Y')
								{
									echo '<div class="premium-white"></div>';
								} ?>
                            
                            </div>
                            
                            <div class="active like-block" >
                            <div class="count" >
                            <span class="like-count" id="cnt1_like_<?php echo $data->content_id ?>"><?php echo content_like::get_like_total($data->content_id, 'like'); ?>
                            </span>
                            </div>
                            <a style="cursor:pointer;" class="comment2" id="like_<?php echo $data->content_id ?>"></a>
                            </div> 
                            
                            
                               <div class="active repost-block"><div class="count" >
                               <span class="like-count" id="cnt1_favorite_<?php echo $data->content_id ?>"><?php echo content_like::get_like_total($data->content_id, 'favorite'); ?></span></div>
                               <a style="cursor:pointer;" class="fav2" id="favorite_<?php echo $data->content_id ?>"></a></div>
                            
                    
                   	 </div>
                     
                     
					<?php
					
				}
			}
			/*else
			{
				echo '<li>Sorry..... No Results Found</li>';	
			}*/
						
		}
		
		public function get_community_details($category_id = 0)
		{
			$param_array			= array();
			$database		= new database();
			if($category_id > 0)
			{
				$sql 			= "SELECT * FROM content WHERE content_type='community' AND content_status='publish' ORDER BY created_date DESC LIMIT 8";
			}
			else
			{
				$sql 			= "SELECT * FROM content WHERE content_type='community' AND content_status='publish' ORDER BY created_date DESC LIMIT 8";
			}
			
			$result				= $database->query($sql);

			if ($result->num_rows > 0)
			{
				$col = "col2";
				$i = 0;
				
				while($data	=	$result->fetch_object())
				{
					if($i == 0 || $i == 6) $col = "col2";
					if($i == 1 || $i == 8) $col = "col3";
					if($i == 2 || $i == 5) $col = "";
					if($i == 3 || $i == 4) $col = "col5";
					//$small_array[] = $data->content_id;
					$image_name 	= $data->content_thumbnail;
					
					if(file_exists(DIR_CONTENT.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_CONTENT.$image_name);
						$imageLib = new imageLib(DIR_CONTENT.$image_name);
						
							//$imageLib->resizeImage(250, 248, 0);	
						$imageLib->resizeImage(82, 82, 0);	
						
						$imageLib->saveImage(DIR_CONTENT.'thumb3_'.$image_name, 90);
						unset($imageLib);
						$img	= 'thumb3_'.$image_name;
					}
										
					$title	  = functions::deformat_string($data->title);
					$title    = (strlen($title)>25) ? substr($title,0, 25).'...': $title;
					$desc     = strip_tags(functions::deformat_string($data->content));
					//if($data->image_size == 0)
					//{
						$desc	  = (strlen($desc)>250) ? substr($desc, 0, 250): $desc;
					//}
					//else
					//{
					//	$desc	  = (strlen($desc)>400) ? substr($desc, 0, 400): $desc;	
					//}
					if($data->content_type == 'vendor')
					{
						$sub_url 	 = URI_ROOT.'vendor/'.$data->seo_url1; 
					}
					else if($data->content_type == 'community')
					{
						$sub_url 	 = URI_ROOT.'community/contents/'.$data->seo_url1; 
					}
					else
					{
						$sub_url 	 = URI_ROOT.'contents/'.$data->seo_url1; 
					}
					
					 //$sub_url 	 = URI_ROOT.'community/contents/'.$data->seo_url1; 
						
					$member1	= new member($data->content_author);
					?>
						
                     <div class="content-block community-block <?php echo $col ?>">
                     <?php if(file_exists(DIR_CONTENT.$image_name) && $image_name != '') { ?>
                			<div class="img-wrap"><a href="<?php echo $sub_url ?>"><img alt="" src="<?php echo URI_CONTENT. $img ?>"></a></div>
                     <?php } ?>
                                <p><a href="<?php echo $sub_url ?>"><?php echo functions::deformat_string($data->title) ?></a></p>
            
                <p class="author"><a href="<?php echo  URI_ROOT ?>user/PublicProfile/<?php echo $member1->member_id ?>">- <?php echo functions::deformat_string($member1->first_name).' '. strtoupper(substr($member1->last_name, 0, 1)); ?></a></p>
           
            <div class="active like-block" >
                            <div class="count" >
                            <span class="like-count" id="cnt1_like_<?php echo $data->content_id ?>"><?php echo content_like::get_like_total($data->content_id, 'like'); ?>
                            </span>
                            </div>
                            <a style="cursor:pointer;" class="comment2" id="like_<?php echo $data->content_id ?>"></a>
                            </div> 
                            
                            
                               <div class="active repost-block"><div class="count" >
                               <span class="like-count" id="cnt1_favorite_<?php echo $data->content_id ?>"><?php echo content_like::get_like_total($data->content_id, 'favorite'); ?></span></div>
                               <a style="cursor:pointer;" class="fav2" id="favorite_<?php echo $data->content_id ?>"></a></div>
               
            </div>
                     
					<?php
					
					$i++;
					
				}
			}						
		}
		
		public function get_vendor_details($content_id = 0)
		{
			$param_array			= array();
			$database		= new database();

			$sql 			= "SELECT * FROM post_vendor_relation WHERE vendor_id='$content_id' AND post_id IN(SELECT content_id FROM content WHERE content_type != 'question_answer' AND content_status='publish') ORDER BY post_id DESC LIMIT 8";
			
			$result				= $database->query($sql);
						
			if ($result->num_rows > 0)
			{
				while($data	=	$result->fetch_object())
				{
					$post_id  = $data->post_id;
					$content1 = new content($post_id);
					//$small_array[] = $data->content_id;
					$image_name 	= $content1->content_thumbnail;
					
					if(file_exists(DIR_CONTENT.$image_name) && $image_name != '')
					{	
						$size_1	= getimagesize(DIR_CONTENT. $image_name);
						$imageLib = new imageLib(DIR_CONTENT.$image_name);
						
							$imageLib->resizeImage(250, 248, 0);	
						
						$imageLib->saveImage(DIR_CONTENT.'thumb2_'.$image_name, 90);
						unset($imageLib);
						$img	= 'thumb2_'.$image_name;
					}
										
					$title	  = functions::deformat_string($content1->title);
					$title    = (strlen($title)>25) ? substr($title,0, 25).'...': $title;
					$desc     = strip_tags(functions::deformat_string($content1->content));
					//if($data->image_size == 0)
					//{
						$desc	  = (strlen($desc)>116) ? substr($desc, 0, 116).'...': $desc;
					//}
					//else
					//{
					//	$desc	  = (strlen($desc)>400) ? substr($desc, 0, 400): $desc;	
					//}
					
					if($content1->content_type == 'vendor')
					{
						$sub_url 	 = URI_ROOT.'vendor/'.$content1->seo_url1; 
					}
					else if($content1->content_type == 'community')
					{
						$sub_url 	 = URI_ROOT.'community/'.$content1->seo_url1; 
					}
					else
					{
						$sub_url 	 = URI_ROOT.'contents/'.$content1->seo_url1; 
					}
					// $sub_url 	 = URI_ROOT.'contents/'.$content1->seo_url1; 
						
					$member1	= new member($content1->content_author);
					?>
						<div class="content-block article-block product">
                            <div class="content-block-wrap">
                                 <div class="img-wrap">
                                    <a href="<?php echo $sub_url ?>" title="">
                                    <img src="<?php echo URI_CONTENT. $img ?>" alt=""></a>
                                </div>
                                
                                
                                <div class="bot-block" style="font-weight:bold;">
                                    <b><a href="<?php echo $sub_url ?>" title="<?php echo $title ?>"><?php echo $title ?></a></b>
                                    <?php if($content1->content_type == 'product') { ?>
                                    <div class="price-product">$<?php echo $content1->product_price ?></div> 
                                    <?php } ?>
                                    <p style="font-weight:bold;"><?php echo $desc ?></p>
                                </div>
                                
                              <!--<div class="bot-block">
                                <div class="bot-block-in1"><a href="<?php echo $sub_url ?>" title="<?php echo $title ?>"><?php echo $title ?></a></div>
                                <div class="bot-block-in2">
                                    <p><?php echo functions::deformat_string($member1->first_name).' '. strtoupper(substr($member1->last_name, 0, 1)); ?></p>
                                    <p><?php echo date('m.d.Y', strtotime($data->created_date)) ?></p>
                                </div>
                            </div>-->
                            
                             <?php if($data->content_is_premium == 'Y' && $data->premium_color ==  1) { 
									echo '<div class="premium"></div>';
								}
								else if($data->content_is_premium == 'Y')
								{
									echo '<div class="premium-white"></div>';
								} ?>
                            
                            </div>
                            
                            <div class="active like-block" >
                            <div class="count" >
                            <span class="like-count" id="cnt1_like_<?php echo $content1->content_id ?>"><?php echo content_like::get_like_total($content1->content_id, 'like'); ?>
                            </span>
                            </div>
                            <a style="cursor:pointer;" class="comment2" id="like_<?php echo $content1->content_id ?>"></a>
                            </div> 
                            
                            
                               <div class="active repost-block"><div class="count" >
                               <span class="like-count" id="cnt1_favorite_<?php echo $content1->content_id ?>"><?php echo content_like::get_like_total($content1->content_id, 'favorite'); ?></span></div>
                               <a style="cursor:pointer;" class="fav2" id="favorite_<?php echo $content1->content_id ?>"></a></div>
                            
                    
                   	 </div>
                     
                     
					<?php
					
				}
			}					
		}
		
		
		public function get_vendor_ids($content_id = 0)
		{
			$database		= new database();
			$sql 			= "SELECT * FROM post_vendor_relation WHERE post_id=$content_id";
			$result			= $database->query($sql);
			if($result->num_rows > 0)
			{
				while($data  = $result->fetch_object())
				{
					$this->vendor_ids1  .=  ($this->vendor_ids1 != '') ? ','.$data->vendor_id : $data->vendor_id;	
				}
			}

		}
		
		
		
		public function get_seo_values($content_id = 0)
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_seopack WHERE content_id=$content_id LIMIT 1";
			$result			= $database->query($sql);
			if($result->num_rows > 0)
			{
				while($data  = $result->fetch_object())
				{
					$this->seo_title  = $data->seo_title;
					$this->seo_description = $data->seo_description;	
				}
			}
			
		}
		
		public function get_tags($content_id = 0)
		{
			$database		= new database();
			$sql 			= "SELECT * FROM content_tag WHERE content_id=$content_id";
			$result			= $database->query($sql);
			$tags 			= '';
			if($result->num_rows > 0)
			{
				$i   = 0;
				while($data  = $result->fetch_object())
				{
					$tag_id = $data->tag_id;
					$tag 	= new tag($tag_id);
					
					$tags	.=  ($i == 0) ? functions::deformat_string($tag->tag) : ','. functions::deformat_string($tag->tag);	
					$i++;
				}
				
				
			}
			
			$this->tag = $tags;
		}
		
		public function get_article_slider_array($content_id = 0)
		{
			$output			= array();
			$database		= new database();
			$sql 			= "SELECT * FROM content WHERE content_type='article' AND content_status='publish' ORDER BY created_date DESC LIMIT 8";
			$result			= $database->query($sql);
			if($result->num_rows > 0)
			{
				while($data= $result->fetch_object())
				{
					$output[]	= $data->content_id;
				}
			}
			
			return  $output	;
		}
		
		
		public function get_previous_article($content_id = 0)
		{
			$cnt	= new content($content_id);
			$prev_id		= 0;
			$database		= new database();
			$sql 			= "SELECT MAX(content_id) AS content_id FROM content WHERE  content_id < $content_id AND content_type='article'  AND content_status='publish' ORDER BY created_date DESC LIMIT 1";
			$result			= $database->query($sql);
			if($result->num_rows > 0)
			{
				$data= $result->fetch_object();
				$prev_id = $data->content_id;
			}
			
			return $prev_id;
		}
		public function get_next_article($content_id = 0)
		{
			$cnt	= new content($content_id);
			$next_id		= 0;
			$database		= new database();
			$sql 			= "SELECT MIN(content_id) AS content_id FROM content WHERE  content_id > $content_id AND content_type='article'  AND content_status='publish' ORDER BY created_date DESC LIMIT 1";
			$result			= $database->query($sql);
			if($result->num_rows > 0)
			{
				$data= $result->fetch_object();
				$next_id = $data->content_id;
			}
			
			return $next_id;
		}
		
		
		public function save_topic()
		{
			$content_id     = 0;
			$database		= new database();
			
			$sql		= "INSERT INTO content 
								(name, title, content, category_id, content_type,  seo_url, seo_url1, content_author,content_status, content_comment_status, content_is_premium, status, created_date) 
								VALUES ('" . $database->real_escape_string($this->name) . "',
										'" . $database->real_escape_string($this->title) . "',
										'" . $database->real_escape_string($this->content) . "',
										'" . $database->real_escape_string($this->category_id) . "',
										'" . $database->real_escape_string($this->content_type) . "',
										'" . $database->real_escape_string($this->seo_url) . "',
										'" . $database->real_escape_string($this->seo_url1) . "',
										'" . $database->real_escape_string($this->content_author) . "',
										'" . $database->real_escape_string($this->content_status) . "',
										'" . $database->real_escape_string($this->content_comment_status) . "',
										'" . $database->real_escape_string($this->content_is_premium) . "',
										'Y',										
										NOW()
										)";
			$result			= $database->query($sql);
			if($database->affected_rows == 1)
			{
				$content_id	= $database->insert_id;
			}
			
			return $content_id;
		}
		
		//Facebook post data
		public function getFacebookContentData($postUrl = '') {
		
			/*$arrayUrl = explode('/', $content->fb_url);
       		$postID   = end($arrayUrl);
			
			$user = $facebook->getUser();

			// Get Access token
			$access_token = $facebook->getAccessToken();
			//$urlGetPostData = 'https://graph.facebook.com/' . $postID . '?access_token=' . $access_token;
            $out = $facebook->api("/".$postID);*/
			
			$arrayUrl = explode('/', $postUrl);
       		$postID   = end($arrayUrl);
			$facebook = unserialize(FBOBJECT);
			$user = $facebook->getUser();
			// Get Access token
			$access_token = $facebook->getAccessToken();
            ////$out = $facebook->api("/".$postID);
			
			$urlGetPostData = 'https://graph.facebook.com/' . $postID . '?access_token=' . $access_token;			
			$ch = curl_init(); // setup a curl
       		curl_setopt($ch, CURLOPT_URL, $urlGetPostData); // set url to send to
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output		
			$returnData = curl_exec($ch); // execute the curl
			
			curl_close($ch); // close the curl
			
			if (!empty($returnData)) {
				$postData = json_decode($returnData);
	
				$this->facebook_link	   	= ($postData->link) ? $postData->link : $postUrl;
				$this->name	   				= ($postData->name != '') ? $postData->name: 'No title found';
				$this->title	   			= ($postData->name != '') ? $postData->name: 'No title found';
				$this->content	   			= ($postData->message != '') ? $postData->message : (($postData->description != '') ? $postData->description : 'No message and description not found');
				$this->seo_url  	= functions::cleanString($postData->name).'.' . CONTENT_EXTENSION;;
				$this->seo_url1  = functions::cleanString($postData->name);
				//$this->isErrorFBMessage($postData);
			}
		}
		
		//Facebook post data
		public function getTwitterContentData($tweetUrl = '')
		{
			$arrayTweetUrl = explode('/', $tweetUrl);
			$tweetId = end($arrayTweetUrl);
			$twitter = new TwitterApplication();
			$tweetData = $twitter->getDataTweetById($tweetId);
			//print_r($tweetData);
			$this->content = preg_replace("/[^A-Za-z ]/i", "", $tweetData->text);
			$this->title   = $tweetData->user->screen_name;
			$this->name    = $tweetData->user->screen_name;
			$this->seo_url  	= functions::cleanString($tweetData->user->screen_name).'.' . CONTENT_EXTENSION;;
			$this->seo_url1 	 = functions::cleanString($tweetData->user->screen_name);
		}
		
		public function getInstagramContentData($url) {
			$urlGetInstagramData = 'http://api.instagram.com/oembed?url=' . $url;
			$ch = curl_init(); // setup a curl
			curl_setopt($ch, CURLOPT_URL, $urlGetInstagramData); // set url to send to
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
			$returnData = curl_exec($ch); // execute the curl
			curl_close($ch); // close the curl
			$dataObj = json_decode($returnData);
			
			//print_r($dataObj);
			$this->title 	= $dataObj->title;
			$this->name 	= $dataObj->title;
			$this->content 	= $dataObj->url;
			$this->instagram_author = $dataObj->author_name;
			$this->seo_url  	= functions::cleanString($dataObj->title).'.' . CONTENT_EXTENSION;;
			$this->seo_url1 	 = functions::cleanString($dataObj->title);
    	}
	}
?>