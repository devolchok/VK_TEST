$(document).ready(function() {

    $('#add-money-form').submit(function() {
        var _this = this;
        clearFormError(this);
        var data = $(this).serializeObject();
        if (!data.money || data.money == 0) {
            return false;
        }
        if (data.money.search(/^ *\d+ *$/) == -1) {
            addFormError('Введена некорректная сумма.', this);
            return false;
        }
        $(this).find('button[type=submit]').button('loading');
        $.post('/money/add/', data)
            .done(function(response) {
                if (response.status == 'ok') {
                    $('#money').text(response.money);
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