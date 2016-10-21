<?php

// INIT
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objHelper = new Controling_Helper($objCore);
$objCore->arrBusiness = $objHelper->getBusiness();