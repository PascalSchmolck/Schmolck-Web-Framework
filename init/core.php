<?php
/**
 * Core Instantiation
 * 
 * @package Schmolck Framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
$core = new Schmolck_Framework_Core();
$core->initHost();
$core->run();