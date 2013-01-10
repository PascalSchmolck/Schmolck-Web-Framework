<?php
/**
 * Schmolck_Framework_Core
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Core 
{
	const MOD_PATH = 'mod';

	protected $_strExceptionModule;

	protected $_strModule;
	protected $_strController;
	protected $_strAction;

	protected $_bLayoutRendering;

	protected $_arrViewStyles;
	protected $_arrViewLESS;
	protected $_arrViewScripts;

	protected $_strViewOutput;
	protected $_strTrace;

	public function __construct() 
	{
		/*
		 * PREPARATION
		 */
		$this->setLayoutRendering(true);
		$this->setExceptionModule('exception');
		$this->initHost();
		$this->cleanTmp();
	}
	
	/**
	 * Clean obsolete tmp files
	 */
	public function cleanTmp()
	{
		Schmolck_Framework_Tmp::clean();
	}
	
	/**
	 * Initialise host settings and parameters
	 */
	public function initHost()
	{
		/*
		 * SETTINGS
		 */
		require(Schmolck_Framework_Host::getCurrentPath().'/settings.php');
		
		/*
		 * PARAMETERS
		 */
		require(Schmolck_Framework_Host::getCurrentPath().'/parameters.php');
		$this->_strModule = ($strModule != '')? $strModule : 'index';
		$this->_strController = ($strController != '')? $strController : 'index';
		$this->_strAction = ($strAction != '')? $strAction : 'index';
	}

	public function setExceptionModule($strModule) 
	{
		$this->_strExceptionModule = $strModule;
	}
	
	/**
	 * Register single LESS file
	 * 
	 * @param string $file
	 * @throws Exception
	 */
	public function registerViewLESS($file) 
	{
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
	public function registerViewLESSs($arrFiles)
	{
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
	public function registerViewJS($file) 
	{
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
	public function registerViewJSs($arrFiles) 
	{
		if (count($arrFiles) > 0) {
			foreach ($arrFiles as $strFile) {
				$this->registerViewJS($strFile);
			}
		}
	}	

	/**
	 * Run through whole MVC process
	 */
	public function run() 
	{
		try {
			$this->_strTrace = 'ApplicationInit';
			$this->_runApplicationInit();
			
			$this->_strTrace = 'ModuleInit';
			$this->_runModuleInit();
			
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
		} catch (Exception $Exception) {
			ob_end_clean();
			$this->_RunExceptionHandling($Exception);
		}
	}

	protected function _runApplicationInit() 
	{
		require(self::MOD_PATH . "/_init.php");
	}

	protected function _runApplicationExit() 
	{
		require(self::MOD_PATH . "/_exit.php");
	}

	protected function _runModuleInit() 
	{
		$strFile = self::MOD_PATH . "/{$this->_strModule}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Init file for module '{$this->_strModule}' not found");
		}
	}

	protected function _runModuleExit() 
	{
		$strFile = self::MOD_PATH . "/{$this->_strModule}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Exit file for module '{$this->_strModule}' not found");
		}
	}

	protected function _runControllerInit() 
	{
		$strFile = self::MOD_PATH . "/{$this->_strModule}/{$this->_strController}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Controller init file for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
	}

	protected function _runControllerExit() {
		$strFile = self::MOD_PATH . "/{$this->_strModule}/{$this->_strController}/_exit.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Controller exit file for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
		}
	}

	protected function _runAction() {
		ob_start();
			$strFile = self::MOD_PATH . "/{$this->_strModule}/{$this->_strController}/{$this->_strAction}.action.php";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("Action file '{$this->_strAction}.action.php' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
			}
		ob_end_clean();
	}

	protected function _runLayoutInit() {
		$strPath = Schmolck_Framework_Host::getCurrentPath().'/template/'.APPLICATION_TEMPLATE;
		$strFile = "{$strPath}/_init.php";
		if (file_exists($strFile)) {
			require($strFile);
		} else {
			throw new Exception("Layout init file '{$strFile}' not found");
		}
	}
	
	protected function _runLayout() {
		if ($this->_bLayoutRendering) {			
			/*
			 * INIT
			 */
			$strPath = Schmolck_Framework_Host::getCurrentPath().'/template/'.APPLICATION_TEMPLATE;
			$strFile = "{$strPath}/_init.php";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("Layout init file '{$strFile}' not found");
			}
			
			/*
			 * RUN
			 */
			$strPath = Schmolck_Framework_Host::getCurrentPath().'/template/'.APPLICATION_TEMPLATE;
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
			$strPath = Schmolck_Framework_Host::getCurrentPath().'/template/'.APPLICATION_TEMPLATE;
			$strFile = "{$strPath}/_exit.php";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("Layout exit file '{$strFile}' not found");
			}			
		} else {
			$this->_renderView();
		}
	}

	protected function _runView() 
	{
		ob_start();
			$strFile = self::MOD_PATH . "/{$this->_strModule}/{$this->_strController}/{$this->_strAction}.view.phtml";
			if (file_exists($strFile)) {
				require($strFile);
			} else {
				throw new Exception("View file '{$this->_strAction}.view.phtml' for module '{$this->_strModule}' and controller '{$this->_strController}' not found");
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
	 * Get core LESS file
	 */
	public function getCoreLESSFile() 
	{
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
					$strCombinedLESS .= "\n\n/* {$strFile} */\n\n".file_get_contents($strFile);
				} else {
					// - no optimizer for LESS found yet
					//$strCombinedLESS .= Schmolck_Framework_Optimizer::getOptimizedCssString(file_get_contents($strFile));
					$strCombinedLESS .= "\n\n/* {$strFile} */\n\n".file_get_contents($strFile);
				}
			}
		}
		// - get md5 hash of optimized styles and create tmp file
		$strTempFile = Schmolck_Framework_Tmp::getFilePath(md5($strCombinedLESS).'.less');
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
	public function getCoreJSFile() 
	{
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
					$strCombinedJs .= "\n\n/* {$strFile} */\n\n".file_get_contents($strFile);
				} else {				
					$strCombinedJs .= Schmolck_Framework_Optimizer::getOptimizedJsString(file_get_contents($strFile));
				}
			}
		}
		// - get md5 hash of optimized scripts and create tmp file
		$strTempFile = Schmolck_Framework_Tmp::getFilePath(md5($strCombinedJs).'.js');
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
	public function getBaseUrl()
	{
		return Schmolck_Framework_Host::getBaseUrl();
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
		require(self::MOD_PATH . "/{$this->_strExceptionModule}/_init.php");
	}

	protected function _runExceptionModuleExit(Exception $Exception) {
		require(self::MOD_PATH . "/{$this->_strExceptionModule}/_exit.php");
	}

	protected function _runExceptionControllerInit(Exception $Exception) {
		require(self::MOD_PATH . "/{$this->_strExceptionModule}/index/_init.php");
	}

	protected function _runExceptionControllerExit(Exception $Exception) {
		require(self::MOD_PATH . "/{$this->_strExceptionModule}/index/_exit.php");
	}

	protected function _runExceptionAction(Exception $Exception) {
		ob_start();
		require(self::MOD_PATH . "/{$this->_strExceptionModule}/index/index.action.php");
		ob_end_clean();
	}

	protected function _runExceptionView(Exception $Exception) {
		ob_start();
		require(self::MOD_PATH . "/{$this->_strExceptionModule}/index/index.view.phtml");
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