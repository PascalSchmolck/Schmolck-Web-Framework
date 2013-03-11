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
		Schmolck_Framework_Helper_Api({
			url: 'SchmolckURI',
			id: 'SchmolckID',
			data: strData
		});
	}
	
	/*
	 * REDIRECT
	 */
	// - will be set in AJAX call if language successfully	changed
	if ('SchmolckVAR1' == 'true') {
		window.location.href = window.location;
	}
	
});