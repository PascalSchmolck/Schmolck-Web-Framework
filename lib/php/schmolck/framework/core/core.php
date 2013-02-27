<?php

/**
 * Schmolck_Framework_Core
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Core {

	protected $_bLayoutRendering;
	protected $_arrViewStyles = array();
	protected $_arrViewLESS = array();
	protected $_arrViewScripts = array();
	protected $_arrHelpers = array();
	protected $_arrActionValues = array();
	protected $_strModule;
	protected $_strController;
	protected $_strAction;
	protected $_strViewOutput;
	protected $_strTrace;

	public function __construct() {
		/*
		 * PREPARATION
		 */
		$this->setLayoutRendering(true);
		$this->initHelpers();
		$this->initApplication();
	}

	/**
	 * Set action value
	 * 
	 * Used for saving values within the action for upcoming use in the view.
	 * 
	 * @param string $strKey
	 * @param mixed $mixedValue
	 */
	public function __set($strKey, $mixedValue) {
		$this->_arrActionValues[$strKey] = $mixedValue;
	}

	/**
	 * Get action value
	 * 
	 * Used for accessing action values from within the view.
	 * 
	 * @param mixed $strKey
	 * @return mixed
	 */
	public function __get($strKey) {
		if (array_key_exists($strKey, $this->_arrActionValues)) {
			return $this->_arrActionValues[$strKey];
		} else {
			Schmolck_Tool_Debug::warning("Action value '{$strKey}' not defined!");
		}
	}

	/**
	 * Initialise all required helpers
	 */
	public function initHelpers() {
		$this->_arrHelpers['application'] = new Schmolck_Framework_Helper_Application($this);
		$this->_arrHelpers['optimizer'] = new Schmolck_Framework_Helper_Optimizer($this);
		$this->_arrHelpers['translator'] = new Schmolck_Framework_Helper_Translator($this);
		$this->_arrHelpers['cache'] = new Schmolck_Framework_Helper_Cache($this);
	}

	/**
	 * Get helper instance
	 * 
	 * @param string $strKey helper name
	 * @return object helper instance
	 */
	public function get($strKey) {
		if (array_key_exists($strKey, $this->_arrHelpers)) {
			return $this->_arrHelpers[$strKey];
		} else {
			throw new Exception("Helper '{$strKey}' not defined!");
		}
	}

	/**
	 * Initialise application settings and parameters
	 */
	public function initApplication() {
		/*
		 * SETTINGS
		 */
		require($this->get('application')->getPath() . '/settings.php');

		/*
		 * PARAMETERS
		 */
		require($this->get('application')->getPath() . '/parameters.php');
		$this->_strModule = ($strModule != '') ? $strModule : 'index';
		$this->_strController = ($strController != '') ? $strController : 'index';
		$this->_strAction = ($strAction != '') ? $strAction : 'index';
	}

	/**
	 * Register single LESS file
	 * 
	 * @param string $file
	 * @throws Exception
	 */
	public function registerViewLESS($file) {
		if (file_exists($file)) {
			$this->_arrViewLESS[] = $file;
			$this->_arrViewLESS = array_unique($this->_arrViewLESS);
		} else {
			throw new Exception("Registration of LESS file '{$file}' failed in {$this->_strTrace}");
		}
	}

	/**
	 * Register multiple LESS files
	 * 
	 * @param array $arrFiles
	 */
	public function registerViewLESSs($arrFiles) {
		if (count($arrFiles) > 0) {
			foreach ($arrFiles as $strFile) {
				$this->registerViewLESS($strFile);
			}
		}
	}

	/**
	 * Register single JS file
	 * 
	 * @param string $file
	 * @throws Exception
	 */
	public function registerViewJS($file) {
		if (file_exists($file)) {
			$this->_arrViewScripts[] = $file;
			$this->_arrViewScripts = array_unique($this->_arrViewScripts);
		} else {
			throw new Exception("Registration of scripts file '{$file}' failed in {$this->_strTrace}");
		}
	}

	/**
	 * Register multiple JS files
	 * 
	 * @param array $arrFiles
	 */
	public function registerViewJSs($arrFiles) {
		if (count($arrFiles) > 0) {
			foreach ($arrFiles as $strFile) {
				$this->registerViewJS($strFile);
			}
		}
	}

	/**
	 * Run through whole MVC process
	 */
	public function run() {
		try {
			/*
			 * BUFFERING
			 */
			ob_start();
			
			/*
			 * PROCESSING
			 */
			$this->_strTrace = 'ApplicationCheck';
			$this->_runApplicationCheck();

			$this->_strTrace = 'ApplicationInit';
			$this->_runApplicationInit();

			$this->_strTrace = 'ModuleCheck';
			$this->_runModuleCheck();

			$this->_strTrace = 'ModuleInit';
			$this->_runModuleInit();

			$this->_strTrace = 'ControllerCheck';
			$this->_runControllerCheck();

			$this->_strTrace = 'ControllerInit';
			$this->_runControllerInit();

			$this->_strTrace = 'Action';
			$this->_runAction();

			$this->_strTrace = 'ControllerExit';
			$this->_runControllerExit();

			$this->_strTrace = 'ModuleExit';
			$this->_runModuleExit();

			$this->_strTrace = 'View';
			$this->_runView();

			$this->_strTrace = 'Layout';
			$this->_runLayout();

			$this->_strTrace = 'AppllicationExit';
			$this->_runApplicationExit();
			
			/*
			 * OUTPUT
			 */
			$strOutput = ob_get_contents();
			ob_end_clean();
			$this->_renderParsedOutput($strOutput);
			
			/*
			 * EXIT
			 */
			exit();
		} catch (Exception $Exception) {
			ob_end_clean();
			$this->_RunExceptionHandling($Exception);
		}
	}

	protected function _runApplicationCheck() {
		$strPath = $this->get('application')->getPath();
		if (!file_exists($strPath)) {
			throw new Exception("Application path '{$strPath}' not found");
		}
	}

	protected function _runApplicationInit() {
		$strFile = $this->get('application')->getModulePath() . "/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runApplicationExit() {
		$strFile = $this->get('application')->getModulePath() . "/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runModuleCheck() {
		$strPath = $this->get('application')->getModulePath() . "/{$this->_strModule}";
		if (!file_exists($strPath)) {
			throw new Exception("Module '{$this->_strModule}' not found");
		}
	}

	protected function _runModuleInit() {
		$strFile = $this->get('application')->getModulePath() . "/{$this->_strModule}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runModuleExit() {
		$strFile = $this->get('application')->getModulePath() . "/{$this->_strModule}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runControllerCheck() {
		$strPath = $this->get('application')->getModulePath() . "/{$this->_strModule}/{$this->_strController}";
		if (!file_exists($strPath)) {
			throw new Exception("Controller '{$this->_strController}' not found");
		}
	}

	protected function _runControllerInit() {
		$strFile = $this->get('application')->getModulePath() . "/{$this->_strModule}/{$this->_strController}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runControllerExit() {
		$strFile = $this->get('application')->getModulePath() . "/{$this->_strModule}/{$this->_strController}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runAction() {
		ob_start();
		$strFile = $this->get('application')->getModulePath() . "/{$this->_strModule}/{$this->_strController}/{$this->_strAction}/action.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Action file '{$this->_strAction}/action.php' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
		ob_end_clean();
	}

	protected function _runLayout() {
		if ($this->_bLayoutRendering) {

			/*
			 * INIT
			 */
			$strPath = $this->get('application')->getTemplatePath();
			$strFile = "{$strPath}/_init.php";
			if (file_exists($strFile)) {
				require($strFile);
			}

			/*
			 * RUN
			 */
			$strPath = $this->get('application')->getTemplatePath();
			$strFile = "{$strPath}/html.phtml";

			if (file_exists($strFile)) {
				// - include styles
				$this->registerViewLESS("{$strPath}/styles.less");
				// - include scripts
				$this->registerViewJS("{$strPath}/scripts.js");
				// - include layout
				require($strFile);
			} else {
				throw new Exception("Layout file '{$strFile}' not found");
			}

			/*
			 * EXIT
			 */
			$strPath = $this->get('application')->getTemplatePath();
			$strFile = "{$strPath}/_exit.php";
			if (file_exists($strFile)) {
				require($strFile);
			}
		} else {
			$this->_runView();
			$this->renderViewHtml();
		}
	}

	protected function _runView() {
		ob_start();
		/*
		 * LOADING
		 */
		// - Html
		$strFile = $this->get('application')->getModulePath() . "/{$this->_strModule}/{$this->_strController}/{$this->_strAction}/view.phtml";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("View file '{$this->_strAction}/view.phtml' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
		// - JavaScript
		$strFile = $this->get('application')->getModulePath() . "/{$this->_strModule}/{$this->_strController}/{$this->_strAction}/scripts.js";
		if (file_exists($strFile)) {
			if (APPLICATION_ENVIRONMENT == 'development') {
				$strJavaScript = file_get_contents($strFile);
			} else {
				$strJavaScript = $this->get('optimizer')->getOptimizedJsString(file_get_contents($strFile));
			}
			echo '<script>' . $strJavaScript . '</script>';
		}

		/*
		 * OUTPUT
		 */
		$this->_strViewOutput = ob_get_contents();
		ob_end_clean();
	}

	/**
	 * Render view html
	 */
	public function renderViewHtml() {
		echo $this->_strViewOutput;
	}

	/**
	 * Get core LESS file
	 */
	public function getCoreLESSFile() {
		/*
		 * CHECK
		 */
		// - nothing to do if no styles registered
		if (count($this->_arrViewLESS) < 1) {
			return;
		}

		/*
		 * PROCESSING
		 */
		// - optimize all styles into one string
		foreach ($this->_arrViewLESS as $strFile) {
			if (file_exists($strFile)) {
				// - do not minify on development environment
				if (APPLICATION_ENVIRONMENT == 'development') {
					$strCombinedLESS .= "\n\n/* {$strFile} */\n\n" . file_get_contents($strFile);
				} else {
					$strCombinedLESS .= $this->get('optimizer')->getOptimizedCssString(file_get_contents($strFile));
				}
			}
		}
		// - get md5 hash of optimized styles and create tmp file
		$strTempFile = $this->get('cache')->getFilePath(md5($strCombinedLESS) . '.less');
		// - fill tmp file with optimized styles
		file_put_contents($strTempFile, $strCombinedLESS);

		/*
		 * OUTPUT
		 */
		return $strTempFile;
	}

	/**
	 * Get core JS file
	 */
	public function getCoreJSFile() {
		/*
		 * CHECK
		 */
		// - nothing to do if no scripts registered
		if (count($this->_arrViewScripts) < 1) {
			return;
		}

		/*
		 * PROCESSING
		 */
		// - optimize all scripts into one string
		foreach ($this->_arrViewScripts as $strFile) {
			if (file_exists($strFile)) {
				if (APPLICATION_ENVIRONMENT == 'development') {
					$strCombinedJs .= "\n\n/* {$strFile} */\n\n" . file_get_contents($strFile);
				} else {
					$strCombinedJs .= $this->get('optimizer')->getOptimizedJsString(file_get_contents($strFile));
				}
			}
		}
		// - get md5 hash of optimized scripts and create tmp file
		$strTempFile = $this->get('cache')->getFilePath(md5($strCombinedJs) . '.js');
		// - fill tmp file with optimized scripts
		file_put_contents($strTempFile, $strCombinedJs);

		/*
		 * OUTPUT
		 */
		return $strTempFile;
	}

	/**
	 * Get base URL
	 */
	public function getBaseUrl() {
		return $this->get('application')->getBaseUrl();
	}

	/**
	 * Set layout rendering true or false
	 * 
	 * @param boolean $bFlag
	 */
	protected function setLayoutRendering($bFlag) {
		$this->_bLayoutRendering = $bFlag;
	}

	protected function _runExceptionHandling(Exception &$Exception) {
//		try {
		$this->_RunExceptionModuleInit($Exception);
		$this->_RunExceptionControllerInit($Exception);
		$this->_RunExceptionAction($Exception);
		$this->_RunExceptionControllerExit($Exception);
		$this->_RunExceptionModuleExit($Exception);
		$this->_RunExceptionView($Exception);
		$this->_RunExceptionLayout($Exception);
//		} catch (Exception $Exception) {
//			die($Exception->getMessage());
//		}
	}

	protected function _runExceptionModuleInit(Exception $Exception) {
		$strFile = $this->get('application')->getModulePath() . '/' . MODULE_EXCEPTION . '/_init.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionModuleExit(Exception $Exception) {
		$strFile = $this->get('application')->getModulePath() . '/' . MODULE_EXCEPTION . '/_exit.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionControllerInit(Exception $Exception) {
		$strFile = $this->get('application')->getModulePath() . '/' . MODULE_EXCEPTION . '/index/_init.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionControllerExit(Exception $Exception) {
		$strFile = $this->get('application')->getModulePath() . '/' . MODULE_EXCEPTION . '/index/_exit.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionAction(Exception $Exception) {
		ob_start();
		require($this->get('application')->getModulePath() . '/' . MODULE_EXCEPTION . '/index/index/action.php');
		ob_end_clean();
	}

	protected function _runExceptionView(Exception $Exception) {
		ob_start();
		require($this->get('application')->getModulePath() . '/' . MODULE_EXCEPTION . '/index/index/view.phtml');
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
		$this->_runView();
	}

	protected function _renderParsedOutput($strOutput) {
		/*
		 * CHECK
		 */
		// - parse output if AJAX call detected
		if (isset($_POST['ajax']) && !empty($_POST['name'])) {
			$arrResult = array();
			$strName = $_POST['name'];
			preg_match("|<\!--{$strName}-->(.*)<\!--/{$strName}-->|si", $strOutput, $arrResult);
			echo trim($arrResult[1]);
		} else {
			echo $strOutput;
		}
	}

}