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
	
	<!-- mobile viewport optimisation -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<?php 
	/*
	 * STYLES
	 */
	// - YAML styles
	$this->registerViewCSSs("lib/css/yaml/core/base.css");
	$this->registerViewCSSs("lib/css/yaml/navigation/hlist.css");
	$this->registerViewCSSs("lib/css/yaml/forms/gray-theme.css");
	$this->registerViewCSSs("lib/css/yaml/screen/typography.css");
	$this->registerViewCSSs("lib/css/yaml/screen/screen-FULLPAGE-layout.css");
	$this->registerViewCSSs("lib/css/yaml/print/print.css");
	// - application styles
  	$this->registerViewCSSs("{$strTemplatePath}/styles.css");
	$this->renderViewStyles();
	?>	
	<!--[if lte IE 7]>
	<link rel="stylesheet" href="lib/css/yaml/core/iehacks.min.css" type="text/css"/>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700|Droid+Sans:700"/>
	
	<?php
	/*
	 * SCRIPTS
	 */
	$this->registerViewScripts('lib/js/jquery/jquery-1.7.1.min.js');
	$this->registerViewScripts("{$strTemplatePath}/scripts.js");
	$this->renderViewScripts();
	?>	
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	<ul class="ym-skiplinks">
		<li><a class="ym-skip" href="#nav">Skip to navigation (Press Enter)</a></li>
		<li><a class="ym-skip" href="#main">Skip to main content (Press Enter)</a></li>
	</ul>

	<header>
		<div class="ym-wrapper">
			<div class="ym-wbox">
				<h1>
					Schmolck <div>news</div>
				</h1>
			</div>
		</div>
	</header>
	
	<nav id="nav">
		<div class="ym-wrapper">
			<div class="ym-hlist">
				<ul>
					<li class="active"><strong>Active</strong></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
				</ul>
				<form class="ym-searchform">
					<input class="ym-searchfield" type="search" placeholder="Search..." />
					<input class="ym-searchbutton" type="submit" value="Search" />
				</form>
			</div>
		</div>
	</nav>
	<div id="main">
		<div class="ym-wrapper">
			<div class="ym-wbox">
				

				<section class="ym-grid linearize-level-1">
					<article class="ym-g66 ym-gl content">
						<div class="ym-gbox-left ym-clearfix">

							<?php $this->renderViewHtml(); ?>
							
						</div>
					</article>
					<aside class="ym-g33 ym-gr">
						<div class="ym-gbox-right ym-clearfix">
							<h3>A Simple Sidebar </h3>
							<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices  posuere cubilia Curae; Cras ornare mattis nunc. Mauris venenatis, pede  sed aliquet vehicula, lectus tellus pulvinar neque, non cursus sem nisi vel augue.</p>
							<p>Mauris a lectus. Aliquam erat volutpat. Phasellus ultrices mi a sapien. Nunc rutrum egestas lorem. Duis ac sem sagittis elit tincidunt gravida. Mauris a lectus. Aliquam erat volutpat. Phasellus ultrices mi a sapien. Nunc rutrum egestas lorem. Duis ac sem sagittis elit tincidunt gravida.</p>
							<p class="box info">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Cras ornare mattis nunc. Mauris venenatis, pede sed aliquet  vehicula, lectus tellus pulvinar neque, non cursus sem nisi vel augue.</p>
						</div>
					</aside>
				</section>
			</div>
		</div>
	</div>
	<footer>
		<div class="ym-wrapper">
			<div class="ym-wbox">
				<p>© Schmolck <?php echo date('Y'); ?> &ndash; <a href="http://www.yaml.de" target="_blank">YAML</a></p>
			</div>
		</div>
	</footer>
</body>
</html>