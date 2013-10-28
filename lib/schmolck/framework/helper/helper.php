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
	protected $_bCache = true;
	
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
	 * Set cache for given hash and value
	 * 
	 * @param type $strHash
	 * @param type $strValue
	 */
	protected function _setCache($strHash, $strValue) {
		if ($this->_bCache) {
			/*
			 * INITIALISATION
			 */
			$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
			$strCacheFile = $objCore->getHelperCache()->getFilePath($strHash);
			
			/*
			 * CACHE
			 */
			Schmolck_Tool_Debug::debug("CACHE: SET: $strHash");		
			file_put_contents($strCacheFile, serialize($strValue));
		}
	}
	
	/**
	 * Get cached value for given hash
	 * 
	 * @param type $strHash
	 * @return type values
	 */
	protected function _getCache($strHash) {
		if ($this->_bCache) {
			/*
			 * INITIALISATION
			 */
			$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
			$strCacheFile = $objCore->getHelperCache()->getFilePath($strHash);
			
			/*
			 * CHECK
			 */
			if (file_exists($strCacheFile)) {
				Schmolck_Tool_Debug::debug("CACHE: GET: $strHash");		
				return unserialize(file_get_contents($strCacheFile));
			} else {
				return null;
			}
		}		
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