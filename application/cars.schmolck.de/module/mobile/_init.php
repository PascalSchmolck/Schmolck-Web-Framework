<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
// - menu
$objCore->menu = array(
    array(
        'link' => 'mobile/page/list',
        'label' => $objCore->getHelperTranslator()->_("List")
    ),
    array(
        'link' => 'mobile/page/gallery',
        'label' => $objCore->getHelperTranslator()->_("Gallery")
    )
);

// ********
// REDIRECT
// ********
// - to new module on TYPO3 website 
$strParameterId = intval(trim(strip_tags($_GET['id'])));
if ($strParameterId != 0) {
    $objCore->getHelperRedirect()->external("http://www.schmolck.de/suche/fahrzeugsuche/fahrzeug-details/$strParameterId/");
  
} else {
    $objCore->getHelperRedirect()->external("http://www.schmolck.de/suche/fahrzeugsuche/");
}
exit();