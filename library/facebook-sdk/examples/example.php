<?php

session_start();
require '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '246704415502361',
  'secret' => '7e372f401c7eb9bd0fab4c899bc568cc',
  'cookie' => true
));

/*$facebook = new Facebook(array(
  'appId'  => '337545633049074',
  'secret' => 'e6490fe605d0bfa9307381858bdef3af',
));*/


$logout		= (isset($_GET['logout'])) ? $_GET['logout']: false;


// Get User ID
$user = $facebook->getUser();

//echo $token = $facebook->getAccessToken();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if($logout)
{
	//session_destroy();
	echo "Logged Out";
	//exit;
}


if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
  
  $permissions = $facebook->api("/me/permissions");
  
  //print_r($permissions);
	if( array_key_exists('publish_stream', $permissions['data'][0]) ) {
    // Permission is granted!
    //$post_id = $facebook->api('/me/feed', 'post', array('message'=>'Hello World!'));
	//$post_id = $facebook->api('/me/feed');
	//print_r($post_id);
	echo "Permission is granted";
} else {
	
    // We don't have the permission
    // Alert the user or ask for the permission!
   //header( "Location: " . $facebook->getLoginUrl(array("scope" => "publish_stream")) );
 }
}



// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl(array( 'next' => ('http://localhost/fb-test1/examples/'.'logout.php') ));
} else {
	$params = array(
	
  'scope' => 'read_stream, friends_likes, email, user_about_me,  public_profile, friend_list, user_friends, publish_stream,  user_birthday', //publish_actions,
  //'scope' => 'public_profile, email',
  'redirect_uri' => 'http://localhost/fb-test1/examples/example.php'
);
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl($params);
}

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>php-sdk</h1>
     <script src="//connect.facebook.net/en_US/all.js"></script>
	<script>
	
	  
	  
	window.fbAsyncInit = function() {
		
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>',
          cookie: true,
          xfbml: true,
          oauth: true,
		  status:false
        });
       FB.Event.subscribe('auth.login', function(response) {
         // window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
		 
        });
		
		
		
		 
      };
	function logout()
	{
		
		FB.logout(function(response) {
       		 //console.log(response.status);
			 <?php //echo $facebook->destroySession(); ?>
			window.location.reload();
    	});
	}
	</script>
    <?php if ($user): ?>
     <!-- <a href="<?php echo $logoutUrl; ?>" >Logout</a>-->
      <a href="logout.php?logoutfrmfb=logout" style="cursor:pointer;" onClick="logout()">Logout</a>
      <fb:login-button autologoutlink="true"></fb:login-button>
    <?php else: ?>
      <div>
        Check the login status using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $statusUrl; ?>">Check the login status</a>
      </div>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

<!--    <h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php echo $naitik['name']; ?>-->
  </body>
</html>
