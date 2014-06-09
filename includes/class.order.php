<?php
/*********************************************************************************************
Author 	: V V VIJESH
Date	: 04-Nov-2010
Purpose	: Newsletter Group class
*********************************************************************************************/
class order
{
	protected $_properties		= array();
	public    $error			= '';
	public    $message			= '';
	public    $warning			= '';
	public 	  $row				= array();

	function __construct($orders_id = 0)
	{
		$this->error	= '';
		$this->message	= '';
		$this->warning	= false;
		
		if($orders_id > 0)
		{
			$this->initialize($orders_id);
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
	private function initialize($orders_id)
	{
		$database	= new database();
		$sql		= "SELECT *	 FROM orders WHERE orders_id = '$orders_id'";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$this->_properties	= $result->fetch_assoc();
		}
	}

	// Save the POSTCODE details
	public function save()
	{
		$database	= new database();
		if ( isset($this->_properties['orders_id']) && $this->_properties['orders_id'] > 0) 
		{
					
			$system_ip  = $_SERVER['REMOTE_ADDR'];
			$temp_member= isset($_SESSION['temp_member_id']) ? 'Y' : 'N';
			$sql	= "UPDATE orders SET 
			billing_firstname = '". $database->real_escape_string($this->billing_firstname)  ."', 
			billing_lastname = '".  $database->real_escape_string($this->billing_lastname)  ."' , 
			billing_address1 = '".  $database->real_escape_string($this->billing_address1)  ."', 
			billing_address2 = '".  $database->real_escape_string($this->billing_address2)  ."',
			billing_address3 = '".  $database->real_escape_string($this->billing_address3)  ."',
			billing_state = '".  $database->real_escape_string($this->billing_state)  ."',
			billing_country = '".  $database->real_escape_string($this->billing_country)  ."',
			billing_postcode = '".  $database->real_escape_string($this->billing_postcode)  ."', 			
			billing_phone = '".  $database->real_escape_string($this->billing_phone)  ."' , 			 
			billing_email = '".  $database->real_escape_string($this->billing_email)  ."', 
			shipping_firstname = '".  $database->real_escape_string($this->shipping_firstname)  ."', 
			shipping_lastname = '".  $database->real_escape_string($this->shipping_lastname)  ."',
			shipping_address1 = '".  $database->real_escape_string($this->shipping_address1)  ."' , 
			shipping_address2 = '".  $database->real_escape_string($this->shipping_address2)  ."' ,
			shipping_address3 = '".  $database->real_escape_string($this->shipping_address3)  ."' ,
			shipping_state = '".  $database->real_escape_string($this->shipping_state)  ."',
			shipping_country = '".  $database->real_escape_string($this->shipping_country)  ."',
			shipping_postcode = '".  $database->real_escape_string($this->shipping_postcode)  ."', 			 
			shipping_phone = '".  $database->real_escape_string($this->shipping_phone)  ."', 			
			shipping_email = '".  $database->real_escape_string($this->shipping_email)  ."',
			discount_type = '".  $database->real_escape_string($this->discount_type)  ."',
			discount_amount = '".  $database->real_escape_string($this->discount_amount)  ."', 
			shipping_charge = '".  $database->real_escape_string($this->shipping_charge)  ."',
			order_total = '".  $database->real_escape_string($this->order_total)  ."', 
			order_date = '".  $database->real_escape_string($this->order_date)  ."',
			payment_status = '".  $database->real_escape_string($this->payment_status)  ."', 
			delivery_status = '".  $database->real_escape_string($this->delivery_status)  ."', 
			payment_method = '".  $database->real_escape_string($this->payment_method)  ."', 
			user_comments = '".  $database->real_escape_string($this->user_comments)  ."',
			system_ip = '".  $database->real_escape_string($system_ip)  ."', 
			temp_member = '".  $database->real_escape_string($temp_member)  ."' 
			WHERE orders_id = '".$this->orders_id."'";
			
			
			
			
		}
		else 
		{
			$system_ip  = $_SERVER['REMOTE_ADDR'];
			$temp_member= isset($_SESSION['temp_member_id' ]) ? 'Y' : 'N';
			$sql		= "INSERT INTO orders 
							(bill_no,member_id,billing_firstname,billing_lastname,billing_address1,billing_address2,billing_address3,billing_state,billing_country,
							billing_postcode,billing_phone,billing_email,shipping_firstname,shipping_lastname,shipping_address1,shipping_address2,shipping_address3,shipping_state,shipping_country,shipping_postcode,shipping_phone,shipping_email,discount_type,discount_amount,shipping_charge,order_total,order_date,payment_status,delivery_status,payment_method,user_comments,system_ip,temp_member ) 
							VALUES ('" . $database->real_escape_string($this->bill_no) . "',
									'" . $database->real_escape_string($this->member_id) . "',									
									'" . $database->real_escape_string($this->billing_firstname) . "',
									'" . $database->real_escape_string($this->billing_lastname) . "',
									'" . $database->real_escape_string($this->billing_address1) . "',
									'" . $database->real_escape_string($this->billing_address2) . "',
									'" . $database->real_escape_string($this->billing_address3) . "',
									'" . $database->real_escape_string($this->billing_state) . "',
									'" . $database->real_escape_string($this->billing_country) . "',
									'" . $database->real_escape_string($this->billing_postcode) . "',									
									'" . $database->real_escape_string($this->billing_phone) . "',									
									'" . $database->real_escape_string($this->billing_email) . "',
									'" . $database->real_escape_string($this->shipping_firstname) . "',
									'" . $database->real_escape_string($this->shipping_lastname) . "',
									'" . $database->real_escape_string($this->shipping_address1) . "',
									'" . $database->real_escape_string($this->shipping_address2) . "',
									'" . $database->real_escape_string($this->shipping_address3) . "',
									'" . $database->real_escape_string($this->shipping_state) . "',
									'" . $database->real_escape_string($this->shipping_country) . "',
									'" . $database->real_escape_string($this->shipping_postcode) . "',									
									'" . $database->real_escape_string($this->shipping_phone) . "',									
									'" . $database->real_escape_string($this->shipping_email) . "',
									'" . $database->real_escape_string($this->discount_type) . "',
									'" . $database->real_escape_string($this->discount_amount) . "',
									'" . $database->real_escape_string($this->shipping_charge) . "',
									'" . $database->real_escape_string($this->order_total) . "',
									'" . $database->real_escape_string($this->order_date) . "',
									'" . $database->real_escape_string($this->payment_status) . "',
									'" . $database->real_escape_string($this->delivery_status) . "',
									'" . $database->real_escape_string($this->payment_method) . "',
									'" . $database->real_escape_string($this->user_comments) . "',
									'" . $database->real_escape_string($system_ip) . "',
									'" . $database->real_escape_string($temp_member) . "')";
		}
		//echo $sql;
		//exit;
		$result			= $database->query($sql);
		
		if($database->affected_rows == 1)
		{
			if($this->orders_id == 0)
			{
				$this->orders_id	= $database->insert_id;
			}
			$this->initialize($this->orders_id);
		}
		
		$this->message = cnst11;
		/*
			$this->message = cnst10;
			$this->warning = true;
		*/
		
	}
	
	// Function update the payment status
	public function update_payment_status($orders_id = 0, $payment_status = '')
	{
		$orders_id		= $orders_id > 0 ? $orders_id : $this->orders_id;
		$payment_status	= $payment_status != '' ? $payment_status : $this->payment_status;
		
		$database	= new database();
		$sql		= "UPDATE orders 
					SET payment_status = '". $payment_status . "'
					WHERE orders_id = '" . $orders_id . "'";
		$result 	= $database->query($sql);
		if($result)
		{
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	// Function update the delivery status
	public function update_delivery_status()
	{		
		$database	= new database();
		$sql		= "UPDATE orders 
					SET delivery_status = '". $this->delivery_status . "'
					WHERE orders_id = '" . $this->orders_id . "'";
		$result 	= $database->query($sql);
		if($result)
		{
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	
	// Function update the delivery status
	public function update_link_status($orderid,$bookid,$link_status)
	{		
		$database	= new database();
			
			$sql		= "UPDATE order_item 
						SET link_status = '".$link_status."'
						WHERE orders_id = '" . $orderid . "' AND product_id  = '" . $bookid . "' and  book_sending_type='e-book'";
						//echo $sql;
			$result 	= $database->query($sql);
		if($result)
		{
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	// Function update the delivery status
	public function update_order_product_quantity($order_session_id = '')
	{		
		$database	= new database();
		
		$sql		= "SELECT book_id,quantity  FROM shoppingcart   WHERE order_session_id = '$order_session_id' ORDER BY shoppingcart_id ASC";
								
		$result		= $database->query($sql);
		//if($result->num_rows > 0)
//		{			
//			while($data	= $result->fetch_object())
//			{
//				$new_var_quantity	= $data->qty - $data->quantity;
//				$new_var_quantity	= $new_var_quantity > 0 ? $new_var_quantity : 0;
//				
//				$pv_sql		= "UPDATE product_variants 
//							SET quantity = '". $new_var_quantity . "' 
//							WHERE product_variant_id= '".$data->product_variant_id . "'";
//				$pv_result 	= $database->query($pv_sql);
//			}
//		}
	}
	
	
	public function order_product_save()
	{
		$database	= new database();
		$sql		= "INSERT INTO order_item (orders_id,product_id,color_variant_id,size_variant_id,product_code,product_name,discount_code,quantity,price) 
							VALUES ('" . $database->real_escape_string($this->orders_id) . "',
									'" . $database->real_escape_string($this->product_id) . "',
									'" . $database->real_escape_string($this->color_variant_id) . "',
									'" . $database->real_escape_string($this->size_variant_id) . "',
									'" . $database->real_escape_string($this->product_code) . "',
									'" . $database->real_escape_string($this->product_name) . "',
									'" . $database->real_escape_string($this->discount_code) . "',
									'" . $database->real_escape_string($this->quantity) . "',									
									'" . $database->real_escape_string($this->price) . "')";
		//echo $sql;							
									
		$result			= $database->query($sql);
		
		$this->message = cnst11;
	}
	
	
	public function clear_existing_order_products()
	{
		    $database 	= new database;
			$check_exist_prod_sql = "SELECT * FROM order_item WHERE orders_id='".$this->orders_id."'";
			$check_exist_prod_res = $database->query($check_exist_prod_sql);
			if($check_exist_prod_res->num_rows>0)
			{
			    $del_exist_prod_sql = "DELETE FROM order_item WHERE orders_id='".$this->orders_id."'";  
				$del_exist_prod_res = $database->query($del_exist_prod_sql);
			}
	}
	
	
	
	// Returns the max order id
	public static function get_max_orders_id()
	{
		$database	= new database();
		$sql		= "SELECT MAX(orders_id) AS orders_id FROM orders";
		$result		= $database->query($sql);
		
		if ($result->num_rows > 0)
		{
			$data	= $result->fetch_object();
			return $data->orders_id > 0 ? $data->orders_id : 0;
		}
		else
		{
			return 0;
		}
	}
			
	// Remove the current object details.
	public function remove()
	{
		$database	= new database();
		if ( isset($this->_properties['orders_id']) && $this->_properties['orders_id'] > 0) 
		{
			$sql = "DELETE FROM orders WHERE orders_id = '" . $this->orders_id . "'";
			try
			{
				if($result 	= $database->query($sql)) 
				{
					$this->message = cnst12;	// Data successfully removed!
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

	public function display_list($opr = '')
	{
		$database 			= new database();
		$cms_tot_sql 		= "SELECT * FROM orders";
		$search_condition	= "1";
		$display_mesg		= 0;			
		$validate 			= new validation(); 
		//$validate->check_blank($_REQUEST['search_word'], "search_word", "search_word");
		if (!$validate->checkErrors())
		{		
			if(!empty($_REQUEST['search_word']))
			{									   
				$param_array[]="search_word=".functions::clean_string($_REQUEST['search_word']);			
				$search_cond_array[]="bill_no like '%".$database->real_escape_string(addslashes(functions::clean_string($_REQUEST['search_word'])))."%'";		
					   
			}
			if(!empty($_REQUEST['payment_status']))
			{
					$param_array[]="payment_status=".$_REQUEST['payment_status'];			
					$search_cond_array[]="payment_status = '".$database->real_escape_string($_REQUEST['payment_status'])."'";		
			}
			if(!empty($_REQUEST['delivery_status']))
			{
					$param_array[]="delivery_status=".$_REQUEST['delivery_status'];			
					$search_cond_array[]="delivery_status = '".$database->real_escape_string($_REQUEST['delivery_status'])."'";		
			}
				if($this->start_date != "" && $this->end_date != "")
				{
					
					$param_array[]			= "start_date=" . $this->start_date;
					$param_array[]			= "end_date=" . $this->end_date;
					
					$sdate 		= explode('-', $this->start_date);
				    $start_date	= $sdate[2] . '-' .  $sdate[1] . '-' . $sdate[0];
					$edate 		= explode('-', $this->end_date);
				    $end_date	= $edate[2] . '-' .  $edate[1] . '-' . $edate[0];
					
					//$search_cond_array[]	= "registration_date BETWEEN '". $start_date . "' AND '". $end_date. "'";
					
					if($start_date == $end_date)
					{
						$search_cond_array[]	= "DATE(o.order_date) = '". $start_date . "'";	
					}
					else
					{
						$search_cond_array[]	= "DATE(o.order_date) BETWEEN '". $start_date . "' AND '". $end_date. "'";	
						//$search_cond_array[]	= "DATE(dc.registration_date) >= '". $start_date . "' AND DATE(dc.registration_date) <= '". $end_date. "'";	
					}
				}
			if(count($search_cond_array)>0) 
			{ 
				$param=join("&amp;",$param_array); 
				$search_condition.=" AND ".join(" AND ",$search_cond_array); 
				$cms_tot_sql.=" WHERE ".$search_condition;
			}
		}
		else
		{
			$this->error	= $validate->getallerrors();
		}
		
		$cms_tot_result = $database->query($cms_tot_sql);
		$totAllRows 	= $cms_tot_result->num_rows;
		$this->num_rows	= $cms_tot_result->num_rows;
		functions::paginate($totAllRows);
		
		$start			= functions::$startfrom;
		$limit			= functions::$limits;
		$this->totalNumRows = $totAllRows ;
		if(isset($_REQUEST['sort']))
		{
			$orderby = "Order by ".$_REQUEST['sort']." ".$_REQUEST['odr'];
		}
		else
		{
			$orderby = "Order by order_date DESC ";
		}
		
		$order_sql = "SELECT * FROM orders o,paymentmethod p WHERE $search_condition && p.methodId=o.payment_method && p.status='Y' $orderby LIMIT $start,$limit";
	  # print $order_sql;
		$order_result = $database->query($order_sql);		
		
		if (($order_result->num_rows > 0) && ($display_mesg==0))
		{
		   $row_type	= 3;			   
		   $tot_pages	= ceil($cms_tot_result->num_rows/$limit);
		   $page_cnt	= $start;
		   $totNum 		= $order_result->num_rows;
		   
		   while($data=$order_result->fetch_array(MYSQLI_BOTH))
		   {
			  $page_cnt++;
			  $class_name	= (($row_type%2)==0)?"even":"odd";
			  $orders_id	= $data['orders_id'];			    
			  $total 		= ($data['surCharge'] > 0)?number_format($data['order_total']+$data['surCharge'],'2','.',','):number_format($data['order_total'],'2','.',',');
			  
			  echo '<tr class="'.$class_name.'">
				<td class="alignCenter pageNumberCol">'.$page_cnt.'</td>	
				<td class="order_dateCol"><a class="handCursor" title="Click here to view Order details." onclick="javascript:showOrder('. $data['orders_id'].','.$page_cnt.')">'.functions::datetime_formats($data['order_date']).'</a></td>	
				<td class="billNumberCol">'.functions::deformat_string($data['bill_no']).'</td>	
				<td class="nameOfBuyerCol">'.functions::deformat_string($data['billing_firstname']." ".$data['billing_lastname']).'</td>	
				<td class="totalAmountCol">'.functions::deformat_string($total).'</td>
				<!--<td class="payment_methodCol">'.functions::deformat_string($data['method_name']).'</td>-->
				<td class="payment_statusCol"><div id="paymentId'.$data['orders_id'].'">'.functions::deformat_string($data['payment_status']).'</div></td>
				<td class="delivery_statusCol"><div id="deliveryId'.$data['orders_id'].'">'.functions::deformat_string($data['delivery_status']).'</div></td>
				<td class="alignCenter printOrderCol">
					<a href="printOrder.php?id='.$data['orders_id'].'" target="_blank"><img src="images/download.png" alt="Download Label" title="Download Label" width="16" height="16" /></a>
				</td>
				<td class="noBorder alignCenter deleteCol">
					<input type="checkbox" name="checkbox['.$data['orders_id'].']" id="ord_checkbox'.$data['orders_id'].'" />
				</td>
				</tr>
				<tr class="expandRow">
					<td colspan="10" height="1"><span id="txtOrder'. $page_cnt .'"></span></td>
				</tr>
				';
			  $row_type++;
			} 
			if(empty($_REQUEST['page']))
			{
				$this->pager_start=1;
			}
			else
			{
				$this->pager_start=$_REQUEST['page'];
			}
			$this->pager_pages=$tot_pages;
			$this->pager_param=$param;
			
			//added by francis for show div on search
			$this->num_rows = $order_result->num_rows;
		}
		else{
				if($param_array!="")
					$this->pager_param1 = join("&",$param_array);
				//echo "<br />Pager Param is : ".$this->pager_param1;
				if(isset($_GET['page'])){
				   $currentPage = $_GET['page'];
			   	}
			    if($currentPage>1){
				 $currentPage = $currentPage-1;
				 if($this->pager_param1=="")
				   $urlQuery = 'manage_order.php?page='.$currentPage;
				 else
				   $urlQuery = 'manage_order.php?'.$this->pager_param1.'&page='.$currentPage;	
				 //echo "<br />URL Query is : ".$urlQuery;
				 functions::redirect($urlQuery);
				}
				else{
					echo "<tr><td colspan='10' align='center'><div align='center' class='warningMesg'>Sorry.. No records found !!</div></td></tr>";
				}	
			
			}
		
	}
	
	public function history($member_id = 0)
	{
		$database		= new database();
		$validation		= new validation(); 
		$param_array	= array();
							
		$sql			= "SELECT orders_id, bill_no, billing_firstname, billing_lastname, order_total, DATE_FORMAT(order_date, '%d-%m-%Y %H:%i') AS order_date, payment_status, delivery_status, payment_method FROM orders where member_id='$member_id' and payment_status != 'CANCELLED' ORDER BY order_date DESC ";
		$result			= $database->query($sql);
		
		$this->num_rows = $result->num_rows;
		//functions::paginate($this->num_rows);
		functions::paginate($this->num_rows, 0, '', 'CLIENT');
		if(functions::$startfrom == 0) 
		{
			$start			= 0;
		}
		else
		{
			$start			= functions::$startfrom;
		}
		$limit				= functions::$limits;
		
		$sql 			= $sql . " limit $start, $limit";
		$result			= $database->query($sql);
		if ($result->num_rows > 0)
		{				
			$i			= 0;
			$row_num	= functions::$startfrom;
			echo '
			<tr class="lightColorRow nodrop nodrag" style="display:none;">
				<td colspan="7"  class="noBorder">
					<input type="hidden" id="show"  name="show" value="0" />
					<input type="hidden" id="orders_id" name="orders_id" value="0" />
					<input type="hidden" id="num_rows" name="num_rows" value="' . $result->num_rows . '" />
				</td>
			</tr>';
			while($data=$result->fetch_object())
			{					
				$i++;
				$row_num++;
				$class_name= (($row_type%2) == 0) ? "tableData" : "odd";
				
				$sql_paymentmethod		= "SELECT * FROM paymentmethod WHERE methodId = '" . $data->payment_method . "'";
				$result_paymentmethod	= $database->query($sql_paymentmethod);
				if($result_paymentmethod->num_rows > 0)
				{
					$data_paymentmethod = $result_paymentmethod->fetch_object();
				}
					   
				echo '
					<tr id="' . $data->orders_id . '" class="' . $class_name . '" title="Click here to view details" onclick="javascript: show_history(\'' . $data->orders_id . '\', \'' . $i . '\');" style="cursor:pointer"  >
						<td align="center" class="pageNumberCol">' . $row_num . '</td>
						<td align="left" class="order_dateCol">' . functions::deformat_string($data->order_date) . '</td>
						<td align="left" class="widthAuto">' . functions::deformat_string($data->bill_no) . '</td>
						<td align="right" class="totalAmount">'.CURRENCY_SYMBOL.number_format($data->order_total,"2",".",",") . '</td>
						<td align="left" class="payment_method">' . functions::deformat_string($data_paymentmethod->method_name) . '</td>
						<td align="left" class="payment_status pending">' . functions::deformat_string($data->payment_status) . '</td>
						<td align="left" class="payment_status pending">' . functions::deformat_string($data->delivery_status) . '</td>
					</tr>
					<tr class="expandRow">
						<td id="details_' . $i . '" colspan="7" height="1" class="collapseBg" ></td>
					</tr>';
				$row_type++;
			}
			$param=join("&amp;",$param_array); 
			$this->pager_param=$param;
		}
		else
		{
		   echo "<tr><td colspan='7'><div class='warningMesg alignCenter noPaddingTop'>Sorry..No records found s!!</div></td></tr>";
		}
	}
	
	public function checkErrors()
	{
		$message 	= "";
		$database 	= new database;
		$countryId	= $this->countryId;
		$orderStartNonAustralia = $this->orderStartNonAustralia;
		$orderEndNonAustralia   = $this->orderEndNonAustralia;
		$orderStart = $this->$orderStart;
		$orderEnd = $this->orderEnd;
		
		if($countryId!=14 && $orderStartNonAustralia!="" && $orderEndNonAustralia!=""  && !is_numeric($orderStartNonAustralia) || $countryId!=14 && $orderStartNonAustralia!="" && $orderEndNonAustralia!=""  && !is_numeric($orderEndNonAustralia))
			{
				$state_qry	="SELECT * FROM orders WHERE countryId=$countryId AND city='$city' AND orderStartNonAustralia='$orderStartNonAustralia' AND orderEndNonAustralia='$orderEndNonAustralia'";
			}
		else if($countryId!=14 && $orderStartNonAustralia!="" && $orderEndNonAustralia!="" && is_numeric($orderStartNonAustralia) && is_numeric($orderEndNonAustralia))
			{
				$state_qry	="SELECT * FROM orders WHERE countryId=$countryId AND $orderStartNonAustralia BETWEEN orderStartNonAustralia AND orderEndNonAustralia OR countryId=$countryId AND $orderEndNonAustralia BETWEEN orderStartNonAustralia AND orderEndNonAustralia";
			}
		else
			{
				$state_qry	="SELECT * FROM orders WHERE countryId=$countryId AND $orderStart BETWEEN orderStart AND orderEnd OR countryId=$countryId AND $orderEnd BETWEEN orderStart AND orderEnd";
			}
			$state_res	= $database->query($state_qry);
			
		$sel_qry	="SELECT * FROM orders WHERE countryId=$countryId AND orderStart>='$orderStart' AND orderStart<='$orderEnd' OR countryId=$countryId AND orderEnd>='$orderStart' AND orderEnd<='$orderEnd'";
		$sel_res	= $database->query($sel_qry);
			
		$selNon_qry	="SELECT * FROM orders WHERE countryId=$countryId AND orderStartNonAustralia>='$orderStartNonAustralia' AND orderStartNonAustralia<='$orderEndNonAustralia' OR countryId=$countryId AND orderEndNonAustralia>='$orderStartNonAustralia' AND orderEndNonAustralia<='$orderEndNonAustralia'";
		$selNon_res	= $database->query($selNon_qry);
		
		if($state_res && $state_res->$result->num_rows > 0 && $countryId==14)
		{
			$message	="This state/order already added in this country. Please change state name or country to continue.";
		}
		else if($sel_res && $sel_res->num_rows > 0 && is_numeric($orderStart) && is_numeric($orderEnd))
		{
			$message	="Start order or end order already exist in this country. Please re enter order values.";
		}
		else if($selNon_res && $selNon_res->num_rows > 0 && is_numeric($orderStartNonAustralia) && is_numeric($orderEndNonAustralia))
		{
			$message	="Start order or end order already exist in this country. Please re enter order values.";
		}
		else if($countryId==14 && $orderStart!="" && $countryId==14 && $orderStart!="" && strlen($orderStart)<4 || strlen($orderStart)>8)
		{
			$message	="Start order must be a minimum length of 4 and maximum length of 8 characters.";
		}
		else if($countryId==14 && $orderStart!="" && !is_numeric($orderStart))
		{
			$message	="Start order must be a numeric value.</font>";
		}
		else if($countryId==14 && $orderEnd!="" && $countryId==14 && $orderEnd!="" && strlen($orderEnd)<4 || strlen($orderEnd)>8)
		{
			$message	="End order must be a minimum length of 4 and maximum length of 8 characters.";
		}
		else if($countryId==14 && $orderEnd!="" && !is_numeric($orderEnd))
		{
			$message	="End order must be a numeric value.";
		}
		else if($countryId==14 && $orderStart!="" && $orderEnd!="" && $orderStart > $orderEnd)
		{
			$message	="Start order must not be greater than end order.";
		}
		else if($countryId!=14 && $orderStartNonAustralia!="" && !preg_match('/^[A-Za-z0-9 ]+$/',$orderStartNonAustralia))
		{
			$message	="Start order must be a numeric or alpha numeric value.";
		}
		else if($countryId!=14 && $orderEndNonAustralia!="" && !preg_match('/^[A-Za-z0-9 ]+$/',$orderEndNonAustralia))
		{
			$message	="End order must be a numeric or alpha numeric value.";
		}
		else if($countryId!=14 && $orderStartNonAustralia!="" && $orderEndNonAustralia!="" && is_numeric($orderStartNonAustralia) && is_numeric($orderEndNonAustralia) && $orderStartNonAustralia > $orderEndNonAustralia)
		{
			$message	="Start order must not be greater than end order.";
		}
		
		if($meaasge != "")
		{
			$this->message = $message;
			$this->warning = true;
			return 1;
		}
		else
			return 0;
	}
	
	public function send_invoice($payment_type)
	{			
		
		
		  $state_name = $this->shipping_state;
		  
		  if(($this->shipping_phone!="") && ($this->shipping_phone!=0))
		  {
			 $shipping_phone = $this->shipping_phone;
		  }
		  else
		  {
			  $shipping_phone= "None";	
		  }
		  if(($this->shipping_address2!="") && ($this->shipping_address2!=" "))
		  {
			 $shipping_address2 = $this->shipping_address2;
		  }
		  else
		  {
			 $shipping_address2 = "None";	
		  }
			
		  if(($this->shipping_address3!="") && ($this->shipping_address3!=" "))
		  {
			 $shipping_address3 = $this->shipping_address3;
		  }
		  else
		  {
			 $shipping_address3 = "None";	
		  }
			
		/**** Send Invoice to Admin code stats here  ***/
		$admin_mail_content		= '';
		$admin_email_template	= new email_template('order.admin_invoice');
		//Replace template content with original values			
		
		$admin_mail_content		= str_replace("{orderid}", $this->bill_no, $admin_email_template->content);
		$admin_mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $admin_mail_content);
		$admin_mail_content		= str_replace("{full_name}", functions::deformat_string($this->shipping_firstname . " " . $this->shipping_lastname), $admin_mail_content);
		$admin_mail_content		= str_replace("{address1}", functions::deformat_string($this->shipping_address1), $admin_mail_content);
		$admin_mail_content		= str_replace("{address2}", functions::deformat_string($this->shipping_address2), $admin_mail_content);
		$admin_mail_content		= str_replace("{address3}", functions::deformat_string($shipping_address3), $admin_mail_content);
		$admin_mail_content		= str_replace("{postcode}", functions::deformat_string($this->shipping_postcode), $admin_mail_content);	
		
				
		$admin_mail_content		= str_replace("{county}", functions::deformat_string($state_name), $admin_mail_content);
		$admin_mail_content		= str_replace("{country}", functions::deformat_string($this->shipping_country), $admin_mail_content);				
		$admin_mail_content		= str_replace("{phone}", functions::deformat_string($shipping_phone), $admin_mail_content);						
		$admin_mail_content		= str_replace("{email}", functions::deformat_string($this->shipping_email), $admin_mail_content);		
		
		$admin_mail_content		= str_replace("{orderdate}", functions::datetime_formats($this->order_date), $admin_mail_content);
		/*$shopping_cart_data = shoppingcart::cart_for_nvoice($order_session_id); */
		$shopping_cart_data = order::order_product_for_invoice($this->orders_id);
		
						
		$admin_mail_content		= str_replace("{Shopping_cart}", $shopping_cart_data, $admin_mail_content);		
			
		$admin_mail_content		= str_replace("{payment_method}", $payment_type, $admin_mail_content);										
		//$admin_mail_content		= str_replace("{comments}", functions::deformat_string($this->user_comments), $admin_mail_content);
		$admin_mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $admin_mail_content);
												
		$mailer				= new mailer();
		$mailer->from		= ADMIN_EMAIL_ID;
		$mailer->to			= ADMIN_EMAIL_ID;			
		$mailer->subject	= $admin_email_template->subject;
		$mailer->body		= $admin_mail_content;
		$mailer->send();		
		/**** Send Invoice to Admin code ends here  ***/
				
							
		/**** Send Invoice to Customer code stats here  ***/
		$mail_content		= '';
		$email_template		= new email_template('order.customer_invoice');
		//Replace template content with original values
		$mail_content		= str_replace("{fname}", functions::deformat_string($this->billing_firstname), $email_template->content);
		//$mail_content		= str_replace("{orderid}", $_SESSION['orders_id'], $mail_content);
		$mail_content		= str_replace("{orderid}", $this->bill_no, $mail_content);			
		
		$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $mail_content);
		$mail_content		= str_replace("{full_name}", functions::deformat_string($this->shipping_firstname . " " . $this->shipping_lastname), $mail_content);
		$mail_content		= str_replace("{address1}", functions::deformat_string($this->shipping_address1), $mail_content);
		$mail_content		= str_replace("{address2}", functions::deformat_string($this->shipping_address2), $mail_content);
		$mail_content		= str_replace("{address3}", functions::deformat_string($shipping_address3), $mail_content);
		$mail_content		= str_replace("{postcode}", functions::deformat_string($this->shipping_postcode), $mail_content);				
		
		$mail_content		= str_replace("{county}", functions::deformat_string($state_name), $mail_content);
		$mail_content		= str_replace("{country}", functions::deformat_string($this->shipping_country), $mail_content);				
						
		$mail_content		= str_replace("{phone}", functions::deformat_string($shipping_phone), $mail_content);
		$mail_content		= str_replace("{email}", functions::deformat_string($this->shipping_email), $mail_content);
		$mail_content		= str_replace("{order_email}", ADMIN_EMAIL_ID , $mail_content);	
		$mail_content		= str_replace("{order_phone}", PHONE, $mail_content);
		
		$mail_content		= str_replace("{orderdate}", functions::datetime_formats($this->order_date), $mail_content);
		
			
		/*$shopping_cart_data = shoppingcart::cart_for_nvoice($order_session_id); */		
		$shopping_cart_data = order::order_product_for_invoice($this->orders_id); 
							
		$mail_content		= str_replace("{Shopping_cart}", $shopping_cart_data, $mail_content);		
			
		$mail_content		= str_replace("{payment_method}", $payment_type, $mail_content);	
		//$mail_content		= str_replace("{comments}", functions::deformat_string($this->user_comments), $mail_content);
		$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
		
		
								
		$mailer				= new mailer();
		$mailer->from		= ADMIN_EMAIL_ID;
		$mailer->to			= $this->billing_email;
		$mailer->subject	= $email_template->subject;
		$mailer->body		= $mail_content;
		//echo $mailer->body;
		$invoice_sent       = $mailer->send();	
					
		return $invoice_sent;
		/**** Send Invoice to Customer code end here  ***/		
	}
	
	
	
	public function order_product_for_invoice($orders_id)
	{
			$order			= new order($orders_id);
			//$deliveryOption	= $order->deliveryOption;
			$shipping_charge	= $order->shipping_charge > 0 ? $order->shipping_charge : 0;
			$discount_amount    = $order->discount_amount > 0 ? $order->discount_amount : 0;
			$database	= new database();
			//$sql		= "SELECT * FROM order_item WHERE orders_id='$orders_id' ORDER BY product_name ASC";
			//$sql		= "SELECT * FROM order_item o join book b  ON o.product_id = b.book_id  WHERE  o.orders_id='$orders_id'  ORDER BY o.order_item_id  ASC";
			$sql		= "SELECT * FROM order_item WHERE orders_id='$orders_id'  ORDER BY order_item_id  ASC";
			$result		= $database->query($sql);	
			
			$grant_total	= 0;
			if ($result->num_rows > 0)
			{
				$cart_invoice='<table width="99%" border="0" cellspacing="1"  cellpadding="4" >
                 	<tr bgcolor="#ededed">
                    	<td width="30" align="center"><font face="Arial" size="2"><strong>No.</strong></font></td>
                        <td width="365"><font face="Arial" size="2"><strong>Product Name</strong></font></td>
						<td width="365"><font face="Arial" size="2"><strong>Product Code</strong></font></td>
                        <td width="65" align="center"><font face="Arial" size="2"><strong>Quantity</strong></font></td>
                        <td width="90" nowrap="nowrap" align="right"><font face="Arial" size="2"><strong>Price('.CURRENCY_SYMBOL.')</strong></font></td>
                        <td width="125" align="right"><font face="Arial" size="2"><strong>Total Price('.CURRENCY_SYMBOL.')</strong></font></td>
                    </tr>';
					$i = 0;
				while($data = $result->fetch_object())
				{
					$i++;
					$product 			= new product($data->product_id);
					//$product_name		= $data->product_name;
					$product_name		= $order->getOrderProductName($data->order_item_id);
					
					//$specificAreaFlag = 0;
					#$specificAreaFlag = $shipArea->getSpecificShippingAreaCategory($productCategoryId); 
					
					$sub_total			= $data->price * $data->quantity;
					$grant_total 		= $grant_total + $sub_total;
					$cart_invoice.='
					<tr>
						<td align="center" ><font face="Arial" size="2">' . $i .'</font></td>
						<td align="left"><font face="Arial" size="2">' . functions::deformat_string($product_name) . '</font></td>
						<td align="left"><font face="Arial" size="2">' .  $data->product_code . '</font></td>
						<td align="center"><font face="Arial" size="2">' . $data->quantity . '</font></td>
						<td align="right"><font face="Arial" size="2">' . number_format($data->price,'2','.',',') . '</font></td>
						<td align="right" ><font face="Arial" size="2">' . number_format($sub_total,'2','.',',') . '</font></td>
					</tr>
					';
				}
				$cart_invoice.='<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="3" align="right" class="alignRight"><font face="Arial" size="2"><strong>Net Amount</strong></font></td>
						<td align="right" class="alignRight"><font face="Arial" size="2"><strong>'.CURRENCY_SYMBOL.number_format($grant_total,'2','.',',') .'</strong></font></td>
					</tr>';
					
				if($discount_amount > 0)
				{
					$grant_total	=  $grant_total - $discount_amount;
				}
				if($discount_amount > 0)
				{
					$cart_invoice .= '
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="3" align="right" class="alignRight"><font face="Arial" size="2"><strong>Discount Amount</strong></font></td>
						<td align="right"><div align="right"><font face="Arial" size="2"><strong>'.CURRENCY_SYMBOL.number_format($discount_amount,'2','.',',') .'</strong></font></div></td>
					</tr>';
				}						
				
				if($shipping_charge > 0)
				{
					$grant_total	=  $grant_total + $shipping_charge;
				}
				if($shipping_charge >0)
				{
					$cart_invoice.='
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="3" align="right" class="alignRight"><font face="Arial" size="2"><strong>Shipping Charge</strong></font></td>
						<td align="right"><div align="right"><font face="Arial" size="2"><strong>'.CURRENCY_SYMBOL.number_format($shipping_charge,'2','.',',') .'</strong></font></div></td>
					</tr>';
				}
					
				
				$cart_invoice.='
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="3" align="right" class="alignRight"><font face="Arial" size="2"><strong>Total</strong></font></td>
						<td align="right" class="alignRight"><font face="Arial" size="2"><strong>'.CURRENCY_SYMBOL.number_format($grant_total,'2','.',',') .'</strong></font></td>
					</tr>
              </table>';
			}
			return $cart_invoice;
	}
	
	
	
	public function get_history_count($member_id = 0)
	{
			$database		= new database();
			$validation		= new validation(); 			
		
			$history_sql	= "SELECT orders_id, bill_no, billing_firstname, billing_lastname, order_total, DATE_FORMAT(order_date, '%d-%m-%Y %H:%i') AS order_date, payment_status, delivery_status, payment_method FROM orders where member_id='$member_id' AND temp_member='N' ORDER BY order_date DESC ";
			$result			= $database->query($history_sql);
			
			return $result->num_rows;
	}	
		
		
		
	public function export_order_list()
	{
		$order_list			= '';
		$status               	= '';
		$database				= new database();
		
		$param_array			= array();
		$sql 					= "SELECT * FROM orders o,paymentmethod p";
		 #p.methodId=o.payment_method && p.status='Y'
		if ($this->search_word != "" || $this->payment_status != ""  || $this->delivery_status != "" || ($this->start_date != "" && $this->end_date != "") )
		{
			
			
         if(($this->search_word != "") && ($this->search_word != " "))
			{		
									   
				$param_array[]="search_word=".$this->search_word;			
				$search_cond_array[]="bill_no like '%".$this->search_word."%'";		
					   
			}
			 if(($this->payment_status != "") && ($this->payment_status != " "))
			{
					$param_array[]="payment_status=".$this->payment_status;			
					$search_cond_array[]="payment_status = '".$this->payment_status."'";		
			}
			 if(($this->delivery_status != "") && ($this->delivery_status != " "))
			{
					$param_array[]="delivery_status=".$this->delivery_status;			
					$search_cond_array[]="delivery_status = '".$this->delivery_status."'";		
			}
				if($this->start_date != "" && $this->end_date != "")
				{
					
					$param_array[]			= "start_date=" . $this->start_date;
					$param_array[]			= "end_date=" . $this->end_date;
					
					$sdate 		= explode('-', $this->start_date);
				    $start_date	= $sdate[2] . '-' .  $sdate[1] . '-' . $sdate[0];
					$edate 		= explode('-', $this->end_date);
				    $end_date	= $edate[2] . '-' .  $edate[1] . '-' . $edate[0];
					
					//$search_cond_array[]	= "registration_date BETWEEN '". $start_date . "' AND '". $end_date. "'";
					
					if($start_date == $end_date)
					{
						$search_cond_array[]	= "DATE(o.order_date) = '". $start_date . "'";	
					}
					else
					{
						$search_cond_array[]	= "DATE(o.order_date) BETWEEN '". $start_date . "' AND '". $end_date. "'";	
						//$search_cond_array[]	= "DATE(dc.registration_date) >= '". $start_date . "' AND DATE(dc.registration_date) <= '". $end_date. "'";	
					}
				}
	}	
	
		$param_array[]="p.methodId=o.payment_method";			
		$search_cond_array[]="p.methodId=o.payment_method";	
		
		$param_array[]="p.status='Y'";			
				$search_cond_array[]="p.status='Y'";	
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
			$sortField	= "o.order_date ";
			$sortOrder	= "DESC";
			$sql		.= " ORDER BY ".$sortField." ".$sortOrder;
		}
		
		//echo $sql;
		//exit;
		$result						= $database->query($sql);
		$this->num_rows				= $result->num_rows;
		if ($result->num_rows > 0)
		{
			
				$order_list	.= functions::array_to_csvstring(array('No.','Order Date','Bill Number','Name of Buyer','Total Amount','Payment Method','Payment Status','Delivery Status'));
			
			$i=0;
			
			while($data=$result->fetch_object())
			{
				    $i++;
					$newlines				= array("\r\n", "\n", "\r");
					$order_total=number_format($data->order_total,2,'.',',');
										
					$order_list	.= functions::array_to_csvstring(
											array(
												$i,
												functions::deformat_string($data->order_date),
												functions::deformat_string($data->bill_no),
												functions::deformat_string($data->billing_firstname." ".$data->billing_lastname),
												$order_total,
												functions::deformat_string($data->method_name),
												functions::deformat_string($data->payment_status),
												functions::deformat_string($data->delivery_status)
											  )
										);
				
						
			}
		}
		return $order_list;
	}	
	
	
	// The function is used to update unique_code value.
		public function update_unique_code($book_id, $orders_id,$unique_code = '')
		{		
			$database	= new database();
			
			$sql		= "UPDATE order_item 
						SET unique_code = '". $unique_code . "'
						WHERE product_id = '" . $book_id . "' and orders_id 	='" . $orders_id . "'";
						//echo $sql;
			$result 	= $database->query($sql);
		}
		
		public function set_unique_code_status($unique_code = '')
		{		
			$database	= new database();
			
			$sql		= "UPDATE order_item 
						SET epub_file = 1, mobi_file = 1 
						WHERE unique_code = '" . $unique_code . "'";
			$result 	= $database->query($sql);
		}
		
		public function cancel_unique_code_status($unique_code, $file_type)
		{		
			$database	= new database();
			
			$sql		= "UPDATE order_item 
						SET " . $file_type . " 	= 0 
						WHERE unique_code = '" . $unique_code . "'";
			$result 	= $database->query($sql);
		}
		
		public function check_unique_code_status($unique_code, $file_type)
		{
			$database	= new database();
			$sql		= "SELECT * FROM order_item WHERE unique_code = '" . $unique_code . "' AND " . $file_type . " = 1";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		
		// The function return a random number
		public function get_unique_code()
		{
			$database 	= new database();
			$random_num = rand(12345,199999)+rand(123,999);
			$timestamp	= time();
			$unique_code= $random_num . ($timestamp + rand(10,999));
			$sql		= "SELECT * FROM order_item WHERE unique_code = '" . $unique_code . "'";
			$result		= $database->query($sql);
			if($result->num_rows > 0)
			{
				$this->get_unique_code();
			}
			else
			{
				return $unique_code;
			}
		}
		
		
		
		// Returns the max order id
		public function check_unique_code($unique_code)
		{
			$database	= new database();
			$sql		= "SELECT * FROM order_item WHERE unique_code = '" . $unique_code . "'";
			$result		= $database->query($sql);
			
			if ($result->num_rows > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		
		
	function generate_link($orders_id)
	{
		
		$database = new database();
		$sql = "SELECT * FROM order_item where orders_id='".$orders_id."' and  book_sending_type='e-book'";
		//echo $sql;
		$result= $database->query($sql);
		$book_line_url="";
		while($data=$result->fetch_object())
		{
			$unique_code	= $this->get_unique_code();
			$order2= new order();
			$order2->update_unique_code($data->product_id,$orders_id,$unique_code);
			$order2->set_unique_code_status($unique_code);
			$order3= new order($orders_id);
			$member_details= new member($order3->member_id);
			$epub_url		= URI_ROOT . 'download_book.php?book_id=' . $data->product_id . '&orders_id=' . $orders_id. '&uc=' . $unique_code.'&type=epub';
			$mobi_url		= URI_ROOT . 'download_book.php?book_id=' . $data->product_id . '&orders_id=' . $orders_id. '&uc=' . $unique_code.'&type=mobi';
			
			//$book_line_url .= "<a href='" . $mobi_url . "' title='Download E-Book'><img src='" . URI_ROOT . "images/download_book.png' border='0' alt='Download E-Book' ></a><br><br>";
			$book_line_url .= "<a href='" . $epub_url . "' title='Download Other Devices E-Book'><img src='" . URI_ROOT . "images/download_other_book.png' border='0' alt='Download Other Devices E-Book'  ></a><br>";
		}
			
		if($book_line_url!="")
		{
			/****  mail code stats here  ***/
			$mail_content		= '';
			$email_template		= new email_template('member.download-book');
			//Replace template content with original values
			$mail_content		= str_replace("{SITE_NAME}", SITE_NAME, $email_template->content);
			$mail_content		= str_replace("{name}", functions::deformat_string($member_details->first_name), $mail_content);
			$mail_content		= str_replace("{URL}", $book_line_url, $mail_content);
			$mail_content		= str_replace("{URI_ROOT}", URI_ROOT, $mail_content);
			
			//echo $mail_content;
			//exit;
			$mailer				= new mailer();
			$mailer->from		= ADMIN_EMAIL_ID;
			$mailer->to			= $member_details->email;
			$mailer->subject	= $email_template->subject;
			$mailer->body		= $mail_content;
						
			$mailer->send();
			/**** Forgot password mail code end here  ***/
		}
	}
	
	public function generateBillNumber()
	{
		//$length=7;   //Commented by Merin on 16-dec-2010
		$length=10;  //Added by Merin on 16-dec-2010
		$level=2;
		list($usec, $sec) = explode(' ', microtime());
		srand((float) $sec + ((float) $usec * 100000));
		
		$validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
		$validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$validchars[3] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			
		$randomString  = "AH";  
		
		$counter   = 0;
		
		while ($counter < $length)
		{
			$actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);
			// All character must be different
			if (!strstr($randomString, $actChar))
			{
				$randomString .= $actChar;
				$counter++;
			}
		}
		
		//return strtoupper($randomString."/".$id."/".date("d-m-Y"));
		return strtoupper($randomString."/".date("d-m-Y"));
	}
	
	public function display_order_item($orders_id){
		$order   	= new order($orders_id);
		$database   = new database();
		$sub_qry	= "SELECT * FROM order_item WHERE orders_id = '$orders_id' ORDER BY order_item_id ASC";
		$result	    = $database->query($sub_qry);
		echo '
		<table class="list">
        <thead>
          <tr>
            <td class="left">Product Name</td>
            <td class="left">Product Code</td>
            <td class="right">Quantity</td>
            <td class="right">Price</td>
            <td class="right">Total</td>
          </tr>
        </thead>
        <tbody>';
		$sub_total			= 0;
		while($data = $result->fetch_object())
		{ 
		  $sub_total			+= $data->price * $data->quantity;
          echo '
		  <tr>
            <td class="left">'.$data->product_name.'</td>
            <td class="left">'.$data->product_code.'</td>
            <td class="right">'.$data->quantity.'</td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($data->quantity * $data->price,'2','.',',').'</td>
          </tr>';
		}  
        
		echo '    
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"></td>
            <td class="right"><b>Sub-Total : </b></td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($sub_total,'2','.',',').'</td>
          </tr>';
		if ($order->discount_amount > 0){  
          echo '
		  <tr>
            <td colspan="3"></td>
            <td class="right"><b>Discount Amount:</b></td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($order->discount_amount,'2','.',',').'</td>
          </tr>';
		}  
		echo '  
		  <tr>
            <td colspan="3"></td>
            <td class="right"><b>Shipping Charge:</b></td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($order->shipping_charge,'2','.',',').'</td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td class="right"><b>Total:</b></td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($order->order_total,'2','.',',').'</td>
          </tr>
        </tfoot>
      </table>';
	  
	}
	
	public function get_order_discount_code($orders_id){
		$order   	= new order($orders_id);
		$database   = new database();
		$sub_qry	= "SELECT * FROM order_item WHERE orders_id = '$orders_id' ORDER BY order_item_id ASC";
		$result	    = $database->query($sub_qry);
		if ($result->num_rows > 0){			
			while($data = $result->fetch_object()){
				if ($data->discount_code != '')
					return $data->discount_code;
			}				
		}
		return;  
	}	
		
	
	public function get_order_item($orders_id,$discount_type){
		$order   	= new order($orders_id);
		$database   = new database();
		$sub_qry	= "SELECT * FROM order_item WHERE orders_id = '$orders_id' ORDER BY order_item_id ASC";
		$result	    = $database->query($sub_qry);
		$msg = '
		<table class="list">
        <thead>
          <tr>
            <td class="left">Product Name</td>
            <td class="left">Product Code</td>';
			
		if ($discount_type == '2'){
			$colspan = '4'; 
			$msg .= '
			<td class="right">Discount Code</td>';
		}else{
			$colspan = '3'; 
		}
			
        $msg .= '
			<td class="right">Quantity</td>
            <td class="right">Price</td>
            <td class="right">Total</td>
          </tr>
        </thead>
        <tbody>';
		
		$sub_total			= 0;
		while($data = $result->fetch_object())
		{ 
		  $sub_total			+= $data->price * $data->quantity;
          $msg .= '
		  <tr>
            <td class="left">'.$data->product_name.'</td>
            <td class="left">'.$data->product_code.'</td>';
			
		  if ($discount_type == '2'){			
			$msg .= '
				<td class="right">'.$data->discount_code.'</td>';
		  }
			
		  $msg .= '
            <td class="right">'.$data->quantity.'</td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($data->price,'2','.',',').'</td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($data->quantity * $data->price,'2','.',',').'</td>
          </tr>';
		}  
        
		$msg .= '    
        </tbody>
        <tfoot>
          <tr>
            <td colspan="'.$colspan.'"></td>
            <td class="right"><b>Sub-Total: </b></td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($sub_total,'2','.',',').'</td>
          </tr>';
		if ($order->discount_amount > 0){  
          $msg .= '
		  <tr>
            <td colspan="'.$colspan.'"></td>
            <td class="right"><b>Discount Amount:</b></td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($order->discount_amount,'2','.',',').'</td>
          </tr>';
		}  
		$msg .= '  
		  <tr>
            <td colspan="'.$colspan.'"></td>
            <td class="right"><b>Shipping Charge:</b></td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($order->shipping_charge,'2','.',',').'</td>
          </tr>
          <tr>
            <td colspan="'.$colspan.'"></td>
            <td class="right"><b>Total:</b></td>
            <td class="right">'.CURRENCY_SYMBOL.number_format($order->order_total,'2','.',',').'</td>
          </tr>
        </tfoot>
      </table>';
	  return $msg;
	}
	
	public function format_date($date){
		$database   = new database();
		$sub_qry	= "SELECT DATE_FORMAT('".$date."', '%d-%m-%Y %H:%i %p') AS frmt_date ";
		$result	    = $database->query($sub_qry);
		if ($result->num_rows > 0){
			$data = $result->fetch_object();				
		}
		return $data->frmt_date;		
	}
	
	public function display_my_orders($member_id)

	{

		$database				= new database();

		$param_array			= array();

		$sql 					= "SELECT *, DATE_FORMAT(order_date, '%d-%m-%Y %H:%i') AS ord_date FROM orders WHERE member_id = '".$member_id."' ";
	
		$search_condition		= '';
		
		/*if($this->cid > 0)		

		{

			$param_array[] 			= "cid=" . $this->cid;

			$search_cond_array[]	= " p.category_id = '" . $this->cid . "' ";					   

		}*/
		
		if(count($search_cond_array)>0) 

		{ 

			//$search_condition	= " WHERE ".join(" AND ",$search_cond_array); 
			$search_condition	=  " AND " . join(" AND ",$search_cond_array); 

		}

				

		$sql			.= $search_condition;

		//$sql 			= $sql . " ORDER BY c.counsellor_name  ";
		
		
		$sortField	= " orders_id ";
		$sortOrder	= " DESC ";
		$sql	   .= " ORDER BY ".$sortField." ".$sortOrder;
		
		
		//echo $sql;

		$result			= $database->query($sql);

		$this->num_rows = $result->num_rows;

		//functions::paginate($this->num_rows);

		functions::paginate_listing($this->num_rows, 0, 0, 'CLIENT');

		$start			= functions::$startfrom;

		
		$limit			= functions::$limits;
				
		$sql 			= $sql . " limit $start, $limit";

		//echo  ($sql);

		$result			= $database->query($sql);
		

		$param=join("&amp;",$param_array); 

		$this->pager_param=$param;

		
		$blog_array		= array();

		if ($result->num_rows > 0)

		{				

			$i 			= 0;
			
			$rec_count  = '1';

			$row_num	= functions::$startfrom;

			$page		= functions::$startfrom > 0 ? (functions::$startfrom / FRONT_PAGE_LIMIT) + 1 : 1;
			
			
			echo '
			<table class="list">
			<thead>
			  <tr>
				<td class="left">No.</td>
				<td class="left">Date Added</td>
				<td class="left">Bill No.</td>
				<td class="left">Order price</td>				
				<td class="left">Payment Status</td>
				<td class="left">View</td>
			  </tr>
			</thead>
			<tbody>';						

			while($data=$result->fetch_object())

			{
				$row_num++;	
							
				echo '
				<tr>
					<td class="left">'.$row_num.'</td>
					<td class="left">'.$data->ord_date.'</td>
					<td class="left">'.$data->bill_no.'</td>
					<td class="left">'.CURRENCY_SYMBOL.number_format($data->order_total,'2','.',',').'</td>					
					<td class="left">'.ucwords(strtolower($data->payment_status)).'</td>
					<td class="left"><span onclick="javascript: show_order_details(\''.$data->orders_id.'\',\''.$rec_count.'\');" style="cursor:pointer">View</span></td>
				</tr>
				<tr>
					<td colspan="6"><span id="txtOrder'. $rec_count .'"></span></td>
				</tr>';
		  
				$rec_count++;					
											
			}
			
			echo '
				</tbody>
		   </table>';

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

					$urlQuery = 'order_history.php?page='.$currentPage;

				}

				else

				{

					$urlQuery = 'order_history.php?'.$this->pager_param1.'&page='.$currentPage;	

				}

				functions::redirect($urlQuery);

			}

			else

			{

				echo "<div align='center' class='warningMesg'>Sorry.. No orders found !!</div>";

			}

		}

	}
	
	public function getOrderProducts($orders_id){
		$database	= new database();
		$sub_qry	= "SELECT * FROM order_item WHERE orders_id = '$orders_id' ORDER BY order_item_id ASC";
		$sub_res	= $database->query($sub_qry);
		return $sub_res;
	}
	
	//PDF Export	
	public static function generate_invoice_details($orders_id = 0, $show_html = false)
	{
		include_once(DIR_LIBRARY . "mpdf/mpdf.php");
		
		$file_name		= 'Invoice.pdf';
		$template_name	= 'invoice.html';
		$pdf_template	= new pdf_template($template_name);
		
		$pdf_content	= str_replace("{template_uri}", URI_PDF_TEMPLATE, $pdf_template->content);
		$database		= new database();
		
		
		
		
		if($orders_id > 0)
		{	
			$order = new order($orders_id);
			
			$address_str  = $order->shipping_address1;
			if ($order->shipping_address2 != '') $address_str  .= ',<br/>'.$order->shipping_address2; 
			if ($order->shipping_address3 != '') $address_str  .= ',<br/>'.$order->shipping_address3;
			//$address_full = implode(',',$address_array);
			//die ('here'.$address_str);
			
			$pdf_content	= str_replace("{name}", functions::deformat_string($order->shipping_firstname).' '. functions::deformat_string($order->shipping_lastname), $pdf_content);			
			$pdf_content	= str_replace("{address}", functions::deformat_string($address_str), $pdf_content);
			//$pdf_content	= str_replace("{address2}", functions::deformat_string($order->shipping_address2), $pdf_content);
			//$pdf_content	= str_replace("{address3}", functions::deformat_string($order->shipping_address3), $pdf_content);
			$pdf_content	= str_replace("{state}", functions::deformat_string($order->shipping_state), $pdf_content);
			
			$pdf_content	= str_replace("{country}", functions::deformat_string($order->shipping_country), $pdf_content);
			$pdf_content	= str_replace("{postcode}", functions::deformat_string($order->shipping_postcode), $pdf_content);
			$pdf_content	= str_replace("{phone}", functions::deformat_string($order->shipping_phone), $pdf_content);
			$pdf_content	= str_replace("{email}", functions::deformat_string($order->shipping_email), $pdf_content);
			$pdf_content	= str_replace("{bill_no}", functions::deformat_string($order->bill_no), $pdf_content);
			
			
			/*$pdf_content	= str_replace("{invoice_no}", functions::deformat_string($ticket_booked->purchase_reference), $pdf_content);
			
			$pdf_content	= str_replace("{currency_name}", functions::deformat_string(CURRENCY_CODE), $pdf_content);
			
			$sub_total			= 0;
			$ticket_details 	= '';
			
			$ticket		= new ticket($ticket_booked->ticket_id);
			$sql   = "SELECT * FROM ticket_booked_items WHERE orders_id='". $orders_id."' ORDER BY order_id ASC";
			$result		= $database->query($sql);
			while($data = $result->fetch_object())
			{
				$member1		=  new member($data->member_id);
				$amount 		= $data->ticket_price - $data->discount_price;
				$sub_total 		+= $amount;
				
				$ticket_details	.= '<div class="quantity" style="height:55px;">'. functions::deformat_string($member1->first_name). ' '. functions::deformat_string($member1->surname) .'</div>
									<div class="description" style="height:55px;">'. functions::deformat_string($ticket->name).'</div>
									<div class="price" style="height:55px;">&pound;'. functions::deformat_string(number_format($data->ticket_price,2,'.','')). '</div>
									<div class="price" style="height:55px;">';
				if($data->discount_price > 0) 
				{
					$ticket_details	.= '- ';
				}
				
				$ticket_details	.= '&pound;'. functions::deformat_string(number_format($data->discount_price,2,'.','')).'</div>
									<div class="amount" style="height:55px;">&pound;'.functions::deformat_string(number_format($amount,2,'.','')).'</div>';
	
	
					
			   
		
			}
			
			$pdf_content	= str_replace("{ticket_details}", $ticket_details, $pdf_content);
					
			$pdf_content	= str_replace("{sub_total}", "&pound;".number_format($sub_total, 2, '.', ''), $pdf_content);
			$pdf_content	= str_replace("{vat}", "&pound;".number_format($ticket_booked->vat, 2, '.', ''), $pdf_content);
			$pdf_content	= str_replace("{vat_percentage}", VAT_PERCENTAGE. '%', $pdf_content);
			$pdf_content	= str_replace("{booking_fee}", "&pound;".number_format($ticket_booked->booking_fee, 2, '.', ''), $pdf_content);
			$pdf_content	= str_replace("{total_amount}", "&pound;".number_format($ticket_booked->sold_price, 2, '.', ''), $pdf_content);*/ 
		}
			
		if($show_html)
		{
			print $pdf_content;
		}
		else
		{
			//print $pdf_content; exit;
			//include_once(DIR_LIBRARY . "mpdf/mpdf.php");
			//$mpdf		= new mPDF('c','A4','','',5,5,6,1,0,0, 'P');
			//$mpdf		= new mPDF('c','A4');
			$mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);
			//$stylesheet = file_get_contents(DIR_PDF_TEMPLATE . $template_name . '/style.css');
			//$mpdf->WriteHTML($stylesheet,1); // The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->WriteHTML($pdf_content);	// Separate Paragraphs  defined by font
			//$mpdf->Output(); 
			//$mpdf->Output(DIR_PDF_TEMPLATE . $filename,'F');
			$mpdf->Output($file_name,'D');
			exit;
		}
	}
	
	public function getOrderProductName($order_item_id){
		$database   = new database();		
		$sub_qry	= " SELECT * FROM order_item WHERE order_item_id = '$order_item_id' ";
		$result	    = $database->query($sub_qry);
		if ($result->num_rows > 0){
			$data = $result->fetch_object();
			
			$product 	= new product($data->product_id);
			$product_cart_name  = $product->product_name;
			
			if ($data->color_variant_id > 0){
				$product_variant_color = new product_variant($data->color_variant_id);
				$product_cart_name    .= '<br/>Color: '.$product_variant_color->product_variant_value; 
			}
			if ($data->size_variant_id > 0){	 
				$product_variant_size  = new product_variant($data->size_variant_id);
				$product_cart_name    .= '<br/>Size: '.$product_variant_size->product_variant_value;
			}
						
		}		
		return $product_cart_name;								
	}
	
}
	
?>