<?php

function tasksListGetAction()
{
    $tasks = array(
        array(
            'id' => 1,
            'title' => 'task 1',
            'description' => 'task 1 description',
            'cost' => '5.00',
            'customer_login' => 'hawx',
        ),
        array(
            'id' => 2,
            'title' => 'Задача 2',
            'description' => 'описание 2 задачи',
            'cost' => '2.00',
            'customer_login' => 'hawx5',
        ),
        array(
            'id' => 3,
            'title' => 'Задача 3',
            'description' => 'task 3 description',
            'cost' => '19.00',
            'customer_login' => 'hawx10',
        ),
    );

    echo renderPage('tasks:tasks', array(
        'tasks' => $tasks,
    ));
}