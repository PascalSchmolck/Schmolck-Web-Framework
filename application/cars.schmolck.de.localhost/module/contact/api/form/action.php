<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$this->strId = $objCore->getHelperApi()->getId();
$this->strUri = $objCore->getHelperApplication()->getRequestUri();

/*
 * PARAMETER
 */
$objCore->strSend = strip_tags($_POST['send']);
$objCore->strName = strip_tags($_POST['name']);
$objCore->strEmail = strip_tags($_POST['email']);
$objCore->strMessage = strip_tags($_POST['message']);

/*
 * CHECK
 */
if ($objCore->strSend != '') {
	if (!Schmolck_Tool_Validate::checkEmail($objCore->strEmail)) {
		$objCore->strEmailError = $objCore->getHelperTranslator()->_("Please enter a valid e-mail address");
	}
}

require __DIR__ . '/output.phtml';
//require __DIR__ . '/2.phtml';

$arrReplace = array(
	'SchmolckID' => $this->strId,
	'SchmolckURI' => $this->strUri,
);
echo "<script>";
echo str_replace(array_keys($arrReplace), array_values($arrReplace), file_get_contents(__DIR__ . '/scripts.js'));
echo "</script>";