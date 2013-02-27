<?php

/**
 * Schmolck_Framework_Gui_Navbar
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Gui_Navbar extends Schmolck_Framework_Gui {

	protected $_arrEntries = array();

	public function setEntries($arrEntries) {
		$this->_arrEntries = $arrEntries;
	}

	protected function _renderHtml() {
		?>
		<div id="<?= $this->id ?>" class="<?= $this->class ?>">
			<div class="hlist">
				<ul>
					<?php
					foreach ($this->_arrEntries as $strName => $arrEntry) {
						echo "
							<li>
								<a href=\"{$arrEntry['href']}\">
									{$arrEntry['label']}
								</a>
							</li>
						";
					}
					?>
				</ul>
			</div>
		</div>
		<?php
	}
	
	protected function _renderJs() {
		
	}

}