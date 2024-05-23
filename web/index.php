<?php

require_once 'autoload.php';

$controller = $_GET['controller'] ?? 'Autenticacao' ;
$action = $_GET['action'] ?? 'login';

$controller .= 'Controller';
require_once "controllers/{$controller}.php";
$controller = new $controller();

$controller->$action();