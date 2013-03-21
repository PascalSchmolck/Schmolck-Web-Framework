<?php

/**
 * Schmolck_Framework_Helper_Message
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Message extends Schmolck_Framework_Helper {
	
	/**
	 * Set message string
	 * 
	 * @param string $strMessage
	 */
	public function setMessage($strMessage) {
		$this->store('message', $strMessage);
	}
	
	/**
	 * Get message
	 * 
	 * @return string message
	 */
	public function getMessage() {
		return $this->restore('message');
	}
	
	/**
	 * Get message and clear it afterwards
	 * 
	 * @return string message
	 */
	public function popMessage() {
		$strMessage = $this->getMessage();
		$this->setMessage('');
		return $strMessage;
	}
}