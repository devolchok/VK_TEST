<?php

function indexAction()
{
    echo renderPage('main:main_page');
}

function notFoundAction()
{
    echo renderPage('main:message_page', array(
        'title' => 'Page not found',
        'message' => 'Not found page.',
    ));
}

function internalErrorAction()
{
    echo renderPage('main:message_page', array(
        'title' => 'Internal error',
        'message' => 'Internal error',
    ));
}