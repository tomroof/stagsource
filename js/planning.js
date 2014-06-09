// JavaScript Document
function validate_planningcategory()
{
	var forms = document.getElementById("planningcateg-frm");
    
	if (!check_blank(forms.categ_name, " Blog Category Name is required!"))
	{	
	    
		 return false;
	}
    return true;
}

function validate_category_search(frmobj)
{
	if(trim(document.forms[frmobj].search_word.value) == "")
	{ 
	   alert('Search word is required !');
	   return false;
	}
}
/*
function validate_planning()
{
   var forms = document.getElementById("newplanning-frm");
      
   if (!check_blank(forms.planning_name, "Title is required!"))
   {	
	     return false;
   }
  
   if (!check_blank(forms.planning_author, "Author is required!"))
   {	
	     return false;
   }
   
   
   else if(!check_valid_author_name(forms.planning_author, "Author Contains Special Characters!"))
   {
		 return false;
   }
   
   if (!check_blank(forms.planning_date, "Date is required!"))
   {	 
	   	 return false;
   }
   
   var bcat=document.getElementById("planning_category_id");
  
  if(!check_combo(bcat, 0, "Category should be selected"))
  {
	    return false;
  }
  
  if (!check_editor_content("planning_post", "Blog Post is required!","errmesg5"))
   {			
		return false;
  }  
   
   return true;
}
*/

