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
// - id
$objCore->strParameterId = trim(strip_tags($_POST['id']));
if ($objCore->strParameterId == '') {
	$objCore->strParameterId = trim(strip_tags($_GET['id']));
}

/*
 * DATA
 */
$strQuery = sprintf("SELECT * FROM mod_cars WHERE knr='%s' LIMIT 1", mysql_real_escape_string($objCore->strParameterId));
$resource = $objCore->getHelperDatabase()->query($strQuery);
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
	$arrRow["equip"] = Schmolck_Cars_Tool::getAusstattung($arrRow);

	/*
	 * OUTPUT
	 */
	$arrResult[] = $arrRow;
}
$objCore->arrCars = $arrResult;

/*
 * CHECK
 */
if (count($objCore->arrCars) == 0) {
	$objCore->getHelperMessage()->setMessage($objCore->getHelperTranslator()->_("Sorry, the selected vehicle is no longer available."));
	$objCore->getHelperRedirect()->local('cars/database/overview');
}