<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
// - title
$objCore->getHelperHtml()->setPageTitle($objCore->getHelperTranslator()->_("Language Selector"));
// - parameters
$objCore->strId = $objCore->getHelperElement()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();

/*
 * AJAX HANDLING
 */
if ($objCore->getHelperElement()->checkAjaxCall()) {
	$strLanguage = trim(strip_tags($_POST['language']));
	if ($strLanguage != '') {
		$objCore->getHelperTranslator()->setLanguage($strLanguage);
		$objCore->strLanguageSwitched = 'true';
	}
}

/*
 * SCRIPT
 */
$objCore->getHelperScripts()->registerViewScriptReplace(array(
	'SchmolckID' => $objCore->strId,
	'SchmolckURL' => $objCore->strUrl,
	'SchmolckVAR1' => $objCore->strLanguageSwitched
));