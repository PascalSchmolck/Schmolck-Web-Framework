<?

/*
 * PREPARATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$strTemplatePath = $objCore->getHelperApplication()->getTemplatePath();
$objCore->registerLayoutScript('lib/js/schmolck/framework/api/element.js');
$objCore->registerLayoutScript('lib/js/schmolck/framework/mail/link.js');

/*
 * TITLE
 */
if ($objCore->getHelperHtml()->getPageTitle() != '') {
	$strPageTitle = ' | ' . $objCore->getHelperHtml()->getPageTitle();
}