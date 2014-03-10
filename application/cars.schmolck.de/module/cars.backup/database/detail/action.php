<?php

/*
 * INCLUSION
 */
require_once 'library/phpqrcode/phpqrcode.php';

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();
// - cars
$objCars = new Cars_Helper($objCore);

/*
 * QR-CODE
 */
$strUri = $objCore->getHelperApplication()->getCurrentUri();
$strBaseUrl = $objCore->getHelperApplication()->getBaseUrl();
$objCore->strQRImage = $objCore->getHelperCache()->getFilePath(md5($strBaseUrl.'/'.$strUri));
QRcode::png($strBaseUrl.'/'.$strUri, $objCore->strQRImage);

/*
 * PARAMETER
 */
// - id
$strParameterId = trim(strip_tags($_GET['id']));

/******************************************************************************/
/*
 * REDIRECT
 */
// - transitional solution
$objCore->getHelperRedirect()->local("mobile/database/detail/id/{$strParameterId}");

/******************************************************************************/

/*
 * DATA
 */
$strQuery = sprintf("SELECT * FROM mod_cars WHERE knr='%s' LIMIT 1", mysql_real_escape_string($strParameterId));
$resource = $objCore->getHelperDatabase()->query($strQuery);
while ($arrRow = mysql_fetch_assoc($resource)) {
	$arrRow['name'] = $objCars->extractName($arrRow);
	$arrRow["EZ"] = $objCars->extractEz($arrRow);
	$arrRow["KM"] = $objCars->extractKm($arrRow);
	$arrRow["RP"] = $objCars->extractPrice($arrRow);
	$arrRow["color"] = $objCars->extractColor($arrRow);
	$arrRow["polster"] = $objCars->extractPolster($arrRow);
	$arrRow["equip"] = $objCars->extractAusstattung($arrRow);
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

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURL' => $objCore->strUrl,
));