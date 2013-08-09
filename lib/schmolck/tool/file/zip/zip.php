<?php

/**
 * Schmolck_Tool_File_Zip
 * 
 * @package Schmolck
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Tool_File_Zip extends Schmolck_Tool_File {

	public function unzip(){
		/*
		 * CHECK
		 */
		if(!file_exists($this->file)){
			throw new Exception("ZIP file not found");
		}
		
		/*
		 * PROCESSING
		 */
		$zip = zip_open($this->file);
		if(is_resource($zip)){
			while($zip_entry = zip_read($zip)){
				if(zip_entry_open($zip, $zip_entry, "r")){
					$fileName = utf8_encode(zip_entry_name($zip_entry));
					$filePointer = fopen(dirname($this->file)."/$fileName", "w");
					fwrite($filePointer, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
					fclose($filePointer);
					zip_entry_close($zip_entry);
				}else{
					throw new Exception("ZIP file extraction failed");
				}
			}
			zip_close($zip);
		}else{
			throw new Exception("ZIP file could not be opened");
		}
	}
}
