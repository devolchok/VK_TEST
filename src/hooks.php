<?php

function notFoundHook()
{
    echo renderPage('main:message_page', array(
        'title' => 'Страница не найдена',
        'message' => 'Страница не найдена',
    ));
}

function internalErrorHook()
{
    echo renderPage('main:message_page', array(
        'title' => 'Произошла ошибка',
        'message' => 'Произошла ошибка',
    ));
}

function badRequestHook()
{
    echo renderPage('main:message_page', array(
        'title' => 'Некорректный запрос',
        'message' => 'Некорректный запрос',
    ));
}