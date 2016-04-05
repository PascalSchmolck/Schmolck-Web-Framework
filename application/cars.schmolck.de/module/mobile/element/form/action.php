<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCars = new Mobile_Helper($objCore);

/*
 * PARAMETER
 */
$objCore->strId = strip_tags($_POST['id']);
$objCore->strSend = strip_tags($_POST['send']);
$objCore->strName = strip_tags($_POST['name']);
$objCore->strEmail = strip_tags($_POST['email']);
$objCore->strSubject = strip_tags($_POST['subject']);
$objCore->strMessage = strip_tags($_POST['message']);

/*
 * CHECK (SUBJECT)
 */
// - subject
if ($objCore->strId == '') {
    if ($objCore->strSubject == '') {
        $objCore->strSubject = $objCore->getHelperTranslator()->_("General request");
    }
    $objCore->bAutoSubject = false;
} else {
    $objCore->strSubject = sprintf($objCore->getHelperTranslator()->_("Request for the vehicle %s"), $objCore->strId);
    $objCore->bAutoSubject = true;
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
            // - get price
            $arrCarResult = $objCars->queryCarsSingle($objCore->strId);
            $strPrice = number_format(doubleval(str_replace('.', '', strval($arrCarResult[0][preis]))), 2, '', '');
            // - fill template with data
            $arrReplace = array(
                '#id' => $objCore->strId,
                '#price' => $strPrice,
                '#name' => $objCore->strName,
                '#email' => $objCore->strEmail,
                '#message' => $objCore->strMessage
            );
            // - append lead message (XML)
            $strXmlFile = $objCore->getHelperApplication()->getActionPath() . '/' . 'template.xml';
            $strXmlMessage = str_replace(array_keys($arrReplace), array_values($arrReplace), file_get_contents($strXmlFile));
            // - create final message
            $objCore->strMessage = $objCore->strMessage
                    . PHP_EOL
                    . PHP_EOL
                    . 'XML-CODE:'
                    . PHP_EOL
                    . '<pre>'
                    . $strXmlMessage
                    . '</pre>';
            // - send mail
            $objCore->getHelperMail()->send(MOBILE_SENDER_NAME, MOBILE_SENDER_ADDRESS, MOBILE_RECIPIENT_NAME, MOBILE_RECIPIENT_ADDRESS, $objCore->strSubject, $objCore->strMessage, Schmolck_Framework_Helper_Mail::MODE_PLAIN);
            $objCore->strMessageMail = $objCore->getHelperTranslator()->_("Message has been sent. Thank you.");
            Schmolck_Tool_Debug::info("MAIL: {$objCore->strName} <{$objCore->strEmail}>: {$objCore->strSubject}: {$objCore->strMessage}", __FILE__, __LINE__);
        } catch (Exception $objException) {
            $objCore->strMessageMail = $objException->getMessage();
        }
    }
}

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
    'SchmolckID' => $objCore->getHelperElement()->getId(),
    'SchmolckURL' => $objCore->getHelperApplication()->getRequestUrl(),
));