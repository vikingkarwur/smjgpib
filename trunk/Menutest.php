<?php
/*******************************************************************************
 *
 *  filename    : statistik.php
 *  last change : 2004-09-16
 *  description : statistik keseluruhan
 *
 *  http://smj.gpib.org/
 *  Copyright 2004 Litbang GPIB
 *
 *  smjGPIB is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation.
 *
 ******************************************************************************/
 
// Include the function library
require "Include/Config.php";
require "Include/Functions.php";
//$acak = rand(1,20);
//$acak1 = "midi/$acak.mid";



//Set the page title
$sSQL = "Select * from infojemaat";
$sinfojemaat = mysql_fetch_array(RunQuery($sSQL));
extract($sinfojemaat);
$sPageTitle = gettext("Statistik Jemaat");

$sSQL = "SELECT per_ID FROM person_per";
$sTotalAll = RunQuery($sSQL);
$TotalAll = mysql_num_rows($sTotalAll);

$sSQL = "SELECT per_ID FROM person_per WHERE per_cls_ID=1";
$sTotal = RunQuery($sSQL);
$Total = mysql_num_rows($sTotal);

$sSQL = "SELECT fam_ID FROM family_fam";
$sTotalKK = RunQuery($sSQL);
$TotalKK = mysql_num_rows($sTotalKK);

$sSQL = "SELECT per_ID FROM person_per WHERE per_gender=1";
$sTotalMaleAll = RunQuery($sSQL);
$TotalMaleAll = mysql_num_rows($sTotalMaleAll);

$sSQL = "SELECT per_ID FROM person_per where per_Gender=1 AND per_cls_ID=1";
$sTotalMale = RunQuery($sSQL);
$TotalMale = mysql_num_rows($sTotalMale);
//male listing
//$sSQL = "SELECT per_ID FROM person_per where per_Gender = 1 AND per_cls_ID=1 ";
//$sTotalMaleListing = RunQuery($sSQL);
//$TotalMale = mysql_num_rows($sTotalMale);

$sSQL = "SELECT per_ID FROM person_per WHERE per_Gender=2";
$sTotalFemaleAll = RunQuery($sSQL);
$TotalFemaleAll = mysql_num_rows($sTotalFemaleAll);

$sSQL = "SELECT per_ID FROM person_per where per_Gender=2 AND per_cls_ID=1";
$sTotalFemale = RunQuery($sSQL);
$TotalFemale = mysql_num_rows($sTotalFemale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) > CURDATE() AND per_cls_ID=1";
$sPA = RunQuery($sSQL);
$PA = mysql_num_rows($sPA);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) > CURDATE() AND per_Gender = 1 AND per_cls_ID=1";
$sPAMale = RunQuery($sSQL);
$PAMale = mysql_num_rows($sPAMale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) > CURDATE() AND per_Gender = 2 AND per_cls_ID=1";
$sPAFemale = RunQuery($sSQL);
$PAFemale = mysql_num_rows($sPAFemale);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_cls_ID=1 AND c16=1";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_cls_ID=1 AND c16=1";
$sPT = RunQuery($sSQL);
$PT = mysql_num_rows($sPT);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_gender=1 AND per_cls_ID=1 AND c16=1";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_Gender = 1 AND per_cls_ID=1 AND c16=1";
$sPTMale = RunQuery($sSQL);
$PTMale = mysql_num_rows($sPTMale);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_gender=2 AND per_cls_ID=1 AND c16=1";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_Gender = 2 AND per_cls_ID=1 AND c16=1";
$sPTFemale = RunQuery($sSQL);
$PTFemale = mysql_num_rows($sPTFemale);

//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_cls_ID=1 AND c16=1";
$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_cls_ID=1 AND c16=1";
//$sSQL = "SELECT * where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE()";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE()";
$sGP = RunQuery($sSQL);
$GP = mysql_num_rows($sGP);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_gender=1 AND per_cls_ID=1 AND c16=1";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_Gender = 1 AND c16=1 AND per_fmr_ID<>0";
$sGPMale = RunQuery($sSQL);
$GPMale = mysql_num_rows($sGPMale);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_gender=2 AND per_cls_ID=1 AND c16=1";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_Gender = 2";
$sGPFemale = RunQuery($sSQL);
$GPFemale = mysql_num_rows($sGPFemale);

//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 2";
//$sPW = RunQuery($sSQL);
//$PW = mysql_num_rows($sPW);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2) AND per_cls_ID=1";//$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_cls_ID=1 AND per_Gender = 2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2) AND (c16=1 OR per_Gender=2)";
//$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2)";
$sPW = RunQuery($sSQL);
$PW = mysql_num_rows($sPW);

//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 1";
//$sPKB = RunQuery($sSQL);
//$PKB = mysql_num_rows($sPKB);
$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=1 OR (c16=2 AND per_Gender=1) OR (c16=4 AND per_Gender=1) AND per_cls_ID=1";
//$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_cls_ID=1 AND per_Gender = 1 OR (c16=2 AND per_Gender=1) OR (c16=3 AND per_Gender=1)";
$sPKB = RunQuery($sSQL);
$PKB = mysql_num_rows($sPKB);

//$sSQL = "SELECT per_ID, CONCAT('<a href=PersonView.php?PersonID=',per_ID,'>',per_FirstName,' ',per_LastName,'</a>') AS Nama FROM person_per, person2group2role_p2g2r WHERE per_ID = p2g2r_per_ID AND p2g2r_grp_ID = 29 AND  p2g2r_rle_ID= 3";
//$sDiaken = RunQuery($sSQL);
//$Diaken = mysql_num_rows($sDiaken);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where c19 LIKE '%diaken%' AND per_cls_ID=1";
$sDiaken = RunQuery($sSQL);
$Diaken = mysql_num_rows($sDiaken);

//$sSQL = "SELECT per_ID, CONCAT('<a href=PersonView.php?PersonID=',per_ID,'>',per_FirstName,' ',per_LastName,'</a>') AS Nama FROM person_per, person2group2role_p2g2r WHERE per_ID = p2g2r_per_ID AND p2g2r_grp_ID = 29 AND  p2g2r_rle_ID= 2";
//$sPenatua = RunQuery($sSQL);
//$Penatua = mysql_num_rows($sPenatua);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where c19 LIKE '%penatua%' AND per_cls_ID=1";
$sPenatua = RunQuery($sSQL);
$Penatua = mysql_num_rows($sPenatua);

