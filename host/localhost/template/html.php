<?
/*
 * PREPARATION
 */
$strTemplatePath = Schmolck_Framework_Host::getCurrentPath().'/template';

/*
 * HTML
 */
?>
<!DOCTYPE html>
<html>
<head>
	<?php $this->renderViewBase(); ?>
	<title>
		Schmolck Framework
	</title>
	
	<?php $this->registerViewStyles("{$strTemplatePath}/styles.css"); ?>
	<?php $this->renderViewStyles(); ?>

	<?php $this->registerViewScripts('lib/js/jquery/jquery-1.7.1.min.js') ?>
	<?php $this->registerViewScripts("{$strTemplatePath}/scripts.js") ?>
	<?php $this->renderViewScripts(); ?>
</head>
<body>
	<?php $this->renderViewHtml(); ?>
</body>
</html>