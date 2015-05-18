$(document).ready(function() {

    $('#create-task-btn').click(function() {
        $('#create-task-form').show();
    });

    $('#cancel-creating-task-btn').click(function() {
        $('#create-task-form').hide();
        clearForm($('#create-task-form'));

        return false;
    });

    $('#create-task-form').submit(function() {
        var _this = this;
        clearFormError(this);
        var data = $(this).serializeObject();
        if (!data.title || !data.description || !data.cost) {
            addFormError('Не все поля заполнены.', this);
            return false;
        }
        if (data.cost == 0) {
            addFormError('Укажите стоимость заказа.', this);
            return false;
        }
        if (data.cost.search(/^ *\d+ *$/) == -1) {
            addFormError('Введена некорректная стоимость заказа.', this);
            return false;
        }

        $(this).find('button[type=submit]').button('loading');
        $.post('/tasks/post/', data)
            .done(function(response) {
                if (response.status == 'ok') {
                    $('#cancel-creating-task-btn').click();
                    $('#money').text(response.money);
                    $('#tasks').prepend(response.html);
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