//$sSQL = "SELECT per_ID, CONCAT('<a href=PersonView.php?PersonID=',per_ID,'>',per_FirstName,' ',per_LastName,'</a>') AS Nama FROM person_per, person2group2role_p2g2r WHERE per_ID = p2g2r_per_ID AND p2g2r_grp_ID = 29 AND  p2g2r_rle_ID= 1";
//$sPendeta = RunQuery($sSQL);
//$Pendeta = mysql_num_rows($sPendeta);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where c19 LIKE '%pendeta%' AND per_cls_ID=1";
$sPendeta = RunQuery($sSQL);
$Pendeta = mysql_num_rows($sPendeta);

$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam WHERE fam_NamaSek!=''";
$sTotalSek = RunQuery($sSQL);
$TotalSek = mysql_num_rows($sTotalSek);

$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam WHERE fam_NamaSek!='' ORDER BY fam_NamaSek ASC";
$sSek = RunQuery($sSQL);
$Sek = mysql_num_rows($sSek);

$sSQL = "SELECT per_ID FROM person_per where per_Gender = 2 AND per_cls_ID!=1";
$sTotalFemaleNon = RunQuery($sSQL);
$TotalFemaleNon = mysql_num_rows($sTotalFemaleNon);

$sSQL = "SELECT per_ID FROM person_per where per_Gender = 1 AND per_cls_ID!=1";
$sTotalMaleNon = RunQuery($sSQL);
$TotalMaleNon = mysql_num_rows($sTotalMaleNon);

$sSQL = "SELECT per_ID FROM person_per where per_cls_ID!=1";
$sTotalNon = RunQuery($sSQL);
$TotalNon = mysql_num_rows($sTotalNon);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID WHERE per_cls_ID=1 AND per_Gender=1 AND c4='true'";
$sTotalSidiMale = RunQuery($sSQL);
$TotalSidiMale = mysql_num_rows($sTotalSidiMale);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID WHERE per_cls_ID=1 AND per_Gender=2 AND c4='true'";
$sTotalSidiFemale = RunQuery($sSQL);
$TotalSidiFemale = mysql_num_rows($sTotalSidiFemale);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID WHERE per_cls_ID=1 AND c4='true'";
$sTotalSidi = RunQuery($sSQL);
$TotalSidi = mysql_num_rows($sTotalSidi);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID WHERE per_cls_ID=1 AND c4='false'";
$sTotalNonSidi = RunQuery($sSQL);
$TotalNonSidi = mysql_num_rows($sTotalNonSidi);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID WHERE per_cls_ID=1 AND c4='false' AND per_Gender=1";
$sTotalNonSidiMale = RunQuery($sSQL);
$TotalNonSidiMale = mysql_num_rows($sTotalNonSidiMale);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID WHERE per_cls_ID=1 AND c4='false' AND per_Gender=2";
$sTotalNonSidiFemale = RunQuery($sSQL);
$TotalNonSidiFemale = mysql_num_rows($sTotalNonSidiFemale);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID WHERE per_cls_ID=1 AND (c13 NOT LIKE '%Balikpapan%' OR c13='')";
$sTotalLokasiNonBpp = RunQuery($sSQL);
$TotalLokasiNonBpp = mysql_num_rows($sTotalLokasiNonBpp);

//$sSQL = "SELECT DISTINCT from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID";
//$sGoldarah = RunQuery($sSQL);
//$Goldarah = mysql_num_rows($sGoldarah);
//$sSQL = "SELECT * FROM user_usr INNER JOIN person_per ON usr_per_ID = per_ID WHERE per_FirstName = " . $_SESSION['UserFirstName'];
//$sSQL = "SELECT * FROM person_per WHERE per_ID = " . $_SESSION['iUserID'];
//$sUser_ID = RunQuery($sSQL);
//$User_ID = mysql_num_rows($sUser_ID);
//$photo1=Images/Person;
$photo=$_SESSION['iUserID'];
$photoFile="Images/Person/Thumbnails/$photo.jpg";
if (file_exists($photoFile)) {
   $photo1="Images/Person/Thumbnails/$photo.jpg";
   } else {
   $photo1="Images/OS22019.jpg";
   }
$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 60 YEAR) <= CURDATE() AND per_cls_ID=1";
$sLansia = RunQuery($sSQL);
$Lansia = mysql_num_rows($sLansia);

$sSQL = "SELECT DISTINCT c8 from person_custom ORDER BY c8 ASC";
$sGoldarah = RunQuery($sSQL);

?>
<script type="text/javascript">
	var IFrameObj; // our IFrame object

	// Some browser-specific stuff may be unneeded by now..
	// Reportedly, there are some problems with IE 5.0, which I could care less about.
	function AddToCart(person_ID)
	{
		if (!document.createElement) {return true};
		var IFrameDoc;
		var URL = 'RPCdummy.php?mode=CartCounter&AddToPeopleCart=' + person_ID;
		if (!IFrameObj && document.createElement) {
			var tempIFrame=document.createElement('iframe');
			tempIFrame.setAttribute('id','RSIFrame');
			tempIFrame.style.border='0px';
			tempIFrame.style.width='0px';
			tempIFrame.style.height='0px';
			IFrameObj = document.body.appendChild(tempIFrame);

			if (document.frames) {
				// For IE5 Mac
				IFrameObj = document.frames['RSIFrame'];
			}
		}

		if (navigator.userAgent.indexOf('Gecko') !=-1
			&& !IFrameObj.contentDocument) {
			// For NS6
			setTimeout('AddToCart()',10);
			return false;
		}

		if (IFrameObj.contentDocument) {
			// For NS6
			IFrameDoc = IFrameObj.contentDocument;
		} else if (IFrameObj.contentWindow) {
			// For IE5.5 and IE6
			IFrameDoc = IFrameObj.contentWindow.document;
		} else if (IFrameObj.document) {
			// For IE5
			IFrameDoc = IFrameObj.document;
		} else {
			return true;
		}

		IFrameDoc.location.replace(URL);
		return false;
	}

	function updateCartCounter(num)
	{
		var targetElement = document.getElementById('CartCounter');
		targetElement.innerHTML = num;
	}
