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
		var strData = $('#SchmolckID').serialize();
		Schmolck_Framework_Helper_Api({
			url: 'SchmolckURI',
			id: 'SchmolckID',
			data: strData
		});
	}
});