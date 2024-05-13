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
        <div class="row g-3 align-items-center mb-2">
            <label for="titulo" class="col-form-label col-md-2">Título</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="titulo" id="titulo">
            </div>
        </div>
        <div class="row g-3 align-items-center mb-2">
            <label for="email" class="col-form-label col-md-2">Email</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="email" id="email">
            </div>
        </div>
        <div class="row g-3 align-items-center mb-2">
            <label for="salario" class="col-form-label col-md-2">Salário</label>
            <div class="col-md-10">
                <input type="number" class="form-control" name="salario" id="salario" min="0">
            </div>
        </div>
        <div class="row g-3 align-items-center mb-2">
            <label for="beneficios" class="col-form-label col-md-2">Benefícios</label>
            <div class="col-md-10">
<!--                <textarea class="form-control" cols="50" name="beneficios" id="beneficios"></textarea>-->
                <input type="text" class="form-control" cols="50" name="beneficios" id="beneficios">
            </div>
        </div>
        <div class="row g-3 align-items-center mb-2">
            <label for="descricao" class="col-form-label col-md-2">Descrição</label>
            <div class="col-md-10">
                <textarea class="form-control" cols="50" name="descricao" id="descricao"></textarea>
            </div>
        </div>
        <div class="row g-3 align-items-center mb-2">
            <label for="requisitos" class="col-form-label col-md-2">Requisitos</label>
            <div class="col-md-10">
                <textarea class="form-control" cols="50" name="requisitos" id="requisitos"></textarea>
            </div>
        </div>
        <div class="row g-3 align-items-center mb-2">
            <label for="cargaHoraria" class="col-form-label col-md-2">Carga horária</label>
            <div class="col-md-10">
                <input type="number" class="form-control" name="cargaHoraria" id="cargaHoraria" min="0">
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-md-12 d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                <button class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </form>
</div>


</body>
</html>