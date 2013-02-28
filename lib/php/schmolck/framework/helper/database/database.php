<?php

/**
 * Schmolck_Framework_Helper_Database
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Database extends Schmolck_Framework_Helper {
	
	protected $_host;
	protected $_name;
	protected $_username;
	protected $_password;
	
	public function init() {
		$this->_host = DATABASE_HOST;
		$this->_name = DATABASE_NAME;
		$this->_username = DATABASE_USERNAME;
		$this->_password = DATABASE_PASSWORD;
	}
	
	public function checkConnection() {
		$link = mysql_connect($this->_host, $this->_name, $this->_password);
		if (!$link) {
			Schmolck_Tool_Debug::error(mysql_error());
			throw new Exception("Database connection failed");
		} else {
			return true;
		}
	}
}