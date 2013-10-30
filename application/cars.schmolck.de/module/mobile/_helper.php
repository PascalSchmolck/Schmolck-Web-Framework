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
	const PRICE_MWST = MOBILE_PRICE_MWST;
	const ZIP_BACKUP = MOBILE_ZIP_BACKUP;

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
	 * Query cars according to set-up filters
	 * 
	 * @return array cars
	 */
	public function queryCarsFiltered() {
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
		// - type
		switch ($this->getFilter('transmission')) {
			default:
				if (trim($this->getFilter('transmission')) != '') {
					$strWhereTransmission = "
						AND DG_getriebeart LIKE '{$this->getFilter('transmission')}'
					";
				}
				break;
			case 'all':
				$strWhereTransmission = "
					AND DG_getriebeart LIKE '%'
				";
				break;
		}
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
				$strWhereTransmission
				$strWherePrice
			ORDER BY
				$strSorting
		";	
		
		/*
		 * CACHE
		 */	
		if ($this->_getCache($this->_getUpdateHash($strQuery)) == null) {

			$resource = $objCore->getHelperDatabase()->query($strQuery);
			while ($arrRow = mysql_fetch_assoc($resource)) {
				$arrResult[] = $this->_getMappedRow($arrRow);
			}

			$this->_setCache($this->_getUpdateHash($strQuery), $arrResult);
		} else {
			$arrResult = $this->_getCache($this->_getUpdateHash($strQuery));
		}
		return $arrResult;
	}
	
	/**
	 * Query single car according to given id
	 * 
	 * @param string $strId
	 * @return array with one single car entry
	 */
	public function queryCarsSingle($strId) {
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
		$arrMap['name'] = $this->_getMappedRowName($arrRow['D_marke'], utf8_encode($arrRow['E_modell']));
		$arrMap['kategorie'] = $arrRow['C_kategorie'];
		$arrMap['fahrzeug'] = $this->_getMappedRowFahrzeug($arrRow['V_neufahrzeug']);
		$arrMap['ez'] = $this->_getMappedRowEz($arrRow);
		$arrMap['km'] = $this->_getMappedRowKm($arrRow);
		$arrMap['kraftstoff'] = $this->_getMappedRowKraftstoff($arrRow['DF_kraftstoffart']);
		$arrMap['kw'] = $arrRow['F_leistung'];
		$arrMap['ps'] = $this->_getMappedRowPs($arrRow);
		$arrMap['getriebe'] = $this->_getMappedRowGetriebe($arrRow['DG_getriebeart']);
		$arrMap['ccm'] = $arrRow['BA_ccm'];
		$arrMap['preis'] = $this->_getMappedRowPrice($arrRow);
		$arrMap['mwst'] = $arrRow['L_mwst'];
		$arrMap['color'] = $arrRow['Q_farbe'];
		$arrMap['images'] = $this->getImages($arrMap['id']);
		$arrMap['bemerkung'] = $this->_getMappedRowBemerkung(utf8_encode($arrRow['Z_bemerkung']));
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
	
	protected function _getMappedRowFahrzeug($strValue) {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		
		/*
		 * PROCESSING
		 */
		switch ($strValue) {
			case '0':
				$strLabel = $objCore->getHelperTranslator()->_("Used Car");
				break;
			case '1':
				$strLabel = $objCore->getHelperTranslator()->_("Brand New Car");
				break;
		}
		
		/*
		 * OUTPUT
		 */
		return $strLabel;
	}	

	protected function _getMappedRowEz($arrRow) {
		return str_replace('.', '/', $arrRow["I_ez"]);
	}

	protected function _getMappedRowKm($arrRow) {
		return number_format($arrRow['J_kilometer'], 0, ',', ".");
	}
	
	protected function _getMappedRowKraftstoff($strValue) {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		
		/*
		 * PROCESSING
		 */
		switch ($strValue) {
			default:
				// - empty
				break;
			case '1':
				$strLabel = $objCore->getHelperTranslator()->_("Petrol");
				break;
			case '2':
				$strLabel = $objCore->getHelperTranslator()->_("Diesel");
				break;
			case '3':
				$strLabel = $objCore->getHelperTranslator()->_("LPG");
				break;
			case '4':
				$strLabel = $objCore->getHelperTranslator()->_("Natural Gas");
				break;
			case '5':
				// - empty
				break;
			case '6':
				$strLabel = $objCore->getHelperTranslator()->_("Electric");
				break;
			case '7':
				$strLabel = $objCore->getHelperTranslator()->_("Hybrid");
				break;
			case '8':
				$strLabel = $objCore->getHelperTranslator()->_("Hydrogen");
				break;
			case '9':
				$strLabel = $objCore->getHelperTranslator()->_("Ethanol");
				break;
		}
		
		/*
		 * OUTPUT
		 */
		return $strLabel;
	}
	
	protected function _getMappedRowGetriebe($strValue) {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		
		/*
		 * PROCESSING
		 */
		switch ($strValue) {
			default:
				// - empty
				break;
			case '1':
				$strLabel = $objCore->getHelperTranslator()->_("Manual");
				break;
			case '2':
				$strLabel = $objCore->getHelperTranslator()->_("Semi-Automatic");
				break;
			case '3':
				$strLabel = $objCore->getHelperTranslator()->_("Automatic");
				break;
		}
		
		/*
		 * OUTPUT
		 */
		return $strLabel;
	}	
	
	/**
	 * Get mapped price according to MwSt. flag
	 * 
	 * @param array $arrRow
	 * @return number
	 */
	protected function _getMappedRowPrice($arrRow) {
		if ($arrRow['L_mwst'] == 0) {
			$nPrice = ceil($arrRow['K_preis'] * (1 + self::PRICE_MWST/100));
			$nPrice = intval($nPrice / 100);
			$nPrice = $nPrice * 100;	
		} else {
			$nPrice = intval($arrRow['K_preis']);
		}
		return number_format($nPrice, 0, "", ".");
	}
	
	/**
	 * Get mapped PS according to KW
	 * 
	 * @param array $arrRow
	 * @return int ps
	 */
	protected function _getMappedRowPs($arrRow) {
		$nPs = $arrRow['F_leistung'] * 1.36 ;
		return number_format($nPs, 0, "", ".");
	}	
	
	protected function _getMappedRowBemerkung($strNotes) {
		/*
		 * PREPARATION
		 */
		// - split into array according to "\" separations
		$arrLines = explode("\\", $strNotes);
		$bLastList = false;
		$bCurrentList = false;
		
		/*
		 * PROCESSING
		 */
		// - line by line
		foreach ($arrLines as &$strLine) {
			// **TEXT** => <strong>TEXT</strong>
			$strLine = preg_replace('/\*\*([^\*\*]+)\*\*/i', '<strong>$1</strong>', $strLine);			
			
			// * TEXT => <li>TEXT</li>
			if (substr($strLine, 0, 1) == '*') {
				$strLine = preg_replace('/(\*)(.+)/i', '<li>$2</li>', $strLine);			

				$bLastList = $bCurrentList;
				$bCurrentList = true;
			} else {
				$bLastList = $bCurrentList;
				$bCurrentList = false;
			}
			
			/*
			 * CHECK
			 */
			// - open listing if required
			if ($bCurrentList && !$bLastList) {
				$strLine = '<ul>' . $strLine;
			}			
			// - close listing if required
			if (!$bCurrentList && $bLastList) {
				$strLine = '</ul>' . $strLine;
			}
		}
		

		
		/*
		 * OUTPUT
		 */
		// - merge into string again
		return implode('<br>', $arrLines);
	}	
	
	/**
	 * Get all available images for one car with given id
	 * 
	 * @param string $strId car id
	 * @return array of images
	 */
	public function getImages($strId) {	
		/*
		 * PREPARATION
		 */
		$strPath = self::IMAGES_PATH;
				
		/*
		 * PROCESSING
		 */
		// - get array of all corresponding image files
		$arrFiles = scandir($strPath);
		// - cycle through all source files
		foreach ($arrFiles as $strFile) {
			// - do not handle dirs
			if (in_array($strFile, array(".",".."))) continue;
			// - do only collect files that match to "id_*.jpg"; e.g. "30080011_5.JPG"
			if (!preg_match('/^'.$strId.'_[0-9]+\.JPG$/i', $strFile)) continue;
			// - collect
			$arrResult[] = $strPath.'/'.$strFile;
		}
		
		/*
		 * CHECK
		 */
		// - return dummy if no image file found
		if (count($arrResult) == 0) {
			return array(
				'data/mobile/images/dummy.jpg'
			);
		}
		
		/*
		 * RETURN
		 */
		return $arrResult;
	}	

	/**
	 * Get all distinc prices for filtering
	 * 
	 * @return array prices
	 */
	public function getFilterPrices() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		$arrResult = array();

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
				AND K_preis > 1
			ORDER BY 
				K_preis ASC
		";
		
		/*
		 * CACHE
		 */
		if ($this->_getCache($this->_getUpdateHash($strQuery)) == null) {
		
			$resource = $objCore->getHelperDatabase()->query($strQuery);
			while ($arrRow = mysql_fetch_assoc($resource)) {
				$arrResult[] = $arrRow["K_preis"];
			}
			$this->_setCache($this->_getUpdateHash($strQuery), $arrResult);
			
		} else {
			$arrResult = $this->_getCache($this->_getUpdateHash($strQuery));
		}
		return $arrResult;		
	}
	
