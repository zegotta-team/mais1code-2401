<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><?= $empresa->getNome() ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class="nav-link mx-2 active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link mx-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Empresa
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="editar_empresa.php">Editar</a></li>
                        <li><a class="dropdown-item" href="remover_empresa.php">Excluir conta</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link mx-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Vagas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="cadastrar_vaga.php">Cadastrar</a></li>
                        <li><a class="dropdown-item" href="editar_vaga.php">Editar</a></li>
                        <li><a class="dropdown-item" href="remover_vaga.php">Excluir</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2" aria-current="page" href="logout.php">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>