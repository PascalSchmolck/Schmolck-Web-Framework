<?php
/**
 * Schmolck_Gui_Navbar
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Gui_Navbar extends Schmolck_Gui{
	
	protected $_arrEntries = array();
	
	public function setEntries($arrEntries)
	{
		$this->_arrEntries = $arrEntries;
	}
}