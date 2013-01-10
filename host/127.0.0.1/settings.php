<?php
/**
 * Host Settings
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */

/* 
 * ERROR REPORTING
 */
error_reporting(E_ALL ^ E_NOTICE);

/*
 * DEBUG_LEVEL
 * 
 * 0 Emergency: system is unusable
 * 1 Alert: action must be taken immediately
 * 2 Critical: critical conditions
 * 3 Error: error conditions
 * 4 Warning: warning conditions
 * 5 Notice: normal but significant condition
 * 6 Informational: informational messages
 * 7 Debug: debug messages
 */
define('DEBUG_LEVEL', 7);

/*
 * APPLICATION ENVIRONMENT
 * 
 * development: on local development machine
 * testing: on testing environment
 * production: on production server
 */
define('APPLICATION_ENVIRONMENT', 'development');