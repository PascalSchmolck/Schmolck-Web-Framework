<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strApi = $objCore->getHelperApi()->getIdentifier();

/*
 * PARAMETER
 */
$objCore->strParameterMode = Schmolck_Tool_Memory::auto($objCore->strApi, 'mode', strip_tags($_POST['mode']));
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