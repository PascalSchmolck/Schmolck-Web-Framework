<?php

/**
 * Host Settings
 * 
 * @package Schmolck Web framework
 * @author Pascal Schmolck
 */

/*
 * ERROR LOGGING & REPORTING
 */
ini_set("log_errors", 1);
ini_set("error_log", "tmp/error.log");
ini_set("error_reporting", E_ALL ^ E_NOTICE);

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
define('DEBUG_LEVEL', 3);

/*
 * APPLICATION NAME
 * 
 * Corresponding to whatever 'application' inside the application folder
 */
define('APPLICATION_NAME', 'cars.schmolck.de');

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
define('APPLICATION_TEMPLATE', '2013.12');

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
define('DATABASE_NAME', 'd016b5da');
define('DATABASE_USERNAME', 'd016b5da');
define('DATABASE_PASSWORD', 'TzwhgUFzoyJsySGc');

/*
 * PIWIK
 * 
 * Leave empty if tracking should not be activated
 */
define('PIWIK_TRACKING_ID', '3');

/*
 * MAIL
 */
define('MAIL_RECIPIENT_NAME', 'cars.schmolck.de');
define('MAIL_RECIPIENT_ADDRESS', 'verkauf@schmolck.de');

/*
 * MOBILE
 */
// - database & import & images
define('MOBILE_ZIP_FILE', 'data/mobile/files/sync/media.zip');
define('MOBILE_CSV_FILE_NAME', 'media.csv');
define('MOBILE_CSV_DELIMITER', ';');
define('MOBILE_CSV_ENCLOSURE', '"');
define('MOBILE_CSV_LIMITS', '203,5,16');
define('MOBILE_IMAGES_PATH', 'data/mobile/files/sync');
define('MOBILE_DATABASE_FILE', 'data/mobile/files/sync/media.csv');
define('MOBILE_DATABASE_TABLE', 'mod_mobile_claris_20131220');
define('MOBILE_PRICE_MWST', 19);
// - contact form
define('MOBILE_SENDER_NAME', 'cars.schmolck.de');
define('MOBILE_SENDER_ADDRESS', 'webmaster@schmolck.de');
define('MOBILE_RECIPIENT_NAME', 'verkauf@schmolck.de');
define('MOBILE_RECIPIENT_ADDRESS', 'verkauf@schmolck.de');