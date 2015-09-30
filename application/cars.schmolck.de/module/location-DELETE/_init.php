<?php
/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
// - menu
$objCore->menu = array(
	array(
		'link' => 'location/page/emmendingen',
		'label' => 'Emmendingen'
	),
	array(
		'link' => 'location/page/muellheim',
		'label' => 'Müllheim'
	),
	array(
		'link' => 'location/page/vogtsburg',
		'label' => 'Vogtsburg'
	)
);
