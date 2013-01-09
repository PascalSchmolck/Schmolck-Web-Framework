<?php
/**
 * Core Instantiation
 * 
 * @package Schmolck PHP Framework (S-PHP-F)
 * @author Pascal Schmolck
 * @copyright 2013
 * @version 1.0.0
 */
$Core = new Schmolck_Framework_Core($strModule, $strController, $strAction);
$Core->SetExceptionModule('exception');
$Core->Run();