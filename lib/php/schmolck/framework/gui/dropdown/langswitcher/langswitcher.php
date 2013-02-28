<?php

/**
 * Schmolck_Framework_Gui_Dropdown_Langswitcher
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Framework_Gui_Dropdown_Langswitcher extends Schmolck_Framework_Gui_Dropdown {

	/**
	 * Initialization
	 */
	public function init() {
		/*
		 * AJAX HANDLING
		 */
		if ($this->_objCore->getHelperAjax()->checkCall($this->id)) {
			$this->_objCore->getHelperTranslator()->setLanguage(strip_tags($_POST['value']));
		}
	}

	/**
	 * Render HTML
	 */
	public function _renderHtml() {
		/*
		 * PREPARATION
		 */
		// - selected
		$this->setSelected($this->_objCore->getHelperTranslator()->getLanguage());
		// - entries
		$arrLanguages = $this->_objCore->getHelperTranslator()->getLanguages();
		if (count($arrLanguages) > 0) {
			foreach ($arrLanguages as $strLanguage) {
				$arrEntries[$strLanguage] = $strLanguage;
			}
			$this->setEntries($arrEntries);
		}


		/*
		 * OUTPUT
		 */
		parent::_renderHtml();
	}

	/**
	 * Render JavaScript
	 */
	protected function _renderJs() {
		parent::_renderJs();
		?>
		<script>
			$(document).ready(function() {
				$('#<?= $this->id ?>').change(function () {
					var strValue = $('#<?= $this->id ?> select').val();					
					Schmolck_Framework_Ajax({
						id: '<?= $this->id ?>',
						data: 'value='+strValue,
						success: function () {
							//window.location.reload();
							window.location.href = window.location;
						}
					});
				});
			});								
		</script>
		<?php
	}

}