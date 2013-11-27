<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();
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
//$strQuery = sprintf("SELECT * FROM  `mod_cars` LIMIT 0,%s", $objCore->nLimit);
//$resource = $objCore->getHelperDatabase()->query($strQuery);
//while ($arrRow = mysql_fetch_assoc($resource)) {
//	$arrRow['name'] = $objCars->extractName($arrRow);
//	$arrRow["EZ"] = $objCars->extractEz($arrRow);
//	$arrRow["KM"] = $objCars->extractKm($arrRow);
//	$arrRow["RP"] = $objCars->extractPrice($arrRow);
//	$arrRow["color"] = $objCars->extractColor($arrRow);
//	$arrResult[] = $arrRow;
//}
//$objCore->arrCars = $arrResult;
//$objCore->nCars = count($objCore->arrCars);

$objCore->arrCars = $objCars->queryCarsFiltered();
$objCore->nCars = count($objCore->arrCars);

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURL' => $objCore->strUrl,
));