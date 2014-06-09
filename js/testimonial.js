// JavaScript Document


function validate_testimonialcategory()
{
	var forms = document.getElementById("testimonialcateg-frm");
    
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
	   alert('Search word is required!');
	   return false;
	}
}


 function validate_date(input, mesg)
 {
   var forms = document.getElementById("newtestimonial-frm"); 
   var date= document.getElementById("txtCalendarFirst").value;	 
   var currentDate = new Date()
  var day = currentDate.getDate()
  var month = currentDate.getMonth() + 1
  var year = currentDate.getFullYear()
   
   var smallDateArr = Array();
    smallDateArr = date.split("-");
    var smallDt = smallDateArr[0];
    var smallMt = smallDateArr[1];
    var smallYr = smallDateArr[2];  
    var largeDt = day;
    var largeMt = month;
    var largeYr = year;
	
	  if(smallYr>largeYr) 
	  {
       alert(mesg);
		input.focus();
		return false;
	  }
	else if(smallYr<=largeYr && smallMt>largeMt)
	{
		alert(mesg);
			input.focus();
			return false;
	}
	else if(smallYr<=largeYr && smallMt==largeMt && smallDt>largeDt)
	{
	   alert(mesg);
			input.focus();
			return false;
	}
	else 
	{
		 return true;
	}
  }

function validate_testimonial()
{
	
   var forms = document.getElementById("newtestimonial-frm");
  
  
  //document.write("<b>" + day + "/" + month + "/" + year + "</b>")
  
    /*  
   if (!check_blank(forms.testimonial_name, "Title is required!"))
   {	
	     return false;
   }
  */
   if (!check_blank(forms.testimonial_author, "Author is required!"))
   {	
	     return false;
   }
   else if(!check_valid_author_name(forms.testimonial_author, "Author Contains Special Characters!"))
   {
		 return false;
   }
 // else if (!validate_date(forms.txtCalendarFirst, "Date should be lessthan currentdate!"))
//   {	 
//	   	 return false;
//   }
//   else if (!check_blank(forms.txtCalendarFirst, "Date is required!"))
//   {	 
//	   	 return false;
//   }
   else if (!check_blank(forms.testimonial_post, "Content is required!"))
   {	 
	   	 return false;
   }
   
 
 
   return true;
}


