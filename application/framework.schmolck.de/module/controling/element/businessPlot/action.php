<?php

require_once 'library/jpgraph/src/jpgraph.php';
require_once 'library/jpgraph/src/jpgraph_line.php';

// INIT
// - core
$objCore = Schmolck_Framework_Core::getInstance($this);
$objHelper = new Controling_Helper($objCore);
$arrBusiness = $objHelper->getBusinessOverview();

//print_r($objCore->arrBusiness[0]);
//exit();

$datay1 = $arrBusiness[0];
$datay2 = $arrBusiness[1];
$datay3 = $arrBusiness[2];
$datay4 = $arrBusiness[3];
$datay5 = $arrBusiness[4];

// Setup the graph
$graph = new Graph(640, 400);
$graph->SetScale("textlin");

$theme_class = new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
//$graph->title->Set('Aufträge pro Filiale');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels(array('2013', '2014', '2015', '2016'));
$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor(FILIALE_COLOR_01);
$p1->SetLegend('01');

// Create the second line
$p2 = new LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor(FILIALE_COLOR_02);
$p2->SetLegend('02');

// Create the third line
$p3 = new LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor(FILIALE_COLOR_03);
$p3->SetLegend('03');

$p4 = new LinePlot($datay4);
$graph->Add($p4);
$p4->SetColor(FILIALE_COLOR_04);
$p4->SetLegend('04');

$p5 = new LinePlot($datay5);
$graph->Add($p5);
$p5->SetColor(FILIALE_COLOR_05);
$p5->SetLegend('05');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();
exit();