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
		$this->initMemory();
		$this->init();
	}

	public function __destruct() {
		$this->saveMemory();
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
	public function initMemory() {
		foreach ($this->_arrMemoryAttributes as $strClassAttribute) {
			$this->$strClassAttribute = Schmolck_Tool_Memory::restore(get_class($this), $strClassAttribute);
		}
	}

	/**
	 * Save memory state
	 */
	public function saveMemory() {
		foreach ($this->_arrMemoryAttributes as $strClassAttribute) {
			Schmolck_Tool_Memory::store(get_class($this), $strClassAttribute, $this->$strClassAttribute);
		}
	}

}