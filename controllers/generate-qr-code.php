<?php	
    include("../resources/php/phpqrcode/qrlib.php");
	
	QRcode::png($_GET["data"], false, QR_ECLEVEL_L, 4);
?>