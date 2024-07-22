<?php

class HabilidadeController
{
    public function __construct()
    {
    }

    public function cadastrar()
    {
        UsuarioController::exigeSessao();

        $categorias = CategoriaHabilidadeDTO::listar();

        View::renderizar('/habilidade/formulario', compact('categorias'), 'sistema-usuario');
    }

    public function salvar()
    {
        UsuarioController::exigeSessao();

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
        UsuarioController::exigeSessao();

        $habilidade = HabilidadeDTO::listar();

        View::renderizar('/habilidade/listar', compact('habilidade'), 'sistema-usuario');
    }

    public function editar()
    {
        UsuarioController::exigeSessao();

        $habilidadeId = $_GET['id'];
        $habilidade = HabilidadeDTO::recuperar($habilidadeId);

        $categorias = CategoriaHabilidadeDTO::listar();

        View::renderizar('habilidade/formulario', compact('habilidade', 'categorias'), 'sistema-usuario');
    }

    public function excluir()
    {
        UsuarioController::exigeSessao();

        $habilidade = HabilidadeDTO::recuperar($_GET['id']);

        if (empty($habilidade)) {
            die('Habilidade não encontrada');
        }

        HabilidadeDTO::deletar($habilidade);

        header('Location: /habilidade/listar');
    }

}