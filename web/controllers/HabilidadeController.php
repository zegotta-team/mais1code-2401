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

        if (!UsuarioController::estaLogado() && !AdminController::estaLogado()) {
            UsuarioController::exigeSessao();
        }

        if (empty($_POST['id'])) {
            if (!empty($_POST['categoriaNova'])) {
                $categoria = new CategoriaHabilidade($_POST['categoriaNova']);
                CategoriaHabilidadeDTO::salvar($categoria);
            } else {
                $categoria = CategoriaHabilidadeDTO::recuperar($_POST['categoria']);
            }

            $habilidade = new Habilidade($_POST['habilidade'], $categoria);
        } else {
            AdminController::exigeSessao();
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

    public function excluir()
    {
        AdminController::exigeSessao();

        $habilidade = HabilidadeDTO::recuperar($_GET['id']);

        if (empty($habilidade)) {
            die('Habilidade não encontrada');
        }

        HabilidadeDTO::deletar($habilidade);

        header('Location: /habilidade');
    }

    public function detalhes()
    {
        AdminController::exigeSessao();
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