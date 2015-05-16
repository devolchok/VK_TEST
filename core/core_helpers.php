<?php

function applyRoutes($originalUri, $routes)
{
    // TODO: Маршрутизация требует улучшения
    foreach ($routes as $pattern => $uri) {
        if (preg_match('#^'.$pattern.'#i', $originalUri)) {
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
    extract($data);
    ob_start();
    require($templateFilePath);
    $content = ob_get_contents();
    ob_end_clean();

    return  $content;
}