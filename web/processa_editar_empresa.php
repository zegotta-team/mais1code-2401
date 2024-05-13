<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($nomeClasse) {
    require_once "../classes/" . strtolower($nomeClasse) . ".php";
});

session_start();
if (empty($_SESSION['empresaId'])) {
    header("Location: login.php");
    die();
}

$empresa = Empresa::getById($_SESSION['empresaId']);
$empresa->setNome($_POST["nome"])
    ->setCNPJ($_POST["cnpj"])
    ->setEmail($_POST["email"])
    ->setDescricao($_POST['descricao'])
    ->setLogo($_POST['logo'])
    ->setEndereco($_POST['endereco'])
    ->salvar();

header('Location: home.php');