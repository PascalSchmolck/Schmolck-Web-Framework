<?php

/**
 * Schmolck_Framework_Helper_Api
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Api extends Schmolck_Framework_Helper {

	/**
	 * Check if currently in AJAX call
	 * 
	 * Provide $strId when checking for specified gui object call
	 * 
	 * @param string $strId gui id
	 * @return boolean
	 */
	public function checkAjaxCall($strId = '') {
		if (empty($strId)) {
			return ( isset($_POST['_ajax']) and !empty($_POST['_id']) );
		} else {
			return ( isset($_POST['_ajax']) and $_POST['_id'] == $strId );
		}
	}

	/**
	 * Get session unique API id
	 * 
	 * @return string id
	 */
	public function getId() {
		if ($this->checkAjaxCall()) {
			return $_POST['_id'];
		} else {
			return 'id' . md5($this->_objCore->getHelperApplication()->getRequestUrl() . session_id());
		}
	}

	/**
	 * Get api CSS class
	 * 
	 * @return string class
	 */
	public function getStyleClass() {
		return  'api '.
				$this->_objCore->getModule() . ' ' .
				$this->_objCore->getController() . ' ' .
				$this->_objCore->getAction();
	}

	/**
	 * Get api identifier
	 * 
	 * @return string identifier
	 */
	public function getIdentifier() {
		return $this->_objCore->getModule() . '/' .
				$this->_objCore->getController() . '/' .
				$this->_objCore->getAction();
	}

	public function getElement($strId, $strApi, $arrParameter=array()) {
		/*
		 * BACKUP
		 */
		$arrOldGET = $_GET;
		$arrOldPOST = $_POST;
		
		/*
		 * INITIALISATION
		 */
		$arrApi = explode('/', $strApi);
		$strModule = $arrApi[0];
		$strController = $arrApi[1];
		$strAction = $arrApi[2];
		
		/*
		 * PARAMETER
		 */
		$_GET = $arrParameter;
		$_POST = array();
		$_POST['_ajax'] = 'true';
		$_POST['_id'] = $strId;
		
		/*
		 * PROCESSING
		 */
		ob_start();
		$objNewCore = new Schmolck_Framework_Core();
		$objNewCore->setModule($strModule);
		$objNewCore->setController($strController);
		$objNewCore->setAction($strAction);
		$objNewCore->setLayoutRendering(false);
		$objNewCore->run();
		$strOutput = ob_get_contents();
		ob_end_clean();

		/*
		 * RESTORE
		 */
		$_GET = $arrOldGET;
		$_POST = $arrOldPOST;

		/*
		 * OUTPUT
		 */
		return $strOutput;
	}

}