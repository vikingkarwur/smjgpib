<?php
/*******************************************************************************
*
*  filename    : Reports/DirectoryReport.php
*  last change : 2003-08-30
*  description : Creates a Member directory
*
*  http://www.infocentral.org/
*  Copyright 2003  Jason York
*
*  InfoCentral is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
******************************************************************************/

require "../Include/Config.php";
require "../Include/Functions.php";
require "../Include/ReportConfig.php";
require "../Include/ReportFunctions.php";


// Load the FPDF library
LoadLib_FPDF();

class PDF_Directory extends FPDF {

	// Private properties
	var $_Margin_Left = 0;         // Left Margin
	var $_Margin_Top  = 0;         // Top margin
	var $_Char_Size   = 12;        // Character size
	var $_CurLine     = 0;
	var $_Column      = 0;
	var $_Font        = "Times";
	var $sFamily;
	var $sLastName;

	function Header()
	{
		global $bDirUseTitlePage;
		global $fam_Name;

		if (($this->PageNo() > 1) || ($bDirUseTitlePage == false))
		{
			global $sChurchName;
			//Select Arial bold 15
			$this->SetFont($this->_Font,'B',15);
			//Line break
			$this->Ln(7);
			//Move to the right
			$this->Cell(10);
			//Framed title
			$this->Cell(190,10,$sChurchName . " - " . gettext("Kartu keluarga " . $fam_Name),1,0,'C');
		}
	}

	function Footer()
	{
		global $bDirUseTitlePage;

		if (($this->PageNo() > 1) || ($bDirUseTitlePage == false))
		{
			//Go to 1.7 cm from bottom
			$this->SetY(-17);
			//Select Arial italic 8
			$this->SetFont($this->_Font,'I',8);
			//Print centered page number
			$iPageNumber = $this->PageNo();
			if ($bDirUseTitlePage)
				$iPageNumber--;
			$this->Cell(0,10, gettext("Halaman") . " " . $iPageNumber,0,0,'C');
		}
	}

	function TitlePage()
	{
		global $sChurchName;
		global $sDirectoryDisclaimer;
		global $sChurchAddress;
		global $sChurchCity;
		global $sChurchState;
		global $sChurchZip;
		global $sChurchPhone;
		global $bDirLetterHead;
		global $fam_ID;
		global $fam_Name;
		global $fam_Address1;
		global $fam_Kompleks1;
		global $fam_RTRW1;
		global $fam_Kelurahan1;
		global $fam_City;
		global $fam_State;
		global $fam_Zip;
		global $fam_Country;
		global $fam_HomePhone;
		global $fam_NamaSek;
		global $fam_NoIndFam;

		//Select Arial bold 15
		$this->SetFont($this->_Font,'B',20);

		if (is_readable($bDirLetterHead))
			$this->Image($bDirLetterHead,10,5,190);

		//Line break
		$this->Ln(5);
		//Move to the right
		$this->MultiCell(197,10,"\n" . gettext("Kartu Keluarga") . "\n",0,'C');
		$this->Ln(30);
		$this->SetFont($this->_Font,'B',36);
		$this->MultiCell(197,10,"Keluarga " . $fam_Name,0,'C');
		$this->SetFont($this->_Font,'B',14);
		$this->Ln(5);
		$this->MultiCell(197,6,"Nomer Induk: " . $fam_NoIndFam . "." . $fam_NamaSek,0,'C');
		$this->MultiCell(197,6,"Sektor Pelayanan: " . $fam_NamaSek,0,'C');
		$this->Ln(10);
		$this->SetFont($this->_Font,'B',10);
		$this->MultiCell(197,5,$fam_Address1,0,'C');
		$this->MultiCell(197,5,$fam_Kompleks1,0,'C');
		$this->MultiCell(197,5,"RT/RW: " .$fam_RTRW1,0,'C');
		$this->MultiCell(197,5,$fam_Kelurahan1 . " " . $fam_City . ", " . $fam_State,0,'C');
		$this->MultiCell(197,5,$fam_Country . " " . $fam_Zip,0,'C');
		$this->Ln(75);
		$today = date("F j, Y");
		$this->MultiCell(197,10,$today . "\n\n",0,'C');
		$this->Ln(5);
		$this->SetFont($this->_Font,'B',24);
		$this->MultiCell(197,8,"Gereja Protestan di Indonesia bagian Barat\n". $sChurchName . "\n",4,'C');
		$this->SetFont($this->_Font,'B',14);
		$sContact = sprintf("%s\n%s, %s  %s\n%s\n\n", $sChurchAddress, $sChurchCity, $sChurchState, $sChurchZip, $sChurchPhone);
		$this->MultiCell(197,6,$sContact,0,'C');
		$this->Ln(5);

		//Select Arial 12
		$this->SetFont($this->_Font,'',8);

		$this->MultiCell(197,2,$sDirectoryDisclaimer,0,'C');

		$sDirImageFam = "..\\Images\\Family\\thumbnails\\" . $fam_ID . ".jpg";
		if (is_readable($sDirImageFam))
				$this->Image($sDirImageFam,68,120,60);

		$this->AddPage();
	}

