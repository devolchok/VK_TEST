<?php

date_default_timezone_set('UTC');
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', ROOT_PATH.'/app/log/errors.log');

$config = array(
    'db' => array(
        'default' => array(
            'host' => 'localhost',
            'dbname' => 'vk_test',
            'username' => 'root',
            'password' => 'miamiheat',
        ),
    ),
);