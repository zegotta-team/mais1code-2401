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

$idUsuario = $_GET['id'];

$usuarioExclusao = UsuarioDTO::getById($idUsuario);

$empresa = EmpresaDTO::getById($_SESSION['empresaId']);

if (empty($usuarioExclusao)){
    die('Usuario não encontrado');
}

if ($empresa->getId() !== $usuarioExclusao->getEmpresa()->getId()){
    die('Sai pilantra, o usuario não é da sua turma');
}

UsuarioDTO::delete($usuarioExclusao);
header('Location: listar_usuarios.php');