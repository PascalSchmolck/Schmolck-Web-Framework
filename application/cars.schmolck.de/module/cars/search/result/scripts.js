$(document).ready(function() {			
	//alert(window.location.hash);
	
	/*
	 * LINKS
	 */
	$('#SchmolckID .links a').each(function() {
		// - action
		$(this).click(function() {
			SchmolckID_send($(this).data('mode'));
			return false;
		});
	});
		
	/*
	* AJAX
	*/
	SchmolckID_send = function(strMode) {
		Schmolck_Framework_Helper_Api({
			url: 'SchmolckURL',
			id: 'SchmolckID',
			data: 'mode='+strMode
		});
	}

});