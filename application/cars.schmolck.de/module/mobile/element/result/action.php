<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperElement()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strApi = $objCore->getHelperElement()->getIdentifier();

/*
 * PARAMETER
 */
$objCore->strParameterMode = Schmolck_Tool_Memory::auto($objCore->getModule(), 'mode', strip_tags($_POST['mode']));
if ($objCore->strParameterMode == '') {
	$objCore->strParameterMode = 'list';
}

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURL' => $objCore->strUrl,
));