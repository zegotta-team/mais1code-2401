<?php

class EmpresaController
{

    public function __construct()
    {
    }

    public function cadastro()
    {
        UsuarioController::renegaSessao();

        View::renderizar('empresa/cadastro', [], 'login');
    }

    public function cadastrar()
    {
        UsuarioController::renegaSessao();

        header('Location: /autenticacao');

        if (EmpresaDTO::verificaDadosExistentes($_POST['nome'], $_POST['cnpj'])) {
            FlashMessage::addMessage('Dados repetidos', FlashMessage::FLASH_ERROR);
            die();
        }

        if (!FilialDTO::verificar($_POST['filialCep'], $_POST['filialEstado'])) {

        }

        $empresa = new Empresa($_POST['nome'], $_POST['cnpj'], $_POST['email'], $_POST['descricao'], $_FILES['logo']['tmp_name'] . "|" . $_FILES['logo']['name']);
        EmpresaDTO::salvar($empresa);

        $usuario = new Usuario($empresa, $_POST['usuarioCpf'], $_POST['usuarioNome'], $_POST['usuarioEmail'], password_hash($_POST['usuarioSenha'], PASSWORD_ARGON2ID), TipoUsuarioEnum::USUARIO->value);
        UsuarioDTO::salvar($usuario);

        $filial = new Filial($empresa, $_POST['filialNome'], $_POST['filialCep'], $_POST['filialLogradouro'], $_POST['filialNumero'], $_POST['filialComplemento'], $_POST['filialBairro'], $_POST['filialCidade'], $_POST['filialEstado']);
        FilialDTO::salvar($filial);

    }

    public function edicao()
    {
        UsuarioController::exigeSessao();

        $empresa = EmpresaDTO::recuperar($_SESSION['usuario']->getEmpresa()->getId());

        View::renderizar('empresa/edicao', compact('empresa'));
    }

    public function editar()
    {
        UsuarioController::exigeSessao();

        $empresa = EmpresaDTO::recuperar($_SESSION['usuario']->getEmpresa()->getId());

        $empresa->setNome($_POST["nome"])
            ->setCNPJ($_POST["cnpj"])
            ->setEmail($_POST["email"])
            ->setDescricao($_POST['descricao']);

        if (!empty($_FILES['logo']['tmp_name']) && $_FILES['logo']['error'] === 0) {
            $empresa->setLogo($_FILES['logo']['tmp_name'] . "|" . $_FILES['logo']['name']);
        }

        EmpresaDTO::salvar($empresa);
        FlashMessage::addMessage('Dados atualizados com sucesso', FlashMessage::FLASH_SUCCESS);

        header('Location: /empresa/edicao');
    }

    public function exclusao()
    {
        UsuarioController::exigeSessao();

        View::renderizar('empresa/exclusao');
    }

    public function excluir()
    {
        UsuarioController::exigeSessao();

        EmpresaDTO::deletar($_SESSION['usuario']->getEmpresa());

        header('Location: /');
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

        $id_empresa = $data['id'];
        $empresa = EmpresaDTO::recuperar($id_empresa);

        echo json_encode($empresa->toArray());
    }

    public function informacoes()
    {
        $layout = 'painel-vagas';
        if (CandidatoController::estaLogado()) {
            $layout = 'sistema-candidato';
        } elseif (UsuarioController::estaLogado()) {
            $layout = 'sistema-usuario';
        }

        $empresaId = $_GET['id'];
        $empresa = EmpresaDTO::recuperar($empresaId);

        $depoimentos = DepoimentoDTO::listar($empresaId);
        $candidatos = array_map(function ($depoimento) {
            return CandidatoDTO::recuperar($depoimento->getCandidatoId());
        }, $depoimentos);

        $todasAsVagas = VagaDTO::listar($empresaId);

        $vagas = array_filter(array_map(function ($vaga) {
            if ($vaga->getStatus() === VagaStatusEnum::Ativa->value) {
                return $vaga;
            }
            return null;
        }, $todasAsVagas));

        $vagas_fechadas = array_map(function ($vaga) {
            $contratacoes = CandidatoVagaDTO::listar('', $vaga->getId(), CandidatoVagaStatusEnum::Contratado->value);
            if (count($contratacoes) > 0) {
                return 1;
            }
            return null;
        }, $todasAsVagas);

        $contratacoes = array_sum(array_map(function ($vaga) {
            return count(CandidatoVagaDTO::listar('', $vaga->getId(), CandidatoVagaStatusEnum::Contratado->value));
        }, $todasAsVagas));

        $mediaAvaliacao = array_map(function ($depoimento) {
            return $depoimento->getAvaliacao();
        }, $depoimentos);

        $dados = [
            'vagas_abertas' => count($todasAsVagas),
            'vagas_fechadas' => count(array_filter($vagas_fechadas)),
            'media_avaliacao' => array_sum($mediaAvaliacao) / count($mediaAvaliacao),
            'contratacoes' => $contratacoes,
        ];

        View::renderizar('empresa/informacoes', compact('empresa', 'dados', 'depoimentos', 'candidatos', 'vagas'), $layout);
    }


}
