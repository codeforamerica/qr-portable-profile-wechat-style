<?php
	require("../resources/php/base.php");

	$db = new mysqli($db_credentials["server"], $db_credentials["username"], $db_credentials["password"], $db_credentials["database"]);
	$db->query("INSERT INTO codes (qr_code_id) VALUES ('')");
	$inserted_id = $db->insert_id;
	$db->close();

	$server = "http://portable-profile-v2.herokuapp.com";
	$qr_code_url = $server."/views/user/fill-form.php?qr_code_id=".$inserted_id;
	$qr_code_image = $server."/controllers/generate-qr-code.php?data=".$qr_code_url;
	
	$data = Array(
		"image" => $qr_code_image,
		"id" => $inserted_id
	);
	
	echo json_encode($data);
?>