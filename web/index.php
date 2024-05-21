<?php

require_once 'autoload.php';

$controller = $_GET['controller'];
$action = $_GET['action'];

$controller .= 'Controller';
require_once "controller/{$controller}.php";
$controller = new $controller();

$controller->$action();