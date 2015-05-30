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
        case 'getFilterOptions':
            $arrBrands = $objCars->getFilterOptionsBrands();
            foreach ($arrBrands as $key => $value) {
                $arrResult['brand'][$key] = array(
                    'label' => $value,
                    'models' => $objCars->getFilterOptionsModels($key)
                );
            }
            break;
        case 'getCarsFiltered':
            $arrResult['cars'] = $objCars->queryCarsFiltered();
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
    $strJSON = json_encode($arrResult);
    header("Content-Type: application/json; charset=utf-8");
    header("Content-Transfer-Encoding: 8bit");
    header("Content-Length: " . strlen($strJSON));
    echo $strJSON;
    exit();
}