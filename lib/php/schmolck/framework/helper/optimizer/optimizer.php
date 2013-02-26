<?php

/**
 * Schmolck_Framework_Helper_Optimizer
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Optimizer extends Schmolck_Framework_Helper {

	/**
	 * Get optimized CSS string
	 * 
	 * @param string $strString CSS string
	 * @return string optimized CSS string
	 */
	public function getOptimizedCssString($strString) {
		return JSMin::minify($strString);
	}

	/**
	 * Get optimized JS string
	 * 
	 * @param string $strString JS string
	 * @return string optimized JS string
	 */
	public function getOptimizedJsString($strString) {
		return JSMin::minify($strString);
	}

}