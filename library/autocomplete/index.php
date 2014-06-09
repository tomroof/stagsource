<!--
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
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
  <title> AutoComplete Jquery Plugin - Amit patil </title>
 </head>
 <link rel="stylesheet" type="text/css" href="styles/autoSuggest.css">
 <script src="js/jquery.js"></script>
 <script src="js/jquery.autoSuggest.js"></script>
 <script language="javascript">
  <?php
  $pluginConf = "";
  if(isset($_GET) && count($_GET) > 0){
	   extract($_GET);
  if($limit == "")	$limit = "10";
  if($width == "")	$width = "auto";
$pluginConf = '
$(function() {
  $("#inputBox").autoSuggest({
	ajaxFilePath	 : "server.php", 
	ajaxParams       : "dummydata=dummyData",
	autoFill	 : "'.$autofill.'",
	iwidth		 : "'.$width.'",
	opacity		 : "0.9",
	ilimit		 : "'.$limit.'",
	idHolder	 : "id-holder",
	match		 : "'.$match.'"
  });
});';	
   } else {
 $pluginConf = '
  $(function() {
	$("#inputBox").autoSuggest({
		ajaxFilePath	 : "server.php", 
		ajaxParams	 : "dummydata=dummyData", 
		autoFill	 : false, 
		iwidth		 : "auto",
		opacity		 : "0.9",
		ilimit		 : "10",
		idHolder	 : "id-holder",
		match		 : "contains"
	});
  }); ';
 } 

  echo $pluginConf; 
 ?>
 </script>
 <style>
	 body{
		background : black;
		font-family : verdana;
		font-size:12px;
	 }
	 body a{
		 color : #384949;
	 }
	 input{
	  border : 1px solid #c1c1c1;
	  height : 20px;
	 }
	 .header{
		padding : 0px;
		color : black;
		height : 100px;
		background : #FA9533;
		font-family : verdana;
		font-size: 12px;
		vertical-align : middle;
		text-align : left;
		padding-left : 20px;
		-moz-border-radius : 8px 8px 0px 0px;
	}
	.footer{
		padding : 0px;
		height : 100px;
		background : #FA9533;
		font-family : verdana;
		font-size: 12px;
		text-align : center;
		-moz-border-radius : 0px 0px 8px 8px;
	}
	.footer #links{
		padding : 20px;
		color : black;
	}
	.footer #links a{
		color : black;
		font-weight : bold;
		text-decoration : none;
	}
	.footer #links a:hover{
		text-decoration : underline;	
		color : white;
	}
	.body-contents{
		font-family : verdana;
		font-size:13px;
	}
	.page{
		width : 900px;
		background : white;
		text-align : left;
		margin : 10px 0px;
		-moz-border-radius : 8px;
	}   
	ul li{
		font-size: 12px;
		font-family : verdana;
	}
	h6{
		font-size: 12px;
		font-family : verdana;
	}
	.table {
		border-collapse:collapse;
	 }
	.table td{
		background : #F7F7F7;
		border : 1px solid #7E7E7E;
	}
	.table th{
		background : #B1B5AE;
		border : 1px solid #7E7E7E;
	}
	.pos{
	  margin:5px 20px;
	}
	.pos li{
		font-size:12px;
		margin : 5px;
	}
	.steps{
		margin : 0px; 
		padding : 0px;
	}
	.steps li{
		margin : 0px;
	}
	.htabs{
		color : white;
		list-style : none;
		margin : 0px;
		padding : 0px;
	}
	.htabs li{
		float: left;
		margin : 4px;
		background : #454A50;
		-moz-border-radius: 5px 5px 0px 0px;
	}
	.htabs li a{
		text-decoration : none;
		font-weight : bold;
		color : white;
		width : auto;
		display : block;
		height : 15px;
		padding : 4px;
	}
	.active{
		/*-moz-border-radius : 5px;*/
		border : 2px solid #636D76;
		border-bottom : 2px solid #E7E9EB;
		background : #E7E9EB;
		color : black !important;
		-moz-border-radius: 5px 5px 0px 0px;
		outline: none;
		-moz-outline-style: none;
	}
	.contents{
		margin-top:28px;
		background : #E7E9EB;
		margin-left:4px;
		margin-right:4px;
		border : 2px solid #636D76;
		color : black;
		padding : 10px;
		line-height : 1.7em;
	}
	.options{
		background : #2F3E3E;
		color : white;
		font-size: 12px;
		border : none;
	}
	.options th{
		background : #729494;
		padding : 4px;
	}
	.options td{
		padding : 4px;
		border-bottom : 1px dashed #729494;
		line-height : 2em;
		vertical-align : top;
	}
	.pcode th{
		background : #C3C3C3;
		font-weight : bold;
		font-size: 13px;
		padding : 5px;
	}
	.pcode td{
		background : #F5F5F5;
		margin : 3px;
	}
	.demo-container{
		background : #454A50;
		height : 25px;
		padding : 20px;
	}
 </style>
 <body>
   <center>
	  <div class="page">
	   <div class="header"><br>
			<a href="http://www.amitpatil.me/php-ajax-autosuggest-jquery-plugin/"><< Back to php-ajax-autosuggest-jquery-plugin page</a>
			<div style="float:right;margin-right : 25px;"><a href="http://www.amitpatil.me/first-greasemonkey-script/"> Next Post - first-greasemonkey-script >></a></div>
		  </ul>	
		  <br style="clear:left;">
		  <h1>Ajax AutoSuggest Jquery Plugin</h1>
	   </div>

			<ul class="htabs">
				<li><a href="#about" class="active">Autosuggest Jquery Plugin</a></li>
				<li><a href="#features">Features</a></li>
				<li><a href="#howto">How to use</a></li>
				<li><a href="#demo">Demo</a></li>
				<li><a href="#options">Documentation</a></li>
				<li><a href="#change_log">Change Log</a></li>
				<li><a href="#fdev">Future Development</a></li>
				<li><a href="#download">Download</a></li>
			</ul>
			<div class="tabs">
				<div class="tab" id="about">
					<div class="contents">
						&nbsp;&nbsp;&nbsp;&nbsp;This is another useful autocomplete plugin for jquery plugin lovers with <b>facebook theme</b> ;) 
						first version of this plugin was developed in 2009 and posted on <a href="http://www.planet-source-code.com/vb/scripts/ShowCode.asp?txtCodeId=2492&lngWId=8">planet-source-code.com</a>. which recorded 17888 downloads in one year and Best Code award too. good responce isnt it ? <br>
						&nbsp;&nbsp;&nbsp;&nbsp;First version was just plain autoComplete script with basic features, and looking at responce received, i thought to come up with its next version with bug fixes, features and configurable options so users can easily adopt it. so here i come up again with its jquery plugin version.<br>
						<br>Hope to get more responce.
						<br>
						<h4>How it works ?</h4>
						&nbsp;&nbsp;&nbsp;&nbsp; Provide input field and attach autosuggest plugin to it.
						as you start typing in it, plugin will start matching entered characters to the values in database and will return all the matching results in list. the way it matches the entries in database is dependant on plugin configuration options provided with this plugin. you can select item(value) you are looking for by using mouse/ UP-DOWN arrows/ TAB key/ ENTER key.
						<br>			
					</div>
				</div>
				<div class="tab" id="features">
					<div class="contents">
						<strong>Features</strong>
						<br>
						<ul>
							<li>Can be easily Configured.</li>
							<li>Facebook Theme.</li>
							<li>Faster.</li>
							<li>Themes can be changed easily with only few changes in CSS.</li>
							<li>Items can be selected with MOUSE/UP-DOWN arrows/TAB/ENTER key.</li>
							<li>Tested in Firefox 3.6, IE 8, Google Chrome 6.0.</li>
							<li>Available in 3 different sizes. 
							  <ul style="padding:0px;margin:10px 20px;">
								 <li><b>jquery.autoSuggest.js</b> - <b>9kb</b> </li>
								 <li><b>jquery.autoSuggest_minified.js</b> - <b>5kb</b> </li>
								 <li><b>jquery.autoSuggest_packed.js</b> - <b>3kb</b> </li>
							  </ul>	
						</ul>
					</div>
				</div>
				<div class="tab" id="howto">
					<div class="contents">
						<strong>How to use</strong><br>
						<h4>1) Include Javascript and CSS</h4>
						 &lt;link rel="stylesheet" type="text/css" href="styles/autoSuggest.css"&gt;<br>
						 &lt;script src="js/jquery.js">&lt;/script&gt;<br>
						 &lt;script src="js/jquery.autoSuggest_packed.js"&gt;&lt;/script&gt;<br>
						<h4>2) HTML</h4>
							&lt;input type="text" name="country" id="inputBox"&gt;<br>
							&lt;input type="hidden" name="id-holder" id="id-holder"&gt;  <br>
						<h4>3) Autosuggest Plugin Configuration</h4>
						<pre style="margin-left : -300px;">
							 &lt;script language="javascript"&gt; 
							  $(function() {
								$("#inputBox").autoSuggest({
									ajaxFilePath	 : "server.php",
									ajaxParams	 : "dummydata=dummyData", 
									autoFill	 : false,
									width		 : "auto",
									opacity		 : "0.9",
									limit		 : "10",
									idHolder	 : "id-holder",
									match		 : "contains"
								});
							  });	
							 &lt;/script&gt;
						 </pre>
					</div>
				</div>
				<div class="tab" id="demo"> 
					<div class="contents">
						<?php
							if(isset($_GET) && count($_GET)>0)
								echo "<span style='color:green;font-weight:bold;'>Using user settings</span>";	
							else
								echo "<span style='color:green;font-weight:bold;'>Using default settings</span>";	
						?>
						<br><br>
						Start typing here : 
							<input type="text" name="country" id="inputBox" size="40">   
							<input type="text" name="id-holder" id="id-holder" size="10" disabled>  
						<br><br>
						<hr>
						<h3>Try configuration options yourself</h3>
						<form name="autoSuggest" method="get" action="">
						 <table width="100%" border="0" style="background:#E5E5E5;" class="pcode">
						  <tr>
							<th>Plugin Options</th>
							<th>Generated Code</th>
						  </tr>
						  <tr>
							<td width="70%" valign="top">
							   <table width="100%" border="0" style="font-size:12px;">
								<tr>
									<td width="20%">autofill : </td>
									<td>
										<select name="autofill">
											<option value="true">True</option>
											<option value="false">False</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>width : </td>
									<td>
										<input type="text" name="width" value="<?php echo $width; ?>"> (auto OR eg : 100px)
									</td>
								</tr>
								<tr>
									<td>Limit : </td>
									<td>
										<input type="text" name="limit" value="<?php echo $limit; ?>"> (Any integer)
									</td>
								</tr>
								<tr>
									<td>match : </td>
									<td>
										<select name="match">
											<option value="starts">Starts</option>
											<option value="ends">Ends</option>
											<option value="contains">Contains</option>
										</select> (starts/ends/contains)
									</td>
								</tr>
								<tr>
									<td></td><td align="left"><input type="submit" name="submit" value="Configure Plugin"></td>
								</tr>
							   </table>	
							</td>
							<td width="30%">
							 <pre style="margin-left: 20px;">
								 <?php echo $pluginConf; ?>
							 </pre>
							</td>
						  </tr>
						 </table>	 
						</form>
					</div>
				</div>
				<div class="tab" id="options"> 
					<div class="contents">
						<table class="options" border="0" width="100%">
							<tr>
								<th width="20%">Option</th>
								<th>Description</th>
							</tr>
							<tr>
								<td><b>ajaxFilePath</b></td>
								<td>This option will hold file path which will return options to ajax call.Default value is <b>NULL</b>.</td>
							</tr>
							<tr>
								<td><b>ajaxParams</b></td>
								<td>If you want to send custom parameters to ajax file then you can pass all that parameters through this variable in single querystring. Default value is <b>NULL</b>.</td>
							</tr>
							<tr>
								<td><b>autoFill</b></td>
								<td>If you want to fill the value under mouse/keyboard in the textfield then set this variable to <b>true</b>. Default value is <b>false</b>.</td>
							</tr>
							<tr>
								<td><b>iwidth</b></td>
								<td>iWidth options holds desired width of suggestion list. Possible values could be <br>1) <b>auto</b> - Automatically adjusts with input fields width.<br>2) <b>Any integer (Ex : 100px)</b> - user defined <br>Default value is <b>auto</b>.</td>
							</tr>
							<tr>
								<td><b>opacity</b></td>
								<td>Opacity of the suggestion list. It can be anything from <b>0.0</b> to <b>1.0</b></td>
							</tr>
							<tr>
								<td><b>ilimit</b></td>
								<td>iLimit option holds number of results (items) you want to show in the suggestion list.</td>
							</tr>
							<tr>
								<td><b>idHolder</b></td>
								<td>If you want to save id of selected item and want to pass it to next page for further processing then 'idHolder' is the thing you are loking for. enter input field name in this option. and autoSuggest plugin will automatically store id of the selected item in supplied field.</td>
							</tr>
							<tr>
								<td><b>match</b></td>
								<td>This is additional option seen in only few plugins. now with this option you can tell autosuggest plugin which search criteria to use. <br>
								1) <b>starts</b> - Lists all the values that starts with entered text.<br>
								2) <b>ends</b> - Lists all the values that ends with entered text.<br>
								3) <b>contains</b> - Lists all the values that contains with entered text.<br>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="tab" id="Change_log"> 
					<div class="contents">
						<strong>Change Log</strong>
						<br>
						<h4>Jquery autosuggest version (Version 1.1)</h4>
						<ul>
							<li>Added keyboard support.</li>
							<li>Selection can be made with UP/DOWN arrow keys.</li>
							<li>TAB key support for option selectection.</li>
							<li>ENTER key support for option selectection.</li>
							<li>Prevented form submission on ENTER key.</li>
							<li>Extra parameters can be passed to <b>server.php</b></li>
						</ul>
						<h4>Jquery autosuggest version (Version 1.0)</h4>
						<ul>
							<li>Jquery autosuggest version 1.0 launched</li>
						</ul>

					</div>
				</div>
				<div class="tab" id="fdev">
					<div class="contents">
						<strong>Future Development</strong>
						<br>
						<ul>
							<li>Multiple instances not supported.</li>
							<li>Not tested with Safari, Opera, Firefox 3, IE6, IE7.</li>
						</ul>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This plugin does not support Multiple instances which is actually a major development remaining in this plugin, making it support multiple instances will take some time as i need to make many changes and it will take some time and there are 1000+ script ideas bouncing in my mind to come out and occupy pages on this blog. so this feature will be added upon visitors responce and requests. <br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Also i have not tested this script in Safari, Opera, Firefox 3, IE6, IE7. <span style="color:red;font-weight:bold;">i am requesting test results from visitors of this page in above browsers</span> so i can make changes in CSS and javascript to make it compatible for above browsers.
					</div>
				</div>
				<div class="tab" id="download">
					<div class="contents">
					  <strong>Download PHP ajax jquery autoSuggest plugin in Zip format</strong>
						<a href="http://www.amitpatil.me/wp-content/plugins/download-monitor/download.php?id=php-ajax-autosuggest-jquery-plugin">Download&nbsp;<img src="images/Download.gif" width="24px" height="24px;" alt="download PHP ajax jquery autoSuggest plugin" border="0"></a>
					</div>
				</div>
			</div>
			<br><br>
	  
	  <div class="footer">
		<div id="links">
		  <a href="http://www.amitpatil.me">Home</a>
		</div>   
	  </div>
    </center>
 </BODY>
</HTML>
<script language="JavaScript">
<!--
	jQuery(document).ready(function(){
		
		jQuery(".tab:not(:first)").hide();

		//to fix u know who
		jQuery(".tab:first").show();
		
		jQuery(".htabs a").click(function(){
			jQuery(".active").removeClass("active");
			jQuery(this).addClass("active");
			stringref = jQuery(this).attr("href").split('#')[1];

			jQuery('.tab:not(#'+stringref+')').hide();
			if (jQuery.browser.msie && jQuery.browser.version.substr(0,3) == "6.0") {
				jQuery('.tab#' + stringref).show();
			}
			else {
				jQuery('.tab#' + stringref).fadeIn();
			}
			return false;
		});
		jQuery(".options tr").mouseover(function(){
			$(this).css("background","#729494");
		});
		jQuery(".options tr").mouseout(function(){
			$(this).css("background","#2F3E3E");
		});
	});	
//-->
</script>