function loadXML(file, done) {
    $.ajax({
        type: 'GET',
        url: file,
        success: done,
    });
}