</script>
 <center>
  <table width="760" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="760" height="493" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr> 
            <td height="3" colspan="3" bgcolor="#FFFFFF"><img src="Images/Spacer.gif" width="1" height="1"></td>
          </tr>
          <tr align="center" bgcolor="#B7DBFF"> 
            <td height="11" colspan="3"> 
              <? require "Include/Header.php"; ?>
            </td>
          </tr>
          <tr> 
            <td height="2" colspan="3" bgcolor="#FFFFCC"><img src="Images/Spacer.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td height="11" colspan="3" bgcolor="#CEEFFF"> <div align="center"><img src="Images/Spacer.gif" width="1" height="1"> 
                <img src="Images/Spacer.gif" width="1" height="1"> </div></td>
          </tr>
          <tr> 
            <td width="35%" align="center" valign="top"> <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF"> 
                  <td width="33%" rowspan="2" align="center"><a href="Menu.php"><img src="Images/gpib_kecil.jpg" alt="KLIK DISINI untuk kembali ke halaman utama" border="0"></a></td>
                  <td width="67%" rowspan="2" align="center"><img src="Images/smj-logo.gif" width="144" height="49"></td>
                </tr>
                <tr bgcolor="#FFFFFF"> </tr>
                <tr valign="middle" bgcolor="#FFFFFF"> 
                  <td colspan="2" align="center" bgcolor="#D5D5FF"> <div align="center"><strong><?php echo gettext("<h5>$NamaJemaat $KotaJemaat</h5>");?></strong></div></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center"><?php echo gettext("$AlamatJemaat");?>&nbsp;<?php echo gettext("$KotaJemaat $ZipJemaat");?>&nbsp;<?php echo gettext("$StateJemaat");?></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center">Telephone : <?php echo gettext("$PhoneJemaat");?></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center">Mupel <?php echo gettext("$NamaMupel");?></td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"><strong><a href="SelectList.php?mode=AnggotaJemaat">Warga 
                    Jemaat </a></strong>: <?php echo gettext($Total); ?> dari 
                    <?php echo gettext($TotalAll); ?> </td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"> <div align="center"> &nbsp;<a href="SelectList.php?mode=NON">(Non 
                      Jemaat: <? echo $TotalNon?>)</a></div></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center">Lokasi luar <?php echo gettext($KotaJemaat); ?> 
                    : <a href="SelectList.php?mode=NONBPP"><?php echo gettext($TotalLokasiNonBpp); ?></a> 
                    Orang </td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"><a href="SelectList.php?mode=AnggotaJemaat1"><strong>Warga 
                    Jemaat Pria</strong></a>:<?php echo gettext($TotalMale); ?> 
                    dari <?php echo gettext($TotalMaleAll); ?> </td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"> <div align="center"> <a href="SelectList.php?mode=MALENON">(Non 
                      Jemaat: <? echo gettext($TotalMaleNon)?>)</a></div></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center"><a href="SelectList.php?mode=AnggotaJemaat2"><strong>Warga 
                    Jemaat Wanita</strong></a>: <?php echo gettext($TotalFemale); ?> 
                    dari <?php echo gettext($TotalFemaleAll); ?></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center"> <div align="center"> <a href="SelectList.php?mode=FEMALENON">(Non 
                      Jemaat: <?php echo gettext($TotalFemaleNon); ?>)</a></div></td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"><a href="SelectList.php?mode=family"><strong>Jumlah 
                    KK</strong> </a> : <?php echo gettext($TotalKK); ?></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center"><strong>Warga Sidi</strong> : 
                    <a href="SelectList.php?mode=SIDI"><? echo gettext($TotalSidi);?></a> 
                    (Non Sidi <a href="SelectList.php?mode=NONSIDI"><? echo gettext($TotalNonSidi); ?></a>)</td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center">Pria <a href="SelectList.php?mode=SIDIMALE"><? echo gettext($TotalSidiMale); ?></a> 
                    (<a href="SelectList.php?mode=NONSIDIMALE"><? echo gettext($TotalNonSidiMale); ?></a>)/ 
                    &nbsp;Wanita <a href="SelectList.php?mode=SIDIFEMALE"><? echo gettext($TotalSidiFemale); ?></a> 
                    (<a href="SelectList.php?mode=NONSIDIFEMALE"><? echo gettext($TotalNonSidiFemale); ?></a>)</td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td height="19" colspan="2" align="center"> <table width="99%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="31%" align="center"><a href="SelectList.php?mode=PENDETA"><strong>Pendeta</strong></a>: 
                          <?php echo gettext($Pendeta); ?></td>
                        <td width="40%" align="center"><a href="SelectList.php?mode=PENATUA"><strong>Penatua</strong></a>: 
                          <?php echo gettext($Penatua); ?> </td>
                        <td width="29%" align="center"><a href="SelectList.php?mode=DIAKEN"><strong>Diaken</strong></a>: 
                          <?php echo gettext($Diaken); ?></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
              <div align="center"> </div></td>
            <td width="38%" align="center" valign="top"> <a href="SelectList.php?mode=PW"></a><a href="SelectList.php?mode=GP"></a> 
              <a href="SelectList.php?mode=PKB"></a> <table width="75%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="3"><img src="Images/Spacer.gif" width="1" height="1"></td>
                </tr>
              </table>
              <table width="99%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td align="center" bgcolor="#CCFFFF"><strong>BIDANG-BIDANG PELAYANAN 
                    KATEGORIAL</strong></td>
                </tr>
              </table>
              <? if(isset($_GET['graphs'])){ 
	 $mode="text"; ?>
              <table width="99%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td align="center" bgcolor="#CCFFFF"><font size="1"><? echo "<a href='Menu.php?$mode'>view 
					$mode mode</a>";?></font></td>
                </tr>
              </table>
              <?
	echo" <img src='Graphs/BPK.php'><br><br><img src='Graphs/Bpkbar.php'>";
	} else { 
    $mode="graphs";
	?>
              <table width="99%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
                <tr align="center" bgcolor="#CCFFFF"> 
                  <td colspan="2"><font size="1"><? echo "<a href='Menu.php?$mode'>view 
					$mode mode</a>";?></font></td>
                </tr>
                <tr align="center"> 
                  <td width="24%"><a href="SelectList.php?mode=PA"><img src="Images/PAlogo.jpg" alt="PA" border="0"></a></td>
                  <td width="76%" align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td align="center" bgcolor="#BBFFBB"><a href="SelectList.php?mode=PA"><strong>PELAYANAN 
                          ANAK</strong></a> : <?php echo gettext($PA); ?> Anak</td>
                      </tr>
                      <tr> 
                        <td align="center" bgcolor="#CCFFCC">(Pria <?php echo gettext($PAMale); ?> 
                          / Wanita <?php echo gettext($PAFemale); ?>)</td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center"> 
                  <td><a href="SelectList.php?mode=PT"><img src="Images/PTlogo.jpg" alt="PT" border="0"></a></td>
                  <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td align="center" bgcolor="#FFFF97"><a href="SelectList.php?mode=PT"><strong>PERSEKUTUAN</strong> 
                          <strong>TERUNA</strong></a> : <?php echo gettext($PT); ?> 
                          Orang</td>
                      </tr>
                      <tr> 
                        <td align="center" bgcolor="#FFFFC1">(Pria <?php echo gettext($PTMale); ?> 
                          / Wanita <?php echo gettext($PTFemale); ?>)</td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center"> 
                  <td><a href="SelectList.php?mode=GP"><img src="Images/GPlogo.jpg" alt="GP" border="0"></a></td>
                  <td align="center"><a href="SelectList.php?mode=PW"></a> <table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td align="center" bgcolor="#6F6FFF"><a href="SelectList.php?mode=GP"><strong>GERAKAN 
                          PEMUDA</strong></a> : <?php echo gettext($GP); ?> Orang<a href="SelectList.php?mode=GP"></a> 
                        </td>
                      </tr>
                      <tr> 
                        <td align="center" bgcolor="#A8A8FF">(Pria <?php echo gettext($GPMale); ?> 
                          / Wanita <?php echo gettext($GPFemale); ?>) </td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center"> 
                  <td><a href="SelectList.php?mode=PW"><img src="Images/PWlogo.jpg" alt="PW" border="0"></a></td>
                  <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td align="center" bgcolor="#BB00BB"><a href="SelectList.php?mode=PW"><strong>PERSATUAN 
                          WANITA</strong></a></td>
                      </tr>
                      <tr> 
                        <td align="center" bgcolor="#FF6CFF"><?php echo gettext($PW); ?> 
                          Orang</td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center"> 
                  <td><a href="SelectList.php?mode=PKB"><img src="Images/PKBlogo.jpg" alt="PKB" border="0"></a></td>
                  <td align="center"><a href="SelectList.php?mode=PKB"></a> <table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td align="center" bgcolor="#A8A8A8"><a href="SelectList.php?mode=PKB"><strong>PERSEKUTUAN 
                          KAUM BAPAK</strong></a></td>
                      </tr>
                      <tr> 
                        <td align="center" bgcolor="#D1D1D1"><?php echo gettext($PKB); ?> 
                          Orang</td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center"> 
                  <td>&nbsp;</td>
                  <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td align="center" bgcolor="#FF9595"><a href="SelectList.php?mode=SENIOR"><strong>LANJUT 
                          USIA </strong></a>: <? echo gettext($Lansia); ?></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
            <? } ?>
            <td width="27%" align="center" valign="top"> <table width="75%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td height="3"><img src="Images/Spacer.gif" width="1" height="1"></td>
                </tr>
              </table>
              <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="29" align="center" bgcolor="#B3E7FF">Selamat Datang 
                    !!!</td>
                  <td width="22%" rowspan="2" align="center" valign="middle" bgcolor="#B3E7FF"><a href="<? echo"$photo1"; ?>" target="_blank"><img src="<? echo"$photo1"; ?>" width="40" height="52" border="0"></a></td>
                </tr>
                <tr> 
                  <td width="78%" height="24" align="center" bgcolor="#66CCFF"><b><?php echo $_SESSION['UserFirstName'] . " " . $_SESSION['UserLastName']; ?></b></td>
                </tr>
                <tr> 
                  <td colspan="2" align="center" bgcolor="#BBE9FF">Versi smjGPIB</td>
                </tr>
                <tr> 
                  <td colspan="2" align="center" bgcolor="#66CCFF"><b><?php echo gettext("$sVersi");?></b></td>
                </tr>
                <tr> 
                  <td height="2" colspan="2" bgcolor="#FFFFFF"><img src="Images/Spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td height="19" colspan="2" align="center" bgcolor="#66CCFF"><strong>Ulang 
                    Tahun</strong> : 
                    <?php $TGL=DATE(d); $BLN=DATE(F);$THN=DATE(Y);echo "$TGL $BLN $THN";?>
                  </td>
                </tr>
                <tr> 
                  <td height="2" colspan="2" align="center" bgcolor="#FFFFCC"><img src="Images/Spacer.gif" width="1" height="1"></td>
                </tr>
                <tr> 
                  <td height="18" colspan="2" align="center" bgcolor="#BBE9FF"> 
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <?php
//Female Listing
$Hariini=DATE(d);
$Bulanini=DATE(m);
$Tahunini=DATE(Y);
//echo DATE(Y);
//echo DATE(D);
$SQL = "SELECT * FROM person_per LEFT JOIN family_fam ON  family_fam.fam_ID = person_per.per_fam_ID WHERE per_BirthDay = $Hariini AND per_BirthMonth = $Bulanini AND per_cls_ID=1";
$TotalFemaleListing = mysql_query($SQL);
//$TotalFemaleListing = mysql_num_rows($sTotalFemaleListing);
$n=1;
$No=1;
while ($Hasil=mysql_fetch_array($TotalFemaleListing)) {
       if ($n==1) {
	     //$bg="#BBCCFF";
		 $bg="#BBCCFF";
		 } else {
	     $bg = "#E6F0FF";
		 } ?>
                      <tr bgcolor="<? echo($bg); ?>" onMouseOver="bgColor='#FFFFCC'" onMouseOut="bgColor='<? echo($bg); ?>'" > 
                        <td> 
                          <?			$Ultahke=$Tahunini-$Hasil[per_BirthYear];
			echo ("$No. <a href='PersonView.php?PersonID=$Hasil[per_ID]'>$Hasil[per_FirstName] $Hasil[per_MiddleName] $Hasil[per_LastName]</a> ($Ultahke / $Hasil[fam_NamaSek])");
			$No=$No+1;
			$n++;
			if ($n>2) {
               $n=1; 
	           }			        
?>
                        </td>
                      </tr>
                      <? } ?>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="38" colspan="3" align="center" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr align="center"> 
                  <td bgcolor="#DFDFFF"><? echo "<b> Jumlah Sektor Pelayanan : $TotalSek </b>"; ?></td>
                </tr>
                <tr align="center"> 
                  <td height="9" bgcolor="#CCCCFF"> 
                    <? while ($data=mysql_fetch_array($sSek)) {?>
                    <? 
					 $Sektor1=$data[fam_NamaSek];
					 $sSQL2 = "SELECT * FROM family_fam WHERE fam_NamaSek='$Sektor1'";
                     $sSektor = RunQuery($sSQL2);
                     $Sektor = mysql_num_rows($sSektor); ?>
                    <? echo "<b><a href='../seklist.php?id=$data[fam_NamaSek]'>$data[fam_NamaSek]</b>";
					   if ($Sektor!='') { 
					      echo (" ($Sektor K / ");
					  $sSQL5 = "SELECT * FROM person_per LEFT JOIN family_fam ON  family_fam.fam_ID = person_per.per_fam_ID WHERE fam_NamaSek='$Sektor1' AND per_cls_ID=1";
                      $sJiwaSek = RunQuery($sSQL5);
                      $JiwaSek = mysql_num_rows($sJiwaSek);
						 echo gettext("$JiwaSek"); echo" J)</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
						  }
						  ?>
                    <? }
	  ?>
                  </td>
                </tr>
                <tr align="center">
                  <td height="10" bgcolor="#DFDFFF"><strong>Golongan Darah : 
                    <? while ($Goldarah=mysql_fetch_array($sGoldarah)) {
	  echo " <a href='../Gollist.php?gd=$Goldarah[c8]'>$Goldarah[c8]</a> |";
	  }
	  ?>
                    </strong></td>
                </tr>
              </table></td>
          </tr>
          <tr align="center"> 
            <td align="center" bgcolor="#CEEFFF">Temukan semua disini !!! (Nama, 
              Alamat, No HP, Dlsb.) 
              <table width="94%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td colspan="2" align="center"> <form action="<? php_self ;?>" method="post">
                      <input type="text" name="What"/>
                      <input name="SUBMIT" type=SUBMIT value="CARI">
                    </form></td>
                </tr>
              </table></td>
            <td colspan="2" rowspan="2" align="center" valign="top" bgcolor="#CEEFFF"> 
              <table width="98%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td><table width="99%" border="0" cellspacing="0" cellpadding="0">
                      <tr> Untuk melihat Anggota jemaat yg berulang tahun selama 
                        seminggu, tekan tombol GENERATE 
                        <form action="Menu.php" method="POST">
                          <input type="hidden" name="A" value="generate">
                          <input name="SUBMIT2" type=SUBMIT value="GENERATE">
                        </form>
                        <?

