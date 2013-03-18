$(document).ready(function() {			
	//alert(window.location.hash);
	
	/*
	 * SCROLLING
	 */
	$.scrollTo('a[name=' + window.location.hash.replace('#', '') + ']');
	
	/*
	 * LINKS
	 */
	$('#SchmolckID .item').each(function() {
		$(this).click(function() {
			window.location.hash = '#' + $(this).data('name');
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