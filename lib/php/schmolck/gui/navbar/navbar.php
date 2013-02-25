<?php

/**
 * Schmolck_Gui_Navbar
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Gui_Navbar extends Schmolck_Gui {

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
		<script>
			$(document).ready(function() {
				obj<?= $this->id ?> = new <?= get_class() ?>('<?= $this->id ?>');
			});
		</script>
		<?php
	}

}