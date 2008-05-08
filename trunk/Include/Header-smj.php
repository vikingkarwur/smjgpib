<?php
/*******************************************************************************
 *
 *  filename    : Include/Header.php
 *  last change : 2003-07-08
 *  description : page header used for most pages
 *
 *  http://www.infocentral.org/
 *  Copyright 2001-2003 Phillip Hullquist, Deane Barker, Chris Gebhardt
 *  http://smj.gpib.org/
 *  Copyright 2004 Litbang GPIB
 *
 *  smjGPIB is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 ******************************************************************************/

// Turn ON output buffering
ob_start();

// Top level menu index counter
$MenuFirst = 1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta http-equiv="pragma" content="no-cache">
	<title>smjGPIB: <?php echo $sPageTitle; ?></title>
	<style type="text/css" media="screen, tv, projection"> 
	@import "Include/Style.css"; 
</style>

	<script type="text/javascript" src="Include/jscalendar/calendar.js"></script>
	<script type="text/javascript" src="Include/jscalendar/lang/calendar-<?php echo substr($sLanguage,0,2); ?>.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="Include/jscalendar/calendar-blue.css" title="cal-style" />

	<script language="javascript" type="text/javascript">

		// Popup Calendar stuff
		function selected(cal, date)
		{
			cal.sel.value = date; // update the date in the input field.
			if (cal.dateClicked)
				cal.callCloseHandler();
		}

		function closeHandler(cal)
		{
			cal.hide(); // hide the calendar
		}

		function showCalendar(id, format)
		{
			var el = document.getElementById(id);
			if (calendar != null)
			{
				calendar.hide();
			}
			else
			{
				var cal = new Calendar(false, null, selected, closeHandler);
				cal.weekNumbers = false;
				calendar = cal;                  // remember it in the global var
				cal.setRange(1900, 2070);        // min/max year allowed.
				cal.create();
			}
			calendar.setDateFormat(format);    // set the specified date format
			calendar.parseDate(el.value);      // try to parse the text in field
			calendar.sel = el;                 // inform it what input field we use
			calendar.showAtElement(el);        // show the calendar below it
			return false;
		}

		var MINUTE = 60 * 1000;
		var HOUR = 60 * MINUTE;
		var DAY = 24 * HOUR;
		var WEEK = 7 * DAY;

		function isDisabled(date)
		{
			var today = new Date();
			return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
		}

		// Clear a field on the first focus
		var priorSelect = new Array();
		function ClearFieldOnce(sField) {
			if (priorSelect[sField.id]) {
				sField.select();
			} else {
				sField.value = "";
				priorSelect[sField.id] = true;
			}
		}

		function LimitTextSize(theTextArea,size) {
			if (theTextArea.value.length > size) {
				theTextArea.value = theTextArea.value.substr(0,size);
			}
		}

	</script>

</head>
<body>
<div id="menu">
<ul id="menuList">
<li><a href="#" class="submenu">Main</a>
<ul id="mainMenu">
<li><a href="Menu.php">Frontpage</a></li>
<li><a href="#">Detail Statistik</a></li>
<li><a href="#">Change Password</a></li>
</ul>

</li>
<li><a class="submenu" href="#">Admin</a>
	<ul id="MyAccountMenu">
		<li id="itemBasket"><a href="#">Edit Users</a></li>
		<li><a href="#">Add New User</a></li>
		<li id="itemHistory"><a href="#">Edit Custom Person Fields</a></li>
		<li><a href="#">Backup Database</a></li>
		<li><a href="#">CSV Import</a></li>
	</ul>
</li>

<li><a class="submenu" href="#">Person/Family</a>
	<ul id="MyAccountMenu">
		<li id="itemBasket"><a href="#">Add New Person</a></li>
		<li><a href="#">View All Person</a></li>
		<li id="itemHistory"><a href="#">Classification Manager</a></li>
		<li><a href="#">Add New Family</a></li>
		<li><a href="#">View All Family</a></li>
		<li><a href="#">Family Roles Manager</a></li>
	</ul>
</li>

<li><a class="submenu" href="#">View</a>
	<ul id="MyAccountMenu">
		<li id="itemBasket"><a href="#">Pelayanan Anak</a></li>
		<li><a href="#">Persekutuan Teruna</a></li>
		<li id="itemHistory"><a href="#">Gerakan Pemuda</a></li>
		<li><a href="#">Pelayanan Wanita</a></li>
		<li><a href="#">Persekutuan Kaum Bapak</a></li>
		<li><a href="#">Warga Senior</a></li>
	</ul>
</li>

<li><a class="submenu" href="#">Cart</a>
	<ul id="SupportMenu">
		<li><a href="#">List Cart Items</a></li>
		<li id="itemHelp"><a href="#">Empty Cart</a></li>
		<li><a href="#">Empty Cart to Group</a></li>
		<li><a href="#">Empty Cart to Family</a></li>
	</ul>
</li>

<li><a class="submenu" href="#">Data/Reports</a>
	<ul id="SupportMenu">
		<li><a href="#">CSV Export Records</a></li>
		<li><a href="#">Query Menu</a></li>
		<li><a href="#">Reports Menu</a></li>
	</ul>
</li>

<li><a class="submenu" href="#">Groups</a>
	<ul id="SupportMenu">
		<li><a href="#">CSV Export Records</a></li>
		<li><a href="#">Query Menu</a></li>
		<li><a href="#">Reports Menu</a></li>
	</ul>
</li>

<li><a class="submenu" href="#">Properties</a>
	<ul id="SupportMenu">
		<li><a href="#">CSV Export Records</a></li>
		<li><a href="#">Query Menu</a></li>
		<li><a href="#">Reports Menu</a></li>
	</ul>
</li>

<li><a class="submenu" href="#">Help</a>
	<ul id="SupportMenu">
		<li><a href="#">CSV Export Records</a></li>
		<li><a href="#">Query Menu</a></li>
		<li><a href="#">Reports Menu</a></li>
	</ul>
</li>

<li><a href="#" class="disabled">Logout</a></li>
</ul>
</div>
<div id="breadcrumbs"></div>

