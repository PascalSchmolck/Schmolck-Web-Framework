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
	const IMAGES_PATH = MOBILE_IMAGES_PATH;	

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
		// - brand
		switch ($this->getFilter('brand')) {
			default:
				if (trim($this->getFilter('brand')) != '') {
					$strWhereBrand = "
						AND D_marke COLLATE UTF8_GENERAL_CI LIKE '{$this->getFilter('brand')}'
					";
				}
				break;
			case 'all':
				$strWhereBrand = "
					AND D_marke COLLATE UTF8_GENERAL_CI LIKE '%'
				";
				break;
			case 'others':
				$strWhereBrand = "
					AND D_marke COLLATE UTF8_GENERAL_CI NOT LIKE 'Mercedes-Benz'
					AND D_marke COLLATE UTF8_GENERAL_CI NOT LIKE 'Smart'
				";
				break;
		}
		// - model
		switch ($this->getFilter('model')) {
			case 'all':
				$strWhereModel = "
					AND E_modell LIKE '%'
				";
				break;
			// - mercedes
			case "a":
				$strWhereModel = "
					AND E_modell LIKE 'A %'
				";
				break;
			case "b":
				$strWhereModel = "
					AND E_modell LIKE 'B %'
				";
				break;
			case "c":
				$strWhereModel = "
					AND
						( E_modell LIKE 'C %'
						OR E_modell LIKE 'CL %'
						)
				";
				break;
			case "e":
				$strWhereModel = "
					AND E_modell LIKE 'E %'
				";
				break;
			case "offroad":
				$strWhereModel = "
					AND
						( E_modell LIKE 'M %'
						OR E_modell LIKE 'ML %'
						OR E_modell LIKE 'G %'
						OR E_modell LIKE 'GL %'
						OR E_modell LIKE 'GLK %'
						)
				";
				break;
			case "clk":
				$strWhereModel = "
					AND E_modell LIKE 'CLK %'
				";
				break;
			case "slk":
				$strWhereModel = "
					AND E_modell LIKE 'SLK %'
				";
				break;
			case "others-mercedes":
				$strWhereModel = "
					AND E_modell NOT LIKE 'A %'
					AND E_modell NOT LIKE 'B %'
					AND E_modell NOT LIKE 'C %'
					AND E_modell NOT LIKE 'CL %'
					AND E_modell NOT LIKE 'E %'
					AND E_modell NOT LIKE 'CLK %'
					AND E_modell NOT LIKE 'SLK %'
					AND E_modell NOT LIKE 'M %'
					AND E_modell NOT LIKE 'ML %'
					AND E_modell NOT LIKE 'G %'
					AND E_modell NOT LIKE 'GL %'
					AND E_modell NOT LIKE 'GLK %'
				";
				break;
			// - smart
			case "f2":
				$strWhereModel = "
					AND E_modell LIKE '%FORTWO%'
				";
				break;
			case "f4":
				$strWhereModel = "
					AND E_modell LIKE '%FORFOUR%'
				";
				break;
			case "roadster":
				$strWhereModel = "
					AND E_modell LIKE '%ROADSTER%'
				";
				break;
			case "others-smart":
				$strWhereModel = "
					AND E_modell NOT LIKE '%FORTWO%'
					AND E_modell NOT LIKE '%FORFOUR%'
					AND E_modell NOT LIKE '%ROADSTER%'
				";
				break;	
		}
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
		// - price
		switch ($this->getFilter('price')) {
			default:
				if (trim($this->getFilter('price')) != '') {
					$strWherePrice = "
						AND K_preis <= {$this->getFilter('price')}
						AND K_preis > 1
					";
				} else {
					$strWherePrice = "
						AND K_preis > 1
					";
				}
				break;
			case 'all':
				$strWherePrice = "
					AND K_preis > 1
				";
				break;
		}
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
			$arrResult[] = $this->_getMappedRow($arrRow);
		}
		
		/*
		 * RETURN
		 */
		return $arrResult;
	}
	
	public function querySingleCar($strId) {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		
		/*
		 * PREPARATION
		 */
		$strId = mysql_real_escape_string($strId);
		
		/*
		 * QUERY
		 */
		$strQuery = "
			SELECT 
				* 
			FROM 
				".self::DATABASE_TABLE." 
			WHERE 
				A_satz_nummer='{$strId}' 
			LIMIT 1
		";
		$resource = $objCore->getHelperDatabase()->query($strQuery);
		while ($arrRow = mysql_fetch_assoc($resource)) {
			$arrResult[] = $this->_getMappedRow($arrRow);
		}		
		
		/*
		 * RETURN
		 */
		return $arrResult;
	}
	
	/**
	 * Get mapped database query result row
	 * 
	 * @param array $arrRow database query row
	 * @return array with mapped values
	 */
	protected function _getMappedRow($arrRow) {
		$arrMap['id'] = $arrRow['A_satz_nummer'];
		$arrMap['name'] = $this->_getMappedRowName($arrRow['D_marke'], $arrRow['E_modell']);
		$arrMap['ez'] = $this->_getMappedRowEz($arrRow);
		$arrMap['km'] = $this->_getMappedRowKm($arrRow);
		$arrMap['kw'] = $arrRow['F_leistung'];
		$arrMap['preis'] = $this->_getMappedRowPrice($arrRow['K_preis']);
		$arrMap['mwst'] = $arrRow['L_mwst'];
		$arrMap['color'] = $arrRow['Q_farbe'];
		$arrMap['images'] = $this->getImages($arrMap['id']);
		$arrMap['bemerkung'] = $this->_getMappedRowBemerkungen(utf8_encode($arrRow['Z_bemerkung']));
		return $arrMap;
	}

	protected function _getMappedRowName($strMarke, $strModell) {
		if (preg_match("/Mercedes/i", $strMarke)) {
			return 'Mercedes-Benz ' . $strModell;
		}

		if (preg_match("/smart/i", $strMarke)) {
			return 'smart ' . $strModell;
		}

		if (preg_match("/Volkswagen/i", $strMarke)) {
			return 'Volkswagen ' . $strModell;
		}
		
		return $strMarke.' '.$strModell;
	}

	protected function _getMappedRowEz($arrRow) {
		return str_replace('.', '/', $arrRow["I_ez"]);
	}

	protected function _getMappedRowKm($arrRow) {
		return number_format($arrRow['J_kilometer'], 0, ',', ".");
	}

	protected function _getMappedRowPrice($strPrice) {
		return number_format($strPrice, 0, "", ".");
	}
	
	protected function _getMappedRowBemerkungen($strNotes) {
		$arrReplace = array(
			'\\'	=> '<br>', 
		);
		return str_replace(array_keys($arrReplace), array_values($arrReplace), $strNotes);
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
		if (file_exists(self::IMAGES_PATH . '/' . $strId . '_1.JPG') || substr(self::IMAGE_PATH, 0, 4) == 'http') {
			return array(
				self::IMAGES_PATH . '/' . $strId . '_1.JPG',
				self::IMAGES_PATH . '/' . $strId . '_2.JPG',
				self::IMAGES_PATH . '/' . $strId . '_3.JPG',
				self::IMAGES_PATH . '/' . $strId . '_4.JPG',
				self::IMAGES_PATH . '/' . $strId . '_5.JPG',
			);
		} elseif (file_exists('data/mobile/images/sync/dummy.jpg')) {
			return array(
				'data/mobile/images/sync/dummy.jpg'
			);
		} else {
			return array(
				'data/mobile/images/dummy.jpg'
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
	const IMAGES_PATH = MOBILE_IMAGES_PATH;
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
		$strDestinationDir = self::IMAGES_PATH;
				
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