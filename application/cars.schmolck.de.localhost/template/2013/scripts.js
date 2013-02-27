/*
 * CONFIGURATION
 */
requirejs.config({
	baseUrl: 'lib/js'
});


/*
 * MAIN
 */
requirejs(['schmolck/framework/api/element'], function(element) {
	element({
		id: 'langswitcher',		
		name: 'langswitcher',
		data: ''
	});
});