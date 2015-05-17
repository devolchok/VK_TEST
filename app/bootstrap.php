<?php

require(ROOT_PATH.'/app/config.php');
require(ROOT_PATH.'/core/core.php');
require(ROOT_PATH.'/src/hooks.php');

session_start();

if (isAuthorized()) {
    $user = $_SESSION['user'];
}