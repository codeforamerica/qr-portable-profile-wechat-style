<?php
	require("../../resources/php/base.php");

	$db = new mysqli($db_credentials["server"], $db_credentials["username"], $db_credentials["password"], $db_credentials["database"]);
	$db->query("INSERT INTO codes (qr_code_id) VALUES ('')");
	$inserted_id = $db->insert_id;
	$db->close();

	if(	$_SERVER["HTTP_HOST"] == "localhost" ||
		$_SERVER["HTTP_HOST"] == "leo.local" ||
		$_SERVER["HTTP_HOST"] == "::1" ||
		strpos($_SERVER["HTTP_HOST"], '192.168.1') !== false
	) {
		$server = "http://leo.local/portable-profile-wechat-style/git";
	} else {
	
		$server = "https://portable-profile-v2.herokuapp.com";
	}
	
	$qr_code_url = $server."/views/user/fill-form.php?qr_code_id=".$inserted_id;	
?>
<!DOCTYPE HTML>
<html>

	<head>
		<title>Generic Intake Tool Example</title>
		<link rel="stylesheet/less" href="../../resources/css/style.less">
		<script src="../../resources/js/lib/less.js"></script>
		<script src="../../resources/js/lib/jquery.js"></script>
		<script src="../../resources/js/main.js"></script>
		
		<script type="text/javascript">
			function check_for_data() {
			    setTimeout(function () {
					$.get("../../controllers/get-data.php?qr_code_id=<?php echo $inserted_id; ?>", function(data) {
						if(data) {
							user_info = JSON.parse(data);

							$.each(user_info, function(key, value) {
								$("form [name='"+key+"']").val(value);
							});
							
							if(user_info.file1 != "undefined") {
								$("#user-images #file1").show();
								$("#user-images #file1 a").attr("href", user_info.file1);
								$("#user-images #file1 a img").attr("src", user_info.file1);
							}
							
							if(user_info.file2 != "undefined") {
								$("#user-images #file2").show();
								$("#user-images #file2 a").attr("href", user_info.file2);
								$("#user-images #file2 a img").attr("src", user_info.file2);
							}
							
							if(user_info.file3 != "undefined") {
								$("#user-images #file3").show();
								$("#user-images #file3 a").attr("href", user_info.file3);
								$("#user-images #file3 a img").attr("src", user_info.file3);
							}
						} else {
					        check_for_data();
						}
					});
			    }, 500);
			}
			
			check_for_data();
		</script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		Scan the code below to fill in your information:
		<br>
		<img src="../../controllers/generate-qr-code.php?data=<?php echo $qr_code_url; ?>" data-qr-code-url="<?php echo $qr_code_url; ?>">
		<br>
		<br>

		<form method="POST">
			<label for="name">Name</label> <input type="text" name="name"><br>
			<label for="phone_number">Phone Number</label> <input type="text" name="phone_number"><br>
			<label for="email_address">Email</label> <input type="text" name="email_address"><br>
			<br><br>
			<label for="street_address_1">Street Address</label> <input type="text" name="street_address_1"><br>
			<label for="street_address_2">Apt/Unit</label> <input type="text" name="street_address_2"><br>
			<label for="address_city">City</label> <input type="text" name="address_city"><br>
			<label for="address_state">State</label> <input type="text" name="address_state"><br>
			<label for="address_zip">Zip Code</label> <input type="text" name="address_zip"><br>
			<br><br>
			<label for="birth_date">Birthday</label> <input type="date" name="birth_date"><br>
			<br><br>
			<label for="notes">Notes</label>
			<br><br>
			<textarea name="notes"></textarea>
			<br>
			<br>
			<br>
			<input type="submit" value="Save">
		</form>
		
		<div id="user-images" style="top: 259px;">
			<div id="file1"><a href="#file1" target="blank"><img src="#file1"></a></div>
			<div id="file2"><a href="#file2" target="blank"><img src="#file2"></a></div>
			<div id="file3"><a href="#file3" target="blank"><img src="#file3"></a></div>
		</div>
	</body>
</html>