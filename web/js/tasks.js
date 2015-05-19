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
                    if ($('#no-tasks').size()) {
                        $('#no-tasks').remove();
                    }
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

    $('#load-tasks-btn').click(function() {
        var _this = this;
       var lastTaskId = $('#tasks .task:last').data('taskId');
        $(this).button('loading');
        $.get('/tasks/get/', {'lastTaskId' : lastTaskId})
            .done(function(response) {
                if (response.status == 'ok') {
                    if (response.html) {
                        $('#tasks').append(response.html);
                        if (response.showMoreBtn === false) {
                            $(_this).remove();
                        }
                    }
                    else {
                        $(_this).remove();
                    }
                }
            })
            .always(function() {
                $(_this).button('reset');
            }
        );
    });

    $('#tasks').on('click', '.perform-task-btn', function() {
        var _this = this;
        var $task = $(this).parents('.task:first');
        var taskId = $task.data('taskId');
        $(this).button('loading');
        $.post('/tasks/perform/', {'taskId' : taskId})
            .done(function(response) {
                if (response.status == 'ok') {
                    $('#money').text(response.money);
                    flashMessage(response.successMessage, 'success');
                    $task.fadeOut(300, function(){ $(this).remove();});
                }
            })
            .always(function() {
                $(_this).button('reset');
            }
        );
    });

});