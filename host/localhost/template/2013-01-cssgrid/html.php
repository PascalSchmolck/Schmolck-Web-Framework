<?
/*
 * PREPARATION
 */
// - navigation bar
$objNavbar = new Schmolck_Gui_Navbar('mainnav');
$objNavbar->setCore($this);
$objNavbar->setEntries(array(
	'home'	=>	array(
		'href' => '#',
		'label' => 'Home'
	),
	'link2'	=>	array(
		'href' => '#',
		'label' => 'Link2'
	),
	'link3'	=>	array(
		'href' => '#',
		'label' => 'Link3'
	),
	'link4'	=>	array(
		'href' => '#',
		'label' => 'Link4'
	),
	'link5'	=>	array(
		'href' => '#',
		'label' => 'Link5'
	),	
	'imprint'	=>	array(
		'href' => '#',
		'label' => 'Imprint'
	),	
));
$htmlNavbar = $objNavbar->getHtml();

/*
 * HTML
 */
?>
<!DOCTYPE html>
<html>
<head>
	<base href="<?php $this->getBaseUrl(); ?>">
	<meta charset="utf-8"/>
	<title>
		Schmolck Framework
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700|Droid+Sans:700"/>
	<link rel="stylesheet" type="text/css" href="lib/css/cssgrid/1140.css"/>
	<!--[if lte IE 9]><link rel="stylesheet" href="lib/css/cssgrid/ie.css" type="text/css" media="screen" /><![endif]-->
	<link rel="stylesheet/less" type="text/css" href="<?=$this->getCoreLESSFile()?>"/>
	
	<script type="text/javascript" src="lib/js/less/less-1.3.0.min.js"></script>
	<script type="text/javascript" src="lib/js/jquery/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="<?=$this->getCoreJSFile()?>"></script>
</head>
<body>
	<div id="header" class="container">
		<div class="row">
			<div class="ninecol">
				<h1>
					Schmolck					
					
				</h1>
				<h2>
					framework
				</h2>
			</div>
			<div class="threecol last">
				
			</div>
		</div>
	</div>
	
	<div id="nav" class="container">
		<div class="row">
			<div class="eightcol">
				<?php echo $htmlNavbar; ?>
			</div>
			<div class="onecol">
				
			</div>
			<div class="twocol last">
				<p>One</p>
			</div>
		</div>
	</div>

	<div id="main" class="container">
		<div class="row">
			<div class="eightcol">
				<div id="content">
					<?php $this->renderViewHtml(); ?>
				</div>
			</div>
			<div class="fourcol last">
				<div id="sidebar">
					<h1>
						Sidebar
					</h1>
					<h2>
						Subtitle
					</h2>
					<p>
						Lorem ipsum dolor sit <a href="#">amet</a>, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet <a href="#">amet</a> kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit <a href="#">amet</a>.   
					</p>
				</div>
			</div>
		</div>
	</div>
	
	<div id="footer" class="container">
		<div class="row">
			<div class="threecol">
				Copyright
			</div>
			<div class="ninecol last">
				<div class="links">
					<a href="#">Contact</a>
					<a href="#">Disclaimer</a>
					<a href="#">Imprint</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>