	function Pengesahan($aName, $aNoInd, $aFamRole) {
		$this->AddPage();
		$this->Ln(5);
		//Move to the right
		$this->SetFont($this->_Font,'B',20);
		$this->MultiCell(197,10,"\n" . gettext("Lembar Pengesahan") . "\n",0,'C');
		$_PosX = $this->_Margin_Left+(0);
		$_PosY = $this->_Margin_Top+(9*5);
		$this->SetXY($_PosX, $_PosY);
		$this->SetFont($this->_Font,'B',12);
		$this->MultiCell(110,7, gettext($aName),1,'J');
		$_PosX = $this->_Margin_Left+(110);
		$_PosY = $this->_Margin_Top+(9*5);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(30,7, gettext($aNoInd),1,'J');
		$_PosX = $this->_Margin_Left+(140);
		$_PosY = $this->_Margin_Top+(9*5);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(40,7, gettext($aFamRole),1,'J');
		$this->SetFont($this->_Font,'',12);
		$_PosX = $this->_Margin_Left+(0);
		$_PosY = $this->_Margin_Top+(200);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(50, 7, 'Majelis Jemaat GPIB Petra', 0,'C');
		$_PosX = $this->_Margin_Left+(55);
		$_PosY = $this->_Margin_Top+(200);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(55, 7, 'Kordinator Sektor Pelayanan', 0,'C');
		$_PosX = $this->_Margin_Left+(115);
		$_PosY = $this->_Margin_Top+(200);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(65, 7, 'Bogor, ......................20......', 0,'C');
		$_PosX = $this->_Margin_Left+(0);
		$_PosY = $this->_Margin_Top+(200 + 5);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(50, 7, 'Sekretaris,', 0,'C');
		$_PosX = $this->_Margin_Left+(55);
		$_PosY = $this->_Margin_Top+(200 + 5);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(55, 7, '', 0,'C');
		$_PosX = $this->_Margin_Left+(115);
		$_PosY = $this->_Margin_Top+(200 + 5);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(65, 7, 'Kepala keluarga/yang bersangkutan', 0,'C');
		$_PosX = $this->_Margin_Left+(0);
		$_PosY = $this->_Margin_Top+(205 + 35);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(50, 7, '(_____________________)', 0,'C');
		$_PosX = $this->_Margin_Left+(55);
		$_PosY = $this->_Margin_Top+(205 + 35);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(55, 7, '(_____________________)', 0,'C');
		$_PosX = $this->_Margin_Left+(115);
		$_PosY = $this->_Margin_Top+(205 + 35);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(65, 7, '(_____________________)', 0,'C');
	}
	// Sets the character size
	// This changes the line height too
	function Set_Char_Size($pt) {
		if ($pt > 3) {
			$this->_Char_Size = $pt;
			$this->SetFont($this->_Font,'',$this->_Char_Size);
		}
	}

