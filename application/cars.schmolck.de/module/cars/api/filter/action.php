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
$objCore->strParameterSend = strip_tags($_POST['send']);
$objCore->strParameterBrand = Schmolck_Tool_Memory::auto($objCore->strApi, 'brand', strip_tags($_POST['brand']));

/*
 * SAVING
 */
$objCars->setFilter('brand', $objCore->strParameterBrand);

/*
 * DATA
 */
//$objCore->arrBrands = $objCars->getBrands();
$objCore->arrBrands = array(
	'mercedes-benz',
	'smart',
//	'volkswagen'
);
$objCore->nCount = count($objCars->queryFilteredCars());

///*
// * DATA
// */
//$strQuery = sprintf("SELECT * FROM  `mod_cars` LIMIT 0,%s", $objCore->nLimit);
//$resource = $objCore->getHelperDatabase()->query($strQuery);
//while ($arrRow = mysql_fetch_assoc($resource)) {
//	$arrRow['name'] = $objCars->getName($arrRow);
//	$arrRow["EZ"] = $objCars->getEz($arrRow);
//	$arrRow["KM"] = $objCars->getKm($arrRow);
//	$arrRow["RP"] = $objCars->getPrice($arrRow);
//	$arrRow["color"] = $objCars->getColor($arrRow);
//	$arrRow["image"] = $objCars->getFirstImageUrl($arrRow);
//	$arrResult[] = $arrRow;
//}
//$objCore->arrCars = $arrResult;
//$objCore->nCars = count($objCore->arrCars);

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURI' => $objCore->strUri,
));