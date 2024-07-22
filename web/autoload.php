<?php

use JetBrains\PhpStorm\NoReturn;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($nomeClasse) {
    $diretorio_raiz = dirname(__DIR__);
    $diretorios = [
        "web" . DIRECTORY_SEPARATOR . "models",
        "web" . DIRECTORY_SEPARATOR . "controllers",
        "web" . DIRECTORY_SEPARATOR . "core",
        "web" . DIRECTORY_SEPARATOR . "enums",
        "web" . DIRECTORY_SEPARATOR . "traits",
    ];

    foreach ($diretorios as $diretorio) {
        $file = $diretorio_raiz . DIRECTORY_SEPARATOR . $diretorio . DIRECTORY_SEPARATOR . $nomeClasse . ".php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

});

#[NoReturn] function dd(): void
{
    $args = func_get_args();
    echo '<pre>';
    foreach ($args as $arg) {
        var_dump($arg);
    }
    echo '</pre>';
    die();
}
