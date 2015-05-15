<?php

/**
 * Image Compression App
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */

error_reporting(0);
ini_set("memory_limit","96M"); 
require_once("classes/image_converter.php");

$string = utf8_decode(rawurldecode(str_replace(dirname($_SERVER["PHP_SELF"])."/", "", strip_tags($_SERVER["REQUEST_URI"]))));
$array = explode("/", $string);

$size = $array[0];
$quality = $array[1];
$file = "../../".str_replace("{$size}/{$quality}/", "", $string);
$dir = "../../tmp/";

// *** SIZE
if($size > 1600 || $size < 1){
	unset($size);
}
// *** QUALITY
if($quality == 0 || empty($quality)){
	$quality = 90;
}
// *** CHECK
if (!file_exists($file)) {
	header('HTTP/1.0 404 Not Found');
	exit();
}
// *** IMAGE
$image = new IMAGE_CONVERTER();
$image->file = $file;
$image->size = $size;
$image->quality = $quality;
$image->cacheDir = $dir;
$image->getImage();
