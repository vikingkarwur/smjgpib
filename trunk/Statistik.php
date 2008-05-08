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

$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam ORDER BY fam_NamaSek ASC";
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

//$sSQL = "SELECT DISTINCT from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID";
//$sGoldarah = RunQuery($sSQL);
//$Goldarah = mysql_num_rows($sGoldarah);

$sSQL = "SELECT DISTINCT c8 from person_custom ORDER BY c8 ASC";
$sGoldarah = RunQuery($sSQL);


require "Include/Header.php";

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
</script><div id="wrapper">
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="760"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr> 
          <td height="22" colspan="3" bgcolor="#66CCFF"> <div align="center"><?php echo $sPageTitle; ?></div></td>
        </tr>
        <tr> 
          <td width="38%" align="center"> <table width="95%" border="0" cellspacing="0" cellpadding="0">
              <tr bgcolor="#FFFFFF"> 
                <td rowspan="2" align="center"><img src="Images/GPIB_color.jpg" width="59" height="55"></td>
              </tr>
              <tr bgcolor="#FFFFFF"> </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center"> <div align="center">GPIB Jemaat <?php echo gettext("$NamaJemaat");?></div></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center"><?php echo gettext("$AlamatJemaat");?>&nbsp;<?php echo gettext("$KotaJemaat $ZipJemaat");?>&nbsp;<?php echo gettext("$StateJemaat");?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center">Telephone : <?php echo gettext("$PhoneJemaat");?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center">MUPEL <?php echo gettext("$NamaMupel");?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center"><strong><a href="SelectList.php?mode=AnggotaJemaat">Total 
                  Warga Jemaat </a></strong>: <?php echo gettext($Total); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center"> <div align="center"> Orang dari <?php echo gettext($TotalAll); ?>&nbsp;<a href="SelectList.php?mode=NON">(Non 
                    Jemaat: <? echo $TotalNon?>)</a></div></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center"><a href="SelectList.php?mode=AnggotaJemaat1"><strong>Total 
                  Warga Jemaat Pria</strong></a>:<?php echo gettext($TotalMale); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center"> <div align="center"> Orang dari <?php echo gettext($TotalMaleAll); ?>&nbsp;<a href="SelectList.php?mode=MALENON">(Non 
                    Jemaat: <? echo gettext($TotalMaleNon)?>)</a></div></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center"><a href="SelectList.php?mode=AnggotaJemaat2"><strong>Total 
                  Warga Jemaat Wanita</strong></a>: <?php echo gettext($TotalFemale); ?></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center"> <div align="center"> Orang dari <?php echo gettext($TotalFemaleAll); ?>&nbsp;<a href="SelectList.php?mode=FEMALENON">(Non 
                    Jemaat: <?php echo gettext($TotalFemaleNon); ?>)</a></div></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td align="center"><a href="SelectList.php?mode=family">Jumlah 
                  KK </a> : <?php echo gettext($TotalKK); ?></td>
              </tr>
            </table></td>
          <td width="36%" align="center"> <a href="SelectList.php?mode=PW"></a><a href="SelectList.php?mode=GP"></a> 
            <a href="SelectList.php?mode=PKB"></a> <table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
              <tr align="center"> 
                <td width="24%"><img src="Images/PAlogo.jpg" width="50" height="51"></td>
                <td width="76%" align="center"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td align="center" bgcolor="#BBFFBB">Total BPK PA : <?php echo gettext($PA); ?> 
                        Anak</td>
                    </tr>
                    <tr> 
                      <td align="center" bgcolor="#CCFFCC">Pria <?php echo gettext($PAMale); ?> 
                        / Wanita <?php echo gettext($PAFemale); ?></td>
                    </tr>
                  </table></td>
              </tr>
              <tr align="center"> 
                <td><img src="Images/PTlogo.jpg" width="51" height="47"></td>
                <td align="center"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td align="center" bgcolor="#FFFF97"><a href="SelectList.php?mode=PT">Total 
                        BPK PT</a> : <?php echo gettext($PT); ?> Orang</td>
                    </tr>
                    <tr> 
                      <td align="center" bgcolor="#FFFFC1">Pria <?php echo gettext($PTMale); ?> 
                        / Wanita <?php echo gettext($PTFemale); ?></td>
                    </tr>
                  </table></td>
              </tr>
              <tr align="center"> 
                <td><img src="Images/GPlogo.jpg" width="52" height="44"></td>
                <td align="center"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td align="center" bgcolor="#6F6FFF"><a href="SelectList.php?mode=GP">Total 
                        BPK GP</a> : <?php echo gettext($GP); ?> Orang<a href="SelectList.php?mode=GP"></a> 
                      </td>
                    </tr>
                    <tr> 
                      <td align="center" bgcolor="#A8A8FF">Pria <?php echo gettext($GPMale); ?> 
                        / Wanita <?php echo gettext($GPFemale); ?> </td>
                    </tr>
                  </table></td>
              </tr>
              <tr align="center"> 
                <td><img src="Images/PWlogo.jpg" width="53" height="48"></td>
                <td align="center"><a href="SelectList.php?mode=PW"></a> <table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td align="center" bgcolor="#BB00BB"><a href="SelectList.php?mode=PW"><strong>BPK 
                        Pelayanan Wanita</strong></a></td>
                    </tr>
                    <tr> 
                      <td align="center" bgcolor="#FF6CFF"><?php echo gettext($PW); ?> 
                        Orang</td>
                    </tr>
                  </table></td>
              </tr>
              <tr align="center"> 
                <td><img src="Images/PKBlogo.jpg" width="53" height="47"></td>
                <td align="center"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td align="center" bgcolor="#A8A8A8"><a href="SelectList.php?mode=PKB"><strong>BPK 
                        Persekutuan Kaum Bapak</strong></a></td>
                    </tr>
                    <tr> 
                      <td align="center" bgcolor="#D1D1D1"><?php echo gettext($PKB); ?> 
                        Orang</td>
                    </tr>
                  </table></td>
              </tr>
              <tr align="center"> 
                <td>&nbsp;</td>
                <td align="center"><a href="SelectList.php?mode=PKB"></a> </td>
              </tr>
            </table></td>
          <td width="26%" align="center" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="center" bgcolor="#B3E7FF">Selamat Datang !!!</td>
              </tr>
              <tr> 
                <td align="center" bgcolor="#66CCFF"><B><?php echo $_SESSION['UserFirstName'] . " " . $_SESSION['UserLastName']; ?></b></td>
              </tr>
              <tr> 
                <td align="center" bgcolor="#BBE9FF">Versi smjGPIB</td>
              </tr>
              <tr> 
                <td align="center" bgcolor="#66CCFF"><b><?php echo gettext("$sVersi");?></b></td>
              </tr>
              <tr> 
                <td bgcolor="#BBE9FF">&nbsp;</td>
              </tr>
              <tr> 
                <td bgcolor="#CCFFFF">Jemaat Ulang Tahun hari ini :</td>
              </tr>
              <tr> 
                <td bgcolor="#CCFFFF"> 
                  <?php $TGL=DATE(d); $BLN=DATE(F);$THN=DATE(Y);echo "$TGL - $BLN - $THN";?>
                </td>
              </tr>
              <tr> 
                <td height="19" bgcolor="#BBE9FF"> 
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

