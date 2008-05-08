<?php
/*******************************************************************************
 *
 *  filename    : KRT.php
 *  last change : 2003-09-03
 *  description : Form Untuk Kebaktian Rumah Tangga
 *
 *  http://www.infocentral.org/
 *  Copyright 2003 Chris Gebhardt
 *
 *  InfoCentral is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 ******************************************************************************/

// Include the function library
require "Include/Config.php";
require "Include/Functions.php";

$sPageTitle = gettext("Directory reports");?>
	<center>
	<table width="760" border="0" cellspacing="0" cellpadding="0">
		<tr><td valign="top">
			<? require "Include/Header.php";?>
		</td></tr>
		<tr>
			<td>
     				<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
     				<tr>
     					<td width="48%" align="center" valign="top">
     						<table width="98%" border="1" cellspacing="0" cellpadding="0">
     						<tr><td colspan="7"><center>
     							Kebaktian Bulan <? echo date("F Y"); ?>
     						</center></td></tr>
     						<tr>
     							<th>No.</th><th>Tanggal</th><th>Sektor</th><th>Keluarga</th><th>Pelayan Firman</th><th>Liturgis</th>
     						</tr>
     						<form method="POST" action="KRT.php">
     						<tr>
     								<td><center>1.</center></td>
     								<td><center><input type="text" size="11" maxlength="10" id="sel1" name="sDate"><input type="image" onclick="return showCalendar('sel1', 'y-mm-dd');" src="Images/calendar.gif"></center></td>
     								<?
     								$sSQL = "SELECT DISTINCT fam_NamaSek FROM family_fam WHERE fam_NamaSek!='' ORDER BY fam_NamaSek";
     								$rsNamaSektor = RunQuery($sSQL);
     								?>
     								<td><center><select name="sSektor">
     								<?
     								while($sNamaSektor = mysql_fetch_array($rsNamaSektor)) {
									echo "<option>$sNamaSektor[0]</option>";
								}
								?>
								</select>
     								</center></td>
     								<?
     								$sSQL = "SELECT * FROM family_fam ORDER BY fam_Name";
								$rsFamilies = RunQuery($sSQL);
								?>
     								<td><center><input type="text" size="12" name="sKeluarga"></center></td>
     								<td><center><input type="text" size="12" name="sPelFir"></center></td>
     								<td><center><input type="text" size="12" name="sLitrugis"></center></td>
     								<td><center><button type=submit name="isi">Tambah</Button></center></td>
						</tr>
     						<tr><td colspan="7"><center>
     							Cetak Daftar Kebaktian Bulan <? echo date("F Y"); ?>
     						</center>
     						</td></tr></form>
     						</table>
     					</td>
     					<td width="48%" align="center" valign="top">
     						<table width="98%" border="1" cellspacing="0" cellpadding="0">
     						<tr><td colspan="7"><center>
     							Kebaktian Bulan <? echo date("F Y", mktime(0, 0, 0, date("m")+1, 1, date("Y"))); ?>
     						</center></td></tr>
     						<tr>
     							<th>No.</th><th>Tanggal</th><th>Sektor</th><th>Keluarga</th><th>Pelayan Firman</th><th>Liturgis</th>
     						</tr>
     						<form method="POST" action="KRT.php">
     						<tr>
     								<td><center>1.</center></td>
     								<td><center><input type="text" size="10" name="sDate"></center></td>
     								<td><center><input type="text" size="2" name="sSektor"></center></td>
     								<td><center><input type="text" size="12" name="sKeluarga"></center></td>
     								<td><center><input type="text" size="12" name="sPelFir"></center></td>
     								<td><center><input type="text" size="12" name="sLitrugis"></center></td>
     								<td><center><button type=submit name="isi">Tambah</Button></center></td>
						</tr>
     						<tr><td colspan="7"><center>
     							Cetak Daftar Kebaktian Bulan <? echo date("F Y", mktime(0, 0, 0, date("m")+1, 1, date("Y"))); ?>
     						</center>
     						</td></tr></form>
     						</table>
 					</td>
				</tr>


