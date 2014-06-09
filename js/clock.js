/********************************************************************************************
Author 		: V V VIJESH
Date		: 25-July-2012
Purpose		: Common functions
Updated By	: 
Date		: 
********************************************************************************************/
function clock()
{
	//var monthArray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	var monthArray = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	//var dayArray	= new Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
	var dayArray	= new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
	
	var thetime=new Date();
	var nhours=thetime.getHours();
	var nmins=thetime.getMinutes();
	var nsecn=thetime.getSeconds();
	var nday=thetime.getDay();
	var nmonth=thetime.getMonth();
	var ntoday=thetime.getDate();
	var nyear=thetime.getYear();
	var AorP=" ";
	
	if (nhours>=12)
		AorP="P.M";
	else
		AorP="A.M";
	
	if (nhours>=13)
		nhours-=12;
	
	if (nhours==0)
	   nhours=12;
	
	if (nsecn<10)
	 nsecn="0"+nsecn;
	
	if (nmins<10)
	 nmins="0"+nmins;
	
	nday	= dayArray[nday];
	nmonth	= monthArray[nmonth];
	
	if (nyear<=99)
	  nyear= "19"+nyear;
	
	if ((nyear>99) && (nyear<2000))
	 nyear+=1900;
	
	//document.getElementById('clock').innerHTML=nhours+":"+nmins+":"+nsecn+" "+AorP+" "+nday+", "+ntoday+"-"+nmonth+"-"+nyear;
	document.getElementById('clock').innerHTML= nday + ", " + nmonth + " " + ntoday + ", " + nyear + " " + nhours+":"+nmins+":"+nsecn+" "+AorP;
	
	setTimeout('clock()',1000);
}

function clientClock()
{
	//var monthArray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	var monthArray = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	//var dayArray	= new Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
	var dayArray	= new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
	
	var thetime=new Date();
	var nhours=thetime.getHours();
	var nmins=thetime.getMinutes();
	var nsecn=thetime.getSeconds();
	var nday=thetime.getDay();
	var nmonth=thetime.getMonth();
	var ntoday=thetime.getDate();
	var nyear=thetime.getYear();
	var AorP=" ";
	
	if (nhours>=12)
		AorP="PM";
	else
		AorP="AM";
	
	if (nhours>=13)
		nhours-=12;
	
	if (nhours==0)
	   nhours=12;
	
	if (nsecn<10)
	 nsecn="0"+nsecn;
	
	if (nmins<10)
	 nmins="0"+nmins;
	
	nday	= dayArray[nday];
	nmonth	= monthArray[nmonth];
	
	if (nyear<=99)
	  nyear= "19"+nyear;
	
	if ((nyear>99) && (nyear<2000))
	 nyear+=1900;
	
	//document.getElementById('clock').innerHTML=nhours+":"+nmins+":"+nsecn+" "+AorP+" "+nday+", "+ntoday+"-"+nmonth+"-"+nyear;
	if(document.getElementById('award_our_time'))
	{
		document.getElementById('award_our_time').innerHTML= '<b>' + nhours+":"+nmins+" "+" "+AorP + '</b>';
	}
	else if(document.getElementById('our_time'))
	{
		document.getElementById('our_time').innerHTML= '<b>' + nhours+":"+nmins+" "+" "+AorP + '</b>';
	}
	setTimeout('clientClock()',1000);
}

// Show the time left from the given time time_left('2012-04-05 20:15:24');
function time_left(date_time)
{
	var accuracy 	= 3;
	var sectext 	= "s ";
	var mintext		= "m ";
	var hrtext		= "h ";
	var dytext		= "d ";
	var mnthtext	= "m ";
	var yrtext		= "y ";
	
	var date_time_array = date_time.split(' ');
	var date_array = date_time_array[0].split('-');
	var time_array = date_time_array[1].split(':');
	
	var year	= parseInt(date_array[0]); // in what year will your target be reached?
	var month	= (parseInt(date_array[1])-1); // value between 0 and 11 (0=january,1=february,...,11=december)
	var day		= parseInt(date_array[2]); // between 1 and 31
	var hour	= parseInt(time_array[0]); // between 0 and 24
	var minute	= parseInt(time_array[1]); // between 0 and 60
	var second	= parseInt(time_array[2]); // between 0 and 60
	var end		= new Date(year, month, day, hour, minute, second);
	var now		= new Date();
	
	if (now.getYear() < 1900) yr = now.getYear() + 1900;
	var sec = second - now.getSeconds();
	var min = minute - now.getMinutes();
	var hr = hour - now.getHours();
	var dy = day - now.getDate();
	var mnth = month - now.getMonth();
	var yr = year - yr;
	var daysinmnth = 32 - new Date(now.getYear(), now.getMonth(), 32).getDate();
	if (sec < 0)
	{
		sec = (sec + 60) % 60;
		min--;
	}
	if (min < 0)
	{
		min = (min + 60) % 60;
		hr--;
	}
	if (hr < 0)
	{
		hr = (hr + 24) % 24;
		dy--;
	}
	if (dy < 0)
	{
		dy = (dy + daysinmnth) % daysinmnth;
		mnth--;
	}
	if (mnth < 0)
	{
		mnth = (mnth + 12) % 12;
		yr--;
	}
				
	var counter = 0;
	var output	= '';
	
	if (yr > 0)
	{
		counter++;
		if(counter <= accuracy)
		{
			output = output + ' ' + yr + yrtext;
		}
	}
	
	if (mnth > 0)
	{
		counter++;
		if(counter <= accuracy)
		{
			output = output + ' ' + mnth + mnthtext;
		}
	}
	
	if (dy > 0)
	{
		counter++;
		if(counter <= accuracy)
		{
			output = output + ' ' + dy + dytext;
		}
	}
	
	if (hr > 0)
	{
		counter++;
		if(counter <= accuracy)
		{
			output = output + ' ' + hr + hrtext;
		}
	}
	
	if (min > 0)
	{
		counter++;
		if(counter <= accuracy)
		{
			output = output + ' ' + min + mintext;
		}
	}
	
	if (sec > 0)
	{
		counter++;
		if(counter <= accuracy)
		{
			output = output + ' ' + sec + sectext;
		}
	}
	document.getElementById("time_left").innerHTML = output;
	timerID = setTimeout("time_left('" + date_time + "')", 1000);
}
