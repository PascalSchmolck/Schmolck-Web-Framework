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

	public function __construct(Schmolck_Framework_Core $objCore) {
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
	 * Store value to memory
	 * 
	 * @param string $strKey
	 * @param mixed $mixedValue
	 */
	public function store($strKey, $mixedValue) {
		Schmolck_Tool_Memory::store(get_class($this), $strKey, $mixedValue);
	}

	/**
	 * Restore value from memory
	 * 
	 * @param string $strKey
	 */
	public function restore($strKey) {
		return Schmolck_Tool_Memory::restore(get_class($this), $strKey);
	}

}