	// Constructor
	function PDF_Directory() {
		global $paperFormat;
		parent::FPDF("P", "mm", $paperFormat);

		$this->_Column      = 0;
		$this->_CurLine     = 2;
		$this->_Font        = "Times";
		$this->SetMargins(0,0);
		$this->Open();
		$this->Set_Char_Size(12);
		$this->AddPage();
		$this->SetAutoPageBreak(false);

		$this->_Margin_Left = 12;
		$this->_Margin_Top  = 12;
	}

	function Check_Lines($numlines)
	{
		$CurY = $this->GetY();  // Temporarily store off the position

		// Need to determine if we will extend beyoned 17mm from the bottom of
		// the page.
		$this->SetY(-17);
		if ($this->_Margin_Top+(($this->_CurLine+$numlines)*5) > $this->GetY())
		{
			$this->_CurLine = 2;
			$this->AddPage();
		}
		$this->SetY($CurY); // Put the position back
	}

	function Print_Name($sName)
	{
		$this->SetFont($this->_Font,'B',12);
		$_PosX = $this->_Margin_Left+(0);
		$_PosY = $this->_Margin_Top+($this->_CurLine*5);
		$this->SetXY($_PosX, $_PosY);
		$this->Write(5, $sName);
		$this->SetFont($this->_Font,'',$this->_Char_Size);
		$this->_CurLine++;
	}

	// Number of lines is only for the $text parameter
	function Add_Record($sTitle, $text, $numlines)
	{
		$_PosX = $this->_Margin_Left+(0);
		$_PosY = $this->_Margin_Top+($this->_CurLine*5);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(64, 5, $sTitle);
		$_PosX = $this->_Margin_Left+(65);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(3, 5, ":");
		$_PosX = $this->_Margin_Left+(68);
		$this->SetXY($_PosX, $_PosY);
		$this->MultiCell(200, 5, $text);
		$this->_CurLine += $numlines;
	}


}

$sSQL = "Select * from infojemaat";
$sinfojemaat = mysql_fetch_array(RunQuery($sSQL));
extract($sinfojemaat);

if (FilterInput($_POST["Family"]) != "") { $sFamilyID = FilterInput($_POST["Family"]); } ;
if (FilterInput($_GET["Family"],'int') != "") { $sFamilyID = FilterInput($_GET["Family"],'int'); };
$sChurchName = $NamaJemaat;
// $sDirectoryDisclaimer = FilterInput($_POST["sDirectoryDisclaimer"]);
$sChurchAddress = $AlamatJemaat;
$sChurchCity = $KotaJemaat;
$sChurchState = $StateJemaat;
$sChurchZip = $ZipJemaat;
$sChurchPhone = $PhoneJemaat;

$bDirUseTitlePage = isset($_POST["bDirUseTitlePage"]);
if (isset($_GET["bDirUseTitlePage"]) != "") { $bDirUseTitlePage = isset($_GET["bDirUseTitlePage"]); };


// Instantiate the directory class and build the report.
$pdf = new PDF_Directory();

// Get Family Data
$sSQL = "SELECT * from family_fam where fam_ID = ". $sFamilyID;

$rsFamily = RunQuery($sSQL);
$aRow = mysql_fetch_array($rsFamily);
extract($aRow);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom on person_custom.per_ID = person_per.per_ID where per_fam_ID = " . $sFamilyID . " order by per_fmr_ID";
$rsPersonInFam = RunQuery($sSQL);

if ($bDirUseTitlePage) $pdf->TitlePage();

