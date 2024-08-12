<?php

/**
 * @noinspection PhpUnused
 */

class HabilidadeController
{
    public function index()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA, TipoUsuarioEnum::ADMINISTRADOR]);

        $layout = Session::estaLogado([TipoUsuarioEnum::ADMINISTRADOR]) ? 'sistema-admin' : 'sistema-usuario';

        $categorias = CategoriaHabilidadeDTO::listar();
        $habilidades = HabilidadeDTO::listar();

        View::renderizar('/habilidade/index', compact('categorias', 'habilidades'), $layout);
    }

    public function salvar()
    {

        Session::exigeSessao([TipoUsuarioEnum::EMPRESA, TipoUsuarioEnum::ADMINISTRADOR]);

        if (empty($_POST['id'])) {
            if (!empty($_POST['categoriaNova'])) {
                $categoria = new CategoriaHabilidade($_POST['categoriaNova']);
                CategoriaHabilidadeDTO::salvar($categoria);
            } else {
                $categoria = CategoriaHabilidadeDTO::recuperar($_POST['categoria']);
            }

            $habilidade = new Habilidade($_POST['habilidade'], $categoria);
        } else {
            Session::exigeSessao([TipoUsuarioEnum::ADMINISTRADOR]);
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
        Session::exigeSessao([TipoUsuarioEnum::ADMINISTRADOR]);

        $habilidade = HabilidadeDTO::recuperar($_GET['id']);

        if (empty($habilidade)) {
            die('Habilidade não encontrada');
        }

        HabilidadeDTO::deletar($habilidade);

        header('Location: /habilidade');
    }

    public function detalhesJson()
    {
        Session::exigeSessao([TipoUsuarioEnum::ADMINISTRADOR]);
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