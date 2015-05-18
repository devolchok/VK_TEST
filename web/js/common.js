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