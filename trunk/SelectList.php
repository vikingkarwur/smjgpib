<?php
/*******************************************************************************
*
*  filename    : SelectList.php
*  last change : 2003-03-27
*  website     : http://www.infocentral.org
*  copyright   : Copyright 2001-2003 Deane Barker and Chris Gebhardt
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
// Filter received user input as needed
if (strlen($_GET["Sort"]))
	$sSort = FilterInput($_GET["Sort"]);
else
	$sSort = "name";

if (isset($_GET["PrintView"])) $bPrintView = true;

if (strlen($_GET["Filter"])) $sFilter = FilterInput($_GET["Filter"]);
if (strlen($_GET["Letter"])) $sLetter = FilterInput($_GET["Letter"],'char');

$sMode = $_GET["mode"];

if (isset($_GET["Number"]))
{
	$_SESSION['SearchLimit'] = FilterInput($_GET["Number"],'int');
	$uSQL = "UPDATE user_usr SET usr_SearchLimit = " . $_SESSION['SearchLimit'] . " WHERE usr_per_ID = " . $_SESSION['iUserID'];
	$rsUser = RunQuery($uSQL);
}

// Set the page title
if ($sMode == 'person')
{
	$sPageTitle = gettext("Daftar Individu");
	$iMode = 1;

	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	if (strlen($_GET["grouptype"]))
	{
		$iGroupType = FilterInput($_GET["grouptype"],'int');
		if (strlen($_GET["groupid"]))
		{
			$iGroupID = FilterInput($_GET["groupid"],'int');
			if ($iGroupID == 0) unset($iGroupID);
		}
	}
}
elseif ($sMode == 'groupassign')
{
	$sPageTitle = gettext("Group Assignment Helper");
	$iMode = 2;

	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	if (isset($_GET["type"]))
		$iGroupTypeMissing = FilterInput($_GET["type"],'int');
	else
		$iGroupTypeMissing = 1;
}
elseif ($sMode == "family")
{
	$sPageTitle = gettext("Daftar Keluarga");
	$iMode = 3;
}
elseif ($sMode == "PA")
{
	$sPageTitle = gettext("Daftar Anggota : BPK Pelayanan Anak");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 4;
}
elseif ($sMode == "PT")
{
	$sPageTitle = gettext("Daftar Anggota : BPK Persekutuan Teruna");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 5;
}
elseif ($sMode == "GP")
{
	$sPageTitle = gettext("Daftar Anggota : BPK Gerakan Pemuda");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 6;
}
elseif ($sMode == "PW")
{
	$sPageTitle = gettext("Daftar Anggota : BPK Pelayanan Wanita");
	$iMode = 7;
}
elseif ($sMode == "PKB")
{
	$sPageTitle = gettext("Daftar Anggota : BPK Persekutuan Kaum Bapak");
	$iMode = 8;
}
elseif ($sMode == "PENATUA")
{
	$sPageTitle = gettext("Daftar Presbiter : Penatua");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 9;
}
elseif ($sMode == "DIAKEN")
{
	$sPageTitle = gettext("Daftar Presbiter : Diaken");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 10;
}
elseif ($sMode == "PENDETA")
{
	$sPageTitle = gettext("Daftar Presbiter : Pendeta");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 11;
}
elseif ($sMode == "SENIOR")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Senior");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 12;
}
elseif ($sMode == "AnggotaJemaat")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Anggota");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 13;
}
elseif ($sMode == "AnggotaJemaat1")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Anggota");
	$iMode = 14;
}
elseif ($sMode == "AnggotaJemaat2")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Anggota");
	$iMode = 15;
}
elseif ($sMode == "FEMALENON")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Anggota");
	$iMode = 16;
}
elseif ($sMode == "MALENON")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Anggota");
	$iMode = 17;
}
elseif ($sMode == "NON")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Anggota");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 18;
}
elseif ($sMode == "SIDI")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Sidi");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 19;
}
elseif ($sMode == "SIDIMALE")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Sidi Pria");
	$iMode = 20;
}
elseif ($sMode == "SIDIFEMALE")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Sidi Wanita");
	$iMode = 21;
}
elseif ($sMode == "NONSIDI")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Non Sidi");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 22;
}
elseif ($sMode == "NONSIDIMALE")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Non Sidi Pria");
	$iMode = 23;
}
elseif ($sMode == "NONSIDIFEMALE")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Non Sidi Wanita");
	$iMode = 24;
}
elseif ($sMode == "NONBPP")
{
	$sPageTitle = gettext("Daftar Anggota : Warga Non Jakarta Timur");
	if (strlen($_GET["Gender"])) $iGender = FilterInput($_GET["Gender"],'int');
	$iMode = 25;
}
$iPerPage = $_SESSION['SearchLimit'];

if (!$bPrintView)
{?>

	              <? require "Include/Header.php"; ?>
<? }
else
	require "Include/Header-Short.php";

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

<?php
if ($iMode == 1 || $iMode == 2 || $iMode > 3)
{
	// SQL for group-assignment helper
	if ($iMode == 2)
	{
		$sBaseSQL = "SELECT *, IF(LENGTH(per_Zip) > 0,per_Zip,fam_Zip) AS zip FROM person_per
			LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID";

		// Find people who are part of a group of the specified type.
		// MySQL doesn't have subqueries until version 4.1.. for now, do it the hard way
		$sSQLsub = "SELECT per_ID FROM person_per
					LEFT JOIN person2group2role_p2g2r ON p2g2r_per_ID = per_ID
					LEFT JOIN group_grp ON grp_ID = p2g2r_grp_ID
					WHERE grp_Type = $iGroupTypeMissing GROUP BY per_ID ";
		$rsSub = RunQuery($sSQLsub);

		if (mysql_num_rows($rsSub) > 0)
		{
			$sExcludedIDs = "";
			while ($aTemp = mysql_fetch_row($rsSub))
			{
				$sExcludedIDs .= $aTemp[0] . ",";
			}
			$sExcludedIDs = substr($sExcludedIDs,0,-1);

			$sGroupWhereExt = " AND per_ID NOT IN (" . $sExcludedIDs . ")";
		}
	}

	// SQL for standard Person List
	if ($iMode == 1 || $iMode > 3)
	{
		// Set the base SQL
		$sBaseSQL = "SELECT *, IF(LENGTH(per_Zip) > 0,per_Zip,fam_Zip) AS zip FROM person_per
					LEFT JOIN family_fam ON per_fam_ID = family_fam.fam_ID";

		if (isset($iGroupID) || isset($iGroupType))
		{
			$sJoinExt = " LEFT JOIN person2group2role_p2g2r ON per_ID = p2g2r_per_ID";
			$sGroupBySQL = " GROUP BY per_ID";
		}

		if (isset($iGroupType))
		{
			$sJoinExt .= " LEFT JOIN group_grp ON grp_ID = p2g2r_grp_ID";
		}

		if (isset($iGroupType))
		{
			if (isset($iGroupID))
			{
				$sTestSQL = "SELECT '' FROM group_grp WHERE grp_ID = $iGroupID AND grp_Type = $iGroupType";
				$rsGroupInType = RunQuery($sTestSQL);
				if (mysql_num_rows($rsGroupInType) > 0)
					$sGroupWhereExt = " AND p2g2r_grp_ID = " . $iGroupID;
				else
				{
					$sGroupWhereExt = " AND grp_Type = " . $iGroupType;
					unset($iGroupID);
				}
			}
			else
				$sGroupWhereExt = " AND grp_Type = " . $iGroupType;
		}
	}

	if (isset($sFilter))
	{
		// Check if there's a space
		if (strstr($sFilter," "))
		{
			// break on the space...
			$aFilter = explode(" ",$sFilter);

			// use the results to check the first and last names
			$sFilterWhereExt = " AND per_FirstName LIKE '%" . $aFilter[0] . "%' AND per_LastName LIKE '%" . $aFilter[1] . "%'";
		}
		else
			$sFilterWhereExt = " AND (per_FirstName LIKE '%" . $sFilter . "%' OR per_LastName LIKE '%" . $sFilter . "%')";

		// Clear any previously set Letter filter to avoid re-submit in hidden form field
		// $sLetter = "";
	}

	if (isset($iGender))
	{
		$sGenderWhereExt = " AND per_Gender = " . $iGender;
	}

	if (isset($sLetter))
	{
		$sLetterWhereExt = " AND per_LastName LIKE '" . $sLetter . "%'";
	}

	if ($iMode > 3 && $iMode < 28)
	{
		$sJoinExt = " LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID";
	}

	if ($iMode == 4)
	{
		$sBPK = " AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) >= CURDATE() AND per_cls_ID=1";
	}

	if ($iMode == 5)
	{
		$sBPK = " AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) >= CURDATE() AND per_cls_ID=1";
	}

	if ($iMode == 6)
	{
		$sBPK = " AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) >= CURDATE() AND c16=1 AND per_cls_ID=1";
	}

	if ($iMode == 7)
	{
		$sBPK = " AND (DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_Gender=2 OR (c16=2 AND per_Gender=2) OR (c16=3 AND per_Gender=2)) AND per_cls_ID=1";
	}


	if ($iMode == 8)
	{
		$sBPK = " AND (DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) <= CURDATE() AND per_cls_ID=1 AND per_Gender=1 OR (c16=2 AND per_Gender=1) OR (c16=4 AND per_Gender=1)) AND per_cls_ID=1 ";
	}

	if ($iMode == 9)
	{
//		$sBPK = " AND p2g2r_per_ID AND p2g2r_grp_ID = 29 AND  p2g2r_rle_ID= 2"; (penatua)
        $sBPK =  " AND c19 LIKE '%penatua%' AND per_cls_ID=1";
	}

	if ($iMode == 10)
	{
		$sBPK = "  AND c19 LIKE '%diaken%' AND per_cls_ID=1";
	}

	if ($iMode == 11)
	{
        $sBPK = " AND c19 LIKE '%pendeta%' AND per_cls_ID=1";
		//$sBPK = " AND Dp2g2r_per_ID AND p2g2r_grp_ID = 29 AND  p2g2r_rle_ID= 1";
	}
	if ($iMode == 12)
	{
		$sBPK = " AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 60 YEAR) <= CURDATE() AND per_cls_ID=1";
	}
	if ($iMode == 13)
	{
    $sBPK = " AND per_cls_ID!=''";
	}
	if ($iMode == 14)
	{
    $sBPK = " AND per_Gender=1 AND per_cls_ID=1";
	}
	if ($iMode == 15)
	{
    $sBPK = " AND per_cls_ID=1 AND per_Gender=2";
	}
    if ($iMode == 16)
	{
    $sBPK = " AND per_Gender = 2 AND per_cls_ID!=1 AND per_cls_ID!=0";
	}
	if ($iMode == 17)
	{
    $sBPK = " AND per_Gender = 1 AND (per_cls_ID!=1 OR per_cls_ID='')";
	}
	if ($iMode == 18)
	{
    $sBPK = " AND per_cls_ID!=1";
	}
	if ($iMode == 19)
	{
    $sBPK = " AND per_cls_ID=1 AND c4='true'";
	}
	if ($iMode == 20)
	{
    $sBPK = " AND per_cls_ID=1 AND c4='true' AND per_Gender=1";
	}
	if ($iMode == 21)
	{
    $sBPK = " AND per_cls_ID=1 AND c4='true' AND per_Gender=2";
	}
	if ($iMode == 22)
	{
    $sBPK = " AND per_cls_ID=1 AND c4='false'";
	}
	if ($iMode == 23)
	{
    $sBPK = " AND per_cls_ID=1 AND c4='false' AND per_Gender=1";
	}
	if ($iMode == 24)
	{
    $sBPK = " AND per_cls_ID=1 AND c4='false' AND per_Gender=2";
	}
	if ($iMode == 25)
	{
    $sBPK = " AND per_cls_ID=1 AND (c13 NOT LIKE '%Jakarta%' OR c13='')";
	}
	$sWhereExt = $sGroupWhereExt . $sFilterWhereExt . $sGenderWhereExt . $sLetterWhereExt . $sBPK;
	$sSQL = $sBaseSQL . $sJoinExt . " WHERE 1" . $sWhereExt . $sGroupBySQL;

	// If AddToCart submit button was used, run the query, add people to cart, and view cart
	if (isset($_GET["AddAllToCart"]))
	{
		$rsPersons = RunQuery($sSQL);
		while ($aRow = mysql_fetch_row($rsPersons))
		{
			AddToPeopleCart($aRow[0]);
		}

		Redirect("CartView.php");
	}
	elseif (isset($_GET["IntersectCart"]))
	{
		$rsPersons = RunQuery($sSQL);
		while ($aRow = mysql_fetch_row($rsPersons))
			$aItemsToProcess[] = $aRow[0];

		if (isset($_SESSION['aPeopleCart']))
			$_SESSION['aPeopleCart'] = array_intersect($_SESSION['aPeopleCart'],$aItemsToProcess);

		Redirect("CartView.php");
	}
	elseif (isset($_GET["RemoveFromCart"]))
	{
		$rsPersons = RunQuery($sSQL);
		while ($aRow = mysql_fetch_row($rsPersons))
			$aItemsToProcess[] = $aRow[0];

		if (isset($_SESSION['aPeopleCart']))
			$_SESSION['aPeopleCart'] = array_diff($_SESSION['aPeopleCart'],$aItemsToProcess);

		Redirect("CartView.php");
	}

	// Get the total number of persons
	$rsPer = RunQuery($sSQL);
	$Total = mysql_num_rows($rsPer);

	// Select the proper sort SQL
	switch($sSort)
	{
		case "family":
			$sOrderSQL = " ORDER BY fam_Name";
			break;
		case "zip":
			$sOrderSQL = " ORDER BY zip, per_LastName, per_FirstName";
			break;
		case "entered":
			$sOrderSQL = " ORDER BY per_DateEntered DESC";
			break;
		default:
			$sOrderSQL = " ORDER BY per_LastName, per_FirstName";
			break;
	}

	// Regular PersonList display
	if (!$bPrintView)
	{
		// Append a LIMIT clause to the SQL statement
		if (empty($_GET['Result_Set']))
			$Result_Set = 0;
		else
			$Result_Set = FilterInput($_GET['Result_Set'],'int');
		$sLimitSQL .= " LIMIT $Result_Set, $iPerPage";

		// Run the query with order and limit to get the final result for this list page
		$finalSQL = $sSQL . $sOrderSQL . $sLimitSQL;
		$rsPersons = RunQuery($finalSQL);

		// Run query to get first letters of last name.
		$sSQL = "SELECT DISTINCT LEFT(per_LastName,1) AS letter FROM person_per	$sJoinExt
				WHERE 1 $sWhereExt ORDER BY letter";
		$rsLetters = RunQuery($sSQL);

		echo "<form method=\"get\" action=\"SelectList.php\" name=\"PersonList\">\n";
		echo "<table align=\"center\">\n<tr><td>";

		if ($iMode == 1)
		{
			echo "<p align=\"center\">";
			if ($_SESSION['bAddRecords'])
				echo "<a href=\"PersonEditor.php\">" . gettext("Tambah Individu Baru") . "</a><BR>";
			echo "<a href=\"SelectList.php?mode=$sMode&type=$iGroupTypeMissing&Filter=$sFilter&Gender=$iGender&grouptype=$iGroupType&groupid=$iGroupID";
			if($sSort) echo "&Sort=$sSort";
			echo "&Letter=$sLetter&PrintView=1\">" . gettext("Lihat halaman yang dapat dicetak dari daftar ini.") . "</a>";
		}
		elseif ($iMode == 2)
		{
			$sSQLtemp = "SELECT * FROM list_lst WHERE lst_ID = 3";
			$rsGroupTypes = RunQuery($sSQLtemp);
			echo "<p align=\"center\" class=\"MediumText\">" . gettext("Show people <b>not</b> in this group type:");
			echo "<select name=\"type\" onchange=\"this.form.submit()\">";
			while ($aRow = mysql_fetch_array($rsGroupTypes))
			{
				extract($aRow);
				echo "<option value=\"" . $lst_OptionID . "\"";
				if ($iGroupTypeMissing == $lst_OptionID) { echo " selected"; }
				echo ">" . $lst_OptionName . "&nbsp;";
			}
			echo "</select></p>";
		}

		?>
		</td></tr>
		<tr><td align="center">
		<?php echo gettext("Diurutkan Berdasarkan:"); ?>
		<select name="Sort">
			<option value="name" <?php if ($sSort == "name" || empty($sSort)) echo "selected";?>><?php echo gettext("Nama"); ?></option>
			<option value="family" <?php if ($sSort == "family") echo "selected";?>><?php echo gettext("Keluarga"); ?></option>
			<option value="zip" <?php if ($sSort == "zip") echo "selected";?>><?php echo gettext("Kode Pos"); ?></option>
			<option value="entered" <?php if ($sSort == "entered") echo "selected";?>><?php echo gettext("yang diisi terakhir kali"); ?></option>
		</select>&nbsp;
		<input type="text" name="Filter" value="<?php echo $sFilter;?>">
		<input type="hidden" name="mode" value="<?php echo $sMode;?>">
		<input type="hidden" name="Letter" value="<?php echo $sLetter;?>">
		<input type="submit" class="icButton" <?php echo 'value="' . gettext("Jalankan Penyaringan") . '"'; ?>>

		</td></tr>

		<tr><td align="center">
		<?php if ($iMode != 7 & $iMode != 8) { ?>
			<select name="Gender" onchange="this.form.submit()">
				<option value="" <?php if (!isset($iGender)) { echo " selected "; }?>><?php echo gettext ("Semua"); ?></option>
				<option value="1" <?php if ($iGender == 1) { echo " selected "; }?>><?php echo gettext ("Laki-laki"); ?></option>
				<option value="2" <?php if ($iGender == 2) { echo " selected "; }?>><?php echo gettext ("Perempuan"); ?></option>
			</select>
		<?php } ?>

		<?php if ($iMode == 1) { ?>
			<select name="grouptype" onchange="this.form.submit()">
				<?php
				$sGroupTypeSQL = "SELECT * FROM list_lst WHERE lst_ID='3' ORDER BY lst_OptionSequence";
				$rsGroupTypes = RunQuery($sGroupTypeSQL);

				echo "<option value=\"\" ";
				if (!isset($iGroupType)) echo " selected ";
				echo ">" . gettext("Semua Type Grup") . "</option>";

				while($orows = mysql_fetch_array($rsGroupTypes))
				{
					$OptionID = $orows["lst_OptionID"];
					$OptionName = $orows["lst_OptionName"];
					echo "<option value=\"$OptionID\"";
					if ($iGroupType==$OptionID) echo " selected ";
					echo ">$OptionName </option>";
				}
				?>
			</select>
			<?php
			if (isset($iGroupType))
			{
				$sGroupsSQL = "SELECT * FROM group_grp WHERE grp_Type = $iGroupType";
				$rsGroups = RunQuery($sGroupsSQL);

				echo "<select name=\"groupid\" onchange=\"this.form.submit()\">";
				echo "<option value=\"\" ";
				if (!isset($iGroupType)) echo " selected ";
				echo ">" . gettext("Semua Grup") . "</option>";

				while($prows = mysql_fetch_array($rsGroups))
				{
					$grp_ID = $prows["grp_ID"];
					$grp_Name = $prows["grp_Name"];
					echo "<option value=\"$grp_ID\"";
					if ($iGroupID == $grp_ID) echo " selected ";
					echo ">$grp_Name </option>";
				}
				echo "</select>";
			}
			?>
		<?php } ?>
		<?php if ($iMode != 7 & $iMode != 8) { ?>
			<input type="button" class="icButton" value="<?php echo gettext("Hapus penyaringan"); ?>" onclick="javascript:document.location='SelectList.php?mode=<?php echo $sMode; ?>&Sort=<?php echo $sSort; ?>&type=<?php echo $iGroupTypeMissing; ?>'"><BR><BR>
		<?php } ?>
			<input name="AddAllToCart" type="submit" class="icButton" <?php echo 'value="' . gettext("Add to Cart") . '"'; ?>>&nbsp;
			<input name="IntersectCart" type="submit" class="icButton" <?php echo 'value="' . gettext("Intersect with Cart") . '"'; ?>>&nbsp;
			<input name="RemoveFromCart" type="submit" class="icButton" <?php echo 	'value="' . gettext("Remove from Cart") . '"'; ?>>

			</td></tr>
		</form>
		</table>
		<?php
		// Create Sort Links
		echo "<div align=\"center\">";
		echo "<a href=\"SelectList.php?mode=$sMode&type=$iGroupTypeMissing&Filter=$sFilter&Gender=$iGender&grouptype=$iGroupType&groupid=$iGroupID";
		if($sSort) echo "&Sort=$sSort";
		echo "\">" . gettext("Lihat Semua") . "</a>";
		while ($aLetter = mysql_fetch_row($rsLetters))
		{
			if ($aLetter[0] == $sLetter) {
				echo "&nbsp;&nbsp;|&nbsp;&nbsp;" . $aLetter[0];
			} else {
				echo "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"SelectList.php?mode=$sMode&type=$iGroupTypeMissing&Filter=$sFilter&Gender=$iGender&grouptype=$iGroupType&groupid=$iGroupID";
				if($sSort) echo "&Sort=$sSort";
				echo "&Letter=" . $aLetter[0] . "\">" . $aLetter[0] . "</a>";
			}
		}
		echo "</div><BR>";

		// Create Next / Prev Links and $Result_Set Value
		if ($Total > 0)
		{
			echo "<div align=\"center\">";
			echo "<form method=\"get\" action=\"SelectList.php\" name=\"ListNumber\">";

			// Show previous-page link unless we're at the first page
			if ($Result_Set < $Total && $Result_Set > 0)
			{
				$thisLinkResult = $Result_Set - $iPerPage;
				echo "<a href=\"SelectList.php?Result_Set=$thisLinkResult&mode=$sMode&type=$iGroupTypeMissing&Filter=$sFilter&Sort=$sSort&Letter=$sLetter&Gender=$iGender&grouptype=$iGroupType&groupid=$iGroupID\">". gettext("Halaman Sebelumnya") . "</A>&nbsp;&nbsp;";
			}

			// Calculate and Display Page-Number Links
			$Pages = $Total / $iPerPage;
			if ($Pages > 1)
			{
				for ($b = 0; $b < $Pages; $b++)
				{
					$c = $b + 1;
					$thisLinkResult = $iPerPage * $b;
					if ($thisLinkResult != $Result_Set)
						echo "&nbsp;&nbsp;<a href=\"SelectList.php?Result_Set=$thisLinkResult&mode=$sMode&type=$iGroupTypeMissing&Filter=$sFilter&Sort=$sSort&Letter=$sLetter&Gender=$iGender&grouptype=$iGroupType&groupid=$iGroupID\">$c</a>&nbsp;&nbsp;\n";
					else
						echo "&nbsp;&nbsp;[ " . $c . " ]&nbsp;&nbsp;";
				}
			}

			// Show next-page link unless we're at the last page
			if ($Result_Set >= 0 && $Result_Set < $Total)
			{
				$thisLinkResult=$Result_Set+$iPerPage;
				if ($thisLinkResult<$Total)
					echo "&nbsp;&nbsp;<a href=\"SelectList.php?Result_Set=$thisLinkResult&mode=$sMode&type=$iGroupTypeMissing&Filter=$sFilter&Sort=$sSort&Letter=$sLetter&Gender=$iGender&grouptype=$iGroupType&groupid=$iGroupID\">" . gettext("Halaman Berikut") . "</a>";
			}

			echo "<input type=\"hidden\" name=\"mode\" value=\"" . $sMode . "\">";
			if($iGroupTypeMissing > 0)
				echo "<input type=\"hidden\" name=\"type\" value=\"" . $iGroupTypeMissing . "\">";
			if(isset($sFilter))
				echo "<input type=\"hidden\" name=\"Filter\" value=\"" . $sFilter . "\">";
			if(isset($sSort))
				echo "<input type=\"hidden\" name=\"Sort\" value=\"" . $sSort . "\">";
			if(isset($sLetter))
				echo "<input type=\"hidden\" name=\"Letter\" value='" . $sLetter . "'\">";
			if(isset($iGender))
				echo "<input type=\"hidden\" name=\"Gender\" value='". $iGender ."'\">";
			if(isset($iGroupType))
				echo "<input type=\"hidden\" name=\"grouptype\" value='". $iGroupType ."'\">";
			if(isset($iGroupID))
				echo "<input type=\"hidden\" name=\"groupid\" value='". $iGroupID ."'\">";
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo gettext("Tampilkan sebanyak:"); ?>&nbsp;
			<select class="SmallText" name="Number">
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="25">25</option>
				<option value="50">50</option>
			</select>&nbsp;
			<input type="submit" class="icTinyButton" value="<?php echo gettext("Go"); ?>">
			</form>
			</div>
			<BR>
		<?php } ?>

		<table cellpadding="4" align="center" cellspacing="0" width="100%">
			<tr class="TableHeader">
				<td width="25"><?php echo gettext("Ubah"); ?></td>
				<td><a href="SelectList.php?mode=<?php echo $sMode; ?>&type=<?php echo $iGroupTypeMissing;?>&Sort=name&Filter=<?php echo $sFilter ?>"><?php echo gettext("Nama"); ?></a></td>
				<td><?php echo gettext("Jenis Kelamin"); ?></td>
				<td><a href="SelectList.php?mode=<?php echo $sMode; ?>&type=<?php echo $iGroupTypeMissing;?>&Sort=family&Filter=<?php echo $sFilter ?>"><?php echo gettext("Keluarga"); ?></a></td>
				<td><?php echo gettext("Kode Pos"); ?></td>
				<td><?php echo gettext("Kotak"); ?></td>
				<?php if ($iMode == 1) { ?>
					<td><?php echo gettext("Kartu Nama Virtual"); ?></td>
					<td><?php echo gettext("Halaman Cetak"); ?></td>
				<?php } else { ?>
					<td><?php echo gettext("Assign"); ?></td>
				<?php } ?>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>

		<?php

		$sRowClass = "RowColorA";

		$iPrevFamily = -1;

		//Loop through the person recordset
		while ($aRow = mysql_fetch_array($rsPersons))
		{
			$per_Title = "";
			$per_FirstName = "";
			$per_MiddleName = "";
			$per_LastName = "";
			$per_Suffix = "";
			$per_Gender = "";

			$fam_Name = "";
			$fam_Address1 = "";
			$fam_Address2 = "";
			$fam_City = "";
			$fam_State = "";

			extract($aRow);

			// Add alphabetical headers based on sort
			switch($sSort)
			{
				case "family":
					if ($fam_ID != $iPrevFamily || $iPrevFamily == -1)
					{
						echo $sBlankLine;
						$sBlankLine = "<tr><td>&nbsp;</td></tr>";
						echo "<tr><td></td><td class=\"ControlBreak\">";
						if (strlen($fam_Name) > 0) { echo $fam_Name; } else {echo "Unassigned"; }
						echo "</td></tr>";
						$sRowClass = "RowColorA";
					}
					break;

				case "name":

					if (substr($per_LastName,0,1) != $sPrevLetter)
					{
						echo $sBlankLine;
						echo "<tr>";
						echo "<td></td><td class=\"ControlBreak\">" . strtoupper(substr($per_LastName,0,1)) . "</td></tr>";
						$sBlankLine = "<tr><td>&nbsp</td></tr>";
						$sRowClass = "RowColorA";
					}
					break;

				default:
					break;
			}

			//Alternate the row color
			$sRowClass = AlternateRowStyle($sRowClass);

			//Display the row
			?>

			<tr class="<?php echo $sRowClass; ?>">
				<td><a href="PersonEditor.php?PersonID=<?php echo $per_ID ?>">Ubah</a></td>
				<td><a href="PersonView.php?PersonID=<?php echo $per_ID ?>"><?php echo FormatFullName($per_Title, $per_FirstName, $per_MiddleName, $per_LastName, $per_Suffix, 3); ?></a>&nbsp;				</td>
				<td><?php switch ($per_Gender) {case 1: echo gettext("Laki-laki"); break; case 2: echo gettext("Perempuan"); break; default: echo "";} ?>&nbsp;</td>
				<td>
					<?php
					if ($fam_Name != "") {
						echo "<a href=\"FamilyView.php?FamilyID=" . $fam_ID . "\">" . $fam_Name;
						echo FormatAddressLine($fam_Address1, $fam_City, $fam_State) . "</a>";
					}
					?>&nbsp;
				</td>
				<td><?php if (strlen($zip)) echo $zip; else echo gettext("Kosong"); ?></td>
				<td><a onclick="return AddToCart(<?php echo $per_ID ?>);" href="blank.html"><?php echo gettext("Tambah ke Kotak"); ?></a></td>
				<?php if ($iMode == 1) { ?>
					<td><a href="VCardCreate.php?PersonID=<?php echo $per_ID ?>"><?php echo gettext("Buat"); ?></a></td>
					<td><a href="PrintView.php?PersonID=<?php echo $per_ID ?>"><?php echo gettext("Halaman Cetak"); ?></a></td>
				<?php } else { ?>
					<td><a href="PersonToGroup.php?PersonID=<?php echo $per_ID ?>&prevquery=<?php echo rawurlencode($_SERVER["QUERY_STRING"]);?>"><?php echo gettext("Add to Group"); ?></a></td>
				<?php } ?>
			</tr>

			<?php
			//Store the family to enable the control break
			$iPrevFamily = $fam_ID;

			//If there was no family, set it to 0
			if (strlen($iPrevFamily) < 1)
				$iPrevFamily = 0;

			//Store the first letter of this record to enable the control break
			$sPrevLetter = substr($per_LastName,0,1);
		}

		//Close the table
		echo "</table>\n";

		require "Include/Footer.php";
		exit;

	} else { ?>

		<table cellpadding="2" align="center" cellspacing="0" width="100%">

			<tr class="TableHeader">
				<td><?php echo gettext("Nama"); ?></td>
				<td><?php echo gettext("Alamat I"); ?><br><?php echo gettext("Kota, Kode Pos"); ?></td>
				<td><?php echo gettext("Telepon Rumah") . " /"; ?>
				<br><?php echo gettext("Telepon Kantor") . " /"; ?>
				<br><?php echo gettext("Telepon Genggam"); ?></td>
				<td><?php echo gettext("Email Utama") . " /"; ?>
				<br><?php echo gettext("Email Kantor/Lainnya"); ?></td>
				<td><?php echo gettext("Tanggal diisi"); ?></td>
			</tr>
		<?php

		$sRowClass = "RowColorA";

		$iPrevFamily = -1;

		$finalSQL = $sSQL . $sOrderSQL;
		$rsPersons = RunQuery($finalSQL);

		//Loop through the person recordset
		while ($aRow = mysql_fetch_array($rsPersons))
		{
			$per_Title = "";
			$per_FirstName = "";
			$per_MiddleName = "";
			$per_LastName = "";
			$per_Suffix = "";
			$per_Address1 = "";
			$per_Address2 = "";
			$per_City = "";
			$per_State = "";
			$per_Zip = "";
			$per_Country = "";
			$per_HomePhone = "";
			$per_WorkPhone = "";
			$per_CellPhone = "";
			$per_Email = "";
			$per_WorkEmail = "";
			$per_DateEntered = "";
			$fam_Name = "";
			$fam_Address1 = "";
			$fam_Address2 = "";
			$fam_City = "";
			$fam_State = "";
			$fam_Zip = "";
			$fam_Country = "";
			$fam_HomePhone = "";
			$fam_CellPhone = "";
			$fam_Email = "";

			extract($aRow);

			//Alternate the row color
			$sRowClass = AlternateRowStyle($sRowClass);

			// Assign the values locally, after selecting whether to display the family or person information
			SelectWhichAddress($sAddress1, $sAddress2, $per_Address1, $per_Address2, $fam_Address1, $fam_Address2, False);
			$sCity = SelectWhichInfo($per_City, $fam_City, False);
			$sState = SelectWhichInfo($per_State, $fam_State, False);
			$sZip = SelectWhichInfo($per_Zip, $fam_Zip, False);
			$sCountry = SelectWhichInfo($per_Country, $fam_Country, False);
			$sHomePhone = SelectWhichInfo(ExpandPhoneNumber($per_HomePhone,$sCountry,$dummy), ExpandPhoneNumber($fam_HomePhone,$fam_Country,$dummy), False);
			$sWorkPhone = SelectWhichInfo(ExpandPhoneNumber($per_WorkPhone,$sCountry,$dummy), ExpandPhoneNumber($fam_WorkPhone,$fam_Country,$dummy), False);
			$sCellPhone = SelectWhichInfo(ExpandPhoneNumber($per_CellPhone,$sCountry,$dummy), ExpandPhoneNumber($fam_CellPhone,$fam_Country,$dummy), False);
			$sUnformattedEmail = SelectWhichInfo($per_Email, $fam_Email, False);

			//Display the row
			?>

			<tr class="<?php echo $sRowClass; ?>">
				<td><?php echo FormatFullName($per_Title, $per_FirstName, $per_MiddleName, $per_LastName, $per_Suffix, 0); ?>&nbsp;</td>
				<td><?php echo $sAddress1;?>&nbsp;<?php if ($sAddress1 != "" && $sAddress2 != "") { echo ", "; } ?><?php if ($sAddress2 != "") echo $sAddress2; ?>
				<?php if ($sCity || $sState || $sZip)
					echo "<br>" . $sCity . ", " . $sState . " " . $sZip; ?></td>
				<td><?php echo $sHomePhone ?>&nbsp;
				<?php if($sWorkPhone) echo "<br>" . $sWorkPhone; ?>
				<?php if($sCellPhone) echo "<br>" . $sCellPhone; ?></td>
				<td><?php echo $sUnformattedEmail ?>&nbsp;
				<br><?php echo $per_WorkEmail ?></td>
				<td><?php echo $per_DateEntered ?>&nbsp;</td>
			</tr>

			<?php

			//Store the family to enable the control break
			$iPrevFamily = $fam_ID;

			//If there was no family, set it to 0
			if (strlen($iPrevFamily) < 1)
			{

				$iPrevFamily = 0;

			}

			//Store the first letter of this record to enable the control break
			$sPrevLetter = substr($per_LastName,0,1);

		}
		//Close the table
		echo "</table>\n";
		require "Include/Footer-Short.php";
	}
}
/**********************
**  Family Listing  **
**********************/
else
{
	// Base SQL
	$sSQL = "SELECT * FROM family_fam ";

	if (isset($sLetter))
		$sSQL .= " WHERE fam_Name LIKE '" . $sLetter . "%' ";
		//$sSQL .= " WHERE fam_Name LIKE per_cls_ID=1 ";
	elseif (isset($sFilter))
	{
		// break on the space...
		// $aFilter = explode(" ",$sFilter);
		//$sSQL .= " WHERE fam_Name LIKE '%" . $aFilter[0] . "%'";

		$sSQL .= " WHERE fam_Name LIKE '%" . $sFilter . "%'";
	}

	//Apply the sort based on what was passed in
	switch($sSort)
	{
		case "entered":
			$sSQL = $sSQL . " ORDER BY fam_DateEntered DESC";
			break;

		default:
			$sSQL = $sSQL . " ORDER BY fam_Name";
			break;
	}

	$rsFamCount = RunQuery($sSQL);
	$Total = mysql_num_rows($rsFamCount);

	// Append a LIMIT clause to the SQL statement
	if (empty($_GET['Result_Set']))
	{
		$Result_Set = 0;
		$sSQL .= " LIMIT $Result_Set, $iPerPage";

	}
	else
	{
		$Result_Set = FilterInput($_GET['Result_Set'],'int');
		$sSQL .= " LIMIT $Result_Set, $iPerPage";
	}

	// Run The Query With a Limit to get result
	$rsFamilies = RunQuery($sSQL);

	// Run query to get first letters of name.
	$sSQL = "SELECT DISTINCT LEFT(fam_Name,1) AS letter FROM family_fam ORDER BY letter";
	$rsLetters = RunQuery($sSQL);

	//Does this user have AddModify permissions?
	if ($_SESSION['bAddRecords']) { echo "<div align=\"center\"><a href=\"FamilyEditor.php\">" . gettext("Tambah Keluarga Baru") . "</a></div><BR>"; }
	?>
	<form method="get" action="SelectList.php" name="FamilyList">
		<p align="center">
		<?php echo gettext("Diurutkan berdasarkan:"); ?>
		<select name="Sort">
			<option value="name"><?php echo gettext("Nama"); ?></option>
			<option value="entered"><?php echo gettext("yang diisi terakhir kali"); ?></option>
		</select>&nbsp;
		<input type="text" name="Filter">
		<input type="hidden" name="mode" value="family">
		<input type="submit" class="icButton" value="<?php echo gettext("Jalankan Penyaringan"); ?>">
		</p>
	</form>
	<?php
	// Create Sort Links
	echo "<div align=\"center\">";
	echo "<a href=\"SelectList.php?mode=family\">" . gettext("Lihat Semua") . "</a>";
	while ($aLetter = mysql_fetch_array($rsLetters))
	{
		echo "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"SelectList.php?mode=family";
		if($sSort) echo "&Sort=$sSort";
		echo "&Letter=" . $aLetter[0] . "\">" . $aLetter[0] . "</a>";
	}

	echo "</div>";
	echo "<BR>";

	// Create Next / Prev Links and $Result_Set Value
	if ($Total > 0)
	{
		echo "<div align=\"center\">";
		echo "<form method=\"get\" action=\"SelectList.php\" name=\"ListNumber\">";

		// Show previous-page link unless we're at the first page
		if ($Result_Set < $Total && $Result_Set > 0)
		{
			$thisLinkResult = $Result_Set - $iPerPage;
			echo "<A HREF=\"SelectList.php?Result_Set=$thisLinkResult&mode=family&Filter=$sFilter&Sort=$sSort&Letter=$sLetter\">Halaman Sebelumnya</A>&nbsp;&nbsp;";
		}

		// Calculate and Display Page # Links
		$Pages = $Total / $iPerPage;
		if ($Pages > 1)
		{
			for ($b = 0; $b < $Pages; $b++)
			{
				$c = $b + 1;
				$thisLinkResult = $iPerPage * $b;
				if ($thisLinkResult != $Result_Set)
					echo "&nbsp;&nbsp;<a href=\"SelectList.php?Result_Set=$thisLinkResult&mode=family&Filter=$sFilter&Sort=$sSort&Letter=$sLetter\">$c</a>&nbsp;&nbsp;\n";
				else
					echo "&nbsp;&nbsp;[ " . $c . " ]&nbsp;&nbsp;";
			}
		}

		// Show next-page link unless we're at the last page
		if ($Result_Set >= 0 && $Result_Set < $Total)
		{
			$thisLinkResult=$Result_Set+$iPerPage;
			if ($thisLinkResult<$Total)
				echo "&nbsp;&nbsp;<a href=\"SelectList.php?Result_Set=$thisLinkResult&mode=family&Filter=$sFilter&Sort=$sSort&Letter=$sLetter\">" . gettext("Halaman Berikut") . "</a>";
		}
		?>

		<input type="hidden" name="mode" value="family">
		<?php
		if(isset($sFilter))
			echo "<input type=\"hidden\" name=\"Filter\" value=\"" . $sFilter . "\">";
		if(isset($sSort))
			echo "<input type=\"hidden\" name=\"Sort\" value=\"" . $sSort . "\">";
		if(isset($sLetter))
			echo "<input type=\"hidden\" name=\"Letter\" value='" . $sLetter . "'\">";
		?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo gettext("Tampilkan sebanyak:"); ?>&nbsp;
		<select class="SmallText" name="Number">
		<option value="5">5</option>
		<option value="10">10</option>
		<option value="20">20</option>
		<option value="25">25</option>
		<option value="50">50</option>
		</select>&nbsp;
		<input type="submit" class="icTinyButton" value="<?php echo gettext("Go"); ?>">
		</form>

		</div>
	<?php } ?>
	<BR>

	<table cellpadding="4" align="center" cellspacing="0" width="100%">

	<tr class="TableHeader">
		<td><?php echo gettext("Nama Keluarga"); ?></td>
		<?php if ($bFamListFirstNames) echo "<td>" . gettext("Nama Depan") . "</td>"; ?>
		<td><?php echo gettext("Alamat"); ?></td>
		<td><?php echo gettext("Kota"); ?></td>
		<td><?php echo gettext("Provinsi"); ?></td>
		<td><?php echo gettext("Terakhir Dirubah"); ?></td>
	</tr>

	<tr>
		<td>&nbsp;</td>
	</tr>

	<?php
	//Loop through the family recordset
	while ($aRow = mysql_fetch_array($rsFamilies))
	{
		// Unfortunately, extract()'s behavior with NULL array entries is inconsistent across different PHP versions
		// To be safe, we need to manually clear these variables.
		$fam_Name = "";
		$fam_Address1 = "";
		$fam_Address2 = "";
		$fam_City = "";
		$fam_State = "";
		$fam_DateLastEdited = "";
        extract($aRow);
        echo $sRow[per_ID];
		if ($bFamListFirstNames)
		{
			// build string of member first names
			$sFirstNames = "";
			$sSQL = "SELECT per_FirstName FROM person_per
				LEFT JOIN list_lst fmr ON per_fmr_ID = fmr.lst_OptionID AND fmr.lst_ID = 2
				WHERE per_fam_ID = " . $fam_ID . " ORDER BY fmr.lst_OptionSequence";
			$rsFirstNames = RunQuery($sSQL);

			$bFirstItem = true;
			while ($aTemp = mysql_fetch_array($rsFirstNames))
			{
				if ($bFirstItem) {
					$sFirstNames .= $aTemp["per_FirstName"];
					$bFirstItem = false;
				}
				else
					$sFirstNames .= ", " . $aTemp["per_FirstName"];
			}
		}

		//Does this family name start with a new letter?
		if (strtoupper(substr($fam_Name,0,1)) != $sPrevLetter)
		{
			//Display the header
			echo $sBlankLine;
			echo "<tr><td class=\"ControlBreak\" colspan=\"4\"><b>" . strtoupper(substr($fam_Name,0,1)) . "</b></td></tr>";
			$sBlankLine = "<tr><td>&nbsp;</td></tr>";
			$sRowClass = "RowColorA";
		}

		//Alternate the row style
		$sRowClass = AlternateRowStyle($sRowClass);

		//Display the row
		?>

		<tr class="<?php echo $sRowClass ?>">
			<td><a href="FamilyView.php?FamilyID=<?php echo $fam_ID ?>"><?php echo $fam_Name ?></a>&nbsp;</td>
			<?php if ($bFamListFirstNames) echo "<td>" . $sFirstNames . "</td>"; ?>
			<td><?php echo $fam_Address1;?><?php if ($fam_Address1 != "" && $fam_Address2 != "") { echo ", "; } ?><?php if ($fam_Address2 != "") echo $fam_Address2; ?>&nbsp;</td>
			<td><?php echo $fam_City ?>&nbsp;</td>
			<td><?php echo $fam_State ?>&nbsp;</td>
			<td><?php echo $fam_DateLastEdited ?>&nbsp;</td>
		</tr>
		<?php
		//Store the first letter of the family name to allow for the control break
		$sPrevLetter = strtoupper(substr($fam_Name,0,1));
	}

	//Close the table
	echo "</table>";
	require "Include/Footer.php";
	exit;
}
?>
