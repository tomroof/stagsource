<?php
class functions

{

	public $message;

	public $warning;

	

	public static $limits,$startfrom,$limits1,$startfrom1;

	

	function __construct()

	{

		$this->message		= '';

		$this->warning		= false;

	}

		

	//Return the page name from the url

	public static function get_page_name($url='')

	{

		$url		= trim($url);

		$url		= ($url == '') ? $_SERVER['PHP_SELF'] : $url;

		$first_char	= strrpos($url,"/") + 1;

		$url_length	= strlen($url);

		$page_name	= substr($url,$first_char,$url_length);

		return $page_name;

	}

	

	//Return the page name from the url

	public static function get_page_name_only($url='')

	{

		$page_name	= functions::get_page_name($url);

		$page_name	= substr($page_name, 0, strlen($page_name)-4);

		return $page_name;

	}

	

	// DISPLAYS COMMENT POST TIME AS "1 year, 1 week ago" or "5 minutes, 7 seconds ago", etc...

	public static function time_ago($date,$granularity=2, $require_ago = true)

	{

		$date = strtotime($date);

		$difference = time() - $date;

		$periods = array('decade' => 315360000,

			'year' => 31536000,

			'month' => 2628000,

			'week' => 604800, 

			'day' => 86400,

			'hour' => 3600,

			'minute' => 60,

			'second' => 1);

									 

		foreach ($periods as $key => $value) {

			if ($difference >= $value) {

				$time = floor($difference/$value);

				$difference %= $value;

				$retval .= ($retval ? ' ' : '').$time.' ';

				$retval .= (($time > 1) ? $key.'s' : $key);

				$granularity--;

			}

			if ($granularity == '0') { break; }

		}

		$ago_text	= $require_ago ? ' ago' : '';

		return $retval . $ago_text;      

	}

		

	public static function pre($filename_prefix = "No value passed!! ", $exit = false)

	{

		echo "<pre>";

		print_r($filename_prefix);

		echo "</pre>";

		

		if($exit)

		{

			exit;

		}

	}

	

	public static function get_random_value($length = 8, $seeds = 'alphanum')

	{

		// Possible seeds

		$seedings['alpha']		= 'abcdefghijklmnopqrstuvwqyz';

		$seedings['numeric']	= '0123456789';

		$seedings['alphanum']	= 'abcdefghijklmnopqrstuvwqyz0123456789';

		$seedings['hexidec']	= '0123456789abcdef';

		

		// Choose seed

		if (isset($seedings[$seeds]))

		{

			$seeds = $seedings[$seeds];

		}

		

		// Seed generator

		list($usec, $sec) = explode(' ', microtime());

		$seed = (float) $sec + ((float) $usec * 100000);

		mt_srand($seed);

		

		// Generate

		$str = '';

		$seeds_count = strlen($seeds);

		

		for ($i = 0; $length > $i; $i++)

		{

			$str .= $seeds{mt_rand(0, $seeds_count - 1)};

		}

		

		return $str;

	}

	

	

	function get_sub_words($string, $maxlength)

	{

		$count 	= ( (str_word_count($string) > $maxlength) ? $maxlength : str_word_count($string));

		$str_array = explode(" ",$string);

		$output_arr = array_slice($str_array, 0, $count); 

		$output = implode(" ", $output_arr);		

		return $output;

	}

	

	function get_sub_string($string, $maxlength, $dot = true)

	{

		$stripString = strip_tags($string);

		$subString = substr($stripString, 0, $maxlength); 

		$strLength = strlen($stripString);

		$result = stripslashes($subString);

		if ($strLength > $maxlength && $dot) {

			$result .=  "...";

		}

		return $result;

	}

	

	function get_format_date($datetime, $format = 'd-M-Y')

	{

		$date	= '';

		$time	= '';

		$month	= 0;

		$day	= 0;

		$year	= 0;

		$hh		= 0;

		$mm		= 0;

		$ss		= 0;

		

		if($datetime != '')

		{

			list($date, $time) 			= explode(' ', $datetime);

		}

		

		if($date != '')

		{

			list($year, $month, $day) 	= explode('-', $date);

		}

		

		if($time != '')

		{

			list($hh, $mm, $ss) 		= explode(':', $time);

		}

		

		$timestamp	= mktime($hh, $mm, $ss, $month, $day, $year);

		return date($format, $timestamp);

	}

	

	// Function display the Javascript noscript warning message

	function  noscript_message($redirect = true, $time = 1)

	{

		$page_name	= functions::get_page_name();

		if($page_name != 'error.php' )

		{

			echo '<noscript>

					<table bgcolor="#FF0000" width="100%">

						<tr>

							<td align="center">

								<b><font color="#FFFFFF">' . constant("ER_00002") . '</font></b>

							</td>

						</tr>

					</table>';

					if($redirect)

					{

						//echo '<meta http-equiv="refresh" content="' . $time . '; url=error.php?eid=ER_00002" >';

					}

			echo '</noscript>';

		}

	}

	

	// Function return user browser

	public static function useragent()

	{

      $useragent = $_SERVER['HTTP_USER_AGENT'];



      if(strchr($useragent,"MSIE 8.0")) return 'MSIE 8.0';



	  if(strchr($useragent,"MSIE 7.0")) return 'MSIE 7.0';



      if(strchr($useragent,"Firefox")) return 'Firefox';



	  if(strchr($useragent,"Mozilla")) return 'Mozilla';



      if(strchr($useragent,"MSIE 6.0")) return 'MSIE 6.0';



      if(strchr($useragent,"MSIE 5.5")) return 'MSIE 5.5';



      if(strchr($useragent,"MSIE 5.01")) return 'MSIE 5.01';



      if(strchr($useragent,"MSIE 4.01")) return 'MSIE 4.01';



      if(strchr($useragent,"MSIE 3.0")) return 'MSIE 3.0'; 



      if(strchr($useragent,"Opera")) return 'Opera';

 	}


    public static function cleanString($string, $separator = '-'){
		$accents = array('Š' => 'S', 'š' => 's', 'Ð' => 'Dj','Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss','à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f');
		$string = strtr($string, $accents);
		$string = strtolower($string);
		$string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
		$string = preg_replace('{ +}', ' ', $string);
		$string = trim($string);
		$string = str_replace(' ', $separator, $string);
	 
		return $string;
	}
	

