<?php
/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
// - menu
$objCore->menu = array(
	array(
		'link' => 'contact/page/emmendingen',
		'label' => 'Emmendingen'
	),
	array(
		'link' => 'contact/page/muellheim',
		'label' => 'Müllheim'
	),
	array(
		'link' => 'contact/page/vogtsburg',
		'label' => 'Vogtsburg'
	)
);
