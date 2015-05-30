<?php

/*
 * INITIALISATION
 */
$objCore = Schmolck_Framework_Core::getInstance($this);
$objCore->strId = $objCore->getHelperElement()->getId();
$objCore->strUrl = $objCore->getHelperApplication()->getRequestUrl();
$objCore->strApi = $objCore->getHelperElement()->getIdentifier();
$objCars = new Mobile_Helper($objCore);
$strParameterMode = strip_tags($_GET['mode']);
$strParameterBrand = Schmolck_Tool_Memory::auto($objCore->getModule(), 'brand', strip_tags($_GET['brand']));
$strParameterModel = Schmolck_Tool_Memory::auto($objCore->getModule(), 'model', strip_tags($_GET['model']));

/*
 * CHECK
 */
if (!empty($strParameterMode)) {
   if (!array_key_exists($strParameterBrand, $objCars->getFilterOptionsBrands())) {
      $strErrorMessage = "brand '$strParameterBrand' does not exist";
      $strErrorCode = 1;
      Schmolck_Tool_Memory::auto($objCore->getModule(), 'brand', ' ');
      throw new Exception($strErrorMessage, $strErrorCode);
   }
   if (count($objCars->getFilterOptionsModels($strParameterBrand)) == 0) {
      $strParameterModel = Schmolck_Tool_Memory::auto($objCore->getModule(), 'model', ' ');
   } else {
      if (!array_key_exists($strParameterModel, $objCars->getFilterOptionsModels($strParameterBrand))) {
         $strErrorMessage = "model '$strParameterModel' does not exist";
         $strErrorCode = 2;
         Schmolck_Tool_Memory::auto($objCore->getModule(), 'model', ' ');
         throw new Exception($strErrorMessage, $strErrorCode);
      }
   }
}

/*
 * SAVING
 */
$objCars->setFilter('brand', $strParameterBrand);
$objCars->setFilter('model', $strParameterModel);

/*
 * REDIRECT
 */
switch ($strParameterMode) {
   // mobile/api/call/mode/silent
   case 'silent':
      break;
   // mobile/api/call/mode/redirect
   case 'redirect':
      $objCore->getHelperRedirect()->local('mobile');
      break;
}

/*
 * EXIT
 */
if (!empty($strParameterMode)) {
   exit();
}