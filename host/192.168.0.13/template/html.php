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
	$this->registerViewStyle("lib/css/cssgrid/1140.css");
	// - application styles
  	$this->registerViewStyle("{$strTemplatePath}/styles.css");
	$this->renderViewStyles();
	?>	
	<!--[if lte IE 9]><link rel="stylesheet" href="lib/css/cssgrid/ie.css" type="text/css" media="screen" /><![endif]-->
	
	<?php
	/*
	 * SCRIPTS
	 */
	$this->registerViewScript('lib/js/jquery/jquery-1.7.1.min.js');
	$this->registerViewScript("{$strTemplatePath}/scripts.js");
	$this->renderViewScripts();
	?>	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	<header class="container">
		<div class="row">
			<div class="ninecol">
				<p>
					<?php $this->renderViewHtml(); ?>
				</p>
			</div>
			<div class="threecol last">
				Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
			</div>
		</div>
	</header>
	
	<div class="container">
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

	<div class="container">
		<div class="row">
			<div class="twocol">
				<p>Two columns</p>
			</div>
			<div class="twocol">
				<p>Two columns</p>
			</div>
			<div class="twocol">
				<p>Two columns</p>
			</div>
			<div class="twocol">
				<p>Two columns</p>
			</div>
			<div class="twocol">
				<p>Two columns</p>
			</div>
			<div class="twocol last">
				<p>Two columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="threecol">
				<p>Three columns</p>
			</div>
			<div class="threecol">
				<p>Three columns</p>
			</div>
			<div class="threecol">
				<p>Three columns</p>
			</div>
			<div class="threecol last">
				<p>Three columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="fourcol">
				<p>Four columns</p>
			</div>
			<div class="fourcol">
				<p>Four columns</p>
			</div>
			<div class="fourcol last">
				<p>Four columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="onecol">
				<p>One</p>
			</div>
			<div class="elevencol last">
				<p>Eleven columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="twocol">
				<p>Two columns</p>
			</div>
			<div class="tencol last">
				<p>Ten columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="threecol">
				<p>Three columns</p>
			</div>
			<div class="ninecol last">
				<p>Nine columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="fourcol">
				<p>Four columns</p>
			</div>
			<div class="eightcol last">
				<p>Eight columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="fivecol">
				<p>Five columns</p>
			</div>
			<div class="sevencol last">
				<p>Seven columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="sixcol">
				<p>Six columns</p>
			</div>
			<div class="sixcol last">
				<p>Six columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="sevencol">
				<p>Seven columns</p>
			</div>
			<div class="fivecol last">
				<p>Five columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="eightcol">
				<p>Eight columns</p>
			</div>
			<div class="fourcol last">
				<p>Four columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="ninecol">
				<p>Nine columns</p>
			</div>
			<div class="threecol last">
				<p>Three columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="tencol">
				<p>Ten columns</p>
			</div>
			<div class="twocol last">
				<p>Two columns</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="elevencol">
				<p>Eleven columns</p>
			</div>
			<div class="onecol last">
				<p>One</p>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="threecol">
				<p>Three columns</p>
			</div>
			<div class="sixcol">
				<p>Six columns</p>
			</div>
			<div class="threecol last">
				<p>Three columns</p>
			</div>
		</div>
	</div>	
	
	
</body>
</html>