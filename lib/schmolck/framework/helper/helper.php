<?php

/**
 * Schmolck_Framework_Helper
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
abstract class Schmolck_Framework_Helper {

	protected $_objCore;
	protected $_arrAttributes = array();
	
	private $_nMicrotime;

	public function __construct(Schmolck_Framework_Core $objCore) {
		/*
		 * LOG
		 */
		$this->_startDebugTimer();
		
		/*
		 * INITIALISATION
		 */
		$this->_objCore = $objCore;
		$this->init();
	}

	/**
	 * Initialisation
	 */
	public function init() {
		// - implementation by child
	}

	/**
	 * Restore from memory
	 * 
	 * @param string $strKey
	 */
	public function restore($strKey) {
		return Schmolck_Tool_Memory::restore(get_class($this), $strKey);
	}

	/**
	 * Store to memory
	 * 
	 * @param string $strKey
	 * @param string $strValue
	 */
	public function store($strKey, $strValue) {
		Schmolck_Tool_Memory::store(get_class($this), $strKey, $strValue);
	}
	
	/**
	 * Start debug timer
	 */
	protected function _startDebugTimer() {
		$this->_nMicrotime = microtime(true);
	}
	
	/**
	 * Stop debug timer and write log message
	 * 
	 * @param string $strStatement
	 */
	protected function _stopDebugTimer($strStatement) {
		/*
		 * PREPARATION
		 */
		// - speed
		if ($this->_nMicrotime > 0) {
			$nSpeed = ceil((microtime(true) - $this->_nMicrotime)*1000);
		} else {
			$nSpeed = -1;
		}
		// - statement
		if ($strStatement != '') {
			$strStatement = str_replace("\n", " ", $strStatement);
			$strStatement = str_replace("\t", " ", $strStatement);
			$strStatement = str_replace("\r", " ", $strStatement);
			$strStatement = str_replace("  ", " ", $strStatement);
			$strStatement = str_replace("  ", " ", $strStatement);
			$strStatement = str_replace("  ", " ", $strStatement);
			$strStatement = trim($strStatement);
		}
		
		/*
		 * LOG
		 */
		Schmolck_Tool_Debug::info("SPEED: {$nSpeed} ms | STATEMENT: {$strStatement}");
	}	
}