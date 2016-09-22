<?php

/**
 * Schmolck 
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Framework_Helper_Db2 extends Schmolck_Framework_Helper {

    private $_nConnection;

    public function __construct() {
        $this->_nConnection = odbc_connect(DB2_DSN, DB2_USER, DB2_PASSWORD, SQL_CUR_USE_ODBC);
        if (!$this->_nConnection) {
            throw new Exception("CARE database connection failed!");
        }
    }

    public function execute($strSQL) {
        return odbc_exec($this->_nConnection, $strSQL);
    }

    public function fetchRow($nResult) {
        return odbc_fetch_row($nResult);
    }

    public function getResult($nResult, $strColumn) {
        return odbc_result($nResult, $strColumn);
    }

}
