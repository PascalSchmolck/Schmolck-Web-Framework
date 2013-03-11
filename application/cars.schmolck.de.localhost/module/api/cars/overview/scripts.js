$(document).ready(function() {			
	/*
	* LINKS
	*/
	$('#SchmolckID .item').each(function() {
		$(this).click(function() {
			window.location.href = $(this).data('link');
		});
	});
		
	/*
	* AJAX
	*/
	SchmolckID_send = function() {
		var strData = $('#SchmolckID').serialize();
		Schmolck_Framework_Api_Element({
			url: 'SchmolckURI',
			id: 'SchmolckID',
			data: strData
		});
	}
});