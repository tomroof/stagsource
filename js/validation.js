/********************************************************************************************
Author 		: V V VIJESH
Date		: 25-July-2012
Purpose		: Common functions
Updated By	: 
Date		: 
********************************************************************************************/
function check_delbox(frmName,field, mesg)
{
	var checked;
	checked	= 0;
	count = document.forms[frmName].elements.length;

	for (i = 0; i < count; i++)
	{
		ele = document.forms[frmName].elements[i];
		if ((ele.type == "checkbox") && (ele.name != "checkbox"))
		{
			if (document.forms[frmName].elements[i].checked)
			{
				checked++;
			}
		}
	}

	if (checked == 0)
	{
		alert("Select atleast one " + mesg);
		return false;
	}
	else
	{
		return true;
	}
}

//Checked atleast one box is ticked.
function get_check(chk_delete, field)
{
	var count = document.formlist.elements.length;

	if (chk_delete.checked)
	{
		for (i = 0; i < count; i++)
		{
			ele = document.formlist.elements[i];
			if (( ele.type == "checkbox") && (ele.name != "checkbox"))
			{
				document.formlist.elements[i].checked = 1;
			}
		}
	}
	else
	{
		for (j = 0; j < count; j++)
		{
			ele = document.formlist.elements[j];
			if ((ele.type == "checkbox") && (ele.name != "checkbox"))
			{
				document.formlist.elements[j].checked = 0;
			}
		}
	}

	return true;
}

// Check the radio button in checked or not
function is_checked(radioObj, mesg)
{
	var flag = false;
	var radioLength = radioObj.length;
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			flag = true;
		}
	}
	
	if(!flag)
	{
		alert(mesg);
		return false;
	}
	return true;
}

function check_blank(input, mesg)
{
	if (trim(input.value) == "")
	{
		alert(mesg);
		input.focus();
		return false;
	}
	return true;
}

function check_selected(input, mesg)
{
	if (trim(input.value) == 0)
	{
		alert(mesg);
		input.focus();
		return false;
	}
	return true;
}

function check_length(input, mini, maxi, mesg)
{
	//	var mini = 3
	//	var maxi = 7

	if (input.value.length < mini || input.value.length > maxi)
	{
		alert(mesg);
		input.focus();
		return false;
	}

	return true;
}

function check_range(input, mini, maxi, mesg)
{
	//	var mini = 3
	//	var maxi = 7
	if (input.value < mini || input.value > maxi)
	{
		alert(mesg);
		input.focus();
		return false;
	}

	return true;
}

function check_compare(input1, input2, mesg)
{
	if (input1.value.length != 0 && input2.value.length != 0)
	{
		if (input1.value != input2.value)
		{
			alert(mesg);
			input2.focus();
			return false;
		}
	}

	return true;
}

function check_combo(input, val, mesg)
{
	if (input.value == val)
	{
		alert(mesg);
		input.focus();
		return false;
	}

	return true;
}

