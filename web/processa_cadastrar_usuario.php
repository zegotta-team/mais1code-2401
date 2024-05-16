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
if (empty($_SESSION['empresaId'])) {
    header("Location: logout.php");
    die();
}

$empresa = EmpresaDTO::getById($_SESSION['empresaId']);

$Usuario = new Usuario($empresa, $_POST['cpf'], $_POST['nome'], $_POST['email'], $_POST['senha']);
UsuarioDTO::salvar($Usuario);

header('Location: listar_usuarios.php');