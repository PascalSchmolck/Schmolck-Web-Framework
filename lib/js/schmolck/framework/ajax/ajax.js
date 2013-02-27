
/**
 * Schmolck_Framework_Ajax
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */

var timeout;

function Schmolck_Framework_Ajax(name, url, post){
	/*
	 * INIT
	 */
	clearTimeout(timeout);

	/*
	 * CHECK
	 */
	url = Schmolck_Framework_AjaxParameterCheck(url);

	/*
	 * ANIMATION
	 */
	Schmolck_Framework_AjaxAnimationStart(name);

	/*
	 * AJAX
	 */
	$.ajax({
		type: 'POST',
		url: url,
		data: post+'&ajax=true',
		async: true,
		success: function(data) {
			// - url?
			if (data.indexOf('ajax:redirect:http') > -1) {
				//----------
				// REDIRECT
				//----------	
				var url = data.substr(14);
				window.location.href = url;
				return;
			} else {
				//******
				// DATA
				//******
				$(name).html($(data).find(name).html());
			}
			
			//***********
			// ANIMATION
			//***********
			Schmolck_Framework_AjaxAnimationStop(name);			
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
	$(name).parent().fadeTo('fast', 0.75);
}

function Schmolck_Framework_AjaxAnimationStop(name){
	/*
	 * ANIMATION
	 */
	// - fadein
	$(name).parent().fadeTo('fast', 1);
}

function Schmolck_Framework_AjaxParameterCheck(url){
	if (url == null || url == '')
	{
		url = window.location;
	}
	return url;
}