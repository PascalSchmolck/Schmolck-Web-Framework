$(document).ready(function() {			
	
	/*
	* ACTION
	*/
	$('#SchmolckID select').change(function() {
		SchmolckID_closeResult();
		SchmolckID_send();
		return false;
	});
	
	$('#SchmolckID input[type=reset]').click(function() {
		$('#SchmolckID input[name=reset]').val('true');
		SchmolckID_send();
		return false;
	});
	
	$('#SchmolckID input[type=button]').click(function() {
		SchmolckID_reloadResult();
		$(this).hide();
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
	 * RESULT
	 */
	SchmolckID_closeResult = function() {
		if ('SchmolckRESULTID' != '') {
			var objResult = $('#SchmolckRESULTID');
			objResult.slideUp(1000);
		}
	}
	SchmolckID_reloadResult = function() {
		if ('SchmolckRESULTID' != '') {
			Schmolck_Framework_Helper_Api({
				url: 'cars/api/result',
				id: 'SchmolckRESULTID'
			});
			var objResult = $('#SchmolckRESULTID');
			if (objResult) {
				$('html, body').animate({scrollTop: objResult.offset().top-20  }, 1000);
			}
		}
	}	
	
	/*
	 * RELOAD
	 */
	if ('SchmolckRELOAD' == 'true') {
		SchmolckID_reloadResult();
	}
});