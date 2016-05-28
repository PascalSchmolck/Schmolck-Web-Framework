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
