<?php

/**
 * Schmolck_Framework_Helper_Mail
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Mail extends Schmolck_Framework_Helper {

	const TEMPLATE_FILE = 'mail.html';

	public function send($strSenderName, $strSenderAddress, $strRecipientName, $strRecipientAddress, $strSubject, $strMessage) {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);

		/*
		 * PREPARATION
		 */
		// - recipient
		$strRecipient = $strRecipientName . ' <' . $strRecipientAddress . '>';
		// - subject
		$strSubject = $_SERVER['HTTP_HOST'] . ' - ' . $strSubject;
		// - message
		$strMessageTemplate = file_get_contents($objCore->getHelperApplication()->getTemplatePath() . '/' . self::TEMPLATE_FILE);
		$arrMessageReplace = array(
			'#MESSAGE#' => str_replace("\n", "<br>", $strMessage),
		);
		$strMessage = str_replace(array_keys($arrMessageReplace), array_values($arrMessageReplace), $strMessageTemplate);
		// - headers
		$strHeader = 'MIME-Version: 1.0' . "\r\n";
		$strHeader .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$strHeader .= 'From:' . $strSenderName . ' <' . $strSenderAddress . '>' . "\r\n";
		$strHeader .= 'To:  ' . $strRecipientName . ' <' . $strRecipientAddress . '>' . "\r\n";

		/*
		 * SENDING
		 */
		$bMail = mail($strRecipient, $strSubject, $strMessage, $strHeader);
		if (!$bMail) {
			throw new Schmolck_Tool_Exception($objCore->getHelperTranslator()->_("Mail could not be sent"));
		}
	}

}