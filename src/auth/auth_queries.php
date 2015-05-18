<?php

function registerUser($login, $password, $userType)
{
    query('INSERT INTO users (login, password, type) VALUES ("%s", "%s", "%s")', array($login, $password, $userType));
}

function getUserByLogin($login)
{
    $result = query('SELECT id, login, password, money, type FROM users WHERE login = "%s" LIMIT 1', array($login));
    $user = mysqli_fetch_assoc($result);

    return $user;
}

function getUserById($id)
{
    $result = query('SELECT id, login, money, type FROM users WHERE id = "%d" LIMIT 1', array($id));
    $user = mysqli_fetch_assoc($result);

    return $user;
}