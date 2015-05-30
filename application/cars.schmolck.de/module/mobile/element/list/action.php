<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperElement()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strStyleClass = $objCore->getHelperElement()->getStyleClass();
// - cars
$objCars = new Mobile_Helper($objCore);
// - offset
$objCore->nOffset = 10;

/*
 * PARAMETER
 */
// - limit
$objCore->nLimit = intval(strip_tags($_POST['limit']));
if ($objCore->nLimit == 0) {
	$objCore->nLimit = max(Schmolck_Tool_Memory::restore(get_class(), 'limit'), $objCore->nOffset);
} else {
	Schmolck_Tool_Memory::store(get_class(), 'limit', $objCore->nLimit);
}

/*
 * DATA
 */
$objCore->arrCars = $objCars->queryCarsFiltered();
$objCore->nCars = count($objCore->arrCars);

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURL' => $objCore->strUrl,
));