<?php

/**
 * Schmolck_Tool_Dir
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Tool_Dir {

	public $directory;	 // string
	public $includePatterns = array(); // regular expressions
	public $excludePatterns = array(); // regular expressions

	public function getFiles() {
		$filesArray = array();
		if (isset($this->directory) && file_exists($this->directory)) {
			$dirStream = opendir($this->directory);
			while ($file = readdir($dirStream)) {
				if (file_exists($this->directory . "/" . $file) && $file != "." && $file != "..") {
					if ($this->patternCheck($file)) {
						$filesArray[] = utf8_encode($file);
					}
				}
			}
		}
		return $filesArray;
	}

	public function getFullFiles() {
		$filesArray = array();
		if (isset($this->directory) && file_exists($this->directory)) {
			$dirStream = opendir($this->directory);
			while ($file = readdir($dirStream)) {
				if (file_exists($this->directory . "/" . $file) && $file != "." && $file != "..") {
					if ($this->patternCheck($file)) {
						$filesArray[] = $this->directory . "/" . utf8_encode($file);
					}
				}
			}
		}
		return $filesArray;
	}

	public function getDirs() {
		$dirArray = array();
		if (isset($this->directory) && file_exists($this->directory)) {
			$dirStream = opendir($this->directory);
			while ($dir = readdir($dirStream)) {
				if (!is_file($dir) && $dir != "." && $dir != "..") {
					if ($this->patternCheck($dir)) {
						$dirArray[] = $dir;
					}
				}
			}
		}
		return $dirArray;
	}

	public function delete() {
		if (isset($this->directory)) {
			if ($handle = opendir($this->directory)) {
				while (false !== ($item = readdir($handle))) {
					if ($item != "." && $item != "..") {
						$dirItem = $this->directory . "/" . $item;
						if ($this->patternCheck($dirItem)) {
							if (is_dir($dirItem)) {
								$this->delete($dirItem);
							} else {
								unlink($dirItem);
							}
						}
					}
				}
				closedir($handle);
				rmdir($this->directory);
			}
		}
	}

	public function deleteAllOlderThan($seconds) {
		$handle = opendir($this->directory);
		while ($item = readdir($handle)) {
			if ($item != "." && $item != ".." && $item != '.gitignore') {
				$entry = $this->directory . "/$item";
				// check maximum time difference
				if ($seconds <= (time() - filectime($entry))) {
					// check patterns
					if ($this->patternCheck($item)) {
						// distinguish dirs and files
						if (is_dir($entry)) {
							$dir = new CMS_DIR();
							$dir->directory = $entry;
							$dir->delete();
						} elseif (is_file($entry)) {
							unlink($entry);
						}
					}
				}
			}
		}
	}

	private function patternCheck($string) {
		if (!empty($this->includePatterns)) {
			if (preg_match("/" . implode("|", $this->includePatterns) . "/i", $string)) {
				if (!empty($this->excludePatterns)) {
					if (!preg_match("/" . implode("|", $this->excludePatterns) . "/i", $string)) {
						return true;
					}
				} else {
					return true;
				}
			}
		} else {
			if (!empty($this->excludePatterns)) {
				if (!preg_match("/" . implode("|", $this->excludePatterns) . "/", $string)) {
					return true;
				}
			} else {
				return true;
			}
		}
		return false;
	}

}
