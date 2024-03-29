<?php
/*******************************************************************************
 *
 *  filename    : FamilyView.php
 *  last change : 2002-04-18
 *  website     : http://www.infocentral.org
 *  copyright   : Copyright 2001, 2002 Deane Barker, 2003 Chris Gebhardt
 *
 *  InfoCentral is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 ******************************************************************************/

//Include the function library
require "Include/Config.php";
require "Include/Functions.php";

//Set the page title
$sPageTitle = gettext("Data Keluarga");

//Get the FamilyID out of the querystring
$iFamilyID = FilterInput($_GET["FamilyID"],'int');

//Are we changing the classification?
if (isset($_POST["Classification"]) && $_SESSION['bEditRecords'])
{
	$iNewClass = FilterInput($_POST["Classification"],'int');
	$sSQL = "UPDATE person_per SET per_cls_ID = " . $iNewClass . " WHERE per_fam_ID = " . $iFamilyID;
	RunQuery($sSQL);
}

$dSQL = "SELECT fam_ID FROM family_fam order by fam_Name";
$dResults = RunQuery($dSQL);

$last_id = 0;
$next_id = 0;
$capture_next = 0;
while($myrow = mysql_fetch_row($dResults))
{
	$fid = $myrow[0];
	if ($capture_next == 1)
	{
	    $next_id = $fid;
		break;
	}
	if ($fid == $iFamilyID)
	{
		$previous_id = $last_id;
		$capture_next = 1;
	}
	$last_id = $fid;
}

if (($previous_id > 0)) {
    $previous_link_text = "<a class=\"SmallText\" href=\"FamilyView.php?FamilyID=$previous_id\">" . gettext("Keluarga Sebelumnya") . "</a>";
}

if (($next_id > 0)) {
    $next_link_text = "<a class=\"SmallText\" href=\"FamilyView.php?FamilyID=$next_id\">" . gettext("Keluarga Selanjutnya") . "</a>";
}

//Get the information for this family
$sSQL = "SELECT *, a.per_FirstName AS EnteredFirstName, a.Per_LastName AS EnteredLastName, b.per_FirstName AS EditedFirstName, b.per_LastName AS EditedLastName
		FROM family_fam
		LEFT JOIN person_per a ON fam_EnteredBy = a.per_ID
		LEFT JOIN person_per b ON fam_EditedBy = b.per_ID
		WHERE fam_ID = " . $iFamilyID;
$rsFamily = RunQuery($sSQL);
extract(mysql_fetch_array($rsFamily));

//Get the notes for this family
$sSQL = "SELECT nte_ID, nte_Text, nte_DateEntered, nte_EnteredBy, nte_DateLastEdited, nte_EditedBy, a.per_FirstName AS EnteredFirstName, a.Per_LastName AS EnteredLastName, b.per_FirstName AS EditedFirstName, b.per_LastName AS EditedLastName 		FROM note_nte
		LEFT JOIN person_per a ON nte_EnteredBy = a.per_ID
		LEFT JOIN person_per b ON nte_EditedBy = b.per_ID
		WHERE nte_fam_ID = " . $iFamilyID . " AND (nte_Private = 0 OR nte_Private = " . $_SESSION['iUserID'] . ")";
$rsNotes = RunQuery($sSQL);

//Get the family members for this family
$sSQL = "SELECT per_ID, per_Title, per_FirstName, per_LastName, per_Suffix, per_Gender,
		per_BirthMonth, per_BirthDay, per_BirthYear, cls.lst_OptionName AS sClassName, fmr.lst_OptionName AS sFamRole
		FROM person_per
		LEFT JOIN list_lst cls ON per_cls_ID = cls.lst_OptionID AND cls.lst_ID = 1
		LEFT JOIN list_lst fmr ON per_fmr_ID = fmr.lst_OptionID AND fmr.lst_ID = 2
		WHERE per_fam_ID = " . $iFamilyID . " ORDER BY fmr.lst_OptionSequence";
$rsFamilyMembers = RunQuery($sSQL);

//Get the Properties assigned to this Family
$sSQL = "SELECT pro_Name, pro_ID, pro_Prompt, r2p_Value, prt_Name, pro_prt_ID
		FROM record2property_r2p
		LEFT JOIN property_pro ON pro_ID = r2p_pro_ID
		LEFT JOIN propertytype_prt ON propertytype_prt.prt_ID = property_pro.pro_prt_ID
		WHERE pro_Class = 'f' AND r2p_record_ID = " . $iFamilyID .
		" ORDER BY prt_Name, pro_Name";
