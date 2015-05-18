<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();
$objCore->strApi = $objCore->getHelperApi()->getIdentifier();
$objCars = new Mobile_Helper($objCore);

/*
 * PARAMETER
 */
$strId = Schmolck_Tool_Memory::auto($objCore->strApi, 'id', strip_tags($_GET['id']));
$objCore->strSend = strip_tags($_POST['send']);
$objCore->strName = strip_tags($_POST['name']);
$objCore->strEmail = strip_tags($_POST['email']);
$objCore->strMessage = strip_tags($_POST['message']);

/*
 * CHECK (SUBJECT)
 */
// - subject
if ($strId == '') {
   $objCore->strSubject = $objCore->getHelperTranslator()->_("Request for a vehicle");
} else {
   $objCore->strSubject = sprintf($objCore->getHelperTranslator()->_("Request for the vehicle %s"), $strId);
}

/*
 * CHECK (SENDING)
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
      try {
         // - get price
         $arrCarResult = $objCars->queryCarsSingle($strId);
         $strPrice = number_format(str_replace('.', '', strval($arrCarResult[0][preis])), 2, '.', '');
         // - fill template with data
         $arrReplace = array(
             '#id' => $strId,
             '#price' => $strPrice,
             '#name' => $objCore->strName,
             '#email' => $objCore->strEmail,
             '#message' => $objCore->strMessage
         );
         // - append lead message (XML)
         $strXmlFile = $objCore->getHelperApplication()->getActionPath() . '/' . 'template.xml';
         $strXmlMessage = str_replace(array_keys($arrReplace), array_values($arrReplace), file_get_contents($strXmlFile));
         // - create final message
         $objCore->strMessage = $objCore->strMessage . '\n \nXML-CODE: <pre>' . $strXmlMessage . '</pre>';
         // - send mail
         $objCore->getHelperMail()->send(MOBILE_SENDER_NAME, MOBILE_SENDER_ADDRESS, MOBILE_RECIPIENT_NAME, MOBILE_RECIPIENT_ADDRESS, $objCore->strSubject, $objCore->strMessage);
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
    'SchmolckID' => $objCore->strId,
    'SchmolckURL' => $objCore->strUrl,
));