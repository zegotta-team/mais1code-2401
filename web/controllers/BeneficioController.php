<?php

class BeneficioController
{
    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('/beneficio/formulario', [], 'sistema');
    }

    public function processaCadastrar()
    {
        AutenticacaoController::exigeSessao();

        if(empty($_POST['id'])){
            $beneficio = new Beneficio($_POST['beneficio']);
        } else {
            $beneficio = BeneficioDTO::recuperar($_POST['id']);
            $beneficio->setNome($_POST['beneficio']);
        }

        BeneficioDTO::salvar($beneficio);
        
        header('Location:/beneficio/listar');
    }
    

    public function listar()
    {
        AutenticacaoController::exigeSessao();
        
        $beneficio = BeneficioDTO::listar();

        View::renderizar('/beneficio/listar', compact('beneficio'), 'sistema');
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();

        $beneficioId = $_GET['id'];

        $beneficio = BeneficioDTO::recuperar($beneficioId);

        View::renderizar('beneficio/formulario', compact('beneficio'), 'sistema');
    }

    public function excluir() 
    {
        AutenticacaoController::exigeSessao();

        $beneficio = BeneficioDTO::recuperar($_GET['id']);

        BeneficioDTO::deletar($beneficio);
    }
}