<?php
/**
 * Schmolck_Framework_Core
 * 
 * @package Schmolck Framework
 * @author Pascal Schmolck
 * @copyright 2013
 * @version 1.0.0
 */
class Schmolck_Framework_Core {

	protected $_strExceptionModule;

	protected $_strModule;
	protected $_strController;
	protected $_strAction;

	protected $_bLayoutRendering;

	protected $_arrViewStyles;
	protected $_arrViewScripts;

	protected $_strViewOutput;

	public function __construct() 
	{
		/*
		 * PREPARATION
		 */
		$this->setLayoutRendering(true);
		$this->setExceptionModule('exception');

		/*
		 * PARAMETERS
		 */
		$this->_loadHostParameters();
	}

	public function setExceptionModule($strModule) 
	{
		$this->_strExceptionModule = $strModule;
	}

	public function registerViewStyles($file) 
	{
		$this->_arrViewStyles[] = $file;
		$this->_arrViewStyles = array_unique($this->_arrViewStyles);
	}

	public function registerViewScripts($file) 
	{
		$this->_arrViewScripts[] = $file;
		$this->_arrViewScripts = array_unique($this->_arrViewScripts);
	}

	public function run() 
	{
		try {
			$this->_RunApplicationInit();
			$this->_RunModuleInit();
			$this->_RunControllerInit();
			$this->_RunAction();
			$this->_RunControllerExit();
			$this->_RunModuleExit();
			$this->_RunView();
			$this->_RunLayout();
			$this->_RunApplicationExit();
		} catch (Exception $Exception) {
			ob_end_clean();
			$this->_RunExceptionHandling($Exception);
		}
	}
	
	protected function _loadHostParameters()
	{
		require(Schmolck_Framework_Host::getCurrentPath().'/parameters.php');
		$this->_strModule = ($strModule != '')? $strModule : 'index';
		$this->_strController = ($strController != '')? $strController : 'index';
		$this->_strAction = ($strAction != '')? $strAction : 'index';
	}

	protected function _runApplicationInit() 
	{
		require("modules/_init.php");
	}

	protected function _runApplicationExit() 
	{
		require("modules/_exit.php");
	}

	protected function _runModuleInit() 
	{
		$strFile = "modules/{$this->_strModule}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Init file for module '{$this->_strModule}' not found");
		}
	}

	protected function _runModuleExit() 
	{
		$strFile = "modules/{$this->_strModule}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Exit file for module '{$this->_strModule}' not found");
		}
	}

	protected function _runControllerInit() 
	{
		$strFile = "modules/{$this->_strModule}/controllers/{$this->_strController}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Controller init file for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
	}

	protected function _runControllerExit() {
		$strFile = "modules/{$this->_strModule}/controllers/{$this->_strController}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Controller exit file for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
	}

	protected function _runAction() {
		ob_start();
			$strFile = "modules/{$this->_strModule}/controllers/{$this->_strController}/{$this->_strAction}.php";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("Action file '{$this->_strAction}' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
			}
		ob_end_clean();
	}

	protected function _runLayout() {
		if ($this->_bLayoutRendering) {
			$strFile = Schmolck_Framework_Host::getCurrentPath()."/template/html.php";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("Layout file not found");
			}
		} else {
			$this->_RenderView();
		}
	}

	protected function _runView() 
	{
		ob_start();
			$strFile = "modules/{$this->_strModule}/views/{$this->_strController}/{$this->_strAction}.phtml";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("View file '{$this->_strAction}' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
			}

			$this->_strViewOutput = ob_get_contents();
		ob_end_clean();
	}

	/**
	 * Render view html
	 */
	public function renderViewHtml() 
	{
		echo $this->_strViewOutput;
	}

	/**
	 * Render <styles> tags
	 */
	public function renderViewStyles() 
	{
		if (count($this->_arrViewStyles) > 0) {
			foreach ($this->_arrViewStyles as $file) {
				if (filesize($file) > 0) {
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$file}\" />\n";
				}
			}
		}
	}

	/**
	 * Render <script> tags
	 */
	public function renderViewScripts() 
	{
		if (count($this->_arrViewScripts) > 0) {
			foreach ($this->_arrViewScripts as $file) {
				if (filesize($file) > 0) {
					echo "<script type=\"text/javascript\" src=\"{$file}\"></script>\n";
				}
			}
		}
	}
	
	/**
	 * Render <base> tag
	 */
	public function renderViewBase()
	{
		$strBaseUrl = Schmolck_Framework_Host::getBaseUrl();
		echo "<base href=\"{$strBaseUrl}\" />\n";
	}

	/**
	 * Set layout rendering true or false
	 * 
	 * @param boolean $bFlag
	 */
	protected function setLayoutRendering($bFlag) 
	{
		$this->_bLayoutRendering = $bFlag;
	}

	protected function _runExceptionHandling(Exception &$Exception) {
		try {
			$this->_RunExceptionModuleInit($Exception);
			$this->_RunExceptionControllerInit($Exception);
			$this->_RunExceptionAction($Exception);
			$this->_RunExceptionControllerExit($Exception);
			$this->_RunExceptionModuleExit($Exception);
			$this->_RunExceptionView($Exception);
			$this->_RunExceptionLayout($Exception);
		} catch (Exception $Exception) {
			die($Exception->getMessage());
		}
	}

	protected function _runExceptionModuleInit(Exception $Exception) {
		require("modules/{$this->_strExceptionModule}/_init.php");
	}

	protected function _runExceptionModuleExit(Exception $Exception) {
		require("modules/{$this->_strExceptionModule}/_exit.php");
	}

	protected function _runExceptionControllerInit(Exception $Exception) {
		require("modules/{$this->_strExceptionModule}/controllers/index/_init.php");
	}

	protected function _runExceptionControllerExit(Exception $Exception) {
		require("modules/{$this->_strExceptionModule}/controllers/index/_exit.php");
	}

	protected function _runExceptionAction(Exception $Exception) {
		ob_start();
		require("modules/{$this->_strExceptionModule}/controllers/index/index.php");
		ob_end_clean();
	}

	protected function _runExceptionView(Exception $Exception) {
		ob_start();
		require("modules/{$this->_strExceptionModule}/views/index/index.phtml");
		$this->_strViewOutput = ob_get_contents();
		ob_end_clean();
	}

	protected function _runExceptionLayout(Exception $Exception) {
		if ($this->_bLayoutRendering) {
			$this->_RunLayout();
		} else {
			$this->_RenderExceptionView($Exception);
		}
	}

	protected function _renderExceptionView(Exception $Exception) {
		$this->_RenderView();
	}
}