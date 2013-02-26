<?php

/**
 * Schmolck_Framework_Helper_Translator
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Helper_Translator extends Schmolck_Framework_Helper {

	protected $_arrDictionary;

	/**
	 * Translate given string
	 * 
	 * @param string $string to translate
	 * @return string translated string
	 */
	public function _($string) {
		$this->_readLanguageFile();

		if (empty($this->_arrDictionary[$string])) {
			return $string;
		} else {
			return $this->_arrDictionary[$string];
		}
	}

	/**
	 * Read language file into dictionary
	 */
	protected function _readLanguageFile() {
		$strFile = $this->_getLanguageFile();
		if (file_exists($strFile)) {
			$objFile = new Schmolck_Tool_File_Po();
			$objFile->file = $strFile;
			foreach ($objFile->getArray() as $msgid => $msgstr) {
				$this->_arrDictionary[$msgid] = $msgstr;
			}
		}
	}

	/**
	 * Get language file 
	 * 
	 * @return string file location
	 */
	protected function _getLanguageFile() {
		$strPath = $this->objCore->get('application')->getPath() . '/translation';
		$strFileName = APPLICATION_LANGUAGE . '.po';
		return $strPath . '/' . $strFileName;
	}

}