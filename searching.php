<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
<?
// Created by Recky HM
// Database connection constants
$sSERVERNAME = "localhost";
$sUSER = "petrabgr";
$sPASSWORD = "petrabgr";
$sDATABASE = "petra-bogor";

$Var=$_POST[What2];

$sSQL0 = "SELECT * from person_per
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_NoIndJem LIKE '%$Var%' or family_fam.fam_NoIndFam LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL1 = "SELECT * from person_per
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_FirstName LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL2 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_MiddleName LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL3 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_LastName LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL4 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE fam_Address1 LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL5 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE fam_Kompleks1 LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL6 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_Address1 LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL7 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_Kompleks1 LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL8 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_CellPhone LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL9 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE fam_CellPhone LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL10 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE per_HomePhone LIKE '%$Var%' ORDER BY per_FirstName ASC";

$sSQL11 = "SELECT * from person_per
         LEFT JOIN person_custom ON person_per.per_ID = person_custom.per_ID
		 LEFT JOIN family_fam ON person_per.per_fam_ID = family_fam.fam_ID
         WHERE fam_HomePhone LIKE '%$Var%' ORDER BY per_FirstName ASC";

$Search0 = mysql_query($sSQL0);
$TotSrc0 = mysql_num_rows($Search0);
$Search1 = mysql_query($sSQL1);
$TotSrc1 = mysql_num_rows($Search1);
$Search2 = mysql_query($sSQL2);
$TotSrc2 = mysql_num_rows($Search2);
$Search3 = mysql_query($sSQL3);
$TotSrc3 = mysql_num_rows($Search3);
$Search4 = mysql_query($sSQL4);
$TotSrc4 = mysql_num_rows($Search4);
$Search5 = mysql_query($sSQL5);
$TotSrc5 = mysql_num_rows($Search5);
$Search6 = mysql_query($sSQL6);
$TotSrc6 = mysql_num_rows($Search6);
$Search7 = mysql_query($sSQL7);
$TotSrc7 = mysql_num_rows($Search7);
$Search8 = mysql_query($sSQL8);
$TotSrc8 = mysql_num_rows($Search8);
$Search9 = mysql_query($sSQL9);
$TotSrc9 = mysql_num_rows($Search9);
$Search10 = mysql_query($sSQL10);
$TotSrc10 = mysql_num_rows($Search10);
$Search11 = mysql_query($sSQL11);
$TotSrc11 = mysql_num_rows($Search11);


$Totalsrc= $TotSrc0+$TotSrc1+$TotSrc2+$TotSrc3+$TotSrc4+$TotSrc5+$TotSrc6+$TotSrc7+$TotSrc8+$TotSrc9+$TotSrc10+$TotSrc11;

if ($Totalsrc > 0) {
 echo"Hai ! <b>".$_SESSION['UserFirstName'] . " " .$_SESSION['UserLastName'] ."</b>, smjGPIB berhasil menemukan <b>$Totalsrc</b> record yg berhubungan dengan <b>\" <font color=blue> $Var </font> \"</b> dlm database $NamaJemaat $KotaJemaat<br><br>";
 } else {
 echo "Sorry ! <b>".$_SESSION['UserFirstName'] . " " .$_SESSION['UserLastName'] ."</b>, smjGPIB tidak berhasil menemukan <b>\" <font color=blue> $Var </font> \"</B> dalam database $NamaJemaat $KotaJemaat, coba lagi....<br>";
 }

$nJ=gettext("$nojemaat");
//$nJ=("test");
$nM=gettext("$nomupel");

