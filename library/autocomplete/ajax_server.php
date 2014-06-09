<?php
	/*
	* PHP Ajax AutoSuggest Jquery Plugin
	* http://www.amitpatil.me/
	*
	* @version
	* 1.0 (Dec 20 2010)
	* 
	* @copyright
	* Copyright (C) 2010-2011 
	*
	* @Auther
	* Amit Patil (amitpatil321@gmail.com)
	* Maharashtra (India) m
	*
	* @license
	* This file is part of PHP Ajax AutoSuggest Jquery Plugin.
	* 
	* PHP Ajax AutoSuggest Jquery Plugin is freeware script. you can redistribute it and/or modify
	* it under the terms of the GNU Lesser General Public License as published by
	* the Free Software Foundation, either version 3 of the License, or
	* (at your option) any later version.
	* 
	* PHP Ajax AutoSuggest Jquery Plugin is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	* GNU General Public License for more details.
	* 
	* You should have received a copy of the GNU General Public License
	* along with this script.  If not, see <http://www.gnu.org/copyleft/lesser.html>.
	*/
	include("config.php");
	$keyword = $_POST['data'];
	$limit	 = $_POST['limit'];

	$sql = "select name from ".$db_table." where ".$db_column." like '%".$keyword."%' limit $limit";
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result))
	{
		echo '<ul class="list">';
		while($row = mysql_fetch_array($result))
		{
			$str = strtolower($row['name']);
			$final = str_replace($keyword,'<span class="matched">'.$keyword.'</span>',$str);
		
			echo '<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
		}
		echo "</ul>";
	}
	else
		echo 0;
?>	   
