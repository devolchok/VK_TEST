<?php

define('ROOT_PATH', realpath(__DIR__.'/..'));

require(ROOT_PATH.'/app/bootstrap.php');

$routes = require(ROOT_PATH.'/app/routes.php');

run($_SERVER['REQUEST_URI'], $routes);
