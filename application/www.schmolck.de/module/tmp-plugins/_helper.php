<?php

/**
 * Plugins_Helper
 * 
 * @package www.schmolck.de
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Plugins_Helper extends Schmolck_Framework_Helper {

	public function __construct(Schmolck_Framework_Core $objCore) {
		parent::__construct($objCore);
	}

	/**
	 * Get all available images within given path
	 * 
	 * @param string $strPath path
	 * @return array of image files
	 */
	public function getImages($strPath) {	
		/*
		 * PROCESSING
		 */
		// - get array of all corresponding image files
		$arrFiles = scandir($strPath);
		// - cycle through all source files
		foreach ($arrFiles as $strFile) {
			// - do not handle dirs
			if (in_array($strFile, array(".",".."))) continue;
			// - do only collect files that match to "*.jpg"
			if (!preg_match('/\.JPG$/i', $strFile)) continue;
			// - collect
			$arrResult[] = $strPath.'/'.$strFile;
		}
		
		/*
		 * CHECK
		 */
		// - return dummy if no image file found
		if (count($arrResult) == 0) {
			return array(
				'images/www.schmolck.de/plugins/dummy.jpg'
			);
		}
		
		/*
		 * RETURN
		 */
		return $arrResult;
	}	

	
}