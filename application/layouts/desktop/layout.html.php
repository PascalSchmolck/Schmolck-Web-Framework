<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<base href="http://localhost/php.framework.schmolck/"/>
	<title>
		Schmolck Framework - Demo
	</title>
	<?php $this->_RenderViewStyles(); ?>
	<link rel='stylesheet' type='text/css' href='application/layouts/desktop/layout.styles.css'/>

	<script type="text/javascript" src="libraries/js/jquery/jquery-1.7.1.min.js"></script>
	<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
	<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>-->
	<?php $this->_RenderViewScripts(); ?>
</head>
<body>
	<?php $this->_RenderViewHtml(); ?>
</body>
</html>