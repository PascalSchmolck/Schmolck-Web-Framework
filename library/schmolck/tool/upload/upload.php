<?php

/**
 * Schmolck_Tool_Upload
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Tool_Upload {

    /**
     * ReArray $_FILES upload array
     * 
     * @param array $_FILES upload array
     * @return array rearranged file array
     */
    public function reArrayFiles(&$FILES) {
        $arrFiles = array();
        $nCount = count($FILES['name']);
        $arrFileKeys = array_keys($FILES);

        for ($i = 0; $i < $nCount; $i++) {
            foreach ($arrFileKeys as $key) {
                $arrFiles[$i][$key] = $FILES[$key][$i];
            }
        }
        return $arrFiles;
    }

}
