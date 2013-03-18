<?php

/**
 * Schmolck_Tool_Memory
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Tool_Memory {

	/**
	 * Store value to memory
	 * 
	 * @param string $strDomain
	 * @param string $strKey
	 * @param mixed $mixedValue
	 */
	static public function store($strDomain, $strKey, $mixedValue) {
		$_SESSION[md5($_SERVER['PHP_SELF'])][$strDomain][$strKey] = $mixedValue;
	}

	/**
	 * Restore value from memory
	 * 
	 * @param string $strDomain
	 * @param string $strKey
	 */
	static public function restore($strDomain, $strKey) {
		return $_SESSION[md5($_SERVER['PHP_SELF'])][$strDomain][$strKey];
	}
	
	/**
	 * Automatic re/storing of value
	 * 
	 * @param type $strDomain
	 * @param type $strKey
	 * @param type $strDefault
	 * @return string stored or default value
	 */
	static public function auto($strDomain, $strKey, $strDefault) {
		if ($strDefault != '') {
			self::store($strDomain, $strKey, $strDefault);
			return $strDefault;
		} else {
			return self::restore($strDomain, $strKey);
		}
	}

}