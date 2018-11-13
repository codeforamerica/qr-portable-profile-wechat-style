$.fn.fill_highlight = function() {
    this.css("transform", "scale(1.15)").delay(250).queue(function (next) { $(this).css('transform', 'scale(1)'); next(); });
};

chrome.runtime.onMessage.addListener(function(data_from_extension, sender, sendResponse) {
	var qr_code_info = data_from_extension;
	$("form *").css("transition", "all 250ms");
	
	function check_for_data() {
	    setTimeout(function () {
			$.get("http://portable-profile-v2.herokuapp.com/controllers/get-data.php?qr_code_id="+qr_code_info["id"], function(data) {
				if(data) {
					var user_info = JSON.parse(data);

					// parse some info
					if(user_info["birth_date"]) { var user_info_birth_date = user_info["birth_date"].split("-"); }
					if(user_info["name"]) { var user_info_name = user_info["name"].split(" "); }
	
					// CalJOBS
					if(user_info["name"]) { $("form [name='ctl00$Main_content$ucLogin$txtUsername']").val(user_info["name"].replace(" ", "").toLowerCase()).fill_highlight(); }
					if(user_info["address_zip"]) { $("form [name='ctl00$Main_content$txtZip']").val(user_info["address_zip"]).fill_highlight(); }
					if(user_info["email_address"]) { $("form [name='ctl00$Main_content$ucEmailTextBox$txtEmail']").val(user_info["email_address"]).fill_highlight(); }
					if(user_info["email_address"]) { $("form [name='ctl00$Main_content$ucEmailTextBox$txtEmailConfirm']").val(user_info["email_address"]).fill_highlight(); }
					if(user_info["birth_date"]) { $("form [name='ctl00$Main_content$ucRegDemographics$txtDOB']").val(user_info_birth_date[1]+"/"+user_info_birth_date[2]+"/"+user_info_birth_date[0]).fill_highlight(); }
	
					// California EDD
					if(user_info["email_address"]) { $("form [name='Email']").val(user_info["email_address"]).fill_highlight(); }
					if(user_info["email_address"]) { $("form [name='ConfirmedEmail']").val(user_info["email_address"]).fill_highlight(); }
	
					// MyBenefits CalWIN
					if(user_info["name"]) { $("form [name='firstName']").val(user_info_name[0]).fill_highlight(); }
					if(user_info["name"]) { $("form [name='lastName']").val(user_info_name[1]).fill_highlight(); }
					if(user_info["email_address"]) { $("form [name='email']").val(user_info["email_address"]).fill_highlight(); }
					if(user_info["email_address"]) { $("form [name='email2']").val(user_info["email_address"]).fill_highlight(); }
	
					// Unemployment Insurance registration

					if(user_info["name"]) { $("form [name='ctl00$contentMain$ucClaimantAccountRegistrationTemplate$frmClaimantAccountRegistration$prtFirstName$ctl00$txtValue']").val(user_info_name[0]).fill_highlight(); }
					if(user_info["name"]) { $("form [name='ctl00$contentMain$ucClaimantAccountRegistrationTemplate$frmClaimantAccountRegistration$prtLastName$ctl00$txtValue']").val(user_info_name[1]).fill_highlight(); }
					if(user_info["birth_date"]) { $("form [name='ctl00$contentMain$ucClaimantAccountRegistrationTemplate$frmClaimantAccountRegistration$prtDateOfBirth$ctl00$txtDate']").val(user_info_birth_date[1]+"/"+user_info_birth_date[2]+"/"+user_info_birth_date[0]).fill_highlight(); }
	
					$.each(user_info, function(key, value) {
						if(value) {
							$("form [name='"+key+"']").val(value).fill_highlight();
						}
					});
				} else {
			        check_for_data();
				}
			});
	    }, 500);
	}
	
	check_for_data();
});