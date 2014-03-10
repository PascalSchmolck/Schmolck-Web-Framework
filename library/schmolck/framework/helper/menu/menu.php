<?php

/**
 * Schmolck_Framework_Helper_Menu
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Menu extends Schmolck_Framework_Helper {

	/**
	 * Get html structure of given menu array
	 * 
	 * @param type $strClass menu style class
	 * @param type $arrMenu menu array
	 * @return string html menu
	 */
	public function getHtml($strClass, $arrMenu) {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		$strCurrentUri = $objCore->getHelperApplication()->getCurrentUri();
		
		/*
		 * CHECK
		 */
		// - do nothing if menu empty
		if (count($arrMenu) == 0) {
			return '';
		}
		
		/*
		 * PREPARATION
		 */
		foreach ($arrMenu as $arrEntry) {
			if ($strCurrentUri == $arrEntry['link']) {
				$strEntryClass = 'current';
			} else {
				$strEntryClass = '';
			}			
			$strEntryHtml .= "
				<li>
					<a href=\"{$arrEntry['link']}\" class=\"{$strEntryClass}\">
						{$arrEntry['label']}
					</a>
				</li>
			";
		}
		
		/*
		 * OUTPUT
		 */
		return "
			<div class=\"{$strClass}\">
				<ul>
					{$strEntryHtml}
				</ul>
			</div>
		";
	}
}