<?php

class HabilidadeController
{
    public function __construct(){
    }

    public function cadastrar() {
        AutenticacaoController::exigeSessao();

        View::renderizar('/habilidade/cadastrar', [], 'sistema');
    }

    public function processaCadastrar() {
        AutenticacaoController::exigeSessao();

        if(empty($_POST['id'])){
            $habilidade = new Habilidade($_POST['habilidade']);
        }else {
            $habilidade = HabilidadeDTO::recuperar($_POST['id']);

            $habilidade->setHabilidade($_POST['habilidade']);
            HabilidadeDTO::salvar($habilidade);
        }


        header('Location:/habilidade/listar');
    }

    public function listar() {
        AutenticacaoController::exigeSessao();

        $habilidade = HabilidadeDTO::listar();

        View::renderizar('/habilidade/listar', compact('habilidade'), 'sistema');
    }
    public function editar() {
        AutenticacaoController::exigeSessao();

        $habilidadeId = $_GET['id'];
        $habilidade = HabilidadeDTO::recuperar($habilidadeId);

        View::renderizar('habilidade/cadastrar', compact('habilidade'), 'sistema');
    }

}