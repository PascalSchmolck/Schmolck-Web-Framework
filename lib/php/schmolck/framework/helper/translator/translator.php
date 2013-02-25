<?php

/**
 * Schmolck_Framework_Helper_Translator
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Translator {

	/**
	 * Translate given string
	 * 
	 * @param string $string to translate
	 * @return string translated string
	 */
	public function _($string) {
		return "&lt;translate&gt;$string&lt;/translate&gt;";
	}

}