<?php

/**
 * Schmolck_Tool_Debug
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Tool_Debug {

	/**
	 * Log alert message
	 *
	 * @param string $strMessage log message
	 */
	static public function emergency($strMessage, $strFile='', $strLine='') {
		self::_WriteMessage('EMERGENCY', self::_getFullMessage($strMessage, $strFile, $strLine), 0);
	}

	/**
	 * Log alert message
	 *
	 * @param string $strMessage log message
	 */
	static public function alert($strMessage, $strFile='', $strLine='') {
		self::_WriteMessage('ALERT', self::_getFullMessage($strMessage, $strFile, $strLine), 1);
	}

	/**
	 * Log critical message
	 *
	 * @param string $strMessage log message
	 */
	static public function critical($strMessage, $strFile='', $strLine='') {
		self::_WriteMessage('CRITICAL', self::_getFullMessage($strMessage, $strFile, $strLine), 2);
	}

	/**
	 * Log error message
	 *
	 * @param string $strMessage log message
	 */
	static public function error($strMessage, $strFile='', $strLine='') {
		self::_WriteMessage('ERROR', self::_getFullMessage($strMessage, $strFile, $strLine), 3);
	}

	/**
	 * Log warning message
	 *
	 * @param string $strMessage log message
	 */
	static public function warning($strMessage, $strFile='', $strLine='') {
		self::_WriteMessage('WARNING', self::_getFullMessage($strMessage, $strFile, $strLine), 4);
	}

	/**
	 * Log notice message
	 *
	 * @param string $strMessage log message
	 */
	static public function notice($strMessage, $strFile='', $strLine='') {
		self::_WriteMessage('NOTICE', self::_getFullMessage($strMessage, $strFile, $strLine), 5);
	}

	/**
	 * Log info message
	 *
	 * @param string $strMessage log message
	 */
	static public function info($strMessage, $strFile='', $strLine='') {
		self::_WriteMessage('INFO', self::_getFullMessage($strMessage, $strFile, $strLine), 6);
	}

	/**
	 * Log debug message
	 *
	 * @param string $strMessage log message
	 */
	static public function debug($strMessage, $strFile='', $strLine='') {
		self::_WriteMessage('DEBUG', self::_getFullMessage($strMessage, $strFile, $strLine), 7);
	}

	/**
	 * Get full message containing file, line and message nicely formatted
	 * 
	 * @param type $strMessage
	 * @param type $strFile
	 * @param type $strLine
	 * @return string full message
	 */
	static private function _getFullMessage($strMessage, $strFile='?', $strLine='?') {
		if ($strFile == '' and $strLine == '') {
			return $strMessage;
		} else {
			return $strMessage . "\nLine: {$strLine} in {$strFile}";
		}
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
	static private function _WriteMessage($strType, $strMessage, $nLevel) {
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

}