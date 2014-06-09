
function clearText(thefield){
    if(thefield.defaultValue==thefield.value)
        thefield.value = ""
}

function fillText(thefield){
    if(thefield.value=="")
        thefield.value=thefield.defaultValue
}



function clearText1(thefield){
   $(thefield).attr('placeholder','');
   if($(thefield).attr('value') == $(thefield).attr('val1'))
   {
   		$(thefield).attr('value','');
   }
}

function fillText1(thefield){
	$(thefield).attr('placeholder',$(thefield).attr('val1'));
}

function clearText2(thefield){
	if($(thefield).val() != "")
	{
		$('#hold_'+$(thefield).attr('id')).hide();	
	}
	else
	{
		$('#hold_'+$(thefield).attr('id')).show();		
	}
}

function fillText2(thefield){
	if($(thefield).val() != "")
	{
		$('#hold_'+$(thefield).attr('id')).hide();	
	}
	else
	{
		$('#hold_'+$(thefield).attr('id')).show();	
	}
}