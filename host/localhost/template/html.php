<!DOCTYPE html>
<html>
<head>
	<?php $this->renderViewBase(); ?>
	<title>
		Schmolck Framework - Demo
	</title>
	
	<?php $this->registerViewStyles('host/localhost/template/styles.css'); ?>
	<?php $this->renderViewStyles(); ?>

	<?php $this->registerViewScripts('libraries/js/jquery/jquery-1.7.1.min.js') ?>
	<?php $this->registerViewScripts('host/localhost/template/scripts.js') ?>
	<?php $this->renderViewScripts(); ?>
</head>
<body>
	<?php $this->renderViewHtml(); ?>
</body>
</html>