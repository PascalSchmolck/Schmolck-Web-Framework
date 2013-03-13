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
	
	/*
	 * SCROLLING
	 */
//	var bProcessed = false;
//	$(window).scroll(function () {
//		if(!bProcessed) {
//			if ($(window).height() + $(window).scrollTop() == $(document).height()) {
//				bProcessed = true;
//				SchmolckID_send();
//				return false;
//			}
//		}
//	});

});