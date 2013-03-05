<?php
/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
if ($objCore->checkAjaxCall()) { 
	$objCore->setLayoutRendering(false);
}