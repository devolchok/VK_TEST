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
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isAuthorized() && !verifyCsrfToken()) {
                httpForbidden();
                exit;
            }
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

function httpForbidden()
{
    header('HTTP/1.0 403 Forbidden');
    callHook('forbidden');
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
 * Рендерит шаблон из заданного модуля.
 *
 * @param string $template. Формат: <Имя модуля>/<Имя шаблона>.
 * @param array $data
 * @return string
 * @throws Exception
 */
function renderTemplate($template, $data = array())
{
    list($module, $templateName) = explode(':', $template);
    $templateFilePath = ROOT_PATH.'/src/'.$module.'/views/'.$templateName.'.html.php';

    return render($templateFilePath, $data);
}

/**
 * Рендерит шаблон из заданного модуля в лейауте.
 *
 * @param string $template. Формат: <Имя модуля>/<Имя шаблона>.
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
    $_SESSION['csrf_token'] = generateUniqueId();
}

function updateUser($key, $value)
{
    $_SESSION['user'][$key] = $value;
}

function logout()
{
    if (verifyCsrfToken()) {
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

/**
 * Выполняет запрос к БД на заданный сервер.
 *
 * @param string $query
 * @param array $parameters
 * @param string $serverName
 * @return bool|mysqli_result
 * @throws Exception
 */
function query($query, $parameters = array(), $serverName = 'default')
{
    foreach ($parameters as &$parameter) {
        $parameter = mysqli_real_escape_string(getDbConnection($serverName), $parameter);
    }
    array_unshift($parameters, $query);
    $queryString = call_user_func_array('sprintf', $parameters);
    $result = mysqli_query(getDbConnection($serverName), $queryString);
    if (!$result) {
        throw new Exception('Db error: '.mysqli_error(getDbConnection($serverName)));
    }

    return $result;
}

function getDbConnection($serverName = 'default')
{
    global $config;
    if (!isset($GLOBALS['dbConnections'][$serverName])) {
        $GLOBALS['dbConnections'][$serverName] = mysqli_connect($config['db'][$serverName]['host'], $config['db'][$serverName]['username'], $config['db'][$serverName]['password'], $config['db'][$serverName]['dbname']);
        if (!$GLOBALS['dbConnections'][$serverName]) {
            throw new Exception('Can\'t connect to host '.$config['db'][$serverName]['host'].' ('.mysqli_connect_error().')');
        }
        query('SET NAMES utf8', array(), $serverName);
    }

    return $GLOBALS['dbConnections'][$serverName];
}

/**
 * Загружает файл из модуля.
 *
 * @param string $module
 * @param string $fileName
 * @throws Exception
 */
function load($module, $fileName)
{
    $filePath = ROOT_PATH.'/src/'.$module.'/'.$fileName.'.php';
    if (!file_exists($filePath)) {
        throw new Exception('File doesn\'t exist: ' . $filePath);
    }
    require_once($filePath);
}