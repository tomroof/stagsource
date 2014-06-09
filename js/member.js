/********************************************************************************************
	Author 		: V V VIJESH
	Date		: 09-Nov-2010
	Purpose		: Handle member related functionalities
	Updated By	: 
	Date		: 
********************************************************************************************/
var xml_http_member;
var id;
function show_member(member_id, selected_id)
{
	if (member_id.length == 0)
	{ 
		return;
	}
	id				= selected_id;
	xml_http_member = getHTTPObject();
	if (xml_http_member==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	show		= document.getElementById("show").value;
	var mid		= document.getElementById("member_id").value;
	if(show == '0' && mid == member_id)
	{
		show	= 1;
		document.getElementById("show").value		= 1;
		document.getElementById("member_id").value	= member_id;
	}
	else
	{
		show	= 0;
		document.getElementById("show").value		= 0;
		document.getElementById("member_id").value	= member_id;
	}

	var url="show_member.php";

	url = url+"?member_id=" + member_id + "&show=" + show;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_member.onreadystatechange	= show_member_onready;
	xml_http_member.open("GET",url,true);
	xml_http_member.send(null);
} 
function open_member_details(member_id,divId, show_edit_comment, comment_id, serial_value)
{  
	var ajaxrequest;
	ajaxrequest = getHTTPObject();
	if (ajaxrequest==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
 	var show = document.getElementById("show").value;
	if(document.getElementById("show_member_id").value==0) {  document.getElementById("show_member_id").value=member_id;}
	var bid		= document.getElementById("show_member_id").value;
	//alert(bid+"   "+member_id);
	if(show=='0' && bid==member_id)
	{		
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_member_id").value	= member_id;
	}
	else if(show=='0' && bid!=member_id)
	{
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_member_id").value	= member_id;
	}
	else if(show=='1' && bid!=member_id)
	{
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_member_id").value	= member_id;
	}
	else
	{		  
		  show=0;
		  document.getElementById("show").value	= 0;
		  document.getElementById("show_member_id").value	= member_id;
	}
	
	ajaxrequest.onreadystatechange = function()
 	{
  		
		if(ajaxrequest.readyState == 4)
  		{
   			if(document.getElementById('num_rows'))
		    {
			   num_rows = document.getElementById('num_rows').value;
		    }
		    for (i = 1; i <= num_rows; i++)
		    {
			   document.getElementById('details_div_'+ i).innerHTML = '';
		    }
			
		    document.getElementById('details_div_'+serial_value).innerHTML = ajaxrequest.responseText;
  		} 		
		
 	}
	//alert(show);
	var url="show_member_details.php?member_id="+member_id+"&member_serial_value="+serial_value+ "&show=" + show;
 	ajaxrequest.open("post", url, true);
    ajaxrequest.send(null);
    return true;
	
}
	
function show_member_onready()
{ 
	var num_rows = 0;
	if (xml_http_member.readyState == 4 || xml_http_member.readyState == "complete")
	{
		if(document.getElementById('num_rows'))
		{
			num_rows = document.getElementById('num_rows').value;
		}
		for (i = 1; i <= num_rows; i++)
		{
			document.getElementById('details_' + i).innerHTML = '';
		}
		document.getElementById('details_' + id).innerHTML = xml_http_member.responseText;
	} 
}

function change_member_status(member_id, selected_id)
{
	if (member_id.length == 0)
	{ 
		return;
	}
	
	id				= selected_id;
	xml_http_member = getHTTPObject();
	if (xml_http_member==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="change_member_status.php";

	url = url+"?member_id=" + member_id;
	url = url+"&stid="+Math.random();
	xml_http_member.onreadystatechange	= change_member_status_onready;
	xml_http_member.open("GET",url,true);
	xml_http_member.send(null);
} 
	
function change_member_status_onready()
{ 
	if (xml_http_member.readyState == 4 || xml_http_member.readyState == "complete")
	{
		var status				= "";
		var member_status_text	= "";
		var status_image		= "";
		var response			= xml_http_member.responseText;
		if(response == 1)
		{
			status				= 'Active'
			status_image		= 'icon-active.png';
			member_status_text	= 'Active';
		}
		else
		{
			status				= 'Inactive'
			status_image		= 'icon-inactive.png';
			member_status_text	= 'Inactive';
		}
		
		document.getElementById('status_image_' + id).src = "images/" + status_image;
		document.getElementById('status_image_' + id).setAttribute("title", status);
		document.getElementById('status_image_' + id).setAttribute("alt", status);
		if(document.getElementById('member_status_text'))
		{
			document.getElementById('member_status_text').innerHTML = member_status_text;
		}
	} 
}

function module_page_permission(module_id, member_id, show)
{
	if (module_id.length == 0)
	{ 
		return;
	}
	id				= module_id;
	xml_http_member	= getHTTPObject();
	if (xml_http_member==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	var url="module_page_permission.php";
	url = url + "?module_id=" + module_id + "&member_id=" + member_id + "&show=" + show;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_member.onreadystatechange	= module_page_permission_onready;
	xml_http_member.open("GET",url,true);
	xml_http_member.send(null);
} 
	
function module_page_permission_onready()
{ 
	if (xml_http_member.readyState == 4 || xml_http_member.readyState == "complete")
	{		
		document.getElementById('module_pages_' + id).innerHTML = xml_http_member.responseText;
	} 
} 