<?php

function registrationGetAction()
{
    if (!isAuthorized()) {
        echo renderPage('auth:registration', array(
            'title' => 'Регистрация',
        ));
    }
    else {
        httpRedirect('/');
    }
}

function loginGetAction()
{
    if (!isAuthorized()) {
        echo renderPage('auth:login', array(
            'title' => 'Вход',
        ));
    }
    else {
        httpRedirect('/');
    }
}

function registerPostAjaxAction()
{
    requireParameters(array('login', 'password', 'user_type'));

    $login = trim($_POST['login']);

    if (strlen($login) < 4) {
        $errorMessage = 'Логин должен содержать 4 и более символов.';
    }
    elseif (!preg_match('/^[a-z](_?[a-z0-9])*$/i', $login)) {
        $errorMessage = 'Логин должен содежать только латинские буквы [a-z], цифры [0-9] и знак подчеркивания [_]. Первый символ - латинская буква. Знак подчеркивания не должен встречаться два раза подряд, и не должен находиться в конце логина.';
    }
    elseif (strlen($_POST['password']) < 6) {
        $errorMessage = 'Пароль должен содержать 6 и более символов.';
    }
    elseif ($_POST['user_type'] != 'customer' && $_POST['user_type'] != 'performer') {
        httpBadRequest();
    }

    load('auth', 'auth_queries');
    if (getUserByLogin($login)) {
        $errorMessage = 'Такой логин уже занят.';
    }

    if (!isset($errorMessage)) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $userType = $_POST['user_type'];
        registerUser($login, $password, $userType);
        outputJson(array(
            'status' => 'ok',
            'successMessage' => 'Вы успешно зарегистрировались, теперь Вы можете зайти на сайт.',
        ));
    }
    else {
        outputJson(array(
            'status' => 'error',
            'errorMessage' => $errorMessage,
        ));
    }
}

function loginPostAjaxAction()
{
    requireParameters(array('login', 'password'));

    $login = trim($_POST['login']);
    load('auth', 'auth_queries');
    $user = getUserByLogin($login);
    if (!$user || !password_verify($_POST['password'], $user['password'])) {
        $errorMessage = 'Неверный логин или пароль.';
        outputJson(array(
            'status' => 'error',
            'errorMessage' => $errorMessage,
        ));
    }
    else {
        unset($user['password']);
        login($user);
        outputJson(array(
            'status' => 'ok'
        ));
    }
}

function logoutGetAction()
{
    logout();
    httpRedirect('/');
}