$rsAssignedProperties = RunQuery($sSQL);

//Get all the properties
$sSQL = "SELECT * FROM property_pro WHERE pro_Class = 'f' ORDER BY pro_Name";
$rsProperties = RunQuery($sSQL);

//Get classifications
$sSQL = "SELECT * FROM list_lst WHERE lst_ID = 1 ORDER BY lst_OptionSequence";
$rsClassifications = RunQuery($sSQL);

//Set the spacer cell width
$iTableSpacerWidth = 10;

// Format the phone numbers
$sHomePhone = ExpandPhoneNumber($fam_HomePhone,$fam_Country,$dummy);
$sWorkPhone = ExpandPhoneNumber($fam_WorkPhone,$fam_Country,$dummy);
$sCellPhone = ExpandPhoneNumber($fam_CellPhone,$fam_Country,$dummy);

require "Include/Header.php";


echo"<br><center>";
if ($previous_link_text) {
	echo "$previous_link_text | ";
}
if ($_SESSION['bEditRecords']) { echo "<a class=\"SmallText\" href=\"FamilyEditor.php?FamilyID=" . $fam_ID . "\">" . gettext("Ubah data ini") . "</a>"; }
if ($_SESSION['bDeleteRecords']) { echo " | <a class=\"SmallText\" href=\"SelectDelete.php?FamilyID=" . $fam_ID . "\">" . gettext("Hapus data ini") . "</a>"; } ?>
 | <a href="Reports\FamilyReport.php?Family=<?php echo $fam_ID . "&bDirUseTitlePage=1"; ?>" class="SmallText"><?php echo gettext("Cetak kartu keluarga"); ?></a><?php
if ($next_link_text && ($_SESSION['bEditRecords'] || $_SESSION['bDeleteRecords'])) {
	echo " | $next_link_text";
}
elseif ($next_link_text) {
	echo "$next_link_text";
}
?>
<BR><br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
<tr>
<td width="25%" valign="top" align="center">
	<div class="LightShadedBox">
	<?php
		//Print the name and address header
		echo "<font size=\"4\"><b>" . gettext("Keluarga") . " $fam_Name </b></font>";
		echo "<br><br>\n<font size=\"3\"><b>";
		echo $fam_NoIndFam . "." . $fam_NamaSek . "</b></font>";
		echo "<br><br>";
		echo "<div class=\"TinyShadedBox\">";
		echo "<font size=\"3\">";
			if ($fam_Address1 != "") { echo $fam_Address1 . "<br>"; }
// Add for GPIB
			if ($fam_Kompleks1 !="") { echo "Kompleks " . $fam_Kompleks1 . "<br>"; }
			if ($fam_RTRW1 != "") { echo "RT-RW " . $fam_RTRW1 . " "; }
			if ($fam_Kelurahan1 != "") {echo "Kelurahan " . $fam_Kelurahan1 . "<br>"; }
// End Add
			if ($fam_Address2 != "") { echo $fam_Address2 . "<br>"; }
// Add for GPIB
			if ($fam_Kompleks2 !="") { echo "Kompleks " . $fam_Kompleks2 . "<br>"; }
			if ($fam_RTRW2 != "") { echo "RT-RW " . $fam_RTRW2 . " "; }
			if ($fam_Kelurahan2 != "") {echo "Kelurahan " . $fam_Kelurahan2 . "<br>"; }
