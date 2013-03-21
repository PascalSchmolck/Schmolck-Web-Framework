<?php

/**
 * Schmolck_Cars_Helper
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
class Schmolck_Cars_Helper extends Schmolck_Framework_Helper {

	const IMAGE_PATH = 'http://www.schmolck.de/data/public/images/vehicles';
	const DATA_FILE = 'http://www.schmolck.de/data/private/vehicles/IFZ.csv';
	const DB_TABLE = 'mod_cars';
	const UPDATE_LIMIT = 1800;

	protected $_arrFilter;
	protected $_arrMemoryAttributes = array(
		'_arrFilter'
	);
	
	public function init() {
		$this->updateFromCSV();
	}

	/**
	 * Set car filter
	 * 
	 * @param type $strName
	 * @param type $strValue
	 */
	public function setFilter($strName, $strValue) {
		$this->_arrFilter[$strName] = mysql_real_escape_string($strValue);
	}

	/**
	 * Query cars according to filters
	 */
	public function queryFilteredCars() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);

		/*
		 * PREPARATION
		 */
		// - brand
		switch ($this->_arrFilter['brand']) {
			default:
				if (trim($this->_arrFilter['brand']) != '') {
					$strWhereBrand = "
						AND FABT LIKE '{$this->_arrFilter['brand']}'
					";
				}
				break;
			case 'all':
				$strWhereBrand = "
					AND FABT LIKE '%'
				";
				break;
			case 'others':
				$strWhereBrand = "
					AND FABT NOT LIKE 'Mercedes-Benz'
					AND FABT NOT LIKE 'Smart'
					AND FABT NOT LIKE 'Volkswagen'
				";
				break;
		}
		// - type
		switch ($this->_arrFilter['type']) {
			default:
				if (trim($this->_arrFilter['type']) != '') {
					$strWhereType = "
						AND KAT LIKE '{$this->_arrFilter['type']}'
					";
				}
				break;
			case 'all':
				$strWhereType = "
					AND KAT LIKE '%'
				";
				break;
		}
		// - price
		switch ($this->_arrFilter['price']) {
			default:
				if (trim($this->_arrFilter['price']) != '') {
					$strWherePrice = "
						AND RP <= {$this->_arrFilter['price']}
					";
				}
				break;
			case 'all':
				continue;
				break;
		}
		// - km
		switch ($this->_arrFilter['km']) {
			default:
				if (trim($this->_arrFilter['km']) != '') {
					$strWhereKm = "
						AND KM <= '{$this->_arrFilter['km']}'
					";
				}
				break;
			case 'all':
				continue;
				break;
		}	
		// - sorting
		switch ($this->_arrFilter['sorting']) {
			default:
			case 'price':
				$strSorting = "
					RP ASC
				";
				break;
			case 'km':
				$strSorting = "
					KM ASC
				";
				break;			
		}			

		/*
		 * QUERY
		 */
		$strQuery = "
			SELECT 
				* 
			FROM 
				" . self::DB_TABLE . "
			WHERE
				TRUE
				$strWhereBrand
				$strWhereType
				$strWhereKm
				$strWherePrice
			ORDER BY
				$strSorting
		";	
		$resource = $objCore->getHelperDatabase()->query($strQuery);
		while ($arrRow = mysql_fetch_assoc($resource)) {
			$arrRow['name'] = $this->extractName($arrRow);
			$arrRow["EZ"] = $this->extractEz($arrRow);
			$arrRow["KM"] = $this->extractKm($arrRow);
			$arrRow["RP"] = $this->extractPrice($arrRow);
			$arrRow["color"] = $this->extractColor($arrRow);
			$arrRow["image"] = $this->extractFirstImageUrl($arrRow);
			$arrResult[] = $arrRow;
		}
		return $arrResult;
	}

	/**
	 * Update database from CSV if required
	 */
	public function updateFromCSV() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);

		/*
		 * SESSION
		 */
		// - only update if necessary
		if ($this->_isUpToDate()) {
			Schmolck_Tool_Debug::info(sprintf('Cars database still up-to-date and not older than %s minutes', (self::UPDATE_LIMIT / 60)));
			return;
		}

		/*
		 * COPY
		 */
		$strTempFile = $this->_getTempFile();
		copy(self::DATA_FILE, $strTempFile);

		/*
		 * CHECK
		 */
		// - determine columns
		$resource = $objCore->getHelperDatabase()->query("SHOW COLUMNS FROM " . self::DB_TABLE);
		$nColumns = mysql_num_rows($resource);

		/*
		 * UPDATE
		 */
		// - read file...
		$handle = fopen($strTempFile, 'r');
		while (!feof($handle)) {

			// - ...line by line
			$strLine = fgets($handle);
			$arrData = explode(";", $strLine);
			$nCounter++;

			// - ignore empty lines
			if (trim($strLine) == '') {
				continue;
			}

			// - consider line only if it matches the amount of columns
			if (count($arrData) == $nColumns) {
				// - build insert query
				$strQuery1 = "INSERT INTO `" . self::DB_TABLE . "` VALUES (";
				$strQuery2 = "";
				$strQuery3 = ")";

				for ($i = 0; $i < $nColumns; $i++) {
					$strQuery2 = $strQuery2 . "'" . mysql_real_escape_string(trim($arrData[$i])) . "', ";
				}
				$strQuery2 = substr($strQuery2, 0, -2);

				// - clear table first
				if (!$bEmptied) {
					$objCore->getHelperDatabase()->query("TRUNCATE TABLE `" . self::DB_TABLE . "`");
					$bEmptied = true;
				}
				// - insert
				$objCore->getHelperDatabase()->query($strQuery1 . $strQuery2 . $strQuery3);
			} else {
				Schmolck_Tool_Debug::error('CSV file contains wrong column number in line ' . $nCounter, __FILE__, __LINE__);
			}
		}

		/*
		 * DEBUGGING
		 */
		Schmolck_Tool_Debug::notice('Cars database has been updated with file ' . $strTempFile);
	}

	protected function _isUpToDate() {
		$strTempFile = $this->_getTempFile();
		if (file_exists($strTempFile)) {
			if ((time() - filemtime($strTempFile)) <= self::UPDATE_LIMIT) {
				return true;
			}
		}
	}

	protected function _getTempFile() {
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		return $objCore->getHelperCache()->getFilePath(md5(self::DATA_FILE) . '.csv');
	}

	static function extractName($arrRow) {
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

	static public function extractEz($arrRow) {
		switch ($arrRow["EZ"]) {
			case "0000-00-00":
				return "-";
				break;
			default:
				return (substr($arrRow["EZ"], 5, 2) . "/" . substr($arrRow["EZ"], 0, 4));
				break;
		}
	}

	static public function extractKm($arrRow) {
		return number_format($arrRow['KM'], 0, ',', ".");
	}

	static public function extractPrice($arrRow) {
		return number_format($arrRow["RP"], 0, "", ".");
	}

	static public function extractColor($arrRow) {
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

	static public function extractPolster($arrRow) {
		$arrRow["POLST"] = ucfirst(strtolower($arrRow["POLST"]));
		switch ($arrRow["FABT"]) {
			default:
				return $arrRow["POLST"];
				break;
			case "Mercedes-Benz":
				return $arrRow["POLSTC"] . " " . $arrRow["POLST"];
				break;
		}
	}

	static public function extractFirstImageUrl($arrRow) {
		return self::IMAGE_PATH . '/' . $arrRow['KNR'] . ',1.JPG';
	}

	static public function extractAusstattung($arrRow) {
		/*
		 * INITIALISATION
		 */
		$nCounter = 0;
		$arrAusstattung = array();

		/*
		 * EXTRACTION
		 */
		$arrSaust = explode("|", $arrRow["SAUST"]);
		$arrAustc = explode("|", $arrRow["AUSTC"]);

		/*
		 * PROCESSING
		 */
		switch ($arrRow["FABT"]) {
			default:
				foreach ($arrSaust as $strEntry) {
					$arrAusstattung[] = utf8_encode(trim($strEntry));
					$nCounter++;
				}
				break;
			case "Mercedes-Benz":
				foreach ($arrSaust as $strEntry) {
					if (!empty($arrAustc[$nCounter]) or !empty($strEntry)) {
						$arrAusstattung[] = $arrAustc[$nCounter] . ' ' . utf8_encode(trim($strEntry));
					}
					$nCounter++;
				}
				break;
		}
		sort($arrAusstattung);
		return $arrAusstattung;
	}

	/**
	 * Get all brands
	 * 
	 * @return array brands
	 */
	public function getBrands() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);

		/*
		 * DATA
		 */
		$strQuery = "
			SELECT 
				DISTINCT FABT 
			FROM 
				" . self::DB_TABLE . "
			WHERE
				TRUE
				AND FABT IS NOT NULL
				AND FABT <> 'null'
				AND FABT <> ''	
			ORDER BY 
				FABT
		";
		$resource = $objCore->getHelperDatabase()->query($strQuery);
		while ($arrRow = mysql_fetch_assoc($resource)) {
			$arrResult[] = strtolower($arrRow["FABT"]);
		}
		return $arrResult;
	}
	
	/**
	 * Get all images for one car
	 * 
	 * @return array images
	 */
	public function getImages($strId) {
		return array(
			self::IMAGE_PATH . '/' . $strId . ',1.JPG',
			self::IMAGE_PATH . '/' . $strId . ',2.JPG',
			self::IMAGE_PATH . '/' . $strId . ',3.JPG',
			self::IMAGE_PATH . '/' . $strId . ',4.JPG',
			self::IMAGE_PATH . '/' . $strId . ',5.JPG',
		);
	}	

	/**
	 * Get all distinc prices
	 * 
	 * @return array prices
	 */
	public function getPrices() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);

		/*
		 * DATA
		 */
		$strQuery = "
			SELECT 
				DISTINCT RP 
			FROM 
				" . self::DB_TABLE . "
			WHERE
				TRUE
				AND RP IS NOT NULL
				AND RP <> 'null'
				AND RP <> ''
			ORDER BY 
				RP ASC
		";
		$resource = $objCore->getHelperDatabase()->query($strQuery);
		while ($arrRow = mysql_fetch_assoc($resource)) {
			$arrResult[] = $arrRow["RP"];
		}
		return $arrResult;
	}
	
	/**
	 * Get all distinct km values
	 * 
	 * @return array km values
	 */
	public function getKms() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);

		/*
		 * DATA
		 */
		$strQuery = "
			SELECT 
				DISTINCT KM 
			FROM 
				" . self::DB_TABLE . "
			WHERE
				TRUE
				AND KM IS NOT NULL
				AND KM <> 'null'
				AND KM <> ''	
			ORDER BY 
				KM ASC
		";
		$resource = $objCore->getHelperDatabase()->query($strQuery);
		while ($arrRow = mysql_fetch_assoc($resource)) {
			$arrResult[] = $arrRow["KM"];
		}
		return $arrResult;
	}	

}