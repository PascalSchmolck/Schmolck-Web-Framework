<?php

/**
 * Schmolck_Framework_Helper_Host
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Host extends Schmolck_Framework_Helper {

	const PATH = 'host';

	static public function getSettings() {
		return self::PATH . '/' . strtolower($_SERVER['HTTP_HOST']) . '.php';
	}

}