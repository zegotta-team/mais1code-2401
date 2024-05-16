<?php
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

$empresa = EmpresaDTO::getById($_SESSION['empresaId']);
$usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

$usuarioEdicao = UsuarioDTO::getById($idUsuario);

if (empty($usuarioEdicao)) {
    die('Usuario não encontrada');
}

if ($empresa->getId() !== $usuarioEdicao->getEmpresa()->getId()) {
    die('Sai pilantra, usuario não é da sua turma');
}

require 'view/editar_usuario.phtml';