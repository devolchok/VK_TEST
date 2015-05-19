<?php

function addMoney($userId, $money)
{
    mysqli_autocommit(getDbConnection(), false);
    query('UPDATE users SET money = money + %f WHERE id = %d LIMIT 1', array($money, $userId));
    query('UPDATE system SET money = money + %f', array($money));
    $commitResult = mysqli_commit(getDbConnection());

    if (!$commitResult) {
        httpInternalError();
    }
}

function getMoney($userId)
{
    $result = query('SELECT money FROM users WHERE id = "%d" LIMIT 1', array($userId));
    $money = mysqli_fetch_assoc($result)['money'];

    return $money;
}