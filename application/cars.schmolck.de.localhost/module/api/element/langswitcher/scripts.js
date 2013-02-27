/*
 * DEFINITION
 */
alert('TEST');
define(['jquery'], function($) {	
	$('#langswitcher').change(function () {
		$.ajax({
			type: "POST",
			url: 'api/data/setLanguage',
			data: 'ajax=true&parameter=test',
			success: function (data) {
				var json = $.parseJSON(data);
				alert('Status: ' + json.status + ' Data: ' + json.data);
			}
		});				
	});
});