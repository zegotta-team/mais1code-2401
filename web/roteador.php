<?php
require_once 'autoload.php';
if (php_sapi_name() == "cli-server") {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

//echo '<pre>';
$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$requestSegments = explode('/', $requestUri);

if (empty($requestSegments[1])) {
    $requestSegments[1] = 'login';
}

$controller = ucfirst($requestSegments[0]) . "Controller";
$action = $requestSegments[1];
$params = array_slice($requestSegments, 2);

if (!file_exists(__DIR__ . "/controllers/{$controller}.php")) {
    $controller = 'AutenticacaoController';
}

require_once "controllers/{$controller}.php";
$controller = new $controller();

if (!method_exists($controller, $action)) {
    $action = 'index';
}


$controller->$action();