// End Add
			if ($fam_City != "") { echo $fam_City . ", "; }
			if ($fam_State != "") { echo $fam_State; }
			if ($fam_Zip != "") { echo " " . $fam_Zip; }
			if ($fam_Country != "") { echo "<br>" . $fam_Country; }
		echo "</font>";
		echo "</div>";

		//Show link to mapquest
		if ($fam_Address1 != "" && $fam_City != "" && $fam_State != "")
		{
			if ($fam_Country == "United States") {
				$sMQcountry = "";
				$bShowMQLink = true;
			}
			elseif ($fam_Country == "Canada") {
				$sMQcountry = "country=CA&";
				$bShowMQLink = true;
			}
			else
				$bShowMQLink = false;
		}

		if ($bShowMQLink)
			echo "<div align=\"right\"><a class=\"SmallText\" target=\"_blank\" href=\"http://www.mapquest.com/maps/map.adp?" .$sMQcountry . "city=" . urlencode($fam_City) . "&state=" . $fam_State . "&address=" . urlencode($fam_Address1) . "\">" . gettext("View Map") . "</a></div>";
		echo "<br>";

		// Upload photo
		if ( isset($_POST["UploadPhoto"]) && ($_SESSION['bAddRecords'] || $_SESSION['bEditRecords']) ) {
			if ($_FILES['Photo']['name'] == "") {
				$PhotoError = gettext("Tidak ada foto yang dipilih.");
			} elseif ($_FILES['Photo']['type'] != "image/pjpeg" && $_FILES['Photo']['type'] != "image/jpeg") {
				$PhotoError = gettext("Hanya Gambar dengan tupe jpeg yang bisa ditampilkan.");
			} else {
				// Create the thumbnail used by PersonView
				$srcImage=imagecreatefromjpeg($_FILES['Photo']['tmp_name']);
				$src_w=imageSX($srcImage);
    			$src_h=imageSY($srcImage);

				// Calculate thumbnail's height and width (a "maxpect" algorithm)
				$dst_max_w = 200;
				$dst_max_h = 350;
				if ($src_w > $dst_max_w) {
					$thumb_w=$dst_max_w;
					$thumb_h=$src_h*($dst_max_w/$src_w);
					if ($thumb_h > $dst_max_h) {
						$thumb_h = $dst_max_h;
						$thumb_w = $src_w*($dst_max_h/$src_h);
					}
				}
				elseif ($src_h > $dst_max_h) {
					$thumb_h=$dst_max_h;
					$thumb_w=$src_w*($dst_max_h/$src_h);
					if ($thumb_w > $dst_max_w) {
						$thumb_w = $dst_max_w;
						$thumb_h = $src_h*($dst_max_w/$src_w);
					}
				}
				else {
					if ($src_w > $src_h) {
						$thumb_w = $dst_max_w;
						$thumb_h = $src_h*($dst_max_w/$src_w);
					} elseif ($src_w < $src_h) {
						$thumb_h = $dst_max_h;
						$thumb_w = $src_w*($dst_max_h/$src_h);
					} else {
						if ($dst_max_w >= $dst_max_h) {
							$thumb_w=$dst_max_h;
							$thumb_h=$dst_max_h;
						} else {
							$thumb_w=$dst_max_w;
							$thumb_h=$dst_max_w;
						}
					}
				}
				$dstImage=ImageCreateTrueColor($thumb_w,$thumb_h);
        		imagecopyresampled($dstImage,$srcImage,0,0,0,0,$thumb_w,$thumb_h,$src_w,$src_h);
				imagejpeg($dstImage,"Images/Family/thumbnails/" . $iFamilyID . ".jpg");
				imagedestroy($dstImage);
    			imagedestroy($srcImage);
				move_uploaded_file($_FILES['Photo']['tmp_name'], "Images/Family/" . $iFamilyID . ".jpg");
			}
		} elseif (isset($_POST["DeletePhoto"]) && $_SESSION['bDeleteRecords']) {
			unlink("Images/Family/" . $iFamilyID . ".jpg");
			unlink("Images/Family/thumbnails/" . $iFamilyID . ".jpg");
		}

		// Display photo or upload from file
		$photoFile = "Images/Family/thumbnails/" . $iFamilyID . ".jpg";
		if (file_exists($photoFile))
		{
			echo "<a target=\"_blank\" href=\"Images/Family/" . $iFamilyID . ".jpg\">";
			echo "<img border=\"1\" src=\"$photoFile\"></a>";
			if ($_SESSION['bEditRecords']) {
				echo "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "?FamilyID=" . $iFamilyID . "\">";
				echo "<br><input type=\"submit\" class=\"icTinyButton\" value=\"" . gettext("Delete Photo") . "\" name=\"DeletePhoto\">";
				echo "</form>";
			}
		} else {
			// Some old / M$ browsers can't handle PNG's correctly.
			if ($bDefectiveBrowser)
				echo "<img border=\"0\" src=\"Images/NoFamPhoto.gif\"><br><br><br>";
			else
				echo "<img border=\"0\" src=\"Images/NoFamPhoto.png\"><br><br><br>";

			if ($_SESSION['bEditRecords']) {
				if (isset($PhotoError)) echo "<span style=\"color: red;\">" . $PhotoError . "</span><br>";
				echo "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "?FamilyID=" . $iFamilyID . "\" enctype=\"multipart/form-data\">";
				echo "<input class=\"icTinyButton\" type=\"file\" name=\"Photo\"> <input type=\"submit\" class=\"icTinyButton\" value=\"" . gettext("Upload Photo") . "\" name=\"UploadPhoto\">";
				echo "</form>";
			}
		}
	?>
	</div>
