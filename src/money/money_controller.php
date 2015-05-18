<?php

function addGetAction()
{
    echo renderPage('money:add_money');
}

function addPostAjaxAction()
{
    global $user;
    requireParameters(array('money'));
    $money = intval($_POST['money']);
    if ($money <= 0) {
        httpBadRequest();
    }
    load('money', 'money_queries');
    addMoney($user['id'], $money);
    $actualMoney = getMoney($user['id']);
    updateUser('money', $actualMoney);
    outputJson(array(
        'status' => 'ok',
        'money' => $actualMoney,
        'successMessage' => 'Ваш счет пополнен.'
    ));
}