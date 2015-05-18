<?php

function addMoney($userId, $money)
{
    query('UPDATE users SET money = money + %d WHERE id = %d LIMIT 1', array($money, $userId));
}

function getMoney($userId)
{
    $result = query('SELECT money FROM users WHERE id = "%d" LIMIT 1', array($userId));
    $money = mysqli_fetch_assoc($result)['money'];

    return $money;
}