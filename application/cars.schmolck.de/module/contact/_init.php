<?php
/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
// - menu
$objCore->menu = array(
	array(
		'link' => 'contact/emmendingen',
		'label' => 'Emmendingen'
	),
	array(
		'link' => 'contact/muellheim',
		'label' => 'Müllheim'
	),
	array(
		'link' => 'contact/vogtsburg',
		'label' => 'Vogtsburg-Bischoffingen'
	)
);
