/**
 * Schmolck_Framework_Helper_Api
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
function Schmolck_Framework_Helper_Api(parameter) {
	/*
	 * INITIALISATION
	 */
	var objElement = $('#' + parameter.id);
	var objParent = $('#' + parameter.id).parent();
	
	/*
	 * AJAX
	 */
	objElement.fadeTo('fast', 0.25, function () {	
		objParent.addClass('loading');
		
		$.ajax({
			type: "POST",
			url: parameter.url,
			data: '_ajax=true&_id=' + parameter.id + '&' + parameter.data,
			success: function (data) {
				/*
				 * DATA
				 */
				objElement.replaceWith(data);				
				objElement.fadeTo('fast', 1);
				objParent.removeClass('loading');

				/*
				 * ACTION
				 */
				if (parameter.success instanceof Function) {
					parameter.success(data);
				}
			}
		});			
	});		
}