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
			return 'id' . md5($this->_objCore->getHelperApplication()->getRequestUri() . session_id());
		}
	}

}