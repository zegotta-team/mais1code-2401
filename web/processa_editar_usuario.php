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
$usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

$usuarioEdicao = UsuarioDTO::getById($_POST['usuarioId']);

if (empty($usuarioEdicao)) {
    die('Usuario não encontrado');
}

if ($empresa->getId() !== $usuarioEdicao->getEmpresa()->getId()) {
    die('Sai pilantra, o usuario não é da sua turma');
}

$usuarioEdicao->setNome($_POST['nome'])
    ->setCpf($_POST['cpf'])
    ->setEmail($_POST['email']);

UsuarioDTO::salvar($usuarioEdicao);

header('Location: listar_usuarios.php');