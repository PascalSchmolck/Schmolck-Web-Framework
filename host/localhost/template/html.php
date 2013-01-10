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
	
	<meta charset="utf-8"/>
	
	<title>
		Schmolck Framework
	</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<?php 
	/*
	 * STYLES
	 */
	
	$this->registerViewStyles(array(
		"lib/css/cssgrid/1140.css",
		"{$strTemplatePath}/styles.css",
	));
	$this->renderViewStyles();
	?>	
	<!--[if lte IE 9]><link rel="stylesheet" href="lib/css/cssgrid/ie.css" type="text/css" media="screen" /><![endif]-->
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700|Droid+Sans:700"/>
	
	<?php
	/*
	 * SCRIPTS
	 */
	$this->registerViewScripts(array(
		'lib/js/jquery/jquery-1.7.1.min.js',
		"{$strTemplatePath}/scripts.js",
	));
	$this->renderViewScripts();
	?>	
</head>
<body>
	<div id="header" class="container">
		<div class="row">
			<div class="ninecol">
				<h1>
					Schmolck					
					<div>
						framework
					</div>
				</h1>
			</div>
			<div class="threecol last">
				
			</div>
		</div>
	</div>
	
	<div id="nav" class="container">
		<div class="row">
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="onecol last">
				<p>One</p>
			</div>
		</div>
	</div>

	<div id="main" class="container">
		<div class="row">
			<div class="twelvecol">
				<p>
					<?php $this->renderViewHtml(); ?>
				</p>
			</div>
		</div>
	</div>
	
</body>
</html>