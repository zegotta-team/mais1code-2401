<?php

class EmpresaController
{

    public function __construct()
    {
    }

    public function cadastrar()
    {
        AutenticacaoController::renegaSessao();

        View::renderizar('empresa/cadastrar', [], 'cadastro-empresa');
    }

    public function processaCadastrar()
    {
        AutenticacaoController::renegaSessao();
        header('Location: /autenticacao');

        if(EmpresaDTO::verificaDadosExistentes($_POST['nome'], $_POST['cnpj']))
        {
            FlashMessage::addMessage('Dados repetidos', FlashMessage::FLASH_ERROR);
            die();
        } 
        
        if (!FilialDTO::verificar($_POST['filialCep'], $_POST['filialEstado'])){


        }

        $empresa = new Empresa($_POST['nome'], $_POST['cnpj'], $_POST['email'], $_POST['descricao'], $_POST['logo']);
        EmpresaDTO::salvar($empresa);

        $usuario = new Usuario($empresa, $_POST['usuarioCpf'], $_POST['usuarioNome'], $_POST['usuarioEmail'], password_hash($_POST['usuarioSenha'], PASSWORD_ARGON2ID),$_POST['tipo']);
        UsuarioDTO::salvar($usuario);

        $filial = new Filial($empresa, $_POST['filialNome'], $_POST['filialCep'], $_POST['filialLogradouro'], $_POST['filialNumero'], $_POST['filialComplemento'], $_POST['filialBairro'], $_POST['filialCidade'], $_POST['filialEstado']);
        FilialDTO::salvar($filial);

    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('empresa/editar');
    }

    public function processaEditar()
    {
        AutenticacaoController::exigeSessao();

        $_SESSION['usuario']->getEmpresa()
            ->setNome($_POST["nome"])
            ->setCNPJ($_POST["cnpj"])
            ->setEmail($_POST["email"])
            ->setDescricao($_POST['descricao'])
            ->setLogo($_POST['logo']);

        EmpresaDTO::salvar($_SESSION['usuario']->getEmpresa());

        header('Location: /vaga/listar');
    }

    public function excluir()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('empresa/excluir');
    }

    public function processaExcluir()
    {
        AutenticacaoController::exigeSessao();

        EmpresaDTO::deletar($_SESSION['usuario']->getEmpresa());

        header('Location: /');
    }
}
