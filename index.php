<?php

/**
 * Schmolck Web Framework
 * 
 * @author Pascal Schmolck <mail@pascalschmolck.de>
 * @license This work is licensed under the Creative Commons Attribution-ShareAlike 4.0 International License. To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/4.0/
 */

/*
 * ERROR REPORTING
 */
ini_set("error_reporting", E_ALL ^ E_NOTICE);

/*
 * AUTOLOADER
 */
function __autoload($strClass) {
	// - prepare
	$strFilePath = 'library';

	// - parse
	$arrParts = explode('_', $strClass);
	foreach ($arrParts as $strPart) {
		$strFilePath .= "/{$strPart}";
		$strFileName = "{$strPart}.php";
	}

	// - include
	require_once(strtolower($strFilePath . '/' . $strFileName));
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
(substr($strUrlQuery, 0, 1) == "/")? $strUrlQuery = substr($strUrlQuery, 1, strlen($strUrlQuery)): null;
$arrQueryParameter = explode("/", $strUrlQuery);

/*
 * DEBUGGING
 */
//echo $strUrlQuery;
//exit();

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
($strModule == '')? $strModule = 'index': null;
($strController == '')? $strController = 'index': null;
($strAction == '')? $strAction = 'index': null;

/*
 * CORE
 */
$objCore = new Schmolck_Framework_Core();
$objCore->setBasePath(dirname(__FILE__));
$objCore->setModule($strModule);
$objCore->setController($strController);
$objCore->setAction($strAction);
$objCore->run();