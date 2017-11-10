$(document).ready(function() {

    $("#click").click(function () {
        var url = $('input[name="url"]').val();
        var shortUrl = $('input[name="shortUrl"]').val();

        $.ajax({
            url: 'short.php',
            type: 'post',
            data: {
                'url': url,
                'shortUrl': shortUrl
            },
            success: function (data) {
                var found = data.includes('Error:');

                if (found == true) {
                    $(".error").remove();
                    $(".success").remove();
                    $(".authform").append('<div class="error"></div>');
                    $(".error").hide().fadeIn(500).html(data);
                } else {
                    $(".error").remove();
                    $(".success").remove();
                    $(".authform").append('<div class="success"></div>');
                    $(".success").hide().fadeIn(500).html(data);
                }
            }
        });
    });
});

