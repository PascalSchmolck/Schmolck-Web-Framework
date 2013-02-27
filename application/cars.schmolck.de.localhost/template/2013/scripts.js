$(document).ready(function() {
	/*
	 * LANGSWITCHER
	 */	
	$.ajax({
		type: "POST",
		url: 'api/element/langswitcher',
		data: 'parameter=test',
		success: function (data) {
			$('#langswitcher').replaceWith(data);
		}
	});				
	
});