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

}