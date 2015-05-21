<?php
/*
 * SCRIPTS
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$strTemplatePath = $objCore->getHelperApplication()->getTemplatePath();
// - foreign scripts
//$objCore->registerLayoutScript('library/jquery/jquery-1.9.1.min.js');
$objCore->registerLayoutScript('library/bower_components/jquery/dist/jquery.min.js');
$objCore->registerLayoutScript('library/bower_components/bootstrap/dist/js/bootstrap.min.js');
// - framework scripts
$objCore->registerLayoutScript('library/schmolck/framework/helper/api/api.js');
$objCore->registerLayoutScript('library/schmolck/framework/helper/link/link.js');
// - layout scripts
$objCore->registerLayoutScript($strTemplatePath . '/scripts.js');

/*
 * STYLES
 */
$objCore->registerLayoutStyle('library/bower_components/bootstrap/dist/css/bootstrap.min.css');
$objCore->registerLayoutStyle('library/bower_components/bootstrap/dist/css/bootstrap-theme.min.css');
//$objCore->registerLayoutStyle($strTemplatePath . '/styles.default.less');
$objCore->registerLayoutStyle($strTemplatePath . '/styles.less');

/*
 * TITLE
 */
if ($objCore->getHelperHtml()->getPageTitle() != '') {
	$strPageTitle = $objCore->getHelperHtml()->getPageTitle() . ' | ';
}