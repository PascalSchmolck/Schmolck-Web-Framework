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
	 * Render HTML
	 */
	public function _renderHtml() {
		/*
		 * PREPARATION
		 */
		$this->setEntries($this->_objCore->get('translator')->getLanguages());

		/*
		 * OUTPUT
		 */
		parent::_renderHtml();
	}

	/**
	 * Render JavaScript
	 */
	protected function _renderJs() {
		?>
		<script>
			$(document).ready(function() {
				$('#<?= $this->id ?>').change(function () {
					$.ajax({
						type: "POST",
						url: 'api/data/setLanguage',
						data: 'language=test',
						success: function (data) {
							var json = $.parseJSON(data);
							alert('Status: ' + json.status + ' Data: ' + json.data);
						}
					});
				});	
			});								
		</script>
		<?php
	}

}