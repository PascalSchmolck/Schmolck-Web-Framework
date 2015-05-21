<?php

/**
 * Schmolck_Framework_Helper_Menu
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
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
				$strEntryClass = 'active';
			} else {
				$strEntryClass = '';
			}			
			$strEntryHtml .= "
				<li role=\"presentation\" class=\"{$strEntryClass}\">
					<a href=\"{$arrEntry['link']}\">
						{$arrEntry['label']}
					</a>
				</li>
			";
		}
		
		/*
		 * OUTPUT
		 */
		return "
         <ul class=\"nav nav-tabs {$strClass}\" role=\"tablist\">              
            {$strEntryHtml}
         </ul>
		";
	}
}