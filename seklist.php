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
$sSERVERNAME = "localhost";
$sUSER = "bukitsion";
$sPASSWORD = "bukitsion1234";
$sDATABASE = "smjgpib";
// Include the function library
//require "Include/Config.php";
//require "Include/Functions.php";

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

$sSQL = "SELECT per_ID FROM person_per where per_Gender = 1 AND per_cls_ID=1 ";
$sTotalMale = RunQuery($sSQL);
$TotalMale = mysql_num_rows($sTotalMale);
//male listing
//$sSQL = "SELECT per_ID FROM person_per where per_Gender = 1 AND per_cls_ID=1 ";
//$sTotalMaleListing = RunQuery($sSQL);
//$TotalMale = mysql_num_rows($sTotalMale);

$sSQL = "SELECT per_ID FROM person_per WHERE per_Gender=2";
$sTotalFemaleAll = RunQuery($sSQL);
$TotalFemaleAll = mysql_num_rows($sTotalFemaleAll);

$sSQL = "SELECT per_ID FROM person_per where per_Gender = 2 AND per_cls_ID=1";
$sTotalFemale = RunQuery($sSQL);
$TotalFemale = mysql_num_rows($sTotalFemale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) > CURDATE()";
$sPA = RunQuery($sSQL);
$PA = mysql_num_rows($sPA);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) > CURDATE() AND per_Gender = 1";
$sPAMale = RunQuery($sSQL);
$PAMale = mysql_num_rows($sPAMale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) > CURDATE() AND per_Gender = 2";
$sPAFemale = RunQuery($sSQL);
$PAFemale = mysql_num_rows($sPAFemale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE()";
$sPT = RunQuery($sSQL);
$PT = mysql_num_rows($sPT);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_Gender = 1";
$sPTMale = RunQuery($sSQL);
$PTMale = mysql_num_rows($sPTMale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) > CURDATE() AND per_Gender = 2";
$sPTFemale = RunQuery($sSQL);
$PTFemale = mysql_num_rows($sPTFemale);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND c16=1 AND per_fmr_ID<>0";
//$sSQL = "SELECT * where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE()";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE()";
$sGP = RunQuery($sSQL);
$GP = mysql_num_rows($sGP);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_Gender=1 AND c16=1 AND per_fmr_ID<>0";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_Gender = 1 AND c16=1 AND per_fmr_ID<>0";
$sGPMale = RunQuery($sSQL);
$GPMale = mysql_num_rows($sGPMale);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_Gender=2 AND c16=1 AND per_fmr_ID<>0";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND per_Gender = 2";
$sGPFemale = RunQuery($sSQL);
$GPFemale = mysql_num_rows($sGPFemale);

//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 2";
//$sPW = RunQuery($sSQL);
//$PW = mysql_num_rows($sPW);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2)";
$sPW = RunQuery($sSQL);
$PW = mysql_num_rows($sPW);

//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 1";
//$sPKB = RunQuery($sSQL);
//$PKB = mysql_num_rows($sPKB);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender = 1 OR (c16=2 AND per_Gender=1) OR (c16=3 AND per_Gender=1)";
$sPKB = RunQuery($sSQL);
$PKB = mysql_num_rows($sPKB);

//$sSQL = "SELECT per_ID, CONCAT('<a href=PersonView.php?PersonID=',per_ID,'>',per_FirstName,' ',per_LastName,'</a>') AS Nama FROM person_per, person2group2role_p2g2r WHERE per_ID = p2g2r_per_ID AND p2g2r_grp_ID = 29 AND  p2g2r_rle_ID= 3";
//$sDiaken = RunQuery($sSQL);
//$Diaken = mysql_num_rows($sDiaken);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where c19 LIKE '%diaken%'";
$sDiaken = RunQuery($sSQL);
$Diaken = mysql_num_rows($sDiaken);

//$sSQL = "SELECT per_ID, CONCAT('<a href=PersonView.php?PersonID=',per_ID,'>',per_FirstName,' ',per_LastName,'</a>') AS Nama FROM person_per, person2group2role_p2g2r WHERE per_ID = p2g2r_per_ID AND p2g2r_grp_ID = 29 AND  p2g2r_rle_ID= 2";
//$sPenatua = RunQuery($sSQL);
//$Penatua = mysql_num_rows($sPenatua);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where c19 LIKE '%penatua%'";
$sPenatua = RunQuery($sSQL);
$Penatua = mysql_num_rows($sPenatua);

//$sSQL = "SELECT per_ID, CONCAT('<a href=PersonView.php?PersonID=',per_ID,'>',per_FirstName,' ',per_LastName,'</a>') AS Nama FROM person_per, person2group2role_p2g2r WHERE per_ID = p2g2r_per_ID AND p2g2r_grp_ID = 29 AND  p2g2r_rle_ID= 1";
//$sPendeta = RunQuery($sSQL);
//$Pendeta = mysql_num_rows($sPendeta);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where c19 LIKE '%pendeta%'";
$sPendeta = RunQuery($sSQL);
$Pendeta = mysql_num_rows($sPendeta);

$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam WHERE fam_NamaSek!=''";
$sTotalSek = RunQuery($sSQL);
$TotalSek = mysql_num_rows($sTotalSek);

$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam WHERE fam_NamaSek!='' ORDER BY fam_NamaSek ASC";
$sSek = RunQuery($sSQL);
$Sek = mysql_num_rows($sSek);

$sSQL = "SELECT per_ID FROM person_per where per_Gender = 2 AND (per_cls_ID!=1 AND per_cls_ID!=0)";
$sTotalFemaleNon = RunQuery($sSQL);
$TotalFemaleNon = mysql_num_rows($sTotalFemaleNon);

$sSQL = "SELECT per_ID FROM person_per where per_Gender = 1 AND (per_cls_ID!=1 AND per_cls_ID!=0)";
$sTotalMaleNon = RunQuery($sSQL);
$TotalMaleNon = mysql_num_rows($sTotalMaleNon);

$sSQL = "SELECT per_ID FROM person_per where (per_cls_ID!=1 AND per_cls_ID!=0)";
$sTotalNon = RunQuery($sSQL);
$TotalNon = mysql_num_rows($sTotalNon);

$photo=$_SESSION['iUserID'];
$photoFile="Images/Person/Thumbnails/$photo.jpg";
if (file_exists($photoFile)) {
   $photo1="Images/Person/Thumbnails/$photo.jpg";
   } else {
   $photo1="Images/OS22019.jpg";
   }
//$sSQL = "SELECT DISTINCT from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID";
//$sGoldarah = RunQuery($sSQL);
//$Goldarah = mysql_num_rows($sGoldarah);

$sSQL = "SELECT DISTINCT c8 from person_custom ORDER BY c8 ASC";
$sGoldarah = RunQuery($sSQL);

$sSQL = "SELECT * FROM family_fam WHERE fam_NamaSek=\"$_REQUEST[id]\" ORDER BY fam_Name ASC";
//$sSQL = "SELECT * FROM family_fam WHERE fam_NamaSek=\"III\"";
$sSekList = RunQuery($sSQL);
$sSekList1 = RunQuery($sSQL);
//$Seklist = mysql_num_rows($sSeklist);
$data1=mysql_fetch_array($sSekList1);

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
      <td width="760" height="438" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr bgcolor="#FFFFFF"> 
            <td height="3" colspan="3"><img src="Images/Spacer.gif" width="1" height="1"></td>
          </tr>
          <tr align="center" bgcolor="#7AB7D8"> 
            <td height="11" colspan="3"> 
              <? require "Include/Header.php"; ?>
            </td>
          </tr>
          <tr bgcolor="#FFFFCC"> 
            <td height="2" colspan="3"><img src="Images/Spacer.gif" width="1" height="1"></td>
          </tr>
          <tr bgcolor="#CEEFFF"> 
            <td height="11" colspan="3"> <div align="center"><img src="Images/Spacer.gif" width="1" height="1"> 
                <img src="Images/Spacer.gif" width="1" height="1"> </div></td>
          </tr>
          <tr> 
            <td width="35%" rowspan="2" align="center" valign="top"> <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF"> 
                  <td width="33%" rowspan="2" align="center"><a href="Menu.php"><img src="Images/GPIB_color.jpg" alt="KLIK DISINI untuk kembali ke halaman depan" width="65" height="61" border="0"></a></td>
                  <td width="67%" rowspan="2" align="center"><img src="Images/smj-logo.gif" width="144" height="49"></td>
                </tr>
                <tr bgcolor="#FFFFFF"> </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td colspan="2" align="center" bgcolor="#D5D5FF"> <div align="center"><strong><?php echo gettext("$NamaJemaat");?></strong></div></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center"><?php echo gettext("$AlamatJemaat");?>&nbsp;<?php echo gettext("$KotaJemaat $ZipJemaat");?>&nbsp;<?php echo gettext("$StateJemaat");?></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center">Telephone : <?php echo gettext("$PhoneJemaat");?></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center">MUPEL <?php echo gettext("$NamaMupel");?></td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"><strong><a href="SelectList.php?mode=AnggotaJemaat">Total 
                    Warga Jemaat </a></strong>: <?php echo gettext($Total); ?></td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"> <div align="center"> <?php echo gettext($TotalAll); ?>&nbsp;<a href="SelectList.php?mode=NON">(Non 
                      Jemaat: <? echo $TotalNon?>)</a></div></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center"><a href="SelectList.php?mode=AnggotaJemaat1"><strong>Total 
                    Warga Jemaat Pria</strong></a>:<?php echo gettext($TotalMale); ?></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center"> <div align="center"> Orang dari 
                      <?php echo gettext($TotalMaleAll); ?>&nbsp;<a href="SelectList.php?mode=MALENON">(Non 
                      Jemaat: <? echo gettext($TotalMaleNon)?>)</a></div></td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"><a href="SelectList.php?mode=AnggotaJemaat2"><strong>Total 
                    Warga Jemaat Wanita</strong></a>: <?php echo gettext($TotalFemale); ?></td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"> <div align="center"> Orang dari 
                      <?php echo gettext($TotalFemaleAll); ?>&nbsp;<a href="SelectList.php?mode=FEMALENON">(Non 
                      Jemaat: <?php echo gettext($TotalFemaleNon); ?>)</a></div></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center"><a href="SelectList.php?mode=family">Jumlah 
                    KK </a> : <?php echo gettext($TotalKK); ?></td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td colspan="2" align="center"><a href="SelectList.php?mode=PENDETA"><strong>Pendeta</strong></a>: 
                    <?php echo gettext($Pendeta); ?></td>
                </tr>
                <tr bgcolor="#E6E6FF"> 
                  <td colspan="2" align="center"><a href="SelectList.php?mode=PENATUA"><strong>Penatua</strong></a>: 
                    <?php echo gettext($Penatua); ?></td>
                </tr>
                <tr bgcolor="#CCCCFF"> 
                  <td height="19" colspan="2" align="center"><a href="SelectList.php?mode=DIAKEN"><strong>Diaken</strong></a>: 
                    <?php echo gettext($Diaken); ?></td>
                </tr>
              </table>
              <div align="center"> </div></td>
            <td width="38%" align="center"> <a href="SelectList.php?mode=PW"></a><a href="SelectList.php?mode=GP"></a> 
              <a href="SelectList.php?mode=PKB"></a> <table width="98%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
                <tr align="center"> 
                  <td height="3" colspan="2"><img src="Images/Spacer.gif" width="1" height="1"></td>
                </tr>
                <tr align="center" bgcolor="#CCFFFF"> 
                  <td colspan="2"><strong>BIDANG-BIDANG PERLAYANAN KATEGORIAL</strong></td>
                </tr>
                <tr align="center"> 
                  <td height="2" colspan="2"><img src="Images/Spacer.gif" width="1" height="1"></td>
                </tr>
                <tr align="center"> 
                  <td width="24%"><a href="SelectList.php?mode=PW"><img src="Images/PAlogo.jpg" border="0"></a></td>
                  <td width="76%" align="center"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td align="center" bgcolor="#BBFFBB"><a href="SelectList.php?mode=PW"><strong>PELAYANAN 
                          ANAK</strong></a> : <?php echo gettext($PA); ?> Anak</td>
                      </tr>
                      <tr> 
                        <td align="center" bgcolor="#CCFFCC">(Pria <?php echo gettext($PAMale); ?> 
                          / Wanita <?php echo gettext($PAFemale); ?>)</td>
                      </tr>
                    </table></td>
                </tr>
                <tr align="center"> 
                  <td><a href="SelectList.php?mode=PT"><img src="Images/PTlogo.jpg" border="0"></a></td>
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
                  <td><a href="SelectList.php?mode=GP"><img src="Images/GPlogo.jpg" border="0"></a></td>
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
                  <td><a href="SelectList.php?mode=PW"><img src="Images/PWlogo.jpg" border="0"></a></td>
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
                  <td><a href="SelectList.php?mode=PKB"><img src="Images/PKBlogo.jpg" border="0"></a></td>
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
              </table></td>
            <td width="27%" align="center" valign="top"> <table width="75%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td height="3"><img src="Images/Spacer.gif" width="1" height="1"></td>
                </tr>
              </table>
              <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td height="29" align="center" bgcolor="#B3E7FF">Selamat Datang 
                    !!!</td>
                  <td width="22%" rowspan="2" align="center" valign="middle" bgcolor="#B3E7FF"><a href="<? echo"$photo1"; ?>"><img src="<? echo"$photo1"; ?>" name="" width="40" height="52" border="0" align="absmiddle" lowsrc="Images/NoPhoto.gif"></a></td>
                </tr>
                <tr> 
                  <td width="78%" height="24" align="center" bgcolor="#66CCFF"><B><?php echo $_SESSION['UserFirstName'] . " " . $_SESSION['UserLastName']; ?></b></td>
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
                      <tr bgcolor="<? echo($bg); ?>" onmouseover="bgColor='#FFFFCC'" onmouseout="bgColor='<? echo($bg); ?>'" > 
                        <td> 
                          <?			$Ultahke=$Tahunini-$Hasil[per_BirthYear];
			echo ("&nbsp; $No.  <a href='PersonView.php?PersonID=$Hasil[per_ID]'>$Hasil[per_FirstName] $Hasil[per_LastName]</a> ($Ultahke / $Hasil[fam_NamaSek])");
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
              </table> </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="38" colspan="2" align="center"> <table width="99%" border="0" cellspacing="0" cellpadding="0">
                <tr align="center"> 
                  <td>Golongan Darah : 
                    <? while ($Goldarah=mysql_fetch_array($sGoldarah)) {
	  echo " <a href='../gollist.php?gd=$Goldarah[c8]'>$Goldarah[c8]</a> |";
	  }
	  ?>
                  </td>
                </tr>
                <tr align="center"> 
                  <td height="19">Jumlah Sektor Pelayanan : <? echo "<b>$TotalSek </b>"; ?>( 
                    <? while ($data=mysql_fetch_array($sSek)) {?>
                    <? echo " <a href='../seklist.php?id=$data[fam_NamaSek]'>$data[fam_NamaSek]</a>"; ?> 
                    | 
                    <? }
	  ?>
                    )</td>
                </tr>
              </table></td>
          </tr>
          <tr align="center"> 
            <td height="19" colspan="3" align="center" bgcolor="#CEEFFF"><table width="90%" border="1" cellspacing="0" cellpadding="0">
                <tr align="center"> 
                  <td colspan="4"><strong>Daftar Nama Keluarga Sektor Pelayanan</strong> 
                    : <? echo "<b>$data1[fam_NamaSek]</b>";?> </td>
                </tr>
                <tr align="center" bgcolor="#9797FF"> 
                  <td width="4%">No</td>
                  <td width="30%">Keluarga</td>
                  <td width="49%">Alamat</td>
                  <td width="17%">Telp</td>
                </tr>
                <? 
  $no=1;
  $n=1;
  while ($data=mysql_fetch_array($sSekList)) {
       if ($n==1) {
	     //$bg="#BBCCFF";
		 $bg="#BBCCFF";
		 } else {
	     $bg = "#E6F0FF";
		 } 
  ?>
                <tr bgcolor="<? echo($bg); ?>" onmouseover="bgColor='#FFFFCC'" onmouseout="bgColor='<? echo($bg); ?>'" > 
                  <td align="center"><? echo "$no.";?></td>
                  <td>&nbsp;<? echo "<a href='../FamilyView.php?FamilyID=$data[fam_ID]'>$data[fam_Name]</a>";?></td>
                  <td>&nbsp;<? echo "$data[fam_Address1] $data[fam_Kompleks1], $data[fam_Kelurahan1], $data[fam_City]";?></td>
                  <td>&nbsp;<? echo "$data[fam_HomePhone]";?></td>
                </tr>
                <? 
  $no++;
  $n++;
  if ($n>2) {
      $n=1; 
	 }
  } ?>
              </table> </td>
          </tr>
          <tr> 
            <td height="19" colspan="3" align="center" bgcolor="#CEEFFF"> 
              <? require "Include/Footer.php"; ?>
            </td>
          </tr>
        </table>
      </td>
  </tr>
</table>
</center>