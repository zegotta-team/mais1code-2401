<?php

class BeneficioController
{
    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('/beneficio/cadastrar', [], 'sistema');
    }

    public function processaCadastrar()
    {
        AutenticacaoController::exigeSessao();

        if(!empty($_POST['beneficio'])){
            $beneficio = new Beneficio($_POST['beneficio']);
            BeneficioDTO::salvar($beneficio);
        }

        header('Location:/beneficio/cadastrar');
    }
}