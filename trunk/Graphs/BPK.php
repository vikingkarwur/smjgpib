<?php
/*******************************************************************************
 *
 *  filename    : Graphs/BPK.php
 *  last change : 2004-10-01
 *  description : Menampilkan Grafik pie3D
 *
 *  http://smjgpib.gpib.org/
 *  Copyright 2004 Litbang GPIB
 *
 *  smjGPIB dibuat oleh sebuah team sukarelawan yang dikoordinasikan oleh
 *  Departement Litbang Sinode GPIB untuk dipakai oleh Jemaat-jemaat GPIB. 
 *  Jemaat selain GPIB dapat memakai smjGPIB karena smjGPIB dibuat dibawah
 *  Licence GPL yang sifatnya Free dan OpenSource. Siapapun dapat merubah/
 *  mengembangkan/memakai smjGPIB diluar GPIB. Khusus untuk Jemaat GPIB 
 *  dianjurkan untuk memakai smjGPIB yang terakhir dikeluarkan oleh Departemen 
 *  Litbang Sinode GPIB agar terjadi keseragaman data di seluruh Jemaat GPIB
 *
 ******************************************************************************/

require "../Include/Config.php";
require "../Include/Functions.php";
require "../Include/ReportFunctions.php";

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) > CURDATE() AND per_cls_ID=1";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) > CURDATE() AND per_cls_ID=1";
$sPA = RunQuery($sSQL);
$PA = mysql_num_rows($sPA);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_cls_ID=1 AND c16=1";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_cls_ID=1";
$sPT = RunQuery($sSQL);
$PT = mysql_num_rows($sPT);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_cls_ID=1 AND c16=1";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_cls_ID=1 AND c16=1";
$sGP = RunQuery($sSQL);
$GP = mysql_num_rows($sGP);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2) AND per_cls_ID=1";//$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_cls_ID=1 AND per_Gender = 2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2) AND (c16=1 OR per_Gender=2)";
//$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2) AND per_cls_ID=1";
$sPW = RunQuery($sSQL);
$PW = mysql_num_rows($sPW);

//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 2";
//$sPW = RunQuery($sSQL);
//$PW = mysql_num_rows($sPW);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=1 OR (c16=2 AND per_Gender=1) OR (c16=4 AND per_Gender=1) AND per_cls_ID=1";
//$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=1 OR (c16=2 AND per_Gender=1) OR (c16=4 AND per_Gender=1) AND per_cls_ID=1";
$sPKB = RunQuery($sSQL);
$PKB = mysql_num_rows($sPKB);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 60 YEAR) <= CURDATE() AND per_cls_ID=1";
//$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 60 YEAR) <= CURDATE() AND per_cls_ID=1";
$sLAN = RunQuery($sSQL);
$LAN = mysql_num_rows($sLAN);

//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 1";
//$sPKB = RunQuery($sSQL);
//$PKB = mysql_num_rows($sPKB);

$Totals = $PKB + $PW + $GP + $PT + $PA;

//$totals[5] = $LAN / $Totals * 100; 
$totals[4] = $PKB / $Totals * 100; 
$totals[3] = $PW / $Totals * 100;
$totals[2] = $GP / $Totals * 100;
$totals[1] = $PT / $Totals * 100;
$totals[0] = $PA / $Totals * 100;

//$totals[0] = $PKB / $Totals * 100; 
//$totals[1] = $PW / $Totals * 100;
//$totals[2] = $GP / $Totals * 100;
//$totals[3] = $PT / $Totals * 100;
//$totals[4] = $PA / $Totals * 100;
//$totals[5] = $LAN / $Totals * 100; 

$BPK[0] = "PKB ($PKB org)";
$BPK[1] = "PW ($PW org)";
$BPK[2] = "GP ($GP org)";
$BPK[3] = "PT ($PT org)";
$BPK[4] = "PA ($PA org)";
//$BPK[5] = "LAN ($LAN orang)";

// JPGraph seems to be fixed.. no longer needed
// setlocale(LC_ALL, 'C');

// Include JPGraph library and the bar graph drawing module
LoadLib_JPGraph(pie,pie3d);

// Start Graphing ---------------------------->

// Create the graph.
$graph = new PieGraph(285,160);
//$graph->SetShadow();

// Set A title for the plot
$graph->title->Set(gettext("Persentase BPK:"));
$graph->title->SetFont(FF_FONT1,FS_BOLD,16);
$graph->title->SetColor("darkblue");
$graph->legend->Pos(0.02,0.15);

// Create the bar plot
$p1 = new PiePlot3d($totals) ;
$p1->SetTheme("sand");
$p1->SetCenter(0.240);
$p1->SetSize(50);

// Adjust projection angle
$p1->SetAngle(45);

// Adjsut angle for first slice
$p1->SetStartAngle(315);

// As a shortcut you can easily explode one numbered slice with
//$p1->ExplodeSlice(1);

// Use absolute values (type==1)
$p1->SetLabelType(PIE_VALUE_ABS);

// Display the slice values
//$p1->value->SetFormat('%d');
$p1->value->Show();

// Set font for legend
$p1->value->SetFont(FF_FONT1,FS_NORMAL,12);
$p1->SetLegends($BPK);

// Add the plots to the graph
$graph->Add($p1);

// Display the graph
$graph->Stroke();

?>