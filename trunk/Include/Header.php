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
	<link rel="stylesheet" type="text/css" href="Include/<?php echo $_SESSION['sStyle']; ?>">
	<link rel="stylesheet" type="text/css" href="css/menu.css">

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

<script type="text/javascript">//<![CDATA[
startList = function() {
	if (document.all && document.getElementById) {
		navRoot = document.getElementById("navigation");
		for (i=0; i<navRoot.childNodes.length; i++) {
			node = navRoot.childNodes[i];
			if (node.nodeName=="LI") {
				node.onmouseover=function() {
					this.className+=" over";
				}
				node.onmouseout=function() {
					this.className=this.className.replace(" over", "");
				}
			}
		}
	}
}
</script>
</head>
<script language="JavaScript">
function mmLoadMenus() {
  if (window.mm_menu_1010224632_1) return;
  window.mm_menu_1010224632_1 = new Menu("root",93,16,"Verdana, Arial, Helvetica, sans-serif",10,"#000000","#ffffff","#B3E7FF","#66CCFF","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_1010224632_1.addMenuItem("Tentang&nbsp;smjGPIB","location='Help.php?page=About'");
  mm_menu_1010224632_1.addMenuItem("Individu","location='Help.php?page=People'");
  mm_menu_1010224632_1.addMenuItem("Keluarga","location='Help.php?page=Family'");
  mm_menu_1010224632_1.addMenuItem("Grup","location='Help.php?page=Groups'");
  mm_menu_1010224632_1.addMenuItem("Laporan","location='Help.php?page=Reports'");
  mm_menu_1010224632_1.addMenuItem("Admin","location='Help.php?page=Admin'");
  mm_menu_1010224632_1.addMenuItem("Kotak","location='Help.php?page=Cart'");
  mm_menu_1010224632_1.addMenuItem("Properties","location='Help.php?page=Properties'");
  mm_menu_1010224632_1.addMenuItem("Notes","location='Help.php?page=Notes'");
  mm_menu_1010224632_1.addMenuItem("Custom","location='Help.php?page=Custom'");
  mm_menu_1010224632_1.addMenuItem("Class","location='Help.php?page=Class'");
   mm_menu_1010224632_1.hideOnMouseOut=true;
   mm_menu_1010224632_1.menuBorder=1;
   mm_menu_1010224632_1.menuLiteBgColor='#ffffff';
   mm_menu_1010224632_1.menuBorderBgColor='#555555';
   mm_menu_1010224632_1.bgColor='#555555';
  window.mm_menu_1010224437_2 = new Menu("root",108,16,"Verdana, Arial, Helvetica, sans-serif",10,"#000000","#ffffff","#B3E7FF","#66CCFF","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_1010224437_2.addMenuItem("People&nbsp;Properties","location='PropertyList.php?Type=p'");
  mm_menu_1010224437_2.addMenuItem("Family&nbsp;Properties","location='PropertyList.php?Type=f'");
  mm_menu_1010224437_2.addMenuItem("Group&nbsp;Properties","location='PropertyList.php?Type=g'");
  mm_menu_1010224437_2.addMenuItem("Property&nbsp;Types","location='PropertyTypeList.php'");
   mm_menu_1010224437_2.hideOnMouseOut=true;
   mm_menu_1010224437_2.menuBorder=1;
   mm_menu_1010224437_2.menuLiteBgColor='#ffffff';
   mm_menu_1010224437_2.menuBorderBgColor='#555555';
   mm_menu_1010224437_2.bgColor='#555555';
  window.mm_menu_1010224227_3 = new Menu("root",152,16,"Verdana, Arial, Helvetica, sans-serif",10,"#000000","#ffffff","#B3E7FF","#66CCFF","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_1010224227_3.addMenuItem("Daftar&nbsp;Grup","location='GroupList.php'");
  <?php if ($_SESSION['bManageGroups']) {?>
  mm_menu_1010224227_3.addMenuItem("Tambah&nbsp;Gruo&nbsp;Baru","location='GroupEditor.php'");
  <?php } ?>
  <?php if ($_SESSION['bMenuOptions']) { ?>
  mm_menu_1010224227_3.addMenuItem("Edit&nbsp;Group&nbsp;Types","location='OptionManager.php?mode=grptypes'");
  <?php } ?>
  mm_menu_1010224227_3.addMenuItem("Group&nbsp;Assignment&nbsp;Helper","location='SelectList.php?mode=groupassign'");
   mm_menu_1010224227_3.hideOnMouseOut=true;
   mm_menu_1010224227_3.menuBorder=1;
   mm_menu_1010224227_3.menuLiteBgColor='#ffffff';
   mm_menu_1010224227_3.menuBorderBgColor='#555555';
   mm_menu_1010224227_3.bgColor='#555555';
  window.mm_menu_1010224040_4 = new Menu("root",119,16,"Verdana, Arial, Helvetica, sans-serif",10,"#000000","#ffffff","#B3E7FF","#66CCFF","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  <?php if ($_SESSION['bAdmin'] || !$bCSVAdminOnly) {?>
  mm_menu_1010224040_4.addMenuItem("Kartu&nbsp;Keluarga","location='FamilyReports.php'");
  mm_menu_1010224040_4.addMenuItem("KRT","location='KRT.php'");
  mm_menu_1010224040_4.addMenuItem("CSV&nbsp;Export&nbsp;Records","location='CSVExport.php'");
  <?php } ?>
  mm_menu_1010224040_4.addMenuItem("Query&nbsp;Menu","location='QueryList.php'");
  mm_menu_1010224040_4.addMenuItem("Reports&nbsp;Menu","location='ReportList.php'");
   mm_menu_1010224040_4.hideOnMouseOut=true;
   mm_menu_1010224040_4.menuBorder=1;
   mm_menu_1010224040_4.menuLiteBgColor='#ffffff';
   mm_menu_1010224040_4.menuBorderBgColor='#555555';
   mm_menu_1010224040_4.bgColor='#555555';
  window.mm_menu_1010223807_5 = new Menu("root",179,16,"Verdana, Arial, Helvetica, sans-serif",10,"#000000","#ffffff","#B3E7FF","#66CCFF","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_1010223807_5.addMenuItem("Daftar&nbsp;Materi&nbsp;di&nbsp;Kotak","location='CartView.php'");
  mm_menu_1010223807_5.addMenuItem("Kosongkan&nbsp;Kotak","location='CartView.php?Action=EmptyCart'");
  mm_menu_1010223807_5.addMenuItem("Isi&nbsp;Materi&nbsp;di&nbsp;Kotak&nbsp;ke&nbsp;Grup","location='CartToGroup.php'");
  mm_menu_1010223807_5.addMenuItem("Isi&nbsp;Materi&nbsp;di&nbsp;Kotak&nbsp;ke&nbsp;Keluarga","location='CartToFamily.php'");
   mm_menu_1010223807_5.hideOnMouseOut=true;
   mm_menu_1010223807_5.menuBorder=1;
   mm_menu_1010223807_5.menuLiteBgColor='#ffffff';
   mm_menu_1010223807_5.menuBorderBgColor='#555555';
   mm_menu_1010223807_5.bgColor='#555555';
  window.mm_menu_1010223211_6 = new Menu("root",109,16,"Verdana, Arial, Helvetica, sans-serif",10,"#000000","#ffffff","#B3E7FF","#66CCFF","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_1010223211_6.addMenuItem("Pendeta","location='SelectList.php?mode=PENDETA'");
  mm_menu_1010223211_6.addMenuItem("Penatua","location='SelectList.php?mode=PENATUA'");
  mm_menu_1010223211_6.addMenuItem("Diaken","location='SelectList.php?mode=DIAKEN'");
  mm_menu_1010223211_6.addMenuItem("Pelayanan&nbsp;Anak","location='SelectList.php?mode=PA'");
  mm_menu_1010223211_6.addMenuItem("Teruna","location='SelectList.php?mode=PT'");
  mm_menu_1010223211_6.addMenuItem("Gerakan&nbsp;Pemuda","location='SelectList.php?mode=GP'");
  mm_menu_1010223211_6.addMenuItem("Persatuan&nbsp;Wanita","location='SelectList.php?mode=PW'");
  mm_menu_1010223211_6.addMenuItem("Kaum&nbsp;Bapak","location='SelectList.php?mode=PKB'");
  mm_menu_1010223211_6.addMenuItem("Lansia","location='SelectList.php?mode=SENIOR'");
   mm_menu_1010223211_6.hideOnMouseOut=true;
   mm_menu_1010223211_6.menuBorder=1;
   mm_menu_1010223211_6.menuLiteBgColor='#ffffff';
   mm_menu_1010223211_6.menuBorderBgColor='#555555';
   mm_menu_1010223211_6.bgColor='#555555';
  window.mm_menu_1010222548_7 = new Menu("root",183,16,"Verdana, Arial, Helvetica, sans-serif",10,"#000000","#ffffff","#B3E7FF","#66CCFF","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  <?php if ($_SESSION['bAddRecords']) {?>
  mm_menu_1010222548_7.addMenuItem("Tambah&nbsp;Individu&nbsp;Baru","location='PersonEditor.php'");
  <?php } ?>
  mm_menu_1010222548_7.addMenuItem("Lihat&nbsp;Seluruh&nbsp;Individu","location='SelectList.php?mode=person'");
  <?php if ($_SESSION['bMenuOptions']) {?>
  mm_menu_1010222548_7.addMenuItem("Pengaturan&nbsp;Klasifikasi","location='OptionManager.php?mode=classes'");
  <?php } ?>
  <?php if ($_SESSION['bAddRecords']) {?>
  mm_menu_1010222548_7.addMenuItem("Tambah&nbsp;Keluarga&nbsp;Baru","location='FamilyEditor.php'");
  <?php } ?>
  mm_menu_1010222548_7.addMenuItem("Lihat&nbsp;Seluruh&nbsp;Keluarga","location='SelectList.php?mode=family'");
  <?php if ($_SESSION['bMenuOptions']) {?>
  mm_menu_1010222548_7.addMenuItem("Pengaturan&nbsp;Hubungan&nbsp;Keluarga","location='OptionManager.php?mode=famroles'");
   <?php } ?>
   mm_menu_1010222548_7.hideOnMouseOut=true;
   mm_menu_1010222548_7.menuBorder=1;
   mm_menu_1010222548_7.menuLiteBgColor='#ffffff';
   mm_menu_1010222548_7.menuBorderBgColor='#555555';
   mm_menu_1010222548_7.bgColor='#555555';
  window.mm_menu_1010222338_8_1 = new Menu("Admin",189,16,"Verdana, Arial, Helvetica, sans-serif",10,"#000000","#ffffff","#B3E7FF","#66CCFF","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
   <?php if ($_SESSION['bAdmin']) {?>
	mm_menu_1010222338_8_1.addMenuItem("Ubah&nbsp;User","location='UserList.php'");
    mm_menu_1010222338_8_1.addMenuItem("Tambah&nbsp;User&nbsp;Baru","location='UserEditor.php'");
    mm_menu_1010222338_8_1.addMenuItem("Ubah&nbsp;Bagian&nbsp;Tambahan&nbsp;Individu","location='PersonCustomFieldsEditor.php'");
    mm_menu_1010222338_8_1.addMenuItem("CSV&nbsp;Import","location='CSVImport.php'");
	mm_menu_1010222338_8_1.addMenuItem("Backup&nbsp;Database","location='BackupDatabase.php'");
   	<?php } else { ?>
	mm_menu_1010222338_8_1.addMenuItem("Maaf Anda Tidak Berhak","location=''");
	<?php } ?>
    mm_menu_1010222338_8_1.hideOnMouseOut=true;
     mm_menu_1010222338_8_1.menuBorder=1;
     mm_menu_1010222338_8_1.menuLiteBgColor='#ffffff';
     mm_menu_1010222338_8_1.menuBorderBgColor='#555555';
     mm_menu_1010222338_8_1.bgColor='#555555';
  window.mm_menu_1010222338_8 = new Menu("root",107,16,"Verdana, Arial, Helvetica, sans-serif",10,"#000000","#ffffff","#B3E7FF","#66CCFF","center","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_menu_1010222338_8.addMenuItem("Profil","location='Menu.php'");
  <?php if ($_SESSION['bAddRecords']) {?>
  mm_menu_1010222338_8.addMenuItem("Ganti&nbsp;Password","location='UserPasswordChange.php'");
  <?php } ?>
  mm_menu_1010222338_8.addMenuItem("Keluar","location='Default.php?Logoff=True'");
  mm_menu_1010222338_8.addMenuItem(mm_menu_1010222338_8_1);
   mm_menu_1010222338_8.hideOnMouseOut=true;
   mm_menu_1010222338_8.childMenuIcon="Include/arrows.gif";
   mm_menu_1010222338_8.menuBorder=1;
   mm_menu_1010222338_8.menuLiteBgColor='#ffffff';
   mm_menu_1010222338_8.menuBorderBgColor='#555555';
   mm_menu_1010222338_8.bgColor='#555555';

  mm_menu_1010222338_8.writeMenus();
} // mmLoadMenus()

</script>
<script language="JavaScript1.2" src="Include/mm_menu.js"></script>

<body bgcolor="#ffffff">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        	<tr>
        		<td height="3" colspan="3" bgcolor="#FFFFFF"><img src="Images/Spacer.gif" width="1" height="1"></td>
          	</tr>
          	<tr align="center">
            		<td height="11" colspan="3" bgcolor="#B7DBFF">

				<script language="JavaScript1.2">mmLoadMenus();</script>
				<img name="menu" src="Include/menu.gif" width="760" height="21" border="0" usemap="#m_menu" alt="">
				<map name="m_menu">
					<area shape="rect" coords="653,2,703,19" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.mm_menu_1010224632_1,646,23,null,'menu');"  >
					<area shape="poly" coords="558,0,642,0,642,19,558,19,558,0" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.mm_menu_1010224437_2,552,23,null,'menu');"  >
					<area shape="rect" coords="492,3,552,17" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.mm_menu_1010224227_3,473,23,null,'menu');"  >
					<area shape="rect" coords="378,1,478,18" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.mm_menu_1010224040_4,384,23,null,'menu');"  >
					<area shape="rect" coords="319,0,370,19" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.mm_menu_1010223807_5,265,23,null,'menu');"  >
					<area shape="rect" coords="238,0,309,21" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.mm_menu_1010223211_6,220,23,null,'menu');"  >
					<area shape="rect" coords="115,0,229,19" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.mm_menu_1010222548_7,90,23,null,'menu');"  >
					<area shape="rect" coords="58,0,111,19" href="Menu.php" alt="" onMouseOut="MM_startTimeout();"  onMouseOver="MM_showMenu(window.mm_menu_1010222338_8,35,23,null,'menu');"  >
				</map>
            		</td>
          	</tr>
          	<tr>
            		<td height="2" colspan="3" bgcolor="#FFFFCC"><img src="Images/Spacer.gif" width="1" height="1"></td>
          	</tr>
          	<tr bgcolor="#CEEFFF">
            		<td height="3" colspan="3"><img src="Images/Spacer.gif" width="1" height="1"></td>
          	</tr>
          </table>

</center>
