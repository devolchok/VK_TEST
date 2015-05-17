<?php

function indexAction()
{
    echo renderPage('main:main_page');
}

function notFoundAction()
{
    echo renderPage('main:message_page', array(
        'title' => 'Страница не найдена',
        'message' => 'Страница не найдена',
    ));
}

function internalErrorAction()
{
    echo renderPage('main:message_page', array(
        'title' => 'Произошла ошибка',
        'message' => 'Произошла ошибка',
    ));
}

function badRequestAction()
{
    echo renderPage('main:message_page', array(
        'title' => 'Некорректный запрос',
        'message' => 'Некорректный запрос',
    ));
}