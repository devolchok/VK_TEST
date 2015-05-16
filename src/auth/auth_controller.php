<?php

function registrationAction()
{
    echo renderPage('auth:registration', array(
        'title' => 'Регистрация',
    ));
}

function loginAction()
{
    echo renderPage('auth:login', array(
        'title' => 'Вход',
    ));
}