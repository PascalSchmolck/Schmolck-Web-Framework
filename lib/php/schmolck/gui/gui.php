<?php
/**
 * Schmolck_Gui
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Gui {

	protected $_objCore;
	protected $_arrAttributes;

	public function __construct($strId) {
		$this->SetAttribute('id', $strId);
		$this->SetAttribute('class', implode(" ", $this->_GetClassesAscending()));
	}

	public function __get($strKey) {
		if (array_key_exists($strKey, $this->_arrAttributes)) {
			return $this->_arrAttributes[$strKey];
		}else{
			Schmolck_Framework_Debug::warning("Attirbute '{$strKey}' not defined!");
		}
	}

	public function setCore($_objCore) {
		$this->_objCore = $_objCore;
	}

	public function setAttribute($strKey, $strValue) {
		$this->_arrAttributes[$strKey] = $strValue;
	}

	public function setAttributes(Array $arrAttributes) {
		$this->_arrAttributes = array_merge($this->_arrAttributes, $arrAttributes);
	}

	/**
	 * Get HTML string output
	 * 
	 * @return string HTML output
	 */
	public function getHtml()
	{
		ob_start();
			$this->render();
			$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	/**
	 * Render HTML output
	 */
	public function render()
	{
		$this->_registerStyles();
		$this->_registerScripts();
		$this->_renderHtml();
	}

	protected function _getLibraryDir() {
		return "lib/php";
	}

	protected function _renderHtml()
	{
		$classes = $this->_GetClassesDescending();
		foreach ($classes as $class) {
			$file = "{$this->_getLibraryDir()}/{$this->_GetClassDir($class)}/{$this->_GetClassFileName($class)}.phtml";
			if (file_exists($file)) {
				require($file);
				echo "\n";
				return;
			}
		}
	}

	protected function _registerStyles()
	{
		$classes = $this->_getClassesAscending();
		foreach ($classes as $class) {
			$file = "{$this->_getLibraryDir()}/{$this->_GetClassDir($class)}/{$this->_GetClassFileName($class)}.css";
			if (file_exists($file)) {
				$this->_objCore->registerViewStyle($file);
			}
		}
	}

	protected function _registerScripts()
	{
		$classes = $this->_getClassesAscending();
		foreach ($classes as $class) {
			$file = "{$this->_getLibraryDir()}/{$this->_GetClassDir($class)}/{$this->_GetClassFileName($class)}.js";
			if (file_exists($file)) {
				$this->_objCore->registerViewScript($file);
			}
		}
	}

	protected function _getClassesDescending()
	{
		$object = $this;
		$parents = array();
		$parents[] = get_class($object);
		for($i=1; $i<20; $i++)
		{
			$parent = get_parent_class($this);
			if (!empty($parent))
			{
				$parents[] = $parent;
				$object = $parent;
			}
			if ($object == __CLASS__) {
				$i = 20;
			}
		}
		return array_unique($parents);
	}

	protected function _getClassesAscending()
	{
		$classes = $this->_getClassesDescending();
		krsort($classes);
		return $classes;
	}

	protected function _GetClassDir($strClass)
	{
		return strtolower(str_replace('_', '/', $strClass));
	}

	protected function _getClassFileName($strClass)
	{
		$arrNameParts = explode('_', $strClass);
		return strtolower($arrNameParts[count($arrNameParts)-1]);
	}
}