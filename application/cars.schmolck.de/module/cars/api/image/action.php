<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUri = $objCore->getHelperApplication()->getRequestUri();
$objCore->strApi = $objCore->getHelperApi()->getIdentifier();
// - cars
$objCars = new Schmolck_Cars_Helper();
$objCars->setCore($objCore);

/*
 * PARAMETER
 */
// - GET
$objCore->strParameterId = Schmolck_Tool_Memory::auto($objCore->strApi, 'id', strip_tags($_GET['id']));
// - POST
$objCore->nNumber = strip_tags($_POST['number']);

/*
 * DATA
 */
$objCore->arrImages = $objCars->getImages($objCore->strParameterId);

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
	'SchmolckURI' => $objCore->strUri,
	'SchmolckIMAGES' => json_encode($objCore->arrImages)
));