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
if (!empty($_SESSION['empresaId'])) {
    header("Location: login.php");
    die();
}

$empresa = new Empresa($_POST['nome'], $_POST['cnpj'], $_POST['usuario'], $_POST['email'], $_POST['senha'], $_POST['descricao'], $_POST['logo'], $_POST['endereco']);
EmpresaDTO::salvar($empresa);

header('Location: login.php');