function check_number(input, mesg)
{
	var re = /^[0-9]*$/;

	if (input.length != 0)
	{
		if (!re.test(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}

	return true;
}

function check_numeric(input, mesg)
{
	if (input.length != 0)
	{
		if (!Number(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}
	return true;
}


function check_zero_and_numeric(input, mesg)
{
	var re = /^([0-9]+)(.*)([0-9]+)*$/;

	if (input.length != 0)
	{
		if (!re.test(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}

	return true;
}





// 123.50
function check_currency(input, mesg)
{
	var re = /^([0-9]+)(\.)([0-9]{2})*$/;

	if (input.length != 0)
	{
		if (!re.test(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}
	return true;
}

function check_alphabets(input, allow_space, mesg)
{
	var re = '';
	if (allow_space == true)
	{
		re = /[^A-Za-z\ ]+$/;
	}
	else
	{
		re = /[^A-Za-z]+$/;
	}
		
	//var re = /^[A-Za-z]*$/;

	if (input.length != 0)
	{
		if (!re.test(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}

	return true;
}

function check_module_name(input, mesg)
{
	var re = /^[a-z\_]+$/;

	if (input.length != 0)
	{
		if (!re.test(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}

	return true;
}


function check_alphanumeric(input, mesg)
{
	var re = /^[A-Za-z0-9]*$/;

	if (input.length != 0)
	{
		if (!re.test(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}

	return true;
}

function check_email(input, mesg)
{
	var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

	if (input.length != 0)
	{
		if (!re.test(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}

	return true;
}

function check_ip(input, mesg)
{
	var re = "/^(25[0-5]|2[0-4]\d|[01]?\d\d\d)\.25[0-5]|2[0-4]\d|[01]?\d\d\d)\.25[0-5]|2[0-4]\d|[01]?\d\d\d)\.25[0-5]|2[0-4]\d|[01]?\d\d\d))$/";

	if (input.length != 0)
	{
		if (!re.test(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}

	return true;
}

function check_url(input, mesg)
{
	if (input.length != 0)
	{
		//if (!input.value.match("/^((http|https):\/\/)?((w){3}$\.)?[a-z0-9\-]+)?\.((.*))$/"))
		if (!input.value.match(/^((http|https):\/\/)?((w){3}$\.)?[a-z0-9\-]+?\.((.*))$/))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}



	return true;
}

function check_zip(input, mesg)
{
	var re = /^[0-9]{5}$/;

	if (input.length != 0)
	{
		if (!re.test(input.value))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}

	return true;
}

function check_specialchar(input, mesg)
{
	var count;
	var special = "`~!@#$%^&*()_-=+\|/*.><,';:][{}?";
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

function check_allowspecial(input, mesg)
{
	var count;
	var special = "`~!@#$%^&*()=+\|/*.><,';:][{}?";
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

function check_date(input, mesg)
{
	var datePat = "/^(\d{1, 2})(\/|-)(\d{1,2})\2(\d{2}|\d{4})$/";
	var matchArray	= input.value.match(datePat);

	if (matchArray == null)
	{
		return false;
	}

	month	= matchArray[1];
	day		= matchArray[3];
	year	= matchArray[4];

	if (month < 1 || month > 12)
	{
		alert("Month must be between 1 and 12");
		return false;
	}

	if (day < 1 || day > 31)
	{
		alert ("Day must be between 1 and 31");
		return false;
	}

	if ((month == 4 || month == 6 || month == 9 || month == 11) && (day == 31))
	{
		alert("Month " + month + " does not have 31 days!");
		return false;
	}

	if (month == 2)
	{
//		var isleap((year % 4 == 0) && (year % 100 != 0 || year % 400 == 0));

		if ( (day > 29) || (day == 29 && (!isleap)) )
		{
		   	alert("February " + year + " does not have " + day + " days!");
			return false;
		}
	}

	return true;
}

// e.g. popup('http://www.google.com', 'Google', 'no', 'no', 0, 0, 500, 400)
function popup(file, title, menubar, toolbar, status, sb, width, height)
{
	var mywindow;
	mywindow = window.open(file, title, '"menubar = ' + menubar + ', toolbar = ' + toolbar + ', status = ' + status + ', scrollbars = ' + sb +  ', width = ' + width + ', height = ' + height + '"');
}

function print_page()
{
	if (window.print)
	{
		agree = confirm("Print this page ?");

		if (agree)
		{	window.print();		}
	}
}

function validateEmail(form)
{
	var returncode = true;
	var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/

	if ( re.test(form.email.value) )
	{
		// it passes
		returncode = true;
	}
	else
	{
		alert("Invalid email address specified " + form.email.value + "\nPlease correct it");
		form.email.focus();
		form.email.select();
		returncode = false;
	}
	return returncode;
}

function filterNonNumeric(field)
{
	var result = new String();
	var numbers = "0123456789";
	var chars = field.value.split(""); // create array

	for (i = 0; i < chars.length; i++)
	{
		if (numbers.indexOf(chars[i]) != -1) result += chars[i];
	}

	if (field.value != result) field.value = result;
}

function filterNonNumeric_zero(field)
{
	var result = new String();
	var numbers = "0123456789";
	var chars = field.value.split(""); // create array

	for (i = 0; i < chars.length; i++)
	{
		if (numbers.indexOf(chars[i]) != -1) result += chars[i];
	}

	if (field.value != result) field.value = result;
	if (field.value == '0') field.value = "1";
	if (field.value == '') field.value = "1";
}

function filterNumericWithSign(field)
{
	var result = new String();
	var numbers = "0123456789-.";
	var chars = field.value.split(""); // create array

	for (i = 0; i < chars.length; i++)
	{
		if (numbers.indexOf(chars[i]) != -1) result += chars[i];
	}

	if (field.value != result) field.value = result;
}

function filterForCurrency(field)
{
	var result = new String();
	var numbers = "0123456789.";
	var chars = field.value.split(""); // create array

	for (i = 0; i < chars.length; i++)
	{
		if (numbers.indexOf(chars[i]) != -1) result += chars[i];
	}

	if (field.value != result) field.value = result;
}

function filter_phone(field, id, mesg)				// DD 25 June, 2004 for Phone validation
{
	var result = new String();
    var count = 0;
	var numbers = "0123456789()-";			// DD 25 June, 2004. Do not change sequence of last 3 digit, (,),-
	var chars = field.value.split("");		// create array
/*
    if (field.value.length < 10)
    {
    	alert (mesg);
        field.select();
        field.focus();
        return(false);
    }
    else
    {
*/
		for (i = 0; i < chars.length; i++)
    	{
        	if (numbers.indexOf(chars[i]) == 10 || numbers.indexOf(chars[i]) == 11 || numbers.indexOf(chars[i]) == 12)
            { count++; }

			if (numbers.indexOf(chars[i]) != -1) result += chars[i];
		}

    	if (field.value != result) field.value = result;

    	if ((count == 2) && (field.value.length > 12))
    	{
			document.getElementById(id).innerHTML = mesg;
    		//alert (mesg);
        	field.select();
        	field.focus();
        	return(false);
    	}
        else
        	{ return(true); }
//    }
}

function validate_phone(input, id, mesg)
{
	if (!input.value.match(/^(\d{3})\-(\d{3})\-(\d{4})$/) )
	{
		document.getElementById(id).innerHTML = mesg;
		//alert (mesg);
		input.focus();
		return false;
	}

	return true;
}

function check_state (form)
{
	//alert (form.state.value);
	if (!StateV (form.state.value, "Please enter the \"State\" you currently reside."))
	{
		return(false);
	}
}

function StateV (s, message)
{
	if (s.selectedIndex = 0)
	{
	   alert(message);
	   s.focus();
	   return (false);
	}

	return (true);
}

function validate_Zip(oZip)
{
	var re = /^[0-9][0-9][0-9][0-9][0-9]\-?([0-9][0-9][0-9][0-9])?$/;
	var sZip = oZip.value;
	var bPassed = true;

	//First let's check for length of string
	if (sZip.length != 0)
    {
		//Now let's check if it's ok
		if (sZip.search(re) == -1)
        {
            sMessage = 'Zip code must be 5 numbers.';
			bPassed = false;
		}
	}
	else
    {
		bPassed = false;
	}

	if (!bPassed)
    {
		if (sMessage.length == 0)
		{
			sMessage = 'Zip code must be 5 numbers.\nIt may be followed by a four number extension, with or without a dash.';
		}
		alert(sMessage);
        oZip.select();
        oZip.focus();
        return(false);
	}
	else
    {
		return(true);
	}
}
/*
validate_date = function(date)
{
	if ( date.match(/^(\d{1,2})\-(\d{1,2})\-(\d{4})$/) )
	{
		var mm = RegExp.$1;
		var dd = RegExp.$2;
		var yy = RegExp.$3;

		// try to create the same date using Date Object
		var dt = new Date(parseFloat(yy), parseFloat(mm)-1, parseFloat(dd), 0, 0, 0, 0);
		// invalid day
		if ( parseFloat(dd) != dt.getDate() ) { return false; }
		// invalid month
		if ( parseFloat(mm)-1 != dt.getMonth() ) { return false; }
		// invalid year
		if ( parseFloat(yy) != dt.getFullYear() ) { return false; }

		// everything fine
		return true;
	} else {
		// not even a proper date
		return false;
	}
}
*/

function compareDates (value1, value2)
{
	var date1, date2;
	var month1, month2;
	var year1, year2;

	year1	= value1.substring (0, value1.indexOf ("-"));
	month1	= value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));
	date1	= value1.substring (value1.lastIndexOf ("-")+1, value1.length);

	year2	= value2.substring (0, value2.indexOf ("-"));
	month2	= value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
	date2	= value2.substring (value2.lastIndexOf ("-")+1, value2.length);

	if (year1 > year2) return 1;
	else if (year1 < year2) return -1;
	else if (month1 > month2) return 1;
	else if (month1 < month2) return -1;
	else if (date1 > date2) return 1;
	else if (date1 < date2) return -1;
	else return 0;
} 

function month_last_date(month, year)
{
	var day;
	switch(month)
	{
		case 1 :
		case 3 :
		case 5 :
		case 7 :
		case 8 :
		case 10:
		case 12:
			day = 31;
			break;
		case 4 :
		case 6 :
		case 9 :
		case 11:
			day = 30;
			break;
		case 2 :
			if( ( (year % 4 == 0) && ( year % 100 != 0) ) || (year % 400 == 0) )
				day = 29;
			else				
				day = 28;			

			break;
	}
	return day;
}

function get_current_date()
{
	var currentDate = new Date()
	var year	= currentDate.getFullYear();
	var mon		= currentDate.getMonth()+1;
	var days	= currentDate.getDate();

	var day		= (days < 10 ? "0" : "") + days;
	var month	= (mon < 10 ? "0" : "") + mon;

	var curDate	= year + "-" + month + "-" + day;

	return curDate;
}

function get_last_date (month, year, format)
{
	var int_d = new Date(year, month, 1); 
	var d = new Date(int_d - 1).getDate();

	if (format == "day")
	{
		return d = new Date(int_d - 1).getDate();
	}
	else
	{
		return full_date = (year + "-" + month + "-" + d);
	}
}

function IsDateGreater(DateValue1, DateValue2)
{
	var DaysDiff;

	Date1 = new Date(DateValue1);
	Date2 = new Date(DateValue2);

	DaysDiff = Math.floor((Date1.getTime() - Date2.getTime()) / (1000 * 60 * 60 * 24));

	alert(DaysDiff);

	if (DaysDiff > 0)
		return true;
	else
		return false;
}

function IsDateLess(DateValue1, DateValue2)
{
	var DaysDiff;

	Date1 = new Date(DateValue1);
	Date2 = new Date(DateValue2);

	DaysDiff = Math.floor((Date1.getTime() - Date2.getTime()) / (1000 * 60 * 60 * 24));

	if (DaysDiff <= 0)
		return true;
	else
		return false;
}

function IsDateEqual(DateValue1, DateValue2)
{
	var DaysDiff;

	Date1 = new Date(DateValue1);
	Date2 = new Date(DateValue2);

	DaysDiff = Math.floor((Date1.getTime() - Date2.getTime()) / (1000 * 60 * 60 * 24));

	if (DaysDiff == 0)
		return true;
	else
		return false;
}

function getDateObject(dateString, dateSeperator)
{
	//This function return a date object after accepting 
	//a date string ans dateseparator as arguments
	var curValue=dateString;
	var sepChar=dateSeperator;
	var curPos=0;
	var cDate,cMonth,cYear;
	
	//extract day portion
	curPos=dateString.indexOf(sepChar);
	cDate=dateString.substring(0,curPos);
	
	//extract month portion 
	endPos=dateString.indexOf(sepChar,curPos+1); cMonth=dateString.substring(curPos+1,endPos);
	
	//extract year portion 
	curPos=endPos;
	endPos=curPos+5; 
	cYear=curValue.substring(curPos+1,endPos);
	
	//Create Date Object
	dtObject=new Date(cYear,cMonth,cDate); 
	return dtObject;
}

function isValidImage(imagename)
{
	imagefile_value = imagename;
	var checkimg = imagefile_value.toLowerCase();

	if (!checkimg.match(/(\.jpg|\.gif|\.png|\.JPG|\.GIF|\.PNG|\.jpeg|\.JPEG)$/))
	{
		return false;
	}
	else
	{
		return true;
	}
}

function isValidCSV(fld)  
{  
    var valid_extensions = /(.csv|.CSV)$/i; 
	if(fld.value) {  
        if (valid_extensions.test(fld.value)){  
             return true;  
         } else {  
		     alert("File format error!");
             return false;  
         }  
     } else {  
	     alert("CSV File required!");
         return false;  
     }  
}  

function isValidUrl(input, mesg)
{
	var url = input.value;
	if (input.length != 0)
	{
		if (!url.match(/^(((http|ftp|https):\/\/)|www\.)[\w\-_]*(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#!]*[\w\-\@?^=%&amp;/~\+#])?$/))
		{
			alert (mesg);
			input.focus();
			return false;
		}
	}

	return true;
}

function trim(s)
{
	return rtrim(ltrim(s));
}

function ltrim(s)
{
	var l=0;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	return s.substring(l, s.length);
}

function rtrim(s)
{
	var r=s.length -1;
	while(r > 0 && s[r] == ' ')
	{	r-=1;	}
	return s.substring(0, r+1);
}

function check_editor_content(fckInstance, mesg)
{
	editorInstance	= FCKeditorAPI.GetInstance(fckInstance);
	var content		= escape(editorInstance.GetXHTML());
	content			= url_decode(content);
	if (trim(content).length == 0 || content == "<br>" || content == "<br />" || content == "<br type=\"_moz\" />" || content == "&nbsp;")
	{
		alert(mesg);
		return false;
	}
	return true;
}
	
function url_decode(str)
{
	str=str.replace(new RegExp('\\+','g'),' ');
	return unescape(str);
}

function check_ckeditor_content(ckInstance, mesg)
{
	var content = CKEDITOR.instances[ckInstance.name].getData();
	
	content			= url_decode(content);
	if (trim(content).length == 0 || content == "<br>" || content == "<br />" || content == "<br type=\"_moz\" />" || content == "&nbsp;")
	{
		alert(mesg);
		return false;
	}
	return true;
}

function url_decode(str)
{
	str=str.replace(new RegExp('\\+','g'),' ');
	return unescape(str);
}

function url_encode(str)
{
	str=escape(str);
	str=str.replace(new RegExp('\\+','g'),'%2B');
	return str.replace(new RegExp('%20','g'),'+');
}




 function check_website(input, mesg)
{
 var url = input.value;
 if (input.length != 0)
 {  
  if (!url.match(/^(((http|ftp|https):\/\/)|www\.)[\w\-_]*(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#!]*[\w\-\@?^=%&amp;/~\+#])?$/))
  {
   alert (mesg);
   input.focus();
   return false;
  }
 }

 return true;
}

function check_fbpost(input, mesg)
{
	 var url = input.value;
	 if (input.length != 0)
	 {  
	  if (!url.match(/^(http|https):\/\/(www\.)?facebook\.com\/stagsource\/posts\/(\d)+$/))
	  {
	   alert (mesg);
	   input.focus();
	   return false;
	  }
	 }
	
	 return true;
}

function check_twitterpost(input, mesg)
{
	 var url = input.value;
	 if (input.length != 0)
	 {  
	  if (!url.match(/^(http|https):\/\/(www\.)?twitter\.com\/.*(\d)+$/))
	  {
	   alert (mesg);
	   input.focus();
	   return false;
	  }
	 }
	
	 return true;
}

function check_instagrampost(input, mesg)
{
	 var url = input.value;
	 if (input.length != 0)
	 {  
	  if (!url.match(/^(http|https):\/\/(www\.)?instagram\.com\/(\w)+\/(\w)+$/))
	  {
	   alert (mesg);
	   input.focus();
	   return false;
	  }
	 }
	
	 return true;
}