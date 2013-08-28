<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * REDIRECT
 */
if ($objCore->getModule() != 'portal') {
	$objCore->getHelperRedirect()->external('http://news.schmolck.de');
}