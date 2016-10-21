<?php

/**
 * Schmolck_Framework_Helper_Cache
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Framework_Helper_Cache extends Schmolck_Framework_Helper {

    const PATH = 'tmp';
    const LIMIT_CLEAN = 86400;  // seconds
    const LIMIT_CACHE = 'd';  // date()

    public function init() {
        /*
         * CLEAN
         */
        // - directory
        if (!$this->restore('clean')) {
            // - only once per session
            $this->cleanDir();
            $this->store('clean', true);
        }
    }

    /**
     * Get tmp file path for given name
     * 
     * @param string $strName file name
     * @return string tmp file path
     */
    public function getFilePath($strName) {
        return self::PATH . '/' . md5($strName . date(self::LIMIT_CACHE));
    }

    /**
     * Clean obsolete tmp files
     */
    public function cleanDir() {
        /*
         * CLEANING
         */
        $dir = new Schmolck_Tool_Dir();
        $dir->directory = self::PATH;
        $dir->deleteAllOlderThan(self::LIMIT_CLEAN);

        /*
         * DEBUGGING
         */
        Schmolck_Tool_Debug::info(sprintf("Cache dir '%s' has been cleaned", self::PATH));
    }

    /**
     * Get cache data depending on key
     * 
     * @param string $strKey
     * @return string
     */
    public function getData($strKey) {
        $strFile = $this->getFilePath($strKey);
        if (file_exists($strFile)) {
            return file_get_contents($strFile);
        }
    }

    /**
     * Set cache data for given key
     * 
     * @param string $strKey
     * @param string $strData
     */
    public function setData($strKey, $strData) {
        $strFile = $this->getFilePath($strKey);
        file_put_contents($strFile, $strData);
    }

    /**
     * Check for given key if empty
     * 
     * @param string $strKey
     * @return boolean
     */
    public function isEmpty($strKey) {
        $strFile = $this->getFilePath($strKey);
        if (file_exists($strFile)) {
            $strData = file_get_contents($strFile);
            return ($strData === "");
        } else {
            return true;
        }
    }

}