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
$vagas = Vaga::consultarVagas($empresa->getId(), '');

?>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mais1Code - Projeto</title>
    <?php require_once 'include.php' ?>
</head>

<body>
<?php include_once 'menu.php' ?>
<div class="container mt-2">
    <pre>
        <table class="table table-bordered table-striped table-hover caption-top">
            <caption>Minhas vagas</caption>
            <?php foreach ($vagas as $vaga) : ?>
                <tr>
                <td><?= $vaga['id'] ?></td>
                <td><?= $vaga['titulo'] ?></td>
                <td>
                    <button class="btn btn-primary btn-sm">Editar</button>
                    <button class="btn btn-primary btn-sm">Excluir</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </pre>
</div>


</body>
</html>