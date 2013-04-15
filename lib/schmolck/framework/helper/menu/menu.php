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
			$strEntryHtml .= "
				<li>
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
			<div class=\"{$strClass}\">
				<ul>
					{$strEntryHtml}
				</ul>
			</div>
		";
	}
}