	//Add slash to the given string, if the string contains quotes

	public static function clean_string($value)

	{

		$value = trim($value);

		if ( get_magic_quotes_gpc() )

		{

			$value = stripslashes( $value );

		}

		//return addslashes( $value );

		return $value;

	}



	// Remove the slashes from the given string

	public static function deformat_string($str)

	{

		return stripslashes($str);

	}

	

	public static function get_csv_string($str)

	{

		$str = stripslashes($str);

		

		return preg_replace("/\r\n|\r|\n/", ' ', $str);

	}

	

	public static function convert_encoding($str)

	{

		return iconv(mb_detect_encoding($str), "UTF-8", $str);

	}

	

	public static function convert_encoding2($str, $from = 'auto', $to = "UTF-8")

	{

		if($from == 'auto') $from = mb_detect_encoding($str);

		return mb_convert_encoding ($str , $to, $from); 

	}



	// Remove the slashes from the given string for text field

	public static function format_text_field($value) 

	{

		return stripslashes(htmlspecialchars($value));

	}

	

	// Redirect a page to the given url

	public static function redirect($link)

	{

		header("location: " . $link);

		exit;

	}

	

	public static function redirectParent($link)

	{

		echo "<script>parent.popupWindow.hide();</script>";

		header("location: " . $link);

		exit;

	}



	public function ret_rights($menuname, $con)

	{

		$get_rights = "";	

		$right_query	= "SELECT admin_rights.rights_flag FROM mainmenu INNER JOIN admin_rights ON (mainmenu.menu_id = admin_rights.menu_id)

			WHERE (admin_rights.admin_id = '" . $_SESSION["leparc_adminid"] . "') AND (mainmenu.menu_name = '" . $menuname . "')";

		$rights_result	= mysql_query($right_query, $con);	

		if (mysql_num_rows($rights_result) > 0)

		{

			$rights_row = mysql_fetch_array($rights_result);

			$get_rights	= $rights_row["rights_flag"];

		}	

		return $get_rights;

	}

	

	// Responses to Contact Us details are inserting in Database 

	public static function add_reponse_to_contactus($contact_us_id, $to_contents, $database)

	{

		$insert_response_query = "Insert into response_to_contactus(contactus_id, response_contents, res_datetime) VALUES ('".$contact_us_id."','".$to_contents."', NOW())";

		//$insert_response_query_res = mysql_query($insert_response_query, $database);

		$insert_response_query_res = $database->query($insert_response_query);

		

		

	}

	

	public static function get_action($id=0)

	{

		$page_permission	= page::get_page_permission();						// Get page permission

		$admin_permission	= page::get_admin_permission($_SESSION[ADMIN_ID]);	// Get admin permission

		$actions			= array('add', 'edit', 'view', 'delete');

		$action 			= '';

		$url 				= '';

		if(!is_numeric($id) && in_array($id, $actions))

		{

			if( ($page_permission[$id] != 'Y') || ( ($page_permission[$id] == 'Y') && ($admin_permission[$id] != 'Y') ) )

			{

				$error_code	= '';

				if($id == 'view')

				{

					$error_code	= 'cnst_ap2';

				}

				else if($id == 'add')

				{

					$error_code	= 'cnst_ap3';

				}

				else if($id == 'edit')

				{

					$error_code	= 'cnst_ap4';

				}

				else if($id == 'delete')

				{

					$error_code	= 'cnst_ap5';

				}

				$url 		= "permission.php?msg=" . $error_code;

				functions::redirect($url);

				exit;

			}

			else

			{

				$action = $id;	

			}

		}

		else

		{

			if($id == 0)

			{

				if( ($page_permission['add'] == 'Y') && ($id == 0 && $admin_permission['add'] != 'Y') )

				{

					$url = "permission.php?msg=cnst_ap3";

				}

				else

				{

					$action = 'add';	

				}

			}

			else

			{

				if( ($page_permission['edit'] == 'Y') && ($id > 0 && $admin_permission['edit'] != 'Y') )

				{

					$url = "permission.php?msg=cnst_ap4";

				}

				else

				{

					$action = 'edit';	

				}

				

				if(($page_permission['view'] == 'Y') && ($id > 0 && $admin_permission['view'] != 'Y') )

				{

					if($url == '' && $action == '')

					{

						$url = "permission.php?msg=cnst_ap2";

					}

				}

				else

				{

					if(($page_permission['view'] == 'N') && ($action == '') )

					{

						$url = "permission.php?msg=cnst_ap4";

					}

					else if($action == '')

					{

						$action = 'view';	

						$url	= '';

					}

				}

			}

			

			if($url != '')

			{

				functions::redirect($url);

				exit;

			}

			else

			{

				return $action;	

			}

		}

	}

	

	function WordsSplit($string, $maxLength)

	{

		$count 	= ( (str_word_count($string) > $maxLength) ? $maxLength : str_word_count($string));

		$strArray = explode(" ",$string);

		$outputArr = array_slice($strArray, 0, $count); 

		$output = implode(" ", $outputArr);

		

		return $output;

	}

	

	// ------function set a the session variabale ---------------

	function setSessionValue($variable, $value="") {

		if(isset($_SESSION[$variable])) {

			unset($_SESSION[$variable]);

		}

		

		if($value!="") {

				$_SESSION[$variable] = $value;

		}

	}

	

	// ------function return the value stored in the session variabale ---------------

	function getSessionValue($variable) {

		return $_SESSION[$variable];

	}



	public function alpha_link($re_param="", $cid="")

	{

		for ($z = 65; $z < 91; $z++)

		{

			$char_link	.= '<a href="' . $_SERVER['PHP_SELF'] . '?cl=' . chr($z) . $re_param . '" class="alpha_link">' . chr($z) . '</a> <span  class="orange_text">|</span> ';

		}

	

		$char_link	.= '<a href="' . $_SERVER['PHP_SELF'] . $cid . '" class="alpha_link">All';

	

		return $char_link;

	}

	

	public function check_file($filename)