function open_planning_details(planning_id,divId, show_edit_comment, comment_id, serial_value)
{  
	var ajaxrequest;
	ajaxrequest = getHTTPObject();
	if (ajaxrequest==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
 	var show = document.getElementById("show").value;
	if(document.getElementById("show_planning_id").value==0) {  document.getElementById("show_planning_id").value=planning_id;}
	var bid		= document.getElementById("show_planning_id").value;
	//alert(bid+"   "+planning_id);
	if(show=='0' && bid==planning_id)
	{		
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_planning_id").value	= planning_id;
	}
	else if(show=='0' && bid!=planning_id)
	{
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_planning_id").value	= planning_id;
	}
	else if(show=='1' && bid!=planning_id)
	{
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_planning_id").value	= planning_id;
	}
	else
	{		  
		  show=0;
		  document.getElementById("show").value	= 0;
		  document.getElementById("show_planning_id").value	= planning_id;
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
	var url="show_planning_details.php?planning_id="+planning_id+"&planning_serial_value="+serial_value+ "&show=" + show;
 	ajaxrequest.open("post", url, true);
    ajaxrequest.send(null);
    return true;
	
}


function change_comment_status(conf_status,comment_id,planningid,it_value)
{
  var conf_msg;
  if(conf_status==0) conf_msg="Approve";
  else conf_msg="Disapprove";
  if(confirm('Are you sure you want to '+conf_msg+' this Comment?'))
   {
	   document.forms['planningcommentsfrm'].act_type.value="change_stat";
		document.forms['planningcommentsfrm'].status.value=conf_status;
		document.forms['planningcommentsfrm'].comment_id.value=comment_id;
		document.forms['planningcommentsfrm'].planningid.value=planningid;
		document.forms['planningcommentsfrm'].it_value.value=it_value;
	   	  document.forms['planningcommentsfrm'].submit(); 
		return true;   
   }
   else
   {
	  return false;   
   }
}

function show_comment(comment_id,tot_comments,show_div_value)
{
  //alert(window.location);
  if(document.getElementById('comment_num_rows'))
  {
	  comm_num_rows = document.getElementById('comment_num_rows').value;
  
 	  for (i = 1; i <= comm_num_rows; i++)
  	  {
	 	 if(i==show_div_value) continue;
	 	 document.getElementById('comments_div_'+ i).style.display="none";
	 	 document.getElementById('edit_div_'+ i).style.display="none";
      }
  }
  else
  {
	  
  }
  
  var edit_div_name="edit_div_"+show_div_value;
  if(document.getElementById(edit_div_name))
  {
  	if(document.getElementById(edit_div_name).style.display=="block")
  	{
  		document.getElementById(edit_div_name).style.display="none";
  	}
  }
  
  
  var comment_div_name="comments_div_"+show_div_value;
  if(document.getElementById(comment_div_name))
  {
  	if(document.getElementById(comment_div_name).style.display=="block")
  	{  	
		document.getElementById(comment_div_name).style.display="none";
  	}
  	else document.getElementById(comment_div_name).style.display="block";
  }
  else
  {
	 
  }
 //alert(comment_div_name);   
}
function edit_comment(comment_id,tot_comments,show_div_value)
{
  //alert(window.location);
  
  if(document.getElementById('comment_num_rows'))
  {
	  comm_num_rows = document.getElementById('comment_num_rows').value;
  }
  for (i = 1; i <= comm_num_rows; i++)
  {
	 if(i==show_div_value) continue;
	 document.getElementById('edit_div_'+ i).style.display="none";
	 document.getElementById('comments_div_'+ i).style.display="none";
  }
  
  var comment_div_name="comments_div_"+show_div_value;
  
  if(document.getElementById(comment_div_name)!=null)
  {  
  	 if(document.getElementById(comment_div_name).style.display=="block")
  	 {
   	 	document.getElementById(comment_div_name).style.display="none";
 	 }
  }
  var edit_div_name="edit_div_"+show_div_value;
  
  if(document.getElementById(edit_div_name)!=null)
  {
  	if(document.getElementById(edit_div_name).style.display=="block")
  	{
  		document.getElementById(edit_div_name).style.display="none";
  	}
  	else document.getElementById(edit_div_name).style.display="block";
  }
   
}

function update_comment(comment_id,planning_id,it_value,com_ccc)
{
   document.planningcommentseditfrm.comment_id.value=comment_id;
   
   var planning_comm_name="planning_comment_name_"+comment_id; 
   document.planningcommentseditfrm.planning_comment_name.value=document.getElementById(planning_comm_name).value;
   
   if (!check_blank(document.getElementById(planning_comm_name), " Author is required!"))
   {	    
		 return false;
   }
   
   var planning_comm_desc="planning_comment_description_"+comment_id;  
   document.planningcommentseditfrm.planning_comment_description.value=document.getElementById(planning_comm_desc).value;
   
   if (!check_blank(document.getElementById(planning_comm_desc), " Comment is required!"))
   {
	     return false;
    }
   
   /*var planning_comm_stat="planning_comment_status_"+comment_id;  
   document.planningcommentseditfrm.planning_comment_status.value=document.getElementById(planning_comm_stat).value;*/
   
   document.planningcommentseditfrm.planning_id.value=planning_id;
   document.planningcommentseditfrm.it_value.value=it_value;
   document.planningcommentseditfrm.serial_value.value=com_ccc;	
   document.planningcommentseditfrm.submit();
   
}


function select_all_plannings(chkbx,frmobj)
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

function toggle_select_comment_all(chkbx,frmobj,planningid)
{
		var frmObj=document.forms[frmobj]; 	
		var chkbxname='checkbox1_'+planningid+'[]';	
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


function delete_comment(comment_id,planningid,it_value)
{  
  
  if(check_comment_delbox(planningid)) 
   {
	  var conf_mesg;	  
	  conf_mesg="Are you sure you want to delete selected comment(s)?";
	  if (confirm(conf_mesg))
	   {
	  	 document.forms["planningfrm"].act_type.value="delete_comment";
		 document.forms["planningfrm"].planningid.value=planningid;
		  document.forms["planningfrm"].it_value.value=it_value;		
	   	 document.forms["planningfrm"].submit();
	   }
	   else return false;
   }
  
  
}


function check_comment_delbox(planningid)
{
	var checked;
	checked	= 0;
    var chkbxname='checkbox1_'+planningid+'[]';
	count =  document.getElementsByName(chkbxname).length;

	for (i = 0; i < count; i++)
	{
		ele1 = document.getElementsByName(chkbxname);	 
		ele = ele1[i];
		if ((ele.type == "checkbox"))
		{
			if (ele.checked)
			{
				checked++;
			}
		}
	}

	if (checked == 0)
	{
		alert("Select atleast one Comment to delete");
		return false;
	}
	else
	{
		return true;
	}
}



//	Display delete confirmation box
function delete_all_plannings(frmName, field, exclbox)
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

function check_valid_author_name(input, mesg)
{
	var count;
	var special = "`~!@#$%^&*()=_+\|/*.><,;:][{}?";
	var chars = input.value.split("");

	if (input.value.length != 0)
	{
		count = 0;
		for (i = 0; i < chars.length; i++)
		{
			if (special.indexOf(chars[i]) != -1)
		 	{	
				count++;		
			}

			if (count > 0)
			{
				alert(mesg);
				input.focus();
				return false;
			}
		}
	}
	return true;
}



function validate_planning_search(obj1,obj2,obj3,obj4)
{
	
	if(trim(document.getElementById(obj1).value) == "" && trim(document.getElementById(obj2).value) == 0 && trim(document.getElementById(obj3).value) == 0 && trim(document.getElementById(obj4).value) == 0)
	{ 
	   alert('You should enter search word and/or select dropdowns!');
	   return false;
	}
}



function change_planning_status(planning_id, selected_id)
{
	if (planning_id.length == 0)
	{ 
		return;
	}
	
	id				= selected_id;
	xml_http_planning = getHTTPObject();
	if (xml_http_planning==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="change_planning_status.php";

	url = url+"?planning_id=" + planning_id;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_planning.onreadystatechange	= change_planning_status_onready;
	xml_http_planning.open("GET",url,true);
	xml_http_planning.send(null);
} 

function change_planning_status_onready()
{ 
	if (xml_http_planning.readyState == 4 || xml_http_planning.readyState == "complete")
	{
		var status				= "";
		var planning_status_text	= "";
		var status_image		= "";
		var response			= xml_http_planning.responseText;
		
		if(response == 1)
		{
			status				= 'Active'
			status_image		= 'icon-active.png';
			planning_status_text	= 'Active';
		}
		else
		{
			status				= 'Inactive'
			status_image		= 'icon-inactive.png';
			planning_status_text	= 'Inactive';
		}
		
		document.getElementById('status_image_' + id).src = "images/" + status_image;
		document.getElementById('status_image_' + id).setAttribute("title", status);
		document.getElementById('status_image_' + id).setAttribute("alt", status);
		if(document.getElementById('planning_status_text'))
		{
			document.getElementById('planning_status_text').innerHTML = planning_status_text;
		}
	} 
}

function change_terms_condition_status(planning_id, selected_id)
{
	
	if (planning_id.length == 0)
	{ 
		return;
	}
	
	id				= selected_id;
	xml_http_planning = getHTTPObject();
	if (xml_http_planning==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="change_terms_condition_status.php";

	url = url+"?planning_id=" + planning_id;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_planning.onreadystatechange	= change_terms_condition_status_onready;
	xml_http_planning.open("GET",url,true);
	xml_http_planning.send(null);
} 

function change_terms_condition_status_onready()
{ 
	if (xml_http_planning.readyState == 4 || xml_http_planning.readyState == "complete")
	{
		var terms_condition_status				= "";
		var terms_condition_status_text	= "";
		var terms_condition_status_image		= "";
		var response			= xml_http_planning.responseText;
		
		if(response == 1)
		{
			
			terms_condition_status				= 'Active'
			terms_condition_status_image		= 'icon-active.png';
			terms_condition_status_text	= 'Active';
			
		}
		else
		{
			terms_condition_status				= 'Inactive'
			terms_condition_status_image		= 'icon-inactive.png';
			terms_condition_status_text	= 'Inactive';
		}
			 
		document.getElementById('terms_condition_status_image_' + id).src = "images/" + terms_condition_status_image;
		document.getElementById('terms_condition_status_image_' + id).setAttribute("title", terms_condition_status);
		document.getElementById('terms_condition_status_image_' + id).setAttribute("alt", terms_condition_status);
		if(document.getElementById('terms_condition_status_text'))
		{
			document.getElementById('terms_condition_status_text').innerHTML = terms_condition_status_text;
		}
	} 
}

