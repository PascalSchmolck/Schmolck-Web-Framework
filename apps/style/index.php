<?php

/**
 * Style Compression App
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
error_reporting(0);
ini_set("memory_limit", "16M");
$strPath = "../..";

/*
 * PARAMETER
 */
$strFile = utf8_decode(rawurldecode(str_replace(dirname($_SERVER["PHP_SELF"]) . "/", "", strip_tags($_SERVER["REQUEST_URI"]))));

/*
 * COMPRESSION
 */
if (extension_loaded("zlib") && (ini_get("output_handler") != "ob_gzhandler")) {
	ini_set("zlib.output_compression", 1);
}

/*
 * CACHING
 */
// send the requisite header information and character set
header("content-type: text/css; charset: UTF-8");
// check cached credentials and reprocess accordingly
header("cache-control: must-revalidate");
// set variable for duration of cached content
$offset = 60 * 60;
// set variable specifying format of expiration header
$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
// send cache expiration header to the client broswer
header($expire);

/*
 * OUTPUT
 */
readfile($strPath . '/' . $strFile);