</td>
<td width="75%" valign="top" align="left">

	<b><?php echo gettext("Informasi Umum:"); ?></b>
	<div class="LightShadedBox">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td align="center">
			<table cellspacing="4" cellpadding="0" border="0">
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Telpon Rumah:"); ?></td>
				<td class="TinyTextColumn"><?php echo $sHomePhone; ?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Telpon Kantor:"); ?></td>
				<td class="TinyTextColumn"><?php echo $sWorkPhone; ?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Handphone:"); ?></td>
				<td class="TinyTextColumn"><?php echo $sCellPhone; ?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Email:"); ?></td>
				<td class="TinyTextColumn"><?php if ($fam_Email != "") { echo "<a href='mailto:" . $fam_Email . "'>" . $fam_Email . "</a>"; } ?>				  </td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Tanggal Nikah:"); ?></td>
				<td class="TinyTextColumn"><?php echo FormatDate($fam_WeddingDate,false) ?>				  </td>
			</tr>
<?php
// Added for GPIB ?>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Tanggal Terdaftar:"); ?></td>
				<td class="TinyTextColumn"><?php echo FormatDate($fam_MembershipDate,false) ?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Asal Gereja Sebelum:"); ?></td>
				<td class="TinyTextColumn"><?php
					if ($fam_AsalGS == "G") { echo "GPIB"; }
					if ($fam_AsalGS == "N") { echo "Non-GPIB"; }
				?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Nama Gereja Sebelum:"); ?></td>
				<td class="TinyTextColumn"><?php echo $fam_NamaGS ?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Nama Sektor Pelayanan:"); ?></td>
				<td class="TinyTextColumn"><?php echo $fam_NamaSek ?></td>
			</tr>
			<tr>
			<td class="TinyLabelColumn"><?php echo gettext("Status Rumah :"); ?></td>
				<td class="TinyTextColumn"><?php echo $fam_StatusRumah ?></td>
			</tr>

<?php
// End Added ?>
			</table>
		</td>
	</tr>
	</table>
	</div>
	<BR>
	<b><?php echo gettext("Assigned Properties:"); ?></b>
    <?php

$sAssignedProperties = ",";

//Was anything returned?
if (mysql_num_rows($rsAssignedProperties) == 0)
{
	//No, indicate nothing returned
	echo "<p align\"center\">" . gettext("No property assignments.") . "</p>";
}
else
{

	//Yes, start the table
	echo "<table width=\"100%\" cellpadding=\"4\" cellspacing=\"0\">";
	echo "<tr class=\"TableHeader\">";
	echo "<td width=\"10%\" valign=\"top\"><b>" . gettext("Type") . "</b></td>";
	echo "<td width=\"15%\" valign=\"top\"><b>" . gettext("Name") . "</b></td>";
	echo "<td valign=\"top\"><b>" . gettext("Value") . "</b></td>";

	if ($_SESSION['bEditRecords'])
	{
		echo "<td width=\"10%\" valign=\"top\"><b>" . gettext("Edit Value") . "</td>";
		echo "<td valign=\"top\"><b>" . gettext("Remove") . "</td>";
	}

	echo "</tr>";

	$last_pro_prt_ID = "";
	$bIsFirst = true;

	//Loop through the rows
	while ($aRow = mysql_fetch_array($rsAssignedProperties))
	{
		$pro_Prompt = "";
		$r2p_Value = "";

		extract($aRow);

		if ($pro_prt_ID != $last_pro_prt_ID)
		{
			echo "<tr class=\"";
			if ($bIsFirst)
				echo "RowColorB";
			else
				echo "RowColorC";
			echo "\"><td><b>" . $prt_Name . "</b></td>";

			$bIsFirst = false;
			$last_pro_prt_ID = $pro_prt_ID;
			$sRowClass = "RowColorB";
		}
		else
		{
			echo "<tr class=\"" . $sRowClass . "\">";
			echo "<td valign=\"top\">&nbsp;</td>";
		}

		echo "<td valign=\"center\">" . $pro_Name . "</td>";
		echo "<td valign=\"center\">" . $r2p_Value . "&nbsp;</td>";

		if ($_SESSION['bEditRecords'])
		{
			if (strlen($pro_Prompt) > 0)
			{
				echo "<td valign=\"center\"><a href=\"PropertyAssign.php?FamilyID=" . $iFamilyID . "&PropertyID=" . $pro_ID . "\">" . gettext("Edit Value") . "</a></td>";
			}
			else
			{
				echo "<td>&nbsp;</td>";
			}

			echo "<td valign=\"center\"><a href=\"PropertyUnassign.php?FamilyID=" . $iFamilyID . "&PropertyID=" . $pro_ID . "\">" . gettext("Remove") . "</a></td>";
		}

		echo "</tr>";

		//Alternate the row style
		$sRowClass = AlternateRowStyle($sRowClass);

		$sAssignedProperties .= $pro_ID . ",";
	}

	//Close the table
	echo "</table>";

}

