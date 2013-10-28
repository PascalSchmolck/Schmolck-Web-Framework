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
	 * @param object $objMessaage log message
	 */
	static public function emergency($objMessage, $strFile='', $strLine='') {
		self::_WriteMessage('EMERGENCY', self::_getFullMessage($objMessage, $strFile, $strLine), 0);
	}

	/**
	 * Log alert message
	 *
	 * @param object $objMessaage log message
	 */
	static public function alert($objMessage, $strFile='', $strLine='') {
		self::_WriteMessage('ALERT', self::_getFullMessage($objMessage, $strFile, $strLine), 1);
	}

	/**
	 * Log critical message
	 *
	 * @param object $objMessaage log message
	 */
	static public function critical($objMessage, $strFile='', $strLine='') {
		self::_WriteMessage('CRITICAL', self::_getFullMessage($objMessage, $strFile, $strLine), 2);
	}

	/**
	 * Log error message
	 *
	 * @param object $objMessaage log message
	 */
	static public function error($objMessage, $strFile='', $strLine='') {
		self::_WriteMessage('ERROR', self::_getFullMessage($objMessage, $strFile, $strLine), 3);
	}

	/**
	 * Log warning message
	 *
	 * @param object $objMessaage log message
	 */
	static public function warning($objMessage, $strFile='', $strLine='') {
		self::_WriteMessage('WARNING', self::_getFullMessage($objMessage, $strFile, $strLine), 4);
	}

	/**
	 * Log notice message
	 *
	 * @param object $objMessaage log message
	 */
	static public function notice($objMessage, $strFile='', $strLine='') {
		self::_WriteMessage('NOTICE', self::_getFullMessage($objMessage, $strFile, $strLine), 5);
	}

	/**
	 * Log info message
	 *
	 * @param object $objMessaage log message
	 */
	static public function info($objMessage, $strFile='', $strLine='') {
		self::_WriteMessage('INFO', self::_getFullMessage($objMessage, $strFile, $strLine), 6);
	}

	/**
	 * Log debug message
	 *
	 * @param object $objMessaage log message
	 */
	static public function debug($objMessage, $strFile='', $strLine='') {
		self::_WriteMessage('DEBUG', self::_getFullMessage($objMessage, $strFile, $strLine), 7);
	}

	/**
	 * Get full message containing file, line and message nicely formatted
	 * 
	 * @param object $objMessaage log message
	 * @param string $strFile
	 * @param string $strLine
	 * @return string full message
	 */
	static private function _getFullMessage($objMessage, $strFile='?', $strLine='?') {
		switch(gettype($objMessage)) {
			default:
				$strMessage = $objMessage;
				break;
			case 'array':
			case 'object':
				$strMessage = print_r($objMessage, true);
				break;
		}
		
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
	 * @param string $objMessage message text
	 * @param int $nLevel number of backtrace steps
	 *
	 */
	static private function _WriteMessage($strType, $objMessage, $nLevel) {
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
		$strMessage = str_replace("\n", "", $objMessage);
		$strLogMessage .= "{$strType}: {$strMessage}";

		/*
		 * OUTPUT
		 */
		error_log($strLogMessage);
	}

}