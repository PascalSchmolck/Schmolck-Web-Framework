<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUri = $objCore->getHelperApplication()->getRequestUri();

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
	// - name
	if (trim($this->strName) == '') {
		$objCore->arrErrors['name'] = $objCore->getHelperTranslator()->_("Please enter your name name");
	}
	// - email
	if (!Schmolck_Tool_Validate::checkEmail($objCore->strEmail)) {
		$objCore->arrErrors['email'] = $objCore->getHelperTranslator()->_("Please enter a valid e-mail address");
	}
	// - message
	if (trim($this->strMessage) == '') {
		$objCore->arrErrors['message'] = $objCore->getHelperTranslator()->_("Please enter your message here");
	}
	
	Schmolck_Tool_Debug::debug(count($objCore->arrErrors), __FILE__, __LINE__);
}


/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $this->strId,
	'SchmolckURI' => $this->strUri,
));