<?

/*
 * PREPARATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$strTemplatePath = $objCore->getHelperApplication()->getTemplatePath();
// - foreign scripts
$objCore->registerLayoutScript('lib/jquery/jquery-1.9.1.min.js');
//$objCore->registerLayoutScript('lib/jquery/ui/jquery-ui-1.10.1.custom.min.js');
// - framework scripts
$objCore->registerLayoutScript('lib/schmolck/framework/helper/api/api.js');
$objCore->registerLayoutScript('lib/schmolck/framework/helper/link/link.js');
// - layout scripts
$objCore->registerLayoutScript($strTemplatePath . '/scripts.js');

// - layout styles
$objCore->registerLayoutStyle($strTemplatePath . '/styles.default.less');
$objCore->registerLayoutStyle($strTemplatePath . '/styles.layout.less');

/*
 * TITLE
 */
if ($objCore->getHelperHtml()->getPageTitle() != '') {
	$strPageTitle = $objCore->getHelperHtml()->getPageTitle() . ' | ';
}