$(document).ready(function() {

    $('#login-form').submit(function() {
        var _this = this;
        clearFormError(this);
        var data = $(this).serializeObject();
        if (!data.login || !data.password) {
            addFormError('Не все поля заполнены.', this);
            return false;
        }
        $(this).find('button[type=submit]').button('loading');
        $.post('/auth/login/', data)
            .done(function(response) {
                if (response.status == 'ok') {
                    window.location.replace('/');
                }
                else {
                    addFormError(response.errorMessage, _this);
                    $(_this).find('button[type=submit]').button('reset');
                }
            })
            .fail(function() {
                $(_this).find('button[type=submit]').button('reset');
            }
        );

        return false;
    });

    $('#registration-form').submit(function() {
        var _this = this;
        clearFormError(this);
        var data = $(this).serializeObject();
        if (!data.login || !data.password) {
            addFormError('Не все поля заполнены.', this);
            return false;
        }
        if (data.password != data.repeatedPassword) {
            addFormError('Пароли не совпадают.', this);
            return false;
        }
        $(this).find('button[type=submit]').button('loading');
        $.post('/auth/register/', data)
            .done(function(response) {
                if (response.status == 'ok') {
                    $('#page-content').text(response.successMessage);
                }
                else {
                    addFormError(response.errorMessage, _this);
                }
            })
            .always(function() {
                $(_this).find('button[type=submit]').button('reset');
            }
        );

        return false;
    });

});