<div class="panel panel-default task" data-task-id="<?php echo $task['id']; ?>">
    <div class="panel-heading"><?php echo htmlspecialchars($task['title']); ?></div>

    <div class="panel-body">
        <?php echo nl2br(htmlspecialchars($task['description'])); ?>
    </div>

    <div class="panel-footer">
        <div class="pull-left">
            <span class="text-muted">Стоимость:</span> <span class="label label-primary"><?php echo $task['cost']; ?></span>
            &nbsp;
            <span class="text-muted">Автор:</span> <span class="label label-default"><?php echo $task['user_login']; ?></span>
        </div>
        <?php if ($user['type'] == 'performer') : ?>
            <button type="button" class="btn btn-primary btn-xs pull-right" data-loading-text="Загрузка...">Выполнить</button>
        <?php endif; ?>
        <div class="clearfix"></div>
    </div>
</div>