<?php

/*
 * INITIALISATION
 */
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strStyleClass = $objCore->getHelperApi()->getStyleClass();

/******************************************************************************/
/*
 * REDIRECT
 */
// - transitional solution
$objCore->getHelperRedirect()->local("mobile");

/******************************************************************************/

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURL' => $objCore->strUrl,
));