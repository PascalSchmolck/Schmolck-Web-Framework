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

/*
 * DATA
 */
$resource = $objCore->getHelperDatabase()->query('SELECT * FROM  `mod_cars` LIMIT 0,10');
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

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $this->strId,
	'SchmolckURI' => $this->strUri,
));