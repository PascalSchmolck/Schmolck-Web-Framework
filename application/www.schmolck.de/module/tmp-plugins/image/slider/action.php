<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strApi = $objCore->getHelperApi()->getIdentifier();
// - plugins
$objPlugins = new Plugins_Helper($objCore);

/*
 * PARAMETER
 */
// - GET
$objCore->strPath = Schmolck_Tool_Memory::auto($objCore->strApi, 'path', strip_tags($_GET['path']));
$objCore->strTimeout = Schmolck_Tool_Memory::auto($objCore->strApi, 'timeout', strip_tags($_GET['timeout']));
// - POST
$objCore->nNumber = strip_tags($_POST['number']);

/*
 * DATA
 */
$objCore->arrImages = $objPlugins->getImages($objCore->strPath);

/*
 * CHECK
 */
if ($objCore->nNumber == '' or ($objCore->nNumber >= count($objCore->arrImages))) {
	$objCore->nNumber = 0;
}

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURL' => $objCore->strUrl,
	'SchmolckIMAGES' => json_encode($objCore->arrImages),
	'SchmolckTIMEOUT' => $objCore->strTimeout
));