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
    header("Location: login.php");
    die();
}

$empresa = EmpresaDTO::getById($_SESSION['empresaId']);
$empresa->setNome($_POST["nome"])
    ->setCNPJ($_POST["cnpj"])
    ->setEmail($_POST["email"])
    ->setDescricao($_POST['descricao'])
    ->setLogo($_POST['logo'])
    ->setEndereco($_POST['endereco']);

EmpresaDTO::salvar($empresa);

header('Location: home.php');