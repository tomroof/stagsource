// JavaScript Document
function open_content_details(content_id,divId, show_edit_comment, comment_id, serial_value)
{  
	var ajaxrequest;
	ajaxrequest = getHTTPObject();
	if (ajaxrequest==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
 	var show = document.getElementById("show").value;
	if(document.getElementById("show_content_id").value==0) {  document.getElementById("show_content_id").value=content_id;}
	var bid		= document.getElementById("show_content_id").value;
	//alert(bid+"   "+content_id);
	if(show=='0' && bid==content_id)
	{		
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_content_id").value	= content_id;
	}
	else if(show=='0' && bid!=content_id)
	{
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_content_id").value	= content_id;
	}
	else if(show=='1' && bid!=content_id)
	{
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_content_id").value	= content_id;
	}
	else
	{		  
		  show=0;
		  document.getElementById("show").value	= 0;
		  document.getElementById("show_content_id").value	= content_id;
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
	var url="show_content_details.php?content_id="+content_id+"&content_serial_value="+serial_value+ "&show=" + show;
 	ajaxrequest.open("post", url, true);
    ajaxrequest.send(null);
    return true;
	
}

function select_all_contents(chkbx,frmobj)
{
		var frmObj=document.forms[frmobj]; 	
		var chkbxname='checkbox[]';	
		var count = document.getElementsByName(chkbxname).length; 
		
		if(document.getElementById(chkbx).checked==true)
		{
			for (i = 0; i < count; i++)
			{
				ele1 = document.getElementsByName(chkbxname);	 
				ele = ele1[i];
				
				//ele = frmObj.elements[i];
				
				if ( ele.type == "checkbox")
				{
					ele.checked = true;
				}
			} 
		}
		else
		{
			for (i = 0; i < count; i++)
			{
				ele1 = document.getElementsByName(chkbxname);	 
				ele = ele1[i];
				if ( ele.type == "checkbox")
				{
					ele.checked = false;
				}
			} 
		}
}

function select_default_all(frmobj)
{
		var frmObj=document.forms[frmobj]; 	
		var chkbxname='checkbox[]';	
		var count = document.getElementsByName(chkbxname).length; 
		var all_check=document.getElementById("checkbox2");
		all_check.checked=true;
		for (i = 0; i < count; i++)
		{
			ele1 = document.getElementsByName(chkbxname);	 
			ele = ele1[i];
				
			//ele = frmObj.elements[i];
				
			if ( ele.type == "checkbox")
			{
				ele.checked = true;
			}
		} 
				
}

function toggle_select_comment_all(chkbx,frmobj,contentid)
{
		var frmObj=document.forms[frmobj]; 	
		var chkbxname='checkbox1_'+contentid+'[]';	
		var count = document.getElementsByName(chkbxname).length; 
		
		if(document.getElementById(chkbx).checked==true)
		{
			for (i = 0; i < count; i++)
			{
				ele1 = document.getElementsByName(chkbxname);	 
				ele = ele1[i];
				
				//ele = frmObj.elements[i];
				
				if ( ele.type == "checkbox")
				{
					ele.checked = true;
				}
			} 
		}
		else
		{
			for (i = 0; i < count; i++)
			{
				ele1 = document.getElementsByName(chkbxname);	 
				ele = ele1[i];
				if ( ele.type == "checkbox")
				{
					ele.checked = false;
				}
			} 
		}
}

function validate_content_search(frmobj)
{
	if((document.forms[frmobj].content_category.value==0) &&  (trim(document.forms[frmobj].search_word.value) == ""))
	{ 
	   alert('You should either enter a Title or select a Category to Search!');
	   return false;
	}
}

//	Display delete confirmation box
function delete_all_contents(frmName, field, exclbox)
{
	if(check_delbox(frmName, field, exclbox)) 
	{
		conf_mesg="Are you sure you want to delete the selected " + exclbox+"(s)?";
		if (confirm(conf_mesg))
		{
			document.forms[frmName].act_type.value="delete";
			document.forms[frmName].submit();
		}
		else
		{
			return false;
		}
	}
}

function change_content_status(content_id, selected_id)
{
	if (content_id.length == 0)
	{ 
		return;
	}
	
	id				= selected_id;
	xml_http_content = getHTTPObject();
	if (xml_http_content==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="change_content_status.php";

	url = url+"?content_id=" + content_id;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_content.onreadystatechange	= change_content_status_onready;
	xml_http_content.open("GET",url,true);
	xml_http_content.send(null);
} 
	
function change_content_status_onready()
{ 
	if (xml_http_content.readyState == 4 || xml_http_content.readyState == "complete")
	{
		var status				= "";
		var content_status_text	= "";
		var status_image		= "";
		var response			= xml_http_content.responseText;
		
		if(response == 1)
		{
			status				= 'Active'
			status_image		= 'icon-active.png';
			content_status_text	= 'Active';
		}
		else
		{
			status				= 'Inactive'
			status_image		= 'icon-inactive.png';
			content_status_text	= 'Inactive';
		}
		
		document.getElementById('status_image_' + id).src = "images/" + status_image;
		document.getElementById('status_image_' + id).setAttribute("title", status);
		document.getElementById('status_image_' + id).setAttribute("alt", status);
		if(document.getElementById('content_status_text'))
		{
			document.getElementById('content_status_text').innerHTML = content_status_text;
		}
	} 
}

function change_menu_option(content_id, selected_id)
{
	if (content_id.length == 0)
	{ 
		return;
	}
	
	id				= selected_id;
	xml_http_content = getHTTPObject();
	if (xml_http_content==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="change_menu_option.php";

	url = url+"?content_id=" + content_id;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_content.onreadystatechange	= change_menu_option_onready;
	xml_http_content.open("GET",url,true);
	xml_http_content.send(null);
} 
	
function change_menu_option_onready()
{ 
	if (xml_http_content.readyState == 4 || xml_http_content.readyState == "complete")
	{
		var menu_option				= "";
		var menu_option_text	= "";
		var menu_option_image		= "";
		var response			= xml_http_content.responseText;
		
		if(response == 1)
		{
			menu_option				= 'Active'
			menu_option_image		= 'icon-active.png';
			menu_option_text	= 'Active';
		}
		else
		{
			menu_option				= 'Inactive'
			menu_option_image		= 'icon-inactive.png';
			menu_option_text		= 'Inactive';
		}
		
		document.getElementById('menu_option_image_' + id).src = "images/" + menu_option_image;
		document.getElementById('menu_option_image_' + id).setAttribute("title", menu_option);
		document.getElementById('menu_option_image_' + id).setAttribute("alt", menu_option);
		/*
		if(document.getElementById('menu_option_text'))
		{
			document.getElementById('menu_option_text').innerHTML = menu_option_text;
		}*/
	} 
}