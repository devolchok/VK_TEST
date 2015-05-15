<?php

function applyRoutes($originalUri, $routes)
{
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