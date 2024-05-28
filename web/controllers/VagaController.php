<?php

class VagaController
{
    public function __construct()
    {
    }

    public function index(){
        AutenticacaoController::exigeSessao();
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);

        View::renderizar('vaga/formulario', compact('usuario'));
    }

    public function salvar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);

        if (empty($_POST['vagaId'])) {
            $vaga = new Vaga($usuario->getEmpresa(), $_POST['titulo'], $_POST['email'], $_POST['salario'], $_POST['beneficios'], $_POST['descricao'], $_POST['requisitos'], $_POST['cargaHoraria']);
        } else {
            $vaga = VagaDTO::recuperar($_POST['vagaId']);

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

        }
        VagaDTO::salvar($vaga);

        header('Location: /vaga/listar');
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);

        $idVaga = $_GET['id'];
        $vaga = VagaDTO::recuperar($idVaga);

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($usuario->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        View::renderizar('vaga/formulario', compact('usuario', 'vaga'));
    }

    public function excluir()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);
        $idVaga = $_GET['id'];

        $vaga = VagaDTO::recuperar($idVaga);


        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($usuario->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        VagaDTO::deletar($vaga);


        header('Location: /vaga/listar');
    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);

        $vagas = VagaDTO::listar($usuario->getEmpresa()->getId(), '');

        View::renderizar('vaga/listar', compact('usuario', 'vagas'));
    }
}