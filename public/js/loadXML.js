function loadXML(file) {
    var ans;
    $.ajax({
        async: false,
        type: 'GET',
        url: file,
        success: function(data) {
            ans = data;
        }
    });
    return ans;
}