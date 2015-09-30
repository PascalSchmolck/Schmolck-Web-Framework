<?php

/**
 * Mobile_Helper
 * 
 * @package cars.schmolck.de
 * @author Pascal Schmolck
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
    * Get filter options for brands
    */
   public function getFilterOptionsBrands() {
      /*
       * INITIALISATION
       */
      $objCore = Schmolck_Framework_Core::getInstance($this->_objCore);            

      /*
       * OUTPUT
       */
      return array(
         'all' => $objCore->getHelperTranslator()->_("All"),
         'mercedes-benz' => 'Mercedes-Benz',
         'smart' => 'smart',
         'skoda' => 'ŠKODA',
         'others' => $objCore->getHelperTranslator()->_("Others"),
      );
   }

   /**
    * Get filter model options depending on given brand
    * 
    * @param string $strBrand brand
    * @return array
    */
   public function getFilterOptionsModels($strBrand) {
      /*
       * INITIALISATION
       */
      $objCore = Schmolck_Framework_Core::getInstance($this->_objCore);            

      /*
       * OUTPUT
       */
      switch ($strBrand) {
         case 'all':
         case 'mercedes-benz':
            return array(
              "all" => $objCore->getHelperTranslator()->_("All"),
              "a" => $objCore->getHelperTranslator()->_("A-Class"),
              "b" => $objCore->getHelperTranslator()->_("B-Class"),
              "c" => $objCore->getHelperTranslator()->_("C-Class"),
              "e" => $objCore->getHelperTranslator()->_("E-Class"),
              "clk" => $objCore->getHelperTranslator()->_("CLK"),
              "slk" => $objCore->getHelperTranslator()->_("SLK"),
              "offroad" => $objCore->getHelperTranslator()->_("Offroad"),
              "others-mercedes" => $objCore->getHelperTranslator()->_("Others"),
            );
         case 'smart':
            return array(
               "all" => $objCore->getHelperTranslator()->_("All"),
               "f2" => $objCore->getHelperTranslator()->_("Fortwo"),
               "f4" => $objCore->getHelperTranslator()->_("Forfour"),
               "roadster" => $objCore->getHelperTranslator()->_("Roadster"),
               "others-smart" => $objCore->getHelperTranslator()->_("Others"),
            );                    
         case 'skoda':
            return array(
               "all" => $objCore->getHelperTranslator()->_("All"),
               "citigo" => 'Citigo',
               "fabia" => 'Fabia',
               "rapid" => 'Rapid',
               "octavia" => 'Octavia',
               "yeti" => 'Yeti',
               "superb" => 'Superb'
            );                    
         case 'others':
            return array(
               "all" => $objCore->getHelperTranslator()->_("All"),
            );        
     }
            
      /*
       * FALLBACK
       */
      return array();
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
					AND D_marke COLLATE UTF8_GENERAL_CI NOT LIKE 'Skoda'
				";
				break;
		}
		// - model
		switch ($this->getFilter('model')) {
			case 'all':
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%'
				";
				break;
			// - mercedes
			case "a":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE 'A %'
				";
				break;
			case "b":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE 'B %'
				";
				break;
			case "c":
				$strWhereModel = "
					AND
						( E_modell COLLATE UTF8_GENERAL_CI LIKE 'C %'
						OR E_modell COLLATE UTF8_GENERAL_CI LIKE 'CL %'
						)
				";
				break;
			case "e":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE 'E %'
				";
				break;
			case "offroad":
				$strWhereModel = "
					AND
						( E_modell COLLATE UTF8_GENERAL_CI LIKE 'M %'
						OR E_modell COLLATE UTF8_GENERAL_CI LIKE 'ML %'
						OR E_modell COLLATE UTF8_GENERAL_CI LIKE 'G %'
						OR E_modell COLLATE UTF8_GENERAL_CI LIKE 'GL %'
						OR E_modell COLLATE UTF8_GENERAL_CI LIKE 'GLK %'
						)
				";
				break;
			case "clk":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE 'CLK %'
				";
				break;
			case "slk":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE 'SLK %'
				";
				break;
			case "others-mercedes":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'A %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'B %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'C %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'CL %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'E %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'CLK %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'SLK %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'M %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'ML %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'G %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'GL %'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE 'GLK %'
				";
				break;
			// - smart
			case "f2":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%FORTWO%'
				";
				break;
			case "f4":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%FORFOUR%'
				";
				break;
			case "roadster":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%ROADSTER%'
				";
				break;
			case "others-smart":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE '%FORTWO%'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE '%FORFOUR%'
					AND E_modell COLLATE UTF8_GENERAL_CI NOT LIKE '%ROADSTER%'
				";
				break;	
            // - ŠKODA
			case "citigo":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%Citigo%'
				";
				break;
			case "fabia":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%Fabia%'
				";
				break;
			case "rapid":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%Rapid%'
				";
				break;
			case "octavia":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%Octavia%'
				";
				break;
            case "yeti":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%Yeti%'
				";
				break;
            case "superb":
				$strWhereModel = "
					AND E_modell COLLATE UTF8_GENERAL_CI LIKE '%Superb%'
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
		$arrMap['marke'] = strtolower($arrRow['D_marke']);
		$arrMap['modell'] = utf8_encode($arrRow['E_modell']);
		$arrMap['name'] = $this->_getMappedRowName($arrRow['D_marke'], utf8_encode($arrRow['E_modell']));
		$arrMap['kategorie'] = $arrRow['C_kategorie'];
		$arrMap['fahrzeug'] = $this->_getMappedRowFahrzeug($arrRow);
		$arrMap['ez'] = $this->_getMappedRowEz($arrRow);
		$arrMap['km'] = $this->_getMappedRowKm($arrRow);
		$arrMap['kraftstoff'] = $this->_getMappedRowKraftstoff($arrRow['DF_kraftstoffart']);
		$arrMap['kw'] = $arrRow['F_leistung'];
		$arrMap['ps'] = $this->_getMappedRowPs($arrRow);
		$arrMap['getriebe'] = $this->getMappedRowTransmission($arrRow['DG_getriebeart']);
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
        
        if (preg_match("/skoda/i", $strMarke)) {
			return 'ŠKODA ' . $strModell;
		}

		if (preg_match("/Volkswagen/i", $strMarke)) {
			return 'Volkswagen ' . $strModell;
		}
		
		return $strMarke.' '.$strModell;
	}
	
	protected function _getMappedRowFahrzeug($arrRow) {
		/*
		 * INITIALISATION
		 */
		$objCore = Schmolck_Framework_Core::getInstance($this->_objCore);
		
		/*
		 * PROCESSING
		 */
		// - Neufahrzeug?
		if ($arrRow['V_neufahrzeug'] == '1') {
			$strLabel = $objCore->getHelperTranslator()->_("Brand New Car");
		}
		// - Jahreswagen?
		if ($arrRow['U_jahreswagen'] == '1') {
			$strLabel = $objCore->getHelperTranslator()->_("Jahreswagen");
		}
		// - Gütesiegel?
		switch (strtolower($arrRow['D_marke'])) {
			case 'mercedes-benz':
				if ($arrRow['DQ_qualitaetssiegel'] == '6') {
					$strLabel = $objCore->getHelperTranslator()->_("Junger Stern");
				} 											
				break;
			case 'smart':
				if ($arrRow['DQ_qualitaetssiegel'] != '') {
					$strLabel = $objCore->getHelperTranslator()->_("jung@smart");
				} 
				break;
		}
		// - Gebrauchtwagen?
		if ($strLabel == '') {
			$strLabel = $objCore->getHelperTranslator()->_("Used Car");
		}
		
		/*
		 * DEBUG
		 */
//		if ($arrRow['A_satz_nummer'] == '20130354') {
//			$strLabel = $arrRow['DQ_qualitaetssiegel'];
//		}
		
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
	
	public function getMappedRowTransmission($strValue) {
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
			$strLine = trim($strLine);
			
                        // - disregard empty lines
                        if ($strLine == '') continue;
                        
			// **TEXT** => <strong>TEXT</strong>
			$strLine = preg_replace('/\*\*([^\*\*]+)\*\*/i', '<strong>$1</strong><br>', $strLine);			
			
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
		return implode('', $arrLines);
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
		return md5($strString.date('Y.m.d-H'));	
	}		
}

