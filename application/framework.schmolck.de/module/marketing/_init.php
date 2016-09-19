<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
// - menu
$objCore->menu = array(
    array(
        'link' => 'marketing/page/overview',
        'label' => 'Overview'
    ),
    array(
        'link' => 'marketing/page/quality',
        'label' => 'Data Management'
    )
);


/*
 * ROUTE
 */
if ($objCore->getAction() == 'index') {
    $objCore->getHelperRedirect()->local('marketing/page/overview');
}