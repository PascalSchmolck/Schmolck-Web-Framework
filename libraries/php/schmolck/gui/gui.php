<?php
/**
 * Schmolck GUI Base Class
 * 
 * @package Schmolck Framework
 * @author Pascal Schmolck
 * @copyright 2013
 * @version 1.0.0
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
			throw new Exception("Parameter '{$strKey}' not defined!");
		}
	}

	public function SetCore($_objCore) {
		$this->_objCore = $_objCore;
	}

	public function SetAttribute($strKey, $strValue) {
		$this->_arrAttributes[$strKey] = $strValue;
	}

	public function SetAttributes(Array $arrAttributes) {
		$this->_arrAttributes = array_merge($this->_arrAttributes, $arrAttributes);
	}

	public function Render()
	{
		$this->_RegisterStyles();
		$this->_RegisterScripts();
		$this->_RenderHtml();
	}

	protected function _GetLibraryDir() {
		return "libraries/php";
	}

	protected function _RenderHtml()
	{
		$classes = $this->_GetClassesDescending();
		foreach ($classes as $class) {
			$file = "{$this->_GetLibraryDir()}/{$this->_GetClassDir($class)}/{$this->_GetClassFileName($class)}.phtml";
			if (file_exists($file)) {
				require($file);
				echo "\n";
				return;
			}
		}
	}

	protected function _RegisterStyles()
	{
		$classes = $this->_GetClassesAscending();
		foreach ($classes as $class) {
			$file = "{$this->_GetLibraryDir()}/{$this->_GetClassDir($class)}/{$this->_GetClassFileName($class)}.css";
			if (file_exists($file)) {
				$this->_objCore->RegisterStyles($file);
			}
		}
	}

	protected function _RegisterScripts()
	{
		$classes = $this->_GetClassesAscending();
		foreach ($classes as $class) {
			$file = "{$this->_GetLibraryDir()}/{$this->_GetClassDir($class)}/{$this->_GetClassFileName($class)}.js";
			if (file_exists($file)) {
				$this->_objCore->RegisterScripts($file);
			}
		}
	}

	protected function _GetClassesDescending()
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

	protected function _GetClassesAscending()
	{
		$classes = $this->_GetClassesDescending();
		krsort($classes);
		return $classes;
	}

	protected function _GetClassDir($strClass)
	{
		return strtolower(str_replace('_', '/', $strClass));
	}

	protected function _GetClassFileName($strClass)
	{
		$arrNameParts = explode('_', $strClass);
		return strtolower($arrNameParts[count($arrNameParts)-1]);
	}
}