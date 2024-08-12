<?php

/**
 * @noinspection PhpUnused
 */

class BeneficioController
{

    public function index()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA, TipoUsuarioEnum::ADMINISTRADOR]);

        $beneficios = BeneficioDTO::listar();

        $layout = Session::estaLogado([TipoUsuarioEnum::ADMINISTRADOR]) ? 'sistema-admin' : 'sistema-usuario';

        View::renderizar('/beneficio/index', compact('beneficios'), $layout);
    }

    public function salvar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA, TipoUsuarioEnum::ADMINISTRADOR]);

        if (empty($_POST['id'])) {
            $beneficio = new Beneficio($_POST['beneficio']);
        } else {
            Session::exigeSessao([TipoUsuarioEnum::ADMINISTRADOR]);
            $beneficio = BeneficioDTO::recuperar($_POST['id']);
            $beneficio->setNome($_POST['beneficio']);
        }
        BeneficioDTO::salvar($beneficio);

        header('Location:/beneficio');
    }

    public function excluir()
    {
        Session::exigeSessao([TipoUsuarioEnum::ADMINISTRADOR]);

        $beneficio = BeneficioDTO::recuperar($_GET['id']);

        BeneficioDTO::deletar($beneficio);

        header("Location: /beneficio");
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

        $idBeneficio = $data['id'];
        $beneficio = BeneficioDTO::recuperar($idBeneficio);

        echo json_encode($beneficio->toArray());
    }
}