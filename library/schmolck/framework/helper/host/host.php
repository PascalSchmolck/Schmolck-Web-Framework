<?php

/**
 * Schmolck_Framework_Helper_Host
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Framework_Helper_Host extends Schmolck_Framework_Helper {

    const PATH = 'host';
    const ENVIRONMENT_PROD = 'production';
    const ENVIRONMENT_DEV = 'development';
    const ENVIRONMENT_TEST = 'testing';

    /**
     * Get config file corresponding to current host
     * 
     * @return string config file
     */
    static public function getConfigFile() {
        /*
         * PREPARATION 
         */
        $strHost = strtolower($_SERVER['HTTP_HOST']);
        $strPath = self::PATH;
        $arrEnvs = array(
            self::ENVIRONMENT_PROD,
            self::ENVIRONMENT_TEST,
            self::ENVIRONMENT_DEV
        );

        /*
         * PROCESSING
         */
        foreach ($arrEnvs as $strEnv) {
            $strFile = "{$strPath}/{$strEnv}/{$strHost}.php";
            if (file_exists($strFile)) {
                define('APPLICATION_ENVIRONMENT', $strEnv);
                return $strFile;
            }
        }

        /*
         * EXCEPTION
         */
        // - no corresponding file found
        throw new Exception('No corresponding host config found: ' . $_SERVER['HTTP_HOST']);
    }

}
