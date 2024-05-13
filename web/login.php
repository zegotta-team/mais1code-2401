<?php
spl_autoload_register(function ($nomeClasse) {
    require_once "../classes/" . strtolower($nomeClasse) . ".php";
});

session_start();

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$empresa = Empresa::autenticar($usuario, $senha);

if (!empty($empresa)) {
    header('Location: home.php');
    $_SESSION['empresaId'] = $empresa->getId();
    $_SESSION['error'] = null;
} else {
    header('Location: index.php');
    $_SESSION['empresaId'] = null;
    $_SESSION['error'] = 'Falha ao autenticar';
}