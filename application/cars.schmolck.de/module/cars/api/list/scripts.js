$(document).ready(function() {			
	//alert(window.location.hash);
	
	/*
	 * SCROLLING
	 */
	// - scroll to previous position
	var hash = window.location.hash.replace('#', '');
	if (hash != '') {
		$('html, body').stop().animate({
			scrollTop: window.location.hash.replace('#', '')
		}, 500);
		window.location.hash = '';
	}
	
	/*
	 * LINKS
	 */
	$('#SchmolckID .item').each(function() {
		// - animation
		$(this).removeClass('loading');

		// - action
		$(this).click(function() {
			// - animation
			$(this).addClass('loading');
			// - save scroll position
			window.location.hash = $(window).scrollTop();			
			// - open link
			window.location.href = $(this).data('link');
		});
	});
	
	/*
	* ACTION
	*/
	$('#SchmolckID .loadlink .button').click(function() {
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
			data: strData
		});
	}

});