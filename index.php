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
	$arrPart = explode("_", strtolower($strClass));
	switch(count($arrPart)){
		case 1:
			$file = "lib/php/{$arrPart[0]}/{$arrPart[0]}.php";
			break;
		case 2:
			$file = "lib/php/{$arrPart[0]}/{$arrPart[1]}/{$arrPart[1]}.php";
			break;
		case 3:
			$file = "lib/php/{$arrPart[0]}/{$arrPart[1]}/{$arrPart[2]}/{$arrPart[2]}.php";
			break;
		case 4:
			$file = "lib/php/{$arrPart[0]}/{$arrPart[1]}/{$arrPart[2]}/{$arrPart[3]}/{$arrPart[3]}.php";
			break;
	}
	if(isset($file)){
		require_once($file);
	}
}

/*
 * CORE
 */
$core = new Schmolck_Framework_Core();
$core->initHost();
$core->run();