?>
    <?php if ($_SESSION['bEditRecords']) { ?>
    <form method="post" action="PropertyAssign.php?FamilyID=<?php echo $iFamilyID ?>">
      <p align="center">"<b>Perhatian ketika record Family ini di Assign, maka secara otomatis akan mengahapus seluruh
	  field pada seluruh anggota keluaraga </b>" <br><span class="SmallText"><?php echo gettext("Assign a New Property:"); ?></span>
          <select name="PropertyID">
            <?php
		while ($aRow = mysql_fetch_array($rsProperties))
		{
			extract($aRow);
			//If the property doesn't already exist for this Person, write the <OPTION> tag
			if (strlen(strstr($sAssignedProperties,"," . $pro_ID . ",")) == 0)
			{
				echo "<option value=\"" . $pro_ID . "\">" . $pro_Name . "</option>";
			}
		}
		?>
          </select>
          <input type="submit" class="icButton" value="Assign" name="Submit2" style="font-size: 8pt;">
      </p>
    </form>
	<?php } ?>
</td>
  </tr>
</table>
<BR>
<?php
if ($previous_link_text) {
	echo "$previous_link_text | ";
}
if ($_SESSION['bEditRecords']) { echo "<a class=\"SmallText\" href=\"FamilyEditor.php?FamilyID=" . $fam_ID . "\">" . gettext("Ubah data ini") . "</a>"; }
if ($_SESSION['bDeleteRecords']) { echo " | <a class=\"SmallText\" href=\"SelectDelete.php?FamilyID=" . $fam_ID . "\">" . gettext("Hapus data ini") . "</a>"; }
if ($next_link_text && ($_SESSION['bEditRecords'] || $_SESSION['bDeleteRecords'])) {
	echo " | $next_link_text";
}
elseif ($next_link_text) {
	echo "$next_link_text";
}
?>
<p class="SmallText">
	<?php echo gettext("Diisi:"); ?> <?php echo FormatDate($fam_DateEntered,True) . " oleh " . $EnteredFirstName . " " . $EnteredLastName; ?>
	<br>

	<?php
	if (strlen($fam_DateLastEdited) > 0)
	{
		echo gettext("Last edited:") . " " . FormatDate($fam_DateLastEdited,True) . " ". gettext("by") . " " . $EditedFirstName . " " . $EditedLastName;
	}
	?>
</p>

<b><?php echo gettext("Anggota Keluarga:"); ?></b>

<table cellpadding="5" cellspacing="0" width="100%">

<tr class="TableHeader">
	<td><?php echo gettext("Nama"); ?></td>
	<td><?php echo gettext("Jenis Kelamin"); ?></td>
	<td><?php echo gettext("Status"); ?></td>
	<td><?php echo gettext("Umur"); ?></td>
	<td><?php echo gettext("Klasifikasi"); ?></td>
	<td><?php echo gettext("Ubah"); ?></td>
</tr>

<?php

$sRowClass = "RowColorA";

