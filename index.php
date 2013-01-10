<?php
/**
 * Schmolck framework - PHP Framework
 * Copyright (C) 2013 Pascal Schmolck <piccolino81@gmail.com>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * AUTOLOADER
 */
function __autoload($strClass){
	// - prepare path
	$strFilePath = 'lib/php';
	
	// - parse class parts
	$arrParts = explode('_', $strClass);
	foreach ($arrParts as $strPart) {
		$strFilePath .= "/{$strPart}";
		$strFileName = "{$strPart}.php";
	}
	
	// - include
	require_once($strFilePath.'/'.$strFileName);
}

/*
 * CORE
 */
$core = new Schmolck_Framework_Core();
$core->run();