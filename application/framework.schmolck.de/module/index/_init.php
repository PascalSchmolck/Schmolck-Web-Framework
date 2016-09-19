<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * ROUTE
 */
if ($objCore->getAction() == 'index') {
    $objCore->getHelperRedirect()->local('index/index/demo');
}