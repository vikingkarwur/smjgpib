<?php
// Include the function library
require "Include/Config.php";
require "Include/Functions.php";

//Set the page title
$sSQL = "Select * from infojemaat";
$sinfojemaat = mysql_fetch_array(RunQuery($sSQL));
extract($sinfojemaat);
$sPageTitle = gettext("List Jemaat Sektor");

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

$sSQL = "SELECT * FROM family_fam WHERE fam_NamaSek=\"$_REQUEST[id]\" ORDER BY fam_Name ASC";
//$sSQL = "SELECT * FROM family_fam WHERE fam_NamaSek=\"III\"";
$sSekList = RunQuery($sSQL);
$sSekList1 = RunQuery($sSQL);
//$Seklist = mysql_num_rows($sSeklist);
$data1=mysql_fetch_array($sSekList1);

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
</script>
<div id="wrapper">
  <div id="column2"> 
    <h3>Current User</h3>
<p><?php echo $_SESSION['UserFirstName'] . " " . $_SESSION['UserLastName']; ?></p>
<h3>Versi smjGPIB</h3>
<p><?php echo gettext("$sVersi");?></p>
<h3>Jemaat</h3>
<p><?php echo gettext("$NamaJemaat");?><br>
  MUPEL <?php echo gettext("$NamaMupel");?><br>
  <?php echo gettext("$AlamatJemaat");?><br>
  <?php echo gettext("$KotaJemaat $ZipJemaat");?><br>
  <?php echo gettext("$StateJemaat");?><br>
  Phone <?php echo gettext("$PhoneJemaat");?></p>
<h3>Statistik Jemaat</h3>
<p>
Total Daftar: <?php echo gettext($TotalAll); ?> (P: <?php echo gettext($TotalMaleAll); ?> / W: <?php echo gettext($TotalFemaleAll); ?> )<br><br/>

Total Warga Jemaat : <br><?php echo gettext($Total); ?> Orang (P: <?php echo gettext($TotalMale); ?> / W: <?php echo gettext($TotalFemale); ?> )<br><br/>

Total KK : <?php echo gettext($TotalKK); ?><br><br>
PKB: <?php echo gettext($PKB); ?><br>
PW: <?php echo gettext($PW); ?><br>
GP: <?php echo gettext($GP); ?> (P: <?php echo gettext($GPMale); ?> / W: <?php echo gettext($GPFemale); ?> )<br>
PT: <?php echo gettext($PT); ?> (P: <?php echo gettext($PTMale); ?> / W: <?php echo gettext($PTFemale); ?> )<br>
PA: <?php echo gettext($PA); ?> (P: <?php echo gettext($PAMale); ?> / W: <?php echo gettext($PAFemale); ?> )<br>
<br> 
Pendeta: <?php echo gettext($Pendeta); ?><br>
Penatua: <?php echo gettext($Penatua); ?><br>
      Diaken: <?php echo gettext($Diaken); ?></p>
  </div>
