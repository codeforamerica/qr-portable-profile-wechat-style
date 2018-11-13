<?php
	if(	$_SERVER["REMOTE_ADDR"] == "localhost" ||
		$_SERVER["REMOTE_ADDR"] == "leo.local" ||
		$_SERVER["REMOTE_ADDR"] == "::1" ||
		strpos($_SERVER["REMOTE_ADDR"], '192.168.1') !== false
	) {
		$db_credentials["server"] = "localhost";
		$db_credentials["username"] = "root";
		$db_credentials["password"] = "root";
		$db_credentials["database"] = "qr-code-wechat";
	} else {
		$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

		$db_credentials["server"] = $url["host"];
		$db_credentials["username"] = $url["user"];
		$db_credentials["password"] = $url["pass"];
		$db_credentials["database"] = substr($url["path"], 1);
	}
	
	mysqli_set_charset($db, "utf8");		
?>