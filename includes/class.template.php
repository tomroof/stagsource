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
						<li><a href="manage_news_letter.php"><img src="images/icon-big-news.png" alt="Manage News Letter" title="Manage News Letter" width="100" height="90" />News Letter</a></li>
						<li><a href="manage_subscribe.php"><img src="images/icon-big-subscribe.png" alt="Manage Subscription" title="Manage Subscription" width="100" height="90" />Subscription</a></li>
						<li><a href="manage_spam_report.php"><img src="images/icon-big-spam.png" alt="Manage Spam Reports" title="Manage Spam Reports" width="100" height="90" />Spam Reports</a></li>		
						<li><a href="manage_blocked_words.php"><img src="images/icon-big-blocked.png" alt="Manage Blocked Words" title="Manage Blocked Words" width="100" height="90" />Blocked Words</a></li>
						<li><a href="manage_planning.php"><img src="images/icon-big-property.png" alt="Manage Wedding Planning" title="Manage Wedding Planning" width="100" height="90" />Wedding Planning</a></li>		
						
						<!--<li><a href="manage_trip.php"><img src="images/icon-big-trip.png" alt="Manage Trips" title="Manage Trips" width="100" height="90" />Trips</a></li>	-->	
					</ul>';
		}
		
		// Generate the admin left menu
		private function left_menu()
		{
			 $page_name = functions::get_page_name();
			echo '
				<ul>
					';
					
					$content_module = array('manage_content.php', 'register_content.php', 'manage_page_content.php', 'register_page_content.php','manage_content_option.php', 'register_content_option.php' ,'manage_category.php', 'register_category.php', 'manage_content_comment.php', 'register_content_comment.php');
					if(in_array($page_name, $content_module))
					{
						echo '
						<li>
						<img src="images/icon-content.png" alt="Manage CMS" title="Manage CMS" width="24" height="24" />
						<a href="manage_content.php">CMS</a>
						<ul>
						<!--<li><a href="manage_page_content.php">Page Content</a></li>
						<li><a href="manage_category.php">Category</a></li>-->
						<li><a href="manage_content_comment.php">Comments</a></li>
						
						</ul>
						</li>';
					
					}
					else
					{
						echo '<li><img src="images/icon-content.png" alt="Manage CMS" title="Manage CMS" width="24" height="24" /><a href="manage_content.php" >CMS</a></li>';
					}
																		  
					echo '<li><img src="images/icon-member.png" alt="Manage Member" title="Manage Member" width="24" height="24" /><a href="manage_member.php" >Member</a></li>
					
					<li><img src="images/icon-news.png" alt="Manage News Letter" title="Manage News Letter" width="24" height="24" /><a href="manage_news_letter.php" >News Letter</a></li>
					<li><img src="images/icon-subscribe.png" alt="Manage Subscription" title="Manage Subscription" width="24" height="24" /><a href="manage_subscribe.php" >Subscription</a></li>
					<li><img src="images/icon-spam.png" alt="Manage Spam Reports" title="Manage Spam Reports" width="24" height="24" /><a href="manage_spam_report.php" >Spam Reports</a></li>
					<li><img src="images/icon-blocked.png" alt="Manage Blocked Words" title="Manage Blocked Words" width="24" height="24" /><a href="manage_blocked_words.php" >Blocked Words</a></li>
					<li><img src="images/icon-property.png" alt="Manage Wedding Planning" title="Manage Wedding Planning" width="24" height="24" /><a href="manage_planning.php" >Wedding Planning</a></li>
					<!--<li><img src="images/icon-trip.png" alt="Manage Trips" title="Manage Trips" width="24" height="24" /><a href="manage_trip.php" >Trips</a></li>-->';
						
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
			<link rel="shortcut icon" type="image/x-icon" href="'.URI_ROOT.'images/favicon.ico">
			<title>' . functions::deformat_string($title) . '</title>
			<meta name="description" content="' . $meta_description . '" />
			<meta name="keywords" content="' . $meta_keywords . '" />
			
			<link href="'.URI_ROOT.'css/style.css" rel="stylesheet" type="text/css"/>
			<link href="'.URI_ROOT.'css/responsive.css" rel="stylesheet" type="text/css"/>
			<link href="'.URI_ROOT.'css/fonts.css" rel="stylesheet" type="text/css"/>

			<script src="' . URI_LIBRARY . 'jquery/jquery-min.js" type="text/javascript"></script>
			<!--<script src="' . URI_LIBRARY . 'jquery/jquery-ui-min.js" type="text/javascript"></script>-->
			';
						
			echo $this->css . ' ' . $this->js;
			
			echo '</head>
			
					<body>
						<div class="outer-wrapper">';
			
							include_once DIR_ROOT.'inc_header.php';
				
		}
		
		public function client_footer()
		{			
				include_once DIR_ROOT.'inc_footer.php';
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