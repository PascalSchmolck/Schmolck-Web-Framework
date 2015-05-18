<?php

/**
 * Schmolck_Framework_Helper_Mail
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Framework_Helper_Mail extends Schmolck_Framework_Helper {

   const TEMPLATE_PLAIN = 'mail.txt';
   const TEMPLATE_HTML = 'mail.html';
   const MODE_PLAIN = false;
   const MODE_HTML = true;

   /**
    * Send mail either in HTML or PLAINTEXT mode
    * 
    * @param string $strSenderName
    * @param string $strSenderAddress
    * @param string $strRecipientName
    * @param string $strRecipientAddress
    * @param string $strSubject
    * @param string $strMessage
    * @param boolean $bHtmlMode
    * @throws Schmolck_Tool_Exception
    */
   public function send($strSenderName, $strSenderAddress, $strRecipientName, $strRecipientAddress, $strSubject, $strMessage, $bHtmlMode) {
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
      switch ($bHtmlMode) {
         case self::MODE_HTML:
            // - template
            $strMessageTemplate = file_get_contents($objCore->getHelperApplication()->getTemplatePath() . '/' . self::TEMPLATE_HTML);
            $arrMessageReplace = array(
                '#name' => $strSenderName,
                '#email' => $strSenderAddress,
                '#message' => str_replace("\n", "<br>", $strMessage)
            );
            $strMessage = str_replace(array_keys($arrMessageReplace), array_values($arrMessageReplace), $strMessageTemplate);
            // - headers
            $strHeader = $this->_getHtmlHeader($strSenderName, $strSenderAddress, $strRecipientName, $strRecipientAddress);
            break;
         case self::MODE_PLAIN:
            // - template
            $strMessageTemplate = file_get_contents($objCore->getHelperApplication()->getTemplatePath() . '/' . self::TEMPLATE_PLAIN);
            $arrMessageReplace = array(
                '#name' => $strSenderName,
                '#email' => $strSenderAddress,
                '#message' => $strMessage
            );
            $strMessage = str_replace(array_keys($arrMessageReplace), array_values($arrMessageReplace), $strMessageTemplate);
            // - headers
            $strHeader = $this->_getPlainHeader($strSenderName, $strSenderAddress, $strRecipientName, $strRecipientAddress);
            break;
      }

      /*
       * SENDING
       */
      $bMail = mail($strRecipient, $strSubject, $strMessage, $strHeader);
      if (!$bMail) {
         throw new Schmolck_Tool_Exception($objCore->getHelperTranslator()->_("Mail could not be sent"));
      }
   }

   /**
    * Get html header
    * 
    * @param string $strSenderName
    * @param string $strSenderAddress
    * @param string $strRecipientName
    * @param string $strRecipientAddress
    * @return string
    */
   private function _getHtmlHeader($strSenderName, $strSenderAddress, $strRecipientName, $strRecipientAddress) {
      $arrHeader = array();
      $arrHeader[] = "MIME-Version: 1.0";
      $arrHeader[] = "Content-type: text/html; charset=utf-8";
      $arrHeader[] = "From: {$strSenderName} <{$strSenderAddress}>";
      $arrHeader[] = "To: {$strRecipientName} <{$strRecipientAddress}>";
      return implode("\r\n", $arrHeader);
   }

   /**
    * Get plain text header
    * 
    * @param string $strSenderName
    * @param string $strSenderAddress
    * @param string $strRecipientName
    * @param string $strRecipientAddress
    * @return string
    */
   private function _getPlainHeader($strSenderName, $strSenderAddress, $strRecipientName, $strRecipientAddress) {
      $arrHeader = array();
      $arrHeader[] = "MIME-Version: 1.0";
      $arrHeader[] = "Content-type: text/plain; charset=utf-8";
      $arrHeader[] = "From: {$strSenderName} <{$strSenderAddress}>";
      $arrHeader[] = "To: {$strRecipientName} <{$strRecipientAddress}>";
      return implode("\r\n", $arrHeader);
   }

}