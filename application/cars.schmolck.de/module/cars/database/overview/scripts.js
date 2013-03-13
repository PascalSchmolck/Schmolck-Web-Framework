$(document).ready(function() {			
	/*
	* LINKS
	*/
	$('#SchmolckID .item').each(function() {
		$(this).click(function() {
			window.location.href = $(this).data('link');
		});
	});

});