<?php

/**
 * Cars_Helper
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
class Cars_Helper extends Schmolck_Framework_Helper {

	const IMAGE_PATH = 'http://www.schmolck.de/data/public/images/vehicles';
	const DATA_FILE = 'http://www.schmolck.de/data/private/vehicles/IFZ.csv';
	const DB_TABLE = 'mod_cars';
	const UPDATE_LIMIT = 1800;

	public function __construct(Schmolck_Framework_Core $objCore) {
		parent::__construct($objCore);

		$this->updateFromCSV();
	}

	/**
	 * Set car filter value
	 * 
	 * @param type $strName
	 * @param type $strValue
	 */
	public function setFilter($strName, $strValue) {
		$arrFilter = $this->restore('filter');
		$arrFilter[$strName] = mysql_real_escape_string($strValue);
		$this->store('filter', $arrFilter);
	}

	/**
	 * Get car filter value
	 * 
	 * @param string $strName
	 * @return mixed
	 */
	public function getFilter($strName) {
		$arrFilter = $this->restore('filter');
		Schmolck_Tool_Debug::debug(print_r($arrFilter, true));		
		return $arrFilter[$strName];
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
		switch ($this->getFilter('brand')) {
			default:
				if (trim($this->getFilter('brand')) != '') {
					$strWhereBrand = "
						AND FABT LIKE '{$this->getFilter('brand')}'
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
				";
				break;
		}
		// - model
		switch ($this->getFilter('model')) {
			case 'all':
				$strWhereModel = "
					AND TYP LIKE '%'
				";
				break;
			// - mercedes
			case "a":
				$strWhereModel = "
					AND typ LIKE 'A %'
				";
				break;
			case "b":
				$strWhereModel = "
					AND typ LIKE 'B %'
				";
				break;
			case "c":
				$strWhereModel = "
					AND
						( typ LIKE 'C %'
						OR typ LIKE 'CL %'
						)
				";
				break;
			case "e":
				$strWhereModel = "
					AND typ LIKE 'E %'
				";
				break;
			case "offroad":
				$strWhereModel = "
					AND
						( typ LIKE 'M %'
						OR typ LIKE 'ML %'
						OR typ LIKE 'G %'
						OR typ LIKE 'GL %'
						OR typ LIKE 'GLK %'
						)
				";
				break;
			case "clk":
				$strWhereModel = "
					AND typ LIKE 'CLK %'
				";
				break;
			case "slk":
				$strWhereModel = "
					AND typ LIKE 'SLK %'
				";
				break;
			case "others-mercedes":
				$strWhereModel = "
					AND typ NOT LIKE 'A %'
					AND typ NOT LIKE 'B %'
					AND typ NOT LIKE 'C %'
					AND typ NOT LIKE 'CL %'
					AND typ NOT LIKE 'E %'
					AND typ NOT LIKE 'CLK %'
					AND typ NOT LIKE 'SLK %'
					AND typ NOT LIKE 'M %'
					AND typ NOT LIKE 'ML %'
					AND typ NOT LIKE 'G %'
					AND typ NOT LIKE 'GL %'
					AND typ NOT LIKE 'GLK %'
				";
				break;
			// - smart
			case "f2":
				$strWhereModel = "
					AND typ LIKE '%FORTWO%'
				";
				break;
			case "f4":
				$strWhereModel = "
					AND typ LIKE '%FORFOUR%'
				";
				break;
			case "roadster":
				$strWhereModel = "
					AND typ LIKE '%ROADSTER%'
				";
				break;
			case "others-smart":
				$strWhereModel = "
					AND typ NOT LIKE '%FORTWO%'
					AND typ NOT LIKE '%FORFOUR%'
					AND typ NOT LIKE '%ROADSTER%'
				";
				break;			
			
			
			
			
			
			
			
			
			
			
			
			
//			default:
//				if (trim($this->getFilter('model')) != '') {
//					$strWhereModel = "
//						AND TYP LIKE '{$this->getFilter('model')} %'
//					";
//				}
//				break;
//			case 'all':
//				$strWhereModel = "
//					AND TYP LIKE '%'
//				";
//				break;
//			case 'others':
//				$strWhereModel = "
//					AND TYP NOT LIKE 'Mercedes-Benz'
//					AND TYP NOT LIKE 'Smart'
//				";
//				break;
		}		
		// - type
		switch ($this->getFilter('type')) {
			default:
				if (trim($this->getFilter('type')) != '') {
					$strWhereType = "
						AND KAT LIKE '{$this->getFilter('type')}'
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
		switch ($this->getFilter('price')) {
			default:
				if (trim($this->getFilter('price')) != '') {
					$strWherePrice = "
						AND RP <= {$this->getFilter('price')}
					";
				}
				break;
			case 'all':
				continue;
				break;
		}
		// - km
		switch ($this->getFilter('km')) {
			default:
				if (trim($this->getFilter('km')) != '') {
					$strWhereKm = "
						AND KM <= '{$this->getFilter('km')}'
					";
				}
				break;
			case 'all':
				continue;
				break;
		}	
		// - ez
		switch ($this->getFilter('ez')) {
			default:
				if (trim($this->getFilter('ez')) != '') {
					$strWhereEz = "
						AND EZ LIKE '{$this->getFilter('ez')}%'
					";
				}
				break;
			case 'all':
				continue;
				break;
		}
		// - sorting
		switch ($this->getFilter('sorting')) {
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
				$strWhereModel
				$strWhereType
				$strWhereKm
				$strWhereEz
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
	
	/**
	 * Get all distinct ez values
	 * 
	 * @return array ez values
	 */
	public function getEzs() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);

		/*
		 * DATA
		 */
		$strQuery = "
			SELECT 
				DISTINCT EZ 
			FROM 
				" . self::DB_TABLE . "
			WHERE
				TRUE
				AND EZ IS NOT NULL
				AND EZ <> 'null'
				AND EZ <> ''	
			ORDER BY 
				EZ ASC
		";
		$resource = $objCore->getHelperDatabase()->query($strQuery);
		while ($arrRow = mysql_fetch_assoc($resource)) {
			$arrResult[] = $arrRow["EZ"];
		}
		return $arrResult;
	}

}