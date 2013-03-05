
/**
 * Schmolck_Framework_Ajax
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */

function Schmolck_Framework_Ajax(parameter){
	/*
	 * CHECK
	 */
	if (parameter.url == null || parameter.url == '') {
		parameter.url = window.location;
	}

	/*
	 * AJAX
	 */
	$.ajax({
		type: 'POST',
		url: parameter.url,
		data: parameter.data + '&_ajax=true&_id=' + parameter.id,
		async: true,
		success: function(data) {
			/*
			 * DATA
			 */
			$('#'+parameter.id).replaceWith(data);

			/*
			 * ACTION
			 */
			if (parameter.success != 'undefined') {
				parameter.success(data);
			}
		}
	});
}