$test=$_POST["A"];
//echo "<BR>Hasil: \$A= $test";
if ($test=="generate") {
    GENERATE();
	}	 
//HUT 7 Hari terakhir (generate)
function GENERATE() {

$HARI=DATE(D);
$HARIINI=DATE(d);
$BULANINI=DATE(m);
$TGLHARIINI=DATE(d);
$TAHUNINI=DATE(Y);
$BULANSTART=DATE(m);
$TGLMAX=DATE(t);
$TAHUNINISTART=DATE(Y);
$TGLSTART=DATE(d);
//echo $HARI;
$test=DATE(z);

$status=0;

if ($HARI=='Mon') {   
   $HARIINI1=DATE(d)+6;
   $HARIINI=DATE(d)+6;
   $status=1;
   }
if ($HARI=='Tue') {   
   $HARIINI1=DATE(d)+5;
   $HARIINI=DATE(d)+5;
   $status=1;
   }
if ($HARI=='Wed') {   
   $HARIINI1=DATE(d)+4;
   $HARIINI=DATE(d)+4;
   $status=1;
   }
   
if ($HARI=='Thu') {   
   $HARIINI1=DATE(d)+3;
   $HARIINI=DATE(d)+3;
   $status=1;
   }
   
if ($HARI=='Fri') {   
   $HARIINI1=DATE(d)+2;
   $HARIINI=DATE(d)+2;
   $status=1;
   }
    
if ($HARI=='Sat') {   
   $HARIINI1=DATE(d)+1;
   $HARIINI=DATE(d)+1;
   $status=1;
   }

if ($HARI=='Sun') {   
   $HARIINI1=DATE(d)+0;
   $HARIINI=DATE(d)+0;
   $status=1;
   }
   
   if ($HARIINI1>$TGLMAX) {
       $HARIINI1=1;
	   $HARIINI=1;
	   $TGLSTART=1;
	   $BULANSTART++;
	   $BULANINI++;
	   if ($BULANINI>12) {
		   $BULANINI=1;
		   $BULANSTART=1;
		   $TAHUNINI++;
		   $TAHUNINISTART++;
		   }
	   //echo "lewat sini";
	   }
	   
   $HARIINICOUNT=1;
   
   $perintah="TRUNCATE TABLE person_hut";
   mysql_query($perintah);
   while ($HARIINICOUNT<=7)
      {
	  $SQL = "SELECT * FROM person_per LEFT JOIN family_fam ON  family_fam.fam_ID = person_per.per_fam_ID WHERE per_BirthDay = $HARIINI AND per_BirthMonth = $BULANINI AND per_cls_ID=1 ";
      $TotalFemaleListing = mysql_query($SQL);
      while ($Hasil=mysql_fetch_array($TotalFemaleListing)) 
            {
			$Ultahke=$TAHUNINI-$Hasil[per_BirthYear];
			//$perintah="UPDATE person_hut SET ultah_NAMA1=$Hasil[per_FirstName], ultah_NAMA2=$Hasil[per_LastName], ultah_KE=$Ultahke, ultah_NAMASEK=$Hasil[fam_NamaSek], ultah_TGL=$Hasil[per_BirthDay], ultah_BLN=$Hasil[per_BirthMonth], ultah_THN=$TAHUNINI, ultah_per_ID=$Hasil[per_ID], ultah_END=$Hasil[per_MiddleName]";
			$perintah="INSERT INTO person_hut (ultah_NAMA1, ultah_NAMA2, ultah_KE, ultah_NAMASEK, ultah_TGL, ultah_BLN, ultah_THN, ultah_per_ID, ultah_fam_ID, ultah_END) VALUES ('$Hasil[per_FirstName]','$Hasil[per_LastName]','$Ultahke','$Hasil[fam_NamaSek]', $Hasil[per_BirthDay], $Hasil[per_BirthMonth], $TAHUNINI,'$Hasil[per_ID]', '$Hasil[fam_Name]', '$Hasil[per_MiddleName]')"; 
			mysql_query($perintah);
			$No++;
			$status=3;
			}
			   //echo "$HARIINI<br>";
	           if ($HARIINI>=$TGLMAX) {
			       $HARIINI=0;
		           $BULANINI++;
				   if ($BULANINI>12) {
				       $BULANINI=1;
					   $TAHUNINI++;
					   }
				   }
		   
		   $HARIINI++;
		   $HARIINICOUNT++;
		   }
	 $HARIINIAKHIR=($HARIINI-1);
	 
	 if ($status==1) {
	 $perintah = " INSERT INTO person_hut (ultah_START, ultah_TGLAKHIR, ultah_BLNSTART) VALUES ('$HARIINI1','$HARIINIAKHIR','$BULANSTART')";
	 mysql_query($perintah);
	 } 
	 if ($status==2) {
	 $perintah = " INSERT INTO person_hut (ultah_START, ultah_TGLAKHIR, ultah_BLNSTART) VALUES ('$HARIINI','$HARIINIAKHIR','$BULANSTART')";
	 mysql_query($perintah);
	 }
	  if ($status==3) {
	 $perintah = " UPDATE person_hut SET ultah_START=$HARIINI1, ultah_TGLAKHIR=$HARIINIAKHIR, ultah_BLNSTART=$BULANSTART";
	 mysql_query($perintah);
	 }
	 //if ($status==0) {
	 //$perintah = " INSERT INTO person_hut (ultah_START, ultah_TGLAKHIR, ultah_BLNSTART) VALUES ('$HARIINI1','$HARIINIAKHIR','$BULANSTART')";
	 //mysql_query($perintah); echo status0;
	 //}
	 //}


?>
                      </tr>
                    </table>
                    <?
		$SQL = "SELECT * FROM person_hut";
        $Total = mysql_query($SQL);
         while ($Hasil=mysql_fetch_array($Total))
             {
			 $tglstart=$Hasil[ultah_START];
			 $tglakhir=$Hasil[ultah_TGLAKHIR];
			 $bulanstart=$Hasil[ultah_BLNSTART];
             }
		?>
                    Jemaat ulang tahun selama seminggu periode (<?php echo "$tglstart-$bulanstart-$TAHUNINISTART s/d $tglakhir - $BULANINI - $TAHUNINI"; ?>) 
                  </td>
                </tr>
                <tr> 
                  <td> <table width="100%" border="1" cellspacing="0" cellpadding="0">
                      <tr bgcolor="#66CCFF"> 
                        <td width="16%"> <div align="center"><strong>TANGGAL</strong></div></td>
                        <td width="68%"> <div align="center"><strong>N A M A</strong></div></td>
                        <td width="9%"> <div align="center"><strong>Ulang Tahun 
                            Ke</strong></div></td>
                        <td width="7%"> <div align="center"><strong>Sek Pel</strong></div></td>
                      </tr>
                      <?php
   $No=1;
   $SQL = "SELECT * FROM person_hut ORDER BY ultah_TGL ASC, ultah_NAMASEK ASC";
   $TotalFemaleListing = mysql_query($SQL); 
     while ($Hasil=mysql_fetch_array($TotalFemaleListing))
            {
			//$Ultahke=$Hasil[ultah_THNAKHIR-$Hasil[per_BirthYear];
			echo ("<TR><TD>&nbsp;$Hasil[ultah_TGL]-$Hasil[ultah_BLN]-$Hasil[ultah_THN]</TD> <TD><a href='PersonView.php?PersonID=$Hasil[ultah_per_ID]'>&nbsp;$Hasil[ultah_NAMA1] $Hasil[ultah_END] $Hasil[ultah_NAMA2] (Kel. $Hasil[ultah_fam_ID])</a></TD> <TD>&nbsp;$Hasil[ultah_KE]</TD> <TD>&nbsp;$Hasil[ultah_NAMASEK]</TD></TR>");
			//echo ("<TR><TD><STRONG>&nbsp;$Hasil[ultah_TGL]-$Hasil[ultah_BLN]-$Hasil[ultah_THN]</STRONG></TD> <TD><STRONG><a href='PersonView.php?PersonID=$Hasil[ultah_per_ID]'>&nbsp;$Hasil[ultah_NAMA1] $Hasil[ultah_END] $Hasil[ultah_NAMA2]</a></STRONG></TD> <TD><STRONG>&nbsp;$Hasil[ultah_KE]</STRONG></TD> <TD><STRONG>&nbsp;$Hasil[ultah_NAMASEK]</STRONG></TD></TR>");
			$No++;
			}
}
?>
                    </table></table></td>
          </tr>
          <tr align="center"> 
            <td align="center" bgcolor="#CEEFFF"><img src="graphs/SEK.php"></td>
          </tr>
          <tr> 
            <td height="9" colspan="3" align="center" bgcolor="#CEEFFF"><table width="90%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="96%"> 
                    <? 
