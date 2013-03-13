<?php

/*
 * INCLUSION
 */
require_once 'lib/phpqrcode/phpqrcode.php';

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();

/*
 * QR-CODE
 */
$strUrl = $objCore->getHelperApplication()->getCurrentUrl();
error_log($strUrl);
$objCore->strQRImage = $objCore->getHelperCache()->getFilePath(md5($strUrl));
QRcode::png($strUrl, $objCore->strQRImage);

/*
 * PARAMETER
 */
// - id
$strParameterId = trim(strip_tags($_GET['id']));

/*
 * PREPARATION
 */
$objCars = new Schmolck_Cars_Helper($objCore);
$objCars->updateFromCSV();

/*
 * DATA
 */
$strQuery = sprintf("SELECT * FROM mod_cars WHERE knr='%s' LIMIT 1", mysql_real_escape_string($strParameterId));
$resource = $objCore->getHelperDatabase()->query($strQuery);
while ($arrRow = mysql_fetch_assoc($resource)) {
	/*
	 * PREPARATION
	 */
	$arrRow['name'] = Schmolck_Cars_Helper::getName($arrRow);
	$arrRow["EZ"] = Schmolck_Cars_Helper::getEz($arrRow);
	$arrRow["KM"] = Schmolck_Cars_Helper::getKm($arrRow);
	$arrRow["RP"] = Schmolck_Cars_Helper::getPrice($arrRow);
	$arrRow["color"] = Schmolck_Cars_Helper::getColor($arrRow);
	$arrRow["polster"] = Schmolck_Cars_Helper::getPolster($arrRow);
	$arrRow["image"] = Schmolck_Cars_Helper::getFirstImageUrl($arrRow);
	$arrRow["equip"] = Schmolck_Cars_Helper::getAusstattung($arrRow);

	/*
	 * OUTPUT
	 */
	$arrResult[] = $arrRow;
}
$objCore->arrCars = $arrResult;

/*
 * CHECK
 */
// - check if database result empty
if (count($objCore->arrCars) == 0) {
	$objCore->getHelperMessage()->setMessage($objCore->getHelperTranslator()->_("Sorry, the selected vehicle is no longer available."));
	$objCore->getHelperRedirect()->local('cars/database/overview');
}