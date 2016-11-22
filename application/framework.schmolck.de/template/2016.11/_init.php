<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$strTemplatePath = $objCore->getHelperApplication()->getTemplatePath();

/*
 * LIBRARIES
 */
// - IE hacks
$objCore->registerLayoutScript('library/bower_components/css3-mediaqueries-js/css3-mediaqueries.js');
$objCore->registerLayoutScript('library/bower_components/html5shiv/dist/html5shiv.min.js');

// - jQuery
$objCore->registerLayoutScript('library/bower_components/jquery/dist/jquery.min.js');

// - Bootstrap
$objCore->registerLayoutScript('library/bower_components/bootstrap/dist/js/bootstrap.min.js');
$objCore->registerLayoutStyle('library/bower_components/bootstrap/dist/css/bootstrap.min.css');
$objCore->registerLayoutStyle('library/bower_components/bootstrap/dist/css/bootstrap-theme.min.css');
//$objCore->registerLayoutStyle('library/css/bootstrap/themes/cyborg/bootstrap.min.css');
// - SB Admin 2 Bootstrap Theme
$objCore->registerLayoutScript('library/startbootstrap-sb-admin-2/dist/js/sb-admin-2.min.js');
$objCore->registerLayoutStyle('library/startbootstrap-sb-admin-2/dist/css/sb-admin-2.min.css');
$objCore->registerLayoutStyle('library/startbootstrap-sb-admin-2/vendor/metisMenu/metisMenu.min.css');

// - Template
$objCore->registerLayoutScript($strTemplatePath . '/scripts.js');
$objCore->registerLayoutStyle($strTemplatePath . '/styles.less');

/*
 * TITLE
 */
if ($objCore->getHelperHtml()->getPageTitle() != '') {
    $strPageTitle = ucfirst($objCore->getHelperTranslator()->_($objCore->getModule())) . " - " . $objCore->getHelperHtml()->getPageTitle();
}

/*
 * NAVBAR
 */
$arrNavbarClass[$objCore->getModule()] = 'active';
