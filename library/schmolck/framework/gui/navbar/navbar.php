<?php

/**
 * Schmolck_Framework_Gui_Navbar
 * 
 * @package Schmolck Web Framework
 * @author Pascal Schmolck
 */
class Schmolck_Framework_Gui_Navbar extends Schmolck_Framework_Gui {

	protected $_arrEntries = array();

	public function setEntries($arrEntries) {
		$this->_arrEntries = $arrEntries;
	}

	protected function _renderHtml() {
		?>
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
		<?php
	}
	
	protected function _renderJs() {
		
	}

}