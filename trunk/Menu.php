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
 *  InfocentralGPIB is free software; you can redistribute it and/or modify
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
//$Var = "DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_cls_ID=1 AND per_Gender=2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2) $And";
$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where (DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2)) AND per_cls_ID=1 ";
$sPW = RunQuery($sSQL);
$PW = mysql_num_rows($sPW);

//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 1";
//$sPKB = RunQuery($sSQL);
//$PKB = mysql_num_rows($sPKB);
$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where (DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=1 OR (c16=2 AND per_Gender=1) OR (c16=4 AND per_Gender=1)) AND per_cls_ID=1 ";
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

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID WHERE per_cls_ID=1 AND (c13 NOT LIKE '%Jakarta%' OR c13='')";
$sTotalLokasiNonBpp = RunQuery($sSQL);
$TotalLokasiNonBpp = mysql_num_rows($sTotalLokasiNonBpp);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID WHERE per_cls_ID=1 AND (c17 =7 or c17 = 3 or c17=4 or c17=5 or c17=6 or c17=8 or c17=10 or c17=11)";
$sTotalPro = RunQuery($sSQL);
$TotalPro = mysql_num_rows($sTotalPro);

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
   $photo1="Images/nophoto.gif";
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
      <td valign="top">
          <? require "Include/Header.php"; ?>
      </td>
    </tr>
    <tr>
    	<td>
    	  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr>
            <td width="35%" align="center" valign="top"> <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF">
                  <td width="33%" align="center"><a href="Menu.php"><img src="Images/gpib_kecil.jpg" alt="KLIK DISINI untuk kembali ke halaman utama" border="0"></a></td>
                  <td width="67%" align="center"><img src="Images/smj-logo.gif" width="144" height="49"></td>
                </tr>
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
                  <td colspan="2" align="center"><a href="SelectList.php?mode=AnggotaJemaat&Gender=1"><strong>Warga
                    Jemaat Pria</strong></a>:<?php echo gettext($TotalMale); ?>
                    dari <?php echo gettext($TotalMaleAll); ?> </td>
                </tr>
                <tr bgcolor="#CCCCFF">
                  <td colspan="2" align="center"> <div align="center"> <a href="SelectList.php?mode=NON&Gender=1">(Non
                      Jemaat: <? echo gettext($TotalMaleNon)?>)</a></div></td>
                </tr>
                <tr bgcolor="#E6E6FF">
                  <td colspan="2" align="center"><a href="SelectList.php?mode=AnggotaJemaat&Gender=2"><strong>Warga
                    Jemaat Wanita</strong></a>: <?php echo gettext($TotalFemale); ?>
                    dari <?php echo gettext($TotalFemaleAll); ?></td>
                </tr>
                <tr bgcolor="#E6E6FF">
                  <td colspan="2" align="center"> <div align="center"> <a href="SelectList.php?mode=NON&Gender=2">(Non
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
                  <td colspan="2" align="center">Pria <a href="SelectList.php?mode=SIDI&Gender=1"><? echo gettext($TotalSidiMale); ?></a>
                    (<a href="SelectList.php?mode=NONSIDI&Gender=1"><? echo gettext($TotalNonSidiMale); ?></a>)/
                    &nbsp;Wanita <a href="SelectList.php?mode=SIDI&Gender=2"><? echo gettext($TotalSidiFemale); ?></a>
                    (<a href="SelectList.php?mode=NONSIDI&Gender=2"><? echo gettext($TotalNonSidiFemale); ?></a>)</td>
                </tr>
                <tr bgcolor="#CCCCFF">
                  <td height="19" colspan="2" align="center"> <table width="99%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="31%" align="center"><a href="?action=list&mode=PENDETA&List.php"><strong>Pendeta</strong></a>:
                          <?php echo gettext($Pendeta); ?></td>
                        <td width="40%" align="center"><a href="?action=list&mode=PENATUA&List.php"><strong>Penatua</strong></a>:
                          <?php echo gettext($Penatua); ?> </td>
                        <td width="29%" align="center"><a href="?action=list&mode=DIAKEN&List.php"><strong>Diaken</strong></a>:
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
              <? if($_GET['action']=='graphs'){
	 $action="text"; ?>
              <table width="99%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center" bgcolor="#CCFFFF"><font size="1"><? echo "<a href='?action=$action'>view
					$action mode</a>";?></font></td>
                </tr>
              </table>
              <?
	echo" <img src='Graphs/BPK.php'><br><br><img src='Graphs/Bpkbar.php'>";
	} else {
	//echo" <img src='Graphs/BPK.php'><br><br><img src='Graphs/Bpkbar.php'>";
    $action="graphs";
	?>
              <table width="99%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
                <tr align="center" bgcolor="#CCFFFF">
                  <td colspan="2"><font size="1"><? echo "<a href='?action=$action'>(klik disini utk lihat grafik)</a>";?></font></td>
                </tr>
                <tr align="center">
                  <td width="24%"><a href="SelectList.php?mode=PA"><img src="Images/PAlogo.jpg" alt="PA" border="0"></a></td>
                  <td width="76%" align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" bgcolor="#BBFFBB"><a href="?action=list&mode=PA&List.php"><strong>PELAYANAN
                          ANAK</strong></a> : <?php echo gettext($PA); ?> Anak</td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCFFCC">(<a href="SelectList.php?mode=PA&Gender=1">Pria</a> <?php echo gettext($PAMale); ?>
                          / <a href="SelectList.php?mode=PA&Gender=2">Wanita</a> <?php echo gettext($PAFemale); ?>)</td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center">
                  <td><a href="SelectList.php?mode=PT"><img src="Images/PTlogo.jpg" alt="PT" border="0"></a></td>
                  <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" bgcolor="#FFFF97"><a href="?action=list&mode=PT&List.php"><strong>PERSEKUTUAN</strong>
                          <strong>TERUNA</strong></a> : <?php echo gettext($PT); ?>
                          Orang</td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#FFFFC1">(<a href="SelectList.php?mode=PT&Gender=1"> Pria</a> <?php echo gettext($PTMale); ?>
                          / <a href="SelectList.php?mode=PT&Gender=2">Wanita</a> <?php echo gettext($PTFemale); ?>)</td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center">
                  <td><a href="SelectList.php?mode=GP"><img src="Images/GPlogo.jpg" alt="GP" border="0"></a></td>
                  <td align="center"><a href="SelectList.php?mode=PW"></a> <table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" bgcolor="#6F6FFF"><a href="?action=list&mode=GP&List.php"><strong>GERAKAN
                          PEMUDA</strong></a> : <?php echo gettext($GP); ?> Orang<a href="SelectList.php?mode=GP"></a>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#A8A8FF">(<a href="SelectList.php?mode=GP&Gender=1">Pria</a> <?php echo gettext($GPMale); ?>
                          / <a href="SelectList.php?mode=GP&Gender=2">Wanita</a> <?php echo gettext($GPFemale); ?>) </td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center">
                  <td><a href="SelectList.php?mode=PW"><img src="Images/PWlogo.jpg" alt="PW" border="0"></a></td>
                  <td align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" bgcolor="#BB00BB"><a href="?action=list&mode=PW&List.php"><strong>PERSATUAN
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
                        <td align="center" bgcolor="#A8A8A8"><a href="?action=list&mode=PKB&List.php"><strong>PERSEKUTUAN
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
                        <td align="center" bgcolor="#FFD9D9"><a href="?action=list&mode=PROFESIONAL&List.php"><strong>FUNGSIONAL &amp;
                          PROFESIONAL</strong></a> : <? echo gettext($TotalPro);?></td>
                      </tr>
                      <tr>
                        <td height="3" align="center"><img src="Images/Spacer.gif" width="1" height="1"></td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#FF9595"><a href="?action=list&mode=LANSIA&List.php"><strong>LANJUT
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
                  <td width="78%" height="18" align="center" bgcolor="#66CCFF"><b><?php echo $_SESSION['UserFirstName'] . " " . $_SESSION['UserLastName']; ?></b></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" bgcolor="#BBE9FF">Versi InfocentralGPIB</td>
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
$SQL = "SELECT * FROM person_per LEFT JOIN family_fam ON  family_fam.fam_ID = person_per.per_fam_ID WHERE per_BirthDay = $Hariini AND per_BirthMonth = $Bulanini AND per_cls_ID=1 ORDER BY per_FirstName ASC";
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
          <tr>
            <td height="38" colspan="3" align="center" valign="top" bgcolor="#FFFFFF">
              <table width="99%" border="0" cellpadding="0" cellspacing="0">
                <tr align="center">
                  <td height="19" bgcolor="#DFDFFF"><? echo "<b> Jumlah Sektor Pelayanan : $TotalSek </b>"; ?>&nbsp;&nbsp;&nbsp;<a href='?action=graphs_sektor'><font size="-7" color='blue'>(klik
                    disini utk lihat grafik)</font></a></td>
                </tr>
                <tr align="center">
                  <td height="9" bgcolor="#CCCCFF">
                    <? while ($data=mysql_fetch_array($sSek)) {?>
                    <?
					 $Sektor1=$data[fam_NamaSek];
					 $sSQL2 = "SELECT * FROM family_fam WHERE fam_NamaSek='$Sektor1'";
                     $sSektor = RunQuery($sSQL2);
                     $Sektor = mysql_num_rows($sSektor);
					 $sSQL5 = "SELECT * FROM person_per LEFT JOIN family_fam ON  family_fam.fam_ID = person_per.per_fam_ID WHERE fam_NamaSek='$Sektor1' AND fam_NamaSek!='' AND per_cls_ID=1";
                     $sJiwaSek = RunQuery($sSQL5);
                     $JiwaSek = mysql_num_rows($sJiwaSek);
                     echo "<a href='?action=seklist&sek=$data[fam_NamaSek]&KK=$Sektor&jiwa=$JiwaSek&seklistbaru.php'><b>$data[fam_NamaSek]</b>";
					   if ($Sektor!='') {
					      echo (" ($Sektor K / ");
						 echo gettext("$JiwaSek"); echo" J)</a>&nbsp;<font color=blue>|</font>";
						  }
						  ?>
                    <? }
	  ?>
                  </td>
                </tr>
                <tr align="center">
                  <td height="5" bgcolor="#DFDFFF"><strong>Golongan Darah :
                    <? while ($Goldarah=mysql_fetch_array($sGoldarah)) {
	  echo " <a href='?action=goldarahlist&gd=$Goldarah[c8]&Gollist.php?gd=$Goldarah[c8]'>$Goldarah[c8]</a> |";
	  }
	  ?>
                    </strong></td>
                </tr>
                <tr align="center">
                  <td height="2" bgcolor="#CCCCFF"> &lt;&lt;<a href="?action=ultahseminggu">
                    klik disini untuk melihat jemaat yg berulang tahun selama
                    satu minggu</a> &gt;&gt;</td>
                </tr>
                <tr align="center">
                  <td height="24" bgcolor="#CEEFFF"> <form action="?action=search&searching.php"  method="post"/>
                      Temukan semua disini !!! (id jemaat, nama, alamat, telp,
                    hp), masukan kata/angka kunci
                    <input name="What2" type="text" width="50" />
                      <input name="SUBMIT2" type="submit" value="cari" width="20" />
                      </form>
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr align="center">
            <td colspan="3" valign="middle">
			  <? if ($_GET[action]=='ultahseminggu') { include'Ultahcostum.php'; include'ultah.php'; } ?>
  			  <? if ($_GET[action]=='costum') { include'Ultahcostum.php'; } ?>
              <? if ($_GET[action]=='search') { include'searching.php'; } ?>
              <? if ($_GET[action]=='seklist') { include'seklistbaru.php'; } ?>
              <? if ($_GET[action]=='goldarahlist') { include'gollist.php'; } ?>
              <? if ($_GET[action]=='list') { include'List.php'; } ?>
              <? if ($_GET[action]=='graphs_sektor') { ?>
              <a href='?action=close'>tutup</a><? echo"<br>"; ?> <img src="Graphs/SEK.php">
              <? } ?>
            </td>
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