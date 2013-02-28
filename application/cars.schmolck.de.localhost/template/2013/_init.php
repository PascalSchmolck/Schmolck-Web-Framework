<?

/*
 * PREPARATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$strTemplatePath = $objCore->getHelperApplication()->getTemplatePath();
$this->registerViewJS('lib/js/schmolck/framework/ajax/ajax.js');
		
/*
 * NAVIGATION
 */
$objNavbar = new Schmolck_Framework_Gui_Navbar($this, 'mainnav');
$objNavbar->setEntries(array(
	'home' => array(
		'href' => '#',
		'label' => $objCore->getHelperTranslator()->_("Home")
	),
	'link2' => array(
		'href' => '#',
		'label' => $objCore->getHelperTranslator()->_("Mercedes-Benz")
	),
	'link3' => array(
		'href' => '#',
		'label' => $objCore->getHelperTranslator()->_("smart")
	),
	'imprint' => array(
		'href' => 'content/static/imprint',
		'label' => $objCore->getHelperTranslator()->_("Imprint")
	),
));
$htmlNavbar = $objNavbar->getHtml();


$objLangSwitcher = new Schmolck_Framework_Gui_Dropdown_Langswitcher($this, 'langswitcher');
$htmlLangSwitcher = $objLangSwitcher->getHtml();