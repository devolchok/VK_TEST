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

/**
 * Рендерит шаблон, заданный в формате <Название модуля>/<Имя шаблона>.
 *
 * @param $template
 * @param array $data
 * @return string
 * @throws Exception
 */
function renderTemplate($template, $data = array())
{
    list($module, $templateName) = explode(':', $template);
    $templateFilePath = ROOT_PATH.'/src/'.$module.'/views/'.$templateName.'.html.php';
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

/**
 * Рендерит шаблон, заданный в формате <Название модуля>/<Имя шаблона>, в лейауте.
 *
 * @param $template
 * @param array $data
 * @param null $layoutFilePath
 * @return string
 * @throws Exception
 */
function renderPage($template, $data = array(), $layoutFilePath = null)
{
    if (!$layoutFilePath) {
        $layoutFilePath  = ROOT_PATH.'/src/main/views/layout.html.php';
    }
    $content = renderTemplate($template, $data);

    return render($layoutFilePath, array(
        'title' => isset($data['title']) ? $data['title'] : '',
        'content' => $content
    ));
}