	{

		$retval = "";

	

		$ext	= strtolower(strrchr($filename, "."));

	

		if ( ($ext != ".jpg") && ($ext != ".gif") && ($ext != ".png") && ($ext != ".bmp") )

		{

			$retval = "Please upload .JPG, .GIF, .PNG, .BMP file";

		}

	

	/*

	

		$filename = get_cfg_var("upload_tmp_dir") . "/" . $filename;

	

		if ( (exif_imagetype($filename) != 1) || (exif_imagetype($filename) != 2) || (exif_imagetype($filename) != 3) || (exif_imagetype($filename) != 6) )

		{

			$retval = "Please upload .JPG, .GIF, .PNG, .BMP file";

		}

	*/

	

		return $retval;

	}

	

	public function get_extension($filename)

	{

		switch (exif_imagetype($filename))

		{

			case 1:

			{

				$ext	= ".gif";

				break;

			}

			case 2:

			{

				$ext	= ".jpg";

				break;

			}

			case 3:

			{

				$ext	= ".png";

				break;

			}

			case 6:

			{

				$ext	= ".bmp";

				break;

			}

			default:

			{

				$ext = 0;

				break;

			}

		}

		return $ext;

	}

	

	/**** Function to get random number starts ****/

	function getRandomUniqueNum()

	{	

		//$randomNumber = rand(12345,199999)+rand(123,999);

		$timestamp = time();

		$randomNumber = $timestamp + rand(10,999);

		$selQuery	= "SELECT * FROM newsletter_subscribers WHERE subscriberUniqueCode = ".$randomNumber;

		$selRes		= mysql_query($selQuery);

		if($selRes && mysql_num_rows($selRes)>0)

		{

			getRandomUniqueNum();

		}

		else

		{

			return $randomNumber;

		}

	

	}/**** Function to get random number ends ****/



	

	// Below public function will convert Hex color to RGB e.g. #FF0000 to 255, 0, 0

	public function html2rgb($color)

	{

		if ($color[0] == '#')

			$color = substr($color, 1);

	

		if (strlen($color) == 6)

			list($r, $g, $b) = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);

		elseif (strlen($color) == 3)

			list($r, $g, $b) = array($color[0], $color[1], $color[2]);

		else

			return false;

	

		$r	= hexdec($r);

		$g	= hexdec($g);

		$b	= hexdec($b);

	

