<?php

class HabilidadeController
{
    public function __construct()
    {
    }

    public function index()
    {
        if (!UsuarioController::estaLogado() && !AdminController::estaLogado()) {
            UsuarioController::exigeSessao();
        }

        $layout = AdminController::estaLogado() ? 'sistema-admin' : 'sistema-usuario';

        $categorias = CategoriaHabilidadeDTO::listar();
        $habilidades = HabilidadeDTO::listar();

        View::renderizar('/habilidade/index', compact('categorias', 'habilidades'), $layout);
    }

    public function salvar()
    {
        UsuarioController::exigeSessao();

        if (empty($_POST['id'])) {
            if (!empty($_POST['categoriaNova'])) {
                $categoria = new CategoriaHabilidade($_POST['categoriaNova']);
                CategoriaHabilidadeDTO::salvar($categoria);
            } else {
                $categoria = CategoriaHabilidadeDTO::recuperar($_POST['categoria']);
            }

            $habilidade = new Habilidade($_POST['habilidade'], $categoria);
        } else {
            $habilidade = HabilidadeDTO::recuperar($_POST['id']);

            if (!empty($_POST['categoriaNova'])) {
                $categoria = new CategoriaHabilidade($_POST['categoriaNova']);
                CategoriaHabilidadeDTO::salvar($categoria);
            } else {
                $categoria = CategoriaHabilidadeDTO::recuperar($_POST['categoria']);
            }

            $habilidade->setHabilidade($_POST['habilidade'])
                ->setCategoria($categoria);
        }

        HabilidadeDTO::salvar($habilidade);

        header('Location:/habilidade');
    }

    public function editar()
    {
        UsuarioController::exigeSessao();

        $habilidadeId = $_GET['id'];
        $habilidade = HabilidadeDTO::recuperar($habilidadeId);

        $categorias = CategoriaHabilidadeDTO::listar();

        View::renderizar('habilidade/index', compact('habilidade', 'categorias'), 'sistema-usuario');
    }

    public function excluir()
    {
        UsuarioController::exigeSessao();

        $habilidade = HabilidadeDTO::recuperar($_GET['id']);

        if (empty($habilidade)) {
            die('Habilidade não encontrada');
        }

        HabilidadeDTO::deletar($habilidade);

        header('Location: /habilidade');
    }

    public function detalhes()
    {
        UsuarioController::exigeSessao();
        header('Content-type: application/json');

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (empty($data)) {
            echo json_encode([]);
            die();
        }

        $id_habilidade = $data['id'];
        $habilidade = HabilidadeDTO::recuperar($id_habilidade);

        echo json_encode($habilidade->toArray());
    }

}