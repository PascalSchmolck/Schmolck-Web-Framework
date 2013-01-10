<?php
/**
 * Schmolck_Framework_Tmp
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Tmp 
{
	const PATH = 'tmp';
	const LIMIT = 3600;		// seconds
	
	/**
	 * Get tmp file path for given name
	 * 
	 * @param string $strName file name
	 * @return string tmp file path
	 */
	static public function getFilePath($strName)
	{
		return self::PATH . '/' . $strName;
	}
	
	/**
	 * Clean obsolete tmp files
	 */
	static public function clean()
	{
		$dir = new Schmolck_Framework_Dir();
		$dir->directory = self::PATH;
		$dir->deleteAllOlderThan(self::LIMIT);		
	}
}