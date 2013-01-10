<?php
/**
 * Schmolck_Framework_Optimizer
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Optimizer 
{
	/**
	 * Get optimized CSS string
	 * 
	 * @param string $strString CSS string
	 * @return string optimized CSS string
	 */
	static public function getOptimizedCssString($strString)
	{
		return JSMin::minify($strString);
	}
	
	/**
	 * Get optimized JS string
	 * 
	 * @param string $strString JS string
	 * @return string optimized JS string
	 */
	static public function getOptimizedJsString($strString)
	{
		return JSMin::minify($strString);
	}
}