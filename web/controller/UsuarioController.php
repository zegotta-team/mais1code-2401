<?php

class UsuarioController
{

    public function __construct() {
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        require 'view/cadastrar_usuario.phtml';
    }

    public function processaCadastrar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $Usuario = new Usuario($usuario->getEmpresa(), $_POST['cpf'], $_POST['nome'], $_POST['email'], $_POST['senha']);
        UsuarioDTO::salvar($Usuario);

        header('Location: index.php?controller=Usuario&action=listar');
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $idUsuario = $_GET['id'];
        $usuarioEdicao = UsuarioDTO::getById($idUsuario);

        if (empty($usuarioEdicao)) {
            die('Usuario não encontrada');
        }

        if ($usuario->getEmpresa()->getId() !== $usuarioEdicao->getEmpresa()->getId()) {
            die('Sai pilantra, usuario não é da sua turma');
        }

        require 'view/editar_usuario.phtml';
    }

    public function processaEditar()
    {

        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $usuarioEdicao = UsuarioDTO::getById($_POST['usuarioId']);

        if (empty($usuarioEdicao)) {
            die('Usuario não encontrado');
        }

        if ($usuario->getEmpresa()->getId() !== $usuarioEdicao->getEmpresa()->getId()) {
            die('Sai pilantra, o usuario não é da sua turma');
        }

        $usuarioEdicao->setNome($_POST['nome'])
            ->setCpf($_POST['cpf'])
            ->setEmail($_POST['email']);

        UsuarioDTO::salvar($usuarioEdicao);

        header('Location: index.php?controller=Usuario&action=listar');
    }

    public function excluir()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);
        $idUsuario = $_GET['id'];

        $usuarioExclusao = UsuarioDTO::getById($idUsuario);

        if (empty($usuarioExclusao)) {
            die('Usuario não encontrado');
        }

        if ($usuario->getEmpresa()->getId() !== $usuarioExclusao->getEmpresa()->getId()) {
            die('Sai pilantra, o usuario não é da sua turma');
        }

        UsuarioDTO::delete($usuarioExclusao);
        header('Location: index.php?controller=Usuario&action=listar');
    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $usuarios = UsuarioDTO::listarTodos($usuario->getEmpresa()->getId());

        require 'view/lista_usuarios.phtml';
    }
}