$No=1;
while ($Hasil=mysql_fetch_array($TotalFemaleListing)) 
            {
			$Ultahke=$Tahunini-$Hasil[per_BirthYear];
			echo ("  $No. <strong> <a href='PersonView.php?PersonID=$Hasil[per_ID]'>$Hasil[per_FirstName] $Hasil[per_LastName] ($Ultahke / $Hasil[fam_NamaSek])</a></strong><BR>");
			$No=$No+1;
			}

?>
                </td>
              </tr>
            </table></td>
        </tr>
        <tr bgcolor="#E6E6E6"> 
          <td rowspan="3" align="center"> <div align="center"> 
              <table width="60%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td colspan="2" align="center">ADVANCE SEARCH </td>
                </tr>
                <tr> 
                  <td colspan="2" align="center"> 
                    <? require ("http://$sHost$sRootPath/QueryView2.php?QueryID=15");?>
                  </td>
                </tr>
              </table>
            </div></td>
          <td height="57" colspan="2" align="center"> <table width="95%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="23%" height="19"><a href="SelectList.php?mode=PENDETA">Pendeta: 
                  <?php echo gettext($Pendeta); ?></a></td>
                <td width="21%"><a href="SelectList.php?mode=PENATUA">Penatua</a>: 
                  <?php echo gettext($Penatua); ?></td>
                <td width="56%"><a href="SelectList.php?mode=DIAKEN">Diaken</a>: 
                  <?php echo gettext($Diaken); ?></td>
              </tr>
              <tr> 
                <td height="19" colspan="3">Golongan Darah : 
                  <? while ($Goldarah=mysql_fetch_array($sGoldarah)) {
	  //echo " $Goldarah[c8] |";
	  echo " <a href='../smjgpib/gollist.php?gd=$Goldarah[c8]'>$Goldarah[c8]</a> |";
	  }
	  ?>
                </td>
              </tr>
              <tr> 
                <td height="19" colspan="3">Jumlah Sektor Pelayanan : <? echo "<b>$TotalSek </b>"; ?>( 
                  <? while ($data=mysql_fetch_array($sSek)) {?>
                  <? echo " <a href='../smjgpib/seklist.php?id=$data[fam_NamaSek]'>$data[fam_NamaSek]</a>"; ?> 
                  | 
                  <? }
	  ?>
                  )</td>
              </tr>
            </table></td>
        </tr>
        <tr align="center" bgcolor="#E6E6E6"> 
          <td height="19" colspan="2" align="left"><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr> 
                <td><table width="99%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <br>-------------------------------------------------------------------------<br>
                      Untuk melihat Anggota jemaat yg berulang tahun selama seminggu, 
                      tekan tombol GENERATE 
                      <form action="Statistik.php" method="POST">
                        <input type=hidden name=A value="generate">
                        <input name="SUBMIT" type=SUBMIT value="GENERATE">
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
			$perintah="INSERT INTO person_hut (ultah_NAMA1, ultah_NAMA2, ultah_KE, ultah_NAMASEK, ultah_TGL, ultah_BLN, ultah_THN, ultah_per_ID, ultah_END) VALUES ('$Hasil[per_FirstName]','$Hasil[per_LastName]','$Ultahke','$Hasil[fam_NamaSek]','$Hasil[per_BirthDay]','$Hasil[per_BirthMonth]','$TAHUNINI','$Hasil[per_ID]','$Hasil[per_MiddleName]')"; 
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
                  </table></td>
              </tr>
              <tr> 
                <td> 
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
                  Jemaat ulang tahun selama seminggu periode (<?php echo "$tglstart-$bulanstart-$TAHUNINISTART s/d $tglakhir - $BULANINI - $TAHUNINI"; ?>)</td>
              </tr>
              <tr> 
                <td></td>
              </tr>
              <tr> 
                <td height="26"> <table width="97%" border="1" cellspacing="0" cellpadding="0">
                    <tr bgcolor="#66CCFF"> 
                      <td width="17%"> <div align="center"><strong>TANGGAL</strong></div></td>
                      <td width="47%"> <div align="center"><strong>N A M A</strong></div></td>
                      <td width="15%"> <div align="center"><strong>Ulang Tahun 
                          Ke</strong></div></td>
                      <td width="21%"> <div align="center"><strong>Sektor Pelayanan</strong></div></td>
                    </tr>
                    <?php
   $No=1;
   $SQL = "SELECT * FROM person_hut";
   $TotalFemaleListing = mysql_query($SQL); 
     while ($Hasil=mysql_fetch_array($TotalFemaleListing))
            {
			//$Ultahke=$Hasil[ultah_THNAKHIR-$Hasil[per_BirthYear];
			echo ("<TR><TD><STRONG>&nbsp;$Hasil[ultah_TGL]-$Hasil[ultah_BLN]-$Hasil[ultah_THN]</STRONG></TD> <TD><STRONG><a href='PersonView.php?PersonID=$Hasil[ultah_per_ID]'>&nbsp;$Hasil[ultah_NAMA1] $Hasil[ultah_END] $Hasil[ultah_NAMA2]</a></STRONG></TD> <TD><STRONG>&nbsp;$Hasil[ultah_KE]</STRONG></TD> <TD><STRONG>&nbsp;$Hasil[ultah_NAMASEK]</STRONG></TD></TR>");
			$No++;
			}
}
?>
                  </table></table></td>
        </tr>
          <tr bgcolor="#E6E6E6"> 
            <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr bgcolor="#E6E6E6"> 
            
          <td height="19" colspan="3" align="center">&nbsp; </td>
        </tr>
      </table></td>
  </tr>
</table>