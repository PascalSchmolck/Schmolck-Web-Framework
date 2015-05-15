<?php

/**
 * Schmolck_Tool_File_Po
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 */
class Schmolck_Tool_File_Po extends Schmolck_Tool_File {

	public function getArray() {
		$array = array();
		$next = "msgid";
		foreach (file($this->file) as $line) {
			if ($next == "msgid") {
				if (preg_match("/$next/", $line)) {
					if (!empty($msgid) && !empty($msgstr)) {
						$array[$msgid] = $msgstr;
						$counter++;
					}
					$msgid = trim(str_replace("\"", "", str_replace($next, "", $line)));
					$next = "msgstr";
				} else {
					if (preg_match("/\"/", $line)) {
						$msgstr .= str_replace("\"", "", $line);
					}
				}
			} elseif ($next == "msgstr") {
				if (preg_match("/$next/", $line)) {
					$msgstr = trim(str_replace("\"", "", str_replace($next, "", $line)));
					$next = "msgid";
				} else {
					if (preg_match("/\"/", $line)) {
						$msgid .= trim(str_replace("\"", "", $line));
					}
				}
			}
		}
		if (!empty($msgid) && !empty($msgstr)) {
			$array[$msgid] = $msgstr;
		}
		return $array;
	}

}
