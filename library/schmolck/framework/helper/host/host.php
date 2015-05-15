<?php

/**
 * Schmolck_Framework_Helper_Host
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Framework_Helper_Host extends Schmolck_Framework_Helper {

	const PATH = 'host';

	static public function getSettings() {
		return self::PATH . '/' . strtolower($_SERVER['HTTP_HOST']) . '.php';
	}

}