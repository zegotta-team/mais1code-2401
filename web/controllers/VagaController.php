<?php

class VagaController
{
    public function __construct()
    {
    }

    public function index()
    {
        $vagas = VagaDTO::listar('', '');
        View::renderizar('vaga/painel', compact('vagas'));
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('vaga/formulario');
    }

    public function salvar()
    {
        AutenticacaoController::exigeSessao();

        if (empty($_POST['vagaId'])) {
            $vaga = new Vaga($_SESSION['usuario']->getEmpresa(), $_POST['titulo'], $_POST['email'], $_POST['salario'], $_POST['beneficios'], $_POST['descricao'], $_POST['requisitos'], $_POST['cargaHoraria'], $_POST['status']);
        } else {
            $vaga = VagaDTO::recuperar($_POST['vagaId']);

            if (empty($vaga)) {
                die('Vaga não encontrada');
            }

            if ($_SESSION['usuario']->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
                die('Sai pilantra, a vaga não é sua');
            }

            $vaga->setTitulo($_POST['titulo'])
                ->setEmail($_POST['email'])
                ->setSalario($_POST['salario'])
                ->setBeneficios($_POST['beneficios'])
                ->setDescricao($_POST['descricao'])
                ->setRequisitos($_POST['requisitos'])
                ->setCargaHoraria($_POST['cargaHoraria'])
                ->setStatus($_POST['status']);

        }
        VagaDTO::salvar($vaga);

        header('Location: /vaga/listar');
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();

        $idVaga = $_GET['id'];
        $vaga = VagaDTO::recuperar($idVaga);

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        View::renderizar('vaga/formulario', compact('vaga'));
    }

    public function excluir()
    {
        AutenticacaoController::exigeSessao();

        $idVaga = $_GET['id'];
        $vaga = VagaDTO::recuperar($idVaga);

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        VagaDTO::deletar($vaga);

        header('Location: /vaga/listar');
    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();

        $vagas = VagaDTO::listar($_SESSION['usuario']->getEmpresa()->getId(), '');

        View::renderizar('vaga/listar', compact('vagas'));
    }

}