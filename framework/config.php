<?php
/**
 * Error Reporting Settings
 * 
 * @package Schmolck PHP Framework (S-PHP-F)
 * @author Pascal Schmolck
 * @copyright 2013
 * @version 1.0.0
 */
error_reporting(E_ALL ^ E_NOTICE);
defined('PATH') || define('PATH', realpath(dirname(__FILE__) . '/../'));
//ob_start("ob_gzhandler");