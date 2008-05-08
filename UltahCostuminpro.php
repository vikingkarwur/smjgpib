<?
// Turn ON output buffering
//ob_start();
// Include the function library
//require "Include/Config.php";
//require "Include/Functions.php";

// Database connection constants
$sSERVERNAME = "localhost";
$sUSER = "bukitsion";
$sPASSWORD = "bukitsion1234";
$sDATABASE = "smjgpib";

$cnInfoCentral = mysql_connect($sSERVERNAME,$sUSER,$sPASSWORD);
mysql_select_db($sDATABASE);

?>
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
<?
$HARI=DATE(D);
$HARIINI=DATE(d);
$BULANINI=DATE(m);
$TGLHARIINI=DATE(d);
$TAHUNINI=DATE(Y);
$BULANSTART=DATE(m);
$TGLMAX=DATE(t);
$TAHUNINISTART=DATE(Y);
$TGLSTART=DATE(d);
$test=DATE(z);

//echo $test;

//exit;
if ($BULANINI==1) {
    $tgl=31;
	}
if ($BULANINI==2) {
    $tgl=28;
	}
if ($BULANINI==3) {
    $tgl=31;
	}
if ($BULANINI==4) {
    $tgl=30;
	}
if ($BULANINI==5) {
    $tgl=31;
	}
if ($BULANINI==6) {
    $tgl=30;
	}
if ($BULANINI==7) {
    $tgl=31;
	}
if ($BULANINI==8) {
    $tgl=31;
	}
if ($BULANINI==9) {
    $tgl=30;
	}
if ($BULANINI==10) {
    $tgl=31;
	}
if ($BULANINI==11) {
    $tgl=30;
	}
if ($BULANINI==12) {
    $tgl=31;
	}

$bln[1]="Jan";
$bln[2]="Feb"; 
$bln[3]="Mar"; 
$bln[4]="Apr"; 
$bln[5]="Mei"; 
$bln[6]="Jun"; 
$bln[7]="Jul"; 
$bln[8]="Ags"; 
$bln[9]="Sep"; 
$bln[10]="Okt"; 
$bln[11]="Nov"; 
$bln[12]="Des";

?>
<table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center"></td>
  </tr>
    <?
		$SQL = "SELECT * FROM person_hut";
        $Total = mysql_query($SQL);
         while ($Hasil=mysql_fetch_array($Total))
             {
			 $tglstart=$Hasil[ultah_START];
			 $tglakhir=$Hasil[ultah_TGLAKHIR];
			 $bulanstart=$Hasil[ultah_BLNSTART];
             }
		?>
  <tr> 
    <td align="center">
      <form action="?action=costum&UltahCostum.php" method="post"/>
	  Dari
      <input type="text" name="Date1" value="<? echo"$HARIINI-$BULANINI-$TAHUNINI" ?>" maxlength="10" id="sel1" size="11">
	  <input name="image" type="image" onClick="return showCalendar('sel1', 'dd-mm-y');" src="Images/calendar.gif">
      s/d 
      <input type="text" name="Date2" value="<? //echo"$HARIINI-$BULANINI-$TAHUNINI" ?>" maxlength="10" id="sel2" size="11">
	  <input name="image" type="image" onClick="return showCalendar('sel2', 'dd-mm-y');" src="Images/calendar.gif">
	  <input type="submit" value="GO"> 
	</td>
  </tr>
  <?
//HUT 7 Hari terakhir (generate)
//if ($_GET[action]=="ultahseminggu") { 
                        
?>
  <tr>
    <td>
	</td>
  </tr>
<?
$BirthDay1=substr($_POST[Date1],0,2);
$BirthMonth1=substr($_POST[Date1],3,2);
$BirthYear1=substr($_POST[Date1],6,4);

$BirthDay2=substr($_POST[Date2],0,2);
$BirthMonth2=substr($_POST[Date2],3,2);
$BirthYear2=substr($_POST[Date2],6,4); 
 
if ($BirthDay2=='') {
    $BirthDay2=$BirthDay1;
	}
if ($BirthMonth2=='') {
    $BirthMonth2=$BirthMonth1;
	}
if ($BirthYear2=='') {
    $BirthYear2=$BirthYear1;
	}
	
if ($BirthDay2 < $BirthDay1 AND $BirthMonth2 > $BirthMonth1) {
   $BirthMonth2+1;
   }
    
//$jDate1=$BirthDay1+$BirthMonth1+$BirthYear1;
//$jDate2=$BirthDay2+$BirthMonth2+$BirthYear2;

//if ($jDate2<$jDate1) {
    //$BirthDay2=$BirthDay1;
	//if ($BirthMonth2>$BirthMonth1) {
	//   $BirthMonth+1;
	//   }
//	}
?>     <tr>
    <td> 
      Jemaat ulang tahun periode (<?php echo "$BirthDay1-$BirthMonth1-$BirthYear1 s/d $BirthDay2-$BirthMonth2-$BirthYear2"; ?>) 
    </td>
  </tr>
  <tr>

  </tr>
  <td> 
<? if ($_GET[action]=='costum') { ?>   
      <table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr> 
          <td width="3%" bgcolor="#66CCFF"> <div align="center">No.</div></td>
          <td width="13%" bgcolor="#66CCFF"><strong>TANGGAL</strong></td>
          <td width="68%" bgcolor="#66CCFF"> <div align="center"><strong>N A M 
              A</strong></div></td>
          <td width="9%" bgcolor="#66CCFF"> <div align="center"><strong>Ulang 
              Tahun Ke</strong></div></td>
          <td width="7%" bgcolor="#66CCFF"> <div align="center"><strong>Sek Pel</strong></div></td>
        </tr>
        <?php
   $No=1;
   //$SQL = "SELECT * FROM person_per WHERE (per_BirthDay>=$BirthDay1 AND per_BirthMonth>=$BirthMonth1) AND (per_BirthDay<=$BirthDay2 AND per_BirthMonth<=$BirthMonth2) ORDER BY per_BirthDay ASC, per_FirstName ASC";
   
   //$SQL = "SELECT * FROM person_per WHERE (per_BirthDay>=$BirthDay1 AND per_BirthMonth>=$BirthMonth1) AND (per_BirthDay<=$BirthDay2 AND per_BirthMonth<=$BirthMonth2) ORDER BY per_BirthDay ASC, per_FirstName ASC";
   $SQL = "SELECT * from person_per LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID where (per_BirthDay BETWEEN 30 AND 31) AND (per_BirthMonth BETWEEN 11 AND 12)  ";
   $TotalFemaleListing = mysql_query($SQL); 
     while ($Hasil=mysql_fetch_array($TotalFemaleListing))
            {
            if ($n==1) {
		       $bg="#BBCCFF";
		       } else {
	           $bg = "#E6F0FF";
		       } 
			?>
        <tr bgcolor="<? echo($bg); ?>" onmouseover="bgColor='#FFFFCC'" onmouseout="bgColor='<? echo($bg); ?>'" > 
          <td width="3%" align="center">&nbsp;<? echo $No; ?></td>
          <td width="13%" align="center"><? echo"$Hasil[per_BirthDay]-$Hasil[per_BirthMonth]-$TAHUNINI" ; ?></td>
          <td>&nbsp;<? echo"$Hasil[per_FirstName]" ; ?></td>
          <td width="9%" align="center"></td>
          <td width="7%" align="center">&nbsp;</td>
        </tr>
        <?
	$No++;
       $n++;
       if ($n>2) {
          $n=1; 
	      }
	}
 ?>
      </table>
	<? } ?>
</table>
