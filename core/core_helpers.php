<?php

function applyRoutes($originalUri, $routes)
{
    // TODO: Маршрутизация требует улучшения
    foreach ($routes as $pattern => $uri) {
        if (preg_match('#^'.$pattern.'$#i', $originalUri)) {
            return $uri;
        }
    }

    return $originalUri;
}

function getSegments($uri)
{
    $uri = strtok($uri, '?');
    $segments = explode('/', $uri);
    array_shift($segments);

    return $segments;
}

function render($templateFilePath, $data = array())
{
    if (!file_exists($templateFilePath)) {
        throw new Exception('Template file doesn\'t exist: ' . $templateFilePath);
    }
    global $user;
    extract($data);
    ob_start();
    require($templateFilePath);
    $content = ob_get_contents();
    ob_end_clean();

    return  $content;
}

function isAjax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function callHook($hookName, $parameters = array())
{
    $hookFunction = $hookName.'Hook';
    if (function_exists($hookFunction)) {
        call_user_func_array($hookFunction, $parameters);
    }
}