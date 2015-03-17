<?php

// INITIALISATION
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();

// REDIRECT
$strModule = $objCore->getModule();
switch ($strModule) {
    default:
        $strUrl = 'http://news.schmolck.de';
        break;
    case 'cars':
    case 'mobile':
    case 'verkauf':
    case 'auto':
        $strUrl = 'http://cars.schmolck.de';
        break;
}
$objCore->getHelperRedirect()->external($strUrl);
exit();