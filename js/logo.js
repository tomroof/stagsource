
var xml_http_logo;
var id;
function show_logo(logo_id, selected_id)
{
	if (logo_id.length == 0)
	{ 
		return;
	}
	id				= selected_id;
	xml_http_logo = getHTTPObject();
	if (xml_http_logo==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	show		= document.getElementById("show").value;
	var mid		= document.getElementById("logo_id").value;
	if(show == '0' && mid == logo_id)
	{
		show	= 1;
		document.getElementById("show").value		= 1;
		document.getElementById("logo_id").value	= logo_id;
	}
	else
	{
		show	= 0;
		document.getElementById("show").value		= 0;
		document.getElementById("logo_id").value	= logo_id;
	}

	var url="show_logo.php";

	url = url+"?logo_id=" + logo_id + "&show=" + show;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_logo.onreadystatechange	= show_logo_onready;
	xml_http_logo.open("GET",url,true);
	xml_http_logo.send(null);
} 
	
function show_logo_onready()
{ 
	var num_rows = 0;
	if (xml_http_logo.readyState == 4 || xml_http_logo.readyState == "complete")
	{
		if(document.getElementById('num_rows'))
		{
			num_rows = document.getElementById('num_rows').value;
		}
		for (i = 1; i <= num_rows; i++)
		{
			
			document.getElementById('details_' + i).innerHTML = '';
		}
		document.getElementById('details_' + id).innerHTML = xml_http_logo.responseText;
	} 
}

function change_logo_status(logo_id, selected_id)
{
	//alert(logo_id);
	if (logo_id.length == 0)
	{ 
		return;
	}
	
	id				= selected_id;
	xml_http_logo = getHTTPObject();
	if (xml_http_logo==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="change_logo_status.php";

	url = url+"?logo_id=" + logo_id;
//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_logo.onreadystatechange	= change_logo_status_onready;
	xml_http_logo.open("GET",url,true);
	xml_http_logo.send(null);
} 
	
function change_logo_status_onready()
{ 
	if (xml_http_logo.readyState == 4 || xml_http_logo.readyState == "complete")
	{
		var status				= "";
		var logo_status_text	= "";
		var status_image		= "";
		var response			= xml_http_logo.responseText;
		
		if(response == 1)
		{
			
			
			status				= 'Active'
			status_image		= 'icon-active.png';
			logo_status_text	= 'Active';
		}
		else
		{
			
			status				= 'Inactive'
			status_image		= 'icon-inactive.png';
			logo_status_text	= 'Inactive';
		}
		
		document.getElementById('status_image_' + id).src = "images/" + status_image;
		document.getElementById('status_image_' + id).setAttribute("title", status);
		document.getElementById('status_image_' + id).setAttribute("alt", status);
		if(document.getElementById('logo_status_text'))
		{
			document.getElementById('logo_status_text').innerHTML = logo_status_text;
		}
	} 
}

function module_page_permission(module_id, logo_id, show)
{
	if (module_id.length == 0)
	{ 
		return;
	}
	id				= module_id;
	xml_http_logo	= getHTTPObject();
	if (xml_http_logo==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	var url="module_page_permission.php";
	url = url + "?module_id=" + module_id + "&logo_id=" + logo_id + "&show=" + show;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_logo.onreadystatechange	= module_page_permission_onready;
	xml_http_logo.open("GET",url,true);
	xml_http_logo.send(null);
} 
	
function module_page_permission_onready()
{ 
	if (xml_http_logo.readyState == 4 || xml_http_logo.readyState == "complete")
	{		
		document.getElementById('module_pages_' + id).innerHTML = xml_http_logo.responseText;
	} 
} 

function getSubCategory(){
	
	pid	= document.getElementById('parent_category_id').value;
	//if (pid > 0){
		xml_http_logo	= getHTTPObject();
		if (xml_http_logo==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		}
		var url="getSubCategoryList.php";
		url = url + "?pid=" + pid ;
		//alert(url);
		url = url+"&stid="+Math.random();
		xml_http_logo.onreadystatechange	= sucategory_onready;
		xml_http_logo.open("GET",url,true);
		xml_http_logo.send(null);
	//}
}

function sucategory_onready()
{ 
	if (xml_http_logo.readyState == 4 || xml_http_logo.readyState == "complete")
	{
		//alert (xml_http_logo.responseText);
		document.getElementById('subcat_div').innerHTML = xml_http_logo.responseText;
	} 
}
	