//Loop through all the family members
while ($aRow =mysql_fetch_array($rsFamilyMembers))
{
	$per_Title = "";
	$per_FirstName = "";
	$per_LastName = "";
	$per_Suffix = "";
	$per_Gender = "";
	$per_BirthMonth = "";
	$per_BirthDay = "";
	$per_BirthYear = "";

	$sFamRole = "";
	$sClassName = "";

	extract($aRow);

	//Alternate the row style
	$sRowClass = AlternateRowStyle($sRowClass)

	//Display the family member
	?>

	<tr class="<?php echo $sRowClass ?>">
		<td>
			<a href="PersonView.php?PersonID=<?php echo $per_ID ?>"><?php
		if ($per_Suffix)
		{
			if ($per_Title)
			{
				 echo $per_Title . " " . $per_FirstName . " " . $per_LastName . ", " . $per_Suffix;
			}
			else
			{
				 echo $per_FirstName . " " . $per_LastName . ", " . $per_Suffix;
			}
		}
		else
		{
			if ($per_Title)
			{
				echo $per_Title . " " . $per_FirstName . " " . $per_LastName;
			}
			else
			{
				echo $per_FirstName . " " . $per_LastName;
			}
		}?></a>
			<br>
		</td>
		<td>
			<?php switch ($per_Gender) {case 1: echo gettext("Laki-laki"); break; case 2: echo gettext("Perempuan"); break; default: echo "";} ?>&nbsp;
		</td>
		<td>
			<?php echo $sFamRole ?>&nbsp;
		</td>
		<td>
			<?php PrintAge($per_BirthMonth,$per_BirthDay,$per_BirthYear); ?>
		</td>
		<td><?php echo $sClassName; ?>&nbsp;</td>
		<td><a href="PersonEditor.php?PersonID=<?php echo $per_ID ?>">Ubah</a></td>
	</tr>

	<?php

}

?>

</table>

<?php if ($_SESSION['bEditRecords']) { ?>
<p align="center">
<form method="post" action="FamilyView.php?FamilyID=<?php echo $iFamilyID; ?>">
  <span class="SmallText"><?php echo gettext("Assign a New Classification:"); ?></span>
  <select name="Classification">
		<option value="0"><?php echo gettext("Select Classification"); ?></option>
		<option value="0">---------------------</option>
		<?php

		while ($aRow = mysql_fetch_array($rsClassifications))
		{
			extract($aRow);
			echo "<option value=\"" . $lst_OptionID . "\">" . $lst_OptionName . "</option>";
		}

		?>
	</select>
	<input type="submit" class="icButton" <?php echo 'value="' . gettext("Change") . '"'; ?> name="Submit" style="font-size: 8pt;">
	<br>
	<span class="SmallText"><?php echo gettext("(This will reset the Classification of ALL family members.)"); ?></span>
</form>
</p>
<?php } else { echo "<br>"; } ?>

<?php if ($_SESSION['bNotes']) { ?>
<p>
	<b><?php echo gettext("Notes:"); ?></b>
</p>

<p>
	<a class="SmallText" href="NoteEditor.php?FamilyID=<?php echo $fam_ID ?>"><?php echo gettext("Add a Note to this Record"); ?></a></font>
<p>

<?php

//Loop through all the notes
while($aRow = mysql_fetch_array($rsNotes))
{
	extract($aRow);

	?>

<p class="ShadedBox")>
		<?php echo $nte_Text ?>
</p>
	<span class="SmallText"><?php echo gettext("Entered:") . ' ' . FormatDate($nte_DateEntered,True) . ' ' . gettext("by") . ' ' . $EnteredFirstName . " " . $EnteredLastName ?></span>
	<br>
	<?php

	if (strlen($nte_DateLastEdited) > 0)
	{ ?>
		<span class="SmallText"><?php echo gettext("Last Edited:") . ' ' . FormatDate($nte_DateLastEdited,True) . ' ' . gettext("by") . ' ' . $EditedFirstName . " " . $EditedLastName ?></span>
		<br>
	<?php
	} ?>
	<a class="SmallText" href="NoteEditor.php?FamilyID=<?php echo $iFamilyID ?>&NoteID=<?php echo $nte_ID ?>"><?php echo gettext("Edit This Note"); ?></a></span>
	|
	<a class="SmallText" href="NoteDelete.php?NoteID=<?php echo $nte_ID ?>"><?php echo gettext("Delete This Note"); ?></a>

	<?php

}
?>
<?php } ?>

<?php
require "Include/Footer.php";
?>