<div id="column1">
   
  <table width="78%" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><div align="center"> 
          <h4><?php echo $sPageTitle; ?></h4>
        </div></td>
    </tr>
    <tr> 
      <td bgcolor="#66CCFF">&nbsp;</td>
      <td bgcolor="#66CCFF"> <div align="center">Bidang Pelayanan Kategorial</div></td>
    </tr>
    <tr> 
      <td width="50%"><div align="center"><a href="SelectList.php?mode=person">Total 
          Daftar</a> : <?php echo gettext($TotalAll); ?> (Pria : <?php echo gettext($TotalMaleAll); ?> 
          / Wanita : <?php echo gettext($TotalFemaleAll); ?> )</div></td>
      <td width="50%"><strong><a href="SelectList.php?mode=PA">BPK Pelayanan Anak</a></strong></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>Total BPK PA : <?php echo gettext($PA); ?> Anak (perincian : <?php echo gettext($PAMale); ?> 
        Anak Pria dan <?php echo gettext($PAFemale); ?> Anak Wanita)</td>
    </tr>
    <tr> 
      <td><div align="center"><strong><a href="SelectList.php?mode=AnggotaJemaat">Total 
          Warga Jemaat </a></strong>: <?php echo gettext($Total); ?> Orang dari 
          <?php echo gettext($TotalAll); ?>&nbsp;<a href="SelectList.php?mode=NON">(Non 
          Jemaat: <? echo $TotalNon?>)</a></div></td>
      <td><a href="SelectList.php?mode=PT"><strong>BPK Persekutuan Teruna</strong></a></td>
    </tr>
    <tr> 
      <td><div align="center">Dengan Perincian :</div></td>
      <td>Total BPK PT : <?php echo gettext($PT); ?> Orang (perincian : <?php echo gettext($PTMale); ?> 
        Orang Pria dan <?php echo gettext($PTFemale); ?> Orang Wanita)</td>
    </tr>
    <tr> 
      <td><div align="center"><a href="SelectList.php?mode=AnggotaJemaat1">- <strong>Total 
          Warga Jemaat Pria</strong></a>: <?php echo gettext($TotalMale); ?> Orang 
          dari <?php echo gettext($TotalMaleAll); ?>&nbsp;<a href="SelectList.php?mode=MALENON">(Non 
          Jemaat: <? echo gettext($TotalMaleNon)?>)</a></div></td>
      <td><a href="SelectList.php?mode=GP"><strong>BPK Gerakan Pemuda</strong></a></td>
    </tr>
    <tr> 
      <td><div align="center"><a href="SelectList.php?mode=AnggotaJemaat2">- <strong>Total 
          Warga Jemaat Wanita</strong></a>: <?php echo gettext($TotalFemale); ?> 
          Orang dari <?php echo gettext($TotalFemaleAll); ?>&nbsp;<a href="SelectList.php?mode=FEMALENON">(Non 
          Jemaat: <?php echo gettext($TotalFemaleNon); ?>)</a></div></td>
      <td>Total BPK GP : <?php echo gettext($GP); ?> Orang<a href="SelectList.php?mode=GP"></a> 
        (perincian : <?php echo gettext($GPMale); ?> Orang Pria dan <?php echo gettext($GPFemale); ?> 
        Orang Wanita)</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><a href="SelectList.php?mode=PW"><strong>BPK Pelayanan Wanita</strong></a></td>
    </tr>
    <tr> 
      <td><div align="center"><a href="SelectList.php?mode=family">Jumlah KK </a> 
          : <?php echo gettext($TotalKK); ?></div></td>
      <td>Total BPK PW : <?php echo gettext($PW); ?> Orang</td>
    </tr>
    <tr> 
      <td rowspan="2"><div align="center">Jumlah Sektor Pelayanan : <? echo "<b>$TotalSek</b> "; ?>(  
	  <? while ($data=mysql_fetch_array($sSek)) {?>
	  <? echo " <a href='../smjgpib/seklist.php?id=$data[fam_NamaSek]'>$data[fam_NamaSek]</a>"; ?> |
	  <? }
	  ?>)
	  </div></td>
      <td><a href="SelectList.php?mode=PKB"><strong>BPK Persekutuan Kaum Bapak</strong></a></td>
    </tr>
    <tr> 
      <td><a href="SelectList.php?mode=PKB"></a>Total BPK PKB : <?php echo gettext($PKB); ?> 
        Orang</td>
    </tr>
  </table>
<table width="78%" border="1" cellspacing="0" cellpadding="0">
  <tr align="center"> 
    <td colspan="4"><strong>Daftar Nama Keluarga Sektor Pelayanan</strong> : <? echo "<b>$data1[fam_NamaSek]</b>";?> 
    </td>
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
    <td>&nbsp;<? echo "<a href='../smjgpib/FamilyView.php?FamilyID=$data[fam_ID]'>$data[fam_Name]</a>";?></td>
    <td>&nbsp;<? echo "$data[fam_Address1] $data[fam_Kompleks1] $data[fam_Kelurahan1] $data[fam_City]";?></td>
    <td>&nbsp;<? echo "$data[fam_HomePhone]";?></td>
  </tr>
  <? 
  $no++;
  $n++;
  if ($n>2) {
      $n=1; 
	 }
  } ?>
</table>
<? require "Include/Footer.php";?>