/**
 * Mobile_Import_Helper
 * 
 * @package cars.schmolck.de
 * @author Pascal Schmolck

 */
class Mobile_Import_Helper extends Schmolck_Framework_Helper {

	const ZIP_FILE = MOBILE_ZIP_FILE;
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
			if (APPLICATION_ENVIRONMENT != 'development') {
				return;
			}
		}

		/*
		 * PROCESSING
		 */
		try {
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
		} catch (Exception $objException) {
			throw new Exception('Database update failed: ' . $objException->getMessage() );
		}
		
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
		 * BACKUP
		 */			
		// - backup current zip file
		rename(self::ZIP_FILE, self::ZIP_FILE . '.' . date("Ymd") . '.bak');		
		
		/*
		 * CLEANING
		 */
		// - remove database import file
		unlink(self::DATABASE_FILE);		
		// - remove old backup files
		$strDir = dirname(self::ZIP_FILE);
		$arrFiles = scandir($strDir);
		foreach ($arrFiles as $strFile) {
			if (in_array($strFile, array(".",".."))) continue;
			if (preg_match('/\.bak$/i', $strFile)) {
				if ((time() - filectime($strDir.'/'.$strFile)) > ' 2628000') { // older than 1 month in ms
					unlink($strDir.'/'.$strFile);
				}
			}
		}			
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
			$strValue3 = mysql_real_escape_string($strValue2);
		}
		
		/*
		 * RETURN
		 */
		return $strValue3;
	}	
}