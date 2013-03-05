<?php

/**
 * Schmolck_Framework_Helper_Application
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Application extends Schmolck_Framework_Helper {

	const PATH = 'application';

	static public function getSettings() {
		return self::PATH . '/' . strtolower($_SERVER['HTTP_HOST']) . '/settings.php';
	}

	/**
	 * Get application name
	 * 
	 * @return string lower case name
	 */
	public function getName() {
		return strtolower($_SERVER['HTTP_HOST']);
	}

	/**
	 * Get application path
	 * 
	 * @return string lower case host path
	 */
	public function getPath() {
		return self::PATH . '/' . $this->getName();
	}

	/**
	 * Get module path
	 * 
	 * @return string module path
	 */
	public function getModulePath() {
		return $this->getPath() . '/module';
	}

	/**
	 * Get template path
	 * 
	 * @return string template path
	 */
	public function getTemplatePath() {
		return $this->getPath() . '/template/' . APPLICATION_TEMPLATE;
	}

	/**
	 * Get base URL
	 * 
	 * e.g. http://localhost/project/schmolck/framework/
	 * 
	 * @return string base URL
	 */
	public function getBaseUrl() {
		$strHost = $_SERVER['HTTP_HOST'];
		$strPath = dirname($_SERVER['PHP_SELF']);
		return "http://{$strHost}{$strPath}/";
	}

	/**
	 * Get module string
	 * 
	 * @return string
	 */
	public function getRequestUri() {
		return $_SERVER['REQUEST_URI'];
	}

}