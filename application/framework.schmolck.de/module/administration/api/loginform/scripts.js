$(document).ready(function() {			
	/*
	* ACTION
	*/
//	$('#SchmolckID_submit').click(function() {
//		SchmolckID_send();
//		return false;
//	});
		
	/*
	* AJAX
	*/
	SchmolckID_send = function() {
		var strData = $('#SchmolckID').serialize();
		Schmolck_Framework_Helper_Element({
			url: 'SchmolckURL',
			id: 'SchmolckID',
			data: strData
		});
	};
});