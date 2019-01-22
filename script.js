$(document).ready(function() {
    $('#btn_send').click(
        function() {
            sendUrl();
            return false;
        }
    );
    $("#full_url").keypress(function(event){
        if (event.keyCode === 13) {
            $('#btn_send').click();
            return false;
        }
    });
});

function sendUrl() {
    $.ajax({
        url: 'save_url.php',
        type: 'POST',
        dataType: 'json',
        data: {url: $('#full_url').val()},
        success: function(response) {
            if (response.status === 'error') {
                $('#error').show();
                $('#url').hide();
                $('#message').html(response.message);
            }
            if (response.status === 'ok') {
                $('#error').hide();
                $('#url').show();
                $('#short_url').val(response.shortUrl);
            }
        }
    });
}
