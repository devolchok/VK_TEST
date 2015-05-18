$(document).ready(function() {

    $('#create-task-btn').click(function() {
        $('#create-task-form').show();
    });

    $('#cancel-creating-task-btn').click(function() {
        $('#create-task-form').hide();

        return false;
    });

});