<?php
/*******************************************************************************
 *
 *  filename    : Include/ReportsConfig.php
 *  last change : 2003-03-14
 *  description : Configure report generation
 *
 *  http://www.infocentral.org/
 *  Copyright 2003 Chris Gebhardt
 *
 *  InfoCentral is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 ******************************************************************************/

//
// Paper size for all PDF report documents
// Sizes: A3, A4, A5, Letter, Legal, or a 2-element array for custom size
//
$paperFormat = "Letter";

//
// Yearly Donation Report Letter (Exemption Letter)
//

//  You may want to comment this out if you are using custom pre-printed letterhead paper.
$sExemptionLetter_Letterhead = "../Images/church_letterhead.png";

$sExemptionLetter_Intro = "We appreciate your financial support during the past year to Your Organization of City, State. The following is a statement of your donations during the past year." ;
$sExemptionLetter_EndLine = "Thank you for your kind donations and may the Lord reward you.<br><br>" ;
$sExemptionLetter_Closing = "<br>Sincerely,<br>" ;
$sExemptionLetter_Author = "<br>Your Name<br>Treasurer" ;
$sExemptionLetter_FooterLine = "123 Your Address · Your City, ST 12345 · Tel. 555.555.1212 · Fax. 555.555.1212 · http://www.youraddress.com";
$sExemptionLetter_Signature = "../Images/signature.png";

//
// Directory Report default settings.  These can be changed at report-creation time.
//

// Settings for the optional title page
$sChurchName = "GPIB Petra";
$sChurchAddress = "123 Your Address";
$sChurchCity = "Your City";
$sChurchState = "ST";
$sChurchZip = "12345";
$sChurchPhone = "(555) 555-5555";
$sDirectoryDisclaimer = "Banyak usaha yang dilakukan untuk membuat keakurasian data. Jika ada kesalahan atau kekurangan, silahkan menghubungi kantor $sChurchName.\n\nData ini hanya digunakan untuk kalangan $sChurchName, dan informasi yang ada harap tidak digunakan untuk kepentingan bisnis atau komersial.";

$bDirLetterHead = "../Images/church_letterhead.png";

// Include only these classifications in the directory, comma seperated
$sDirClassifications = "1,2,4,5";
// These are the family role numbers designated as head of house
$sDirRoleHead = "1,7";
// These are the family role numbers designated as spouse
$sDirRoleSpouse = "2";
// These are the family role numbers designated as child
$sDirRoleChild = "3";

// Donation Receipt
$sDonationReceipt_Thanks = "Thank you for your kind donation to Your Organization of City, State.";
$sDonationReceipt_Closing = "Thank you!";

?>
