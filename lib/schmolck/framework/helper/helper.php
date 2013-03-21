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
	protected $_arrMemoryAttributes = array();

	public function __construct(Schmolck_Framework_Core $objCore) {
		$this->_objCore = $objCore;
		$this->_initMemory();
		$this->init();
	}

	public function __destruct() {
		$this->_saveMemory();
	}

	/**
	 * Initialisation
	 */
	public function init() {
		// - implementation by child
	}

	/**
	 * Initialise memory state
	 */
	protected function _initMemory() {
		foreach ($this->_arrMemoryAttributes as $strClassAttribute) {
			$this->$strClassAttribute = Schmolck_Tool_Memory::restore(get_class($this), $strClassAttribute);
		}
	}

	/**
	 * Save memory state
	 */
	protected function _saveMemory() {
		foreach ($this->_arrMemoryAttributes as $strClassAttribute) {
			Schmolck_Tool_Memory::store(get_class($this), $strClassAttribute, $this->$strClassAttribute);
		}
	}

}