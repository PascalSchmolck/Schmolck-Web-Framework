<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->getHelperHtml()->setPageTitle($objCore->getHelperTranslator()->_("Controling"));
$objCore->menu = array(
    array(
        'link' => 'controling/page/overview',
        'label' => 'Overview'
    ),
    array(
        'link' => 'controling/page/details',
        'label' => 'Details'
    )
);


/*
 * ROUTE
 */
if ($objCore->getAction() == 'index') {
    $objCore->getHelperRedirect()->local('controling/page/overview');
}