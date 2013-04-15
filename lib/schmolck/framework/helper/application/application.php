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

	/**
	 * Get application name
	 * 
	 * @return string lower case name
	 */
	public function getName() {
		return APPLICATION_NAME;
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
		if(substr($strPath, 0, 1) == "/" or substr($strPath, 0, 1) == "\\"){
			$strPath = substr($strPath, 1, strlen($strPath));
		}
		return "http://{$strHost}{$strPath}";
	}

	/**
	 * Get request url
	 * 
	 * @return string
	 */
	public function getRequestUrl() {
		//return $_SERVER['REQUEST_URI'];
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);

		/*
		 * PREPARATION
		 */
		$strHost = $_SERVER['HTTP_HOST'];
		$strUri = $objCore->getModule() . '/' . $objCore->getController() . '/' . $objCore->getAction();
		$strPath = dirname($_SERVER['PHP_SELF']);
		// - http://host/path/module/controller/action
		if ($strPath != '') {
			return 'http://'.$strHost.$strPath ."/". $strUri;
		} 
		// - http://host/module/controller/action
		return 'http://'.$strHost.$strUri;		
	}

}