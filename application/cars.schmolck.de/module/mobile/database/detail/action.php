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
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();
// - cars
$objCars = new Mobile_Helper($objCore);

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

/*
 * DATA
 */
$objCore->arrCars = $objCars->queryCarsSingle($strParameterId);

/*
 * CHECK
 */
// - check if database result empty
if (count($objCore->arrCars) == 0) {
	$objCore->getHelperMessage()->setMessage($objCore->getHelperTranslator()->_("Sorry, the selected vehicle is no longer available."));
	$objCore->getHelperRedirect()->local('mobile/search');
}

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURL' => $objCore->strUrl,
));