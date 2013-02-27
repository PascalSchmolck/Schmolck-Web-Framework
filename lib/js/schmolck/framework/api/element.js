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
		url: 'api/element/' + parameter.name,
		data: parameter.data,
		success: function (data) {
			$('#' + parameter.id).replaceWith(data);
		}
	});	
}