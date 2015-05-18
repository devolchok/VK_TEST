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

function handleAjaxError() {
    flashMessage('Произошла ошибка.', 'danger');
}

function flashMessage(errorMessage, type) {
    var $flashMessage = $('<div class="alert alert-' + type + ' flash-message">' + errorMessage + '</div>');
    $('body').append($flashMessage);
    setTimeout(function() {
        $flashMessage.remove();
    }, 3000);
}

function addFormError(errorMessage, form) {
    $(form).prepend('<p class="alert alert-danger">' + errorMessage + '</p>')
}

function clearFormError(form) {
    $(form).find('.alert').remove();
}

$(document).ajaxError(function(e, jqXHR) {
    handleAjaxError();
});

$.ajaxSetup({
    cache: false,
    timeout: 10000,
    dataType: 'json'
});

$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};