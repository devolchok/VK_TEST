<?php

function tasksListGetAction()
{
    $tasks = array(
        array(
            'id' => 1,
            'title' => 'task 1',
            'description' => 'task 1 description',
            'cost' => '5.00',
            'user_login' => 'hawx',
        ),
        array(
            'id' => 2,
            'title' => 'Задача 2',
            'description' => 'описание 2 задачи',
            'cost' => '2.00',
            'user_login' => 'hawx5',
        ),
        array(
            'id' => 3,
            'title' => 'Задача 3',
            'description' => 'task 3 description',
            'cost' => '19.00',
            'user_login' => 'hawx10',
        ),
    );

    echo renderPage('tasks:tasks', array(
        'tasks' => $tasks,
    ));
}

function postPostAjaxAction()
{
    global $user;
    requireParameters(array('title', 'description', 'cost'));
    load('money', 'money_queries');
    $cost = intval($_POST['cost']);
    if ($cost <= 0) {
        httpBadRequest();
    }
    $userMoney = getMoney($user['id']);
    if ($userMoney >= $cost) {
        load('tasks', 'tasks_queries');
        load('auth', 'auth_queries');
        $taskId = postTask($user['id'], $user['login'], array(
          'title' => trim($_POST['title']),
          'description' => trim($_POST['description']),
          'cost' => trim($_POST['cost']),
        ));
        callHook('moneyChanged');
        outputJson(array(
            'status' => 'ok',
            'html' => renderTemplate('tasks:task', array('task' => getTask($taskId))),
            'money' => $user['money'],
        ));
    }
    else {
        $errorMessage = 'У Вас недостаточно средств. Пополните баланс.';
        outputJson(array(
            'status' => 'error',
            'errorMessage' => $errorMessage,
        ));
    }
}