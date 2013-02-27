<?
/*
 * JAVASCRIPT
 */
$this->registerViewJS('lib/js/schmolck/framework/api/element.js');


/*
 * NAVIGATION
 */
$objNavbar = new Schmolck_Framework_Gui_Navbar($this, 'mainnav');
$objNavbar->setEntries(array(
	'home' => array(
		'href' => '#',
		'label' => $this->get('translator')->_("Home")
	),
	'link2' => array(
		'href' => '#',
		'label' => $this->get('translator')->_("Mercedes-Benz")
	),
	'link3' => array(
		'href' => '#',
		'label' => $this->get('translator')->_("smart")
	),
	'imprint' => array(
		'href' => 'content/static/imprint',
		'label' => $this->get('translator')->_("Imprint")
	),
));
$htmlNavbar = $objNavbar->getHtml();

/*
 * LANGUAGE
 */
//$objLangSwitcher = new Schmolck_Framework_Gui_Dropdown_Langswitcher($this, 'langswitcher');
////$objLangSwitcher->setEntries($this->get('translator')->getLanguages());
//$htmlLangSwitcher = $objLangSwitcher->getHtml();

$strBaseUrl = $this->get('application')->getBaseUrl();
$htmlLangSwitcher = file_get_contents($strBaseUrl . 'api/element/langswitcher');