<?php

class FilialController
{

    public function __construct()
    {
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('filial/formulario', [], 'sistema');
    }

    public function processaCadastrar()
    {
        AutenticacaoController::exigeSessao();
        header('Location: /filial/listar');
        
        
        if (empty($_POST['filialId'])) {
            $filial = new Filial($_SESSION['usuario']->getEmpresa(), $_POST['filialNome'], $_POST['filialCep'], $_POST['filialLogradouro'], $_POST['filialNumero'], $_POST['filialComplemento'], $_POST['filialBairro'], $_POST['filialCidade'], $_POST['filialEstado']);
        } else {
            $filial = FilialDTO::recuperar($_POST['filialId']);

            if (empty($filial)) {
                die('Filial não encontrada');
            }

            if ($_SESSION['usuario']->getEmpresa()->getId() !== $filial->getEmpresa()->getId()) {
                die('Sai pilantra, a filial não é sua!');
            }

            $filial->setNome($_POST['filialNome'])
                ->setCep($_POST['filialCep'])
                ->setLogradouro($_POST['filialLogradouro'])
                ->setNumero($_POST['filialNumero'])
                ->setComplemento($_POST['filialComplemento'])
                ->setBairro($_POST['filialBairro'])
                ->setCidade($_POST['filialCidade'])
                ->setEstado($_POST['filialEstado']);
        }
        
        FilialDTO::salvar($filial);

    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();

        $filiais = FilialDTO::listar($_SESSION['usuario']->getEmpresa()->getId());

        View::renderizar('filial/listar', compact('filiais'));
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();
        
        $idFilial = $_GET['id'];
        $filial = FilialDTO::recuperar($idFilial);

        if (empty($filial)) {
            die('Filial não encontrada');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $filial->getEmpresa()->getId()) {
            die('Sai pilantra, essa filial não é sua');
        }

        View::renderizar('filial/formulario', compact('filial'));
    }

}
