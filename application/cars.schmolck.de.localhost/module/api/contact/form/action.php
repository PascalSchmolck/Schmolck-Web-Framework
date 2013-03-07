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
		$objCore->strErrorName = $objCore->getHelperTranslator()->_("Please enter your name name");
		$bError = true;
	}
	// - email
	if (!Schmolck_Tool_Validate::checkEmail($objCore->strEmail)) {
		$objCore->strErrorEmail = $objCore->getHelperTranslator()->_("Please enter a valid e-mail address");
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
		// - recipient
		$strRecipient = $objCore->strEmail;

		// - subject
		$strSubject = $objCore->getHelperApplication()->getName() . ' ' . $objCore->getHelperTranslator()->_("Request");

		// - message
		$strMessage = '
			<html>
				<head>
				<style type="text/css">
					body{
						font-face: arial;
						font-size: 10pt;
					}
				</style>
				</head>
				<body>
					' . $objCore->strMessage . '
				</body>
			</html>
		';

		// - proper header for HTML mails
		$strHeader = 'MIME-Version: 1.0' . "\r\n";
		$strHeader .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		// - additional headers
		$strHeader .= 'From:' . $objCore->strName . ' <' . $objCore->strEmail . '>' . "\r\n";
		$strHeader .= 'To:  ' . MAIL_SENDER_NAME . ' <' . MAIL_SENDER_ADDRESS . '>' . "\r\n";

		// - send mail
		$bMail = mail($strRecipient, $strSubject, $strMessage, $strHeader);

		if ($bMail) {
			$objCore->strMessageMail = $objCore->getHelperTranslator()->_("Message has been sent. Thank you.");
			Schmolck_Tool_Debug::info('Mail has been sent.');
		} else {
			$objCore->strMessageMail = $objCore->getHelperTranslator()->_("Sorry, message could not be sent.");
			Schmolck_Tool_Debug::error('Mail message could not be sent', __FILE__, __LINE__);
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