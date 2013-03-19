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
$objCars = new Schmolck_Cars_Helper($objCore);

/*
 * PARAMETER
 */
// - GET
$objCore->strParameterResultID = Schmolck_Tool_Memory::auto($objCore->strApi, 'resultID', strip_tags($_GET['resultID']));
// - POST
$objCore->strParameterSend = strip_tags($_POST['send']);
$objCore->strParameterReset = strip_tags($_POST['reset']);
if ($objCore->strParameterReset) {
	$strReload = 'true';
	$_POST['brand'] = ' ';
	$_POST['type'] = ' ';
	$_POST['price'] = ' ';
}
$objCore->strParameterBrand = Schmolck_Tool_Memory::auto($objCore->strApi, 'brand', strip_tags($_POST['brand']));
$objCore->strParameterType = Schmolck_Tool_Memory::auto($objCore->strApi, 'type', strip_tags($_POST['type']));
$objCore->strParameterPrice = Schmolck_Tool_Memory::auto($objCore->strApi, 'price', strip_tags($_POST['price']));

/*
 * SAVING
 */
$objCars->setFilter('brand', $objCore->strParameterBrand);
$objCars->setFilter('type', $objCore->strParameterType);
$objCars->setFilter('price', $objCore->strParameterPrice);

/*
 * DATA
 */
$objCore->nCount = count($objCars->queryFilteredCars());
$objCore->arrPrices = $objCars->getPrices();

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURI' => $objCore->strUri,
	'SchmolckRESULTID' => $objCore->strParameterResultID,
	'SchmolckRELOAD' => $strReload
));