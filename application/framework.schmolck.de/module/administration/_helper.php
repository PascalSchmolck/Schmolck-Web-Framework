<?php

/**
 * Administration Helper
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Administration_Helper extends Schmolck_Framework_Helper {

    public function __construct(Schmolck_Framework_Core $objCore) {
        parent::__construct($objCore);
    }

    public function verifyLoginData($strUser, $strPassword) {
        /*
         * INIT
         */
        $objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
        $objDB2 = $objCore->getHelperDb2();

        /*
         * QUERY
         */
        $strSQL = "SELECT * FROM REPDBFSC.RPADREP WHERE ADIOCD = '20' AND ADUSER = 'ASPSCPS'";
        $nResult = $objDB2->execute($strSQL);

        /*
         * DEBUG
         */
//        print_r(odbc_result_all($nResult));
//        echo odbc_result($nResult, 'ADUSER');
//        exit();

        return odbc_result($nResult, 'ADUSER');
    }

}