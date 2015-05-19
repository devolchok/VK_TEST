<?php

require(ROOT_PATH.'/app/config.php');
require(ROOT_PATH.'/core/core.php');
require(ROOT_PATH.'/src/hooks.php');
require(ROOT_PATH.'/src/helpers.php');

session_start();

if (isAuthorized()) {
    $user = $_SESSION['user'];
}