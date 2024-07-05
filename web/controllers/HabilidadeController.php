<?php

class HabilidadeController
{
    public function __construct(){
    }

    public function cadastrar() {
        AutenticacaoController::exigeSessao();

        View::renderizar('/habilidade/formulario', [], 'sistema');
    }

    public function salvar() {
        AutenticacaoController::exigeSessao();

        if (empty($_POST['id'])) {
            $habilidade = new Habilidade($_POST['habilidade']);
        } else {
            $habilidade = HabilidadeDTO::recuperar($_POST['id']);

            $habilidade->setHabilidade($_POST['habilidade']);
        }

        HabilidadeDTO::salvar($habilidade);

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

        View::renderizar('habilidade/formulario', compact('habilidade'), 'sistema');
    }
    public function excluir()
    {
        AutenticacaoController::exigeSessao();

        $habilidadeId = $_GET['id'];
        $habilidade = HabilidadeDTO::recuperar($habilidadeId);

        if (empty($habilidade)) {
            die('Habilidade não encontrada');
        }


        HabilidadeDTO::deletar($habilidade);

        header('Location: /habilidade/listar');
    }

}