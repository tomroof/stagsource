<?php

require '../src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '246704415502361',
  'secret' => '7e372f401c7eb9bd0fab4c899bc568cc',
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
	$logoutUrl = $facebook->getLogoutUrl();
} else {
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl();
}

?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <?php if ($user) { ?>
     
      Your user profile is
      <pre>
        <?php print htmlspecialchars(print_r($user_profile, true)) ?>
      </pre>
    <?php } else { ?>
      <fb:login-button ></fb:login-button>
    <?php } ?>
    <div id="fb-root"></div>
   <script>
      window.fbAsyncInit = function() {
		
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>',
          cookie: true,
          xfbml: true,
          oauth: true,
		  status:true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
		 
        });
		

		
		 
      };
	  
	     
  
 		 function logout()
  	   {
		   <?php echo $facebook->destroySession(); ?>
	 		FB.logout(function(response) {
       		 //console.log(response.status);
			window.location.reload();
    	});
	   }
  
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>

 
<a onClick="logout()">Log Out</a>



<div id="status">
</div>
    
    
  </body>
  
  
</html>
