<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUri = $objCore->getHelperApplication()->getRequestUri();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();

/*
 * PREPARATION
 */
$objCars = new Schmolck_Cars_Helper($objCore);
$objCars->updateFromCSV();

/*
 * DATA
 */
$resource = $objCore->getHelperDatabase()->query('SELECT * FROM  `mod_cars` LIMIT 0,10');
while ($arrRow = mysql_fetch_assoc($resource)) {
	/*
	 * PREPARATION
	 */
	$arrRow['name'] = Schmolck_Cars_Helper::getName($arrRow);
	$arrRow["EZ"] = Schmolck_Cars_Helper::getEz($arrRow);
	$arrRow["KM"] = Schmolck_Cars_Helper::getKm($arrRow);
	$arrRow["RP"] = Schmolck_Cars_Helper::getPrice($arrRow);
	$arrRow["color"] = Schmolck_Cars_Helper::getColor($arrRow);
	$arrRow["image"] = Schmolck_Cars_Helper::getFirstImageUrl($arrRow);

	/*
	 * OUTPUT
	 */
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