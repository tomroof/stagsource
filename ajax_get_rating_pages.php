<?php

include("includes/config.php"); 

$item_per_page =5;
//sanitize post value
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$planning_id 	= $_REQUEST['planning_id'];

//validate page number is really numaric
if(!is_numeric($page_number)){die('Invalid page number!');}

//get current starting point of records
$position = ($page_number * $item_per_page);


$database 	= new database();
$sql 		= "SELECT planning_rating_id,comment FROM planning_rating WHERE planning_id=$planning_id ORDER BY planning_rating_id ASC LIMIT $position, $item_per_page";
//Limit our results within a specified range. 
$results 	= $database->query($sql);

//output results from database
echo '<ul class="page_result">';
while($row = mysqli_fetch_array($results))
{
	/*echo '<li id="item_'.$row["planning_rating_id"].'">'.$row["planning_rating_id"].'. <span class="page_name">'.$row["comment"].'</span><span class="page_message">'.$row["vendor_name"].'</span></li>';*/
	echo '<p><img src="images/quotes.jpg" width="18" height="16">'.nl2br(functions::deformat_string($row["comment"])).'</p>';
}
echo '</ul>';
?>

