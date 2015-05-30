<?php

// INITIALISATION
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperElement()->getId();

// Redirect...
if ($objCore->getHelperApplication()->getBaseUrl() == 'http://www.cars.schmolck.de') { 
    // ...if www.cars instead of cars.schmolck.de has been called
    $objCore->getHelperRedirect()->external('http://cars.schmolck.de');
    exit();
}
