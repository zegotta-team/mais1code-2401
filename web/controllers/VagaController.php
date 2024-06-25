<?php

class VagaController
{
    public function __construct()
    {
    }

    public function index()
    {
        session_start();

        if (!empty($_SESSION['candidato'])) {

            $vagas = VagaDTO::listar('', '', VagaStatusEnum::Ativa->value);
            View::renderizar('vaga/painel', compact('vagas'), 'sistema-candidato');

        } else {

            $vagas = VagaDTO::listar('', '', VagaStatusEnum::Ativa->value);
            View::renderizar('vaga/painel', compact('vagas'), 'painel-vagas');

        }
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        View::renderizar('vaga/formulario');
    }

    public function salvar()
    {
        AutenticacaoController::exigeSessao();

        if (empty($_POST['vagaId'])) {
            $vaga = new Vaga($_SESSION['usuario']->getEmpresa(), $_POST['titulo'], $_POST['email'], $_POST['salario'], $_POST['beneficios'], $_POST['descricao'], $_POST['requisitos'], $_POST['cargaHoraria'], $_POST['status']);
        } else {
            $vaga = VagaDTO::recuperar($_POST['vagaId']);

            if (empty($vaga)) {
                die('Vaga não encontrada');
            }

            if ($_SESSION['usuario']->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
                die('Sai pilantra, a vaga não é sua');
            }

            $vaga->setTitulo($_POST['titulo'])
                ->setEmail($_POST['email'])
                ->setSalario($_POST['salario'])
                ->setBeneficios($_POST['beneficios'])
                ->setDescricao($_POST['descricao'])
                ->setRequisitos($_POST['requisitos'])
                ->setCargaHoraria($_POST['cargaHoraria'])
                ->setStatus($_POST['status']);
        }
        VagaDTO::salvar($vaga);

        header('Location: /vaga/listar');
    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();

        $idVaga = $_GET['id'];
        $vaga = VagaDTO::recuperar($idVaga);

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        View::renderizar('vaga/formulario', compact('vaga'));
    }

    public function excluir()
    {
        AutenticacaoController::exigeSessao();

        $idVaga = $_GET['id'];
        $vaga = VagaDTO::recuperar($idVaga);

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        VagaDTO::deletar($vaga);

        header('Location: /vaga/listar');
    }

    public function listar()
    {
        AutenticacaoController::exigeSessao();

        $vagas = VagaDTO::listar($_SESSION['usuario']->getEmpresa()->getId(), '');

        View::renderizar('vaga/listar', compact('vagas'));
    }

    public function exibir()
    {
        session_start();

        $vaga = VagaDTO::recuperar($_GET['id']);
        if (!empty($_SESSION['candidato'])) {
            $candidato_vaga = CandidatoVagaDTO::recuperar($_SESSION['candidato']->getId(), $vaga->getId());
        } else {
            $candidato_vaga = null;
        }

        View::renderizar('vaga/detalhes', compact('vaga', 'candidato_vaga'), 'painel-vagas');
    }

    public function desistirCandidatura()
    {
        session_start();
        $dataHora = date("Y-m-d H:i:s");

        $candidatoVaga = CandidatoVagaDTO::recuperar($_SESSION['candidato']?->getId(), $_GET['id']);

        $candidatoVaga->setStatus(CandidatoVagaStatusEnum::Inativa->value);
        $candidatoVaga->setUltimaDesistencia($dataHora);

        CandidatoVagaDTO::salvar($candidatoVaga);

        header('Location: /vaga/exibir?id='.$_GET['id']);
    }

    public function processaCandidatura()
    {
        session_start();

        $candidato = $_SESSION['candidato'];
        $vaga = VagaDTO::recuperar($_GET['id']);

        $historico = CandidatoVagaDTO::recuperar($candidato->getId(), $vaga->getId());
        $ultimaDesistencia = empty($historico) ? '' : $historico->getUltimaDesistencia();

        $candidatoVaga = new CandidatoVaga($candidato, $vaga, $ultimaDesistencia, CandidatoVagaStatusEnum::Ativa->value);
        CandidatoVagaDTO::salvar($candidatoVaga);

        header('Location: /vaga/exibir?id='.$_GET['id']);
    }

}
