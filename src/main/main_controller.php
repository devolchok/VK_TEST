<?php

function indexAction()
{
    echo renderPage('main:mainpage');
}

function notFoundAction()
{
    echo renderPage('main:not_found_page', array('title' => 'Page not found'));
}