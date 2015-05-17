<?php

function indexGetAction()
{
    echo renderPage('main:main_page');
}

function notFoundGetAction()
{
    echo renderPage('main:message_page', array(
        'title' => 'Страница не найдена',
        'message' => 'Страница не найдена',
    ));
}

function internalErrorGetAction()
{
    echo renderPage('main:message_page', array(
        'title' => 'Произошла ошибка',
        'message' => 'Произошла ошибка',
    ));
}

function badRequestGetAction()
{
    echo renderPage('main:message_page', array(
        'title' => 'Некорректный запрос',
        'message' => 'Некорректный запрос',
    ));
}