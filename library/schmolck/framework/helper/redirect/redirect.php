<?php

/**
 * Schmolck_Framework_Helper_Redirect
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Framework_Helper_Redirect extends Schmolck_Framework_Helper {

	public function local($strParameter) {
		header('Location: ' . $this->_objCore->getHelperApplication()->getBaseUrl() . '/' . $strParameter);
		exit();
	}
	
	public function external($strUrl) {
		header('Location: ' . $strUrl);
		exit();
	}	

}