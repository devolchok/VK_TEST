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

function getDbConnection($serverName)
{
    global $config;
    if (!isset($GLOBALS['dbConnections'][$serverName])) {
        $GLOBALS['dbConnections'][$serverName] = mysqli_connect($config['db'][$serverName]['host'], $config['db'][$serverName]['username'], $config['db'][$serverName]['password'], $config['db'][$serverName]['dbname']);
        if (!$GLOBALS['dbConnections'][$serverName]) {
            throw new Exception('Can\'t connect to host '.$config['db'][$serverName]['host'].' ('.mysqli_connect_error().')');
        }
        query('SET NAMES utf8', $serverName);
    }

    return $GLOBALS['dbConnections'][$serverName];
}