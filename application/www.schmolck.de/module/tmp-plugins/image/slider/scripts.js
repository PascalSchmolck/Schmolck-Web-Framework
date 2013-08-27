$(document).ready(function() {		
	
	var arrSchmolckIDImages = SchmolckIMAGES;
	var timeout;
	
	startSlider = function() {
		timeout = setTimeout('$(\'#SchmolckID img\').click()', SchmolckTIMEOUT);
	};
	
	stopSlider = function () {
		clearTimeout(timeout);
	};

	/*
	* ACTION
	*/
	$('#SchmolckID img').click(function() {

		/*
		 * PREPARATION
		 */
		var nNumber = parseInt($(this).data('next'));
		var nNext = nNumber + 1;
		
		/*
		 * CHECK
		 */
		if (nNext >= arrSchmolckIDImages.length) {
			nNext = 0;
		}

		$(this).attr('src', arrSchmolckIDImages[$(this).data('next')]);
		$(this).data('next', nNext);
		
		stopSlider();
		startSlider();
	});
	
	startSlider();

});