
var devices = [];
var csrf = window.Laravel.csrfToken;

// add new device to devices
function registerStudentDevice(device_mac_address, display_id, token_id) {
	devices.push({
		device_mac_address: device_mac_address,
		display_id: display_id,
		token_id: token_id,
	});
}

// get new location for all devices
function refreshLocation() {

	var rect = $("#map").position();

	if (csrf == null) {
		console.log("csrf is not found");
		return;
	}

	function refresh(idx) {
		
		if (idx >= devices.length) {
			return;
		}

		var device = devices[idx];

		$.ajax({
			url: getLocation_url,
			type: "POST",
	        data: { 
	        	_token: csrf,
	        	device_mac_address: device["device_mac_address"]
	        },
		}).done(function(responseText) {

			var data = JSON.parse(responseText);

			if (data.callButton == '') {
				$("#" + device["display_id"]).html(data.area);		
			} else if (data.callButton == 'active') {
				$("#" + device["display_id"]).html("<button \
					class='btn btn-primary' \
					onclick='call(\"" + device["device_mac_address"] + "\", \"" + data.area + "\");'>" 
					+ data.area + 
					"</button>");						
			} else if (data.callButton == 'inactive') {
				$("#" + device["display_id"]).html("<button class='btn btn-secondary disabled'>" + data.area + "</button>");
			} else {
				console.log('unknown response:' + data.callButton);
			}

			$("#" + device["token_id"]).offset({
				top: rect.top + data.location[0],
				left: rect.left + data.location[1],
			});

			refresh(idx+1);
		});
		
	};

	refresh(0);
}

function call(device_mac_address, area) {

	$.ajax({
		url: callStudent_url + '/' + device_mac_address + '/' + area,
		type: "POST",
        data: { 
        	_token: csrf,
        	device_mac_address: device_mac_address,
        	area: area,
        },
	}).done(function(responseText) {
		console.log(responseText);
		refreshLocation();
	});
}

// set onload function
document.body.onload = function() {
	refreshLocation();
}