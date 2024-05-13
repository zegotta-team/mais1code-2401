<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($nomeClasse) {
    require_once "../classes/" . strtolower($nomeClasse) . ".php";
});

session_start();
if (empty($_SESSION['empresaId'])) {
    header("Location: logout.php");
    die();
}

$empresa = Empresa::getById($_SESSION['empresaId']);

$Vaga = new Vaga($empresa, $_POST['titulo'], $_POST['email'], $_POST['salario'], $_POST['beneficios'], $_POST['descricao'], $_POST['requisitos'], $_POST['cargaHoraria']);
$Vaga->salvar();

header('Location: home.php');