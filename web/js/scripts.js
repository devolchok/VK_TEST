$(document).ready(function() {

    $('#login-form').submit(function() {
        var data = $(this).serialize();
        $.post('/auth/login/', data)
            .done(function(response) {
                if (response.status == 'ok') {
                    window.location.replace('/');
                }
            })
            .fail(function() {

            });

        return false;
    });

});