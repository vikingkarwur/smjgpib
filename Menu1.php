<?php
/*******************************************************************************
 *
 *  filename    : Menu.php
 *  last change : 2002-03-24
 *  description : menu that appears after login, shows login attempts
 *
 *  http://www.infocentral.org/
 *  Copyright 2001-2002 Phillip Hullquist, Deane Barker
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

// Set the page title
$sPageTitle = gettext("smjGPIB - sistem manajemen jemaat GPIB");

require "Include/Header.php";

//Set the page title
$sSQL = "Select * from infojemaat";
$sinfojemaat = mysql_fetch_array(RunQuery($sSQL));
extract($sinfojemaat);
$sPageTitle = gettext("Statistik Jemaat $NamaJemaat - $NamaMupel");

$sSQL = "SELECT per_ID FROM person_per WHERE per_Gender<>''";
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

$sSQL = "SELECT per_ID FROM person_per WHERE per_Gender=2";
$sTotalFemaleAll = RunQuery($sSQL);
$TotalFemaleAll = mysql_num_rows($sTotalFemaleAll);

$sSQL = "SELECT per_ID FROM person_per where per_Gender = 2 AND per_cls_ID=1";
$sTotalFemale = RunQuery($sSQL);
$TotalFemale = mysql_num_rows($sTotalFemale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) >= CURDATE()";
$sPA = RunQuery($sSQL);
$PA = mysql_num_rows($sPA);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) >= CURDATE() AND per_Gender = 1";
$sPAMale = RunQuery($sSQL);
$PAMale = mysql_num_rows($sPAMale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 0 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 12 YEAR) >= CURDATE() AND per_Gender = 2";
$sPAFemale = RunQuery($sSQL);
$PAFemale = mysql_num_rows($sPAFemale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) >= CURDATE()";
$sPT = RunQuery($sSQL);
$PT = mysql_num_rows($sPT);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) >= CURDATE() AND per_Gender = 1";
$sPTMale = RunQuery($sSQL);
$PTMale = mysql_num_rows($sPTMale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 13 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 17 YEAR) >= CURDATE() AND per_Gender = 2";
$sPTFemale = RunQuery($sSQL);
$PTFemale = mysql_num_rows($sPTFemale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) >= CURDATE()";
$sGP = RunQuery($sSQL);
$GP = mysql_num_rows($sGP);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) >= CURDATE() AND per_Gender = 1";
$sGPMale = RunQuery($sSQL);
$GPMale = mysql_num_rows($sGPMale);

$sSQL = "SELECT per_ID, per_BirthDay, per_BirthMonth, per_BirthYear from person_per where DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 18 YEAR) <= CURDATE() AND DATE_ADD(CONCAT(per_BirthYear,'-',per_BirthMonth,'-',per_BirthDay),INTERVAL 35 YEAR) >= CURDATE() AND per_Gender = 2";
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

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where c19 LIKE '%pendeta%'";
$sPendeta = RunQuery($sSQL);
$Pendeta = mysql_num_rows($sPendeta);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where c19 LIKE '%penatua%'";
$sPenatua = RunQuery($sSQL);
$Penatua = mysql_num_rows($sPenatua);

$sSQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where c19 LIKE '%diaken%'";
$sDiaken = RunQuery($sSQL);
$Diaken = mysql_num_rows($sDiaken);

?>

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

PKB: <?php echo gettext($PKB); ?> Orang<br>
PW: <?php echo gettext($PW); ?> Orang<br>
GP: <?php echo gettext($GP); ?> (P: <?php echo gettext($GPMale); ?> / W: <?php echo gettext($GPFemale); ?> )<br>
PT: <?php echo gettext($PT); ?> (P: <?php echo gettext($PTMale); ?> / W: <?php echo gettext($PTFemale); ?> )<br>
PA: <?php echo gettext($PA); ?> (P: <?php echo gettext($PAMale); ?> / W: <?php echo gettext($PAFemale); ?> )<br>
<br> 
Pendeta: <?php echo gettext($Pendeta); ?> Orang<br>
Penatua: <?php echo gettext($Penatua); ?> Orang<br>
Diaken: <?php echo gettext($Diaken); ?> Orang<br></p>

    <div align="center">
      <h3><a href="Statistik.php"><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Statistik Lengkap...</font>.</a></strong><br>
        <br>
      </h3>
    </div>
  </div>
<div id="content-logo"></div>
<div id="column1">
<h3><?php echo $sPageTitle; ?></h3>
<p><?php echo gettext("Syalom :") . " " . $_SESSION['UserFirstName'] . " " . gettext("selamat datang"); ?>!</p>
<h4>Login Information</h4>
<p><?php
if ($_SESSION['iLoginCount'] == 0) {
	echo gettext("This is your first login.");
} else {
	echo gettext("You last logged in on ") . strftime("%A, %B %e, %Y",$_SESSION['dLastLogin']) . ' ' . gettext("at") . ' ' . strftime("%r",$_SESSION['dLastLogin']) . ".";
}
?></p>
<p><?php echo gettext("There were"); ?> <strong><?php echo $_SESSION['iFailedLogins']; ?></strong> <?php echo gettext("failed login attempt(s) since your last successful login."); ?></p>
</div>
<div id="bottom-foot"></div>
</div>

<?php
require "Include/Footer.php";
?>
