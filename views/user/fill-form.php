<?php
	require("../../resources/php/base.php");
	
	$qr_code_id = $_GET["qr_code_id"];
?>
<!DOCTYPE HTML>
<html>

	<head>
		<title>Enter Data</title>
		<link rel="stylesheet/less" href="../../resources/css/style.less">
		<script src="../../resources/js/lib/less.js"></script>
		<script src="../../resources/js/lib/jquery.js"></script>
		<script src="../../resources/js/main.js"></script>
		<meta name="viewport" content = "width = device-width, initial-scale = 1, user-scalable = no" />
		
		<script type="text/javascript">
			$(document).ready(function() {
				var user_data = {};
				
				$.each(localStorage, function(key, value) {
					if(key !== "auto_saved_sql") {	
						$("form [name='"+key+"']").val(value);
					}
				});
			
				$("a#yes").click(function() {
					$.each($('form').serializeArray(), function(i, field) {
						user_data[field.name] = field.value;
					});
				
					user_data_json = JSON.stringify(user_data);
					
					$.get("../../controllers/save-data.php?data="+user_data_json+"&qr_code_id=<?php echo $qr_code_id; ?>");
					$("form").submit();
				});
				
				$("form").submit(function(e) {
					e.preventDefault();

					var values = {};
					$.each($('form').serializeArray(), function(i, field) {
					    values[field.name] = field.value;
						localStorage.setItem(field.name, field.value);
						user_data[field.name] = field.value;
					});
					
					user_data_json = JSON.stringify(user_data);
					
					$.get("../../controllers/save-data.php?data="+user_data_json+"&qr_code_id=<?php echo $qr_code_id; ?>");
					
					$("input[type=submit]").val("Saved!").css("background", "#4080FF");
					
					setTimeout(function() {
						$("input[type=submit]").val("Save and Share").css("background", "#42B72A");
					}, 1000);
				});
			});
		</script>
	</head>
	<body ontouchstart="">

		<h2>Would you like to share your information?</h2>
		
		<a class="button split yes" id="yes">Yes</a>
		<a class="button split no">No</a>
		

		<h3>You can edit your information before you share:</h3>
		
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
			<label for="birth_date">Birthday</label> <input type="date" name="birth_date" value="<?php echo date('Y-m-d');?>"><br>
			<br><br>
			<label for="notes">Notes</label>
			<br><br>
			<textarea name="notes"></textarea>
			<input name="file1" id="file1" type="hidden">
			<input name="file2" id="file2" type="hidden">
			<input name="file3" id="file3" type="hidden">
			<br>
			<br>
			<br>
			<br>
			<input type="submit" value="Save and Share" class="button yes">
		</form>
		
		
	</body>
</html>