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
	// - cssgrid styles
	$this->registerViewStyles("lib/css/cssgrid/1140.css");
	// - application styles
  	$this->registerViewStyles("{$strTemplatePath}/styles.css");
	$this->renderViewStyles();
	?>	
	<!--[if lte IE 9]><link rel="stylesheet" href="lib/css/cssgrid/ie.css" type="text/css" media="screen" /><![endif]-->
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700|Droid+Sans:700"/>
	
	<?php
	/*
	 * SCRIPTS
	 */
	$this->registerViewScripts('lib/js/jquery/jquery-1.7.1.min.js');
	$this->registerViewScripts("{$strTemplatePath}/scripts.js");
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
						news
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
				<p>
					Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
				</p>
			</div>
		</div>
	</div>
	
</body>
</html>