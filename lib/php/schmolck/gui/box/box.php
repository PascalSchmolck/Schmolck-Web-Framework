<?php
/**
 * Schmolck_Gui_Box
 * 
 * @package Schmolck framework
 * @author Pascal Schmolck
 * @copyright 2013
 */
class Schmolck_Gui_Box extends Schmolck_Gui{

	protected function _renderHtml() {
		?>
		<div id="<?=$this->id?>" class="<?=$this->class?>">
			<?=$this->data?>
		</div>
		<script>
		$(document).ready(function() {
			obj<?=$this->id?> = new <?=get_class()?>('<?=$this->id?>');
		});
		</script>
		<?php
	}
	
}