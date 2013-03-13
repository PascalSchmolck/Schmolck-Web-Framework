<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUri = $objCore->getHelperApplication()->getRequestUri();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();
// - cars
$objCars = new Schmolck_Cars_Helper($objCore);
$objCars->updateFromCSV();
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
$strQuery = sprintf("SELECT * FROM  `mod_cars` LIMIT 0,%s", $objCore->nLimit);
$resource = $objCore->getHelperDatabase()->query($strQuery);
while ($arrRow = mysql_fetch_assoc($resource)) {
	$arrRow['name'] = $objCars->getName($arrRow);
	$arrRow["EZ"] = $objCars->getEz($arrRow);
	$arrRow["KM"] = $objCars->getKm($arrRow);
	$arrRow["RP"] = $objCars->getPrice($arrRow);
	$arrRow["color"] = $objCars->getColor($arrRow);
	$arrRow["image"] = $objCars->getFirstImageUrl($arrRow);
	$arrResult[] = $arrRow;
}
$objCore->arrCars = $arrResult;
$objCore->nCars = count($objCore->arrCars);

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURI' => $objCore->strUri,
));