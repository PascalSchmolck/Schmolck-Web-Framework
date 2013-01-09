<?php
/**
 * Core Instantiation
 * 
 * @package php.framework.schmolck
 * @author Pascal Schmolck
 * @copyright 2012
 * @version 1.0.0
 */
$Core = new Schmolck_Framework_Core($strModule, $strController, $strAction);
$Core->SetExceptionModule('exception');
$Core->Run();