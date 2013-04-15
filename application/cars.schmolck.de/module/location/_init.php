<?php
/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
// - menu
$objCore->menu = array(
	array(
		'link' => 'location/emmendingen',
		'label' => 'Emmendingen'
	),
	array(
		'link' => 'location/muellheim',
		'label' => 'Müllheim'
	),
//	array(
//		'link' => 'location/vogtsburg',
//		'label' => 'Vogtsburg-Bischoffingen'
//	)
);
