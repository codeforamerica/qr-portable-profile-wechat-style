<?php
	require("../resources/php/base.php");

	$qr_code_id = $_GET["qr_code_id"];
	$data = $_GET['data'];

	$db = new mysqli($db_credentials["server"], $db_credentials["username"], $db_credentials["password"], $db_credentials["database"]);
	$db->query("UPDATE codes SET data = '".$data."' WHERE qr_code_id = '".$qr_code_id."';");
	$db->close();
?>