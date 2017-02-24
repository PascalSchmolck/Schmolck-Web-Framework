<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objHelper = new Administration_Helper($objCore);

/*
 * PARAMETER
 */
$objCore->strSend = strip_tags($_POST['send']);
$objCore->strName = strip_tags($_POST['name']);
$objCore->strPassword = strip_tags($_POST['password']);

/*
 * CHECK
 */
if ($objCore->strSend != '') {
    $objCore->strUser = $objHelper->verifyLoginData($strUser, $strPassword);
}

$objCore->strUser = $objHelper->verifyLoginData($strUser, $strPassword);

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
    'SchmolckID' => $objCore->getHelperElement()->getId(),
    'SchmolckURL' => $objCore->getHelperApplication()->getRequestUrl(),
));