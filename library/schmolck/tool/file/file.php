<?php

/**
 * Schmolck_Tool_File
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 */
class Schmolck_Tool_File {

	public $file;
	protected $handle;

	public function __construct($file = "") {
		$this->file = $file;
	}

	public function open($mode) {
		$this->handle = fopen($this->file, $mode);
	}

	public function read() {
		return fgets($this->handle);
	}

	public function eof() {
		return feof($this->handle);
	}

	public function write($string) {
		fwrite($this->handle, $string);
	}

	public function close() {
		fclose($this->handle);
	}

	public static function convertBytes($bytes) {
		$size = number_format(($bytes / pow(2, 10) / 1000), 0);
		if ($size >= 1) {
			return "$size MB";
		}
		$size = number_format(($bytes / pow(2, 10)), 0);
		if ($size >= 1) {
			return "$size KB";
		}
		$size = number_format($bytes, 0);
		return "$size B";
	}

}
