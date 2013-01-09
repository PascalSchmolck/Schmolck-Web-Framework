<?php
/**
 * Global Settings
 * 
 * @package Schmolck Framework
 * @author Pascal Schmolck
 * @copyright 2013
 * @version 1.0.0
 */

/* 
 * REPORTING
 */
error_reporting(E_ALL ^ E_NOTICE);

/*
 * GLOBALS
 */
defined('PATH') || define('PATH', realpath(dirname(__FILE__) . '/../'));