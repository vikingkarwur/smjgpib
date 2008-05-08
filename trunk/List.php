<?php
// Created by Recky HM
//ob_start;
//Include the function library
//require "Include/Config.php";
//require "Include/Functions.php";

//$sSERVERNAME = "localhost";
//$sUSER = "bethania";
//$sPASSWORD = "bethania";
//$sDATABASE = "smjgpib_bethania";

$sSERVERNAME = "localhost";
$sUSER = "petrabgr";
$sPASSWORD = "petrabgr";
$sDATABASE = "petra-bogor";

$mode = "$_GET[mode]";

$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam WHERE fam_NamaSek!='' ORDER BY fam_NamaSek ASC";
$sSek = RunQuery($sSQL);
$Sek = mysql_num_rows($sSek);

echo"<form action= '$php_self' method='post' />";
echo"Filter by Sektor <select name='sek'>";
echo"<option value=ALL>ALL</option>";
while ($data=mysql_fetch_array($sSek)) { ?>
<option value=<? echo"$data[fam_NamaSek]"; if ($sek==$data[fam_NamaSek]) { echo"selected"; } ?>><? echo"$data[fam_NamaSek]";?></option>
<? }
echo"</select>";
echo"<input type='submit' value='GO' >";
echo"</form>";

$sek="$_POST[sek]";
//echo "dddd $j";
// "ffff $_POST[$j]";
//$And="";
if ($_POST[sek]!="") {
    $And="AND fam_NamaSek=\"$_POST[sek]\"";
    }
if ($_POST[sek]=="ALL") {
    $And="";
    }

if ($mode=="PKB") {
$Var="(DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=1 OR (c16=2 AND per_Gender=1) OR (c16=4 AND per_Gender=1)) AND per_cls_ID=1 $And ";
}
if ($mode=="PW") {
$Var = "(DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2)) AND per_cls_ID=1 $And ";
}
if ($mode=="PA") {
$Var = "DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) >= CURDATE() AND per_cls_ID=1 $And";
}
if ($mode=="PT") {
$Var = "DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) >= CURDATE() AND per_cls_ID=1 $And";
}
if ($mode=="GP") {
$Var = "DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) >= CURDATE() AND c16=1 AND per_cls_ID=1 $And";
}
if ($mode=="LANSIA") {
$Var="DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 60 YEAR) <= CURDATE() AND per_cls_ID=1 $And";
}
if ($mode=="PENDETA") {
$Var="per_cls_ID=1 AND c19 LIKE '%pendeta%' $And";
}
if ($mode=="PENATUA") {
$Var="per_cls_ID=1 AND c19 LIKE '%penatua%' $And";
}
if ($mode=="DIAKEN") {
$Var="per_cls_ID=1 AND c19 LIKE '%diaken%' $And";
}
if ($mode=="PROFESIONAL") {
$Var="per_cls_ID=1 AND (c17 =7 or c17 = 3 or c17=4 or c17=5 or c17=6 or c17=8 or c17=10 or c17=11) $And";
}

//$sSQL = "SELECT per_FirstName FROM person_per ORDER BY per_FirstName ASC";
$sSQL = "SELECT DISTINCT LEFT(per_FirstName,1) AS per_FirstName FROM person_per
LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
WHERE $Var ORDER BY per_FirstName ASC";
$sNama = RunQuery($sSQL);
$Nama = mysql_num_rows($sNama);

//echo"<form action= '$php_self' method='post' />";
//echo"Filter by Abjad <select name='Nama'>";
//echo"<option value=ALL>ALL</option>";
//while ($Nama=mysql_fetch_array($sNama)) {

//$Name1=substr($Nama[per_FirstName],0,1);
?>
<option value=<? //echo"$Name1"; ?>><?
//echo"$Name1"; ?> </option>
<?
//}
//echo"</select>";
//"<input type='submit' name='submit' value='GO' onClick='Menu.php'>";
//echo"</form>";
//echo"<a href='?action=list&mode=$mode&sek=$sek&List.php'>go</a>";
//$Nam="$_POST[Nama]";

//if (submit1) {
//   $And="AND fam_NamaSek=\"$sek\"";
//   }
//if (submit=="GO") {
   //$And="AND fam_NamaSek=\"$sek\"";
//   $j="OK";
//   echo "ehm $j";
//   }
//if ($_POST[sek]=="") {
//   $And="";
//   }

//if ($_POST[Nama]!="") {
//   $Var2="$Var AND per_FirstName LIKE '$Nam%'";
//   }
//if ($_POST[Nama]=="" OR $_POST[Nama]=="ALL") {
//   $Var2=$Var;
//  }


//$sSQL = "SELECT * FROM infojemaat";
//$InfoJem = RunQuery($sSQL);
$nJ=gettext("$nojemaat");
//$nJ=("test");
$nM=gettext("$nomupel");
//echo "dddd $nJ<br>";
//echo gettext("$nojemaat");
//exit;
$sSQL = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE $Var ORDER BY fam_NamaSek ASC, per_FirstName ASC";
$sGoldarah = RunQuery($sSQL);

