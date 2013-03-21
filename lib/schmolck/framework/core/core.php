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
	protected $_arrHelpers = array();
	protected $_arrActionValues = array();
	protected $_strModule;
	protected $_strController;
	protected $_strAction;
	protected $_strViewOutput;
	protected $_strTrace;

	static public function getInstance(Schmolck_Framework_Core $objCore) {
		return $objCore;
	}

	public function __construct() {
		$this->_initSettings();
		$this->_initHelpers();
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
		}
	}

	public function getViewOutput() {
		return $this->_strViewOutput;
	}

	/**
	 * Get module name
	 * 
	 * @return string name
	 */
	public function getModule() {
		return $this->_strModule;
	}

	/**
	 * Set module name
	 * 
	 * @param string $strModule
	 */
	public function setModule($strModule) {
		$this->_strModule = $strModule;
	}

	/**
	 * Get controller name
	 * 
	 * @return string name
	 */
	public function getController() {
		return $this->_strController;
	}

	/**
	 * Set controller name
	 * 
	 * @param string $strController
	 */
	public function setController($strController) {
		$this->_strController = $strController;
	}

	/**
	 * Get action name
	 * 
	 * @return string name
	 */
	public function getAction() {
		return $this->_strAction;
	}

	/**
	 * Set action name
	 * 
	 * @param string $strAction
	 */
	public function setAction($strAction) {
		$this->_strAction = $strAction;
	}

	/**
	 * Initialize all required helpers
	 */
	protected function _initHelpers() {
		$this->_arrHelpers['host'] = new Schmolck_Framework_Helper_Host($this);
		$this->_arrHelpers['application'] = new Schmolck_Framework_Helper_Application($this);
		$this->_arrHelpers['database'] = new Schmolck_Framework_Helper_Database($this);
		$this->_arrHelpers['optimizer'] = new Schmolck_Framework_Helper_Optimizer($this);
		$this->_arrHelpers['translator'] = new Schmolck_Framework_Helper_Translator($this);
		$this->_arrHelpers['redirect'] = new Schmolck_Framework_Helper_Redirect($this);
		$this->_arrHelpers['message'] = new Schmolck_Framework_Helper_Message($this);
		$this->_arrHelpers['scripts'] = new Schmolck_Framework_Helper_Scripts($this);
		$this->_arrHelpers['cache'] = new Schmolck_Framework_Helper_Cache($this);
		$this->_arrHelpers['html'] = new Schmolck_Framework_Helper_Html($this);
		$this->_arrHelpers['link'] = new Schmolck_Framework_Helper_Link($this);
		$this->_arrHelpers['mail'] = new Schmolck_Framework_Helper_Mail($this);
		$this->_arrHelpers['api'] = new Schmolck_Framework_Helper_Api($this);

	}

	/**
	 * Get host helper
	 * 
	 * @return \Schmolck_Framework_Helper_Server
	 */
	public function &getHelperHost() {
		return $this->_arrHelpers['host'];
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
	 * Get redirect helper
	 * 
	 * @return \Schmolck_Framework_Helper_Redirect
	 */
	public function &getHelperRedirect() {
		return $this->_arrHelpers['redirect'];
	}

	/**
	 * Get message helper
	 * 
	 * @return \Schmolck_Framework_Helper_Message
	 */
	public function &getHelperMessage() {
		return $this->_arrHelpers['message'];
	}

	/**
	 * Get scripts helper
	 * 
	 * @return \Schmolck_Framework_Helper_Scripts
	 */
	public function &getHelperScripts() {
		return $this->_arrHelpers['scripts'];
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
	 * Get link helper
	 * 
	 * @return \Schmolck_Framework_Helper_Link
	 */
	public function &getHelperLink() {
		return $this->_arrHelpers['link'];
	}	

	/**
	 * Get mail helper
	 * 
	 * @return \Schmolck_Framework_Helper_Mail
	 */
	public function &getHelperMail() {
		return $this->_arrHelpers['mail'];
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
	 * Initialize server settings
	 */
	protected function _initSettings() {
		require(Schmolck_Framework_Helper_Host::getSettings());
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
			throw new Schmolck_Tool_Exception("Registration of LESS file '{$file}' failed in {$this->_strTrace}");
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
			throw new Schmolck_Tool_Exception("Registration of scripts file '{$file}' failed in {$this->_strTrace}");
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

			$this->_strTrace = 'View';
			$this->_runView();

			$this->_strTrace = 'ControllerExit';
			$this->_runControllerExit();

			$this->_strTrace = 'ModuleExit';
			$this->_runModuleExit();

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
		} catch (Exception $Exception) {
			ob_end_clean();
			$this->_runExceptionHandling($Exception);
		}
	}

	protected function _runApplicationCheck() {
		$strPath = $this->getHelperApplication()->getPath();
		if (!file_exists($strPath)) {
			throw new Schmolck_Tool_Exception("Application path '{$strPath}' not found");
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
		$strPath = $this->getHelperApplication()->getModulePath() . "/{$this->getModule()}";
		if (!file_exists($strPath)) {
			throw new Schmolck_Tool_Exception("Module '{$this->getModule()}' not found");
		}
	}

	protected function _runModuleInit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->getModule()}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runModuleExit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->getModule()}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runControllerCheck() {
		$strPath = $this->getHelperApplication()->getModulePath() . "/{$this->getModule()}/{$this->getController()}";
		if (!file_exists($strPath)) {
			throw new Schmolck_Tool_Exception("Controller '{$this->getController()}' not found");
		}
	}

	protected function _runControllerInit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->getModule()}/{$this->getController()}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runControllerExit() {
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->getModule()}/{$this->getController()}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runAction() {
		ob_start();
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->getModule()}/{$this->getController()}/{$this->getAction()}/action.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Schmolck_Tool_Exception("Action file '{$this->getAction()}/action.php' for module '{$this->getModule()}' and controller '{$this->getController()}' not found");
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
				throw new Schmolck_Tool_Exception("Layout file '{$strFile}' not found");
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
		$strFile = $this->getHelperApplication()->getModulePath() . "/{$this->getModule()}/{$this->getController()}/{$this->getAction()}/output.phtml";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Schmolck_Tool_Exception("View file '{$this->getAction()}/output.phtml' for module '{$this->getModule()}' and controller '{$this->getController()}' not found");
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
		 * PREPARATION
		 */
		foreach ($this->_arrLayoutStyles as $strFile) {
			if (file_exists($strFile)) {
				$nHash += filesize($strFile);
				$nHash += filectime($strFile);
			}
		}
		$strTempFile = $this->getHelperCache()->getFilePath($nHash.APPLICATION_ENVIRONMENT);

		/*
		 * PROCESSING
		 */
		if (!file_exists($strTempFile)) {
			// - logging
			Schmolck_Tool_Debug::info("Optimization of styles into $strTempFile");
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
			// - fill tmp file with optimized styles
			file_put_contents($strTempFile, $strCombinedLESS);
		}
		
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
		 * PREPARATION
		 */
		foreach ($this->_arrLayoutScripts as $strFile) {
			if (file_exists($strFile)) {
				$nHash += filesize($strFile);
				$nHash += filectime($strFile);
			}
		}
		$strTempFile = $this->getHelperCache()->getFilePath($nHash.APPLICATION_ENVIRONMENT);		

		/*
		 * PROCESSING
		 */
		if (!file_exists($strTempFile)) {
			// - logging
			Schmolck_Tool_Debug::info("Optimization of scripts into $strTempFile");
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
			// - fill tmp file with optimized scripts
			file_put_contents($strTempFile, $strCombinedJs);
		}

		/*
		 * OUTPUT
		 */
		return $strTempFile;
	}

	public function forward($strModule, $strController, $strAction) {
		$this->_strModule = $strModule;
		$this->_strController = $strController;
		$this->_strAction = $strAction;
		$this->run();
	}

	/**
	 * Set layout rendering true or false
	 * 
	 * @param boolean $bFlag
	 */
	public function setLayoutRendering($bFlag) {
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
		$strFile = $this->getHelperApplication()->getModulePath() . '/' . EXCEPTION_MODULE . '/_init.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionModuleExit(Exception $Exception) {
		$strFile = $this->getHelperApplication()->getModulePath() . '/' . EXCEPTION_MODULE . '/_exit.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionControllerInit(Exception $Exception) {
		$strFile = $this->getHelperApplication()->getModulePath() . '/' . EXCEPTION_MODULE . '/index/_init.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionControllerExit(Exception $Exception) {
		$strFile = $this->getHelperApplication()->getModulePath() . '/' . EXCEPTION_MODULE . '/index/_exit.php';
		if (file_exists($strFile)) {
			require($strFile);
		}
	}

	protected function _runExceptionAction(Exception $Exception) {
		ob_start();
		require($this->getHelperApplication()->getModulePath() . '/' . EXCEPTION_MODULE . '/index/index/action.php');
		ob_end_clean();
	}

	protected function _runExceptionView(Exception $Exception) {
		ob_start();
		require($this->getHelperApplication()->getModulePath() . '/' . EXCEPTION_MODULE . '/index/index/output.phtml');
		$this->_strViewOutput = ob_get_contents();
		ob_end_clean();
	}

	protected function _runExceptionLayout(Exception $Exception) {
		/*
		 * CHECK
		 */
		if ($this->getHelperApi()->checkAjaxCall()) {
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