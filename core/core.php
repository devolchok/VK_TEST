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
        $actionFunction = isAjax() ? $action.$_SERVER['REQUEST_METHOD'].'Ajax'.'Action' : $action.$_SERVER['REQUEST_METHOD'].'Action';
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
    callHook('notFound');
}

function httpInternalError()
{
    header('HTTP/1.0 500 Internal Server Error');
    callHook('internalError');
}

function httpBadRequest()
{
    header('HTTP/1.0 400 Bad Request');
    callHook('badRequest');
}

function httpRedirect($uri, $permament = false)
{
    header('Location: ' . $uri, true, $permament ? 301 : 302);
    exit;
}

function outputJson($json)
{
    header('Content-Type: application/json');
    echo json_encode($json);
}

function requireParameters($parameters)
{
    foreach ($parameters as $parameter) {
        if (empty($_REQUEST[$parameter])) {
            httpBadRequest();
        }
    }
}

/**
 * Рендерит шаблон, заданный в формате <Имя модуля>/<Имя шаблона>.
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
 * Рендерит шаблон, заданный в формате <Имя модуля>/<Имя шаблона>, в лейауте.
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

function login($user)
{
    session_regenerate_id();
    $_SESSION['user'] = $user;
    $_SESSION['user']['logout_hash'] = generateUniqueId();
}

function logout()
{
    if (isset($_GET['logout_hash']) && $_GET['logout_hash'] == $_SESSION['user']['logout_hash']) {
        session_regenerate_id();
        $_SESSION['user'] = null;
    }
}

function isAuthorized()
{
    return isset($_SESSION['user']);
}

function generateUniqueId()
{
    return md5(uniqid(mt_rand(), true)).'_'.mt_rand();
}

function query($queryString, $serverName = 'default')
{
    $result = mysqli_query(getDbConnection($serverName), $queryString);
    if (!$result) {
        throw new Exception('Db error: '.mysqli_error(getDbConnection($serverName)));
    }

    return $result;
}