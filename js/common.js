/********************************************************************************************
Author 		: V V VIJESH
Date		: 25-July-2012
Purpose		: Common functions
Updated By	: 
Date		: 
********************************************************************************************/
var xml_http_common;
function getHTTPObject()
{
	var xmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function popup_crop_window(image_name, upload_dir_name, max_width, thumb_width, thumb_height)
{
	window.open("crop_image.php?image="+image_name+"&upload_dir_name="+upload_dir_name+"&max_width="+max_width+"&thumb_width="+thumb_width+"&thumb_height="+thumb_height, "CropGalleryImage", "width=900,height=600,scrollbars=yes,menubar=no");
}

function urlDecode(str){
	str=str.replace(new RegExp('\\+','g'),' ');
	return unescape(str);
}

function urlEncode(str){
	str=escape(str);
	str=str.replace(new RegExp('\\+','g'),'%2B');
	return str.replace(new RegExp('%20','g'),'+');
}

//Change admin theme
function change_admin_theme(admin_id, theme)
{
	if (admin_id.length == 0)
	{ 
		return;
	}
	xml_http_common = getHTTPObject();
	if (xml_http_common==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="change_admin_theme.php";

	url = url+"?admin_id=" + admin_id + "&theme=" + theme;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_common.onreadystatechange	= change_admin_theme_onready;
	xml_http_common.open("GET",url,true);
	xml_http_common.send(null);
} 
	
function change_admin_theme_onready()
{ 
	if (xml_http_common.readyState == 4 || xml_http_common.readyState == "complete")
	{
		var response		= xml_http_common.responseText;
		document.getElementById('theme').href = 'css/' + response + '/inner.css';
	}
}

//	Display delete confirmation box
function delete_all(frmName,field, exclbox)
{
	if(check_delbox(frmName,field, exclbox)) 
	{
		conf_mesg="Are you sure you want to delete the selected " + exclbox+"(s)?";
		if (confirm(conf_mesg))
		{
			document.forms[frmName].action_type.value="delete";
			document.forms[frmName].submit();
		}
		else
		{
			return false;
		}
	}
}

//	Toggle all selection box
function toggle_select_all(chkbx,frmobj)
{
	var frmObj=document.forms[frmobj]; 
	var count = frmObj.elements.length;	 
	if(document.getElementById(chkbx).checked==true)
	{
		for (i = 0; i < count; i++)
		{
			ele = frmObj.elements[i];				
			if ( ele.type == "checkbox")
			{
				frmObj.elements[i].checked = true;
			}
		} 
	}
	else
	{
		for (i = 0; i < count; i++)
		{
			ele = frmObj.elements[i];				
			if ( ele.type == "checkbox")
			{
				frmObj.elements[i].checked = false;
			}
		} 
	}
}

//	Select all selection box
function select_all(frmobj)
{
	
	var frmObj=document.forms[frmobj]; 
	
	var count = frmObj.elements.length;	
	for (i = 0; i < count; i++)
	{
		ele = frmObj.elements[i];
		if ( ele.type == "checkbox")
		{
			frmObj.elements[i].checked = true;
		}
	} 	    
}
//	Unselect all selection box
function unselect_all(frmobj)
{
	var frmObj=document.forms[frmobj]; 
	var count = frmObj.elements.length;	
	for (i = 0; i < count; i++)
	{
		ele = frmObj.elements[i];
		if ( ele.type == "checkbox")
		{
			frmObj.elements[i].checked = false;
		}
	} 	    
}

function export_all(frmName,field, exclbox)
{
	if(check_delbox(frmName,field, exclbox)) 
	{
		conf_mesg="Are you sure you want to export the selected " + exclbox;
		if (confirm(conf_mesg))
		{
			document.forms[frmName].action_type.value="export";
			document.forms[frmName].submit();
		}
		else
		{
			return false;
		}
	}
}

function exportSelected(frmName, exclbox)
{
	if(check_delbox(frmName, exclbox)) 
	{
		conf_mesg="Are you sure you want to export the selected " + exclbox;
		if (confirm(conf_mesg))
		{
			document.forms[frmName].act_type.value="export";
			document.forms[frmName].submit();
		}
		else
		{
			return false;
		}
	}
}

function refresh_captcha()
{
	//Get a reference to CAPTCHA image
	img = document.getElementById("img_captcha");
	//Change the image
	img.src = "create_image.php?" + Math.random();
}

function validateSubscriber()
{
	var forms = document.frmsubscribe;
	if (!check_blank(forms.subscriberEmail, "Please enter Email."))
	{	return false;	}
	if (!check_email(forms.subscriberEmail, "Email is not valid!"))
	{	return false;	}
	document.frmsubscribe.submit();
}