<?php

/**
 * Schmolck_Framework_Gui
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
abstract class Schmolck_Framework_Gui {

	protected $_objCore;
	protected $_arrAttributes;

	abstract protected function _renderHtml();

	abstract protected function _renderJs();

	public function __construct(Schmolck_Framework_Core $objCore, $strId) {
		$this->_objCore = $objCore;
		$this->setAttribute('id', $strId);
		$this->setAttribute('class', implode(" ", $this->_GetClassesAscending()));
		$this->init();
	}

	public function __get($strKey) {
		if (array_key_exists($strKey, $this->_arrAttributes)) {
			return $this->_arrAttributes[$strKey];
		} else {
			Schmolck_Tool_Debug::warning("Attribute '{$strKey}' not defined!");
		}
	}

	public function init() {
		
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
	public function getHtml() {
		ob_start();
		$this->_render();
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	/**
	 * Render entire output
	 */
	private function _render() {
		$this->_registerCSS();
		$this->_registerLESS();
		$this->_registerJS();
		$this->_renderWrapperStart();
		$this->_renderHtml();
		$this->_renderJs();
		$this->_renderWrapperStop();
	}

	protected function _getLibraryDir() {
		return "lib/php";
	}

	protected function _registerCSS() {
		$classes = $this->_getClassesAscending();
		foreach ($classes as $class) {
			$file = "{$this->_getLibraryDir()}/{$this->_GetClassDir($class)}/styles.css";
			if (file_exists($file)) {
				$this->_objCore->registerViewCSS($file);
			}
		}
	}

	protected function _registerLESS() {
		$classes = $this->_getClassesAscending();
		foreach ($classes as $class) {
			$file = "{$this->_getLibraryDir()}/{$this->_GetClassDir($class)}/styles.less";
			if (file_exists($file)) {
				$this->_objCore->registerViewLESS($file);
			}
		}
	}

	protected function _registerJS() {
		$classes = $this->_getClassesAscending();
		foreach ($classes as $class) {
			$file = "{$this->_getLibraryDir()}/{$this->_GetClassDir($class)}/scripts.php";
			if (file_exists($file)) {
				$this->_objCore->registerViewJS($file);
			}
		}
	}

	protected function _getClassesDescending() {
		$object = $this;
		$parents = array();
		$parents[] = get_class($object);
		for ($i = 1; $i < 20; $i++) {
			$parent = get_parent_class($object);
			if (!empty($parent)) {
				$parents[] = $parent;
				$object = $parent;
			}
			if ($object == __CLASS__) {
				$i = 20;
			}
		}
		return array_unique($parents);
	}

	protected function _getClassesAscending() {
		$classes = $this->_getClassesDescending();
		krsort($classes);
		return $classes;
	}

	protected function _GetClassDir($strClass) {
		return strtolower(str_replace('_', '/', $strClass));
	}

	protected function _getClassFileName($strClass) {
		$arrNameParts = explode('_', $strClass);
		return strtolower($arrNameParts[count($arrNameParts) - 1]);
	}

	/**
	 * Render wrapper start
	 * 
	 * Used for special AJAX calls
	 */
	protected function _renderWrapperStart() {
		if ($this->_objCore->getHelperAjax()->checkCall($this->id)) {
			echo "<!--{$this->id}-->";
		}
		echo "<div id=\"{$this->id}\" class=\"{$this->class}\">";
	}

	/**
	 * Render wrapper stop
	 * 
	 * Used for special AJAX calls
	 */
	protected function _renderWrapperStop() {
		echo "</div>";
		if ($this->_objCore->getHelperAjax()->checkCall($this->id)) {
			echo "<!--/{$this->id}-->";
		}
	}

}