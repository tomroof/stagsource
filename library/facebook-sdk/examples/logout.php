<?php
session_start();
require '../src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '246704415502361',
  'secret' => '7e372f401c7eb9bd0fab4c899bc568cc',
));
$token = $facebook->getAccessToken();
/*$url = 'https://www.facebook.com/logout.php?next=http://localhost/fb-test1/examples/example.php&access_token='.$token;
//session_destroy();
$facebook->destroySession();
header('Location: '.$url);*/

$url = 'example.php?logout=true';
$facebook->destroySession();

session_destroy();
header('Location: '.$url);

?>