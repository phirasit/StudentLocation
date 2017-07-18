function loadFile(file, done) {
    $.ajax({
        type: 'GET',
        url: file,
        success: done,
    });
}

function loadJson(file, done) {
	$.getJSON(file, {
		format: "json"
	}, done).fail(function(err) {
		console.log(err);
	});
}