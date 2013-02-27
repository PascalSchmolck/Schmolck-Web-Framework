<?php

/**
 * Schmolck_Tool_File
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 * @copyright 2013
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

}
