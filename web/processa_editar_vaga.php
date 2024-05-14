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
$vaga = VagaDTO::getById($_POST['vagaId']);

if (empty($vaga)) {
    die('Vaga não encontrada');
}

if ($empresa->getId() !== $vaga->getEmpresa()->getId()) {
    die('Sai pilantra, a vaga não é sua');
}

$vaga->setTitulo($_POST['titulo'])
    ->setEmail($_POST['email'])
    ->setSalario($_POST['salario'])
    ->setBeneficios($_POST['beneficios'])
    ->setDescricao($_POST['descricao'])
    ->setRequisitos($_POST['requisitos'])
    ->setCargaHoraria($_POST['cargaHoraria']);

VagaDTO::salvar($vaga);

header('Location: home.php');