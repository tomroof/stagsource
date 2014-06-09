/********************************************************************************************

Author 		: V V VIJESH

Date		: 16-June-2010

Purpose		: 

Updated By	: 

Date		: 

********************************************************************************************/

$(function() {

	$("#postcode").autoSuggest({

		ajaxFilePath : "ajax_postcode_latlgn_suggest.php", 
		ajaxParams	 : "dummydata=dummyData", 
		autoFill	 : false, 
		iwidth		 : "auto",
		opacity		 : "0.9",
		ilimit		 : "10",
		idHolder	 : "id-holder",
		match		 : "starts"

	});

});