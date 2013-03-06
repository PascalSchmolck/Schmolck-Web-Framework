/**
 * Schmolck_Framework_Api_Element
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
function Schmolck_Framework_Api_Element(parameter) {
	$.ajax({
		type: "POST",
		url: parameter.url,
		data: '_ajax=true&_id=' + parameter.id + '&' + parameter.data,
		success: function (data) {
			/*
			 * DATA
			 */
			$('#' + parameter.id).fadeOut('fast', function () {
				$('#' + parameter.id).replaceWith(data);
			});			
			
			/*
			 * ACTION
			 */
			if (parameter.success instanceof Function) {
				parameter.success(data);
			}
		}
	});		
}