
/**
 * Schmolck_Framework_Ajax
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */

var timeout;

function Schmolck_Framework_Ajax(parameter){
	/*
	 * INIT
	 */
	clearTimeout(timeout);
	var url = Schmolck_Framework_AjaxParameterCheck(parameter.url);

	/*
	 * ANIMATION
	 */
	Schmolck_Framework_AjaxAnimationStart(parameter.id);

	/*
	 * AJAX
	 */
	$.ajax({
		type: 'POST',
		url: url,
		data: parameter.data + '&ajax=true&name=' + parameter.id,
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
			
			/*
			 * ANIMATION
			 */
			Schmolck_Framework_AjaxAnimationStop(parameter.id);			
		}
	});
}

function Schmolck_Framework_AjaxTimeout(name, url, post, duration){
	//*******
	// CLEAN
	//*******
	if(timeout) {
		clearTimeout(timeout);
		timeout = null;
	}
	//******
	// CALL
	//******
	timeout = setTimeout("Schmolck_Framework_Ajax('" + name + "', '" + url + "', '" + post + "')", duration);
}

function Schmolck_Framework_AjaxAnimationStart(name){
	/*
	 * ANIMATION
	 */
	// - fadeout
	$('#'+name).parent().fadeTo('fast', 0.75);
}

function Schmolck_Framework_AjaxAnimationStop(name){
	/*
	 * ANIMATION
	 */
	// - fadein
	$('#'+name).parent().fadeTo('fast', 1);
}

function Schmolck_Framework_AjaxParameterCheck(url){
	if (url == null || url == '')
	{
		url = window.location;
	}
	return url;
}