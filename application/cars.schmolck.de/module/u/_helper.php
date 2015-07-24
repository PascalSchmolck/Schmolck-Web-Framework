<?php

/**
 * Url helper
 * 
 * @package cars.schmolck.de
 * @author Pascal Schmolck
 */
class Url_Helper extends Schmolck_Framework_Helper {

    const HASH_PATH = HASH_PATH;
    const URL_PATH = URL_PATH;

    /**
     * Encode / hash given URL
     * 
     * @param string $strUrl
     * @return string encoded URL
     */
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
        $strHashFile = self::HASH_PATH . '/' . $strHash;
        if (!file_exists($strHashFile)) {
            file_put_contents($strHashFile, $strUrl);
        }

        /*
         * OUTPUT
         */
        return $strBaseUrl . '/' . $strModulePath . '/' . $strHash;
    }

    /**
     * Decode / unhash given Hash
     * 
     * @param string $strHash
     * @return string URL
     * @throws Exception
     */
    public function decodeUrl($strHash) {
        /*
         * PROCESSING
         */
        $strHashFile = self::HASH_PATH . '/' . $strHash;
        if (file_exists($strHashFile)) {
            $strUrl = file_get_contents($strHashFile);
            $this->_countUrl($strUrl);
            return $strUrl;
        } else {
            throw new Exception('No corresponding hash file found', 1);
        }
    }

    /**
     * Get URL statistics
     * 
     * @return array of urls and calls
     */
    public function getUrlStatistics() {
        /*
         * PREPARATION
         */
        $objDir = new Schmolck_Tool_Dir();
        $objDir->directory = self::URL_PATH;
        $arrFiles = $objDir->getFullFiles();

        /*
         * PROCESSING
         */
        foreach ($arrFiles as $strFile) {
            $strUrl = urldecode(basename($strFile));
            $strCounter = file_get_contents($strFile);
            $arrUrls[] = array(
                'url' => $strUrl,
                'counter' => $strCounter,
            );
            // - helper for sorting
            $arrUrl[] = $strUrl;
            $arrCounter[] = $strCounter;
        }
        /*
         * SORTING
         */
        array_multisort($arrCounter, SORT_DESC, $arrUrl, SORT_ASC, $arrUrls);
        
        /*
         * OUTPUT
         */
        return $arrUrls;
    }

    /**
     * Count / increment calls of given URL
     * 
     * @param string $strUrl
     */
    protected function _countUrl($strUrl) {
        $nCounter = 0;
        $strUrlFile = self::URL_PATH . '/' . urlencode($strUrl);
        if (file_exists($strUrlFile)) {
            $nCounter = intval(file_get_contents($strUrlFile));
        }
        $nCounter++;
        file_put_contents($strUrlFile, $nCounter);
    }

}
