<?php

$objCore = Schmolck_Framework_Core::getInstance($this);
$this->arrLanguages = $objCore->getHelperTranslator()->getLanguages();
