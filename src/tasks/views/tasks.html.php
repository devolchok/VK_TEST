<?php if ($user['type'] == 'customer') : ?>
    <button type="button" class="btn btn-primary" data-loading-text="Загрузка..." id="create-task-btn">Создать заказ</button>
    <br><br>

    <form class="form-horizontal" method="post" id="create-task-form">
        <div class="form-group">
            <label for="inputTitle" class="col-sm-2 control-label">Заголовок</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputTitle" placeholder="Заголовок" name="title" maxlength="255">
            </div>
        </div>
        <div class="form-group">
            <label for="inputDescription" class="col-sm-2 control-label">Описание</label>
            <div class="col-sm-10">
                <textarea rows="5" type="password" class="form-control" id="inputDescription" placeholder="Описание" name="description" maxlength="6000"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCost" class="col-sm-2 control-label">Стоимость</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="text" class="form-control" id="inputCost" placeholder="0" name="cost" maxlength="7">
                    <div class="input-group-addon">.00</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-primary" data-loading-text="Загрузка..." id="post-task-btn">Отправить</button>
                <button class="btn btn-default" id="cancel-creating-task-btn">Отмена</button>
            </div>
        </div>
    </form>

<?php endif; ?>

<?php foreach ($tasks as $task) : ?>
    <?php echo renderTemplate('tasks:task', array('task' => $task)); ?>
<?php endforeach; ?>

<br>
<button class="btn btn-default center-block" type="submit" data-loading-text="Загрузка..." id="load-tasks-btn">Загрузить еще</button>