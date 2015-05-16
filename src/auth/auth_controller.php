<?php

function registrationAction()
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

function loginAction()
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

function loginPostAction()
{
    $user = array(
        'id' => 1,
        'login' => 'AsiX',
    );
    login($user);
    outputJson(array(
        'status' => 'ok'
    ));
}

function logoutAction()
{
    logout();
    httpRedirect('/');
}