<?php

function tasksListGetAction()
{
    load('tasks', 'tasks_queries');
    $tasks = getTasks();

    echo renderPage('tasks:tasks', array(
        'tasks' => $tasks,
        'showMoreBtn' => count($tasks) == TASK_ITEMS_PER_PAGE,
    ));
}

function getGetAjaxAction()
{
    requireParameters(array('lastTaskId'));
    $lastTaskId = intval($_GET['lastTaskId']);
    load('tasks', 'tasks_queries');
    $tasks = getTasks($lastTaskId);
    $html = '';
    foreach ($tasks as $task) {
        $html .= renderTemplate('tasks:task', array('task' => $task));
    }

    outputJson(array(
        'status' => 'ok',
        'html' => $html,
        'showMoreBtn' => count($tasks) == TASK_ITEMS_PER_PAGE
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
          'cost' => $cost,
        ));
        updateUserMoney();
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

function performPostAjaxAction()
{
    global $user;

    requireParameters(array('taskId'));
    $taskId = intval($_POST['taskId']);
    load('tasks', 'tasks_queries');
    load('money', 'money_queries');
    $money = getMoney($user['id']);
    performTask($user['id'], $taskId);
    updateUserMoney();
    outputJson(array(
        'status' => 'ok',
        'successMessage' => 'Заказ выполнен. Зачислено: '.round($user['money'] - $money, 2),
        'money' => $user['money'],
    ));
}