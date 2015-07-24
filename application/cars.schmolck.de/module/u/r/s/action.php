<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * PREPARATION
 */
$objUrl = new Url_Helper($objCore);
$objCore->arrUrls = $objUrl->getUrlStatistics();