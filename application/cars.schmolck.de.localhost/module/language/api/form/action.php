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
	if ($_POST['language'] != '') {
		$objCore->getHelperTranslator()->setLanguage(strip_tags($_POST['language']));
	}
}

/*
 * SCRIPT
 */
$objCore->registerViewScriptReplace(array(
	'SchmolckID' => $this->strId,
	'SchmolckURI' => $this->strUri,
));