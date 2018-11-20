<?php
	require("../../resources/php/base.php");
?>
<!DOCTYPE HTML>
<html>

	<head>
		<title>Enter Data</title>
		<link rel="stylesheet/less" href="../../resources/css/style.less?<?php echo rand(0, 9999); ?>">
		<script src="../../resources/js/lib/less.js"></script>
		<script src="../../resources/js/lib/jquery.js"></script>
		<script src="../../resources/js/main.js"></script>
		<meta name="viewport" content = "width = device-width, initial-scale = 1, user-scalable = no" />
		
		<script type="text/javascript">
            $(document).ready(function() {
								
				$.each(localStorage, function(key, value) {
					if(key != "auto_saved_sql") {
						$("form [name='"+key+"']").val(value);
					}
				});
				
				$("form").submit(function(e) {
					e.preventDefault();

					var values = {};
					$.each($('form').serializeArray(), function(i, field) {
					    values[field.name] = field.value;
						localStorage.setItem(field.name, field.value);
					});
					
					var file_data = $('#file1').prop('files')[0];   
				    var form_data = new FormData();                  
				    form_data.append('file', file_data);

				    $.ajax({
				        url: '../../controllers/upload-file.php', // point to server-side PHP script 
				        dataType: 'text',  // what to expect back from the PHP script, if anything
				        cache: false,
				        contentType: false,
				        processData: false,
				        data: form_data,                         
				        type: 'post',
				        success: function(php_script_response){
				            console.log(php_script_response); // display response from the PHP script, if any
				        }
				     });
					
					$("input[type=submit]").val("Saved!").css("background", "#72CE0E");
					
					setTimeout(function() {
						$("input[type=submit]").val("Save").css("background", "#4080FF");;
					}, 1000);
				});
			});
		</script>
	</head>
	<body ontouchstart="">

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
			<br><br>
			<label for="files">Save Documents</label>
			<br><br>
			<input name="file2" id="file1" type="file" accept="image/*;capture=camera">
			<br><br>
			<input name="file2" id="file2" type="file" accept="image/*;capture=camera">
			<br><br>
			<input name="file3" id="file3" type="file" accept="image/*;capture=camera">
			<br>
			<br>
			<br>
			<br>
			<input type="submit" value="Save" class="button">
		</form>
		
	</body>
</html>
