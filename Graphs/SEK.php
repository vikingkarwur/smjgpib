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

$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam WHERE fam_NamaSek!='' ORDER BY fam_NamaSek ASC";
$sSek = RunQuery($sSQL);
$Sek = mysql_num_rows($sSek);

//$sSQL = "SELECT * FROM person_per LEFT JOIN family_fam ON  family_fam.fam_ID = person_per.per_fam_ID WHERE fam_NamaSek=''";
$sSQL = "SELECT * FROM person_per LEFT JOIN family_fam ON  family_fam.fam_ID = person_per.per_fam_ID WHERE fam_NamaSek!='' AND per_cls_ID=1";
//$sSQL = "SELECT * FROM family_fam WHERE fam_NamaSek=\"III\"";
$sTotalJiwaAllSek = RunQuery($sSQL);
$TotalJiwaAllSek = mysql_num_rows($sTotalJiwaAllSek);
//$Seklist = mysql_num_rows($sSeklist);
//while ($data1=mysql_fetch_array($sTotalJiwaAllSek)) {
//echo ("$TotalJiwaAllSek<br>");
//echo ("<a href='../FamilyView.php?FamilyID=$data1[fam_ID]'>$data1[fam_Name]</a>");
//}
//exit;
$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam WHERE fam_NamaSek!=''";
$sTotalSek = RunQuery($sSQL);
$TotalSek = mysql_num_rows($sTotalSek);

$n=0;
$Balik=$TotalSek-1;
while ($Hasil=mysql_fetch_array($sSek)) {
	
	$NamaSek=$Hasil[fam_NamaSek];
	//echo $Hasil[fam_NamaSek];
	$sSQL = "SELECT * FROM person_per LEFT JOIN family_fam ON  family_fam.fam_ID = person_per.per_fam_ID WHERE fam_NamaSek='$NamaSek' AND per_cls_ID=1";
    $sTotalJemaatSek = RunQuery($sSQL);
    $TotalJemaatSek = mysql_num_rows($sTotalJemaatSek);
	$Totals1= $TotalJiwaAllSek;
    $totals[$Balik] = $TotalJemaatSek / $Totals1 * 100; 
	$BPK[$n] = "SP($NamaSek $TotalJemaatSek JW)";
	$n++;
	$Balik=$Balik-1;
	}
	
// JPGraph seems to be fixed.. no longer needed
// setlocale(LC_ALL, 'C');

// Include JPGraph library and the bar graph drawing module
LoadLib_JPGraph(pie,pie3d);

// Start Graphing ---------------------------->

// Create the graph.
$graph = new PieGraph(325,260);
//$graph->SetShadow();

// Set A title for the plot
$graph->title->Set(gettext("Grafik Persentase Sektor"));
$graph->title->SetFont(FF_FONT1,FS_BOLD,10);
$graph->title->SetColor("darkblue");
$graph->legend->Pos(0.02,0.15);

// Create the bar plot
$p1 = new PiePlot3d($totals) ;
$p1->SetTheme("sand");
$p1->SetCenter(0.240);
$p1->SetSize(50);

// Adjust projection angle
$p1->SetAngle(90);

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