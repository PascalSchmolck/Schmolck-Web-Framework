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
if ($objCore->strParameterSend) {
	$strReload = 'true';
}
$objCore->strParameterReset = strip_tags($_POST['reset']);
if ($objCore->strParameterReset) {
	$strReload = 'true';
	$_POST['brand'] = ' ';
	$_POST['type'] = ' ';
	$_POST['price'] = ' ';
	$_POST['km'] = ' ';
	$_POST['sorting'] = 'price';
}
$objCore->strParameterBrand = Schmolck_Tool_Memory::auto($objCore->strApi, 'brand', strip_tags($_POST['brand']));
$objCore->strParameterType = Schmolck_Tool_Memory::auto($objCore->strApi, 'type', strip_tags($_POST['type']));
$objCore->strParameterPrice = Schmolck_Tool_Memory::auto($objCore->strApi, 'price', strip_tags($_POST['price']));
$objCore->strParameterKm = Schmolck_Tool_Memory::auto($objCore->strApi, 'km', strip_tags($_POST['km']));
$objCore->strParameterSorting = Schmolck_Tool_Memory::auto($objCore->strApi, 'sorting', strip_tags($_POST['sorting']));

/*
 * PREPARATION
 */
if (trim($objCore->strParameterBrand) 
	or trim($objCore->strParameterType) 
	or trim($objCore->strParameterPrice)
	or trim($objCore->strParameterKm)
	or $objCore->strParameterSorting != 'price') {
	$objCore->bResetLink = true;
}

/*
 * SAVING
 */
$objCars->setFilter('brand', $objCore->strParameterBrand);
$objCars->setFilter('type', $objCore->strParameterType);
$objCars->setFilter('price', $objCore->strParameterPrice);
$objCars->setFilter('km', $objCore->strParameterKm);
$objCars->setFilter('sorting', $objCore->strParameterSorting);

/*
 * DATA
 */
$objCore->nCount = count($objCars->queryFilteredCars());
$objCore->arrPrices = $objCars->getPrices();
$objCore->arrKms = $objCars->getKms();

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURI' => $objCore->strUri,
	'SchmolckAPI' => $objCore->strApi,
));