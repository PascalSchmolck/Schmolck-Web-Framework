<?php

/**
 * Schmolck_Tool_Exception
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Tool_Exception extends Exception {

	public function __construct($message, $code=null, $previous=null) {
		/*
		 * LOGGING
		 */
		// - report any exception into PHP error log
		Schmolck_Tool_Debug::error($message."\nLine: {$this->getLine()} in {$this->getFile()}");
		
		/*
		 * EXCEPTION
		 */
		parent::__construct($message, $code, $previous);
	}
}