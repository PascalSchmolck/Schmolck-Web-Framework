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
	$strFilePath = 'lib';

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
 * PARAMETERS
 */
// - preparation
$strUrlQuery = utf8_decode(rawurldecode(str_replace(dirname($_SERVER["PHP_SELF"])."/", "", strip_tags($_SERVER["REQUEST_URI"]))));
$arrQueryParameter = explode("/", $strUrlQuery);
// - parsing
$nCounter = 0;
$_GET = array();
foreach($arrQueryParameter as $entry){
	switch($nCounter){
		case 0:
			$strModule = $entry;
			break;
		case 1:
			$strController = $entry;
			break;
		case 2:
			$strAction = $entry;
			break;
		default:
			if($nCounter % 2 != 0){
				$key = $entry;
			}else{
				$value = $entry;
				$_GET[$key] = $value;
			}
			break;
	}
	$nCounter++;
}

/*
 * CORE
 */
$objCore = new Schmolck_Framework_Core();
$objCore->setModule($strModule);
$objCore->setController($strController);
$objCore->setAction($strAction);
$objCore->run();