<?php

/**
 * Schmolck_Framework_Helper_Scripts
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Scripts extends Schmolck_Framework_Helper {

	protected $_arrViewScriptReplace = array();

	/**
	 * Register script replace strings
	 * 
	 * @param array $arrReplace
	 */
	public function registerViewScriptReplace($arrReplace) {
		$this->_arrViewScriptReplace = $arrReplace;
	}

	/**
	 * Render view scripts
	 * 
	 * Used for rendering scripts inside an element defined in the output.phtml
	 * 
	 * @throws Exception
	 */
	public function renderViewScripts() {
		$strFile = $this->_objCore->getHelperApplication()->getModulePath() . "/{$this->_objCore->getModule()}/{$this->_objCore->getController()}/{$this->_objCore->getAction()}/scripts.js";
		if (file_exists($strFile)) {
			$strJavaScript = str_replace(array_keys($this->_arrViewScriptReplace), array_values($this->_arrViewScriptReplace), file_get_contents($strFile));
			if (APPLICATION_ENVIRONMENT != 'development') {
				$strJavaScript = $this->_objCore->getHelperOptimizer()->getOptimizedJsString($strJavaScript);
			}
			echo '<script>' . $strJavaScript . '</script>';
		} else {
			throw new Exception("View scripts file '{$strFile} not found");
		}
	}

}