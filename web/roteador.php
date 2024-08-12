<?php

if (isset($_GET['debug']) && $_GET['debug'] === '1') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

const TITLE = 'FoodFinder Jobs';

require_once 'autoload.php';

if (php_sapi_name() === "cli-server") {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

$requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$requestSegments = explode('/', $requestUri);

if (empty($requestSegments[0])) {
    $requestSegments[0] = 'Vaga';
    if (empty($requestSegments[1])) {
        $requestSegments[1] = 'painel';
    }
}

if (empty($requestSegments[1])) {
    $requestSegments[1] = 'index';
}

$controller = ucfirst($requestSegments[0]) . "Controller";
$action = $requestSegments[1];
$params = array_slice($requestSegments, 2);

if (!file_exists(__DIR__ . "/controllers/{$controller}.php")) {
    $controller = 'ErrorController';
    $action = 'index';
}

require_once "controllers/{$controller}.php";
$controller = new $controller();

if (!method_exists($controller, $action)) {
    $controller = 'ErrorController';
    $action = 'index';
    require_once "controllers/{$controller}.php";
    $controller = new $controller();
}


$controller->$action();
