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
	 * @param string $strClass
	 * @param string $strKey
	 * @param mixed $mixedValue
	 */
	static public function store($strClass, $strKey, $mixedValue) {
		$_SESSION[md5($_SERVER['PHP_SELF'])][$strClass][$strKey] = $mixedValue;
	}

	/**
	 * Restore value from memory
	 * 
	 * @param string $strKey
	 */
	static public function restore($strClass, $strKey) {
		return $_SESSION[md5($_SERVER['PHP_SELF'])][$strClass][$strKey];
	}

}