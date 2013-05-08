<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * REDIRECT
 */
$objCore->getHelperRedirect()->local('cars/database/overview');