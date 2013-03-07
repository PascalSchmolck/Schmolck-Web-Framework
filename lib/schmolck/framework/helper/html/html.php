<?php

/**
 * Schmolck_Framework_Helper_Html
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Html extends Schmolck_Framework_Helper {

	protected $_strPageTitle;

	/**
	 * Set HTML page title
	 * 
	 * @param string $strString title
	 */
	public function setPageTitle($strString) {
		$this->_strPageTitle = $strString;
	}

	/**
	 * Get HTML page title
	 * 
	 * @return string title
	 */
	public function getPageTitle() {
		return $this->_strPageTitle;
	}

}