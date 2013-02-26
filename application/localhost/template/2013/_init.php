<?
/*
 * NAVIGATION
 */
$objNavbar = new Schmolck_Gui_Navbar('mainnav');
$objNavbar->setCore($this);
$objNavbar->setEntries(array(
	'link1'	=>	array(
		'href' => '#',
		'label' => $this->get('translator')->_("Link 1")
	),
	'link2'	=>	array(
		'href' => '#',
		'label' => $this->get('translator')->_("Link 2")
	),
	'link3'	=>	array(
		'href' => '#',
		'label' => $this->get('translator')->_("Link 3")
	),
	'link4'	=>	array(
		'href' => '#',
		'label' => $this->get('translator')->_("Link 4")
	),	
));
$htmlNavbar = $objNavbar->getHtml();