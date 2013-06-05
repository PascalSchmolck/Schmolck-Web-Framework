$(document).ready(function() {		
	/*
	 * NAVIGATION
	 */
	$('#navigation .button').click(function() {
		$('#navigation .button').hide();
		$('#navigation ul').slideDown('slow');
	});
	
	/*
	 * ANIMATION
	 */
	$('.slideDown').slideDown('slow');

});