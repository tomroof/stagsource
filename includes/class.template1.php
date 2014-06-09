 <?php
/*********************************************************************************************
	Author 	: V V VIJESH
	Date	: 25-June-2012
	Purpose	: Template class
*********************************************************************************************/
    class template
	{
		protected $_properties;
		public $error;
		public $message;
		public $warning;

        function __construct()
		{			
			$this->_properties					= array();
			$this->error						= '';
			$this->message						= '';
			$this->warning						= false;
			$this->_properties['type'] 			= '';
			$this->_properties['title'] 		= '';
			
			$this->_properties['name'] 		= '';
			
			$this->_properties['model_window'] 	= false;
			$this->_properties['meta_keywords'] = '';
			$this->_properties['meta_keywords'] = '';
			$this->_properties['js'] 			= '';
			$this->_properties['css'] 			= '';
			$this->_properties['left_menu']		= false;
			$this->_properties['admin_id']		= 0;
			$this->_properties['member_id']		= 0;
        }

		function __get($propertyName)
        {
			if (array_key_exists($propertyName, $this->_properties))
			{
				return $this->_properties[$propertyName];
			}

			return null;
        }

		public function __set($propertyName, $value)
		{
			return $this->_properties[$propertyName] = $value;
		}
		
		public function __destruct() 
		{
			unset($this->_properties);
			unset($this->error);
			unset($this->message);
		}
		
		public function heading()
		{
			switch($this->type)
			{
				case 'ADMIN':
					$this->title = 	$this->title == '' ? ADMIN_TITLE : $this->title;
					$this->admin_heading();
					break;
				case 'CLIENT':
					//$this->title = 	$this->title == '' ? FRONT_TITLE : $this->title;
					//$this->name = 	$this->name == '' ? FRONT_TITLE : $this->title;
					$this->client_heading();
					break;
			}
		}
		
		public function footer()
		{
			switch($this->type)
			{
				case 'ADMIN':
					$this->admin_footer();
					break;
				case 'CLIENT':
					$this->client_footer();
					break;
			}
		}
		
		public function admin_heading()
		{
			$admin = new admin($this->admin_id);
			//$theme = $admin->theme == '' ? 'default-inner.css' : functions::deformat_string($admin->theme) . '-inner.css';
			$theme = functions::deformat_string(ADMIN_THEME) . '/inner.css';
			echo '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="shortcut icon" type="image/x-icon" href="' . URI_ROOT . 'image/favicon.ico">
				<title>' . functions::deformat_string($this->title) . '</title>				
				<link href="css/common.css" rel="stylesheet" type="text/css" />
				<link id="theme" href="css/' . $theme . '" rel="stylesheet" type="text/css" />
				<script src="' . URI_LIBRARY . 'jquery/jquery-min.js" type="text/javascript"></script>
				<script type="text/javascript" language="javascript" src="' . ADMIN_JS_PATH . 'common.js"></script>
				<script type="text/javascript" language="javascript" src="' . ADMIN_JS_PATH . 'clock.js"></script>
				' . $this->css . '
				' . $this->js . '
				</head>
				<body>
				';
			
			functions::noscript_message();
			
			if(!$this->model_window)
			{
				echo '<div id="wrapper">';
				include_once 'top_banner.php';
				include_once 'top_navigation.php';
				echo ' <div class="clearFloat"></div>
					<div class="main">';
				if($this->left_menu)
				{
					echo '<div class="leftMenu txtBold txtMedium">';
					$this->list_menu('LIST');
					echo '</div>
						<div class="content">';
				}
				else
				{
					echo '<div class="dashboardContent">';	
				}
			}
			else
			{
				echo '<style type="text/css">
					body{ background-color:#fff !important; background-image:none !important;}
					</style>';
			}
		}
		
		public function admin_footer()
		{
			$clock	= '';
			if(!$this->model_window)
			{
				$clock	= '<script type="text/javascript" language="javascript">
				clock();
				</script>';
				echo '			<div class="clearFloat"></div>
							</div>
						<div class="clearFloat"></div> 
					  </div>
					<div class="clearFloat"></div>
					</div>
					<div class="clearFloat"></div>';
					include_once "footer_banner.php";
			}
				echo $clock;
				echo '</body></html>';
		}
		
		public static function list_menu($type)
		{
			switch ($type)
			{
				case 'THUMBNAILS':
					self::list_thumbnails();
					break;
				case 'LIST':
					self::left_menu();
					break;
				default:
					self::left_menu();
					break;
			}
		}
		
		private function list_thumbnails()
		{
			echo '
				<ul>
						<li><a href="manage_content.php"><img src="images/icon-big-content.png" alt="Manage CMS" title="Manage CMS" width="100" height="90" />CMS</a></li>
						<li><a href="manage_member.php"><img src="images/icon-big-member.jpg" alt="Manage Member" title="Manage Member" width="100" height="90" />Member</a></li>
						<!--<li><a href="manage_property_type.php"><img src="images/icon-big-property.png" alt="Manage Property Type" title="Property Type" width="100" height="90" />Property Type</a></li>-->
						<li><a href="manage_hotel.php"><img src="images/icon-big-property.png" alt="Manage Hotel" title="Manage Hotel" width="100" height="90" />Hotel</a></li>				
						<li><a href="manage_restaurant.php"><img src="images/icon-big-restaurant.png" alt="Manage Restaurant" title="Manage Restaurant" width="100" height="90" />Restaurant</a></li>
						<li><a href="manage_venue.php"><img src="images/icon-big-venue.png" alt="Manage Venue" title="Manage Venue" width="100" height="90" />Venue</a></li>
					</ul>';
		}
		
		// Generate the admin left menu
		private function left_menu()
		{
			 $page_name = functions::get_page_name();
			echo '
				<ul>
					';
					
					$content_module = array('manage_content.php', 'register_content.php', 'manage_page_content.php', 'register_page_content.php','manage_content_option.php', 'register_content_option.php'
					,'manage_category.php', 'register_category.php');
					if(in_array($page_name, $content_module))
					{
						echo '
						<li>
						<img src="images/icon-content.png" alt="Manage CMS" title="Manage CMS" width="24" height="24" />
						<a href="manage_content.php">CMS</a>
						<ul>
						<li><a href="manage_page_content.php">Page Content</a></li>
						<li><a href="manage_category.php">Category</a></li>
						
						</ul>
						</li>';
					
					}
					else
					{
						echo '<li><img src="images/icon-content.png" alt="Manage CMS" title="Manage CMS" width="24" height="24" /><a href="manage_content.php" >CMS</a></li>';
					}
																		  
					echo '<li><img src="images/icon-member.png" alt="Manage Member" title="Manage Member" width="24" height="24" /><a href="manage_member.php" >Member</a></li>
					<!--<li><img src="images/icon-property.png" alt="Manage Property Type" title="Manage Property Type" width="24" height="24" /><a href="manage_property_type.php" >Property Type</a></li>-->
					
					<li><img src="images/icon-property.png" alt="Manage Hotel" title="Manage Hotel" width="24" height="24" /><a href="manage_hotel.php" >Hotel</a></li>
					<li><img src="images/icon-restaurant.jpg" alt="Manage Restaurant" title="Manage Restaurant" width="24" height="24" /><a href="manage_restaurant.php" >Restaurant</a></li>
					<li><img src="images/icon-venue.png" alt="Manage Venue" title="Manage Venue" width="24" height="24" /><a href="manage_venue.php" >Venue</a></li>
					';
						
		echo '</ul>';
					
						
					
					
						
		}
		
		public function client_heading()
		{
			$page_name 	= functions::get_page_name();
			$title		= $this->title != '' ? $this->title .' ' : '';
			if (trim($title) == ''){
				$title	   .= FRONT_TITLE;
			}
				
			$meta_description = functions::format_text_field(META_DESCRIPTION) ;
			$meta_keywords    = functions::format_text_field(META_KEYWORDS);
			
			echo '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport">
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<html lang="en" class="no-js">
			<head>
			
			<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
			<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
			<title>' . functions::deformat_string($title) . '</title>
			<meta name="description" content="' . $meta_description . '" />
			<meta name="keywords" content="' . $meta_keywords . '" />
			
			<link href="css/style.css" rel="stylesheet" type="text/css"/>
			<link href="css/responsive.css" rel="stylesheet" type="text/css"/>
			<link href="css/fonts.css" rel="stylesheet" type="text/css"/>

			<script src="' . URI_LIBRARY . 'jquery/jquery-min.js" type="text/javascript"></script>
			<!--<script src="' . URI_LIBRARY . 'jquery/jquery-ui-min.js" type="text/javascript"></script>-->
			';
						
			echo $this->css . ' ' . $this->js;
			
			echo '</head>
			
					<body>
						<div class="outer-wrapper">';
			
							include_once 'inc_header.php';
				
		}
		
		public function client_footer()
		{			
				include_once 'inc_footer.php';
				echo '</div>
					</body>
				</html>';

		

		}
		
		public function header_branding()
		{
			echo '';
		}
		
		public function footer_branding()
		{
			//echo 'Design and Developed by <a href="http://www.rainend.com/" target="_blank">Rainend</a>';
		}
	}
?>