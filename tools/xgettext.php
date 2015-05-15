<?php

/**
 * xgettext
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */

/*
 * CHECKS
 */
if ($argc > 0) {
	// command line
	if (empty($argv[1])) {
		die("USAGE: php " . basename($_SERVER["PHP_SELF"]) . " <directory>\n");
	}
	$dir = $argv[1];
} else {
	// web server
	if ($_SERVER["HTTP_HOST"] != "localhost") {
		// only on localhost due to security reasons
		header("Location: " . dirname($_SERVER["PHP_SELF"]));
		exit();
	}
	if (empty($_GET["dir"])) {
		die("<b>USAGE</b>: " . basename($_SERVER["PHP_SELF"]) . "?dir=...");
	}
	$dir = $_GET["dir"];
}
// DEBUG
// print_r(getFiles($dir));
// exit();
echo(convertStrings(extractStrings(extractFunctions(getFiles($dir)))));

/*
 * FUNCTIONS
 */

function getFiles($dir) {
	$array = array();
	$handle = opendir($dir);
	while ($file = readdir($handle)) {
		if ($file != "." && $file != ".." && $file != $_SERVER["PHP_SELF"]) {
			if (is_dir($dir . $file)) {
				// directory
				$array = array_merge($array, getFiles($dir . $file . '/'));
			} else {
				// file
				$array[] = $dir . $file;
			}
		}
	}
	closedir($handle);
	return $array;
}

function extractFunctions($files) {
	$strings = array();
	$set = array();
	foreach ($files as $file) {
		$counter = 1;
		foreach (file($file) as $line) {
			if (!empty($line)) {
				// _("") || _('') || gettext("") || gettext('')
				preg_match("/\_\(\"[^\"]*\"\)/i", $line, $tmp);
				if (count($tmp) > 0) {
					if (!in_array($tmp[0], $set)) {
						$strings["$file:$counter"][] = $tmp[0];
						$set[] = $tmp[0];
					}
					$tmp = array();
				}
			}
			$counter++;
		}
	}
	return $strings;
}

function extractStrings($strings) {
	foreach ($strings as $file => &$results) {
		foreach ($results as &$result) {
			$result = substr($result, 3, strlen($result) - 5);
		}
	}
	return $strings;
}

function convertStrings($strings) {
	foreach ($strings as $file => &$results) {
		//$file = str_replace("../", "", $file);
		foreach ($results as &$string) {
			$result .= "#: $file \n";
			$result .= "msgid \"$string\" \n";
			$result .= "msgstr \"\" \n";
			$result .= "\n";
		}
	}
	return $result;
}
