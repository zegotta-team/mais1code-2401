<?php

class VagaController
{
    public function __construct()
    {
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        require 'view/cadastrar_vaga.phtml';
    }

    public function processaCadastrar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $Vaga = new Vaga($usuario->getEmpresa(), $_POST['titulo'], $_POST['email'], $_POST['salario'], $_POST['beneficios'], $_POST['descricao'], $_POST['requisitos'], $_POST['cargaHoraria']);
        VagaDTO::salvar($Vaga);

        header('Location: index.php?controller=Vaga&action=listar');
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $idVaga = $_GET['id'];
        $vaga = VagaDTO::getById($idVaga);

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($usuario->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        require 'view/editar_vaga.phtml';
    }

    public function processaEditar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $vaga = VagaDTO::getById($_POST['vagaId']);

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($usuario->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
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

        header('Location: index.php?controller=Vaga&action=listar');
    }

    public function excluir()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);
        $idVaga = $_GET['id'];

        $vaga = VagaDTO::getById($idVaga);


        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($usuario->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        VagaDTO::removerVagaDB($vaga);


        header('Location: index.php?controller=Vaga&action=listar');
    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $vagas = VagaDTO::consultarVagas($usuario->getEmpresa()->getId(), '');

        require 'view/lista_vagas.phtml';
    }
}