<?php

/**
 * @noinspection PhpUnused
 */

class FilialController
{
    public function index()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $filiais = FilialDTO::listar(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId());

        View::renderizar('filial/index', compact('filiais'));
    }

    public function salvar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);
        header('Location: /filial');

        if (empty($_POST['filialId'])) {
            $filial = new Filial(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa(), $_POST['filialNome'], $_POST['filialCep'], $_POST['filialLogradouro'], $_POST['filialNumero'], $_POST['filialComplemento'], $_POST['filialBairro'], $_POST['filialCidade'], $_POST['filialEstado']);
        } else {
            $filial = FilialDTO::recuperar($_POST['filialId']);

            if (empty($filial)) {
                die('Filial não encontrada');
            }

            if (Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId() !== $filial->getEmpresa()->getId()) {
                die('Sai pilantra, a filial não é sua!');
            }

            $filial->setNome($_POST['filialNome'])
                ->setCep($_POST['filialCep'])
                ->setLogradouro($_POST['filialLogradouro'])
                ->setNumero($_POST['filialNumero'])
                ->setComplemento($_POST['filialComplemento'])
                ->setBairro($_POST['filialBairro'])
                ->setCidade($_POST['filialCidade'])
                ->setEstado($_POST['filialEstado']);
        }

        FilialDTO::salvar($filial);

    }

    public function editar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $idFilial = $_GET['id'];
        $filial = FilialDTO::recuperar($idFilial);

        if (empty($filial)) {
            die('Filial não encontrada');
        }

        if (Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId() !== $filial->getEmpresa()->getId()) {
            die('Sai pilantra, essa filial não é sua');
        }

        View::renderizar('filial/index', compact('filial'));
    }

    public function excluir()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $filialId = $_GET['id'];

        $filialExclusao = FilialDTO::recuperar($filialId);

        if (empty($filialExclusao)) {
            die('Filial não encontrada');
        }

        if (Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId() !== $filialExclusao->getEmpresa()->getId()) {
            die('Sai pilantra, está filial não é sua');
        }

        FilialDTO::deletar($filialExclusao);
        header('Location: /filial/');
    }

    public function detalhesJson() {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);
        header('Content-type: application/json');

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (empty($data)){
            echo json_encode([]);
            die();
        }

        $idFilial = $data['id'];
        $filial = FilialDTO::recuperar($idFilial);

        echo json_encode($filial->toArray());
    }

}
