<?php

/**
 * Schmolck framework - PHP Framework
 * 
 * @
 * @author Pascal Schmolck <mail@pascalschmolck.de>
 * @copyright (c) 2013, Pascal Schmolck
 * @package Schmolck framework
 */

/*
 * AUTOLOADER
 */
function __autoload($strClass) {
	// - prepare
	$strFilePath = 'lib/php';

	// - parse
	$arrParts = explode('_', $strClass);
	foreach ($arrParts as $strPart) {
		$strFilePath .= "/{$strPart}";
		$strFileName = "{$strPart}.php";
	}

	// - include
	require_once($strFilePath . '/' . $strFileName);
}

/*
 * SESSION
 */
session_start();

/*
 * CORE
 */
$core = new Schmolck_Framework_Core();
$core->run();