<?php

class HabilidadeController
{
    public function __construct()
    {
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        $categorias = CategoriaHabilidadeDTO::listar();

        View::renderizar('/habilidade/formulario', compact('categorias'), 'sistema');
    }

    public function salvar()
    {
        AutenticacaoController::exigeSessao();

        if (empty($_POST['id'])) {
            if (!empty($_POST['categoriaNova'])) {
                $categoria = new CategoriaHabilidade($_POST['categoriaNova']);
                CategoriaHabilidadeDTO::salvar($categoria);
            } else{
                $categoria = CategoriaHabilidadeDTO::recuperar($_POST['categoria']);
            }

            $habilidade = new Habilidade($_POST['habilidade'], $categoria);
        } else {
            $habilidade = HabilidadeDTO::recuperar($_POST['id']);

            if (!empty($_POST['categoriaNova'])) {
                $categoria = new CategoriaHabilidade($_POST['categoriaNova']);
                CategoriaHabilidadeDTO::salvar($categoria);
            } else{
                $categoria = CategoriaHabilidadeDTO::recuperar($_POST['categoria']);
            }

            $habilidade->setHabilidade($_POST['habilidade'])
                        ->setCategoria($categoria);
        }

        HabilidadeDTO::salvar($habilidade);

        header('Location:/habilidade/listar');
    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();

        $habilidade = HabilidadeDTO::listar();

        View::renderizar('/habilidade/listar', compact('habilidade'), 'sistema');
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();

        $habilidadeId = $_GET['id'];
        $habilidade = HabilidadeDTO::recuperar($habilidadeId);

        $categorias = CategoriaHabilidadeDTO::listar();

        View::renderizar('habilidade/formulario', compact('habilidade', 'categorias'), 'sistema');
    }

    public function excluir()
    {
        AutenticacaoController::exigeSessao();

        $habilidade = HabilidadeDTO::recuperar($_GET['id']);

        if (empty($habilidade)) {
            die('Habilidade não encontrada');
        }

        HabilidadeDTO::deletar($habilidade);

        header('Location: /habilidade/listar');
    }

}