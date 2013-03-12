<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUri = $objCore->getHelperApplication()->getRequestUri();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();

/*
 * PARAMETER
 */
// - url
$objCore->strParameterUrl = strip_tags($_POST['url']);
if ($objCore->strParameterUrl == '') {
	$objCore->strParameterUrl = $objCore->strUri;
}
// - id
$objCore->strParameterId = trim(strip_tags($_POST['id']));
if ($objCore->strParameterId == '') {
	$objCore->strParameterId = trim(strip_tags($_GET['id']));
}

/*
 * CHECK
 */
// - id not empty then forward to detail view
if ($objCore->strParameterId != '') {
	$objCore->forward('api', 'cars', 'detail');
}

/*
 * DATA
 */
$resource = $objCore->getHelperDatabase()->query('SELECT * FROM  `mod_cars` LIMIT 0,10');
while ($arrRow = mysql_fetch_assoc($resource)) {
	/*
	 * PREPARATION
	 */
	$arrRow['name'] = Schmolck_Cars_Tool::getName($arrRow);
	$arrRow["EZ"] = Schmolck_Cars_Tool::getEz($arrRow);
	$arrRow["KM"] = Schmolck_Cars_Tool::getKm($arrRow);
	$arrRow["RP"] = Schmolck_Cars_Tool::getPrice($arrRow);
	$arrRow["color"] = Schmolck_Cars_Tool::getColor($arrRow);
	$arrRow["image"] = Schmolck_Cars_Tool::getFirstImageUrl($arrRow);

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