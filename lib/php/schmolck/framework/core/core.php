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
	protected $_arrViewScripts;

	protected $_strViewOutput;

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
	 * Render <styles> tags
	 */
	public function renderViewStyles() 
	{
		/*
		 * CHECK
		 */
		// - nothing to do if no styles registered
		if (count($this->_arrViewStyles) < 1) {
			return;
		}
		
		/*
		 * PROCESSING
		 */
		// - optimize all styles into one string
		foreach ($this->_arrViewStyles as $strFile) {
			if (file_exists($strFile)) {
				// - do not minify on development environment
				if (APPLICATION_ENVIRONMENT == 'development') {
					$strCombinedCSS .= "\n\n/* {$strFile} */\n\n".file_get_contents($strFile);
				} else {
					$strCombinedCSS .= Schmolck_Framework_Optimizer::getOptimizedCssString(file_get_contents($strFile));
				}
			}
		}
		// - get md5 hash of optimized styles and create tmp file
		$strTempFile = Schmolck_Framework_Tmp::getFilePath(md5($strCombinedCSS).'.css');
		// - fill tmp file with optimized styles
		file_put_contents($strTempFile, $strCombinedCSS);
		
		/*
		 * OUTPUT
		 */
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$strTempFile}\" />\n";
	}

	/**
	 * Render <script> tags
	 */
	public function renderViewScripts() 
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
		echo "<script type=\"text/javascript\" src=\"{$strTempFile}\"></script>\n";
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