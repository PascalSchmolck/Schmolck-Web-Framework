$(document).ready(function() {			
	/*
	* ACTION
	*/
	$('#SchmolckID input[type=submit]').click(function() {
		SchmolckID_send();
		return false;
	});
		
	/*
	* AJAX
	*/
	SchmolckID_send = function() {
		var strData = $('#SchmolckID form').serialize();
		Schmolck_Framework_Helper_Element({
			url: 'SchmolckURL',
			id: 'SchmolckID',
			data: strData
		});
	}
});