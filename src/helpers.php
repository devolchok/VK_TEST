<?php

function updateUserMoney()
{
    load('money', 'money_queries');

    global $user;
    $actualMoney = getMoney($user['id']);
    $user['money'] = $actualMoney;
    updateUser('money', $actualMoney);
}