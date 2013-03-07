<?php
/**
 * Schmolck_Tool_Debug
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Tool_Debug
{
	/**
	 * Log alert message
	 *
	 * @param string $strMessage log message
	 */
	static public function emergency($strMessage)
	{
		self::_WriteMessage('EMERGENCY', $strMessage, 0);
	}

	/**
	 * Log alert message
	 *
	 * @param string $strMessage log message
	 */
	static public function alert($strMessage)
	{
		self::_WriteMessage('ALERT', $strMessage, 1);
	}

	/**
	 * Log critical message
	 *
	 * @param string $strMessage log message
	 */
	static public function critical($strMessage)
	{
		self::_WriteMessage('CRITICAL', $strMessage, 2);
	}

	/**
	 * Log error message
	 *
	 * @param string $strMessage log message
	 */
	static public function error($strMessage)
	{
		self::_WriteMessage('ERROR', $strMessage, 3);
	}

	/**
	 * Log warning message
	 *
	 * @param string $strMessage log message
	 */
	static public function warning($strMessage)
	{
		self::_WriteMessage('WARNING', $strMessage, 4);
	}

	/**
	 * Log notice message
	 *
	 * @param string $strMessage log message
	 */
	static public function notice($strMessage)
	{
		self::_WriteMessage('NOTICE', $strMessage, 5);
	}

	/**
	 * Log info message
	 *
	 * @param string $strMessage log message
	 */
	static public function info($strMessage)
	{
		self::_WriteMessage('INFO', $strMessage, 6);
	}

	/**
	 * Log debug message
	 *
	 * @param string $strMessage log message
	 */
	static public function debug($strMessage)
	{
		self::_WriteMessage('DEBUG', self::_GetCallingClass().'->'.self::_GetCallingFunction().'(): '.$strMessage, 7);
	}

	/**
	 * Get calling class and function name
	 *
	 * @return string calling class->function
	 */
	static public function getCallingClassAndFunction()
	{
		$arrDebugBacktrace = debug_backtrace();
		return $arrDebugBacktrace[2]['class'].'->'.$arrDebugBacktrace[2]['function'];
	}

	/**
	 * Write message according to level
	 *
	 * 0 Emergency: system is unusable
	 * 1 Alert: action must be taken immediately
	 * 2 Critical: critical conditions
	 * 3 Error: error conditions
	 * 4 Warning: warning conditions
	 * 5 Notice: normal but significant condition
	 * 6 Informational: informational messages
	 * 7 Debug: debug messages
	 *
	 * @param string $strType message type
	 * @param string $strMessage message text
	 * @param int $nLevel number of backtrace steps
	 *
	 */
	static private function _WriteMessage($strType, $strMessage, $nLevel)
	{
		//-------
		// CHECK
		//-------
		// - only write log if level is of importance
		if (DEBUG_LEVEL < $nLevel) {
			return;
		}

		/*
		 * MESSAGE
		 */
		$strLogMessage .= "{$strType}: {$strMessage}";

		/*
		 * OUTPUT
		 */
		error_log($strLogMessage);
	}

	/**
	 * Get calling class name
	 *
	 * @return string calling class
	 */
	static private function _GetCallingClass()
	{
		$arrDebugBacktrace = debug_backtrace();
		return $arrDebugBacktrace[2]['class'];
	}

	/**
	 * Get calling function name
	 *
	 * @return string calling function
	 */
	static private function _GetCallingFunction()
	{
		$arrDebugBacktrace = debug_backtrace();
		return $arrDebugBacktrace[2]['function'];
	}
}