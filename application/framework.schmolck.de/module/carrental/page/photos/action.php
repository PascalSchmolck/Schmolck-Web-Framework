<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * PARAMETER
 */
$objCore->strSend = strip_tags($_POST['send']);

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

/*
 * CHECK
 */
if ($objCore->strSend != '') {

    if ($_FILES['file']) {
        $FILES = reArrayFiles($_FILES['file']);

        foreach ($FILES as $FILE) {
            $uploaddir = "C:/temp/uploads/";
            $uploadfile = $uploaddir . basename($FILE['name']);

            if (move_uploaded_file($FILE['tmp_name'], $uploadfile)) {
                $objCore->getHelperMessage()->setMessage("Datei ist valide und wurde erfolgreich hochgeladen");
            } else {
                $objCore->getHelperMessage()->setMessage("Möglicherweise eine Dateiupload-Attacke!");
            }
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