<?php
session_start();
if (!empty($_SESSION['empresaId'])) {
    header("Location: menu.php");
    die();
}
?>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mais1Code - Projeto</title>
    <?php require_once 'include.php' ?>
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-4/assets/css/login-4.css">
    <style>
        body {
            background-color: rgb(248, 249, 250) !important;
        }
    </style>
</head>

<body>
<!-- Login 4 - Bootstrap Brain Component -->
<section class="p-3 p-md-4 p-xl-5">
    <div class="container">
        <div class="card border-light-subtle shadow-sm">
            <div class="row g-0">
                <div class="col-12 col-md-6">
                    <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy" src="https://www.smallbusiness.nsw.gov.au/sites/default/files/styles/1280/public/2023-07/iStock-1492719618.jpg?itok=T1vG28Cx" alt="BootstrapBrain Logo">
                </div>
                <div class="col-12 col-md-6">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5">
                                    <h3>Nova empresa</h3>
                                </div>
                            </div>
                        </div>
                        <form action="processa_cadastrar_empresa.php" method="post">
                            <div class="row gy-3 gy-md-4 overflow-hidden">
                                <div class="col-12">
                                    <label for="nome" class="form-label">Nome da empresa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome da Empresa" required>
                                </div>
                                <div class="col-12">
                                    <label for="cnpj" class="form-label">CNPJ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="CNPJ" required>
                                </div>
                                <div class="col-12">
                                    <label for="usuario" class="form-label">Usuário <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Informe seu usuário de acesso" required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Informe um email válido" required>
                                </div>
                                <div class="col-12">
                                    <label for="senha" class="form-label">Senha <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="senha" id="senha" value="" required>
                                </div>
                                <div class="col-12">
                                    <label for="descricao" class="form-label">Descrição <span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" name="descricao" id="descricao" placeholder="Descrição" required></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="logo" class="form-label">Logo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="logo" id="logo" placeholder="adicione uma imagem" required>
                                </div>
                                <div class="col-12">
                                    <label for="endereco" class="form-label">Endereço <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Digite o Endereço Atual" required>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-primary" type="submit">Cadastrar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <hr class="mt-5 mb-4 border-secondary-subtle">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                                    Já possui cadastro? <a href="login.php" class="link-secondary text-decoration-none">Faça o login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>