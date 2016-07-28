<?php

/* * *
 * CARE Apps
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
require_once("config.php");
require_once("classes/Schmolck_DB2_Connection.php");

/*
 * INIT
 */
$objCareDB = new Schmolck_DB2_Connection($dsn, $user, $password);

/*
 * QUERY
 */
// Schätzung der WR Vor-Order für Filiale 03 ab 01.01.2016
$strSQL = "
SELECT * FROM REPDBFSC.RPEFCPP
LEFT JOIN REPDBFSC.RPEECPP
ON EEBZCD = EFBZCD
WHERE EFFACD = 20
AND EFAVCD = 03
AND EFB2DT > '1160101'
AND EFKPCD = '6900005'
ORDER BY EFB2DT, EFJ7CD, EFDENB
";
$nResult = $objCareDB->execute($strSQL);

// DEBUG
//print_r(odbc_result_all($nResult));
//exit();

$arrRows = array();
while ($objCareDB->fetchRow($nResult)) {
    $bCatch = false;
    $Kundennummer = odbc_result($nResult, 'EFL7CD');
    $Kennzeichen = odbc_result($nResult, 'EEGATX');
    $Fahrgestellnummer = odbc_result($nResult, 'EEHGCD');
    $Rechnungsdatum = odbc_result($nResult, 'EFB2DT');
    $Rechnungsnummer = odbc_result($nResult, 'EFBZCD');
    $Auftragsart = odbc_result($nResult, 'EFJ9CD');
    $Auftragsnummer = odbc_result($nResult, 'EFJ7CD');
    $Positionsnummer = odbc_result($nResult, 'EFDENB');
    $Positionsbezeichnung = odbc_result($nResult, 'EFATTY');


    // Positionsnummer speichern, wenn Winterreifen gemessen wurden...
    if (preg_match("/W\(x\)/i", $Positionsbezeichnung)) {
        $nTempPosNr = $Positionsnummer;
    }

    // Zeile greifen, wenn die nächste Zeile nach W(x)...
    if ($Positionsnummer == $nTempPosNr + 1) {

        // ...aber nur, wenn kleiner als 4mm
        if (preg_match("/3,/i", $Positionsbezeichnung)) {
            $bCatch = true;
        }
        if (preg_match("/2,/i", $Positionsbezeichnung)) {
            $bCatch = true;
        }
        if (preg_match("/1,/i", $Positionsbezeichnung)) {
            $bCatch = true;
        }
        if (preg_match("/0,/i", $Positionsbezeichnung)) {
            $bCatch = true;
        }
    }

    if ($bCatch) {
        $arrRows[] = array(
            $Kundennummer,
            $Kennzeichen,
            $Fahrgestellnummer,
            $Rechnungsdatum,
            $Rechnungsnummer,
            $Auftragsart,
            $Auftragsnummer,
            $Positionsnummer,
            $Positionsbezeichnung
        );
    }




//    echo odbc_result_all($nResult)."\n";
}

/*
 * OUTPUT 
 */
//foreach ($arrRows as $arrColumns) {
//    foreach ($arrColumns as $strEntry) {
//        echo trim($strEntry);
//        echo ";";
//    }
//    echo "<br>";
//}
echo "<table border='1'>";
foreach ($arrRows as $arrColumns) {
    echo "<tr>";
    foreach ($arrColumns as $strEntry) {
        echo "<td>";
        echo trim($strEntry);
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table>";
