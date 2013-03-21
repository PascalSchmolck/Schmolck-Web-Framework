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
 * COMPRESSION
 */
if (extension_loaded("zlib") && (ini_get("output_handler") != "ob_gzhandler")) {
    ini_set("zlib.output_compression", 1);
}

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
 * APPLICATION NAME
 * 
 * Corresponding to whatever 'application' inside the application folder
 */
define('APPLICATION_NAME', 'cars.schmolck.de');

/*
 * APPLICATION ENVIRONMENT
 * 
 * development: on local development machine
 * testing: on testing environment
 * production: on production server
 */
define('APPLICATION_ENVIRONMENT', 'production');

/*
 * APPLICATION LANGUAGE
 * 
 * Define the default language for the application.
 */
define('APPLICATION_LANGUAGE', 'de');

/*
 * APPLICATION TEMPLATE
 * 
 * Define what template should be used. 
 * Depends on what template folders you have installed and running.
 */
define('APPLICATION_TEMPLATE', '2013.03');

/*
 * EXCEPTION
 * 
 * Define what module should be used in case of an exception and
 * which e-mail address should be used for notification mails.
 */
define('EXCEPTION_MODULE', 'exception');
define('EXCEPTION_ADDRESS', 'webmaster@schmolck.de');

/*
 * DATABASE CONNECTION
 * 
 * Define the database connection settings here.
 */
define('DATABASE_HOST', 'localhost');
define('DATABASE_NAME', 'pascal_cars.schmolck.de');
define('DATABASE_USERNAME', 'pascal');
define('DATABASE_PASSWORD', 'test');

/*
 * PIWIK
 * 
 * Leave empty if tracking should not be activated
 */
define('PIWIK_TRACKING_ID', '');

/*
 * MAIL
 */
define('MAIL_SENDER_NAME', 'Pascal Schmolck');
define('MAIL_SENDER_ADDRESS', 'mail@pascalschmolck.de');

/*
 * CARS
 */
define('CARS_CONTACT_RECIPIENT_NAME', 'Pascal Schmolck');
define('CARS_CONTACT_RECIPIENT_ADDRESS', 'mail@pascalschmolck.de');