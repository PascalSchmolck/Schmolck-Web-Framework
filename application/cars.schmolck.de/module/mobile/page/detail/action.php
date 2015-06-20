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
$objCore->strId = $objCore->getHelperElement()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strStyleClass = $objCore->getHelperElement()->getStyleClass();
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
$strParameterId = intval(trim(strip_tags($_GET['id'])));

/*
 * DATA
 */
$objCore->arrCars = $objCars->queryCarsSingle($strParameterId);

/*
 * CHECK
 */
// - check if database result empty
if (count($objCore->arrCars) == 0) {
    $strMessage = sprintf($objCore->getHelperTranslator()->_("Sorry, the selected vehicle %s is not available."), $strParameterId);
	$objCore->getHelperMessage()->setMessage($strMessage);
	$objCore->getHelperRedirect()->local('mobile');
}

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURL' => $objCore->strUrl,
));