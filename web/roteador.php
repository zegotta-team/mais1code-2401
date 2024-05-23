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
$requestSegments = explode('/' , $requestUri);
//var_dump($requestSegments);

$controller = ucfirst($requestSegments[0])."Controller";
$action = $requestSegments[1];
$params = array_slice($requestSegments, 2);

require_once "controllers/{$controller}.php";
$controller = new $controller();

$controller->$action();
