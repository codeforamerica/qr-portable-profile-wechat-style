$.get("http://localhost/portable-profile-wechat-style/git/chrome-ext-server-support/qr-code-info-json.php", function(data) {	
	qr_code_info = JSON.parse(data);
	
	$("#qr_code").html("<img src='"+qr_code_info["image"]+"'>");
	
	chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
		var current_tab = tabs[0];
		console.log(current_tab);

		chrome.tabs.executeScript(current_tab.id, { file: "js/lib/jquery.js" }, function() {
			chrome.tabs.executeScript(current_tab.id, {file: 'js/inject.js'}, function() {
				chrome.tabs.sendMessage(current_tab.id, qr_code_info);
			});
		});
	});
	
});