<?php

/**
 * Schmolck_Framework_Gui_Dropdown
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Gui_Dropdown extends Schmolck_Framework_Gui {

	protected $_arrEntries = array();
	protected $_strSelected;

	public function setEntries($arrEntries) {
		$this->_arrEntries = $arrEntries;
	}
	
	public function setSelected($strSelected) {
		$this->_strSelected = $strSelected;
	}

	protected function _renderHtml() {
		?>
		<select>
			<?php
			foreach ($this->_arrEntries as $strName => $strLabel) {
				($strName == $this->_strSelected) ? $strSelected = 'selected': $strSelected = '';
				echo "
					<option value=\"{$strName}\" {$strSelected}>
						{$strLabel}
					</option>
				";
			}
			?>
		</select>
		<?php
	}

	protected function _renderJs() {
		
	}

}