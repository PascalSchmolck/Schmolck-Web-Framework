<?php

/*
 * INCLUSION
 */
require_once 'lib/phpqrcode/phpqrcode.php';

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();
// - cars
$objCars = new Schmolck_Cars_Helper($objCore);

/*
 * QR-CODE
 */
$strUrl = $objCore->getHelperApplication()->getCurrentUrl();
$objCore->strQRImage = $objCore->getHelperCache()->getFilePath(md5($strUrl));
QRcode::png($strUrl, $objCore->strQRImage);

/*
 * PARAMETER
 */
// - id
$strParameterId = trim(strip_tags($_GET['id']));

/*
 * DATA
 */
$strQuery = sprintf("SELECT * FROM mod_cars WHERE knr='%s' LIMIT 1", mysql_real_escape_string($strParameterId));
$resource = $objCore->getHelperDatabase()->query($strQuery);
while ($arrRow = mysql_fetch_assoc($resource)) {
	$arrRow['name'] = $objCars->getName($arrRow);
	$arrRow["EZ"] = $objCars->getEz($arrRow);
	$arrRow["KM"] = $objCars->getKm($arrRow);
	$arrRow["RP"] = $objCars->getPrice($arrRow);
	$arrRow["color"] = $objCars->getColor($arrRow);
	$arrRow["polster"] = $objCars->getPolster($arrRow);
	$arrRow["image"] = $objCars->getFirstImageUrl($arrRow);
	$arrRow["equip"] = $objCars->getAusstattung($arrRow);
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