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

	public function setEntries($arrEntries) {
		$this->_arrEntries = $arrEntries;
	}

	protected function _renderHtml() {
		?>
		<select>
			<?php
			foreach ($this->_arrEntries as $strName => $strLabel) {
				echo "
					<option value=\"{$strName}\">
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