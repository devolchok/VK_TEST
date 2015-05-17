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

function loginPostAjaxAction()
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

function logoutGetAction()
{
    logout();
    httpRedirect('/');
}