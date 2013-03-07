/**
 * Schmolck_Framework_Api_Element
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
function Schmolck_Framework_Api_Element(parameter) {
	/*
	 * INITIALISATION
	 */
	var objElement = $('#' + parameter.id);
	var objParent = $('#' + parameter.id).parent();
	
	/*
	 * AJAX
	 */
	objParent.fadeTo('fast', 0.5, function () {	
		$.ajax({
			type: "POST",
			url: parameter.url,
			data: '_ajax=true&_id=' + parameter.id + '&' + parameter.data,
			success: function (data) {
				/*
				 * DATA
				 */
				objElement.replaceWith(data);				
				objParent.fadeTo('fast', 1);

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