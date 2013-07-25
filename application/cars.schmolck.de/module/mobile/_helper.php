<?php

/**
 * Mobile_Helper
 * 
 * @package cars.schmolck.de
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Mobile_Helper extends Schmolck_Framework_Helper {

	// - old (perhaps obsolete very soon)
	const IMAGE_PATH = CARS_LOCATION_IMAGES;
	const DATA_FILE = CARS_LOCATION_SYNCFILE;
	const DB_TABLE = 'mod_cars';
	const UPDATE_LIMIT = 1800;
	// - new
	const DATABASE_TABLE = MOBILE_DATABASE_TABLE;	

	public function __construct(Schmolck_Framework_Core $objCore) {
		parent::__construct($objCore);

		/*
		 * IMPORT
		 */
		$objImportHelper = new Mobile_Import_Helper($objCore);
		$objImportHelper->updateFromZIP();
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
//		// - brand
//		switch ($this->getFilter('brand')) {
//			default:
//				if (trim($this->getFilter('brand')) != '') {
//					$strWhereBrand = "
//						AND FABT LIKE '{$this->getFilter('brand')}'
//					";
//				}
//				break;
//			case 'all':
//				$strWhereBrand = "
//					AND FABT LIKE '%'
//				";
//				break;
//			case 'others':
//				$strWhereBrand = "
//					AND FABT NOT LIKE 'Mercedes-Benz'
//					AND FABT NOT LIKE 'Smart'
//				";
//				break;
//		}
//		// - model
//		switch ($this->getFilter('model')) {
//			case 'all':
//				$strWhereModel = "
//					AND TYP LIKE '%'
//				";
//				break;
//			// - mercedes
//			case "a":
//				$strWhereModel = "
//					AND typ LIKE 'A %'
//				";
//				break;
//			case "b":
//				$strWhereModel = "
//					AND typ LIKE 'B %'
//				";
//				break;
//			case "c":
//				$strWhereModel = "
//					AND
//						( typ LIKE 'C %'
//						OR typ LIKE 'CL %'
//						)
//				";
//				break;
//			case "e":
//				$strWhereModel = "
//					AND typ LIKE 'E %'
//				";
//				break;
//			case "offroad":
//				$strWhereModel = "
//					AND
//						( typ LIKE 'M %'
//						OR typ LIKE 'ML %'
//						OR typ LIKE 'G %'
//						OR typ LIKE 'GL %'
//						OR typ LIKE 'GLK %'
//						)
//				";
//				break;
//			case "clk":
//				$strWhereModel = "
//					AND typ LIKE 'CLK %'
//				";
//				break;
//			case "slk":
//				$strWhereModel = "
//					AND typ LIKE 'SLK %'
//				";
//				break;
//			case "others-mercedes":
//				$strWhereModel = "
//					AND typ NOT LIKE 'A %'
//					AND typ NOT LIKE 'B %'
//					AND typ NOT LIKE 'C %'
//					AND typ NOT LIKE 'CL %'
//					AND typ NOT LIKE 'E %'
//					AND typ NOT LIKE 'CLK %'
//					AND typ NOT LIKE 'SLK %'
//					AND typ NOT LIKE 'M %'
//					AND typ NOT LIKE 'ML %'
//					AND typ NOT LIKE 'G %'
//					AND typ NOT LIKE 'GL %'
//					AND typ NOT LIKE 'GLK %'
//				";
//				break;
//			// - smart
//			case "f2":
//				$strWhereModel = "
//					AND typ LIKE '%FORTWO%'
//				";
//				break;
//			case "f4":
//				$strWhereModel = "
//					AND typ LIKE '%FORFOUR%'
//				";
//				break;
//			case "roadster":
//				$strWhereModel = "
//					AND typ LIKE '%ROADSTER%'
//				";
//				break;
//			case "others-smart":
//				$strWhereModel = "
//					AND typ NOT LIKE '%FORTWO%'
//					AND typ NOT LIKE '%FORFOUR%'
//					AND typ NOT LIKE '%ROADSTER%'
//				";
//				break;			
//		// - type
//		switch ($this->getFilter('type')) {
//			default:
//				if (trim($this->getFilter('type')) != '') {
//					$strWhereType = "
//						AND KAT LIKE '{$this->getFilter('type')}'
//					";
//				}
//				break;
//			case 'all':
//				$strWhereType = "
//					AND KAT LIKE '%'
//				";
//				break;
//		}
//		// - price
//		switch ($this->getFilter('price')) {
//			default:
//				if (trim($this->getFilter('price')) != '') {
//					$strWherePrice = "
//						AND RP <= {$this->getFilter('price')}
//						AND RP > 1
//					";
//				} else {
//					$strWherePrice = "
//						AND RP > 1
//					";
//				}
//				break;
//			case 'all':
//				$strWherePrice = "
//					AND RP > 1
//				";
//				break;
//		}
//		// - km
//		switch ($this->getFilter('km')) {
//			default:
//				if (trim($this->getFilter('km')) != '') {
//					$strWhereKm = "
//						AND KM <= '{$this->getFilter('km')}'
//					";
//				}
//				break;
//			case 'all':
//				continue;
//				break;
//		}	
//		// - ez
//		switch ($this->getFilter('ez')) {
//			default:
//				if (trim($this->getFilter('ez')) != '') {
//					$strWhereEz = "
//						AND EZ LIKE '{$this->getFilter('ez')}%'
//					";
//				}
//				break;
//			case 'all':
//				continue;
//				break;
//		}
		// - sorting
		switch ($this->getFilter('sorting')) {
			default:
			case 'price':
				$strSorting = "
					K_preis ASC
				";
				break;
			case 'km':
				$strSorting = "
					J_kilometer ASC
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
				" . self::DATABASE_TABLE . "
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
			$arrRow['NAME'] = $this->extractName($arrRow);
			$arrRow['EZ'] = $this->extractEz($arrRow);
			$arrRow['KM'] = $this->extractKm($arrRow);
			$arrRow['PREIS'] = $this->extractPrice($arrRow);
			$arrRow['COLOR'] = $arrRow['Q_farbe'];
			$arrRow['images'] = $this->getImages($arrRow['KNR']);
			$arrResult[] = $arrRow;
		}
		return $arrResult;
	}

	static function extractName($arrRow) {
		if (preg_match("/Mercedes/i", $arrRow['D_marke'])) {
			return 'Mercedes-Benz ' . $arrRow['E_modell'];
		}

		if (preg_match("/smart/i", $arrRow['D_marke'])) {
			return 'smart ' . $arrRow['E_modell'];
		}

		if (preg_match("/Volkswagen/i", $arrRow['D_marke'])) {
			return 'Volkswagen ' . $arrRow['E_modell'];
		}
		
		return $arrRow['D_marke'].' '.$arrRow['E_modell'];
	}

	static public function extractEz($arrRow) {
		return str_replace('.', '/', $arrRow["I_ez"]);
	}

	static public function extractKm($arrRow) {
		return number_format($arrRow['J_kilometer'], 0, ',', ".");
	}

	static public function extractPrice($arrRow) {
		return number_format($arrRow["K_preis"], 0, "", ".");
	}

	static public function extractColor($arrRow) {
		$arrRow["Q_farbe"] = strtolower($arrRow["Q_farbe"]);
		switch ($arrRow["Q_farbe"]) {
			default:
				return $arrRow["Q_farbe"];
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
				DISTINCT D_marke 
			FROM 
				" . self::DATABASE_TABLE . "
			WHERE
				TRUE
				AND D_marke IS NOT NULL
				AND D_marke <> 'null'
				AND D_marke <> ''	
			ORDER BY 
				D_marke
		";
		$resource = $objCore->getHelperDatabase()->query($strQuery);
		while ($arrRow = mysql_fetch_assoc($resource)) {
			$arrResult[] = strtolower($arrRow["D_marke"]);
		}
		return $arrResult;
	}
	
	/**
	 * Get all images for one car
	 * 
	 * @return array images
	 */
	public function getImages($strId) {		
		if (file_exists(self::IMAGE_PATH . '/' . $strId . ',1.JPG') || substr(self::IMAGE_PATH, 0, 4) == 'http') {
			return array(
				self::IMAGE_PATH . '/' . $strId . ',1.JPG',
				self::IMAGE_PATH . '/' . $strId . ',2.JPG',
				self::IMAGE_PATH . '/' . $strId . ',3.JPG',
				self::IMAGE_PATH . '/' . $strId . ',4.JPG',
				self::IMAGE_PATH . '/' . $strId . ',5.JPG',
			);
		} elseif (file_exists('data/cars/images/sync/dummy.jpg')) {
			return array(
				'data/cars/images/sync/dummy.jpg'
			);
		} else {
			return array(
				'data/cars/images/dummy.jpg'
			);
		}
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
				DISTINCT K_preis
			FROM 
				" . self::DATABASE_TABLE . "
			WHERE
				TRUE
				AND K_preis IS NOT NULL
				AND K_preis <> 'null'
				AND K_preis <> ''
			ORDER BY 
				K_preis ASC
		";
		$resource = $objCore->getHelperDatabase()->query($strQuery);
		while ($arrRow = mysql_fetch_assoc($resource)) {
			$arrResult[] = $arrRow["K_preis"];
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

/**
 * Mobile_Import_Helper
 * 
 * @package cars.schmolck.de
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Mobile_Import_Helper extends Schmolck_Framework_Helper {

	const ZIP_FILE = MOBILE_ZIP_FILE;
	const ZIP_IMAGES_PATH = MOBILE_ZIP_IMAGES_PATH;
	const CSV_FILE_NAME = MOBILE_CSV_FILE_NAME;
	const CSV_DELIMITER = MOBILE_CSV_DELIMITER;
	const CSV_ENCLOSURE = MOBILE_CSV_ENCLOSURE;
	const DATABASE_FILE = MOBILE_DATABASE_FILE;
	const DATABASE_TABLE = MOBILE_DATABASE_TABLE;
	
	public function __construct(Schmolck_Framework_Core $objCore) {
		parent::__construct($objCore);

		$this->updateFromZIP();
	}	
	
	/**
	 * Update database table and images from ZIP file
	 */
	public function updateFromZIP() {
		/*
		 * CHECK 
		 */
		// - nothing to do if no ZIP file found
		if (!$this->_checkIfExists()) {
			return;
		}

		/*
		 * PROCESSING
		 */
		// - unpack uploaded ZIP file
		$this->_unpackZIPFile();
		// - move car images to proper location
		$this->_moveUnpackedImages();
//		// - split CSV file into separate files
//		$this->_splitUnpackedCSV();
		// - import data into database tables
		$this->_importUnpackedCSV();
		
		/*
		 * DEBUGGING
		 */
		Schmolck_Tool_Debug::notice('Mobile database has been updated with file: ' . self::DATABASE_TABLE);
		
	}
	
	/**
	 * Check if ZIP file exists
	 * 
	 * @return boolean
	 */
	protected function _checkIfExists() {
		return file_exists(self::ZIP_FILE);
	}
	
	/**
	 * Unpack ZIP file
	 */
	protected function _unpackZIPFile() {
		/*
		 * UNZIPPING
		 */
		$objFile = new Schmolck_Tool_File_Zip();
		$objFile->file = self::ZIP_FILE;
		$objFile->unzip();
		
		/*
		 * CLEANING
		 */
		// - rename ZIP file
		if (APPLICATION_ENVIRONMENT != 'development') {
			rename(self::ZIP_FILE, self::ZIP_FILE.'.bak');
		}
	}	
	
	/**
	 * Move unpacked car images to proper location
	 * 
	 * @throws Exception
	 */
	protected function _moveUnpackedImages() {		
		/*
		 * PREPARATION
		 */
		$strSourceDir = dirname(self::ZIP_FILE);
		$strDestinationDir = self::ZIP_IMAGES_PATH;
				
		/*
		 * PROCESSING
		 */
		// - get array of all source files
		$arrFiles = scandir($strSourceDir);
		// - cycle through all source files
		foreach ($arrFiles as $strFile) {
			// - do not handle dirs
			if (in_array($strFile, array(".",".."))) continue;
			// - do not handle other files than *.JPG and *.jpg
			if (!preg_match('/\.JPG$/i', $strFile)) continue;
			// - if we copied this successfully, mark it for deletion
			if (copy($strSourceDir.'/'.$strFile, $strDestinationDir.'/'.$strFile)) {
				$arrDelete[] = $strSourceDir.'/'.$strFile;
			} else {
				throw new Exception('Could not move extracted car image to proper location');
			}
		}
		
		/*
		 * CLEANING
		 */
		// - delete all successfully-copied files
		foreach ($arrDelete as $strFile) {
			if (!unlink($strFile)) {
				throw new Exception('Could not delete extracted car image after moving to proper location');
			}			
		}		
	}
	
//	protected function _splitUnpackedCSV() {
//		/*
//		 * PREPARATION
//		 */
//		$strSourceDir = dirname(self::ZIP_FILE);
//		
//		/*
//		 * SCANNING
//		 */
//		// - get array of all source files
//		$arrFiles = scandir($strSourceDir);
//		// - cycle through all source files
//		foreach ($arrFiles as $strFile) {
//			// - do not handle dirs
//			if (in_array($strFile, array(".",".."))) continue;
//			// - if we find a CSV file we take it and proceed
//			if (preg_match('/\.CSV$/i', $strFile)) {
//				$arrCSV[] = $strFile;
//			}
//		}		
//		
//		/*
//		 * CHECK
//		 */
//		if (count($arrCSV) < 1) {
//			throw new Exception('No CSV file found');
//		}
//		
//		/*
//		 * SPLITTING
//		 */
//		$strPath = $strSourceDir;
//		$strFile = self::CSV_FILE_NAME;
//
//		// - read CSV file
//		if (($resHandler = fopen($strPath.'/'.$strFile, "r")) !== FALSE) {
//			while (($strLine = fgets($resHandler)) !== FALSE) {
//				// - explode into value array
//				$arrValues = explode(self::CSV_DELIMITER, $strLine);
//				
//				// - determine car id
//				$strCarId = $arrValues[1];
//								
//				// - determine first parameters
//				$nLengthPosition1 = 0;
//				$nStartPosition1 = $nLengthPosition1 + 1;
//				$nLength1 = intval($this->_getEnclosureFreeCSVValue($arrValues[$nLengthPosition1]));
//
//				// - determine second parameters
//				$nLengthPosition2 = $nStartPosition1 + $nLength1;
//				$nStartPosition2 = $nLengthPosition2 + 1;				
//				$nLength2 = intval($this->_getEnclosureFreeCSVValue($arrValues[$nLengthPosition2]));
//				
//				// - determine third parameters
//				$nLengthPosition3 = $nLengthPosition2 + 1 + $nLength2;
//				$nStartPosition3 = $nLengthPosition3 + 1;
//				$nLength3 = intval($this->_getEnclosureFreeCSVValue($arrValues[$nLengthPosition3]));
//
//				// - calculate value arrays
//				$arrValues1 = array_slice($arrValues, $nStartPosition1, $nLength1);
//				$arrValues2 = array_merge(array($strCarId), array_slice($arrValues, $nStartPosition2, $nLength2));
//				$arrValues3 = array_merge(array($strCarId), array_slice($arrValues, $nStartPosition3, $nLength3));
//				
//				// - write to separate database import files
//				file_put_contents(self::DATABASE_IMPORT_FILE1, implode(self::CSV_DELIMITER, $arrValues1));
//				file_put_contents(self::DATABASE_IMPORT_FILE2, implode(self::CSV_DELIMITER, $arrValues2));
//				file_put_contents(self::DATABASE_IMPORT_FILE3, implode(self::CSV_DELIMITER, $arrValues3));
//			}
//			fclose($resHandler);
//			
//			// - remove source CSV file
//			unlink($strPath.'/'.$strFile);
//		}	
//	}
	
	/*
	 * Import data into database tables
	 */
	protected function _importUnpackedCSV() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		
		/*
		 * QUERY
		 */
		$strQuery = "
			LOAD DATA LOCAL INFILE '".self::DATABASE_FILE."'
			REPLACE
			INTO TABLE `".self::DATABASE_TABLE."`
			FIELDS TERMINATED BY '".self::CSV_DELIMITER."'
			OPTIONALLY ENCLOSED BY '\"'
			LINES TERMINATED BY '\n'
		";
		$objCore->getHelperDatabase()->query($strQuery);
				
		/*
		 * CLEANING
		 */
		if (APPLICATION_ENVIRONMENT != 'development') {
			rename(self::DATABASE_FILE, self::DATABASE_FILE.'.bak');
		}
	}
	
	/**
	 * Get CSV value without defined enclosure strings
	 * 
	 * @param string $strValue
	 * @return string cleaned string
	 */
	protected function _getEnclosureFreeCSVValue($strValue) {
		/*
		 * PROCESSING
		 */
		// - if string longer than 2 characters
		if (mb_strlen($strValue) > 2) {
			// - remove first and last enclosure
			$strValue1 = ltrim($strValue, self::CSV_ENCLOSURE);
			$strValue2 = rtrim($strValue1, self::CSV_ENCLOSURE);
		}
		
		/*
		 * RETURN
		 */
		return $strValue2;
	}	
}