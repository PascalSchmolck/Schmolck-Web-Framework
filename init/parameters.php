<?php
/**
 * Parameter Parsing
 * 
 * @package Schmolck Framework
 * @author Pascal Schmolck
 * @copyright 2013
 * @version 1.0.0
 */

/*
 * PREPARATION
 */
$strUrlQuery = utf8_decode(rawurldecode(str_replace(dirname($_SERVER["PHP_SELF"])."/", "", strip_tags($_SERVER["REQUEST_URI"]))));
$arrQueryParameter = explode("/", $strUrlQuery);

/*
 * PARSING
 */
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
			if($counter % 2 != 0){
				$key = $entry;
			}else{
				$value = $entry;
				$_GET[$key] = $value;
			}
			break;
	}
	$nCounter++;
}