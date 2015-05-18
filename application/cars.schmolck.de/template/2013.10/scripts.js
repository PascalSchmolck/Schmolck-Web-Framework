$(document).ready(function() {		
	/*
	 * NAVIGATION
	 */
	$('.menu .helper').click(function() {
		$('.menu .helper').hide();
		$('.menu .list').slideDown('fast');
		return false;
	});
	
	/*
	 * ANIMATION
	 */
	$('.slideDown').slideDown('slow');
	
});