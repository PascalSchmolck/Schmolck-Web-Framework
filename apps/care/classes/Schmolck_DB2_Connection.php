<?php

/* * *
 * Schmolck DB2 Connection Class
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */

class Schmolck_DB2_Connection {

    private $_nConnection;

    public function __construct($dsn, $user, $password) {
        $this->_nConnection = odbc_connect($dsn, $user, $password, SQL_CUR_USE_ODBC);
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

}
