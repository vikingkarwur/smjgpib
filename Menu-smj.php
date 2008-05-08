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

require "Include/Header-smj.php";

?>

<div id="wrapper">
<div id="column2">
<h3>Current User</h3>
<p><?php echo $_SESSION['UserFirstName'] . " " . $_SESSION['UserLastName']; ?></p>
<h3>Versi smjGPIB</h3>
<p><?php echo gettext("$sVersi");?></p>
<h3>Jemaat</h3>
<p><?php echo gettext("$sNamaJemaat");?><br>
  MUPEL <?php echo gettext("$sNamaMUPEL");?></p>
<h3>Statistik Jemaat</h3>
<p>
Warga Senior:<br>
PKB:<br>
PW:<br>
GP:<br>
PT:<br>
PA:<br>
<br> 
Pendeta:<br>
Penatua:<br>
Diaken:</p>
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
require "Include/Footer-smj.php";
?>
