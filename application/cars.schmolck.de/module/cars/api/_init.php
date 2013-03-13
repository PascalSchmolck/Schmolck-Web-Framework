<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
// - switch of layout if in AJAX call
if ($objCore->getHelperApi()->checkAjaxCall()) {
	$objCore->setLayoutRendering(false);
}