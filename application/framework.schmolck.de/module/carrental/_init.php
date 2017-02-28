<?php

/*
 * INIT
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->getHelperHtml()->setPageTitle($objCore->getHelperTranslator()->_("Car Rental"));
$objCore->menu = array(
    array(
        'link' => 'carrental/page/overview',
        'label' => $objCore->getHelperTranslator()->_("Overview"),
    ),
    array(
        'link' => 'carrental/page/photos',
        'label' => $objCore->getHelperTranslator()->_("Photos"),
    )
);

/*
 * ROUTE
 */
if ($objCore->getAction() == 'index') {
    $objCore->getHelperRedirect()->local('carrental/page/overview');
}