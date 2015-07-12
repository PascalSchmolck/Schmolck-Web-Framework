<?php

/**
 * Url helper
 * 
 * @package cars.schmolck.de
 * @author Pascal Schmolck
 */
class Url_Helper extends Schmolck_Framework_Helper {

    const PATH = URL_PATH;

    public function encodeUrl($strUrl) {
        /*
         * INITIALISATION
         */
        $objCore = Schmolck_Framework_Core::getInstance($this->_objCore);

        /*
         * PROCESSING
         */
        $strBaseUrl = $objCore->getHelperApplication()->getBaseUrl();
        $strModulePath = 'u/r/l/s';
        $strHash = md5($strUrl);
        
        /*
         * SAVING
         */
        $strHashFile = self::PATH . '/' . $strHash;
        if (!file_exists($strHashFile)) {
            file_put_contents($strHashFile, $strUrl);
        }

        /*
         * OUTPUT
         */
        return $strBaseUrl . '/' . $strModulePath . '/' . $strHash;
    }

    public function decodeUrl($strHash) {
        /*
         * PROCESSING
         */
        $strHashFile = self::PATH . '/' . $strHash;
        if (file_exists($strHashFile)) {
            return file_get_contents($strHashFile);
        } else {
            throw new Exception('No corresponding hash file found', 1);
        }
    }

}
