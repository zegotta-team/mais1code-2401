<?php

class HabilidadeController
{
    public function __construct()
    {
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('/habilidade/cadastrar', [], 'sistema');
    }

    public function processaCadastrar()
    {
        AutenticacaoController::exigeSessao();
        $post = $_POST['habilidade'];
        $habilidade = new Habilidade($post);
        $dados = HabilidadeDTO::salvar($habilidade);


        View::renderizar('/habilidade/cadastrar', [], 'sistema');
    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();

        $vagas = VagaDTO::listar($_SESSION['usuario']->getEmpresa()->getId(), '');
        $habilidades = HabilidadeDTO::listar('','vagas');


        View::renderizar('/habilidade/listar', compact('vagas'));
    }

}