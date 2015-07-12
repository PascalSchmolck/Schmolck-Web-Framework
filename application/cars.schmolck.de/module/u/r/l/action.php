<?php

/*
 * INCLUSION
 */
require_once 'library/phpqrcode/phpqrcode.php';

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * PARAMETER
 */
$objCore->strHash = strip_tags($_GET['s']);
$objCore->strUrl = strip_tags($_POST['url']);

/*
 * PROCESSING
 */
// - redirect
if ($objCore->strHash != '') {
    $objUrl = new Url_Helper($objCore);
    try {
        $objCore->getHelperRedirect()->external($objUrl->decodeUrl($objCore->strHash));
    } catch (Exception $objException) {
        switch ($objException->getCode()) {
            default:
                throw $objException;
            case 1:
                $objCore->strErrorMessage = $objCore->getHelperTranslator()->_("Sorry, the called URL is unknown");
                break;
        }
    }
}
// - shorten
if ($objCore->strUrl != '') {
    $objUrl = new Url_Helper($objCore);
    $objCore->strHash = $objUrl->encodeUrl($objCore->strUrl);

    // - QR-Code
    $strUri = $objCore->getHelperApplication()->getCurrentUri();
    $strBaseUrl = $objCore->getHelperApplication()->getBaseUrl();
    $objCore->strQRImage = $objCore->getHelperCache()->getFilePath(md5($strBaseUrl . '/' . $strUri));
    QRcode::png($objCore->strHash, $objCore->strQRImage);
}

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
    'SchmolckID' => $objCore->getHelperElement()->getId(),
    'SchmolckURL' => $objCore->getHelperApplication()->getRequestUrl(),
));