function open_testimonial_details(testimonial_id,divId, show_edit_comment, comment_id, serial_value)
{  
	var ajaxrequest;
	ajaxrequest = getHTTPObject();
	if (ajaxrequest==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
 	var show = document.getElementById("show").value;
	if(document.getElementById("show_testimonial_id").value==0) {  document.getElementById("show_testimonial_id").value=testimonial_id;}
	var bid		= document.getElementById("show_testimonial_id").value;
	//alert(bid+"   "+testimonial_id);
	if(show=='0' && bid==testimonial_id)
	{		
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_testimonial_id").value	= testimonial_id;
	}
	else if(show=='0' && bid!=testimonial_id)
	{
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_testimonial_id").value	= testimonial_id;
	}
	else if(show=='1' && bid!=testimonial_id)
	{
		  show=1;
		  document.getElementById("show").value	= 1;
		  document.getElementById("show_testimonial_id").value	= testimonial_id;
	}
	else
	{		  
		  show=0;
		  document.getElementById("show").value	= 0;
		  document.getElementById("show_testimonial_id").value	= testimonial_id;
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
	var url="show_testimonial_details.php?testimonial_id="+testimonial_id+"&testimonial_serial_value="+serial_value+ "&show=" + show;
 	ajaxrequest.open("post", url, true);
    ajaxrequest.send(null);
    return true;
	
}


function change_comment_status(conf_status,comment_id,testimonialid,it_value)
{
  var conf_msg;
  if(conf_status==0) conf_msg="Approve";
  else conf_msg="Disapprove";
  if(confirm('Are you sure you want to '+conf_msg+' this Comment?'))
   {
	   document.forms['testimonialcommentsfrm'].act_type.value="change_stat";
		document.forms['testimonialcommentsfrm'].status.value=conf_status;
		document.forms['testimonialcommentsfrm'].comment_id.value=comment_id;
		document.forms['testimonialcommentsfrm'].testimonialid.value=testimonialid;
		document.forms['testimonialcommentsfrm'].it_value.value=it_value;
	   	  document.forms['testimonialcommentsfrm'].submit(); 
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

function update_comment(comment_id,testimonial_id,it_value,com_ccc)
{
   document.testimonialcommentseditfrm.comment_id.value=comment_id;
   
   var testimonial_comm_name="testimonial_comment_name_"+comment_id; 
   document.testimonialcommentseditfrm.testimonial_comment_name.value=document.getElementById(testimonial_comm_name).value;
   
   if (!check_blank(document.getElementById(testimonial_comm_name), " Author is required!"))
   {	    
		 return false;
   }
   
   var testimonial_comm_desc="testimonial_comment_description_"+comment_id;  
   document.testimonialcommentseditfrm.testimonial_comment_description.value=document.getElementById(testimonial_comm_desc).value;
   
   if (!check_blank(document.getElementById(testimonial_comm_desc), " Comment is required!"))
   {
	     return false;
    }
   
   /*var testimonial_comm_stat="testimonial_comment_status_"+comment_id;  
   document.testimonialcommentseditfrm.testimonial_comment_status.value=document.getElementById(testimonial_comm_stat).value;*/
   
   document.testimonialcommentseditfrm.testimonial_id.value=testimonial_id;
   document.testimonialcommentseditfrm.it_value.value=it_value;
   document.testimonialcommentseditfrm.serial_value.value=com_ccc;	
   document.testimonialcommentseditfrm.submit();
   
}


function select_all_testimonials(chkbx,frmobj)
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

function toggle_select_comment_all(chkbx,frmobj,testimonialid)
{
		var frmObj=document.forms[frmobj]; 	
		var chkbxname='checkbox1_'+testimonialid+'[]';	
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


function delete_comment(comment_id,testimonialid,it_value)
{  
  
  if(check_comment_delbox(testimonialid)) 
   {
	  var conf_mesg;	  
	  conf_mesg="Are you sure you want to delete selected comment(s)?";
	  if (confirm(conf_mesg))
	   {
	  	 document.forms["testimonialfrm"].act_type.value="delete_comment";
		 document.forms["testimonialfrm"].testimonialid.value=testimonialid;
		  document.forms["testimonialfrm"].it_value.value=it_value;		
	   	 document.forms["testimonialfrm"].submit();
	   }
	   else return false;
   }
  
  
}


function check_comment_delbox(testimonialid)
{
	var checked;
	checked	= 0;
    var chkbxname='checkbox1_'+testimonialid+'[]';
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


function validate_testimonial_search(frmobj)
{
	if(trim(document.forms[frmobj].search_word.value) == "")
	{ 
	   alert('Search word is required!');
	   return false;
	}
}

//	Display delete confirmation box
function delete_all_testimonials(frmName, field, exclbox)
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
function change_testimonial_status(testimonial_id, selected_id)
{
	if (testimonial_id.length == 0)
	{ 
		return;
	}
	
	id				= selected_id;
	xml_http_testimonial = getHTTPObject();
	if (xml_http_testimonial==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}
	
	var url="change_testimonial_status.php";

	url = url+"?testimonial_id=" + testimonial_id;
	//alert(url);
	url = url+"&stid="+Math.random();
	xml_http_testimonial.onreadystatechange	= change_testimonial_status_onready;
	xml_http_testimonial.open("GET",url,true);
	xml_http_testimonial.send(null);
} 
function change_testimonial_status_onready()
{ 
	if (xml_http_testimonial.readyState == 4 || xml_http_testimonial.readyState == "complete")
	{
		var status				= "";
		var testimonial_status_text	= "";
		var status_image		= "";
		var response			= xml_http_testimonial.responseText;
		
		//alert(response);
		
		if(response == 1)
		{
			status				= 'Active'
			status_image		= 'icon-active.png';
			testimonial_status_text	= 'Active';
		}
		else
		{
			status				= 'Inactive'
			status_image		= 'icon-inactive.png';
			testimonial_status_text	= 'Inactive';
		}
		
		document.getElementById('status_image_' + id).src = "images/" + status_image;
		document.getElementById('status_image_' + id).setAttribute("title", status);
		document.getElementById('status_image_' + id).setAttribute("alt", status);
		if(document.getElementById('testimonial_status_text'))
		{
			document.getElementById('testimonial_status_text').innerHTML = testimonial_status_text;
		}
	} 
}

	

