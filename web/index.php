<?php

define('ROOT_PATH', realpath(__DIR__.'/..'));

require(ROOT_PATH.'/app/bootstrap.php');

$routes = require(ROOT_PATH.'/app/routes.php');

try {
    run($_SERVER['REQUEST_URI'], $routes);
}
catch(Exception $e) {
    error_log($e->getMessage());
    httpInternalError();
}
