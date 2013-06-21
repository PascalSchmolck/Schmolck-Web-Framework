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
	
	/*
	 * SCROLLUP
	 */
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	}); 
	$('.scrollup').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 600);
		return false;
	});

});