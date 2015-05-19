<?php

function updateUserMoney()
{
    global $user;
    $actualMoney = getMoney($user['id']);
    $user['money'] = $actualMoney;
    updateUser('money', $actualMoney);
}