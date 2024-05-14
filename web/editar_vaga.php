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

$idVaga = $_GET['id'];

$vaga = VagaDTO::getById($idVaga);
$empresa = EmpresaDTO::getById($_SESSION['empresaId']);

if (empty($vaga)) {
    die('Vaga não encontrada');
}

if ($empresa->getId() !== $vaga->getEmpresa()->getId()) {
    die('Sai pilantra, a vaga não é sua');
}

require 'view/editar_vaga.phtml';