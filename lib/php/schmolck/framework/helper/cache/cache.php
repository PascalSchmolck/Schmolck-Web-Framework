<?php

/**
 * Schmolck_Framework_Helper_Cache
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Cache extends Schmolck_Framework_Helper {

	const PATH = 'tmp';
	const LIMIT = 3600;  // seconds

	public function __construct() {
		$this->cleanDir();
	}

	/**
	 * Get tmp file path for given name
	 * 
	 * @param string $strName file name
	 * @return string tmp file path
	 */
	public function getFilePath($strName) {
		return self::PATH . '/' . $strName;
	}

	/**
	 * Clean obsolete tmp files
	 */
	public function cleanDir() {
		$dir = new Schmolck_Tool_Dir();
		$dir->directory = self::PATH;
		$dir->deleteAllOlderThan(self::LIMIT);
	}

}