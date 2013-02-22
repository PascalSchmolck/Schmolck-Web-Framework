<?
/*
 * NAVIGATION
 */
$objNavbar = new Schmolck_Gui_Navbar('mainnav');
$objNavbar->setCore($this);
$objNavbar->setEntries(array(
	'home'	=>	array(
		'href' => '#',
		'label' => 'Home'
	),
	'link2'	=>	array(
		'href' => '#',
		'label' => 'Link2'
	),
	'link3'	=>	array(
		'href' => '#',
		'label' => 'Link3'
	),
	'link4'	=>	array(
		'href' => '#',
		'label' => 'Link4'
	),
	'link5'	=>	array(
		'href' => '#',
		'label' => 'Link5'
	),	
	'imprint'	=>	array(
		'href' => '#',
		'label' => 'Imprint'
	),	
));
$htmlNavbar = $objNavbar->getHtml();