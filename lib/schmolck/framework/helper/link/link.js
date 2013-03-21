
/**
 * Schmolck_Framework_Helper_Link
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */

function Schmolck_Framework_Helper_Link(strString) {

	var map = []
	var tmp = "abcdefghijklmnopqrstuvwxyz"
	var strResult = ""

	for (j = 0; j < tmp.length; j++) {
		var x = tmp.charAt(j);
		var y = tmp.charAt((j + 13) % 26)
		map[x] = y;
		map[x.toUpperCase()] = y.toUpperCase()
	}

	for (j = 0; j < strString.length; j++) {
		var c = strString.charAt(j)
		strResult += (c >= 'A' && c <= 'Z' || c >= 'a' && c <= 'z' ? map[c] : c)
	}
	
	window.location = strResult;
}