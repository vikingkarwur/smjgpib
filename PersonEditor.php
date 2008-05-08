<?php
/*******************************************************************************
 *
 *  filename    : PersonEditor.php
 *  last change : 2003-01-29
 *  website     : http://www.infocentral.org
 *  copyright   : Copyright 2001, 2002, 2003 Deane Barker, Chris Gebhardt
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
$sPageTitle = gettext("Person Editor");

//Get the PersonID out of the querystring
$iPersonID = FilterInput($_GET["PersonID"],'int');

// Security: User must have Add or Edit Records permission to use this form in those manners
// Clean error handling: (such as somebody typing an incorrect URL ?PersonID= manually)
if (strlen($iPersonID) > 0)
{
	if (!$_SESSION['bEditRecords'])
	{
		Redirect("Menu.php");
		exit;
	}
	$sSQL = "SELECT '' FROM person_per WHERE per_ID = " . $iPersonID;
	if (mysql_num_rows(RunQuery($sSQL)) == 0)
	{
		Redirect("Menu.php");
		exit;
	}
}
elseif (!$_SESSION['bAddRecords'])
{
	Redirect("Menu.php");
	exit;
}

// Get the list of custom person fields
$sSQL = "SELECT person_custom_master.* FROM person_custom_master ORDER BY custom_Order";
$rsCustomFields = RunQuery($sSQL);
$numCustomFields = mysql_num_rows($rsCustomFields);

//Is this the second pass?
if (isset($_POST["PersonSubmit"]) || isset($_POST["PersonSubmitAndAdd"]))
{
	//Get all the variables from the request object and assign them locally
	$sNoIndJem = FilterInput($_POST["NoIndJem"]);
	$sTitle = FilterInput($_POST["Title"]);
	$sFirstName = FilterInput($_POST["FirstName"]);
	$sMiddleName = FilterInput($_POST["MiddleName"]);
	$sLastName = FilterInput($_POST["LastName"]);
	$sSuffix = FilterInput($_POST["Suffix"]);
	$iGender = FilterInput($_POST["Gender"],'int');
	$sAddress1 = FilterInput($_POST["Address1"]);
// Added for GPIB
	$sKompleks1 = FilterInput($_POST["Kompleks1"]);
	$sRTRW1 = FilterInput($_POST["RTRW1"]);
	$sKelurahan1 = FilterInput($_POST["Kelurahan1"]);
// End Added
	$sAddress2 = FilterInput($_POST["Address2"]);
// Added for GPIB
	$sKompleks2 = FilterInput($_POST["Kompleks2"]);
	$sRTRW2 = FilterInput($_POST["RTRW2"]);
	$sKelurahan2 = FilterInput($_POST["Kelurahan2"]);
// End Added
	$sCity = FilterInput($_POST["City"]);
	$sZip	= FilterInput($_POST["Zip"]);
	$sCountry = FilterInput($_POST["Country"]);
	$iFamily = FilterInput($_POST["Family"],'int');
	$iFamilyRole = FilterInput($_POST["FamilyRole"],'int');

	// Get their family's country in case person's country was not entered
	if ($iFamily > 0) {
		$sSQL = "SELECT fam_Country FROM family_fam WHERE fam_ID = " . $iFamily;
		$rsFamCountry = RunQuery($sSQL);
		extract(mysql_fetch_array($rsFamCountry));
	}

	$sCountryTest = SelectWhichInfo($sCountry, $fam_Country, false);
	if ($sCountryTest == "United States" || $sCountryTest == "Canada")
		$sState = FilterInput($_POST["State"]);
	else
		$sState = FilterInput($_POST["StateTextbox"]);

	$sHomePhone = FilterInput($_POST["HomePhone"]);
	$sWorkPhone = FilterInput($_POST["WorkPhone"]);
	$sCellPhone = FilterInput($_POST["CellPhone"]);
	$sEmail = FilterInput($_POST["Email"]);
	$sWorkEmail = FilterInput($_POST["WorkEmail"]);
	$iBirthPlace = FilterInput($_POST["BirthPlace"]);
	$iBirthMonth = FilterInput($_POST["BirthMonth"],'int');
	$iBirthDay = FilterInput($_POST["BirthDay"],'int');
	$iBirthYear = FilterInput($_POST["BirthYear"],'int');
	$dMembershipDate = FilterInput($_POST["MembershipDate"]);
	$aAsalGS = FilterInput($_POST["AsalGS"]);
	$sNamaGS = FilterInput($_POST["NamaGS"]);
	$iClassification = FilterInput($_POST["Classification"],'int');
	$sEnvelope = FilterInput($_POST['EnvID'],'int');

	$bNoFormat_HomePhone = isset($_POST["NoFormat_HomePhone"]);
	$bNoFormat_WorkPhone = isset($_POST["NoFormat_WorkPhone"]);
	$bNoFormat_CellPhone = isset($_POST["NoFormat_CellPhone"]);

	//Initialize the error flag
	$bErrorFlag = false;

	//Adjust variables as needed
	if ($iFamily == 0)	$iFamilyRole = 0;

	//Validate the First Name
	if (strlen($sFirstName) < 1)
	{
		$sFirstNameError = gettext("You must enter a First Name.");
		$bErrorFlag = true;
	}

	//Validate the Last Name.  If family selected, but no last name, inherit from family.
	if (strlen($sLastName) < 1)
	{
		if ($iFamily == 0) {
			$sLastNameError = gettext("You must enter a Last Name if no Family is selected.");
			$bErrorFlag = true;
		} else {
			$sSQL = "SELECT fam_Name FROM family_fam WHERE fam_ID = " . $iFamily;
			$rsFamName = RunQuery($sSQL);
			$aTemp = mysql_fetch_array($rsFamName);
			$sLastName = $aTemp[0];
		}
	}

	// If they entered a full date, see if it's valid
	if (strlen($iBirthYear) > 0)
	{
		if ($iBirthYear > 2155 || $iBirthYear < 1901)
		{
			$sBirthYearError = gettext("Tahun salah: yang diperbolehkan adalah 1901 sampai 2155");
			$bErrorFlag = true;
		}
		elseif ($iBirthMonth > 0 && $iBirthDay > 0)
		{
			if (!checkdate($iBirthMonth,$iBirthDay,$iBirthYear))
			{
				$sBirthDateError = gettext("Tanggal lahir salah.");
				$bErrorFlag = true;
			}
		}
	}

	// Validate Membership Date if one was entered
	if (strlen($dMembershipDate) > 0)
	{
		list($iYear, $iMonth, $iDay) = sscanf($dMembershipDate,"%04d-%02d-%02d");
		if ( !checkdate($iMonth,$iDay,$iYear) )
		{
			$sMembershipDateError = "<span style=\"color: red; \">" . gettext("Not a valid Membership Date") . "</span>";
			$bErrorFlag = true;
		}
	}

	// Validate all the custom fields
	while ( $rowCustomField = mysql_fetch_array($rsCustomFields, MYSQL_BOTH) )
	{
		extract($rowCustomField);

		$currentFieldData = FilterInput($_POST[$custom_Field]);

		$bErrorFlag |= !validateCustomField($type_ID, $currentFieldData, $custom_Field, $aCustomErrors);

		// assign processed value locally to $aPersonProps so we can use it to generate the form later
		$aCustomData[$custom_Field] = $currentFieldData;
	}

	//If no errors, then let's update...
	if (!$bErrorFlag)
	{
		$sPhoneCountry = SelectWhichInfo($sCountry,$fam_Country,false);

		if (!$bNoFormat_HomePhone) $sHomePhone = CollapsePhoneNumber($sHomePhone,$sPhoneCountry);
		if (!$bNoFormat_WorkPhone) $sWorkPhone = CollapsePhoneNumber($sWorkPhone,$sPhoneCountry);
		if (!$bNoFormat_CellPhone) $sCellPhone = CollapsePhoneNumber($sCellPhone,$sPhoneCountry);

		//If no birth year, set to NULL
		if (strlen($iBirthYear) < 4)
		{
			$iBirthYear = "NULL";
		}

		// New Person (add)
		if (strlen($iPersonID) < 1)
		{
			if (!$_SESSION['bFinance'] || strlen($sEnvelope) < 1)
				$sEnvelope = "NULL";

			$sSQL = "INSERT INTO person_per (per_NoIndJem, per_Title, per_FirstName, per_MiddleName, per_LastName, per_Suffix, per_Gender, per_Address1, per_Kompleks1, per_RTRW1, per_Kelurahan1, per_Address2, per_Kompleks2, per_RTRW2, per_Kelurahan2, per_City, per_State, per_Zip, per_Country, per_HomePhone, per_WorkPhone, per_CellPhone, per_Email, per_WorkEmail, per_BirthPlace, per_BirthMonth, per_BirthDay, per_BirthYear, per_Envelope, per_fam_ID, per_fmr_ID, per_MembershipDate, per_AsalGS, per_NamaGS, per_cls_ID, per_DateEntered, per_EnteredBy) VALUES ('" . $sNoIndJem . "', '" . $sTitle . "','" . $sFirstName . "','" . $sMiddleName . "','" . $sLastName . "','" . $sSuffix . "'," . $iGender . ",'" . $sAddress1 . "','" . $sKompleks1 . "','" . $sRTRW1 . "','" . $Kelurahan1 . "','" . $sAddress2 . "','" . $sKompleks2 . "','" . $sRTRW2 . "','" . $sKelurahan2 . "','" . $sCity . "','" . $sState . "','" . $sZip . "','" . $sCountry . "','" . $sHomePhone . "','" . $sWorkPhone . "','" . $sCellPhone . "','" . $sEmail . "','" . $sWorkEmail . "','" . $iBirthPlace . "'," . $iBirthMonth . "," . $iBirthDay . "," . $iBirthYear . "," . $sEnvelope . "," . $iFamily . "," . $iFamilyRole . ",";
			if ( strlen($dMembershipDate) > 0 )
				$sSQL .= "\"" . $dMembershipDate . "\"";
			else
				$sSQL .= "NULL";
			$sSQL .= ",'" . $aAsalGS . "','" . $sNamaGS . "'," . $iClassification . ",'" . date("YmdHis") . "'," . $_SESSION['iUserID'] . ")";
			$bGetKeyBack = True;

		// Existing person (update)
		} else {

			$sSQL = "UPDATE person_per SET per_NoIndJem = '" . $sNoIndJem . "',per_Title = '" . $sTitle . "',per_FirstName = '" . $sFirstName . "',per_MiddleName = '" . $sMiddleName . "', per_LastName = '" . $sLastName . "', per_Suffix = '" . $sSuffix . "', per_Gender = " . $iGender . ", per_Address1 = '" . $sAddress1 . "', per_Kompleks1 = '" . $sKompleks1 . "', per_RTRW1 = '" . $sRTRW1 . "', per_Kelurahan1 = '" . $perKelurahan1 . "', per_Address2 = '" . $sAddress2 . "', per_Kompleks2 = '" . $sKompleks2 . "', per_RTRW2 = '" . $sRTRW2 . "', per_Kelurahan2 = '" . $sKelurahan2 . "', per_City = '" . $sCity . "', per_State = '" . $sState . "', per_Zip = '" . $sZip . "', per_Country = '" . $sCountry . "', per_HomePhone = '" . $sHomePhone . "', per_WorkPhone = '" . $sWorkPhone . "', per_CellPhone = '" . $sCellPhone . "', per_Email = '" . $sEmail . "', per_WorkEmail = '" . $sWorkEmail . "', per_BirthPlace = '" . $iBirthPlace . "', per_BirthMonth = " . $iBirthMonth . ", per_BirthDay = " . $iBirthDay . ", per_BirthYear = " . $iBirthYear . ", per_fam_ID = " . $iFamily . ", per_Fmr_ID = " . $iFamilyRole . ", per_cls_ID = " . $iClassification . ", per_MembershipDate = ";
			if ( strlen($dMembershipDate) > 0 )
				$sSQL .= "\"" . $dMembershipDate . "\"";
			else
				$sSQL .= "NULL";

			if ($_SESSION['bFinance'])
			{
				if (strlen($sEnvelope) < 1) $sEnvelope = "NULL";
				$sSQL .= ", per_Envelope = " . $sEnvelope;
			}

			$sSQL .= ", per_AsalGS = '" . $aAsalGS . "', per_NamaGS = '" . $sNamaGS . "', per_DateLastEdited = '" . date("YmdHis") . "', per_EditedBy = " . $_SESSION['iUserID'] . " WHERE per_ID = " . $iPersonID;

			$bGetKeyBack = false;
		}

		//Execute the SQL
		RunQuery($sSQL);

		// If this is a new person, get the key back and insert a blank row into the person_custom table
		if ($bGetKeyBack)
		{
			$sSQL = "SELECT MAX(per_ID) AS iPersonID FROM person_per";
			$rsPersonID = RunQuery($sSQL);
			extract(mysql_fetch_array($rsPersonID));
			$sSQL = "INSERT INTO `person_custom` (`per_ID`) VALUES ('" . $iPersonID . "')";
			RunQuery($sSQL);
		}

		// Update the custom person fields.
		if ($numCustomFields > 0)
		{
			$sSQL = "UPDATE person_custom SET ";
			mysql_data_seek($rsCustomFields,0);

			while ( $rowCustomField = mysql_fetch_array($rsCustomFields, MYSQL_BOTH) )
			{
				extract($rowCustomField);
				$currentFieldData = trim($aCustomData[$custom_Field]);

				sqlCustomField($sSQL, $type_ID, $currentFieldData, $custom_Field, $sPhoneCountry);
			}

			// chop off the last 2 characters (comma and space) added in the last while loop iteration.
			$sSQL = substr($sSQL,0,-2);

			$sSQL .= " WHERE per_ID = " . $iPersonID;

			//Execute the SQL
			RunQuery($sSQL);
		}

		// Check for redirection to another page after saving information: (ie. PersonEditor.php?previousPage=prev.php?a=1;b=2;c=3)
		if ($previousPage != "") {
			$previousPage = str_replace(";","&",$previousPage) ;
			Redirect($previousPage . $iPersonID);
		}
		else if (isset($_POST["PersonSubmit"]))
		{
			//Send to the view of this person
			Redirect("PersonView.php?PersonID=" . $iPersonID);
		}
		else
		{
			//Reload to editor to add another record
			Redirect("PersonEditor.php");
		}

	}

	// Set the envelope in case the form failed.
	$per_Envelope = $sEnvelope;

} else {

	//FirstPass
	//Are we editing or adding?
	if (strlen($iPersonID) > 0)
	{
		//Editing....
		//Get all the data on this record

		$sSQL = "SELECT * FROM person_per LEFT JOIN family_fam ON per_fam_ID = fam_ID WHERE per_ID = " . $iPersonID;
		$rsPerson = RunQuery($sSQL);
		extract(mysql_fetch_array($rsPerson));

		$sNoIndJem = $per_NoIndJem;
		$sTitle = $per_Title;
		$sFirstName = $per_FirstName;
		$sMiddleName = $per_MiddleName;
		$sLastName = $per_LastName;
		$sSuffix = $per_Suffix;
		$iGender = $per_Gender;
		$sAddress1 = $per_Address1;
// Added for GPIB
		$sKompleks1 = $per_Kompleks1;
		$sRTRW1 = $per_RTRW1;
		$sKelurahan1 = $per_Kelurahan1;
// End Added
		$sAddress2 = $per_Address2;
// Added for GPIB
		$sKompleks2 = $per_Kompleks2;
		$sRTRW2 = $per_RTRW2;
		$sKelurahan2 = $per_Kelurahan2;
// End Added
		$sCity = $per_City;
		$sState = $per_State;
		$sZip	= $per_Zip;
		$sCountry = $per_Country;
		$sHomePhone = $per_HomePhone;
		$sWorkPhone = $per_WorkPhone;
		$sCellPhone = $per_CellPhone;
		$sEmail = $per_Email;
		$sWorkEmail = $per_WorkEmail;
		$iBirthPlace = $per_BirthPlace;
		$iBirthMonth = $per_BirthMonth;
		$iBirthDay = $per_BirthDay;
		$iBirthYear = $per_BirthYear;
		$iOriginalFamily = $per_fam_ID;
		$iFamily = $per_fam_ID;
		$iFamilyRole = $per_fmr_ID;
		$dMembershipDate = $per_MembershipDate;
		$aAsalGS = $per_AsalGS;
		$sNamaGS = $per_NamaGS;
		$iClassification = $per_cls_ID;

		$sPhoneCountry = SelectWhichInfo($sCountry,$fam_Country,false);

		$sHomePhone = ExpandPhoneNumber($per_HomePhone,$sPhoneCountry,$bNoFormat_HomePhone);
		$sWorkPhone = ExpandPhoneNumber($per_WorkPhone,$sPhoneCountry,$bNoFormat_WorkPhone);
		$sCellPhone = ExpandPhoneNumber($per_CellPhone,$sPhoneCountry,$bNoFormat_CellPhone);

		//The following values are True booleans if the family record has a value for the
		//indicated field.  These are used to highlight field headers in red.
		$bFamilyMembership = strlen($fam_MembershipDate);
		$bFamilyAsalGS = strlen($fam_AsalGS);
		$bFamilyNamaGS = strlen($fam_NamaGS);
		$bFamilyAddress1 = strlen($fam_Address1);
// Added for GPIB
		$bFamilyKompleks1 = strlen($fam_Kompleks1);
		$bFamilyRTRW1 = strlen($fam_RTRW1);
		$bFamilyKelurahan1 = strlen($fam_Kelurahan1);
// End Added
		$bFamilyAddress2 = strlen($fam_Address2);
// Added for GPIB
		$bFamilyKompleks2 = strlen($fam_Kompleks2);
		$bFamilyRTRW2 = strlen($fam_RTRW2);
		$bFamilyKelurahan2 = strlen($fam_Kelurahan2);
// End Added
		$bFamilyCity = strlen($fam_City);
		$bFamilyState = strlen($fam_State);
		$bFamilyZip = strlen($fam_Zip);
		$bFamilyCountry = strlen($fam_Country);
		$bFamilyHomePhone = strlen($fam_HomePhone);
		$bFamilyWorkPhone = strlen($fam_WorkPhone);
		$bFamilyCellPhone = strlen($fam_CellPhone);
		$bFamilyEmail = strlen($fam_Email);

		$sSQL = "SELECT * FROM person_custom WHERE per_ID = " . $iPersonID;
		$rsCustomData = RunQuery($sSQL);
		$aCustomData = mysql_fetch_array($rsCustomData, MYSQL_BOTH);
	}
	else
	{
		//Adding....
		//Set defaults
		$sCity = $sDefaultCity;
		$sCountry = $sDefaultCountry;
		$sState = $sDefaultState;
		$iFamily = "0";
		$iFamilyRole = "0";
		$iClassification = "0";
		$bHomeBound = False;
	}
}

// Get appropriate donation envelope options
if ($_SESSION['bFinance'])
{
	if (isset($per_Envelope))  // Do they have an existing envelope number?
	{
		$aEnvelopeOptions[0] = $per_Envelope;
		$numEnvelopeOptions = 1;
	}
	else
	{
		$sSQL = "SELECT DISTINCT per_Envelope AS iEnvelope FROM person_per WHERE per_Envelope != 'NULL' ORDER BY per_Envelope ASC";
		$result = RunQuery($sSQL);
		$lastEnvelope = 0;
		$numEnvelopeOptions = 0;
		while ($aRow = mysql_fetch_array($result))
		{
			$thisEnvelope = $aRow['iEnvelope'];
			for($iOption = $lastEnvelope + 1; $iOption < $thisEnvelope; $iOption++)
			{
				$aEnvelopeOptions[$numEnvelopeOptions++] = $iOption;
			}
			$lastEnvelope = $thisEnvelope;
		}

		// If no recyclable unused IDs exist, create a new one.
		if ($numEnvelopeOptions == 0) $aEnvelopeOptions[$numEnvelopeOptions++] = $lastEnvelope + 1;
	}
}

//Get Classifications for the drop-down
$sSQL = "SELECT * FROM list_lst WHERE lst_ID = 1 ORDER BY lst_OptionSequence";
$rsClassifications = RunQuery($sSQL);

//Get Families for the drop-down
$sSQL = "SELECT * FROM family_fam ORDER BY fam_Name";
$rsFamilies = RunQuery($sSQL);

//Get Family Roles for the drop-down
$sSQL = "SELECT * FROM list_lst WHERE lst_ID = 2 ORDER BY lst_OptionSequence";
$rsFamilyRoles = RunQuery($sSQL);
?>


<? require "Include/Header.php"; ?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?PersonID=" . $iPersonID; ?>" name="PersonEditor">

<table cellpadding="3" align="center">

	<tr>
		<td <?php if ($numCustomFields > 0) echo "colspan=\"2\""; ?> align="center">
			<input type="submit" class="icButton" value="<?php echo gettext("Simpan"); ?>" name="PersonSubmit">
			<?php if ($_SESSION['bAddRecords']) { echo "<input type=\"submit\" class=\"icButton\" value=\"" . gettext("Simpan dan Tambah") . "\" name=\"PersonSubmitAndAdd\">"; } ?>
			<input type="button" class="icButton" value="<?php echo gettext("Batal"); ?>" name="PersonCancel" onclick="javascript:document.location='<?php if (strlen($iPersonID) > 0) { echo "PersonView.php?PersonID=" . $iPersonID; } else {echo "SelectList.php?mode=person"; } ?>';">
		</td>
	</tr>

	<tr>
		<td <?php if ($numCustomFields > 0) echo "colspan=\"2\""; ?> class="SmallText" align="center">
			<?php echo gettext("Warna"); ?> <span style="color: red;"><?php echo gettext("merah"); ?></span> <?php echo gettext("mempunyai nilai yang diambil dari data keluarga."); ?>
		</td>
	</tr>
	<tr>
		<td <?php if ($numCustomFields > 0) echo "colspan=\"2\""; ?> align="center">
		<?php if ( $bErrorFlag ) echo "<span class=\"LargeText\" style=\"color: red;\">" . gettext("Invalid fields or selections. Changes not saved! Please correct and try again!") . "</span>"; ?>
		</td>
	</tr>
	<tr>
		<td>
		<table cellpadding="3">
			<tr>
				<td colspan="2" align="center"><h3><?php echo gettext("Bagian Umum"); ?></h3></td>
			</tr>
			<tr>
				<?php if ($iFamily > 0) {
					$sSQL = "SELECT fam_NoIndFam, fam_NamaSek FROM family_fam WHERE fam_ID = " . $iFamily;
					$rsNoIndFam = RunQuery($sSQL);
					extract(mysql_fetch_array($rsNoIndFam));
					$sNoIndFam = $fam_NoIndFam;
					$sNamaSek = $fam_NamaSek;
				} ?>
				<td class="LabelColumn" <?php addToolTip("Contoh: 0003"); ?>><?php echo gettext("No Induk Jemaat: "); ?></td>
				<td class="TextColumn"><?php echo gettext($sNoIndFam) ?> - <input type="text" name="NoIndJem" id="NoIndJem" value="<?php echo htmlentities(stripslashes($sNoIndJem)); ?>">.<?php echo gettext($sNamaSek) ?></td>
			</tr>
			<tr>
				<td class="LabelColumn" <?php addToolTip("Contoh: Pdt. Ir. Dr. drs."); ?>><?php echo gettext("Titel:"); ?></td>
				<td class="TextColumn"><input type="text" name="Title" id="Title" value="<?php echo htmlentities(stripslashes($sTitle)); ?>"></td>
			</tr>

			<tr>
				<td class="LabelColumn"><?php echo gettext("Nama Depan:"); ?></td>
				<td class="TextColumn"><input type="text" name="FirstName" id="FirstName" value="<?php echo htmlentities(stripslashes($sFirstName)); ?>"><br><font color="red"><?php echo $sFirstNameError ?></font></td>
			</tr>

			<tr>
				<td class="LabelColumn"><?php echo gettext("Nama Tengah:"); ?></td>
				<td class="TextColumn"><input type="text" name="MiddleName" value="<?php echo htmlentities(stripslashes($sMiddleName)); ?>"></td>
			</tr>

			<tr>
				<td class="LabelColumn"><?php echo gettext("Nama Belakang:"); ?></td>
				<td class="TextColumn"><input type="text" name="LastName" id="LastName" value="<?php echo htmlentities(stripslashes($sLastName)); ?>"><br><font color="red"><?php echo $sLastNameError ?></font></td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Contoh: S.Kom, SE, SH"); ?>><?php echo gettext("Gelar Sarjana:"); ?></td>
				<td class="TextColumn"><input type="text" name="Suffix" id="Suffix" value="<?php echo htmlentities(stripslashes($sSuffix)); ?>"></td>
			</tr>

			<tr>
				<td class="LabelColumn"><?php echo gettext("Jenis Kelamin:"); ?></td>
				<td class="TextColumnWithBottomBorder">
					<select name="Gender">
						<option value="0"><?php echo gettext("Jenis Kelamin"); ?></option>
						<option value="1" <?php if ($iGender == 1) { echo "selected"; } ?>><?php echo gettext("Laki-laki"); ?></option>
						<option value="2" <?php if ($iGender == 2) { echo "selected"; } ?>><?php echo gettext("Perempuan"); ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
			</tr>
<?php
/*			<?php if ($_SESSION['bFinance']) { ?>
//			<tr>
//				<td class="LabelColumn" <?php addToolTip("Envelope Numbers are automatically assigned to prevent duplication. Simply select an available envelope number if needed."); ?>><?php echo gettext("Donation Envelope:"); ?></td>
//				<td class="TextColumn">
//					<select name="EnvID">
//						<option value=""><?php echo gettext("None"); ?></option>
//						<?php
//						for ($iOption = 0; $iOption < $numEnvelopeOptions; $iOption++)
//						{
//							$thisEnvelope = $aEnvelopeOptions[$iOption];
//
//							echo "<option value=\"" . $thisEnvelope . "\"";
//							if ($per_Envelope == $thisEnvelope) echo " selected";
//							echo ">" . $thisEnvelope . "</option>" ;
//						}
//						?>
//					</select>
//				</td>
//			</tr>
//			<tr>
//				<td>&nbsp;</td>
//			</tr>
//			<?php //} ?> */
?>
			<tr>
				<td class="LabelColumn" <?php addToolTip("If a family member, select the appropriate family from the list. Otherwise, leave this as is."); ?>><?php echo gettext("Keluarga:"); ?></td>
				<td class="TextColumn">
					<select name="Family" size="8">
						<option value="0" selected><?php echo gettext("Belum Terisi"); ?></option>
						<option value="0">-----------------------</option>

						<?php
						while ($aRow = mysql_fetch_array($rsFamilies))
						{
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
				<td class="LabelColumn" <?php addToolTip("Select the appropriate role for the individual. If no family is assigned, do not assign a role."); ?>><?php echo gettext("Status di keluarga:"); ?></td>
				<td class="TextColumnWithBottomBorder">
					<select name="FamilyRole">
						<option value="0"><?php echo gettext("Belum terisi"); ?></option>
						<option value="0">-----------------------</option>

						<?php
						while ($aRow = mysql_fetch_array($rsFamilyRoles))
						{
							extract($aRow);

							echo "<option value=\"" . $lst_OptionID . "\"";
							if ($iFamilyRole == $lst_OptionID) { echo " selected"; }
							echo ">" . $lst_OptionName . "&nbsp;";
						}
						?>

					</select>
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Main address for an individual. If the address does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyAddress1) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Alamat I:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="Address1" value="<?php echo htmlentities(stripslashes($sAddress1)); ?>" size="30" maxlength="50"></td>
			</tr>
