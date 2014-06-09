<?php
ob_start("ob_gzhandler");
session_start();
include_once("includes/config.php");

if(!empty($_SESSION[MEMBER_ID])){
	switch($_REQUEST['action']){
		case 'add':
			$database	= new database();
			
			$id = $database->real_escape_string($_REQUEST['planning_id']);
			$date = $database->real_escape_string(strtotime($_REQUEST['datetime']));
			$duration = $database->real_escape_string($_REQUEST['duration']);
			
			if((int)$_REQUEST['setdate'] > 0) $date = $duration = 0;
			
			$sql = 'INSERT INTO `itinerary` (planning_id,date,duration,member_id) VALUES('.$id.','.$date.',"'.$duration.'",'.$_SESSION[MEMBER_ID].')';
			
			$database->query($sql);
			
			echo '0<>Added to itinerary';
			break;
	
		case 'edit':
			break;
	}
} else
	echo '2<>Access forbidden';
?>