<?php

define('TASK_ITEMS_PER_PAGE', 10);

function postTask($userId, $userLogin, $task)
{
    query('INSERT INTO tasks (title, description, cost, user_id, user_login) VALUES ("%s", "%s", "%s", %d, "%s")',
        array($task['title'], $task['description'], $task['cost'], $userId, $userLogin));
    return lastInsertId();
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