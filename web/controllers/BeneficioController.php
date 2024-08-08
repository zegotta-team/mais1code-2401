<?php

class BeneficioController
{

    public function index()
    {
        if (!UsuarioController::estaLogado() && !AdminController::estaLogado()) {
            UsuarioController::exigeSessao();
        }

        $beneficios = BeneficioDTO::listar();

        $layout = AdminController::estaLogado() ? 'sistema-admin' : 'sistema-usuario';

        View::renderizar('/beneficio/index', compact('beneficios'), $layout);
    }

    public function salvar()
    {
        if (!UsuarioController::estaLogado() && !AdminController::estaLogado()) {
            UsuarioController::exigeSessao();
        }

        if (empty($_POST['id'])) {
            $beneficio = new Beneficio($_POST['beneficio']);
        } else {
            AdminController::exigeSessao();
            $beneficio = BeneficioDTO::recuperar($_POST['id']);
            $beneficio->setNome($_POST['beneficio']);
        }
        BeneficioDTO::salvar($beneficio);

        header('Location:/beneficio');
    }

    public function excluir()
    {
        AdminController::exigeSessao();

        $beneficio = BeneficioDTO::recuperar($_GET['id']);

        BeneficioDTO::deletar($beneficio);

        header("Location: /beneficio");
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

        $idBeneficio = $data['id'];
        $beneficio = BeneficioDTO::recuperar($idBeneficio);

        echo json_encode($beneficio->toArray());
    }
}