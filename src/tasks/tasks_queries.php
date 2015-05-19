<?php

define('TASK_ITEMS_PER_PAGE', 10);

function postTask($userId, $userLogin, $task)
{
    mysqli_autocommit(getDbConnection(), false);
    // Добавление заказа в систему.
    query('INSERT INTO tasks (title, description, cost, user_id, user_login) VALUES ("%s", "%s", "%s", %d, "%s")',
        array($task['title'], $task['description'], $task['cost'], $userId, $userLogin));
    $taskId = mysqli_insert_id(getDbConnection());
    // Списывание средств с заказчика.
    query('UPDATE users SET money = money - %f WHERE id = %d LIMIT 1', array($task['cost'], $userId));
    $commitResult = mysqli_commit(getDbConnection());

    if (!$commitResult) {
        httpInternalError();
    }

    return $taskId;
}

function getTask($taskId)
{
    $result = query('SELECT id, title, description, cost, user_id, user_login FROM tasks WHERE id = %d LIMIT 1', array($taskId));
    $task = mysqli_fetch_assoc($result);

    return $task;
}

function getTasks($lastTaskId = 0)
{
    if ($lastTaskId) {
        $result = query('SELECT id, title, description, cost, user_id, user_login FROM tasks WHERE id < %d ORDER BY id DESC LIMIT %d', array($lastTaskId, TASK_ITEMS_PER_PAGE));}
    else {
        $result = query('SELECT id, title, description, cost, user_id, user_login FROM tasks ORDER BY id DESC LIMIT %d', array(TASK_ITEMS_PER_PAGE));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function performTask($userId, $taskId)
{
    $task = getTask($taskId);

    mysqli_autocommit(getDbConnection(), false);
    // Удаление задачи из системы.
    query('DELETE FROM tasks WHERE id = %d', array($taskId));
    // Начисление средств исполнителю (с учетом комисси).
    query('UPDATE users SET money = money + %f - %f * %f WHERE id = %d LIMIT 1', array($task['cost'], $task['cost'], $GLOBALS['config']['commission'], $userId));
    // Начисление комиссии системе.
    query('UPDATE system SET profit = profit + %f * %f', array($task['cost'], $GLOBALS['config']['commission']));
    $commitResult = mysqli_commit(getDbConnection());

    if (!$commitResult) {
        httpInternalError();
    }
}