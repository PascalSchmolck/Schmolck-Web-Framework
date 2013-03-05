<?php
/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
if ($objCore->getHelperApi()->checkAjaxCall()) { 
	$objCore->setLayoutRendering(false);
}