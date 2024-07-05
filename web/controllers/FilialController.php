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

    public function listar()
    {
        AutenticacaoController::exigeSessao();

        $filial = FilialDTO::listar($_SESSION['usuario']->getEmpresa()->getId(),'');

        View::renderizar('filial/listar', compact('filial'));
    }

}
