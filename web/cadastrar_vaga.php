<?php
spl_autoload_register(function ($nomeClasse) {
    require_once "../classes/" . strtolower($nomeClasse) . ".php";
});

session_start();
if (empty($_SESSION['empresaId'])) {
    header("Location: logout.php");
    die();
}

$empresa = Empresa::getById($_SESSION['empresaId']);

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
    <form method="post" action="processa_cadastrar_vaga.php">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="titulo" class="col-form-label">Título</label>
            </div>
            <div class="col-auto">
                <input type="text" class="form-control" name="titulo" id="titulo">
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="email" class="col-form-label">Email</label>
            </div>
            <div class="col-auto">
                <input type="text" class="form-control" name="email" id="email">
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="salario" class="col-form-label">Salario</label>
            </div>
            <div class="col-auto">
                <input type="text" class="form-control" name="salario" id="salario">
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="beneficios" class="col-form-label">Beneficios</label>
            </div>
            <div class="col-auto">
                <textarea class="form-control" cols="50" name="beneficios" id="beneficios"></textarea>
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="descricao" class="col-form-label">Descrição</label>
            </div>
            <div class="col-auto">
                <textarea class="form-control" cols="50" name="descricao" id="descricao"></textarea>
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="requisitos" class="col-form-label">Requisitos</label>
            </div>
            <div class="col-auto">
                <textarea class="form-control" cols="50" name="requisitos" id="requisitos"></textarea>
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="cargaHoraria" class="col-form-label">Carga horária</label>
            </div>
            <div class="col-auto">
                <input type="text" class="form-control" name="cargaHoraria" id="cargaHoraria">
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <button class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </form>
</div>


</body>
</html>