<?php

/**
 * Schmolck_Framework_Helper
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper {

	protected $_objCore;
	protected $_arrMemoryAttributes = array();
	private static $_arrInstances = array();

	/**
	 * Abstract Singleton Pattern
	 * 
	 * @return instance
	 */
	final public static function getInstance() {
		$class = get_called_class();
		if (empty(self::$_arrInstances[$class])) {
			$rc = new ReflectionClass($class);
			self::$_arrInstances[$class] = $rc->newInstanceArgs(func_get_args());
		}
		return self::$_arrInstances[$class];
	}

	final public function __clone() {
		throw new Exception('This singleton must not be cloned!');
	}

	public function __construct() {
		$this->_initMemory();
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
	
	public function setCore(Schmolck_Framework_Core $objCore) {
		$this->_objCore = $objCore;
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