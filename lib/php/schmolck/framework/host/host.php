<?php
/**
 * Schmolck_Framework_Host
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Host 
{
	/**
	 * Get current host name
	 * 
	 * @return string lower case host name
	 */
	static public function getCurrentName()
	{
		return strtolower($_SERVER['HTTP_HOST']);
	}
	
	/**
	 * Get current host path
	 * 
	 * @return string lower case host path
	 */
	static public function getCurrentPath()
	{
		return 'host/'.self::getCurrentName();
	}	
	
	/**
	 * Get base URL
	 * 
	 * e.g. http://localhost/project/schmolck/framework/
	 * 
	 * @return string base URL
	 */
	static public function getBaseUrl()
	{
		$strHost = $_SERVER['HTTP_HOST'];
		$strPath = dirname($_SERVER['PHP_SELF']);
		return "http://{$strHost}{$strPath}/";
	}
}