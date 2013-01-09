<?php
/**
 * Class Autoloader
 * 
 * @package php.framework.schmolck
 * @author Pascal Schmolck
 * @copyright 2012
 * @version 1.0.0
 */
function __autoload($class){
	$part = explode("_", strtolower($class));
	switch(count($part)){
		case 1:
			$file = "libraries/php/{$part[0]}/{$part[0]}.php";
			break;
		case 2:
			$file = "libraries/php/{$part[0]}/{$part[1]}/{$part[1]}.php";
			break;
		case 3:
			$file = "libraries/php/{$part[0]}/{$part[1]}/{$part[2]}/{$part[2]}.php";
			break;
		case 4:
			$file = "libraries/php/{$part[0]}/{$part[1]}/{$part[2]}/{$part[3]}/{$part[3]}.php";
			break;
	}
	if(isset($file)){
		require_once($file);
	}
}