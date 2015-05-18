$(document).ready(function() {		
	/*
	 * NAVIGATION
	 */
	$('.navigation .helper').click(function() {
		$('.navigation .helper').hide();
		$('.navigation .list').slideDown('fast');
		return false;
	});
	
	/*
	 * ANIMATION
	 */
	$('.slideDown').slideDown('slow');
	
});