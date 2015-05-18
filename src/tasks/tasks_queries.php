<?php

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