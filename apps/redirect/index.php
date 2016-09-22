<?php

/**
 * Redirection for temporary purpose
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
error_reporting(0);
ini_set("memory_limit", "16M");

// PREPARE
// - get query string and put it into redirection URL
$strUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$arrUrl = parse_url($strUrl);
$strRedirectUrl = 'http://www.schmolck.de/suche/fahrzeugsuche/?' . $arrUrl['query'];
header('Location: ' . $strRedirectUrl);

