<?php
/**
 * Front Controller
 * 
 * @package Schmolck Framework
 * @author Pascal Schmolck
 * @copyright 2013
 */

/*
 * AUTOLOADER
 */
function __autoload($strClass){
	// - prepare path
	$strFilePath = 'lib/php';
	
	// - parse class parts
	$arrParts = explode('_', $strClass);
	foreach ($arrParts as $strPart) {
		$strFilePath .= "/{$strPart}";
		$strFileName = "{$strPart}.php";
	}
	
	// - include
	require_once($strFilePath.'/'.$strFileName);
}

/*
 * CORE
 */
$core = new Schmolck_Framework_Core();
$core->run();