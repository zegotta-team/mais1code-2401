<?php

class UsuarioController
{

    public function __construct()
    {
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        View::renderizar('usuario/formulario', compact('usuario'));
    }

    public function salvar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        if (empty($_POST['usuarioId'])) {
            $usuario = new Usuario($usuario->getEmpresa(), $_POST['cpf'], $_POST['nome'], $_POST['email'], $_POST['senha']);
        } else {
            $usuario = UsuarioDTO::getById($_POST['usuarioId']);

            if (empty($usuario)) {
                die('Usuario não encontrado');
            }

            if ($usuario->getEmpresa()->getId() !== $usuario->getEmpresa()->getId()) {
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
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $idUsuario = $_GET['id'];
        $usuarioEdicao = UsuarioDTO::getById($idUsuario);

        if (empty($usuarioEdicao)) {
            die('Usuario não encontrada');
        }

        if ($usuario->getEmpresa()->getId() !== $usuarioEdicao->getEmpresa()->getId()) {
            die('Sai pilantra, usuario não é da sua turma');
        }

        View::renderizar('usuario/formulario', compact('usuario', 'usuarioEdicao'));
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
        header('Location: /usuario/listar');
    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $usuarios = UsuarioDTO::listarTodos($usuario->getEmpresa()->getId());

        View::renderizar('usuario/listar', compact('usuario', 'usuarios'));
    }
}