if ($_POST[What]!="") {
$Var="$_POST[What]";
//$sSQL1="SELECT * FROM person_per WHERE per_FirstName LIKE '%$_POST[What]%'";
//$sSQL2="SELECT * FROM person_per WHERE per_MiddleName LIKE '%$_POST[What]%'";
//$sSQL3="SELECT * FROM person_per WHERE per_LastName LIKE '%$_POST[What]%'";

$sSQL1 = "SELECT * from person_per 
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_FirstName LIKE '%$Var%' ORDER BY per_FirstName ASC";
		 
$sSQL2 = "SELECT * from person_per 
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_MiddleName LIKE '%$Var%' ORDER BY per_FirstName ASC";
		 
$sSQL3 = "SELECT * from person_per 
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_LastName LIKE '%$Var%' ORDER BY per_FirstName ASC";
		 
$sSQL4 = "SELECT * from person_per 
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE fam_Address1 LIKE '%$Var%' ORDER BY per_FirstName ASC";
		 
$sSQL5 = "SELECT * from person_per 
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE fam_Kompleks1 LIKE '%$Var%' ORDER BY per_FirstName ASC";
		 
$sSQL6 = "SELECT * from person_per 
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_Address1 LIKE '%$Var%' ORDER BY per_FirstName ASC";
		 
$sSQL7 = "SELECT * from person_per 
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_Kompleks1 LIKE '%$Var%' ORDER BY per_FirstName ASC";
		 		 
$sSQL8 = "SELECT * from person_per 
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_CellPhone LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL9 = "SELECT * from person_per 
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE fam_CellPhone LIKE '%$Var%' ORDER BY per_FirstName ASC";
		 
$Search1 = mysql_query($sSQL1);
$TotSrc1 = mysql_num_rows($Search1);
$Search2 = mysql_query($sSQL2);
$TotSrc2 = mysql_num_rows($Search2);
$Search3 = mysql_query($sSQL3);
$TotSrc3 = mysql_num_rows($Search3);
$Search4 = mysql_query($sSQL4);
$TotSrc4 = mysql_num_rows($Search4);
$Search5 = mysql_query($sSQL5);
$TotSrc5 = mysql_num_rows($Search5);
$Search6 = mysql_query($sSQL6);
$TotSrc6 = mysql_num_rows($Search6);
$Search7 = mysql_query($sSQL7);
$TotSrc7 = mysql_num_rows($Search7);
$Search8 = mysql_query($sSQL8);
$TotSrc8 = mysql_num_rows($Search8);
$Search9 = mysql_query($sSQL9);
$TotSrc9 = mysql_num_rows($Search9);

$Totalsrc= $TotSrc1+$TotSrc2+$TotSrc3+$TotSrc4+$TotSrc5+$TotSrc6+$TotSrc7+$TotSrc8+$TotSrc9;

//if ($TotSrc1==0 AND $TotSrc2==0 AND $TotSrc3==0 AND $TotSrc4==0 AND $Totsrc5==0 AND $TotSrc6==0 AND $TotSrc7==0 AND $TotSrc8==0 AND $TotSrc9)==0) {
if ($Totalsrc > 0) { 
 echo"Hai ! <b>".$_SESSION['UserFirstName'] . " " .$_SESSION['UserLastName'] ."</b>, smjGPIB berhasil menemukan <b>$Totalsrc</b> record yg berhubungan dengan <b>\" <font color=blue> $Var </font> \"</b> dlm database $NamaJemaat $KotaJemaat<br><br>";
 } else {
 //echo $S;
 echo "Sorry ! <b>".$_SESSION['UserFirstName'] . " " .$_SESSION['UserLastName'] ."</b>, smjGPIB tidak berhasil menemukan <b>\" <font color=blue> $Var </font> \"</B> dalam database $NamaJemaat $KotaJemaat, coba lagi....<br>";
 } 



while ($Hasil1=mysql_fetch_array($Search1)) {
 $List1 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil1[per_ID]'>$Hasil1[per_FirstName] $Hasil1[per_MiddleName] $Hasil1[per_LastName] | $Hasil1[fam_NamaSek] | $Hasil1[fam_Address1] $Hasil1[fam_HomePhone] | $Hasil1[per_HomePhone] | $Hasil1[fam_CellPhone] | $Hasil1[per_CellPhone]</a>");
 echo"1$List1<br>";

 //echo "<a href='PersonView.php?PersonID=$Hasil1[per_ID]'>$test $Hasil1[per_MiddleName] $Hasil1[per_LastName] | $Hasil1[fam_NamaSek] | $Hasil1[fam_HomePhone] | $Hasil1[per_HomePhone] | $Hasil1[fam_CellPhone] | $Hasil1[per_CellPhone] | $Hasil1[fam_Address1]</a><br>";
 $id1="$id1, $Hasil1[per_ID]";
 }
//echo "a$id1"; 
$id22="$id1";
while ($Hasil2=mysql_fetch_array($Search2)) {
 $id2="$Hasil2[per_ID]";
 if (!ereg($id2,$id1)) {
 $List2 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil2[per_ID]'>$Hasil2[per_FirstName] $Hasil2[per_MiddleName] $Hasil2[per_LastName] | $Hasil2[fam_NamaSek] | $Hasil2[fam_Kompleks1] $Hasil2[fam_Address1] | $Hasil2[fam_HomePhone] | $Hasil2[per_HomePhone] | $Hasil2[fam_CellPhone] | $Hasil2[per_CellPhone]</a>");
 echo"2$List2<br>";
 //echo "<a href='PersonView.php?PersonID=$Hasil2[per_ID]'>$Hasil2[per_FirstName] $Hasil2[per_MiddleName] $Hasil2[per_LastName] | $Hasil2[fam_NamaSek] | $Hasil2[fam_HomePhone] | $Hasil2[per_HomePhone] | $Hasil2[fam_CellPhone] | $Hasil2[per_CellPhone] | $Hasil2[fam_Address1]</a><br>";
 $id222="$id222, $Hasil2[per_ID]";
 }
 }
//echo "ini22$id222 |<br>";
$id33="$id1$id222";
while ($Hasil3=mysql_fetch_array($Search3)) {
 $id3="$Hasil3[per_ID]";
 if (!ereg($id3,$id33)) {
 $List3 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil3[per_ID]'>$Hasil3[per_FirstName] $Hasil3[per_MiddleName] $Hasil3[per_LastName] | $Hasil3[fam_NamaSek] | $Hasil3[fam_Kompleks1] $Hasil3[fam_Address1] | $Hasil3[fam_HomePhone] | $Hasil3[per_HomePhone] | $Hasil3[fam_CellPhone] | $Hasil3[per_CellPhone]</a>");
 echo"3$List3<br>";
 //echo "<a href='PersonView.php?PersonID=$Hasil3[per_ID]'>$Hasil3[per_FirstName] $Hasil3[per_MiddleName] $Hasil3[per_LastName] | $Hasil3[fam_NamaSek] | $Hasil3[fam_HomePhone] | $Hasil3[per_HomePhone] | $Hasil3[fam_CellPhone] | $Hasil3[per_CellPhone] | $Hasil3[fam_Address1]</a><br>";
 $id333="$id333, $Hasil3[per_ID]";
 }
 } 
//echo "ini33$id333 |<br>";

$id44="$id1$id222$id333";
while ($Hasil4=mysql_fetch_array($Search4)) { 
 $id4="$Hasil4[per_ID]"; 
 if (!ereg($id4,$id44)) {
 $List4 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil4[per_ID]'>$Hasil4[per_FirstName] $Hasil4[per_MiddleName] $Hasil4[per_LastName] | $Hasil4[fam_NamaSek] | $Hasil4[fam_Kompleks1] $Hasil4[fam_Address1] $Hasil4[fam_HomePhone] | $Hasil4[per_HomePhone] | $Hasil4[fam_CellPhone] | $Hasil4[per_CellPhone]</a>");
 echo"4$List4<br>";
 //echo "<a href='PersonView.php?PersonID=$Hasil4[per_ID]'>$Hasil4[per_FirstName] $Hasil4[per_MiddleName] $Hasil4[per_LastName] | $Hasil4[fam_NamaSek] | $Hasil4[fam_HomePhone] | $Hasil4[per_HomePhone] | $Hasil4[fam_CellPhone] | $Hasil4[per_CellPhone] | $Hasil4[fam_Address1]</a><br>";
 $id444="$id444, $Hasil4[per_ID]";
 } 
 } 
//echo "ini44$id444 |<br>";

$id55="$id1$id222$id333$id444";
while ($Hasil5=mysql_fetch_array($Search5)) {
 $id5="$Hasil5[per_ID]";
 if (!ereg($id5,$id55)) {
 $List5 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil5[per_ID]'>$Hasil5[per_FirstName] $Hasil5[per_MiddleName] $Hasil5[per_LastName] | $Hasil5[fam_NamaSek] |  $Hasil5[fam_Kompleks1] $Hasil5[fam_Address1] $Hasil5[fam_HomePhone] | $Hasil5[per_HomePhone] | $Hasil5[fam_CellPhone] | $Hasil5[per_CellPhone]</a>");
 echo"5$List5<br>"; 
 //echo "<a href='PersonView.php?PersonID=$Hasil5[per_ID]'>$Hasil5[per_FirstName] $Hasil5[per_MiddleName] $Hasil5[per_LastName] | $Hasil5[fam_NamaSek] | $Hasil5[fam_HomePhone] | $Hasil5[per_HomePhone] | $Hasil5[fam_CellPhone] | $Hasil5[per_CellPhone] | $Hasil5[fam_Address1]</a><br>"; 
 $id555="$id555, $Hasil5[per_ID]";
 }
 } 
//echo "ini5$id555 |<br>";
$id66="$id1$id222$id333$id444$id555";
while ($Hasil6=mysql_fetch_array($Search6)) { 
 $id6="$Hasil6[per_ID]"; 
 if (!ereg($id6,$id66)) {
 $List6 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil6[per_ID]'>$Hasil6[per_FirstName] $Hasil6[per_MiddleName] $Hasil6[per_LastName] | $Hasil6[fam_NamaSek] | $Hasil6[fam_Kompleks1] $Hasil6[fam_Address1] $Hasil6[fam_HomePhone] | $Hasil6[per_HomePhone] | $Hasil6[fam_CellPhone] | $Hasil6[per_CellPhone]</a>");
 echo"6$List6<br>";
 //echo "<a href='PersonView.php?PersonID=$Hasil6[per_ID]'>$Hasil6[per_FirstName] $Hasil6[per_MiddleName] $Hasil6[per_LastName] | $Hasil6[fam_NamaSek] | $Hasil6[fam_HomePhone] | $Hasil6[per_HomePhone] | $Hasil6[fam_CellPhone] | $Hasil6[per_CellPhone] | $Hasil6[fam_Address1]</a><br>"; 
 $id666="$id666, $Hasil6[per_ID]";
 }
 }
$id77="$id1$id222$id333$id444$id555$id666";
while ($Hasil7=mysql_fetch_array($Search7)) {
 $id7="$Hasil7[per_ID]";
 if (!ereg($id7,$id77)) {
 $List7 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil7[per_ID]'>$Hasil7[per_FirstName] $Hasil7[per_MiddleName] $Hasil7[per_LastName] | $Hasil7[fam_NamaSek] | $Hasil7[fam_Kompleks1] $Hasil7[per_Kompleks1] $Hasil7[fam_Address1] $Hasil7[fam_HomePhone] | $Hasil7[per_HomePhone] | $Hasil7[fam_CellPhone] | $Hasil7[per_CellPhone]</a>");
 echo"7$List7<br>";
 //echo "<a href='PersonView.php?PersonID=$Hasil7[per_ID]'>$Hasil7[per_FirstName] $Hasil7[per_MiddleName] $Hasil7[per_LastName] | $Hasil7[fam_NamaSek] | $Hasil7[fam_HomePhone] | $Hasil7[per_HomePhone] | $Hasil7[fam_CellPhone] | $Hasil7[per_CellPhone] | $Hasil7[fam_Address1]</a><br>";
 $id777="$id777, $Hasil7[per_ID]";
 }
 }
$id88="$id1$id222$id333$id444$id555$id666$id777";
while ($Hasil8=mysql_fetch_array($Search8)) {
 $id8="$Hasil8[per_ID]";
 if (!ereg($id8,$id88)) {
 $List8 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil8[per_ID]'>$Hasil8[per_FirstName] $Hasil8[per_MiddleName] $Hasil8[per_LastName] | $Hasil8[fam_NamaSek] | $Hasil8[fam_Kompleks1] $Hasil8[fam_Address1] $Hasil8[fam_HomePhone] | $Hasil8[per_HomePhone] | $Hasil8[fam_CellPhone] | $Hasil8[per_CellPhone]</a>");
 echo"8$List8<br>";
 //echo "<a href='PersonView.php?PersonID=$Hasil8[per_ID]'>$Hasil8[per_FirstName] $Hasil8[per_MiddleName] $Hasil8[per_LastName] | $Hasil8[fam_NamaSek] | $Hasil8[per_HomePhone] | $Hasil8[per_HomePhone] | $Hasil8[fam_CellPhone] | $Hasil8[per_CellPhone] | $Hasil8[fam_Address1]</a><br>";
 $id888="$id888, $Hasil8[per_ID]";
 }
 }
$id99="$id1$id222$id333$id444$id555$id666$id777$id888";
while ($Hasil9=mysql_fetch_array($Search9)) {
 $id9="$Hasil9[per_ID]";
 if (!ereg($id9,$id99)) {
 $List9 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil9[per_ID]'>$Hasil9[per_FirstName] $Hasil9[per_MiddleName] $Hasil9[per_LastName] | $Hasil9[fam_NamaSek] | $Hasil9[fam_Kompleks1] $Hasil9[fam_Address1] $Hasil9[fam_HomePhone] | $Hasil9[per_HomePhone] | $Hasil9[fam_CellPhone] | $Hasil9[per_CellPhone]</a>");
 echo"9$List9<br>";
 //echo "<a href='PersonView.php?PersonID=$Hasil9[per_ID]'>$Hasil9[per_FirstName] $Hasil9[per_MiddleName] $Hasil9[per_LastName] | $Hasil9[fam_NamaSek] | $Hasil9[per_HomePhone] | $Hasil9[per_HomePhone] | $Hasil9[fam_CellPhone] | $Hasil9[per_CellPhone] | $Hasil9[fam_Address1]</a><br>";
// $id999="$id999, $id9";
 } 
 }
 }
 ?>
                  </td>
                  <td width="1%">&nbsp;</td>
                  <td width="3%">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td colspan="3" align="center" bgcolor="#CEEFFF"> 
              <? require "Include/Footer.php"; ?>
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
</center>