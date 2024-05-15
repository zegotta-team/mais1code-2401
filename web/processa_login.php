<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($nomeClasse) {
    $diretorio_raiz = dirname(__DIR__);
    $caminho_classes = realpath($diretorio_raiz . '/web/classes');

    require_once "$caminho_classes/$nomeClasse.php";
});
session_start();

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$empresa = EmpresaDTO::autenticar($usuario, $senha);

if (!empty($empresa)) {
    header('Location: home.php');
    $_SESSION['empresaId'] = $empresa->getId();
    $_SESSION['error'] = null;
} else {
    header('Location: index.php');
    $_SESSION['empresaId'] = null;
    $_SESSION['error'] = 'Falha ao autenticar';
}