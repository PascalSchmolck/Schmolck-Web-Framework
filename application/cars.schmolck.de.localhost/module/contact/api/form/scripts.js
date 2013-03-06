$(document).ready(function() {		
	/*
	* ACTION
	*/
	$('#SchmolckID input[type=submit]').click(function() {
		SchmolckID_submit();
		return false;
	});
		
	/*
	* AJAX
	*/
	SchmolckID_submit = function() {
		var strData = $('#SchmolckID').serialize();
		Schmolck_Framework_Api_Element({
			url: 'SchmolckURI',
			id: 'SchmolckID',
			data: strData
		});
	}
});