<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * PARAMETER
 */
$objCore->strSend = strip_tags($_POST['send']);

/*
 * CHECK
 */
if ($objCore->strSend != '') {

    if ($_FILES['file']) {
        $FILES = Schmolck_Tool_Upload::reArrayFiles($_FILES['file']);

        foreach ($FILES as $FILE) {
            $strUploadDir = "C:/temp/uploads/";
            $strUploadFile = $strUploadDir . basename($FILE['name']);

            if (move_uploaded_file($FILE['tmp_name'], $strUploadFile)) {
                $arrFiles[] = basename($FILE['name']);
            }
        }
        $objCore->getHelperMessage()->setMessage(sprintf($objCore->getHelperTranslator()->_("Files %s successfully uploaded"), implode(', ', $arrFiles)));
    }
}