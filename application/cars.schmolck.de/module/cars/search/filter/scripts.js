$(document).ready(function() {			
	
	/*
	* ACTION
	*/
	$('#SchmolckID select').change(function() {
		SchmolckID_send();
		return false;
	});
	
	$('#SchmolckID input[type=reset]').click(function() {
		$('#SchmolckID input[name=reset]').val('true');
		SchmolckID_send();
		return false;
	});
		
	/*
	* AJAX
	*/
	SchmolckID_send = function() {
		var strData = $('#SchmolckID form').serialize();
		Schmolck_Framework_Helper_Api({
			url: 'SchmolckURI',
			id: 'SchmolckID',
			data: strData,
			success: function() {
				window.location.hash = 'SchmolckAPI';
			}
		});
	}
});