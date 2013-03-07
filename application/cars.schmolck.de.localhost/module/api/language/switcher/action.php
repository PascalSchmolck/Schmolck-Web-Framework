<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
// - title
$objCore->getHelperHtml()->setPageTitle($objCore->getHelperTranslator()->_("Language Selector"));
// - parameters
$objCore->strId = $objCore->getHelperApi()->getId();
$objCore->strUri = $objCore->getHelperApplication()->getRequestUri();

/*
 * AJAX HANDLING
 */
if ($objCore->getHelperApi()->checkAjaxCall()) {
	$strLanguage = trim(strip_tags($_POST['language']));
	if ($strLanguage != '') {
		$objCore->getHelperTranslator()->setLanguage($strLanguage);
		$objCore->strLanguageSwitched = 'true';
	}
}

/*
 * SCRIPT
 */
$objCore->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURI' => $objCore->strUri,
	'SchmolckVAR1' => $objCore->strLanguageSwitched
));