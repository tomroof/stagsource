var count = 0;
function reloadCaptcha()
{
	frm = document.getElementById("simple_captcha");
	opacity("simple_captcha", 100, 0, 300);
	count++;
	frm.src = "<?php echo URI_LIBRARY; ?>captcha/CaptchaSecurityImages.php?" + count;
	opacity("simple_captcha", 0, 100, 300);
}
// Change opacity
function opacity(id, opacStart, opacEnd, millisec)
{
	//speed for each frame
	var speed = Math.round(millisec / 100);
	var timer = 0;
	//determine the direction for the blending, if start and end are the same nothing happens
	if(opacStart > opacEnd)
	{
		for(i = opacStart; i >= opacEnd; i--)
		{
			setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
			timer++;
		}
	}
	else if(opacStart < opacEnd)
	{
		for(i = opacStart; i <= opacEnd; i++)
		{
			setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
			timer++;
		}
	}
}

// Change the opacity for different browsers
function changeOpac(opacity, id)
{
	var object = document.getElementById(id).style;
	object.opacity = (opacity / 100);
	object.MozOpacity = (opacity / 100);
	object.KhtmlOpacity = (opacity / 100);
	object.filter = "alpha(opacity=" + opacity + ")";
} 
$(document).ready(function() {
	reloadCaptcha();
});