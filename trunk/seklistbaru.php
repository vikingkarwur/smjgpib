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
//$sSERVERNAME = "localhost";
//$sUSER = "bukitsion";
//$sPASSWORD = "bukitsion1234";
//$sDATABASE = "smjgpib";

$sSERVERNAME = "localhost";
$sUSER = "petrabgr";
$sPASSWORD = "petrabgr";
$sDATABASE = "petra-bogor";

// Include the function library
//require "Include/Config.php";
//require "Include/Functions.php";

//Set the page title
$Var = $_GET[sek];
$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam";
$sSek = RunQuery($sSQL);
$Sek = mysql_num_rows($sSek);

$sSQL = "SELECT * FROM family_fam WHERE fam_NamaSek=\"$Var\" ORDER BY fam_Name ASC";
//$sSQL = "SELECT * FROM family_fam WHERE fam_NamaSek=\"III\"";
$sSekList = RunQuery($sSQL);
$sSekList1 = RunQuery($sSQL);
//$Seklist = mysql_num_rows($sSeklist);
$data1=mysql_fetch_array($sSekList1);
//$data2=mysql_fetch_array($Sek);

?>
<center>
<table width="760" border="0" cellspacing="0" cellpadding="0">
  <tr> 
      <td width="760" height="57" valign="top"> 
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr align="center"> 
            <td height="19" align="center">
<table width="95%" border="0" cellspacing="1" cellpadding="1">
                <tr align="center" bgcolor="#B0B0B0"> 
                  <td colspan="4"><strong>Daftar Nama Keluarga Sektor Pelayanan</strong> 
                    : <? echo "<b>$data1[fam_NamaSek] | Jumlah = $_GET[KK] KK | $_GET[jiwa] Jiwa</b>";?> 
                  </td>
                </tr>
                <tr align="center" bgcolor="#9797FF"> 
                  <td width="4%">No</td>
                  <td width="25%">Keluarga</td>
                  <td width="57%">Alamat</td>
                  <td width="14%">Telp</td>
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
                  <td>&nbsp;<? echo"<a href='./FamilyView.php?FamilyID=$data[fam_ID]'>$data[fam_Name]</a>";?></td>
                  <td>&nbsp;<? echo"$data[fam_Address1] $data[fam_Kompleks1], $data[fam_Kelurahan1], $data[fam_City]";?></td>
                  <td>&nbsp;<? echo"$data[fam_HomePhone]";?></td>
                </tr>
                <? 
  $no++;
  $n++;
  if ($n>2) {
      $n=1; 
	 }
  } ?>
              </table>
            </td>
          </tr>
        </table>
      </td>
  </tr>
</table>
</center>