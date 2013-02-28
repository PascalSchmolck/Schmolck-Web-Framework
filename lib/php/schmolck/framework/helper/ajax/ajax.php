<?php

/**
 * Schmolck_Framework_Helper_Ajax
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Ajax extends Schmolck_Framework_Helper {

	/**
	 * Check if currently in AJAX call
	 * 
	 * Provide $strId when checking for specified gui object call
	 * 
	 * @param string $strId gui id
	 * @return boolean
	 */
	public function checkCall($strId = '') {
		if (empty($strId)) {
			return ( isset($_POST['ajax']) and !empty($_POST['name']) );
		} else {
			return ( isset($_POST['ajax']) and $_POST['name'] == $strId );
		}
	}

}