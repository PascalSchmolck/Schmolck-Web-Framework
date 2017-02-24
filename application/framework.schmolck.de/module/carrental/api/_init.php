<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * LAYOUT
 */
// - switch of layout if in AJAX call
if ($objCore->getHelperElement()->checkAjaxCall()) {
	$objCore->setLayoutRendering(false);
}