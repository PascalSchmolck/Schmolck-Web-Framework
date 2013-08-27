<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->getHelperApi()->getId(),
));