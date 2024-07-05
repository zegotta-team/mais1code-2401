<?php

class FilialController
{

    public function __construct()
    {
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('filial/cadastrar', [], 'sistema');
    }

    public function processaCadastrar()
    {
        AutenticacaoController::exigeSessao();
        header('Location: /autenticacao');
        
        $filial = new Filial($_SESSION['usuario']->getEmpresa(), $_POST['filialNome'], $_POST['filialCep'], $_POST['filialLogradouro'], $_POST['filialNumero'], $_POST['filialComplemento'], $_POST['filialBairro'], $_POST['filialCidade'], $_POST['filialEstado']);

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
            ->setLogo($_POST['logo'])
            ->setEndereco($_POST['endereco']);

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

        header('Location: /autenticacao/processaLogout');
    }
}
