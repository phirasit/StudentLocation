
var devices = [];
var csrf = window.Laravel.csrfToken;

// add new device to devices
function registerStudentDevice(device_mac_address, display_id, color) {
	console.log(device_mac_address, display_id, color);
	devices.push({
		device_mac_address: device_mac_address,
		display_id: display_id,
		color: color,
	});
}

function getAreaPositionInMap(area) {
	return result == "" ? [] : JSON.parse(result);
}

// get new location for all devices
function refreshLocation() {

	if (csrf == null) {
		console.log("csrf is not found");
		return;
	}

	function refreshEachDevice(idx) {
		
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

			var data = responseText;

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

			if (data.area != '-') {
				console.log(data.location);
				devices[idx].location = data.location;
			} else {
				devices[idx].location = null;
			}

			refreshEachDevice(idx+1);
		});
		
	};

	refreshEachDevice(0);
}

function call(device_mac_address, area) {

	console.log(device_mac_address, area);

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
		refresh();
	}).fail(function(responseText) {
		console.log(responseText);
	});
}

