<?php

class EmpresaController
{

    public function __construct()
    {
    }

    public function cadastrar()
    {
        AutenticacaoController::renegaSessao();

        View::renderizar('empresa/cadastrar', [], true);
    }

    public function processaCadastrar()
    {
        AutenticacaoController::renegaSessao();

        $empresa = new Empresa($_POST['nome'], $_POST['cnpj'], $_POST['email'], $_POST['descricao'], $_POST['logo'], $_POST['endereco']);
        EmpresaDTO::salvar($empresa);

        $usuario = new Usuario($empresa, $_POST['usuarioCpf'], $_POST['usuarioNome'], $_POST['usuarioEmail'], $_POST['usuarioSenha']);
        UsuarioDTO::salvar($usuario);

        header('Location: /autenticacao');
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);

        View::renderizar('empresa/editar', compact('usuario'));
    }

    public function processaEditar()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);

        $usuario->getEmpresa()->setNome($_POST["nome"])
            ->setCNPJ($_POST["cnpj"])
            ->setEmail($_POST["email"])
            ->setDescricao($_POST['descricao'])
            ->setLogo($_POST['logo'])
            ->setEndereco($_POST['endereco']);

        EmpresaDTO::salvar($usuario->getEmpresa());

        header('Location: /vaga/listar');
    }

    public function excluir()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);

        View::renderizar('empresa/excluir', compact('usuario'));
    }

    public function processaExcluir()
    {
        AutenticacaoController::exigeSessao();
        $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);

        EmpresaDTO::deletar($usuario->getEmpresa());

        header('Location: /autenticacao/processaLogout');
    }
}