/**
	 * Get all distinc transmissions for filtering
	 * 
	 * @return array transmissions
	 */
	public function getFilterTransmissions() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		$arrResult = array();

		/*
		 * DATA
		 */
		$strQuery = "
			SELECT 
				DISTINCT DG_getriebeart
			FROM 
				" . self::DATABASE_TABLE . "
			WHERE
				TRUE
				AND DG_getriebeart IS NOT NULL
			ORDER BY 
				DG_getriebeart ASC
		";
		
		/*
		 * CACHE
		 */
		if ($this->_getCache($this->_getUpdateHash($strQuery)) == null) {
		
			$resource = $objCore->getHelperDatabase()->query($strQuery);
			while ($arrRow = mysql_fetch_assoc($resource)) {
				$arrResult[] = $arrRow["DG_getriebeart"];
			}
			$this->_setCache($this->_getUpdateHash($strQuery), $arrResult);
			
		} else {
			$arrResult = $this->_getCache($this->_getUpdateHash($strQuery));
		}
		return $arrResult;		
	}	
	
	/**
	 * Get cache update hash according to key
	 * 
	 * @param string $strString key
	 * @return string hash
	 */
	protected function _getUpdateHash($strString) {
		if (file_exists(self::ZIP_BACKUP)) {
			$strUpdateDate = filectime(self::ZIP_BACKUP);
		}
		return md5($strString.date('Y.m.d-H.i').$strUpdateDate);	
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
	const ZIP_BACKUP = MOBILE_ZIP_BACKUP;
	const IMAGES_PATH = MOBILE_IMAGES_PATH;
	const CSV_FILE_NAME = MOBILE_CSV_FILE_NAME;
	const CSV_DELIMITER = MOBILE_CSV_DELIMITER;
	const CSV_ENCLOSURE = MOBILE_CSV_ENCLOSURE;
	const CSV_LIMITS = MOBILE_CSV_LIMITS;
	const DATABASE_FILE = MOBILE_DATABASE_FILE;
	const DATABASE_TABLE = MOBILE_DATABASE_TABLE;
	
	protected $_arrNewsImages;
	protected $_bImportSuccess;
	
	/**
	 * Update database table and images from ZIP file
	 */
	public function updateFromZip() {
		/*
		 * CHECK 
		 */
		// - nothing to do if no ZIP file found
		if (!$this->_checkIfExists()) {
			return;
		}
		// - prevent duplicate processing
		if ($this->restore('processing') == true) {
			//return;
		}

		/*
		 * PROCESSING
		 */
		// - set processing flag
		$this->store('processing', true);
		// - remove existing images
		$this->_updateFromZipImages();		
		// - unpack uploaded ZIP file
		$this->_updateFromZipUnpack();
		// - import data into database tables
		$this->_updateFromZipCsv();
		// - cleanup
		$this->_updateFromZipCleaning();
		// - unset processing flag
		$this->store('processing', false);

		/*
		 * DEBUGGING
		 */
		Schmolck_Tool_Debug::notice('Mobile database has been updated with file: ' . self::ZIP_FILE);
	}
	
	/*
	 * Clean up after import process
	 */
	protected function _updateFromZipCleaning() {
		/*
		 * CLEANING
		 */
		// - database import file
		unlink(self::DATABASE_FILE);
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
	protected function _updateFromZipUnpack() {
		$objFile = new Schmolck_Tool_File_Zip();
		$objFile->file = self::ZIP_FILE;
		$objFile->unzip();
		
		/*
		 * CLEANING & PREVENTION
		 */
		rename(self::ZIP_FILE, self::ZIP_BACKUP);
	}	
	
	/**
	 * Remove all images
	 * 
	 * @throws Exception
	 */
	protected function _updateFromZipImages() {		
		/*
		 * PREPARATION
		 */
		$strDir = dirname(self::ZIP_FILE);
	
		/*
		 * PROCESSING
		 */
		// - get array of all source files
		$arrFiles = scandir($strDir);
		// - cycle through all source files
		foreach ($arrFiles as $strFile) {
			// - do not handle dirs
			if (in_array($strFile, array(".",".."))) continue;
			// - do not handle other files than *.JPG and *.jpg
			if (preg_match('/\.JPG$/i', $strFile)) {
				unlink($strDir.'/'.$strFile);
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
//				$nLength1 = intval($this->_getEnclosureFreeValue($arrValues[$nLengthPosition1]));
//
//				// - determine second parameters
//				$nLengthPosition2 = $nStartPosition1 + $nLength1;
//				$nStartPosition2 = $nLengthPosition2 + 1;				
//				$nLength2 = intval($this->_getEnclosureFreeValue($arrValues[$nLengthPosition2]));
//				
//				// - determine third parameters
//				$nLengthPosition3 = $nLengthPosition2 + 1 + $nLength2;
//				$nStartPosition3 = $nLengthPosition3 + 1;
//				$nLength3 = intval($this->_getEnclosureFreeValue($arrValues[$nLengthPosition3]));
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
	 * 
	 * @throws Exception if CSV file does not fit to the configured limit parameters
	 */
	protected function _updateFromZipCsv() {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		
		/*
		 * PREPARATION
		 */
		// - determine columns
		$nColumns = mysql_num_rows($objCore->getHelperDatabase()->query("SHOW COLUMNS FROM " . self::DATABASE_TABLE));		
		
		/*
		 * CHECK
		 */
		// - check csv length parameters
		$arrLimits = explode(',', self::CSV_LIMITS);
		// - read csv file row by row
		$strPath = dirname(self::ZIP_FILE);
		$strFile = self::CSV_FILE_NAME;
		if (($resHandler = fopen($strPath . '/' . $strFile, "r")) !== FALSE) {
			while (($strLine = fgets($resHandler)) !== FALSE) {		
				// - explode into value array
				$arrValues = explode(self::CSV_DELIMITER, $strLine);
				$nOffset = 0;
				foreach ($arrLimits as $strLimit) {
					// - throw exception if CSV does not fit every configured parameter
					if ($this->_getEnclosureFreeValue($arrValues[$nOffset]) != $strLimit) {
						throw new Exception('Database import file does not fit to the limit parameter: '.$strLimit);
					}
					$nOffset = $nOffset + intval($strLimit) + 1;
				}
			}
		}
		
		/*
		 * PROCESSING
		 */
		// Read CSV file into database...
		$nCounter = 0;
		$handle = fopen($strPath . '/' . $strFile, 'r');
		while (!feof($handle)) {

			// ...line by line
			$strLine = fgets($handle);
			$arrData = explode(self::CSV_DELIMITER, $strLine);
			$nCounter++;

			/*
			 * CHECK
			 */
			// - ignore empty lines
			if (trim($strLine) == '') {
				continue;
			}
			// - ignore vehicles with "-" within Claris-Id
			if (strpos($arrData[2], '-') > 0) {
				continue;
			}

			// Build insert query
			$strQuery1 = "INSERT INTO `" . self::DATABASE_TABLE . "` VALUES (";
			$strQuery2 = "";
			$strQuery3 = ")";
			for ($i = 0; $i < $nColumns; $i++) {
				$strQuery2 = $strQuery2 . "'" . $this->_getEnclosureFreeValue($arrData[$i]) . "', ";
			}
			$strQuery2 = substr($strQuery2, 0, -2);

			// Clear table first
			if (!$bEmptied) {
				$objCore->getHelperDatabase()->query("TRUNCATE TABLE `" . self::DATABASE_TABLE . "`");
				$bEmptied = true;
			}

			// Insert rows with best-effort
			try {
				$objCore->getHelperDatabase()->query($strQuery1 . $strQuery2 . $strQuery3);
			} catch (Exception $objException) {
				// Log errors but proceed as if nothing happened
				Schmolck_Tool_Debug::error($objException->getMessage());
			}
		}		
	}
	
	/**
	 * Get CSV value without defined enclosure strings
	 * 
	 * @param string $strValue
	 * @return string cleaned string
	 */
	protected function _getEnclosureFreeValue($strValue) {
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