<?php

require(ROOT_PATH.'/core/core_helpers.php');

/**
 * Запускает контроллер на основе URI и маршрутов.
 *
 * @param string $uri
 * @param array $routes
 */
function run($uri, $routes = array())
{
    $uri = applyRoutes($uri, $routes);
    $segments = getSegments($uri);

    $controller = !empty($segments[0]) ? $segments[0] : 'main';
    $action = !empty($segments[1]) ? $segments[1] : 'index';

    $controllerFile = ROOT_PATH.'/src/'.$controller.'/'.$controller.'_controller.php';
    if (file_exists($controllerFile)) {
        require_once($controllerFile);
        $actionFunction = $_SERVER['REQUEST_METHOD'] === 'POST' ? $action.'PostAction' : $action.'Action';
        if (function_exists($actionFunction)) {
            call_user_func_array($actionFunction, array_slice($segments, 2));
        }
        else {
            httpNotFound();
        }
    }
    else {
        httpNotFound();
    }
}

function httpNotFound()
{
    header('HTTP/1.0 404 Not Found');
    run('/main/notFound/');
}
