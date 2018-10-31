<?php
	require("../resources/php/base.php");
	
	$qr_code_id = $_GET["qr_code_id"];
	
	$db = new mysqli($db_credentials["server"], $db_credentials["username"], $db_credentials["password"], $db_credentials["database"]);
	$result = $db->query("SELECT data FROM codes WHERE qr_code_id = '".$qr_code_id."'");
	
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        echo $row["data"];
	    }
	} else {
	    echo "no results";
	}
	
	$db->close();
?>