//$Goldarah = mysql_num_rows($sGoldarah);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE() AND c16=1 AND per_fmr_ID<>0";
//$sSQL = "SELECT * where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE()";
//$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) > CURDATE()";
$sUsia = RunQuery($sSQL);
//$GP = mysql_num_rows($sGP);

$TotSrc = mysql_num_rows($sGoldarah);
?>

<center>
  <table width="760" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="760" align="center" valign="top">
        <table width="99%" border="0" cellspacing="1" cellpadding="1">
          <tr align="center" bgcolor="#CCCCCC">
            <td colspan="10"><? if ($TotSrc > 0) {
 echo"<b>Jumlah $mode ";

 if ($And!="") {
 echo", Sektor pelayanan $sek";
 }
 echo" = $TotSrc Org.</b>";
 }?>
			</td>
          </tr>
          <tr align="center">
            <td width="3%" bgcolor="#9797FF">No</td>
            <td width="6%" bgcolor="#9797FF">ID Jemaat</td>
            <td width="4%" bgcolor="#9797FF">Sek</td>
            <td width="20%" bgcolor="#9797FF">N a m a</td>
            <td width="4%" bgcolor="#9797FF">Usia</td>
            <td width="31%" bgcolor="#9797FF">Alamat</td>
            <td bgcolor="#9797FF">Telp RMH</td>
            <td bgcolor="#9797FF">Telp Kantor</td>
            <td bgcolor="#9797FF">HP</td>
          </tr>
          <?
  $tahunini=DATE(Y);
  $no=1;
  $n=1;
  while ($Goldarah=mysql_fetch_array($sGoldarah)) {
       if ($n==1) {
	     //$bg="#BBCCFF";
		 $bg="#BBCCFF";
		 } else {
	     $bg = "#E6F0FF";
		 }
  ?>
          <tr bgcolor="<? echo($bg); ?>" onMouseOver="bgColor='#FFFFCC'" onMouseOut="bgColor='<? echo($bg); ?>'" >
            <td align="center" ><? echo $no; ?></td>
            <td ><?
			$id=$Goldarah[per_ID];
			$Jumkar=strlen($id);
			If ($Jumkar==1) { $dig="000"; $id1="$nM.$nJ.$dig$id"; }
			If ($Jumkar==2) { $dig="00"; $id1="$nM.$nJ.$dig$id"; }
			If ($Jumkar==3) { $dig="0"; $id1="$nM.$nJ.$dig$id"; }
			If ($Jumkar>=4) { $id1="$nM.$nJ.$id"; }
			echo "$id1";?>
            </td>
            <td align="center" ><? echo "$Goldarah[fam_NamaSek]";?></td>
            <td ><? echo "<a href='./PersonView.php?PersonID=$Goldarah[per_ID]'>$Goldarah[per_FirstName] $Goldarah[per_MiddleName] $Goldarah[per_LastName]</a>";?></td>
            <td align="center" ><? echo $tahunini-$Goldarah[per_BirthYear] ;?></td>
            <td ><? echo "$Goldarah[fam_Address1] $Goldarah[fam_Kompleks1] $Goldarah[fam_Kelurahan1] $Goldarah[fam_City]";?></td>
            <td width="11%" align="center" >
              <?
	 //homephone
	   if ($Goldarah[fam_HomePhone]!='') {
	      echo"&nbsp;$Goldarah[fam_HomePhone]";
		  }
		   ?>
              </a></td>
            <td width="10%" align="center">
              <?
	//worphone
	   if ($Goldarah[per_WorkPhone]=='' AND $Goldarah[per_fmr_ID]!=1 AND $Goldarah[per_fmr_ID]!=0) {
		  echo"&nbsp;<font color=red>$Goldarah[fam_WorkPhone]</font>";
		  } else {
		  if ($Goldarah[per_WorkPhone]=='') {
		      echo"&nbsp;$Goldarah[fam_WorkPhone]";
		     }
		  }
	    if ($Goldarah[per_WorkPhone]!='') {
		  echo"&nbsp;$Goldarah[per_WorkPhone]";
          } ?>
            </td>
            <td width="11%" align="center" >
              <?
	//cellphone
	   if ($Goldarah[per_CellPhone]=='' AND $Goldarah[per_fmr_ID]!=1 AND $Goldarah[per_fmr_ID]!=0) {
		  echo"&nbsp;<font color=red>$Goldarah[fam_CellPhone]</font>";
		  } else {
		  if ($Goldarah[per_CellPhone]=='') {
		      echo"&nbsp;$Goldarah[fam_CellPhone]";
		     }
		  }
	    if ($Goldarah[per_CellPhone]!='') {
		  echo"&nbsp;$Goldarah[per_CellPhone]";
          } ?>
          </td>
          </tr>
          <?
  $no++;
  $n++;
  if ($n>2) {
      $n=1;
	 }
  }?>
        </table>
      </td>
    </tr>
  </table>
</center>