$no=1;
while ($Hasil0=mysql_fetch_array($Search0)) {
			$sNoid=$Hasil0[per_NoIndJem];
			$sNoidF=$Hasil0[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil0[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";
 //$List0 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil0[per_ID]'>$Noid $Hasil0[per_FirstName] $Hasil0[per_MiddleName] $Hasil0[per_LastName] | $Hasil0[fam_NamaSek] | $Hasil0[per_Address1] $Hasil0[per_Kompleks1] $Hasil0[fam_Kompleks1] $Hasil0[fam_Address1] | $Hasil0[fam_HomePhone] | $Hasil0[per_HomePhone] | $Hasil0[fam_CellPhone] | $Hasil0[per_CellPhone]</a>");
 $List0 = ("<a href='PersonView.php?PersonID=$Hasil0[per_ID]'>$Noid $Hasil0[per_FirstName] $Hasil0[per_MiddleName] $Hasil0[per_LastName] | $Hasil0[fam_NamaSek] | $Hasil0[per_Address1] $Hasil0[per_Kompleks1] $Hasil0[fam_Kompleks1] $Hasil0[fam_Address1] | $Hasil0[fam_HomePhone] | $Hasil0[per_HomePhone] | $Hasil0[fam_CellPhone] | $Hasil0[per_CellPhone]</a>");
 echo"$no. $List0<br>";
 $id0="$id0, $Hasil0[per_ID]";
 $no++;
 }
$id11="$id0";

while ($Hasil1=mysql_fetch_array($Search1)) {
			$sNoid=$Hasil1[per_NoIndJem];
			$sNoidF=$Hasil1[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil1[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";
 $id1="$Hasil1[per_ID]";
 if (!ereg($id1,$id0)) {
 $List1 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil1[per_ID]'>$Noid $Hasil1[per_FirstName] $Hasil1[per_MiddleName] $Hasil1[per_LastName] | $Hasil1[fam_NamaSek] | $Hasil1[per_Address1] $Hasil1[per_Kompleks1] $Hasil1[fam_Kompleks1] $Hasil1[fam_Address1] | $Hasil1[fam_HomePhone] | $Hasil1[per_HomePhone] | $Hasil1[fam_CellPhone] | $Hasil1[per_CellPhone]</a>");
 echo"$no. 1 $List1<br>";
 $id1="$id1, $Hasil1[per_ID]";
 $no++;
 }
 }
$id22="$id1";
while ($Hasil2=mysql_fetch_array($Search2)) {
			$sNoid=$Hasil2[per_NoIndJem];
			$sNoidF=$Hasil2[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil2[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";

 $id2="$Hasil2[per_ID]";
 if (!ereg($id2,$id1)) {
 $List2 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil2[per_ID]'>$Noid $Hasil2[per_FirstName] $Hasil2[per_MiddleName] $Hasil2[per_LastName] | $Hasil2[fam_NamaSek] | $Hasil2[per_Address1] $Hasil2[per_Kompleks1] $Hasil2[fam_Kompleks1] $Hasil2[fam_Address1] | $Hasil2[fam_HomePhone] | $Hasil2[per_HomePhone] | $Hasil2[fam_CellPhone] | $Hasil2[per_CellPhone]</a>");
 echo"$no. $List2<br>";
 $id222="$id222, $Hasil2[per_ID]";
  $no++;
 }
 }
$id33="$id1$id222";
while ($Hasil3=mysql_fetch_array($Search3)) {
			$sNoid=$Hasil3[per_NoIndJem];
			$sNoidF=$Hasil3[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil3[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";

 $id3="$Hasil3[per_ID]";
 if (!ereg($id3,$id33)) {
 $List3 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil3[per_ID]'>$Noid $Hasil3[per_FirstName] $Hasil3[per_MiddleName] $Hasil3[per_LastName] | $Hasil3[fam_NamaSek] | $Hasil3[per_Address1] $Hasil3[per_Kompleks1] $Hasil3[fam_Kompleks1] $Hasil3[fam_Address1] | $Hasil3[fam_HomePhone] | $Hasil3[per_HomePhone] | $Hasil3[fam_CellPhone] | $Hasil3[per_CellPhone]</a>");
 echo"$no. $List3<br>";
 $id333="$id333, $Hasil3[per_ID]";
  $no++;
 }
 }

$id44="$id1$id222$id333";
while ($Hasil4=mysql_fetch_array($Search4)) {
			$sNoid=$Hasil4[per_NoIndJem];
			$sNoidF=$Hasil4[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil4[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";

 $id4="$Hasil4[per_ID]";
 if (!ereg($id4,$id44)) {
 $List4 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil4[per_ID]'>$Noid $Hasil4[per_FirstName] $Hasil4[per_MiddleName] $Hasil4[per_LastName] | $Hasil4[fam_NamaSek] | $Hasil4[per_Address1] $Hasil4[per_Kompleks1] $Hasil4[fam_Kompleks1] $Hasil4[fam_Address1] $Hasil4[fam_HomePhone] | $Hasil4[per_HomePhone] | $Hasil4[fam_CellPhone] | $Hasil4[per_CellPhone]</a>");
 echo"$no. $List4<br>";
 $id444="$id444, $Hasil4[per_ID]";
  $no++;
 }
 }

$id55="$id1$id222$id333$id444";
while ($Hasil5=mysql_fetch_array($Search5)) {
			$sNoid=$Hasil5[per_NoIndJem];
			$sNoidF=$Hasil5[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil5[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";

 $id5="$Hasil5[per_ID]";
 if (!ereg($id5,$id55)) {
 $List5 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil5[per_ID]'>$Noid $Hasil5[per_FirstName] $Hasil5[per_MiddleName] $Hasil5[per_LastName] | $Hasil5[fam_NamaSek] |  $Hasil5[per_Address1] $Hasil5[per_Kompleks1] $Hasil5[fam_Kompleks1] $Hasil5[fam_Address1] $Hasil5[fam_HomePhone] | $Hasil5[per_HomePhone] | $Hasil5[fam_CellPhone] | $Hasil5[per_CellPhone]</a>");
 echo"$no. $List5<br>";
 $id555="$id555, $Hasil5[per_ID]";
  $no++;
 }
 }
$id66="$id1$id222$id333$id444$id555";
while ($Hasil6=mysql_fetch_array($Search6)) {
			$sNoid=$Hasil6[per_NoIndJem];
			$sNoidF=$Hasil6[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil6[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";

 $id6="$Hasil6[per_ID]";
 if (!ereg($id6,$id66)) {
 $List6 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil6[per_ID]'>$Noid $Hasil6[per_FirstName] $Hasil6[per_MiddleName] $Hasil6[per_LastName] | $Hasil6[fam_NamaSek] | $Hasil6[per_Address1] $Hasil6[per_Kompleks1] $Hasil6[fam_Kompleks1] $Hasil6[fam_Address1] $Hasil6[fam_HomePhone] | $Hasil6[per_HomePhone] | $Hasil6[fam_CellPhone] | $Hasil6[per_CellPhone]</a>");
 echo"$no. $List6<br>";
 $id666="$id666, $Hasil6[per_ID]";
  $no++;
 }
 }
$id77="$id1$id222$id333$id444$id555$id666";
while ($Hasil7=mysql_fetch_array($Search7)) {
			$sNoid=$Hasil7[per_NoIndJem];
			$sNoidF=$Hasil7[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil7[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";

 $id7="$Hasil7[per_ID]";
 if (!ereg($id7,$id77)) {
 $List7 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil7[per_ID]'>$Noid $Hasil7[per_FirstName] $Hasil7[per_MiddleName] $Hasil7[per_LastName] | $Hasil7[fam_NamaSek] | $Hasil7[per_Address1] $Hasil7[per_Kompleks1] $Hasil7[fam_Kompleks1] $Hasil7[per_Kompleks1] $Hasil7[fam_Address1] $Hasil7[fam_HomePhone] | $Hasil7[per_HomePhone] | $Hasil7[fam_CellPhone] | $Hasil7[per_CellPhone]</a>");
 echo"$no. $List7<br>";
 $id777="$id777, $Hasil7[per_ID]";
  $no++;
 }
 }
$id88="$id1$id222$id333$id444$id555$id666$id777";
while ($Hasil8=mysql_fetch_array($Search8)) {
			$sNoid=$Hasil8[per_NoIndJem];
			$sNoidF=$Hasil8[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil8[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";

 $id8="$Hasil8[per_ID]";
 if (!ereg($id8,$id88)) {
 $List8 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil8[per_ID]'>$Noid $Hasil8[per_FirstName] $Hasil8[per_MiddleName] $Hasil8[per_LastName] | $Hasil8[fam_NamaSek] | $Hasil8[per_Address1] $Hasil8[per_Kompleks1] $Hasil8[fam_Kompleks1] $Hasil8[fam_Address1] $Hasil8[fam_HomePhone] | $Hasil8[per_HomePhone] | $Hasil8[fam_CellPhone] | $Hasil8[per_CellPhone]</a>");
 echo"$no. $List8<br>";
 $id888="$id888, $Hasil8[per_ID]";
  $no++;

 }
 }
$id99="$id1$id222$id333$id444$id555$id666$id777$id888";
while ($Hasil9=mysql_fetch_array($Search9)) {
			$sNoid=$Hasil9[per_NoIndJem];
			$sNoidF=$Hasil9[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil9[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";

 $id9="$Hasil9[per_ID]";
 if (!ereg($id9,$id99)) {
 $List9 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil9[per_ID]'>$Noid $Hasil9[per_FirstName] $Hasil9[per_MiddleName] $Hasil9[per_LastName] | $Hasil9[fam_NamaSek] | $Hasil9[per_Address1] $Hasil9[per_Kompleks1] $Hasil9[fam_Kompleks1] $Hasil9[fam_Address1] $Hasil9[fam_HomePhone] | $Hasil9[per_HomePhone] | $Hasil9[fam_CellPhone] | $Hasil9[per_CellPhone]</a>");
 echo"$no. $List9<br>";
 $id999="$id999, $Hasil9[per_ID]";
  $no++;
 }
 }
$id1010="$id1$id222$id333$id444$id555$id666$id777$id888$id999";
while ($Hasil10=mysql_fetch_array($Search10)) {
			$sNoid=$Hasil10[per_NoIndJem];
			$sNoidF=$Hasil10[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil10[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";

 $id10="$Hasil10[per_ID]";
 if (!ereg($id10,$id1010)) {
 $List10 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil10[per_ID]'>Noid $Hasil10[per_FirstName] $Hasil10[per_MiddleName] $Hasil10[per_LastName] | $Hasil10[fam_NamaSek] | $Hasil10[per_Address1] $Hasil0[per_Kompleks1] $Hasil10[fam_Kompleks1] $Hasil10[fam_Address1] $Hasil10[fam_HomePhone] | $Hasil10[per_HomePhone] | $Hasil10[fam_CellPhone] | $Hasil10[per_CellPhone]</a>");
 echo"$no. $List10<br>";
 $id101010="$id101010, $Hasil10[per_ID]";
  $no++;
 }
 }
$id1111="$id1$id222$id333$id444$id555$id666$id777$id888$id899$id999$id101010";
while ($Hasil11=mysql_fetch_array($Search11)) {
			$sNoid=$Hasil11[per_NoIndJem];
			$sNoidF=$Hasil11[fam_NoIndFam];
			$Jumkar=strlen($sNoid);
			$sNamaS=$Hasil11[fam_NamaSek];
			$Noid="$sNoidF - $sNoid.$sNamaS";
 $id11="$Hasil11[per_ID]";
 if (!ereg($id11,$id1111)) {
 $List11 = eregi_replace($Var,"<font color=blue>$Var</font>", "<a href='PersonView.php?PersonID=$Hasil11[per_ID]'>$Noid $Hasil11[per_FirstName] $Hasil11[per_MiddleName] $Hasil11[per_LastName] | $Hasil11[fam_NamaSek] | $Hasil11[per_Address1] $Hasil11[per_Kompleks1] $Hasil11[fam_Kompleks1] $Hasil11[fam_Address1] $Hasil11[fam_HomePhone] | $Hasil11[per_HomePhone] | $Hasil11[fam_CellPhone] | $Hasil11[per_CellPhone]</a>");
 echo"$no. $List11<br>";
 //$id111111="$id111111, $Hasil11[per_ID]";
  $no++;
 }
 }
 //}
 ?>
 	</td>
  </tr>
</table>
