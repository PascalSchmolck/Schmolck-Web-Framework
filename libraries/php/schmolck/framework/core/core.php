<?php
/**
 * Schmolck_Framework_Core
 * 
 * @package Schmolck PHP Framework (S-PHP-F)
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

	public function __construct($strModule, $strController, $strAction) {
		//-------------
		// PREPARATION
		//-------------
		$this->_bLayoutRendering = true;

		//-----------
		// PARAMETER
		//-----------
		$this->_strModule = ($strModule != '')? $strModule : 'index';
		$this->_strController = ($strController != '')? $strController : 'index';
		$this->_strAction = ($strAction != '')? $strAction : 'index';
	}

	public function SetExceptionModule($strModule) {
		$this->_strExceptionModule = $strModule;
	}

	public function RegisterStyles($file) {
		$this->_arrViewStyles[] = $file;
		$this->_arrViewStyles = array_unique($this->_arrViewStyles);
	}

	public function RegisterScripts($file) {
		$this->_arrViewScripts[] = $file;
		$this->_arrViewScripts = array_unique($this->_arrViewScripts);
	}

	public function Run() {
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

	protected function _RunApplicationInit() {
		require("application/_init.php");
	}

	protected function _RunApplicationExit() {
		require("application/_exit.php");
	}

	protected function _RunModuleInit() {
		$strFile = "application/modules/{$this->_strModule}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Init file for module '{$this->_strModule}' not found");
		}
	}

	protected function _RunModuleExit() {
		$strFile = "application/modules/{$this->_strModule}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Exit file for module '{$this->_strModule}' not found");
		}
	}

	protected function _RunControllerInit() {
		$strFile = "application/modules/{$this->_strModule}/controllers/{$this->_strController}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Controller init file for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
	}

	protected function _RunControllerExit() {
		$strFile = "application/modules/{$this->_strModule}/controllers/{$this->_strController}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Controller exit file for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
	}

	protected function _RunAction() {
		ob_start();
			$strFile = "application/modules/{$this->_strModule}/controllers/{$this->_strController}/{$this->_strAction}.php";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("Action file '{$this->_strAction}' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
			}
		ob_end_clean();
	}

	protected function _RunLayout() {
		if ($this->_bLayoutRendering) {
			$strFile = "application/layouts/desktop/layout.html.php";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("Layout file for 'desktop' not found");
			}
		} else {
			$this->_RenderView();
		}
	}

	protected function _RunView() {
		ob_start();
			$strFile = "application/modules/{$this->_strModule}/views/{$this->_strController}/{$this->_strAction}.phtml";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("View file '{$this->_strAction}' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
			}

			$this->_strViewOutput = ob_get_contents();
		ob_end_clean();
	}

	protected function _RenderViewHtml() {
		echo $this->_strViewOutput;
	}

	protected function _RenderViewStyles() {
		if (count($this->_arrViewStyles) > 0) {
			foreach ($this->_arrViewStyles as $file) {
				if (filesize($file) > 0) {
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$file}\" />\n";
				}
			}
		}
	}

	protected function _RenderViewScripts() {
		if (count($this->_arrViewScripts) > 0) {
			foreach ($this->_arrViewScripts as $file) {
				if (filesize($file) > 0) {
					echo "<script type=\"text/javascript\" src=\"{$file}\"></script>\n";
				}
			}
		}
	}

	protected function _SetLayoutRendering($bFlag) {
		$this->_bLayoutRendering = $bFlag;
	}

	protected function _RunExceptionHandling(Exception &$Exception) {
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

	protected function _RunExceptionModuleInit(Exception $Exception) {
		require("application/modules/{$this->_strExceptionModule}/_init.php");
	}

	protected function _RunExceptionModuleExit(Exception $Exception) {
		require("application/modules/{$this->_strExceptionModule}/_exit.php");
	}

	protected function _RunExceptionControllerInit(Exception $Exception) {
		require("application/modules/{$this->_strExceptionModule}/controllers/index/_init.php");
	}

	protected function _RunExceptionControllerExit(Exception $Exception) {
		require("application/modules/{$this->_strExceptionModule}/controllers/index/_exit.php");
	}

	protected function _RunExceptionAction(Exception $Exception) {
		ob_start();
		require("application/modules/{$this->_strExceptionModule}/controllers/index/index.php");
		ob_end_clean();
	}

	protected function _RunExceptionView(Exception $Exception) {
		ob_start();
		require("application/modules/{$this->_strExceptionModule}/views/index/index.phtml");
		$this->_strViewOutput = ob_get_contents();
		ob_end_clean();
	}

	protected function _RunExceptionLayout(Exception $Exception) {
		if ($this->_bLayoutRendering) {
			$this->_RunLayout();
		} else {
			$this->_RenderExceptionView($Exception);
		}
	}

	protected function _RenderExceptionView(Exception $Exception) {
		$this->_RenderView();
	}
}