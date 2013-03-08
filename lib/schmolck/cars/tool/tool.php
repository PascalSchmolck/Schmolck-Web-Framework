<?php

/**
 * Schmolck_Cars_Tool
 * 
 * FGC Fahrzeuggruppe-Code
 * FGT Fahrzeuggruppe-Text
 * KAT Kommissionsart-Text
 * KNR Kommissionsnummer
 * FGN Fahrgestellnummer
 * RP Richtpreis
 * FAB Fabrikat
 * FABT Fabrikat-Text
 * TYP Typ
 * PS
 * KW
 * CCM
 * EZ
 * KM
 * BS Betriebsstunden
 * FARBC Farbcode
 * FARB Farbe
 * FARBA Farbart
 * FARBAT Farbart-Text
 * POLSTC Polstercode
 * POLST Polster
 * POLSTA Polsterart
 * POLSTAT Polsterart-Text
 * GA Getriebeart
 * AA Antriebsart
 * ST Standort
 * AU Ausfuehrung
 * AUSTC Ausstattungscodes getrennt durch |
 * SAUST Sonderausstattung getrennt durch |
 * VERKB Fahrzeug-Verkaufsbezeichnung wie auf Rechnung
 * STEUR Besteuerung
 * 
 * @package Schmolck cars
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Cars_Tool {

	const IMAGE_PATH = 'http://www.schmolck.de/data/public/images/vehicles';

	static function getName($arrRow) {
		if (preg_match("/Mercedes/i", $arrRow["FABT"])) {
			return 'Mercedes-Benz ' . $arrRow['TYP'];
		}

		if (preg_match("/smart/i", $arrRow["FABT"])) {
			return 'smart ' . $arrRow['TYP'];
		}

		if (preg_match("/Volkswagen/i", $arrRow["FABT"])) {
			return 'Volkswagen ' . $arrRow['TYP'];
		}
	}

	static public function getEz($arrRow) {
		switch ($arrRow["EZ"]) {
			case "0000-00-00":
				return "-";
				break;
			default:
				return (substr($arrRow["EZ"], 5, 2) . "/" . substr($arrRow["EZ"], 0, 4));
				break;
		}
	}

	static public function getKm($arrRow) {
		return number_format($arrRow['KM'], 0, ',', ".");
	}

	static public function getPrice($arrRow) {
		return number_format($arrRow["RP"], 0, "", ".");
	}

	static public function getColor($arrRow) {
		$arrRow["FARB"] = strtolower($arrRow["FARB"]);
		switch ($arrRow["FABT"]) {
			default:
				return $arrRow["FARB"];
				break;
			case "Mercedes-Benz":
				return $arrRow["FARBC"] . " " . $arrRow["FARB"];
				break;
		}
	}

	static public function getFirstImageUrl($arrRow) {
		return self::IMAGE_PATH . '/' . $arrRow['KNR'] . ',1.JPG';
	}

}