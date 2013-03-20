$(document).ready(function() {			
	/*
	* ACTION
	*/
	$('#SchmolckID img').click(function() {
		SchmolckID_loadNext($(this).data('next'));
		return false;
	});
		
	/*
	* AJAX
	*/
	SchmolckID_loadNext = function(strNext) {
		Schmolck_Framework_Helper_Api({
			url: 'SchmolckURI',
			id: 'SchmolckID',
			data: 'number=' + strNext
		});
	}
});