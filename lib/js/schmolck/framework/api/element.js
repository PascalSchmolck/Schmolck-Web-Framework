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
		data: 'ajax=true&' + parameter.data,
		success: function (data) {
			$('#' + parameter.id).fadeOut('fast', function () {
				$('#' + parameter.id).replaceWith(data);
			});			
		}
	});		
}