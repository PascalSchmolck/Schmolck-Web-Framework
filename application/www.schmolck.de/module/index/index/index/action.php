<?php

// INITIALISATION
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();

// REDIRECT
//$objCore->getHelperRedirect()->external('http://news.schmolck.de');