$(document).ready(function() {			
	
	/*
	* ACTION
	*/
	$('#SchmolckID select').change(function() {
		SchmolckID_closeList();
		SchmolckID_send();
		return false;
	});
	
	$('#SchmolckID input[type=reset]').click(function() {
		$('#SchmolckID input[name=reset]').val('true');
		SchmolckID_send();
		return false;
	});
	
	$('#SchmolckID input[type=button]').click(function() {
		window.location.reload();
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
	 * RESET
	 */
	if ('SchmolckRELOAD' == 'true') {
		window.location.reload();
	}
	
	/*
	 * LIST
	 */
	SchmolckID_closeList = function() {
		if ('SchmolckLIST' != '') {
			var objList = $('#SchmolckLIST');
			objList.slideUp(1000);
		}
	}
});