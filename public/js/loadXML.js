function loadXML(file, done) {
    $.ajax({
        type: 'GET',
        url: file,
        success: done,
    });
}

function extractXML(xml, key) {
	return $(xml).find(key).text();
}