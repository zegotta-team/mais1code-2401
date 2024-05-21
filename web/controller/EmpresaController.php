<?php

class EmpresaController {

    public function __construct() {
    }

    public function cadastrar(){
        require 'renega_sessao.php';

        require 'view/cadastrar_empresa.phtml';
    }

    public function processaCadastrar() {
        AutenticacaoController::renegaSessao();

        $empresa = new Empresa($_POST['nome'], $_POST['cnpj'], $_POST['email'], $_POST['descricao'], $_POST['logo'], $_POST['endereco']);
        EmpresaDTO::salvar($empresa);

        $usuario = new Usuario($empresa, $_POST['usuarioCpf'], $_POST['usuarioNome'], $_POST['usuarioEmail'],$_POST['usuarioSenha']);
        UsuarioDTO::salvar($usuario);

        header('Location: index.php?controller=Autenticacao&action=login');
    }

    public function editar(){
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        require 'view/editar_empresa.phtml';
    }

    public function processaEditar() {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        $usuario->getEmpresa()->setNome($_POST["nome"])
            ->setCNPJ($_POST["cnpj"])
            ->setEmail($_POST["email"])
            ->setDescricao($_POST['descricao'])
            ->setLogo($_POST['logo'])
            ->setEndereco($_POST['endereco']);

        EmpresaDTO::salvar($usuario->getEmpresa());

        header('Location: index.php?controller=Vaga&action=listar');
    }

    public function excluir(){
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        require 'view/excluir_empresa.phtml';
    }

    public function processaExcluir() {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::getById($_SESSION['usuarioId']);

        EmpresaDTO::delete($usuario->getEmpresa());

        header('Location: index.php?controller=Autenticacao&action=processaLogout');
    }
}