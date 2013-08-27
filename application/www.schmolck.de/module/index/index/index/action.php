<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();

/*
 * REDIRECT
 */
//$objCore->getHelperRedirect()->local('cars/database/overview');