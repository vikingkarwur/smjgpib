<?php
/*******************************************************************************
 *
 *  filename    : Include/Footer.php
 *  last change : 2002-04-22
 *  description : footer that appear on the bottom of all pages
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
?>

<div class="Footer">
<strong><?php echo gettext("$sNamaJemaat");?></strong> - smjGPIB v<?php echo gettext("$sVersi");?>  | sistem managemen jemaat <a href="http://www.gpib.or.id/" target="_blank">GPIB</a>
</div>

</body>

</html>
<?php

// Turn OFF output buffering
ob_end_flush();

// Reset the Global Message
$_SESSION['sGlobalMessage'] = "";

?>
