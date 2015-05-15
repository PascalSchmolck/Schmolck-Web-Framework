<?php

/**
 * Schmolck_Tool_Validate
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 */
class Schmolck_Tool_Validate {

	/**
	 * Check if given string has proper e-mail address format
	 * 
	 * @param string $strString
	 * @return boolean
	 */
	static public function checkEmail($strString) {		
		return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $strString);
	}

}