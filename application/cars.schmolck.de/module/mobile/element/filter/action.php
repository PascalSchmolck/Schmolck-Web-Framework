<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperElement()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strApi = $objCore->getHelperElement()->getIdentifier();
// - cars
$objCars = new Mobile_Helper($objCore);

/*
 * PARAMETER
 */
// - GET
$objCore->strParameterResultID = Schmolck_Tool_Memory::auto($objCore->getModule(), 'resultID', strip_tags($_POST['resultID']));
$objCore->strParameterResultURL = Schmolck_Tool_Memory::auto($objCore->getModule(), 'resultURL', strip_tags($_POST['resultURL']));
// - POST
$objCore->strParameterSend = strip_tags($_POST['send']);
$objCore->strParameterReset = strip_tags($_POST['reset']);
if ($objCore->strParameterReset) {
    $strReload = 'true';
    $_POST['brand'] = ' ';
    $_POST['model'] = ' ';
    $_POST['type'] = ' ';
    $_POST['transmission'] = ' ';
    $_POST['price'] = ' ';
    $_POST['km'] = ' ';
    $_POST['ez'] = ' ';
    $_POST['sorting'] = 'price';
}
$objCore->strParameterBrand = Schmolck_Tool_Memory::auto($objCore->getModule(), 'brand', strip_tags($_POST['brand']));
$objCore->strParameterModel = Schmolck_Tool_Memory::auto($objCore->getModule(), 'model', strip_tags($_POST['model']));
$objCore->strParameterType = Schmolck_Tool_Memory::auto($objCore->getModule(), 'type', strip_tags($_POST['type']));
$objCore->strParameterTransmission = Schmolck_Tool_Memory::auto($objCore->getModule(), 'transmission', strip_tags($_POST['transmission']));
$objCore->strParameterPrice = Schmolck_Tool_Memory::auto($objCore->getModule(), 'price', strip_tags($_POST['price']));
$objCore->strParameterKm = Schmolck_Tool_Memory::auto($objCore->getModule(), 'km', strip_tags($_POST['km']));
$objCore->strParameterEz = Schmolck_Tool_Memory::auto($objCore->getModule(), 'ez', strip_tags($_POST['ez']));
$objCore->strParameterSorting = Schmolck_Tool_Memory::auto($objCore->getModule(), 'sorting', strip_tags($_POST['sorting']));

/*
 * PREPARATION
 */
if (trim($objCore->strParameterBrand)
        or trim($objCore->strParameterModel)
        or trim($objCore->strParameterType)
        or trim($objCore->strParameterTransmission)
        or trim($objCore->strParameterPrice)
        or trim($objCore->strParameterKm)
        or trim($objCore->strParameterEz)
        or $objCore->strParameterSorting != 'price') {
//	$objCore->bResetLink = true;
}

/*
 * SAVING
 */
$objCars->setFilter('brand', $objCore->strParameterBrand);
$objCars->setFilter('model', $objCore->strParameterModel);
$objCars->setFilter('type', $objCore->strParameterType);
$objCars->setFilter('transmission', $objCore->strParameterTransmission);
$objCars->setFilter('price', $objCore->strParameterPrice);
$objCars->setFilter('km', $objCore->strParameterKm);
$objCars->setFilter('ez', $objCore->strParameterEz);
$objCars->setFilter('sorting', $objCore->strParameterSorting);

/*
 * DATA
 */
$objCore->nCount = count($objCars->queryCarsFiltered());
$objCore->arrTransmissions = $objCars->getFilterTransmissions();
$objCore->arrPrices = $objCars->getFilterPrices();

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
    'SchmolckID' => $objCore->strId,
    'SchmolckURL' => $objCore->strUrl,
    'SchmolckRESULTID' => $objCore->strParameterResultID,
    'SchmolckRESULTURL' => $objCore->strParameterResultURL,
));
