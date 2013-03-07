<?

/*
 * PREPARATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$strTemplatePath = $objCore->getHelperApplication()->getTemplatePath();
$objCore->registerLayoutScript('lib/js/schmolck/framework/ajax/ajax.js');
$objCore->registerLayoutScript('lib/js/schmolck/framework/api/element.js');
$objCore->registerLayoutScript('lib/js/schmolck/framework/mail/link.js');

/*
 * TITLE
 */
if ($objCore->getHelperHtml()->getPageTitle() != '') {
	$strPageTitle = ' | ' . $objCore->getHelperHtml()->getPageTitle();
}

/*
 * NAVIGATION
 */
//$objNavbar = new Schmolck_Framework_Gui_Navbar($this, 'mainnav');
//$objNavbar->setEntries(array(
//	'home' => array(
//		'href' => '',
//		'label' => $objCore->getHelperTranslator()->_("Home")
//	),
//	'location' => array(
//		'href' => 'content/static/location',
//		'label' => $objCore->getHelperTranslator()->_("Location")
//	),
//	'contact' => array(
//		'href' => 'content/static/contact',
//		'label' => $objCore->getHelperTranslator()->_("Contact")
//	),
//	'imprint' => array(
//		'href' => 'content/static/imprint',
//		'label' => $objCore->getHelperTranslator()->_("Imprint")
//	),
//));
//$htmlNavbar = $objNavbar->getHtml();


//$objLangSwitcher = new Schmolck_Framework_Gui_Dropdown_Langswitcher($this, 'langswitcher');
//$htmlLangSwitcher = $objLangSwitcher->getHtml();