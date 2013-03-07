$(document).ready(function() {			
	/*
	* ACTION
	*/
	$('#SchmolckID select').change(function() {
		SchmolckID_send();
	});
		
	/*
	* AJAX
	*/
	SchmolckID_send = function() {
		var strData = $('#SchmolckID').serialize();
		Schmolck_Framework_Api_Element({
			url: 'SchmolckURI',
			id: 'SchmolckID',
			data: strData,
			success: function() {
				window.location.href = window.location;
			}
		});
	}
});