while ($aPersonInFam = mysql_fetch_array($rsPersonInFam)) {
	extract($aPersonInFam);
	$sName = $per_LastName . ", " . $per_FirstName . " " . $per_MiddleName;
	$aName .= $sName . "\n";

	$numlines++; // add an extra blank line after record
	$pdf->Check_Lines(30);

	$pdf->Print_Name($sName);

	$PosX = $pdf->_Margin_Left + 163;
	$PosY = $pdf->_Margin_Top + ($pdf->_CurLine - 1) * 5;

	$sDirImagePer = "..\\Images\\Person\\thumbnails\\" . $per_ID . ".jpg";
	if (is_readable($sDirImagePer))
			$pdf->Image($sDirImagePer,$PosX,$PosY,25);

	$sTitle = "No. Induk";
	$sValue = $fam_NoIndFam . "-" . $per_NoIndJem . "." . $fam_NamaSek;
	$aNoInd .= $sValue . "\n";
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Tempat/Tanggal Lahir";
	if ($per_BirthPlace == "") { $per_BirthPlace = "____________"; };
	if ($per_BirthDay == 0) { $per_BirthDay = "___"; };
	if (!is_null($per_BirthMonth)) { $per_BirthMonth = date("F", mktime(0, 0, 0, ($per_BirthMonth + 1), 0, 0)); };
	if ($per_BirthMonth == "0") { $per_BirthMonth = "___"; };
	if ($per_BirthYear == "") { $per_BirthYear = "___"; };
	$sValue = $per_BirthPlace . " / " . $per_BirthDay . " - " . $per_BirthMonth . " - " . $per_BirthYear;
	$pdf->Add_Record($sTitle, $sValue, 1);

	if(!is_null($per_Email) and $per_Email != "") {
		$sTitle = "Email";
		$sValue = $per_Email;
		$pdf->Add_Record($sTitle, $sValue, 1);
	}

	if(!is_null($per_CellPhone) and $per_CellPhone != "") {
		$sTitle = "Handphone";
		$sValue = $per_CellPhone;
		$pdf->Add_Record($sTitle, $sValue, 1);
	}

	$sTitle = "Hubungan Keluarga";
	if ($per_fmr_ID == 0) { $sValue = "________________"; }
	else {
		$sSQL = "SELECT lst_OptionName from list_lst where lst_ID = \"2\" and lst_OptionID = \"" . $per_fmr_ID . "\"";
		$rsFamRule = RunQuery($sSQL);
		$aFamRule = mysql_fetch_array($rsFamRule);
		extract($aFamRule);
		$sValue = $lst_OptionName;
	}
	$aFamilyRole .= $sValue . "\n";
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Jenis Kelamin";
	if ($per_Gender == 1) { $sValue = "Laki-laki"; }
	elseif ($per_Gender == 2) { $sValue = "Perempuan"; }
	else { $sValue = "-"; };
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Tempat/Tanggal Baptis";
	if ($c2 == "true" or $c2 == "") {
		if ($c23 == "" or $c2 == "") { $c23 = "____________";}
		if ($c3 == "" or $c2 == "") { $sDate = "___ - ___ - ______"; }
		else {
			ereg("(....)-(..)-(..)", $c3, $aDate);
			$sDate = date("j - F - Y", mktime(0, 0, 0, $aDate[2], $aDate[3], $aDate[1]));
		};
		$sValue = $c23 . " / " . $sDate;
		if ($c2 == "") { $sValue .= " / Belum dibaptis"; };
	} else { $sValue = "Belum dibaptis"; };
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Tempat/Tanggal Sidi";
	if ($c4 == "true" or $c4 == "") {
		if ($c24 == "" or $c4 == "") { $c24 = "____________";}
		if ($c5 == "" or $c4 == "") { $sDate = "___ - ___ - ______"; }
		else {
			ereg("(....)-(..)-(..)", $c5, $aDate);
			$sDate = date("j - F - Y", mktime(0, 0, 0, $aDate[2], $aDate[3], $aDate[1]));
		};
		$sValue = $c24 . " / " . $sDate;
		if ($c4 == "") { $sValue .= " / Belum disidi"; };
	} else { $sValue = "Belum disidi"; };
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Tempat/Tanggal Pernikahan Gereja";
	if ($c16 == "2" or $c16 == "" or $c16 == "4" or $c16 == "3") {
		if ($c25 == "" or $c16 == "") { $c25 = "____________";}
		if ($c7 == "" or $c16 == "") { $sDate = "___ - ___ - ______"; }
		else {
			ereg("(....)-(..)-(..)", $c7, $aDate);
			$sDate = date("j - F - Y", mktime(0, 0, 0, $aDate[2], $aDate[3], $aDate[1]));
		};
		$sValue = $c25 . " / " . $sDate;
		if ($c16 == "") { $sValue .= " / Belum pernikahan di Gereja"; };
	 	if ($c16 == "4") { $sValue .= " (Duda)"; }
		elseif ($c16 == "3") { $sValue .= " (Janda)"; };
	} else { $sValue = "Belum menikah"; };
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Tempat/Tanggal Catatan Sipil";
	if ($c16 == "2" or $c16 == "" or $c16 == "4" or $c16 == "3") {
		if ($c30 == "" or $c16 == "") { $c30 = "____________";}
		if ($c31 == "" or $c16 == "") { $sDate = "___ - ___ - ______"; }
		else {
			ereg("(....)-(..)-(..)", $c31, $aDate);
			$sDate = date("j - F - Y", mktime(0, 0, 0, $aDate[2], $aDate[3], $aDate[1]));
		};
		$sValue = $c30 . " / " . $sDate;
		if ($c16 == "") { $sValue .= " / Belum catatan sipil"; };
	 	if ($c16 == "4") { $sValue .= " (Duda)"; }
		elseif ($c16 == "3") { $sValue .= " (Janda)"; };
	} else { $sValue = "Belum menikah"; };
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Pendidikan Terakhir";
	if (is_null($c18)) { $sValue = "________________"; }
	else {
		$sSQL = "SELECT lst_OptionName from list_lst where lst_ID = \"28\" and lst_OptionID = \"" . $c18 . "\"";
		$rsLastEdu = RunQuery($sSQL);
		$aLastEdu = mysql_fetch_array($rsLastEdu);
		extract($aLastEdu);
		$sValue = $lst_OptionName;
	}
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Pekerjaan Terakhir";
	if (is_null($c17)) { $sValue = "________________"; }
	else {
		$sSQL = "SELECT lst_OptionName from list_lst where lst_ID = \"27\" and lst_OptionID = \"" . $c17 . "\"";
		$rsLastEdu = RunQuery($sSQL);
		$aLastEdu = mysql_fetch_array($rsLastEdu);
		extract($aLastEdu);
		$sValue = $lst_OptionName;
	}
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Terdaftar di Jemaat sejak";
	if (!is_null($per_MembershipDate)) {
		ereg("(....)-(..)-(..)", $per_MembershipDate, $aDate);
		$sValue = date("j - F - Y", mktime(0, 0, 0, $aDate[2], $aDate[3], $aDate[1]));
	} else {
		ereg("(....)-(..)-(..)", $fam_MembershipDate, $aDate);
		$sValue = date("j - F - Y", mktime(0, 0, 0, $aDate[2], $aDate[3], $aDate[1]));
	}
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Hobby/Ketrampilan";
	if (is_null($c22)) { $sValue = "________________"; }
	else {
		$sValue = $c22;
	}
	$pdf->Add_Record($sTitle, $sValue, 1);

	$sTitle = "Pengalaman Gerejawi";
	if (is_null($c20)) { $sValue = "________________________________________________ \n________________________________________________\n________________________________________________\n________________________________________________\n________________________________________________ "; }
	else {
		$sValue = $c20;
	}
	$pdf->Add_Record($sTitle, $sValue, 5);

	$sTitle = "Pengalaman Non-Gerejawi";
	if (is_null($c28)) { $sValue = "________________________________________________ \n________________________________________________\n________________________________________________\n________________________________________________\n________________________________________________ "; }
	else {
		$sValue = $c28;
	}
	$pdf->Add_Record($sTitle, $sValue, 5);

	$sTitle = "Program Pembinaan yang pernah diikuti";
	if (is_null($c27)) { $sValue = "________________________________________________ \n________________________________________________\n________________________________________________\n________________________________________________\n________________________________________________ "; }
	else {
		$sValue = $c27;
	}
	$pdf->Add_Record($sTitle, $sValue, 6);

}

$pdf->Pengesahan($aName, $aNoInd, $aFamilyRole);

if ($iPDFOutputType == 1)
	$pdf->Output("KK-". $fam_Name . "-" . date("Ymd") . ".pdf", true);
else
	$pdf->Output();
?>

