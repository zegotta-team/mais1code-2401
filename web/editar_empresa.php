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
    <form method="post" action="processa_editar_empresa.php">
        <div class="row gy-3 gy-md-4 overflow-hidden mb-2">
            <label for="nome" class="form-label col-2">Nome da empresa <span class="text-danger">*</span></label>
            <div class="col-10">
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome da Empresa" required value="<?=$empresa->getNome()?>">
            </div>
        </div>
        <div class="row gy-3 gy-md-4 overflow-hidden mb-2">
            <label for="cnpj" class="form-label col-2">CNPJ <span class="text-danger">*</span></label>
            <div class="col-10">
                <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="CNPJ" required  value="<?=$empresa->getCNPJ()?>">
            </div>
        </div>
        <div class="row gy-3 gy-md-4 overflow-hidden mb-2">
            <label for="usuario" class="form-label col-2">Usuário <span class="text-danger">*</span></label>
            <div class="col-10">
                <input readonly type="text" class="form-control" name="usuario" id="usuario" placeholder="Informe seu usuário de acesso" required value="<?=$empresa->getUsuario()?>">
            </div>
        </div>
        <div class="row gy-3 gy-md-4 overflow-hidden mb-2">
            <label for="email" class="form-label col-2">Email <span class="text-danger">*</span></label>
            <div class="col-10">
                <input type="email" class="form-control" name="email" id="email" placeholder="Informe um email válido" required value="<?=$empresa->getEmail()?>">
            </div>
        </div>
        <div class="row gy-3 gy-md-4 overflow-hidden mb-2">
            <label for="descricao" class="form-label col-2">Descrição <span class="text-danger">*</span></label>
            <div class="col-10">
                <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição" required><?=$empresa->getDescricao()?></textarea>
            </div>
        </div>
        <div class="row gy-3 gy-md-4 overflow-hidden mb-2">
            <label for="logo" class="form-label col-2">Logo <span class="text-danger">*</span></label>
            <div class="col-10">
                <input type="text" class="form-control" name="logo" id="logo" placeholder="adicione uma imagem" required value="<?=$empresa->getLogo()?>">
            </div>
        </div>
        <div class="row gy-3 gy-md-4 overflow-hidden mb-2">
            <label for="endereco" class="form-label col-2">Endereço <span class="text-danger">*</span></label>
            <div class="col-10">
                <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Digite o Endereço Atual" required value="<?=$empresa->getEndereco()?>">
            </div>
        </div>
        <div class="row gy-3 gy-md-4 overflow-hidden mb-2">
            <div class="col-12">
                <div class="d-grid">
                    <button class="btn bsb-btn-xl btn-primary" type="submit">Cadastrar</button>
                </div>
            </div>
    </form>
</div>


</body>
</html>