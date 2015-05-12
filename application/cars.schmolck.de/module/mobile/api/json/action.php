<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCars = new Mobile_Helper($objCore);
$strParameterFunction = $_GET['function'];

/*
 * OUTPUT
 */
try {
   switch ($strParameterFunction) {
      // mobile/api/json/function/getFilterOptions
      case 'getFilterOptions':
         $arrBrands = $objCars->getFilterOptionsBrands();
         foreach ($arrBrands as $key => $value) {
            $arrResult['brand'][$key] = array(
               'label' => $value,
               'models' => $objCars->getFilterOptionsModels($key)
            );
         }
         break;
   } 
} catch (Exception $objException) {
   $arrResult = array(
     'status' => $objException->getCode(),
     'result' => $objException->getMessage()
   );
}

/*
 * OUTPUT
 */
if (!empty($strParameterFunction)) {
   echo json_encode($arrResult);
   exit();
}