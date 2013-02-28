<?

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);

/*
 * NAVIGATION
 */
$objNavbar = new Schmolck_Gui_Navbar('mainnav');
$objNavbar->setCore($this);
$objNavbar->setEntries(array(
	'link1' => array(
		'href' => '#',
		'label' => $objCore->getHelperTranslator->_("Link 1")
	),
	'link2' => array(
		'href' => '#',
		'label' => $objCore->getHelperTranslator->_("Link 2")
	),
	'link3' => array(
		'href' => '#',
		'label' => $objCore->getHelperTranslator->_("Link 3")
	),
	'link4' => array(
		'href' => '#',
		'label' => $objCore->getHelperTranslator->_("Link 4")
	),
));
$htmlNavbar = $objNavbar->getHtml();