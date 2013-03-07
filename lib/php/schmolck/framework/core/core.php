<?php

/**
 * Schmolck_Framework_Core
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Core {
	
	protected $_bLayoutRendering = true;
	protected $_arrLayoutStyles = array();
	protected $_arrLayoutScripts = array();
	protected $_arrViewScriptReplace  = array();
	protected $_arrHelpers = array();
	protected $_arrActionValues = array();
	protected $_strModule;
	protected $_strController;
	protected $_strAction;
	protected $_strViewOutput;
	protected $_strTrace;

	static public function getInstance(Schmolck_Framework_Core $obj) {
		return $obj;
	}
	
	public function __construct() {
		/*
		 * PREPARATION
		 */
		$this->_initSettings();
		$this->_initHelpers();
		$this->_initApplication();
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
	 * Initialize all required helpers
	 */
	protected function _initHelpers() {
		$this->_arrHelpers['application'] = new Schmolck_Framework_Helper_Application($this);
		$this->_arrHelpers['database'] = new Schmolck_Framework_Helper_Database($this);
		$this->_arrHelpers['optimizer'] = new Schmolck_Framework_Helper_Optimizer($this);
		$this->_arrHelpers['translator'] = new Schmolck_Framework_Helper_Translator($this);
		$this->_arrHelpers['cache'] = new Schmolck_Framework_Helper_Cache($this);
		$this->_arrHelpers['html'] = new Schmolck_Framework_Helper_Html($this);
		$this->_arrHelpers['ajax'] = new Schmolck_Framework_Helper_Ajax($this);
		$this->_arrHelpers['api'] = new Schmolck_Framework_Helper_Api($this);
	}
	
	/**
	 * Get application helper
	 * 
	 * @return \Schmolck_Framework_Helper_Application
	 */
	public function &getHelperApplication() {
		return $this->_arrHelpers['application'];
	}
	
	/**
	 * Get database helper
	 * 
	 * @return \Schmolck_Framework_Helper_Database
	 */
	public function &getHelperDatabase() {
		return $this->_arrHelpers['database'];
	}
	
	/**
	 * Get optimizer helper
	 * 
	 * @return \Schmolck_Framework_Helper_Optimizer
	 */
	public function &getHelperOptimizer() {
		return $this->_arrHelpers['optimizer'];
	}	
	
	/**
	 * Get translator helper
	 * 
	 * @return \Schmolck_Framework_Helper_Translator
	 */
	public function &getHelperTranslator() {
		return $this->_arrHelpers['translator'];
	}	

	/**
	 * Get cache helper
	 * 
	 * @return \Schmolck_Framework_Helper_Cache
	 */
	public function &getHelperCache() {
		return $this->_arrHelpers['cache'];
	}	
	
	/**
	 * Get HTML helper
	 * 
	 * @return \Schmolck_Framework_Helper_Html
	 */
	public function &getHelperHtml() {
		return $this->_arrHelpers['html'];
	}	
	
	/**
	 * Get ajax helper
	 * 
	 * @return \Schmolck_Framework_Helper_Ajax
	 */
	public function &getHelperAjax() {
		return $this->_arrHelpers['ajax'];
	}	
	
	/**
	 * Get api helper
	 * 
	 * @return \Schmolck_Framework_Helper_Api
	 */
	public function &getHelperApi() {
		return $this->_arrHelpers['api'];
	}		

	/**
	 * Initialize application settings
	 */
	protected function _initSettings() {
		require(Schmolck_Framework_Helper_Application::getSettings());
	}

	/**
	 * Initialize application
	 */
	protected function _initApplication() {
		/*
		 * PARAMETERS
		 */
		require($this->getHelperApplication()->getPath() . '/parameters.php');
		$this->_strModule = ($strModule != '') ? $strModule : 'index';
		$this->_strController = ($strController != '') ? $strController : 'index';
		$this->_strAction = ($strAction != '') ? $strAction : 'index';
	}

	/**
	 * Register single layout style file
	 * 
	 * @param string $file
	 * @throws Exception
	 */
	public function registerLayoutStyle($file) {
		if (file_exists($file)) {
			$this->_arrLayoutStyles[] = $file;
			$this->_arrLayoutStyles = array_unique($this->_arrLayoutStyles);
		} else {
			throw new Exception("Registration of LESS file '{$file}' failed in {$this->_strTrace}");
		}
	}

	/**
	 * Register multiple layout style files
	 * 
	 * @param array $arrFiles
	 */
	public function registerLayoutStyles($arrFiles) {
		if (count($arrFiles) > 0) {
			foreach ($arrFiles as $strFile) {
				$this->registerLayoutStyle($strFile);
			}
		}
	}

	/**
	 * Register single layout script file
	 * 
	 * @param string $file
	 * @throws Exception
	 */
	public function registerLayoutScript($file) {
		if (file_exists($file)) {
			$this->_arrLayoutScripts[] = $file;
			$this->_arrLayoutScripts = array_unique($this->_arrLayoutScripts);
		} else {
			throw new Exception("Registration of scripts file '{$file}' failed in {$this->_strTrace}");
		}
	}

	/**
	 * Register multiple layout script files
	 * 
	 * @param array $arrFiles
	 */
	public function registerLayoutScripts($arrFiles) {
		if (count($arrFiles) > 0) {
			foreach ($arrFiles as $strFile) {
				$this->registerLayoutScript($strFile);
			}
		}
	}
	
	/**
	 * Register script replace strings
	 * 
	 * @param array $arrReplace
	 */
	public function registerViewScriptReplace($arrReplace) {
		$this->_arrViewScriptReplace = $arrReplace;
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
			echo $strOutput;

			/*
			 * EXIT
			 */
			exit();
		} catch (Exception $Exception) {
			ob_end_clean();
			$this->_runExceptionHandling($Exception);
		}
	}

	protected function _runApplicationCheck() {
		$strPath = $this->getHelperApplication()->getPath();
		if (!file_exists($strPath)) {
			throw new Exception("Application path '{$strPath}' not found");
		}
	}

	protected function _runApplicationInit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runApplicationExit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runModuleCheck() {
		$strPath = $this->getHelperApplication()->getModulePath() . "/{$this->_strModule}";
		if (!file_exists($strPath)) {
			throw new Exception("Module '{$this->_strModule}' not found");
		}
	}

	protected function _runModuleInit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->_strModule}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runModuleExit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->_strModule}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runControllerCheck() {
		$strPath = $this->getHelperApplication()->getModulePath() . "/{$this->_strModule}/{$this->_strController}";
		if (!file_exists($strPath)) {
			throw new Exception("Controller '{$this->_strController}' not found");
		}
	}

	protected function _runControllerInit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->_strModule}/{$this->_strController}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runControllerExit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->_strModule}/{$this->_strController}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runAction() {
		ob_start();
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->_strModule}/{$this->_strController}/{$this->_strAction}/action.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Action file '{$this->_strAction}/action.php' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
		$this->_strViewOutput .= ob_get_contents();
		ob_end_clean();
	}

	protected function _runLayout() {
		if ($this->_bLayoutRendering) {

			/*
			 * INIT
			 */
			$strPath = $this->getHelperApplication()->getTemplatePath();
			$strFile = "{$strPath}/_init.php";
			if (file_exists($strFile)) {
				require($strFile);
			}

			/*
			 * RUN
			 */
			$strPath = $this->getHelperApplication()->getTemplatePath();
			$strFile = "{$strPath}/html.phtml";

			if (file_exists($strFile)) {
				// - include styles
				$this->registerLayoutStyle("{$strPath}/styles.less");
				// - include scripts
				$this->registerLayoutScript("{$strPath}/scripts.js");
				// - include layout
				require($strFile);
			} else {
				throw new Exception("Layout file '{$strFile}' not found");
			}

			/*
			 * EXIT
			 */
			$strPath = $this->getHelperApplication()->getTemplatePath();
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
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->_strModule}/{$this->_strController}/{$this->_strAction}/output.phtml";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("View file '{$this->_strAction}/output.phtml' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
		// - JavaScript
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->_strModule}/{$this->_strController}/{$this->_strAction}/scripts.js";
		if (file_exists($strFile)) {
			$strJavaScript = str_replace(array_keys($this->_arrViewScriptReplace), array_values($this->_arrViewScriptReplace), file_get_contents($strFile));
			if (APPLICATION_ENVIRONMENT != 'development') {
				$strJavaScript = $this->getHelperOptimizer()->getOptimizedJsString($strJavaScript);
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
	 * Get view style file
	 */
	public function getViewStyleFile() {
		/*
		 * CHECK
		 */
		// - nothing to do if no styles registered
		if (count($this->_arrLayoutStyles) < 1) {
			return;
		}

		/*
		 * PROCESSING
		 */
		// - optimize all styles into one string
		foreach ($this->_arrLayoutStyles as $strFile) {
			if (file_exists($strFile)) {
				// - do not minify on development environment
				if (APPLICATION_ENVIRONMENT == 'development') {
					$strCombinedLESS .= "\n\n/* {$strFile} */\n\n" . file_get_contents($strFile);
				} else {
					$strCombinedLESS .= $this->getHelperOptimizer()->getOptimizedCssString(file_get_contents($strFile));
				}
			}
		}
		// - get md5 hash of optimized styles and create tmp file
		$strTempFile = $this->getHelperCache()->getFilePath(md5($strCombinedLESS) . '.less');
		// - fill tmp file with optimized styles
		file_put_contents($strTempFile, $strCombinedLESS);

		/*
		 * OUTPUT
		 */
		return $strTempFile;
	}

	/**
	 * Get view script file
	 */
	public function getViewScriptFile() {
		/*
		 * CHECK
		 */
		// - nothing to do if no scripts registered
		if (count($this->_arrLayoutScripts) < 1) {
			return;
		}

		/*
		 * PROCESSING
		 */
		// - optimize all scripts into one string
		foreach ($this->_arrLayoutScripts as $strFile) {
			if (file_exists($strFile)) {
				if (APPLICATION_ENVIRONMENT == 'development') {
					$strCombinedJs .= "\n\n/* {$strFile} */\n\n" . file_get_contents($strFile);
				} else {
					$strCombinedJs .= $this->getHelperOptimizer()->getOptimizedJsString(file_get_contents($strFile));
				}
			}
		}
		// - get md5 hash of optimized scripts and create tmp file
		$strTempFile = $this->getHelperCache()->getFilePath(md5($strCombinedJs) . '.js');
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
		return $this->getHelperApplication()->getBaseUrl();
	}
	
	/**
	 * Check if currently in AJAX call
	 * 
	 * @return boolean
	 */
	public function checkAjaxCall() {
		return (count($_POST) > 0 and isset($_POST['ajax']));
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
		$this->_runExceptionModuleInit($Exception);
		$this->_runExceptionControllerInit($Exception);
		$this->_runExceptionAction($Exception);
		$this->_runExceptionControllerExit($Exception);
		$this->_runExceptionModuleExit($Exception);
		$this->_runExceptionView($Exception);
		$this->_runExceptionLayout($Exception);
//		} catch (Exception $Exception) {
//			die($Exception->getMessage());
//		}
	}

	protected function _runExceptionModuleInit(Exception $Exception) {
		$strFile = $this->getHelperApplication()->getModulePath() . '/' . MODULE_EXCEPTION . '/_init.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionModuleExit(Exception $Exception) {
		$strFile = $this->getHelperApplication()->getModulePath() . '/' . MODULE_EXCEPTION . '/_exit.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionControllerInit(Exception $Exception) {
		$strFile = $this->getHelperApplication()->getModulePath() . '/' . MODULE_EXCEPTION . '/index/_init.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionControllerExit(Exception $Exception) {
		$strFile = $this->getHelperApplication()->getModulePath() . '/' . MODULE_EXCEPTION . '/index/_exit.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionAction(Exception $Exception) {
		ob_start();
		require($this->getHelperApplication()->getModulePath() . '/' . MODULE_EXCEPTION . '/index/index/action.php');
		ob_end_clean();
	}

	protected function _runExceptionView(Exception $Exception) {
		ob_start();
		require($this->getHelperApplication()->getModulePath() . '/' . MODULE_EXCEPTION . '/index/index/output.phtml');
		$this->_strViewOutput = ob_get_contents();
		ob_end_clean();
	}

	protected function _runExceptionLayout(Exception $Exception) {
		/*
		 * CHECK
		 */
		if ($this->checkAjaxCall()) {
			$this->setLayoutRendering(false);
		}
		/*
		 * OUTPUT
		 */
		if ($this->_bLayoutRendering) {
			$this->_runLayout();
		} else {
			$this->_renderExceptionView($Exception);
		}
	}

	protected function _renderExceptionView(Exception $Exception) {
		$this->renderViewHtml();
	}

}