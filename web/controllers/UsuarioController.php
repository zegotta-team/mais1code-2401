<?php

class UsuarioController
{

    public function __construct()
    {
    }

    public function index() {

    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('usuario/formulario');
    }

    public function salvar()
    {
        AutenticacaoController::exigeSessao();

        if (empty($_POST['usuarioId'])) {
            $usuario = new Usuario($_SESSION['usuario']->getEmpresa(), $_POST['cpf'], $_POST['nome'], $_POST['email'], $_POST['senha']);
        } else {
            $usuario = UsuarioDTO::recuperar($_POST['usuarioId']);

            if (empty($usuario)) {
                die('Usuario não encontrado');
            }

            if ($_SESSION['usuario']->getEmpresa()->getId() !== $usuario->getEmpresa()->getId()) {
                die('Sai pilantra, o usuario não é da sua turma');
            }

            $usuario->setNome($_POST['nome'])
                ->setCpf($_POST['cpf'])
                ->setEmail($_POST['email']);

        }

        UsuarioDTO::salvar($usuario);

        header('Location: /usuario/listar');
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();

        $idUsuario = $_GET['id'];
        $usuarioEdicao = UsuarioDTO::recuperar($idUsuario);

        if (empty($usuarioEdicao)) {
            die('Usuario não encontrada');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $usuarioEdicao->getEmpresa()->getId()) {
            die('Sai pilantra, usuario não é da sua turma');
        }

        View::renderizar('usuario/formulario', compact('usuarioEdicao'));
    }

    public function trocarSenha()
    {
        AutenticacaoController::exigeSessao();

        $idUsuario = $_GET['id'];
        $usuarioAlteracao = UsuarioDTO::recuperar($idUsuario);

        if (empty($usuarioAlteracao)) {
            die('Usuario não encontrado');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $usuarioAlteracao->getEmpresa()->getId()) {
            die('Sai pilantra, usuario não é da sua turma');
        }

        View::renderizar('usuario/trocarsenha', compact('usuarioAlteracao'));

    }

    public function salvarSenha()
    {
        AutenticacaoController::exigeSessao();

        if (!empty($_POST['usuarioId']))
        {
            $usuario = UsuarioDTO::recuperar($_POST['usuarioId']);

            if (empty($usuario)) {
                die('Usuario não encontrado');
            }

            if ($_SESSION['usuario']->getEmpresa()->getId() !== $usuario->getEmpresa()->getId()) {
                die('Sai pilantra, o usuario não é da sua turma');
            }

            $usuario->setSenha($_POST['senha']);
            UsuarioDTO::salvarSenha($usuario);

        }
        header('Location: /usuario/listar');
    }

    public function excluir()
    {
        AutenticacaoController::exigeSessao();

        $idUsuario = $_GET['id'];

        $usuarioExclusao = UsuarioDTO::recuperar($idUsuario);

        if (empty($usuarioExclusao)) {
            die('Usuario não encontrado');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $usuarioExclusao->getEmpresa()->getId()) {
            die('Sai pilantra, o usuario não é da sua turma');
        }

        UsuarioDTO::deletar($usuarioExclusao);
        header('Location: /usuario/listar');
    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();

        $usuarios = UsuarioDTO::listar($_SESSION['usuario']->getEmpresa()->getId());

        View::renderizar('usuario/listar', compact('usuarios'));
    }
}