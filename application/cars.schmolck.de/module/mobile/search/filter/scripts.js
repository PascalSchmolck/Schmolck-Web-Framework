$(document).ready(function() {			
	
	/*
	* ACTION
	*/
	$('#SchmolckID select').change(function() {
		// - reset model selection if brand changed
		if ($(this).attr('name') === 'brand') {
			$('#SchmolckID select[name=model]').val('all');
		}
		SchmolckID_send();
		return false;
	});
	
	$('#SchmolckID input[type=reset]').click(function() {
		$('#SchmolckID input[name=reset]').val('true');
		SchmolckID_send();
		return false;
	});
		
	/*
	* AJAX
	*/
	SchmolckID_send = function() {
		var strData = $('#SchmolckID form').serialize();
		Schmolck_Framework_Helper_Api({
			url: 'SchmolckURL',
			id: 'SchmolckID',
			data: strData,
			success: function () {
				SchmolckID_reloadResult();
			}
		});
	};
	
	/*
	 * RESULT
	 */
	SchmolckID_reloadResult = function() {
		var objResult = $('#SchmolckRESULTID');
		if (objResult) {
			Schmolck_Framework_Helper_Api({
				url: 'mobile/search/result',
				id: 'SchmolckRESULTID'
			});
		}
	};	
});