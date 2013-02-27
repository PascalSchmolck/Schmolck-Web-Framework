$(document).ready(function() {
	/*
	 * CHANGE
	 */
	$('#langswitcher').change(function () {
		$.ajax({
			type: "POST",
			url: 'api/data/setLanguage',
			data: 'language=test',
			success: function (data) {
				var json = $.parseJSON(data);
				alert('Status: ' + json.status + ' Data: ' + json.data);
			}
		});				
	});
});