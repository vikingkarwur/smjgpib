<?php
/*******************************************************************************
 *
 *  filename    : PersonView.php
 *  last change : 2003-04-14
 *  description : Displays all the information about a single person
 *
 *  http://www.infocentral.org/
 *  Copyright 2001-2003 Phillip Hullquist, Deane Barker, Chris Gebhardt
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

// Get the person ID from the querystring
$iPersonID = FilterInput($_GET["PersonID"],'int');

if ( isset($_POST["GroupAssign"]) && $_SESSION['bManageGroups'] )
{
	$iGroupID = FilterInput($_POST["GroupAssignID"],'int');
	AddToGroup($iPersonID,$iGroupID,0);
}

$dSQL= "SELECT per_ID FROM person_per order by per_LastName, per_FirstName";
$dResults = RunQuery($dSQL);

$last_id = 0;
$next_id = 0;
$capture_next = 0;
while($myrow = mysql_fetch_row($dResults))
{
	$pid = $myrow[0];
	if ($capture_next == 1)
	{
	    $next_id = $pid;
		break;
	}
	if ($pid == $iPersonID)
	{
		$previous_id = $last_id;
		$capture_next = 1;
	}
	$last_id = $pid;
}

if (($previous_id > 0)) {
    $previous_link_text = "<a class=\"SmallText\" href=\"PersonView.php?PersonID=$previous_id\">" . gettext("Previous Person") . "</a>";
}

if (($next_id > 0)) {
    $next_link_text = "<a class=\"SmallText\" href=\"PersonView.php?PersonID=$next_id\">" . gettext("Next Person") . "</a>";
}

// Get this person's data
$sSQL = "SELECT a.*, family_fam.*, cls.lst_OptionName AS sClassName, fmr.lst_OptionName AS sFamRole, b.per_FirstName AS EnteredFirstName,
				b.Per_LastName AS EnteredLastName, c.per_FirstName AS EditedFirstName, c.per_LastName AS EditedLastName
			FROM person_per a
			LEFT JOIN family_fam ON a.per_fam_ID = family_fam.fam_ID
			LEFT JOIN list_lst cls ON a.per_cls_ID = cls.lst_OptionID AND cls.lst_ID = 1
			LEFT JOIN list_lst fmr ON a.per_fmr_ID = fmr.lst_OptionID AND fmr.lst_ID = 2
			LEFT JOIN person_per b ON a.per_EnteredBy = b.per_ID
			LEFT JOIN person_per c ON a.per_EditedBy = c.per_ID
			WHERE a.per_ID = " . $iPersonID;
$rsPerson = RunQuery($sSQL);
extract(mysql_fetch_array($rsPerson));

// Get the lists of custom person fields
$sSQL = "SELECT person_custom_master.* FROM person_custom_master
			WHERE custom_Side = 'left' ORDER BY custom_Order";
$rsLeftCustomFields = RunQuery($sSQL);

$sSQL = "SELECT person_custom_master.* FROM person_custom_master
			WHERE custom_Side = 'right' ORDER BY custom_Order";
$rsRightCustomFields = RunQuery($sSQL);

// Get the custom field data for this person.
$sSQL = "SELECT * FROM person_custom WHERE per_ID = " . $iPersonID;
$rsCustomData = RunQuery($sSQL);
$aCustomData = mysql_fetch_array($rsCustomData, MYSQL_BOTH);

// Get the notes for this person
$sSQL = "SELECT nte_Private, nte_ID, nte_Text, nte_DateEntered, nte_EnteredBy, nte_DateLastEdited, nte_EditedBy, a.per_FirstName AS EnteredFirstName, a.Per_LastName AS EnteredLastName, b.per_FirstName AS EditedFirstName, b.per_LastName AS EditedLastName ";
$sSQL .= "FROM note_nte ";
$sSQL .= "LEFT JOIN person_per a ON nte_EnteredBy = a.per_ID ";
$sSQL .= "LEFT JOIN person_per b ON nte_EditedBy = b.per_ID ";
$sSQL .= "WHERE nte_per_ID = " . $iPersonID;

// Admins should see all notes, private or not.  Otherwise, only get notes marked non-private or private to the current user.
if (!$_SESSION['bAdmin'])
	$sSQL .= " AND (nte_Private = 0 OR nte_Private = " . $_SESSION['iUserID'] . ")";

$rsNotes = RunQuery($sSQL);

// Get the Groups this Person is assigned to
$sSQL = "SELECT grp_ID, grp_Name, grp_hasSpecialProps, role.lst_OptionName AS roleName
		FROM group_grp
		LEFT JOIN person2group2role_p2g2r ON p2g2r_grp_ID = grp_ID
		LEFT JOIN list_lst role ON lst_OptionID = p2g2r_rle_ID AND lst_ID = grp_RoleListID
		WHERE person2group2role_p2g2r.p2g2r_per_ID = " . $iPersonID . "
		ORDER BY grp_Name";
$rsAssignedGroups = RunQuery($sSQL);

// Get all the Groups
$sSQL = "SELECT grp_ID, grp_Name FROM group_grp ORDER BY grp_Name";
$rsGroups = RunQuery($sSQL);

// Get the Properties assigned to this Person
$sSQL = "SELECT pro_Name, pro_ID, pro_Prompt, r2p_Value, prt_Name, pro_prt_ID
		FROM record2property_r2p
		LEFT JOIN property_pro ON pro_ID = r2p_pro_ID
		LEFT JOIN propertytype_prt ON propertytype_prt.prt_ID = property_pro.pro_prt_ID
		WHERE pro_Class = 'p' AND r2p_record_ID = " . $iPersonID .
		" ORDER BY prt_Name, pro_Name";
$rsAssignedProperties = RunQuery($sSQL);

// Get all the properties
$sSQL = "SELECT * FROM property_pro WHERE pro_Class = 'p' ORDER BY pro_Name";
$rsProperties = RunQuery($sSQL);

//$dBirthDate = FormatBirthDate($per_BirthYear, $per_BirthMonth, $per_BirthDay);
$dBirthDate = FormatBirthDate($per_BirthDay,$per_BirthMonth,$per_BirthYear);

$sFamilyInfoBegin = "<span style=\"color: red;\">";
$sFamilyInfoEnd = "</span>";

// Assign the values locally, after selecting whether to display the family or person information

$numadd = SelectWhichAddress($sAddress1, $sAddress2, $per_Address1, $per_Address2, $fam_Address1, $fam_Address2, True);
$sCity = SelectWhichInfo($per_City, $fam_City, True);
$sState = SelectWhichInfo($per_State, $fam_State, True);
$sZip = SelectWhichInfo($per_Zip, $fam_Zip, True);
$sCountry = SelectWhichInfo($per_Country, $fam_Country, True);
$sPhoneCountry = SelectWhichInfo($per_Country, $fam_Country, False);
$sHomePhone = SelectWhichInfo(ExpandPhoneNumber($per_HomePhone,$sPhoneCountry,$dummy), ExpandPhoneNumber($fam_HomePhone,$fam_Country,$dummy), True);
$sWorkPhone = SelectWhichInfo(ExpandPhoneNumber($per_WorkPhone,$sPhoneCountry,$dummy), ExpandPhoneNumber($fam_WorkPhone,$fam_Country,$dummy), True);
$sCellPhone = SelectWhichInfo(ExpandPhoneNumber($per_CellPhone,$sPhoneCountry,$dummy), ExpandPhoneNumber($fam_CellPhone,$fam_Country,$dummy), True);
$sEmail = SelectWhichInfo($per_Email, $fam_Email, True);
$sUnformattedEmail = SelectWhichInfo($per_Email, $fam_Email, False);

if ($per_Envelope > 0)
	$sEnvelope = $per_Envelope;
else
	$sEnvelope = gettext("Not assigned");

// Set the page title and include HTML header
$sPageTitle = gettext("Person View");

?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
          <tr>
            <td height="3" colspan="3" bgcolor="#FFFFFF"><img src="Images/Spacer.gif" width="1" height="1"></td>
          </tr>
          <tr align="center">
            <td height="11" colspan="3" bgcolor="#B7DBFF">
              <? require "Include/Header.php"; ?>
            </td>
          </tr>
          <tr>
            <td height="2" colspan="3" bgcolor="#FFFFCC"><img src="Images/Spacer.gif" width="1" height="1"></td>
          </tr>
          <tr bgcolor="#CEEFFF">
            <td height="3" colspan="3"><img src="Images/Spacer.gif" width="1" height="1"></td>
          </tr>
         </table>
<?
echo"<center>";
$iTableSpacerWidth = 10;

if ($previous_link_text) {
	echo "$previous_link_text | ";
}
if ($_SESSION['bEditRecords']) { echo "<a class=\"SmallText\" href=\"PersonEditor.php?PersonID=" . $per_ID . "\">" . gettext("Edit this Record") . "</a> | "; }
if ($_SESSION['bDeleteRecords']) { echo "<a class=\"SmallText\" href=\"SelectDelete.php?mode=person&PersonID=" . $per_ID . "\">" . gettext("Delete this Record") . "</a> | " ; }
?>
<a href="PrintView.php?PersonID=<?php echo $per_ID; ?>" class="SmallText"><?php echo gettext("Printable Page"); ?></a>
| <a href="<?php echo $_SERVER['PHP_SELF']; ?>?PersonID=<?php echo $per_ID; ?>&AddToPeopleCart=<?php echo $per_ID; ?>" class="SmallText"><?php echo gettext("Add to Cart"); ?></a>

<?php
if ($_SESSION['bAdmin'])
{
	$sSQL = "SELECT usr_per_ID FROM user_usr WHERE usr_per_ID = " . $per_ID;
	if (mysql_num_rows(RunQuery($sSQL)) == 0)
		echo " | <a class=\"SmallText\" href=\"UserEditor.php?NewPersonID=" . $per_ID . "\">" . gettext("Make User") . "</a>" ;
	else
		echo " | <a class=\"SmallText\" href=\"UserEditor.php?PersonID=" . $per_ID . "\">" . gettext("Edit User") . "</a>" ;
}

//if ($_SESSION['bFinance'])
//{
//	echo " | <a class=\"SmallText\" href=\"DonationView.php?PersonID=" . $per_ID . "\">" . gettext("View Donations") . "</a>" ;
//	echo " | <a class=\"SmallText\" href=\"DonationEditor.php?PersonID=" . $per_ID . "\">" . gettext("Add Donation") . "</a>" ;
//}
if ($next_link_text) {
	echo " | $next_link_text";
}

?>

<br><br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
<tr>
<td width="25%" valign="top">
	<div class="LightShadedBox">
	<?php
		echo "<h2>";
		echo FormatFullName($per_Title, $per_FirstName, $per_MiddleName, $per_LastName, $per_Suffix, 0);
		echo "</h2>";
		echo "<h3>";
		echo $fam_NoIndFam . " - " . $per_NoIndJem . "." . $fam_NamaSek;
		echo "</h3>";

		if ($fam_ID != "") {
			echo "<h4>";
			if ($sFamRole != "") { echo $sFamRole; } else { echo gettext("Member"); }
			echo gettext("</h4><h4>Keluarga ") . " <a href=\"FamilyView.php?FamilyID=" . $fam_ID . "\">" . $fam_Name . "</a>" . gettext("") . "</h4>";
		}
		else
			echo gettext("(No assigned family)") . "<br><br>";

		echo "<div class=\"TinyShadedBox\">";
			echo "<font size=\"3\">";
//Edited & Add for GPIB
//			if ($sAddress1 != "") { echo $sAddress1 . "<br>"; }
			if ($sAddress1 != "") { echo $sAddress1 . "<br>";
				if ($numadd) {
					if ($numadd == 1) {
						if ($per_Kompleks1 != "") { echo "Kompleks: " . $per_Kompleks1 . "<br>"; }
						if ($per_RTRW1 != "") { echo "RT-RW: " . $per_RTRW1 . " ";}
						if ($per_Kelurahan1 != "") { echo "Kelurahan: " . $per_Kelurahan1 . " ";}
					} else {
						echo "<span style=\"color: red;\">";
						if ($fam_Kompleks1 != "") { echo "Kompleks: " . $fam_Kompleks1 . "<br>"; }
						if ($fam_RTRW1 != "") { echo "RT-RW: " . $fam_RTRW1 . " ";}
						if ($fam_Kelurahan1 != "") { echo "Kelurahan: " . $fam_Kelurahan1 . " ";}
						echo "</span>";
					}
				}
			}
//			if ($sAddress2 != "") { echo $sAddress2 . "<br>"; }
			if ($sAddress2 != "") { echo $sAddress2 . "<br>";
				if ($numadd) {
					if ($numadd == 1) {
						if ($per_Kompleks2 != "") { echo "Kompleks: " . $per_Kompleks2 . "<br>"; }
						if ($per_RTRW2 != "") { echo "RT-RW: " . $per_RTRW2 . " ";}
						if ($per_Kelurahan2 != "") { echo "Kelurahan: " . $per_Kelurahan2 . " ";}
					} else {
						echo "<span style=\"color: red;\">";
						if ($fam_Kompleks2 != "") { echo "Kompleks: " . $fam_Kompleks2 . "<br>"; }
						if ($fam_RTRW2 != "") { echo "RT-RW: " . $fam_RTRW2 . " ";}
						if ($fam_Kelurahan2 != "") { echo "Kelurahan: " . $fam_Kelurahan2 . " ";}
						echo "</span>";
					}
				}
			}
// End Edit & Add
			if ($sCity != "") { echo $sCity . ", "; }
			if ($sState != "") { echo $sState; }
			if ($sZip != "") { echo " " . $sZip; }
			if ($sCountry != "") {echo "<br>" . $sCountry; }
			echo "</font>";
		echo "</div>";

		// Strip tags in case they were added for family inherited data
		$sAddress1 = strip_tags($sAddress1);
		$sCity = strip_tags($sCity);
		$sState = strip_tags($sState);
		$sCountry = strip_tags($sCountry);

		//Show link to mapquest
		if ($sAddress1 != "" && $sCity != "" && $sState != "")
		{
			if ($sCountry == "United States") {
				$sMQcountry = "";
				$bShowMQLink = true;
			}
			elseif ($sCountry == "Canada") {
				$sMQcountry = "country=CA&";
				$bShowMQLink = true;
			}
			else
				$bShowMQLink = false;
		}

		if ($bShowMQLink)
			echo "<div align=\"right\"><a class=\"SmallText\" target=\"_blank\" href=\"http://www.mapquest.com/maps/map.adp?" .$sMQcountry . "city=" . urlencode($sCity) . "&state=" . $sState . "&address=" . urlencode($sAddress1) . "\">" . gettext("View Map") . "</a></div>";

		echo "<br>";

		// Upload photo
		if ( isset($_POST["UploadPhoto"]) && ($_SESSION['bAddRecords'] || $_SESSION['bEditRecords']) ) {
			if ($_FILES['Photo']['name'] == "") {
				$PhotoError = gettext("No photo selected for uploading.");
			} elseif ($_FILES['Photo']['type'] != "image/pjpeg" && $_FILES['Photo']['type'] != "image/jpeg") {
				$PhotoError = gettext("Only jpeg photos can be uploaded.");
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
				imagejpeg($dstImage,"Images/Person/thumbnails/" . $iPersonID . ".jpg");
				imagedestroy($dstImage);
    			imagedestroy($srcImage);
				move_uploaded_file($_FILES['Photo']['tmp_name'], "Images/Person/" . $iPersonID . ".jpg");
			}
		} elseif (isset($_POST["DeletePhoto"]) && $_SESSION['bDeleteRecords']) {
			unlink("Images/Person/" . $iPersonID . ".jpg");
			unlink("Images/Person/thumbnails/" . $iPersonID . ".jpg");
		}

		// Display photo or upload from file
		$photoFile = "Images/Person/thumbnails/" . $iPersonID . ".jpg";
		if (file_exists($photoFile))
		{
			echo "<a target=\"_blank\" href=\"Images/Person/" . $iPersonID . ".jpg\">";
			echo "<img border=\"1\" src=\"$photoFile\"></a>";
			if ($_SESSION['bEditRecords']) {
				echo "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "?PersonID=" . $iPersonID . "\">";
				echo "<br><input type=\"submit\" class=\"icTinyButton\" value=\"" . gettext("Delete Photo") . "\" name=\"DeletePhoto\">";
				echo "</form>";
			}
		} else {
			// Some old / M$ browsers can't handle PNG's correctly.
			if ($bDefectiveBrowser)
				echo "<img border=\"0\" src=\"Images/NoPhoto.gif\"><br><br><br>";
			else
				echo "<img border=\"0\" src=\"Images/NoPhoto.png\"><br><br><br>";

			if ($_SESSION['bEditRecords']) {
				if (isset($PhotoError)) echo "<span style=\"color: red;\">" . $PhotoError . "</span><br>";
				echo "<form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "?PersonID=" . $iPersonID . "\" enctype=\"multipart/form-data\">";
				echo "<input class=\"icTinyButton\" type=\"file\" name=\"Photo\"> <input type=\"submit\" class=\"icTinyButton\" value=\"" . gettext("Upload Photo") . "\" name=\"UploadPhoto\">";
				echo "</form>";
			}
		}
	?>
	</div>
</td>

    <td width="75%" valign="top" align="left"> <b><?php echo gettext("Informasi Umum:"); ?></b>
      <div class="LightShadedBox">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td align="center">
			<table cellspacing="4" cellpadding="0" border="0">
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Jenis Kelamin:"); ?></td>
				<td class="TinyTextColumn">
				<?php
					switch ($per_Gender)
					{
					case 1:
						echo gettext("Laki-Laki");
						break;
					case 2:
						echo gettext("Perempuan");
						break;
					}
				?>
				</td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Tempat Lahir:"); ?></td>
				<td class="TinyTextColumn"><?php echo htmlentities(stripslashes($per_BirthPlace)); ?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Tanggal Lahir:"); ?></td>
				<td class="TinyTextColumn"><?php echo $dBirthDate; ?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Umur:"); ?></td>
				<td class="TinyTextColumn"><?php PrintAge($per_BirthMonth,$per_BirthDay,$per_BirthYear); ?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Terdaftar Sejak:"); ?></td>
				<td class="TinyTextColumn">
					<?php
						if ($per_MembershipDate != "") {
							echo FormatDate($per_MembershipDate,false);
						} else {
							echo "<span style=\"color: red;\">";
							echo FormatDate($fam_MembershipDate,false);
							echo "</span>";
						}
					?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Asal Gereja Sebelum:"); ?></td>
				<td class="TinyTextColumn">
					<?php
						if ($per_AsalGS != "") {
							if ($per_AsalGS = "G") {
								echo "GPIB";
							} else {
								echo "Non-GPIB";
							}
						} else {
							if ($fam_AsalGS = "G") {
								echo "<span style=\"color: red;\">";
								echo "GPIB";
								echo "</span>";
							} else {
								echo "<span style=\"color: red;\">";
								echo "Non-GPIB";
								echo "</span>";
							}
						}
					?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Nama Gereja Sebelum:"); ?></td>
				<td class="TinyTextColumn">
					<?php
						if ($per_NamaGS != "") {
							echo $per_NamaGS;
						} else {
							echo "<span style=\"color: red;\">";
							echo $fam_NamaGS;
							echo "</span>";
						}
					?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Klasifikasi:"); ?></td>
				<td class="TinyTextColumn"><?php echo $sClassName; ?></td>
			</tr>


				<?php //}

				// Display the left-side custom fields
				while ($Row = mysql_fetch_array($rsLeftCustomFields)) {
					extract($Row);
					$currentData = trim($aCustomData[$custom_Field]);
					if ($type_ID == 11) $custom_Special = $sPhoneCountry;
					echo "<tr><td class=\"TinyLabelColumn\">" . $custom_Name . "</td>";
					echo "<td class=\"TinyTextColumn\">" . displayCustomField($type_ID, $currentData, $custom_Special) . "</td></tr>";
				}
			?>
			</table>
		</td>
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
				<td class="TinyLabelColumn"><?php echo gettext("Email 1:"); ?></td>
				<td class="TinyTextColumn"><?php if ($sEmail != "") { echo "<a href=\"mailto:" . $sUnformattedEmail . "\">" . $sEmail . "</a>"; } ?></td>
			</tr>
			<tr>
				<td class="TinyLabelColumn"><?php echo gettext("Email 2:"); ?></td>
				<td class="TinyTextColumn"><?php if ($per_WorkEmail != "") { echo "<a href=\"mailto:" . $per_WorkEmail . "\">" . $per_WorkEmail . "</a>"; } ?></td>
			</tr>
			<?php
				// Display the right-side custom fields
				while ($Row = mysql_fetch_array($rsRightCustomFields)) {
					extract($Row);
					$currentData = trim($aCustomData[$custom_Field]);
					if ($type_ID == 11) $custom_Special = $sPhoneCountry;
					echo "<tr><td class=\"TinyLabelColumn\">" . $custom_Name . "</td>";
					echo "<td class=\"TinyTextColumn\">" . displayCustomField($type_ID, $currentData, $custom_Special) . "</td></tr>";
				}
			?>
			</table>
		</td>
	</tr>
	</table>
	</div>
	<br>
      <b><?php echo gettext("Assigned Properties:"); ?></b>
      <?php

	$sAssignedProperties = ",";

	//Was anything returned?
	if (mysql_num_rows($rsAssignedProperties) == 0)
	{
		echo "<p align\"center\">" . gettext("No property assignments.") . "</p>";
	}
	else
	{
		//Yes, start the table
		echo "<table width=\"100%\" cellpadding=\"4\" cellspacing=\"0\">";
		echo "<tr class=\"TableHeader\">";
		echo "<td width=\"10%\" valign=\"top\"><b>" . gettext("Type") . "</b>";
		echo "<td width=\"15%\" valign=\"top\"><b>" . gettext("Name") . "</b>";
		echo "<td valign=\"top\"><b>" . gettext("Value") . "</b></td>";

		if ($_SESSION['bEditRecords'])
		{
			echo "<td valign=\"top\"><b>" . gettext("Edit") . "</b></td>";
			echo "<td valign=\"top\"><b>" . gettext("Remove") . "</b></td>";
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

			echo "<td valign=\"center\">" . $pro_Name . "&nbsp;</td>";
			echo "<td valign=\"center\">" . $r2p_Value . "&nbsp;</td>";

			if ($_SESSION['bEditRecords'])
			{
				if (strlen($pro_Prompt) > 0)
				{
					echo "<td valign=\"center\"><a href=\"PropertyAssign.php?PersonID=" . $iPersonID . "&PropertyID=" . $pro_ID . "\">" . gettext("Edit") . "</a></td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
				}
				echo "<td valign=\"center\"><a href=\"PropertyUnassign.php?PersonID=" . $iPersonID . "&PropertyID=" . $pro_ID . "\">" . gettext("Remove") . "</a></td>";
			}
			echo "</tr>";

			//Alternate the row style
			$sRowClass = AlternateRowStyle($sRowClass);

			$sAssignedProperties .= $pro_ID . ",";
		}
		echo "</table>";
	}

	?>
      <?php if ($_SESSION['bEditRecords']) { ?>
      &quot; <strong>Perhatian ketika record ini di Assign, maka secara otomatis
      akan menghapus/mengganti field Jabatan Gerajawi/catatan khusus/Klasifikasi
      </strong>&quot;
      <form method="post" action="PropertyAssign.php?PersonID=<?php echo $iPersonID; ?>">
	<p class="SmallText" align="center">
		<span class="SmallText"><?php echo gettext("Assign a New Property:"); ?></span>
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
		<input type="submit" class="icButton" <?php echo 'value="' . gettext("Assign") . '"'; ?> name="Submit" style="font-size: 8pt;">
	</p>
	</form>
	<?php }
	else
	{
		echo "<br><br><br>";
	}
	?>

	<b><?php echo gettext("Assigned Groups:"); ?></b>

	<script language="javascript">
	function GroupRemove( Group, Person ) {
	var answer = confirm (<?php echo "'" . gettext("Warning: If you remove this group membership, you will irrevokably lose any member data assigned") . "'"; ?>)
	if ( answer )
		window.location="GroupMemberList.php?GroupID=" + Group + "&PersonToRemove=" + Person
	}
	</script>

	<?php

	//Initialize row shading
	$sRowClass = "RowColorA";

	$sAssignedGroups = ",";

	//Was anything returned?
	if (mysql_num_rows($rsAssignedGroups) == 0)
	{
		echo "<p align=\"center\">" . gettext("No group assignments.") . "</p>";
	}
	else
	{
		echo "<table width=\"100%\" cellpadding=\"4\" cellspacing=\"0\">";
		echo "<tr class=\"TableHeader\">";
		echo "<td>" . gettext("Group Name") . "</td>";
		echo "<td>" . gettext("Role") . "</td>";
		if ($_SESSION['bManageGroups'])
		{
			echo "<td>" . gettext("Properties") . "</td>";
			echo "<td width=\"10%\">" . gettext("Remove") . "</td>";
		}
		echo "</tr>";

		// Loop through the rows
		while ($aRow = mysql_fetch_array($rsAssignedGroups))
		{
			extract($aRow);

			// Alternate the row style
			$sRowClass = AlternateRowStyle($sRowClass);

			echo "<tr class=\"" . $sRowClass . "\">";
			echo "<td><a href=\"GroupView.php?GroupID=" . $grp_ID . "\">" . $grp_Name . "</a></td>";

			echo "<td>";
			if ($_SESSION['bManageGroups']) echo "<a href=\"MemberRoleChange.php?GroupID=" . $grp_ID . "&PersonID=" . $iPersonID . "\">";
			echo $roleName;
			if ($_SESSION['bManageGroups']) echo "</a>";
			echo "</td>";

			if ($_SESSION['bManageGroups']) {
				if ($grp_hasSpecialProps == 'true')
					echo "<td><a href=\"GroupPropsEditor.php?PersonID=" . $iPersonID . "&GroupID=" . $grp_ID . "\">" . gettext("View/Edit") . "</a></td>";
				else
					echo "<td>&nbsp;</td>";
				echo "<td><input type=\"button\" class=\"icTinyButton\" value=\"" . gettext("Remove") . "\" Name=\"remove\" onclick=\"GroupRemove(" . $grp_ID . ", " . $iPersonID . ");\" ></td>";
			}
			echo "</tr>";

			// If this group has associated special properties, display those with values and prop_PersonDisplay flag set.
			if ($grp_hasSpecialProps == 'true')
			{
				$firstRow = true;
				// Get the special properties for this group
				$sSQL = "SELECT groupprop_master.* FROM groupprop_master
					WHERE grp_ID = " . $grp_ID . " AND prop_PersonDisplay = 'true' ORDER BY prop_ID";
				$rsPropList = RunQuery($sSQL);

				$sSQL = "SELECT * FROM groupprop_" . $grp_ID . " WHERE per_ID = " . $iPersonID;
				$rsPersonProps = RunQuery($sSQL);
				$aPersonProps = mysql_fetch_array($rsPersonProps, MYSQL_BOTH);

				while ($aProps = mysql_fetch_array($rsPropList))
				{
					extract($aProps);
					$currentData = trim($aPersonProps[$prop_Field]);
					if (strlen($currentData) > 0)
					{
						// only create the properties table if it's actually going to be used
						if ($firstRow) {
							echo "<tr><td colspan=\"2\"><table width=\"100%\"><tr><td width=\"15%\"></td><td><table width=\"90%\" cellspacing=\"0\">";
							echo "<tr class=\"TinyTableHeader\"><td>" . gettext("Property") . "</td><td>" . gettext("Value") . "</td></tr>";
							$firstRow = false;
						}
						$sRowClass = AlternateRowStyle($sRowClass);
						if ($type_ID == 11) $prop_Special = $sPhoneCountry;
						echo "<tr class=\"$sRowClass\"><td>" . $prop_Name . "</td><td>" . displayCustomField($type_ID, $currentData, $prop_Special) . "</td></tr>";
					}
				}
				if (!$firstRow) echo "</table></td></tr></table></td></tr>";
			}

			// NOTE: this method is crude.  Need to replace this with use of an array.
			$sAssignedGroups .= $grp_ID . ",";
		}
		echo "</table>";
	}
	?>

	<?php if ($_SESSION['bManageGroups']) { ?>
	<form method="post" action="PersonView.php?PersonID=<?php echo $iPersonID ?>">
	<p class="SmallText" align="center">
		<span class="SmallText"><?php echo gettext("Assign a New Group:"); ?></span>
		<select name="GroupAssignID">
			<?php
			while ($aRow = mysql_fetch_array($rsGroups))
			{
				extract($aRow);

				//If the property doesn't already exist for this Person, write the <OPTION> tag
				if (strlen(strstr($sAssignedGroups,"," . $grp_ID . ",")) == 0)
				{
					echo "<option value=\"" . $grp_ID . "\">" . $grp_Name . "</option>";
				}
			}
			?>
		</select>
		<input type="submit" class="icButton" <?php echo 'value="' . gettext("Assign") . '"'; ?> name="GroupAssign" style="font-size: 8pt;">
		<br>
		<span class="SmallText" align="center"><?php echo gettext("(Person will be assigned to the Group in the Default Role.)"); ?></span>
	</p>
	</form>
	<?php } ?>
</td>
</tr>
</table>

<?php
if ($previous_link_text) {
	echo "$previous_link_text | ";
}
if ($_SESSION['bEditRecords']) { echo "<a class=\"SmallText\" href=\"PersonEditor.php?PersonID=" . $per_ID . "\">" . gettext("Edit this Record") . "</a> | "; }
if ($_SESSION['bDeleteRecords']) { echo "<a class=\"SmallText\" href=\"SelectDelete.php?mode=person&PersonID=" . $per_ID . "\">" . gettext("Delete this Record") . "</a> | " ; }
?>
<a href="PrintView.php?PersonID=<?php echo $per_ID; ?>" class="SmallText"><?php echo gettext("Printable Page"); ?></a>
| <a href="<?php echo $_SERVER['PHP_SELF']; ?>?PersonID=<?php echo $per_ID; ?>&AddToPeopleCart=<?php echo $per_ID; ?>" class="SmallText"><?php echo gettext("Add to Cart"); ?></a>

<?php
if ($_SESSION['bAdmin'])
{
	$sSQL = "SELECT usr_per_ID FROM user_usr WHERE usr_per_ID = " . $per_ID;
	if (mysql_num_rows(RunQuery($sSQL)) == 0)
		echo " | <a class=\"SmallText\" href=\"UserEditor.php?NewPersonID=" . $per_ID . "\">" . gettext("Make User") . "</a>" ;
	else
		echo " | <a class=\"SmallText\" href=\"UserEditor.php?PersonID=" . $per_ID . "\">" . gettext("Edit User") . "</a>" ;
}

//if ($_SESSION['bFinance'])
//{
//	echo " | <a class=\"SmallText\" href=\"DonationView.php?PersonID=" . $per_ID . "\">" . gettext("View Donations") . "</a>" ;
//	echo " | <a class=\"SmallText\" href=\"DonationEditor.php?PersonID=" . $per_ID . "\">" . gettext("Add Donation") . "</a>" ;
//}
if ($next_link_text) {
	echo " | $next_link_text";
}
?>

<p class="SmallText">
	<span style="color: red;"><?php echo gettext("Red text"); ?></span> <?php echo gettext("indicates items inherited from the associated family record."); ?>
</p>

<p class="SmallText">
	<?php echo gettext("Diisi:"); ?> <?php echo FormatDate($per_DateEntered,true); ?> <?php echo gettext("oleh"); ?> <?php echo $EnteredFirstName . " " . $EnteredLastName; ?>
<?php

	if (strlen($per_DateLastEdited) > 0)
	{
		?>
			<br>
			<?php echo gettext("Terakhir diubah:") . ' ' . FormatDate($per_DateLastEdited,true) . ' ' . gettext("oleh") . ' ' . $EditedFirstName . " " . $EditedLastName ?>
		</p>
		<?php
	}
	?>

</p>


<?php if ($_SESSION['bNotes']) { ?>
<p>
	<b><?php echo gettext("Notes:"); ?></b>
</p>

<p>
	<a class="SmallText" href="NoteEditor.php?PersonID=<?php echo $per_ID ?>"><?php echo gettext("Add a Note to this Record"); ?></a></font>
</p>

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

	if (strlen($nte_DateLastEdited))
	{ ?>
		<span class="SmallText"><?php echo gettext("Last Edited:") . ' ' . FormatDate($nte_DateLastEdited,True) . ' ' . gettext("by") . ' ' . $EditedFirstName . " " . $EditedLastName ?></span>
		<br>
	<?php
	}
	if ($_SESSION['bNotes']) { ?><a class="SmallText" href="NoteEditor.php?PersonID=<?php echo $iPersonID ?>&NoteID=<?php echo $nte_ID ?>"><?php echo gettext("Edit This Note"); ?></a>&nbsp;|&nbsp;<?php }
	if ($_SESSION['bNotes']) { ?><a class="SmallText" href="NoteDelete.php?NoteID=<?php echo $nte_ID ?>"><?php echo gettext("Delete This Note"); ?></a> <?php }

}
?>
<?php }

require "Include/Footer.php";
?>
