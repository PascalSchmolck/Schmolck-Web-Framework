/**
 * Schmolck_Framework_Helper_Api
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 * 
 * @param {array} parameter various parameters
 */
function Schmolck_Framework_Helper_Api(parameter) {
	/*
	 * INITIALISATION
	 */
	var objElement = $('#' + parameter.id);
	
	/*
	 * ANIMATION
	 */
	objElement.addClass('loading');
	objElement.fadeTo(1000, 0.5);
		
	/*
	 * AJAX
	 */
	$.ajax({
		type: "POST",
		url: parameter.url,
		data: '_ajax=true&_id=' + parameter.id + '&' + parameter.data,
		success: function (data) {
		
			/*
			 * DATA
			 */
			objElement.replaceWith(data);				

			/*
			 * ACTION
			 */
			if (parameter.success instanceof Function) {
				parameter.success(data);
			}
		}
	});			
}