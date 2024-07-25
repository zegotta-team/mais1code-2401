<?php

class BeneficioController
{
    public function cadastrar()
    {
        UsuarioController::exigeSessao();

        View::renderizar('/beneficio/formulario', []);
    }

    public function processaCadastrar()
    {
        UsuarioController::exigeSessao();

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
        UsuarioController::exigeSessao();
        
        $beneficio = BeneficioDTO::listar();

        View::renderizar('/beneficio/listar', compact('beneficio'));
    }

    public function editar()
    {
        UsuarioController::exigeSessao();

        $beneficioId = $_GET['id'];

        $beneficio = BeneficioDTO::recuperar($beneficioId);

        View::renderizar('beneficio/formulario', compact('beneficio'));
    }

    public function excluir() 
    {
        UsuarioController::exigeSessao();

        $beneficio = BeneficioDTO::recuperar($_GET['id']);

        BeneficioDTO::deletar($beneficio);

        header("Location: /beneficio/listar");
    }
}