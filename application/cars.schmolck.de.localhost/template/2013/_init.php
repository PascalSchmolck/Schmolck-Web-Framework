<?

/*
 * PREPARATION
 */
$strTemplatePath = $this->get('application')->getTemplatePath();

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