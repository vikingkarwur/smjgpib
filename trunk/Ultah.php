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

//$thn1=$TAHUNINI-3;
//$thn2=$TAHUNINI+3;



?>
<table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center">&nbsp; </td>
  </tr>
  <?
//HUT 7 Hari terakhir (generate)
//if ($_GET[action]=="ultahseminggu") { 
                        


$status=0;

if ($HARI=='Mon') {   
   $HARIINI1=DATE(d)+6;
   $HARIINI=DATE(d)+6;
   $status=1;
   }
if ($HARI=='Tue') {   
   $HARIINI1=DATE(d)+5;
   $HARIINI=DATE(d)+5;
   $status=1;
   }
if ($HARI=='Wed') {   
   $HARIINI1=DATE(d)+4;
   $HARIINI=DATE(d)+4;
   $status=1;
   }
   
if ($HARI=='Thu') {   
   $HARIINI1=DATE(d)+3;
   $HARIINI=DATE(d)+3;
   $status=1;
   }
   
if ($HARI=='Fri') {   
   $HARIINI1=DATE(d)+2;
   $HARIINI=DATE(d)+2;
   $status=1;
   }
    
if ($HARI=='Sat') {   
   $HARIINI1=DATE(d)+1;
   $HARIINI=DATE(d)+1;
   $status=1;
   }

if ($HARI=='Sun') {   
   $HARIINI1=DATE(d)+0;
   $HARIINI=DATE(d)+0;
   $status=1;
   }
   
   if ($HARIINI1>$TGLMAX) {
       $HARIINI1=1;
	   $HARIINI=1;
	   $TGLSTART=1;
	   $BULANSTART++;
	   $BULANINI++;
	   if ($BULANINI>12) {
		   $BULANINI=1;
		   $BULANSTART=1;
		   $TAHUNINI++;
		   $TAHUNINISTART++;
		   }
	   }
	   
   $HARIINICOUNT=1;
   
   $perintah="TRUNCATE TABLE person_hut";
   mysql_query($perintah);
   while ($HARIINICOUNT<=7)
      {
	  $SQL = "SELECT * FROM person_per LEFT JOIN family_fam ON  family_fam.fam_ID = person_per.per_fam_ID WHERE per_BirthDay = $HARIINI AND per_BirthMonth = $BULANINI AND per_cls_ID=1 ";
      $TotalFemaleListing = mysql_query($SQL);
      while ($Hasil=mysql_fetch_array($TotalFemaleListing)) 
            {
			$Ultahke=$TAHUNINI-$Hasil[per_BirthYear];
			//$perintah="UPDATE person_hut SET ultah_NAMA1=$Hasil[per_FirstName], ultah_NAMA2=$Hasil[per_LastName], ultah_KE=$Ultahke, ultah_NAMASEK=$Hasil[fam_NamaSek], ultah_TGL=$Hasil[per_BirthDay], ultah_BLN=$Hasil[per_BirthMonth], ultah_THN=$TAHUNINI, ultah_per_ID=$Hasil[per_ID], ultah_END=$Hasil[per_MiddleName]";
			$perintah="INSERT INTO person_hut (ultah_NAMA1, ultah_NAMA2, ultah_KE, ultah_NAMASEK, ultah_TGL, ultah_BLN, ultah_THN, ultah_per_ID, ultah_fam_ID, ultah_END) VALUES ('$Hasil[per_FirstName]','$Hasil[per_LastName]','$Ultahke','$Hasil[fam_NamaSek]', $Hasil[per_BirthDay], $Hasil[per_BirthMonth], $TAHUNINI,'$Hasil[per_ID]', '$Hasil[fam_Name]', '$Hasil[per_MiddleName]')"; 
			mysql_query($perintah);
			$No++;
			$status=3;
			}
	           if ($HARIINI>=$TGLMAX) {
			       $HARIINI=0;
		           $BULANINI++;
				   if ($BULANINI>12) {
				       $BULANINI=1;
					   $TAHUNINI++;
					   }
				   }
		   
		   $HARIINI++;
		   $HARIINICOUNT++;
		   }
	 $HARIINIAKHIR=($HARIINI-1);
	 
	 if ($status==1) {
	 $perintah = " INSERT INTO person_hut (ultah_START, ultah_TGLAKHIR, ultah_BLNSTART) VALUES ('$HARIINI1','$HARIINIAKHIR','$BULANSTART')";
	 mysql_query($perintah);
	 } 
	 if ($status==2) {
	 $perintah = " INSERT INTO person_hut (ultah_START, ultah_TGLAKHIR, ultah_BLNSTART) VALUES ('$HARIINI','$HARIINIAKHIR','$BULANSTART')";
	 mysql_query($perintah);
	 }
	  if ($status==3) {
	 $perintah = " UPDATE person_hut SET ultah_START=$HARIINI1, ultah_TGLAKHIR=$HARIINIAKHIR, ultah_BLNSTART=$BULANSTART";
	 mysql_query($perintah);
	 }
	 //if ($status==0) {
	 //$perintah = " INSERT INTO person_hut (ultah_START, ultah_TGLAKHIR, ultah_BLNSTART) VALUES ('$HARIINI1','$HARIINIAKHIR','$BULANSTART')";
	 //mysql_query($perintah); echo status0;
	 //}
	 //}
?>
  <tr> 
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
    <td> </td>
  </tr>
  <tr> 
    <td> Jemaat ulang tahun selama seminggu periode (<?php echo "$tglstart-$bulanstart-$TAHUNINISTART s/d $tglakhir - $BULANINI - $TAHUNINI"; ?>) 
    </td>
  </tr>
  <td> <table width="100%" border="0" cellspacing="1" cellpadding="1">
      <tr> 
        <td width="16%" bgcolor="#66CCFF"> <div align="center"><strong>TANGGAL</strong></div></td>
        <td width="68%" bgcolor="#66CCFF"> <div align="center"><strong>N A M A</strong></div></td>
        <td width="9%" bgcolor="#66CCFF"> <div align="center"><strong>Ulang Tahun 
            Ke</strong></div></td>
        <td width="7%" bgcolor="#66CCFF"> <div align="center"><strong>Sek Pel</strong></div></td>
      </tr>
      <?php
   $No=1;
   $SQL = "SELECT * FROM person_hut ORDER BY ultah_TGL ASC, ultah_NAMASEK ASC";
   $SQL = "SELECT * FROM person_hut ";
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
        <td width="16%" align="center"><? echo"$Hasil[ultah_TGL]-$Hasil[ultah_BLN]-$Hasil[ultah_THN]";?></td>
        <td>&nbsp;<? echo"<a href='PersonView.php?PersonID=$Hasil[ultah_per_ID]'>$Hasil[ultah_NAMA1] $Hasil[ultah_END] $Hasil[ultah_NAMA2] (Kel. $Hasil[ultah_fam_ID])</td>";?></td>
        <td width="9%" align="center"><? echo"$Hasil[ultah_KE]";?></td>
        <td width="7%" align="center"><? echo"$Hasil[ultah_NAMASEK]";?></td>
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
</table>
