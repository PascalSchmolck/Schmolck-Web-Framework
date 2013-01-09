<?php
/**
 * Schmolck_Framework_Tmp
 * 
 * @package Schmolck Framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Tmp 
{
	const PATH = 'tmp';
	
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
}