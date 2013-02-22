<?
/*
 * NAVIGATION
 */
$objNavbar = new Schmolck_Gui_Navbar('mainnav');
$objNavbar->setCore($this);
$objNavbar->setEntries(array(
	'home'	=>	array(
		'href' => '#',
		'label' => 'Startseite'
	),
	'link2'	=>	array(
		'href' => '#',
		'label' => 'Mercedes-Benz'
	),
	'link3'	=>	array(
		'href' => '#',
		'label' => 'smart'
	),
	'link4'	=>	array(
		'href' => '#',
		'label' => 'Link4'
	),
	'imprint'	=>	array(
		'href' => '#',
		'label' => 'Imprint'
	),	
));
$htmlNavbar = $objNavbar->getHtml();