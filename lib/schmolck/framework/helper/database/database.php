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
	protected $_connection;
	
	/**
	 * Initialise database settings
	 */
	public function init() {
		/*
		 * PREPARATION
		 */
		$this->_host = DATABASE_HOST;
		$this->_name = DATABASE_NAME;
		$this->_username = DATABASE_USERNAME;
		$this->_password = DATABASE_PASSWORD;
		
		/*
		 * CHECK
		 */
		if ($this->_host != 'DATABASE_HOST' and $this->_name != 'DATABASE_NAME' and $this->_username != 'DATABASE_USERNAME' and $this->_password != 'DATABASE_PASSWORD') {
			$this->connect();
		}		
	}

	/**
	 * Connect to database
	 * 
	 * @return boolean
	 * @throws Schmolck_Tool_Exception
	 */
	public function connect() {
		/*
		 * CHECK
		 */
		// - check if already connected
		if ($this->_connection != null) {
			return;
		}

		/*
		 * CONNECT
		 */
		$this->_connection = mysql_connect($this->_host, $this->_username, $this->_password);
		if (!$this->_connection) {
			Schmolck_Tool_Debug::error(mysql_error());
			throw new Schmolck_Tool_Exception("Connecting to database failed");
		}

		/*
		 * DATABASE
		 */

		$bResult = mysql_select_db($this->_name, $this->_connection);
		if (!$bResult) {
			Schmolck_Tool_Debug::error(mysql_error());
			throw new Schmolck_Tool_Exception("Selecting database failed ");
		}
	}

	/**
	 * Query database
	 * 
	 * @param string $strSQL
	 * @return resource
	 * @throws Schmolck_Tool_Exception
	 */
	public function query($strSQL) {		
		/*
		 * LOG
		 */
		$this->_startDebugTimer();
		
		/*
		 * QUERY
		 */
		$resource = mysql_query($strSQL, $this->_connection);
		if (!$resource) {
			Schmolck_Tool_Debug::error(mysql_error());
			Schmolck_Tool_Debug::error("SQL: " . $strSQL);
			throw new Schmolck_Tool_Exception("Database query failed");		
		}
		
		/*
		 * LOG
		 */
		$this->_stopDebugTimer($strSQL);

		/*
		 * OUTPUT
		 */
		return $resource;
	}
	
}