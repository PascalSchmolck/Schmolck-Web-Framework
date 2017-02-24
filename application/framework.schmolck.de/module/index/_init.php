<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * MENU
 */
$objCore->menu = array(
    array(
        'link' => 'index/index/demo',
        'label' => $objCore->getHelperTranslator()->_("Active"),
    ),
    array(
        'link' => 'index',
        'label' => $objCore->getHelperTranslator()->_("Inactive"),
    ),
);
/*
 * ROUTE
 */
if ($objCore->getAction() == 'index') {
    $objCore->getHelperRedirect()->local('index/index/demo');
}