<?php
// Added for GPIB ?>
			<tr>
				<td class="LabelColumn" <?php addToolTip("Main address for an individual. If the address does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyKompleks1) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Kompleks I:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="Kompleks1" value="<?php echo htmlentities(stripslashes($sKompleks1)); ?>" size="30" maxlength="50"></td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Main address for an individual. If the address does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyRTRW1) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("RT-RW I:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="RTRW1" value="<?php echo htmlentities(stripslashes($sRTRW1)); ?>" size="30" maxlength="50"></td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Main address for an individual. If the address does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyKelurahan1) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Kelurahan I:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="Kelurahan1" value="<?php echo htmlentities(stripslashes($sKelurahan1)); ?>" size="30" maxlength="50"></td>
			</tr>

<?php
// End Added ?>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Additional information if needed. If the address does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyAddress2) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Alamat II:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="Address2" value="<?php echo htmlentities(stripslashes($sAddress2)); ?>" size="30" maxlength="50"></td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Additional information if needed. If the address does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyKelurahan2) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Kelurahan II:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="Kelurahan2" value="<?php echo htmlentities(stripslashes($sKelurahan2)); ?>" size="30" maxlength="50"></td>
			</tr>

<?php
// Added for GPIB ?>
			<tr>
				<td class="LabelColumn" <?php addToolTip("Additional information if needed. If the address does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyKompleks2) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Kompleks II:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="Kompleks2" value="<?php echo htmlentities(stripslashes($sKompleks2)); ?>" size="30" maxlength="50"></td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Additional information if needed. If the address does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyRTRW2) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("RT-RW II:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="RTRW2" value="<?php echo htmlentities(stripslashes($sRTRW2)); ?>" size="30" maxlength="50"></td>
			</tr>

<?php
// End Added ?>
			<tr>
				<td class="LabelColumn" <?php addToolTip("If the city does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyCity) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Kota:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="City" value="<?php echo htmlentities(stripslashes($sCity)); ?>"></td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Either use the drop-down menu (for the US) or text box. If the state does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyState) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Provinsi:"); ?></span></td>
				<td class="TextColumn">
					<?php require "Include/StateDropDown.php"; ?>
					OR
					<input type="text" name="StateTextbox" value="<?php if ($sPhoneCountry != "United States" && $sPhoneCountry != "Canada") echo htmlentities(stripslashes($sState)); ?>" size="20" maxlength="30">
					<BR><?php echo gettext("(Use the textbox for countries other than US and Canada)"); ?>
				</td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("If the ZIP does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyZip) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Kode Pos:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="Zip" value="<?php echo htmlentities(stripslashes($sZip)); ?>" maxlength="10" size="8"></td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Use the drop-down menu to select the appropriate country. If the Country does not differ from the family, leave this field blank."); ?>><?php if ($bFamilyCountry) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Negara:"); ?></span></td>
				<td class="TextColumnWithBottomBorder">
					<?php require "Include/CountryDropDown.php"; ?>
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Format: xxx-xxx-xxxx Ext. xxx.<br>If the Home Phone does not differ from the family, leave this field blank."); ?>>
					<?php
					if ($bFamilyHomePhone)
						echo "<span style=\"color: red;\">". gettext("Telepon Rumah:") ."</span>";
					else
						echo gettext("Telepon Rumah:");
					?>
				</td>
				<td class="TextColumn">
					<input type="text" name="HomePhone" value="<?php echo htmlentities(stripslashes($sHomePhone)); ?>" size="30" maxlength="30">
					<br><input type="checkbox" name="NoFormat_HomePhone" value="1" <?php if ($bNoFormat_HomePhone) echo " checked";?>><?php echo gettext("Jangan menggunakan format otomatis"); ?>
				</td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Format: xxx-xxx-xxxx Ext. xxx.<br>If the Work Phone does not differ from the family, leave this field blank."); ?>>
					<?php
					if ($bFamilyWorkPhone)
						echo "<span style=\"color: red;\">" . gettext("Telepon Kantor:") . "</span>";
					else
						echo gettext("Telepon Kantor:");
					?>
				</td>
				<td class="TextColumn">
					<input type="text" name="WorkPhone" value="<?php echo htmlentities(stripslashes($sWorkPhone)); ?>" size="30" maxlength="30">
					<br><input type="checkbox" name="NoFormat_WorkPhone" value="1" <?php if ($bNoFormat_WorkPhone) echo " checked";?>><?php echo gettext("Jangan menggunakan format otomatis"); ?>
				</td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Format: xxx-xxx-xxxx Ext. xxx.<br>If the Mobile Phone does not differ from the family, leave this field blank."); ?>>
					<?php
					if ($bFamilyCellPhone)
						echo "<span style=\"color: red;\">" . gettext("Telepon Genggam:") . "</span>";
					else
						echo gettext("Telepon Genggam:");
					?>
				</td>
				<td class="TextColumn">
					<input type="text" name="CellPhone" value="<?php echo htmlentities(stripslashes($sCellPhone)); ?>" size="30" maxlength="30">
					<br><input type="checkbox" name="NoFormat_CellPhone" value="1" <?php if ($bNoFormat_CellPhone) echo " checked";?>><?php echo gettext("Jangan menggunakan format otomatis"); ?>
				</td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("If the Email does not differ from the family, leave this field blank."); ?>>
					<?php
						if ($bFamilyEmail)
							echo "<span style=\"color: red;\">" . gettext("Alamat Email:") . "</span></td>";
						else
							echo gettext("Email:") . "</td>";
					?>
				<td class="TextColumnWithBottomBorder"><input type="text" name="Email" value="<?php echo htmlentities(stripslashes($sEmail)); ?>" size="30"></td>
			</tr>

			<tr>
				<td class="LabelColumn"><?php echo gettext("Email Kantor/Lainnya:"); ?></td>
				<td class="TextColumnWithBottomBorder"><input type="text" name="WorkEmail" value="<?php echo htmlentities(stripslashes($sWorkEmail)); ?>" size="30"></td>
			</tr>

			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="LabelColumn"><?php echo gettext("Tempat Lahir:"); ?></td>
				<td class="TextColumnWithBottomBorder"><input type="text" name="BirthPlace" value="<?php echo htmlentities(stripslashes($iBirthPlace)); ?>" size="30"></td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Use drop down-menus to select the birth date. If the year is not known, you can still include the date (for birthday reference), although age will not be calculated."); ?>><?php echo gettext("Tanggal Lahir:"); ?></td>
				<td class="TextColumn">
					<select name="BirthMonth">
						<option value="0" <?php if ($iBirthMonth == 0) { echo "selected"; } ?>><?php echo gettext("Tidak diketahui"); ?></option>
						<option value="01" <?php if ($iBirthMonth == 1) { echo "selected"; } ?>><?php echo gettext("Januari"); ?></option>
						<option value="02" <?php if ($iBirthMonth == 2) { echo "selected"; } ?>><?php echo gettext("Februari"); ?></option>
						<option value="03" <?php if ($iBirthMonth == 3) { echo "selected"; } ?>><?php echo gettext("Maret"); ?></option>
						<option value="04" <?php if ($iBirthMonth == 4) { echo "selected"; } ?>><?php echo gettext("April"); ?></option>
						<option value="05" <?php if ($iBirthMonth == 5) { echo "selected"; } ?>><?php echo gettext("Mei"); ?></option>
						<option value="06" <?php if ($iBirthMonth == 6) { echo "selected"; } ?>><?php echo gettext("Juni"); ?></option>
						<option value="07" <?php if ($iBirthMonth == 7) { echo "selected"; } ?>><?php echo gettext("Juli"); ?></option>
						<option value="08" <?php if ($iBirthMonth == 8) { echo "selected"; } ?>><?php echo gettext("Agustus"); ?></option>
						<option value="09" <?php if ($iBirthMonth == 9) { echo "selected"; } ?>><?php echo gettext("September"); ?></option>
						<option value="10" <?php if ($iBirthMonth == 10) { echo "selected"; } ?>><?php echo gettext("Oktober"); ?></option>
						<option value="11" <?php if ($iBirthMonth == 11) { echo "selected"; } ?>><?php echo gettext("November"); ?></option>
						<option value="12" <?php if ($iBirthMonth == 12) { echo "selected"; } ?>><?php echo gettext("Desember"); ?></option>
					</select>
					<select name="BirthDay">
						<option value="0"><?php echo gettext(""); ?></option>
						<?php for ($x=1; $x < 32; $x++)
						{
							if ($x < 10) { $sDay = "0" . $x; } else { $sDay = $x; }
						?>
							<option value="<?php echo $sDay ?>" <?php if ($iBirthDay == $x) {echo "selected"; } ?>><?php echo $x ?></option>
						<?php } ?>
					</select>
				<font color="red"><?php echo $sBirthDateError ?></font>
				</td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("It must be in four-digit format (XXXX).<br>If the birth date is not known, you can still include the date (for age reference), although birthday will not be calculated."); ?>><?php echo gettext("Tahun Lahir:"); ?></td>
				<td class="TextColumn"><input type="text" name="BirthYear" value="<?php echo $iBirthYear ?>" maxlength="4" size="5"><font color="red"><br><?php echo $sBirthYearError ?></font><br><font size="1"><?php echo gettext("Must be four-digit format."); ?></font></td>
			</tr>

			<tr>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Format: YYYY-MM-DD<br>or enter the date by clicking on the calendar icon to the right."); ?>><?php if ($bFamilyMembership) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Tanggal Terdaftar:"); ?></span></td>
				<td class="TextColumn"><input type="text" name="MembershipDate" value="<?php echo $dMembershipDate; ?>" maxlength="10" id="sel1" size="11">&nbsp;<input type="image" onclick="return showCalendar('sel1', 'y-mm-dd');" src="Images/calendar.gif"> <span class="SmallText"><?php echo gettext("[format: YYYY-MM-DD]"); ?></span><font color="red"><?php echo $sMembershipDateError ?></font></td>
			</tr>

			<tr>
				<td class="LabelColumn"><?php if ($bFamilyAsalGS) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Asal Gereja Sebelum:"); ?></span></td>
				<td class="TextColumnWithBottomBorder">
				<select name="AsalGS">
					<option value="" <?php if ($aAsalGS == "") echo "selected" ?> ><?php echo gettext("Asal Gereja Sebelum"); ?></option>
					<option value="G" <?php if ($aAsalGS == "G") echo "selected" ?> ><?php echo gettext("GPIB"); ?></option>
					<option value="N" <?php if ($aAsalGS == "N") echo "selected" ?> ><?php echo gettext("Non-GPIB"); ?></option>
				</select></td>
			</tr>

			<tr>
				<td class="LabelColumn"><?php if ($bFamilyNamaGS) { echo "<span style=\"color: red;\">"; } ?><?php echo gettext("Nama Gereja Sebelum:"); ?></span></td>
				<td class="TextColumnWithBottomBorder"><input type="text" name="NamaGS" value="<?php echo htmlentities(stripslashes($sNamaGS)); ?>" size="30"></td>
			</tr>

			<tr>
				<td class="LabelColumn" <?php addToolTip("Select the appropriate classification. These can be set using the classification manager in admin."); ?>><?php echo gettext("Jenis Keanggotaan:"); ?></td>
				<td class="TextColumnWithBottomBorder">
					<select name="Classification">
						<option value="0"><?php echo gettext("Belum Terisi"); ?></option>
						<option value="0">-----------------------</option>

						<?php
						while ($aRow = mysql_fetch_array($rsClassifications))
						{
							extract($aRow);

							echo "<option value=\"" . $lst_OptionID . "\"";
							if ($iClassification == $lst_OptionID) { echo " selected"; }
							echo ">" . $lst_OptionName . "&nbsp;";
						}
						?>

					</select>
				</td>
			</tr>
		</table>
		</td>

		<?php if ($numCustomFields > 0) { ?>
			<td valign="top">
			<table cellpadding="3">
				<tr>
					<td colspan="2" align="center"><h3><?php echo gettext("Bagian Tambahan"); ?></h3></td>
				</tr>
				<?php
				mysql_data_seek($rsCustomFields,0);

				while ( $rowCustomField = mysql_fetch_array($rsCustomFields, MYSQL_BOTH) )
				{
					extract($rowCustomField);

					echo "<tr><td class=\"LabelColumn\">" . $custom_Name . "</td><td class=\"TextColumn\">";

					$currentFieldData = trim($aCustomData[$custom_Field]);

					if ($type_ID == 11) $custom_Special = $sPhoneCountry;

					formCustomField($type_ID, $custom_Field, $currentFieldData, $custom_Special, !isset($_POST["PersonSubmit"]));
					echo "<span style=\"color: red; \">" . $aCustomErrors[$custom_Field] . "</span>";
					echo "</td></tr>";
				}
				?>
			</table>
			</td>
		<?php } ?>

	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td <?php if ($numCustomFields > 0) echo "colspan=\"2\""; ?> align="center">
			<input type="submit" class="icButton" <?php echo 'value="' . gettext("Simpan") . '"'; ?> name="PersonSubmit">
			<?php if ($_SESSION['bAddRecords']) { echo "<input type=\"submit\" class=\"icButton\" value=\"" . gettext("Simpan dan Tambah") . "\" name=\"PersonSubmitAndAdd\">"; } ?>
			<input type="button" class="icButton" <?php echo 'value="' . gettext("Batal") . '"'; ?> name="PersonCancel" onclick="javascript:document.location='<?php if (strlen($iPersonID) > 0) { echo "PersonView.php?PersonID=" . $iPersonID; } else {echo "SelectList.php?mode=person"; } ?>';">
		</td>
	</tr>

	</form>

</table>

<?php
require "Include/Footer.php";
?>
