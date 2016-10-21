<?php

/**
 * Controling Helper Class
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Controling_Helper extends Schmolck_Framework_Helper {

    public function getBusiness() {

        $strCacheKey = __CLASS__ . __METHOD__ . date('Y.m.d');
        $objCache = $this->_objCore->getHelperCache();


        if (!$objCache->isEmpty($strCacheKey)) {
            $arrResult = unserialize($this->_objCore->getHelperCache()->getData($strCacheKey));
        } else {
            $arrResult = array();

            $objDb2 = $this->_objCore->getHelperDb2();

            $strSQL = "
SELECT t1.Filiale, t1.Anzahl AS \"2013\", t2.Anzahl AS \"2014\", t3.Anzahl AS \"2015\", t4.Anzahl AS \"2016\"
FROM
	(SELECT eeavcd AS Filiale, SUBSTRING(eeeodt, 2, 2) AS Jahr, count(*) AS Anzahl 
	FROM repdbfsc.rpeecpp
	WHERE eefacd = '20'
	AND SUBSTRING(eeeodt, 1, 3) = '113'
	AND (EEJ9CD = 'PME' OR EEJ9CD = 'NME' OR EEJ9CD = 'N10' OR EEJ9CD = 'N20' OR EEJ9CD = 'N30' OR EEJ9CD = 'S10' OR EEJ9CD = 'S20')
	GROUP BY eeavcd, SUBSTRING(eeeodt, 2, 2)
	ORDER BY eeavcd) t1
LEFT JOIN
	(SELECT eeavcd AS Filiale, SUBSTRING(eeeodt, 2, 2) AS Jahr, count(*) AS Anzahl 
	FROM repdbfsc.rpeecpp
	WHERE eefacd = '20'
	AND SUBSTRING(eeeodt, 1, 3) = '114'
	AND (EEJ9CD = 'PME' OR EEJ9CD = 'NME' OR EEJ9CD = 'N10' OR EEJ9CD = 'N20' OR EEJ9CD = 'N30' OR EEJ9CD = 'S10' OR EEJ9CD = 'S20')
	GROUP BY eeavcd, SUBSTRING(eeeodt, 2, 2)
	ORDER BY eeavcd) t2
LEFT JOIN
	(SELECT eeavcd AS Filiale, SUBSTRING(eeeodt, 2, 2) AS Jahr, count(*) AS Anzahl 
	FROM repdbfsc.rpeecpp
	WHERE eefacd = '20'
	AND SUBSTRING(eeeodt, 1, 3) = '115'
	AND (EEJ9CD = 'PME' OR EEJ9CD = 'NME' OR EEJ9CD = 'N10' OR EEJ9CD = 'N20' OR EEJ9CD = 'N30' OR EEJ9CD = 'S10' OR EEJ9CD = 'S20')
	GROUP BY eeavcd, SUBSTRING(eeeodt, 2, 2)
	ORDER BY eeavcd) t3
LEFT JOIN
	(SELECT eeavcd AS Filiale, SUBSTRING(eeeodt, 2, 2) AS Jahr, count(*) AS Anzahl 
	FROM repdbfsc.rpeecpp
	WHERE eefacd = '20'
	AND SUBSTRING(eeeodt, 1, 3) = '116'
	AND (EEJ9CD = 'PME' OR EEJ9CD = 'NME' OR EEJ9CD = 'N10' OR EEJ9CD = 'N20' OR EEJ9CD = 'N30' OR EEJ9CD = 'S10' OR EEJ9CD = 'S20')
	GROUP BY eeavcd, SUBSTRING(eeeodt, 2, 2)
	ORDER BY eeavcd) t4
ON
	t4.Filiale = t3.Filiale
ON 
	t3.Filiale = t2.Filiale
ON
	t2.Filiale = t1.Filiale
ORDER BY t1.Filiale             
        ";

            $nResult = $objDb2->execute($strSQL);
            while ($objDb2->fetchRow($nResult)) {
                $arrColumns = array();
                $arrColumns[] = $objDb2->getResult($nResult, '2013');
                $arrColumns[] = $objDb2->getResult($nResult, '2014');
                $arrColumns[] = $objDb2->getResult($nResult, '2015');
                $arrColumns[] = $objDb2->getResult($nResult, '2016');
                $arrResult[] = $arrColumns;
            }
            $this->_objCore->getHelperCache()->setData($strCacheKey, serialize($arrResult));
        }
        return $arrResult;
    }

}