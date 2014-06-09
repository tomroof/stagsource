// JavaScript Document

// Select Box
$(function () {
			$("#1").selectbox();
			$("#2").selectbox();
			$("#3").selectbox();
			$("#4").selectbox();
			$("#5").selectbox();
			$("#6").selectbox();
			$("#7").selectbox();
			$("#8").selectbox();
			$("#9").selectbox();
			$("#10").selectbox();
			
		});

// Form Validations
function validateprojectdetails() {
	
var field_name = $("#name").val();
var field_email = $("#email").val();
var field_phone = $("#phone").val();


	 if(!checkName(field_name)) {
		 alert('Please enter a valid name');
		 return false;
		 
	 }
	 
	 if(!(IsEmail(field_email))) {
		 alert('Please enter a valid email address ');
		 return false;
	 }

	
if(!(validatePhone(field_phone))) {
		alert('Please Enter a Valid Phone Number');
		return false;
	}

	
	
}

function checkName(name) {
  var regex = /^[A-Za-z0-9 ]{1,50}$/;
  return regex.test(name);
}

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}




function validatePhone(txtPhone) {

    var filter = /^[0-9-+]+$/;
	if(filter.test(txtPhone)) {
		return true;
	} else {
		return false;	
	}
}