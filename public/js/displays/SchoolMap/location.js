
var devices = [];
var csrf = window.Laravel.csrfToken;

// add new device to devices
function registerStudentDevice(device_mac_address, display_id, token_id, color) {
	devices.push({
		device_mac_address: device_mac_address,
		display_id: display_id,
		token_id: token_id,
		color: color,
	});
}

function getAreaPositionInMap(area, mapINFO) {
	return result == "" ? [] : JSON.parse(result);
}

function refreshImage(display_canvas_id, mapINFO) {
	// drawArea(display_canvas_id, mapINFO[data.area], device.color);

	// clearCanvas(display_canvas_id);

	for (i in devices) {

	// 	var device = devices[i];
	// 	if (device.location != undefined) {
	// 		drawCircle(display_canvas_id, [device.location[0], device.location[1]], device.color);
	// 	}
	}

}

// get new location for all devices
function refreshLocation(display_canvas_id, mapINFO) {

	if (csrf == null) {
		console.log("csrf is not found");
		return;
	}

	// clearCanvas(display_canvas_id);

	function refreshEachDevice(idx) {
		
		if (idx >= devices.length) {
			refreshImage(display_canvas_id, mapINFO);
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
			// console.log(data);

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

