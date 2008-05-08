<?php
/*******************************************************************************
 *
 *  filename    : DirectoryReports.php
 *  last change : 2003-09-03
 *  description : form to invoke directory report
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
require "Include/ReportConfig.php";

// If CSVAdminOnly option is enabled and user is not admin, redirect to the menu.
//if (!$_SESSION['bAdmin'] && $bCSVAdminOnly) {
//	Redirect("Menu.php");
//	exit;
//}

$sSQL = "Select * from infojemaat";
$sinfojemaat = mysql_fetch_array(RunQuery($sSQL));
extract($sinfojemaat);

// Set the page title and include HTML header
$sPageTitle = gettext("Directory reports");
require "Include/Header.php";

?>

<form method="POST" action="Reports/FamilyReport.php">

<?php

// Get classifications for the selects
$sSQL = "SELECT * FROM family_fam ORDER BY fam_Name";
$rsFamilies = RunQuery($sSQL);

?>

<table align="center">
	<tr>
		<td class="LabelColumn"><?php echo gettext("Pilih Keluarga"); ?></td>
		<td class="TextColumn">
			<select name="Family" size="8">
				<option value="0" selected><?php echo gettext("Belum Terisi"); ?></option>
				<option value="0">-----------------------</option>

				<?php
				while ($aRow = mysql_fetch_array($rsFamilies)) {
					extract($aRow);
					echo "<option value=\"" . $fam_ID . "\"";
					if ($iFamily == $fam_ID) { echo " selected"; }
					echo ">" . $fam_Name . "- ". $fam_NoIndFam . "" . FormatAddressLine($fam_Address1, $fam_City, $fam_State);
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="LabelColumn"><?php echo gettext("Halaman Depan:"); ?></td>
		<td class="TextColumn">
			<table>
				<tr>
					<td><?php echo gettext("Pakai Halaman Depan"); ?></td>
					<td><input type="checkbox" Name="bDirUseTitlePage" value="1"></td>
				</tr>
				<tr>
					<td><?php echo gettext("Nama Gereja"); ?></td>
					<td><?php echo gettext($NamaJemaat);?></td>
					<input type="hidden" name="sChurchName" value="<?php echo $NamaJemaat; ?>">
				</tr>
				<tr>
					<td><?php echo gettext("Alamat"); ?></td>
					<td><?php echo gettext($AlamatJemaat);?></td>
					<input type="hidden" name="sChurchAddress" value="<?php echo $AlamatJemaat; ?>">
				</tr>
				<tr>
					<td><?php echo gettext("Kota"); ?></td>
					<td><?php echo gettext($KotaJemaat);?></td>
					<input type="hidden" name="sChurchCity" value="<?php echo $KotaJemaat; ?>">
				</tr>
				<tr>
					<td><?php echo gettext("Propinsi"); ?></td>
					<td><?php echo gettext($StateJemaat);?></td>
					<input type="hidden" name="sChurchState" value="<?php echo $StateJemaat; ?>">
				</tr>
				<tr>
					<td><?php echo gettext("Kode Pos"); ?></td>
					<td><?php echo gettext($ZipJemaat);?></td>
					<input type="hidden" name="sChurchZip" value="<?php echo $ZipJemaat; ?>">
				</tr>
				<tr>
					<td><?php echo gettext("Telepon"); ?></td>
					<td><?php echo gettext($PhoneJemaat);?></td>
					<input type="hidden" name="sChurchPhone" value="<?php echo $PhoneJemaat; ?>">
				</tr>
				<tr>
					<td><?php echo gettext("Peringatan"); ?></td>
					<td><textarea Name="sDirectoryDisclaimer" cols="35" rows="4"><?php echo $sDirectoryDisclaimer;?></textarea></td>
				</tr>

			</table>
		</td>
	</tr>


</table>

<p align="center">
<BR>
<input type="submit" class="icButton" name="Submit" <?php echo 'value="' . gettext("Cetak Kartu Keluarga") . '"'; ?>>
<input type="button" class="icButton" name="Cancel" <?php echo 'value="' . gettext("Batal") . '"'; ?> onclick="javascript:document.location='Menu.php';">
</p>
</form>

<?php
require "Include/Footer.php";
?>
