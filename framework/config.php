<?php
/**
 * Error Reporting Settings
 * 
 * @package php.framework.schmolck
 * @author Pascal Schmolck
 * @copyright 2012
 * @version 1.0.0
 */
error_reporting(E_ALL ^ E_NOTICE);
defined('PATH') || define('PATH', realpath(dirname(__FILE__) . '/../'));
//ob_start("ob_gzhandler");