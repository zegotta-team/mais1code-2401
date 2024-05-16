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

$email = $_POST['email'];
$senha = $_POST['senha'];

$usuario = UsuarioDTO::autenticar($email, $senha);

if (!empty($usuario)) {
    header('Location: home.php');
    $_SESSION['usuarioId'] = $usuario->getId();
    $_SESSION['empresaId'] = $usuario->getEmpresa()->getId();
    $_SESSION['error'] = null;
} else {
    header('Location: index.php');
    $_SESSION['usuarioId'] = null;
    $_SESSION['empresaId'] = null;
    $_SESSION['error'] = 'Falha ao autenticar';
}