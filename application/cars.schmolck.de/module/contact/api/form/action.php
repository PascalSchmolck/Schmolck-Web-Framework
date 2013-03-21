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
$objCore->strSubject = strip_tags($_POST['subject']);
$objCore->strMessage = strip_tags($_POST['message']);

/*
 * CHECK
 */
if ($objCore->strSend != '') {
	// - name
	if (trim($this->strName) == '') {
		$objCore->strErrorName = $objCore->getHelperTranslator()->_("Please enter your name name");
		$bError = true;
	}
	// - email
	if (!Schmolck_Tool_Validate::checkEmail($objCore->strEmail)) {
		$objCore->strErrorEmail = $objCore->getHelperTranslator()->_("Please enter a valid e-mail address");
		$bError = true;
	}
	// - subject
	if (trim($this->strSubject) == '') {
		$objCore->strErrorSubject = $objCore->getHelperTranslator()->_("Please enter a subject");
		$bError = true;
	}
	// - message
	if (trim($this->strMessage) == '') {
		$objCore->strErrorMessage = $objCore->getHelperTranslator()->_("Please enter your message here");
		$bError = true;
	}

	/*
	 * SENDING
	 */
	if (!$bError) {
		try {
			$objCore->getHelperMail()->send($objCore->strName, $objCore->strEmail, MAIL_RECIPIENT_NAME, MAIL_RECIPIENT_ADDRESS, $objCore->strSubject, $objCore->strMessage);
			$objCore->strMessageMail = $objCore->getHelperTranslator()->_("Message has been sent. Thank you.");
		} catch (Exception $objException) {
			$objCore->strMessageMail = $objException->getMessage();
		}
	}
}

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $this->strId,
	'SchmolckURI' => $this->strUri,
));