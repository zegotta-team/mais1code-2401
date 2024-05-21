<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($nomeClasse) {
    $diretorio_raiz = dirname(__DIR__);
    $caminho_classes = realpath($diretorio_raiz . '/web/classes');
    $caminho_controllers = realpath($diretorio_raiz . '/web/controller');

    if (file_exists("$caminho_classes/$nomeClasse.php")) {
        require_once "$caminho_classes/$nomeClasse.php";
    } else {
        require_once "$caminho_controllers/$nomeClasse.php";
    }
});
