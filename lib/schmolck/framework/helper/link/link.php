<?php

/**
 * Schmolck_Framework_Helper_Link
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Link extends Schmolck_Framework_Helper {
	
	public function get($strString) {
		return "javascript:Schmolck_Framework_Helper_Link('".str_rot13($strString)."');";
	}
}