		return array($r, $g, $b);

	}

	

	// Below public function will convert RGB to Hex color e.g. 255, 0, 0 to #FF0000

	public function rgb2html2($color)

	{

		if (is_array($r) && sizeof($r) == 3)

			list($r, $g, $b) = $r;

	

		$r = intval($r);

		$g = intval($g);

		$b = intval($b);

	

		$r = dechex($r < 0 ? 0 : ($r > 255 ? 255 : $r));

		$g = dechex($g < 0 ? 0 : ($g > 255 ? 255 : $g));

		$b = dechex($b < 0 ? 0 : ($b > 255 ? 255 : $b));

	

		$color	= (strlen($r) < 2 ? '0' : '').$r;

		$color .= (strlen($g) < 2 ? '0' : '').$g;

		$color .= (strlen($b) < 2 ? '0' : '').$b;

	

		return '#' . $color;

	}

	

	// Below public function will show date MMM, dd yyyy

	public function date_formats($date)

	{

		$today	= "";

		$year	= 0;

		$mon	= 0;

		$day	= 0;

	

		if (strlen($date) > 0)

		{

			$get_date	= explode("-", $date);

			$year		= $get_date[0];

			$mon		= $get_date[1];

			$day		= $get_date[2];

	

			//$today = date("M, d Y", mktime(0, 0, 0, $mon, $day, $year));

			$today = $day."-". $mon."-". $year;

		}

		return $today;

	}

	

	public function paginate($allNum, $show = 0, $param = '', $user_type = 'ADMIN')

	{

		$database = new database();

		//echo "<br />Param1 is : ".$param;

		$page =  (isset($_REQUEST['page'])) ? ($_REQUEST['page']-1) : 0 ;

		if($user_type == 'ADMIN')

		{

			self::$limits = PAGE_LIMIT;
			
		}

		else

		{

			self::$limits = FRONT_PAGE_LIMIT;

		}

		

		$limit		= self::$limits;

		$s = $page * $limit;

		self::$startfrom = $s;

		

		$currentPage = $page+1;

		$adj  = 3;

		$p = new pagination();

		$p->Items($allNum);

		$p->limit($limit);

		//echo "<br />Param2 is : ".$param;

		if($param != "")

			$p->target($_SERVER['PHP_SELF']."?".$param);

		else

			$p->target($_SERVER['PHP_SELF']);

		$p->currentPage($page+1);

		$p->adjacents(3);

		if($show)

			$p->show();

	}


	public function paginateclient($allNum, $show = 0, $param = '', $user_type = 'CLIENT')

	{

		$database = new database();

		

		$page =  (isset($_GET['page'])) ? ($_GET['page']-1) : 0 ;

		

		if($user_type == 'ADMIN')

		{

			self::$limits = PAGE_LIMIT;

		}

		else

		{

			self::$limits = FRONT_PAGE_LIMIT;

		}

		$limit		= self::$limits;

		$s = $page * $limit;

		self::$startfrom = $s;

		$currentPage = $page+1;

		$adj  = 3;

		$p = new pagination();

		$p->Items($allNum);

		$p->limit($limit);

		

		if($param != "")

			$p->target($_SERVER['PHP_SELF']."?".$param);

		else

			$p->target($_SERVER['PHP_SELF']);

		$p->currentPage($page+1);

		$p->adjacents(3);

		if($show)

			$p->show();

	}

	

	
	public function paginateclient_property($allNum, $show = 0, $param = '', $user_type = 'CLIENT',$override_limit=9)
	{
		$database = new database();
		
		$page =  (isset($_GET['page'])) ? ($_GET['page']-1) : 0 ;
		
		if($override_limit!=0)
		{
			self::$limits1 = $override_limit;		
		}
		else
		{
			if($user_type == 'ADMIN')
			{
				self::$limits1 = PAGE_LIMIT;
			}
			else
			{
				self::$limits1 = FRONT_PAGE_LIMIT*3;
			}
		}
		
		$limit1		= self::$limits1;
		$s = $page * $limit1;
		self::$startfrom1 = $s;
		$currentPage = $page+1;
		$adj  = 3;
		$p = new pagination();
		$p->Items($allNum);
		$p->limit($limit1);
		
		if($param != "")
			$p->target($_SERVER['PHP_SELF']."?".$param);
		else
			$p->target($_SERVER['PHP_SELF']);
		$p->currentPage($page+1);
		$p->adjacents(3);
		if($show)
			$p->show(); 
	}

	

	public function paginate_member($allNum, $show = 0, $param = '', $user_type = 'CLIENT')

	{

		$database = new database();

		

		$page =  (isset($_GET['page'])) ? ($_GET['page']-1) : 0 ;

		

		if($user_type == 'ADMIN')

		{

			self::$limits = PAGE_LIMIT;

		}

		else

		{

			self::$limits = FRONT_PAGE_LIMIT;

			//self::$limits = 20;

		}

		$limit		= self::$limits;

		$s = $page * $limit;

		self::$startfrom = $s;

		$currentPage = $page+1;

		$adj  = 3;

		$p = new pagination();

		$p->Items($allNum);

		$p->limit($limit);

		

		

		if($param != "")

			$p->target($_SERVER['PHP_SELF']."?".$param);

		else

			$p->target($_SERVER['PHP_SELF']);

		$p->currentPage($page+1);

		$p->adjacents($adj);

		if($show)

			$p->show();

	}

		

	

	// Below public function will show date MMM, dd yyyy

	public function datetime_formats($date)

	{

		$today = "";

		if (strlen($date) > 0)

		{

			list($dateValue,$times) = explode(" ",$date);

			$get_date	= explode("-", $dateValue);

			$year		= $get_date[0];

			$mon		= $get_date[1];

			$day		= $get_date[2];

	

			$times		= strstr($date, " ");

			//$today = date("M, d Y", mktime(0, 0, 0, $mon, $day, $year)) . " - " . $times;

			$today = $day."-". $mon."-". $year ." ". $times ;

		}

		return $today;

	}

	

	// Below public function will use for create category tree for combo box

	public function traverse_tree_menu($pid, $parent_id, $menu_id = 0, $level = 0)

	{

		global $con, $category_option;

		$level++;

	

		$tree_query 	= "SELECT * FROM menu WHERE status = 'Y' AND parent_id = '" . $menu_id . "' ORDER BY menu_name";

		$tree_result	= mysql_query($tree_query, $con);

	

		if (mysql_num_rows($tree_result) > 0)

		{

			while($pop_row = mysql_fetch_array($tree_result))

			{

				$parent_text	= "";

				$child_text		= "";

	

				if ($pop_row["menu_id"] == $pid)

				{

					$category_option .= '<option value="' . $pop_row["menu_id"] . ' SELECTED>';

				}

				else

				{

					$category_option .= '<option value="' . $pop_row["menu_id"] . '"' . ($pop_row["menu_id"] == $parent_id ? 'SELECTED' : '') . '>';

				}

	

				for ($j = 0; $j < $level; $j++)

				{

					if ($j == 0)

					{

						$parent_text	.= '&nbsp;&nbsp;&nbsp;|---';

					}

	

					if ($j > 0)

					{

						$child_text		.= '----|-----';

					}

				}

	

				$category_option .= $parent_text . $child_text;

				$category_option .= $pop_row["menu_name"];

				$category_option .= "</option>";

	

				traverse_tree_menu($pid, $parent_id, $pop_row["menu_id"], $level);

			}

		}

	}

	

	// Below public function will use for create category tree for combo box

	public function traverse_left_menu($pid, $parent_id, $db, $menu_id = 0, $level = 0, $temp)

	{

		global $con, $menu_option, $temp;

		$level++;

	

		$tree_query 	= "SELECT * FROM menu WHERE status = 'Y' AND parent_id = '" . $menu_id . "' ORDER BY menu_name";

		$tree_result	= mysql_query($tree_query, $con);

	

		$main_count = $db->ret_count("menu", "parent_id = '" . $menu_id . "'", $con);

	

		if (mysql_num_rows($tree_result) > 0)

		{

			while($pop_row = mysql_fetch_array($tree_result))

			{

				$submenu = $db->ret_count("menu", "parent_id = '" . $pop_row["menu_id"] . "'", $con);

	

				$menu_option .= '<li>';

				$menu_option .= '<a href="#">' . stripslashes(trim($pop_row["menu_name"])) . '</a>';

	

				if ($submenu > 0)

				{

					$menu_option .= '<ul>';

					$temp = true;

				}

				elseif ($submenu == 0)

				{

					$menu_option .= '</li>';

				}

				elseif ($submenu == $main_count)

				{

					$menu_option .= '</ul></li>';

					$temp = false;

				}

	

				traverse_left_menu($pid, $parent_id, $db, $pop_row["menu_id"], $level, $temp);

			}

		}

	}

	

	public function resize()

	{

		$file	= "your.jpg";							// The file you are resizing

	

		// This will set our output to 45% of the original size.

		$size	= 0.45;

	

		// This sets it to a .jpg, but you can change this to png to gif

		header('content-type: image/jpeg');

	

		// Settings the resize parameters

		list($width, $height) = getimagesize($file);

	

		$minwidth	= $width * $size;

		$minheight	= $height * $size;

	

		// Creating the canvas

		$tn = imagecreatetruecolor($minwidth, $minheight);

		$source = imagecreatefromjpeg($file);

	

		// Resizing our image to fit the canvas

		imagecopyresized($tn, $source, 0, 0, 0, 0, $minwidth, $minheight, $width, $height);

	

		// Outputs a jpg image you could change this to gif or png if needed

		imagejpeg($tn);

	}

	

	//Below code is used for deleting all selected files

	/*$del_file	= $path . "*" . session_id() . "*";



	foreach(glob($del_file) as $filename)

	{

		@unlink($filename);

	}

	*/



	public function curPageURL()

	{

		$pageURL =	'http';

	

		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}



		$pageURL 	.=	"://";

		if ($_SERVER["SERVER_PORT"] != "80")

		{

			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

		}

		else

		{

			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

		}

		return $pageURL;

	}

	

	public function change_status($table_name,$fld_name,$curr_status,$table_key,$keyvalue)

	{

	    global $con;

		$new_status=($curr_status==1)?"0":"1";

		$status_change_sql="UPDATE ".$table_name." SET ".$fld_name."='".$new_status."' WHERE ".$table_key."='".$keyvalue."'";

		$status_change_result = $con->query($status_change_sql);

		if($status_change_result->affected_rows>0)

		{

		  return true;

		}

		

	}

	

	// Add Contact Address

	public function add_contact_address($contact_address)

	{

		global $con;

		$select_current_contact_address = "Select contact_address from contact_address";

		$select_current_contact_address_result	= $con->query($select_current_contact_address);

		if($select_current_contact_address_result->num_rows > 0){

			$status_change_sql="UPDATE contact_address SET  contact_address = '".$contact_address."'";

			$status_change_result = $con->query($status_change_sql);

			if($status_change_result>0)

			{

			  return true;

			}

		}

		else{

		

			$add_contact_address = "Insert into contact_address (contact_address) VALUES ('".$contact_address."')";

			$add_address_result = $con->query($add_contact_address);

			if($add_address_result>0)

			{

			  return true;

			}

		}	



	}

	

	//Select Current Contact Address

	function select_contact_address()

	{

		global $con;

		$select_current_contact_address = "Select contact_address from contact_address";

		$select_current_contact_address_result	= $con->query($select_current_contact_address);

		if($select_current_contact_address_result->num_rows > 0){

			$result_row = $select_current_contact_address_result->fetch_assoc();

			return $result_row;

		}

	}

	

	

	public function check_for_username ($value, $case, $message, $caption)

	{

		$value	= trim($value);

		switch($case){

			default:		// contain all validations under this field. Fixed message.

				if($value=="")	{

					$str = $caption." cannot be left blank!";

					return $str;

				}

				else if($value!="" && ((strlen($value)<5) || (strlen($value)>50))){

						$str = $caption." should be minimum 5 and maximum 50 characters.";

						return $str;

				}

				else if( ($value!="") && (!preg_match('/^[A-Za-z]+$/',  substr($value, 0, 1)))){

					$str = "Please enter a valid ".$caption.". First letter of the ".$caption." must be alphabet.";

					return $str;

				}	

				else if( ($value!="") && (!preg_match('/^[A-Za-z0-9]+$/',$value))){

					$str = "Please enter a valid ".$caption.".  Only alphabet or numeric value allowed in ".$caption;

					return $str;

				}	

		}	

	}



	//This u function for upload attachment file

	function upload_file($file_object, $upload_path, $allowed_extensions = 'mp3,mp4,wma', $max_upload_limit = 1024, $create_unique_name = true, $filename_prefix = '')

	{

		/*************************************************

		Desc: You can use this function for upload a file

		E.g.; $documentName = uploadFile($_FILES['userDocFile'], DIR_USER_DOC, 'doc,pdf', 750);

		Note: If the uploading is successfull then return the uploaded file name else return 1

		*************************************************/

		$result			= array();

		$result_code	= '';

		$message		= '';

		 

		$upload_path = str_replace("\\", "/", $upload_path);

		$upload_path = str_replace("//", "/", $upload_path);

		if($this->create_folder($upload_path))

		{

			$dir_name	= $upload_path;

		}

		else

		{			

			$this->message	= "Folder does not exist";

			$this->warning	= true;

			return false;

		}

		

		$file_name	=strtolower($file_object['name']);

		//$search = array(" ", "'", '"', '`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '', '+', '=', ';', ':', ',', '<', '>', '?', '/', '{',  '}', '[', ']');

		//$replace = "-";

		//$file_name = str_replace($search, $replace, $file_name);

		$file_name = $this->remove_special_chars($file_name);

		if($create_unique_name)

		{

			$timestamp		= time();

			$rnum 			= microtime();

			$rnum			= str_replace("0.", "", $rnum);

			$rnum			= str_replace(" ", "", $rnum);

			$unique_number	= $timestamp . $rnum . rand(0,99999);

			/*

			$unique_number	= rand(1,10);//uniqid("");

			*/

			$file_name		= $unique_number.$file_name;

			

		}

		

		$file_name  	= $filename_prefix . $file_name;

		$file_full_path	= $upload_path . $file_name;

		$path       	= array();

		$path			= pathinfo($file_name);

		$ext			= $path['extension'];

		$allwd			= explode(",", strtolower($allowed_extensions));

		

		if($allowed_extensions!='' && !in_array($ext,$allwd))

		{	

			$message_parameter = "";

			for($i=0; $i< count($allwd); $i++)

			{

				$message_parameter .= $allwd[$i];

				if($i< count($allwd)-1)

				{

					$message_parameter .= " OR ";

				}

			}

			$this->message	= "Please select $message_parameter file";

			$this->warning	= true;

			return false;

			

		}

		else if(($file_object['size'] / 1024) > $max_upload_limit)

		{

			$this->message	= "Maximum file size limit is " . $max_upload_limit . "Kb. Please select a smaller file";

			$this->warning	= true;

			return false;

		}

		else

		{

			move_uploaded_file($file_object['tmp_name'],$file_full_path);

		}

		

		$this->message	= "";

		$this->warning	= false;

		return $file_name;

	}

	

	

	//This u function for upload attachment file

	public function upload_image($file_object, $upload_path, $allowed_extensions = 'jpg,jpeg,gif,png', $max_upload_limit = 1024, $create_unique_name = true, $create_thumb = true, $filename_prefix = '', $size='', $option = '')

	{

		/*************************************************

		Desc: You can use this function for upload a file

		E.g.; $documentName = uploadFile($_FILES['userDocFile'], DIR_USER_DOC, 'doc,pdf', 750);

		Note: If the uploading is successfull then return the uploaded file name else return 1

		*************************************************/

		$result			= array();

		$result_code	= '';

		$message		= '';

		

		

		$min_image_w		= (count($size)==6 || count($size)==8) && $size[0]>0 && is_numeric($size[0]) ? $size[0] : MIN_IMAGE_WIDTH;

		$min_image_h		= (count($size)==6 || count($size)==8) && $size[1]>0 && is_numeric($size[1]) ? $size[1] : MIN_IMAGE_HEIGHT;

		

		$max_image_w		= (count($size)==6 || count($size)==8) && $size[2]>0 && is_numeric($size[2]) ? $size[2] : MAX_IMAGE_WIDTH;

		$max_image_h		= (count($size)==6 || count($size)==8) && $size[3]>0 && is_numeric($size[3]) ? $size[3] : MAX_IMAGE_HEIGHT;

		

		$imagethumbsize_w	= (count($size)==6 || count($size)==8) && $size[4]>0 && is_numeric($size[4]) ? $size[4] : MAX_THUMB_IMAGE_WIDTH;

		$imagethumbsize_h	= (count($size)==6 || count($size)==8) && $size[5]>0 && is_numeric($size[5]) ? $size[5] : MAX_THUMB_IMAGE_HEIGHT;

		

		$validate_min_size	= count($size)== 8 && is_numeric($size[6]) ? $size[6] : 1;

		$validate_max_size	= count($size)==8 && is_numeric($size[7]) ? $size[7] : 1;

		

		$upload_path 		= str_replace("\\", "/", $upload_path);

		$upload_path 		= str_replace("//", "/", $upload_path);

		if($this->create_folder($upload_path))

		{

			$dir_name	= $upload_path;

		}

		else

		{			

			$this->message	= "Folder does not exist";

			$this->warning	= true;

			return false;

		}

		

		$file_name	=strtolower($file_object['name']);

		$file_name = $this->remove_special_chars($file_name);

		if($create_unique_name)

		{

			$timestamp		= time();

			$rnum 			= microtime();

			$rnum			= str_replace("0.", "", $rnum);

			$rnum			= str_replace(" ", "", $rnum);

			$unique_number	= $timestamp . $rnum . rand(0,99999);

			$file_name		= $unique_number.$file_name;

		}

		

		$file_name  			= $filename_prefix . $file_name;

		$file_full_path			= $upload_path . $file_name;

		$thumb_image_full_path	= $upload_path . "thumb_" . $file_name;

		$path       	= array();

		$path			= pathinfo($file_name);

		$ext			= $path['extension'];

		$allwd			= explode(",", strtolower($allowed_extensions));

		

		if(!in_array($ext,$allwd))

		{	

			$message_parameter = "";

			for($i=0; $i< count($allwd); $i++)

			{

				$message_parameter .= $allwd[$i];

				if($i< count($allwd)-1)

				{

					$message_parameter .= " OR ";

				}

			}

			$this->message	= "Please select $message_parameter file";

			$this->warning	= true;

			return false;

			

		}

		else if(($file_object['size'] / 1024) > $max_upload_limit)

		{

			$this->message	= "Maximum file size limit is " . $max_upload_limit . "Kb. Please select a smaller file";

			$this->warning	= true;

			return false;

		}

		else

		{

			move_uploaded_file($file_object['tmp_name'], $file_full_path);

			$size	= @getimagesize($file_full_path);

			$size_w	= $size[0];

			$size_h	= $size[1];

			if( ($size_w<=($min_image_w-1) || $size_h<=($min_image_h-1)) && $validate_min_size == 1 )

			{

				@unlink($file_full_path);

				$this->message	= "1Please upload the correct size image. Image size atleast $min_image_w X $min_image_h pixels.";

				$this->warning	= true;

				return false;

			}

			else if( ($size_w > $max_image_w || $size_h > $max_image_h) && $validate_max_size==1 )

			{

				@unlink($file_full_path);

				$this->message	= "2Please upload the correct size image. Maximum Image size is $max_image_w X $max_image_h pixels.";

				$this->warning	= true;

				return false;

			}

			else

			{

				if($size_w > $max_image_w || $size_h > $max_image_h)

				{

					

					$resizeObj = new resize_image($file_full_path);



					if(!empty($option))

					{

						// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)

						$resizeObj->resizeImage($max_image_w, $max_image_h, $option);

					}

					else

					{

						$resizeObj->resizeImage($max_image_w, $max_image_h);

					}

				

					// *** 3) Save image

					$resizeObj->saveImage($file_full_path, 100);

	

					/*

					$image = new simple_image();

					$image->load($file_full_path);

					#$image->resizeToHeight(400);

					$image->resize($max_image_w, $max_image_h);

					$image->save($file_full_path);

					*/

					

					/*resize_image($size_w,$size_h,$file_full_path,$thumb_image_full_path,$replace=1,$size_w,$size_h);

					resize_then_crop($filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,"255","255","255");*/

				}

				

				if($create_thumb)

				{

					/*

					$image = new simple_image();

					$image->load($file_full_path);

					$image->resizeToHeight(400);

					$image->resize($imagethumbsize_w, $imagethumbsize_h);

					$image->save($thumb_image_full_path);

					*/

					$resizeObj = new resize_image($file_full_path);



					if(!empty($option))

					{

						// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)

						$resizeObj->resizeImage($imagethumbsize_w, $imagethumbsize_h, $option);

					}

					else

					{

						$resizeObj->resizeImage($imagethumbsize_w, $imagethumbsize_h);

					}

				

					// *** 3) Save image

					$resizeObj->saveImage($thumb_image_full_path, 100);

				}

			}

			

			$this->message	= "";

			$this->warning	= false;

			return $file_name;

		}

	}

	

	function delete_file_from_ftp($file_name)

	{

		$ftp = new ftp(FTP_USERNAME, FTP_PASSWORD, FTP_ADDRESS, FTP_DIRECTORY);

		$result = $ftp->delete_file($file_name);

		if($result == false) 

		{

			$this->message	= "Error occured during the remove!";

			$this->warning	= false;

			return false;

		}

		else if($result == NULL)

		{

			$this->message	= "File not exists!";

			$this->warning	= false;

			return false;

		}

		else {

			//echo "File Sucessfull uploaded! :)<br />\n";

			$this->message	= "";

			$this->warning	= false;

			return $file_name;

		}

	}

	

	function upload_file_to_ftp($file_object, $max_upload_limit = 1024, $create_unique_name = true, $filename_prefix = '')

	{

		/*************************************************

		Desc: You can use this function for upload a file

		E.g.; $documentName = uploadFile($_FILES['userDocFile'], DIR_USER_DOC, 'doc,pdf', 750);

		Note: If the uploading is successfull then return the uploaded file name else return 1

		*************************************************/

		$result			= array();

		$result_code	= '';

		$message		= '';

		

		$file_name	=strtolower($file_object['name']);

		$file_name = $this->remove_special_chars($file_name);

		if($create_unique_name)

		{

			$timestamp		= time();

			$rnum 			= microtime();

			$rnum			= str_replace("0.", "", $rnum);

			$rnum			= str_replace(" ", "", $rnum);

			$unique_number	= $timestamp . $rnum . rand(0,99999);

			$file_name		= $unique_number.$file_name;

		}

		

		$file_name  	= $filename_prefix . $file_name;

		$file_full_path	= $upload_path . $file_name;

		$path       	= array();

		$path			= pathinfo($file_name);

		$ext			= $path['extension'];

		/*

		$allwd			= explode(",", strtolower($allowed_extensions));

		

		if(!in_array($ext,$allwd))

		{	

			$message_parameter = "";

			for($i=0; $i< count($allwd); $i++)

			{

				$message_parameter .= $allwd[$i];

				if($i< count($allwd)-1)

				{

					$message_parameter .= " OR ";

				}

			}

			$this->message	= "Please select $message_parameter file";

			$this->warning	= true;

			return false;

			

		}

		

		else */

		if(($file_object['size'] / 1024) > $max_upload_limit)

		{

			$this->message	= "Maximum file size limit is " . $max_upload_limit . "Kb. Please select a smaller file";

			$this->warning	= true;

			return false;

		}

		else

		{

			$ftp = new ftp(FTP_USERNAME, FTP_PASSWORD, FTP_ADDRESS, FTP_DIRECTORY);

			$result = $ftp->upload_process($file_object['tmp_name'], $file_name);

			if($result == false) 

			{

				$this->message	= "Error occured during the upload!";

				$this->warning	= false;

				return false;

			}

			else if($result == NULL)

			{

				$this->message	= "File not exists!";

				$this->warning	= false;

				return false;

			}

			else {

				//echo "File Sucessfull uploaded! :)<br />\n";

				$this->message	= "";

				$this->warning	= false;

				return $file_name;

			}

		}

	}

	

	function create_folder($folder_path) 

	{

		/*************************************************

		Desc: The function create or check the folder path exist or not. If path found return true otherwise false

		E.g.; $path = create_folder('C:/project/uploaded/product_image/');

		*************************************************/

		$folder_path	= $this->remove_special_chars($folder_path, '-', array(" ", ':', '/'));

		$folder_path	= str_replace("\\", "/", $folder_path);

		$folder_path	= str_replace("//", "/", $folder_path);

		$result 		= false;

		$flag			= 0;

		if(!file_exists ($folder_path))

		{

			$folder = explode("/",$folder_path);

			$path	= '';

			for($i=0; $i<count($folder); $i++)

			{

				if(substr_count($_SERVER['PATH'], "WINDOWS"))

				{

					//print "OS : Windows";

					$path .= $folder[$i]."/";

				}

				else if(substr_count($_SERVER['PATH'], "bin"))

				{

					//print "OS : Unix/Linux";

					//$path = $path == "" ? "" : "/".$path.$folder[$i];

					$fname = trim($folder[$i])."/";

					if($fname =="/")

					{

						if($flag==0)

						{

							$flag = 1;

						}

						else

						{

							continue;

						}

					}

					$path .= $fname;

					if($i <= 3)

					{

						continue;

					}

				}

				

				if(!file_exists($path))

				{

					//Creating folder

					if(!mkdir($path))

					{

						return $result;	

					}

					else

					{

						chmod($path, 0777);

					}

				}

			}

			

			if(file_exists ($folder_path))

			{

				$result = true;

			}

		}

		else

		{

			if($this->getmod($path) != 0777)

			{

				@chmod($path, 0777);

			}

			$result = true;

		}

		

		return $result;	

	}

	

	function remove_special_chars($string_value, $replace = '-', $except = array()) 

	{

		$default = array(" ", "'", '"', '`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '', '+', '=', ';', ':', ',', '<', '>', '?', '/', '{',  '}', '[', ']');

		if(count($except) > 0)

		{

			$search	= array_diff($default, $except);		

		}

		else

		{

			$search	= $default;

		}

		$string_value	= str_replace($search, $replace, $string_value);

		return $string_value;

	}



	// Get file mode

	// Get file permissions supported by chmod 

	function getmod($filename)

	{

		$val = 0;

		if(file_exists ($filename))

		{

			$perms = fileperms($filename);

			// Owner; User

			$val += (($perms & 0x0100) ? 0x0100 : 0x0000); //Read

			$val += (($perms & 0x0080) ? 0x0080 : 0x0000); //Write

			$val += (($perms & 0x0040) ? 0x0040 : 0x0000); //Execute

			

			// Group

			$val += (($perms & 0x0020) ? 0x0020 : 0x0000); //Read

			$val += (($perms & 0x0010) ? 0x0010 : 0x0000); //Write

			$val += (($perms & 0x0008) ? 0x0008 : 0x0000); //Execute

			

			// Global; World

			$val += (($perms & 0x0004) ? 0x0004 : 0x0000); //Read

			$val += (($perms & 0x0002) ? 0x0002 : 0x0000); //Write

			$val += (($perms & 0x0001) ? 0x0001 : 0x0000); //Execute

			

			// Misc

			$val += (($perms & 0x40000) ? 0x40000 : 0x0000); //temporary file (01000000)

			$val += (($perms & 0x80000) ? 0x80000 : 0x0000); //compressed file (02000000)

			$val += (($perms & 0x100000) ? 0x100000 : 0x0000); //sparse file (04000000)

			$val += (($perms & 0x0800) ? 0x0800 : 0x0000); //Hidden file (setuid bit) (04000)

			$val += (($perms & 0x0400) ? 0x0400 : 0x0000); //System file (setgid bit) (02000)

			$val += (($perms & 0x0200) ? 0x0200 : 0x0000); //Archive bit (sticky bit) (01000)

		}

		return $val;

	} 

	

	public function image_resize($fullpath,$dest,$filename)

	{

		$imagethumbsize_w	= (count($size)==6 || count($size)==8) && $size[4]>0 && is_numeric($size[4]) ? $size[4] : MAX_THUMB_IMAGE_WIDTH;

		$imagethumbsize_h	= (count($size)==6 || count($size)==8) && $size[5]>0 && is_numeric($size[5]) ? $size[5] : MAX_THUMB_IMAGE_HEIGHT;

		$thumb_image_full_path = $dest."/thumb_".$filename;

		$image = new SimpleImage();

		$image->load($fullpath);

		#$image->resizeToHeight(400);

		$image->resize($imagethumbsize_w,$imagethumbsize_h);

		$image->save($thumb_image_full_path);

		$create_thumb=true;	

		return $create_thumb;

	}



	public function generate_thumb_image($image_name, $path, $imagethumbsize_w, $imagethumbsize_h)

	{

		$filein		= $path . $image_name;

		$fileout	= $path . 'thumb_' . $image_name;

		$this->resize_then_crop($filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,"255","255","255");	

	}

	

	public function resize_then_crop( $filein,$fileout,$imagethumbsize_w,$imagethumbsize_h,$red,$green,$blue)

	{

		// Get new dimensions

		list($width, $height) = getimagesize($filein);

		$new_width = $width * $percent;

		$new_height = $height * $percent;

		

		if(preg_match("/.jpg/i", "$filein"))

		{

		   $format = 'images/jpeg';

		}

		if(preg_match("/.jpeg/i", "$filein"))

		{

		   $format = 'images/jpeg';

		}

		if (preg_match("/.gif/i", "$filein"))

		{

		   $format = 'images/gif';

		}

		if(preg_match("/.png/i", "$filein"))

		{

		   $format = 'images/png';

		}

		   

		switch($format)

		{

			case 'images/jpeg':

				$image = imagecreatefromjpeg($filein);

				break;

			case 'images/gif';

				$image = imagecreatefromgif($filein);

				break;

			case 'images/png':

				$image = imagecreatefrompng($filein);

				break;

		}

		

		$width = $imagethumbsize_w ;

		$height = $imagethumbsize_h ;

		list($width_orig, $height_orig) = getimagesize($filein);

		

		if ($width_orig < $height_orig)

		{

			$height = ($imagethumbsize_w / $width_orig) * $height_orig;

		}

		else

		{

			$width = ($imagethumbsize_h / $height_orig) * $width_orig;

		}

		//if the width is smaller than supplied thumbnail size 

		if ($width < $imagethumbsize_w)

		{

			$width = $imagethumbsize_w;

			$height = ($imagethumbsize_w/ $width_orig) * $height_orig;;

		}

		//if the height is smaller than supplied thumbnail size 

		if ($height < $imagethumbsize_h)

		{

	

			$height = $imagethumbsize_h;

			$width = ($imagethumbsize_h / $height_orig) * $width_orig;

		}

		

		$thumb 		= imagecreatetruecolor($width , $height);  

		$bgcolor 	= imagecolorallocate($thumb, $red, $green, $blue);   

		ImageFilledRectangle($thumb, 0, 0, $width, $height, $bgcolor);

		imagealphablending($thumb, true);

		

		imagecopyresampled($thumb, $image, 0, 0, 0, 0,

		$width, $height, $width_orig, $height_orig);

		$thumb2 	= imagecreatetruecolor($imagethumbsize_w , $imagethumbsize_h);

		// true color for best quality

		$bgcolor 	= imagecolorallocate($thumb2, $red, $green, $blue);   

		ImageFilledRectangle($thumb2, 200, 200,

		$imagethumbsize_w , $imagethumbsize_h , $white);

		imagealphablending($thumb2, true);

		

		$w1 =($width/2) - ($imagethumbsize_w/2);

		$h1 = ($height/2) - ($imagethumbsize_h/2);

		

		imagecopyresampled($thumb2, $thumb, 0,0, $w1, $h1,

		$imagethumbsize_w , $imagethumbsize_h ,$imagethumbsize_w, $imagethumbsize_h);

		

		if ($fileout !="")imagegif($thumb2, $fileout); //write to file

	}

	public static function  date_format_change($string)
	  {
		return  implode('-', array_reverse(explode('-', $string)));
	  }

	public static function array_to_csvstring($items, $CSV_SEPARATOR = ',', $CSV_ENCLOSURE = '"', $CSV_LINEBREAK = "\n") {

	      $string = '';

	     $o = array();

	

	    foreach ($items as $item) {

		  if (stripos($item, $CSV_ENCLOSURE) !== false) {

		    $item = str_replace($CSV_ENCLOSURE, $CSV_ENCLOSURE . $CSV_ENCLOSURE, $item);

		  }

	

		  if ((stripos($item, $CSV_SEPARATOR) !== false)

		    || (stripos($item, $CSV_ENCLOSURE) !== false)

		   || (stripos($item, $CSV_LINEBREAK !== false))) {

		    $item = $CSV_ENCLOSURE . $item . $CSV_ENCLOSURE;

		  }

	

		  $o[] = $item;

	    }

	

	     $string = implode($CSV_SEPARATOR, $o) . $CSV_LINEBREAK;

	

	     return $string;

	  }
	  
	public function paginateclient_article($allNum, $show = 0, $param = '', $user_type = 'CLIENT',$override_limit=9)
	{
		$database = new database();
		
		$page_1 =explode('?page=',$_SERVER['REQUEST_URI']);
		
		if(count($page_1) > 1)
		{
			$page	= $page_1[1]-1;
		}
		else
		{
			$page	= 0;
		}
		
		//$page =  (isset($_GET['page'])) ? ($_GET['page']-1) : 0 ;
		
		if($override_limit!=0)
		{
			self::$limits1 = $override_limit;		
		}
		else
		{
			if($user_type == 'ADMIN')
			{
				self::$limits1 = PAGE_LIMIT;
			}
			else
			{
				self::$limits1 = FRONT_PAGE_LIMIT*4;
			}
		}
		
		$limit1		= self::$limits1;
		$s = $page * $limit1;
		self::$startfrom1 = $s;
		$currentPage = $page+1;
		$adj  = 3;
		$p = new pagination();
		$p->Items($allNum);
		$p->limit($limit1);
		
		if(strstr($_SERVER['PHP_SELF'], 'index.php'))
		{
			$p->target(URI_ROOT);
			/*if($param != "")
				$p->target($_SERVER['PHP_SELF']."?".$param);
			else
				$p->target($_SERVER['PHP_SELF']);*/
		}
		else if(strstr($_SERVER['PHP_SELF'], 'category.php'))
		{
			$p->target(URI_ROOT.'category/'.$_GET['id']);
		}
				
		$p->currentPage($page+1);
		$p->adjacents(3);
		if($show)
			$p->show_article(); 
	}

	

}

?>