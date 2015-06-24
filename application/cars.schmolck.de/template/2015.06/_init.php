<?php
/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$strTemplatePath = $objCore->getHelperApplication()->getTemplatePath();

/*
 * SCRIPTS
 */
// - foreign (IE hacks)
$objCore->registerLayoutScript('library/bower_components/css3-mediaqueries-js/css3-mediaqueries.js');
$objCore->registerLayoutScript('library/bower_components/html5shiv/dist/html5shiv.min.js');
// - foreign (regular scripts)
$objCore->registerLayoutScript('library/bower_components/jquery/dist/jquery.min.js');
$objCore->registerLayoutScript('library/bower_components/bootstrap/dist/js/bootstrap.min.js');
// - layout
$objCore->registerLayoutScript($strTemplatePath . '/scripts.js');

/*
 * STYLES
 */
$objCore->registerLayoutStyle('library/bower_components/bootstrap/dist/css/bootstrap.min.css');
//$objCore->registerLayoutStyle('library/bower_components/bootstrap/dist/css/bootstrap-theme.min.css');
$objCore->registerLayoutStyle('library/css/bootstrap/themes/cyborg/bootstrap.min.css');
$objCore->registerLayoutStyle($strTemplatePath . '/styles.less');

/*
 * TITLE
 */
if ($objCore->getHelperHtml()->getPageTitle() != '') {
	$strPageTitle = $objCore->getHelperHtml()->getPageTitle() . ' | ';
}

/*
 * NAVBAR
 */
$arrNavbarClass[$objCore->getModule()] = 'active';