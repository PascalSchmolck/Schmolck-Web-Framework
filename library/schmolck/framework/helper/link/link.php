<?php

/**
 * Schmolck_Framework_Helper_Link
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Framework_Helper_Link extends Schmolck_Framework_Helper {
	
	public function get($strString) {
		return "javascript:Schmolck_Framework_Helper_Link('".str_rot13($strString)."');";
	}
}