<?php

/**
 * Schmolck_Framework_Helper_Api
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Framework_Helper_Api extends Schmolck_Framework_Helper {

	/**
	 * Check if currently in AJAX call
	 * 
	 * Provide $strId when checking for specified gui object call
	 * 
	 * @param string $strId gui id
	 * @return boolean
	 */
	public function checkAjaxCall($strId = '') {
		if (empty($strId)) {
			return ( isset($_POST['_ajax']) and !empty($_POST['_id']) );
		} else {
			return ( isset($_POST['_ajax']) and $_POST['_id'] == $strId );
		}
	}

	/**
	 * Get session unique API id
	 * 
	 * @return string id
	 */
	public function getId() {
		if ($this->checkAjaxCall()) {
			return $_POST['_id'];
		} else {
			return 'id' . md5($this->_objCore->getHelperApplication()->getRequestUrl() . session_id());
		}
	}

	/**
	 * Get api CSS class
	 * 
	 * @return string class
	 */
	public function getStyleClass() {
		return  ''.
				$this->_objCore->getModule() . ' ' .
				$this->_objCore->getController() . ' ' .
				$this->_objCore->getAction();
	}

	/**
	 * Get api identifier
	 * 
	 * @return string identifier
	 */
	public function getIdentifier() {
		return $this->_objCore->getModule() . '/' .
				$this->_objCore->getController() . '/' .
				$this->_objCore->getAction();
	}

	/**
	 * Get API element
	 * 
	 * @param string $strId element id
	 * @param string $strUrl element url (including GET parameter)
	 * @param array $arrParameter POST parameter
	 * @return string element
	 */	
	public function getElement($strId, $strUrl, $arrParameter=array()) {
		/*
		 * BACKUP
		 */
		$arrOldGET = $_GET;
		$arrOldPOST = $_POST;
		
        /*
         * PARSING 
         */
        $nCounter = 0;
        $_GET = array();
        $arrQueryParameter = explode('/', $strUrl);
        foreach ($arrQueryParameter as $entry) {
           switch ($nCounter) {
              case 0:
                 $strModule = $entry;
                 break;
              case 1:
                 $strController = $entry;
                 break;
              case 2:
                 $strAction = $entry;
                 break;
              default:
                 if ($nCounter % 2 != 0) {
                    $key = $entry;
                 } else {
                    $value = $entry;
                    // - remove trailing ?
                    if (substr($value, strlen($value) - 1, strlen($value)) == '?') {
                       $value = substr($value, 0, strlen($value) - 1);
                    }
                    $_GET[$key] = $value;
                 }
                 break;
           }
           $nCounter++;
        }
		
		/*
		 * PARAMETER
		 */
		$_POST = $arrParameter;
		$_POST['_ajax'] = 'true';
		$_POST['_id'] = $strId;
		
		/*
		 * PROCESSING
		 */
		ob_start();
		$objNewCore = new Schmolck_Framework_Core();
		$objNewCore->setModule($strModule);
		$objNewCore->setController($strController);
		$objNewCore->setAction($strAction);
		$objNewCore->setLayoutRendering(false);
		$objNewCore->run();
		$strOutput = ob_get_contents();
		ob_end_clean();

		/*
		 * RESTORE
		 */
		$_GET = $arrOldGET;
		$_POST = $arrOldPOST;

		/*
		 * OUTPUT
		 */
		return $strOutput;
	}
	
	/**
	 * Get API element call statements
	 * 
	 * @param string $strId element id
	 * @param string $strApi api call structure
	 * @param array $arrParameter GET parameters
	 * @return string element call statements
	 */
	public function getElementCaller($strId, $strApi, $arrParameter=array()) {
		return "
			<div id=\"{$strId}\">
				<script>
					Schmolck_Framework_Helper_Api({
						url: '{$strApi}',
						id: '{$strId}',
						data: '".http_build_query($arrParameter)."'
					});
				</script>
			</div>
		";
	}

}