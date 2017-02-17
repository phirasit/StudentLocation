
var devices = [];
var csrf = window.Laravel.csrfToken

// add new device to devices
function registerStudentDevice(device_mac_address, display_id) {
	devices.push({
		device_mac_address: device_mac_address,
		display_id: display_id
	});
}

// get new location for all devices
function refreshLocation() {

	if (csrf == null) {
		console.log("csrf is not found");
		return;
	}

	for (var i = 0 ; i < devices.length; ++i) {

		var device = devices[i];

		$.ajax({
			url: getLocation_url,
			type: "POST",
            data: { 
            	_token: csrf,
            	device_mac_address: device["device_mac_address"]
            },
		}).done(function(responseText) {
			$("#" + device["display_id"]).html(responseText);
		});
	}
}

