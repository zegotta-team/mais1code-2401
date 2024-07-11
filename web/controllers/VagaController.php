<?php

class VagaController
{
    public function __construct()
    {
    }

    public function index()
    {
        session_start();

        $vagas = VagaDTO::listar('', '', VagaStatusEnum::Ativa->value, '', VagaOrdenacaoEnum::MaisRecente);
        $habilidades = HabilidadeDTO::listar();
        $empresas = EmpresaDTO::listar();
        
        $layout = !empty($_SESSION['candidato']) ? 'sistema-candidato' : 'painel-vagas';
        View::renderizar('vaga/painel', compact('vagas', 'habilidades', 'empresas'), $layout);
    }

    public function cadastrar()
    {
        AutenticacaoController::exigeSessao();

        $filiais = FilialDTO::listar($_SESSION['usuario']->getEmpresa()->getId());
        $habilidades = HabilidadeDTO::listar();

        View::renderizar('vaga/formulario', compact('filiais', 'habilidades'));
    }

    public function salvar()
    {
        header('Location: /vaga/listar');
        AutenticacaoController::exigeSessao();

        $filial = FilialDTO::recuperar($_POST['filial']);

        $habilidades = [];
        if (!empty($_POST['habilidade'])) {
            foreach ($_POST['habilidade'] as $habilidadeId) {
                $habilidades[] = HabilidadeDTO::recuperar($habilidadeId);
            }
        }

        if (empty($_POST['vagaId'])) {
            $vaga = new Vaga($filial, $_SESSION['usuario']->getEmpresa(), $_POST['titulo'], $_POST['email'], $_POST['salario'], $_POST['beneficios'], $_POST['descricao'], $_POST['cargaHoraria'], $_POST['regimeContratacao'], $_POST['regimeTrabalho'], $_POST['nivelSenioridade'], $_POST['nivelHierarquia'], $_POST['status'], $habilidades);
        } else {
            $vaga = VagaDTO::recuperar($_POST['vagaId']);

            if (empty($vaga)) {
                FlashMessage::addMessage('Vaga não encontrada', FlashMessage::FLASH_ERROR);
                exit();
            }

            if ($_SESSION['usuario']->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
                FlashMessage::addMessage('Sai pilantra, a vaga não é sua', FlashMessage::FLASH_ERROR);
                exit();
            }

            $vaga->setFilial($filial)
                ->setTitulo($_POST['titulo'])
                ->setEmail($_POST['email'])
                ->setSalario($_POST['salario'])
                ->setBeneficios($_POST['beneficios'])
                ->setDescricao($_POST['descricao'])
                ->setCargaHoraria($_POST['cargaHoraria'])
                ->setRegimeContratacao($_POST['regimeContratacao'])
                ->setRegimeTrabalho($_POST['regimeTrabalho'])
                ->setNivelSenioridade($_POST['nivelSenioridade'])
                ->setNivelHierarquico($_POST['nivelHierarquia'])
                ->setStatus($_POST['status'])
                ->setHabilidades($habilidades);
        }
        VagaDTO::salvar($vaga);
        FlashMessage::addMessage('Dados gravados com sucesso');


    }

    public function editar()
    {
        AutenticacaoController::exigeSessao();

        $idVaga = $_GET['id'];
        $filiais = FilialDTO::listar($_SESSION['usuario']->getEmpresa()->getId());
        $vaga = VagaDTO::recuperar($idVaga);

        $habilidades = HabilidadeDTO::listar('', '');

        $candidato_vagas = CandidatoVagaDTO::listar('', $vaga->getId());

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        View::renderizar('vaga/formulario', compact('vaga', 'candidato_vagas', 'filiais', 'habilidades'));
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

        $vagas = VagaDTO::listar($_SESSION['usuario']->getEmpresa()->getId(), '', '', '', VagaOrdenacaoEnum::AlfabeticaCrescente);

        View::renderizar('vaga/listar', compact('vagas'));
    }

    public function exibir()
    {
        session_start();
        $vaga = VagaDTO::recuperar($_GET['id']);

        $habilidades = $vaga->getHabilidades();

        $habilidadesDescrita = '';

        foreach ($habilidades as $habilidade) {
            $habilidadesDescrita .= ' ' . $habilidade->getHabilidade();

        }

        if (CandidatoController::estaLogado()) {
            $candidato_vaga = CandidatoVagaDTO::recuperar($_SESSION['candidato']->getId(), $vaga->getId());
            $layout = 'sistema-candidato';
        } else {
            $candidato_vaga = null;
            $layout = 'painel-vagas';
        }
        View::renderizar('vaga/detalhes', compact('vaga', 'candidato_vaga', 'habilidadesDescrita'), $layout);

    }

    public function desistirCandidatura()
    {
        session_start();
        $dataHora = date("Y-m-d H:i:s");

        $candidatoVaga = CandidatoVagaDTO::recuperar($_SESSION['candidato']?->getId(), $_GET['id']);

        $candidatoVaga->setStatus(CandidatoVagaStatusEnum::Desistencia->value);
        $candidatoVaga->setUltimaDesistencia($dataHora);

        CandidatoVagaDTO::salvar($candidatoVaga);

        header('Location: /vaga/exibir?id=' . $_GET['id']);
    }

    public function processaCandidatura()
    {
        session_start();

        $candidato = $_SESSION['candidato'];
        $vaga = VagaDTO::recuperar($_GET['id']);

        $historico = CandidatoVagaDTO::recuperar($candidato->getId(), $vaga->getId());
        $ultimaDesistencia = empty($historico) ? '' : $historico->getUltimaDesistencia();

        $candidatoVaga = new CandidatoVaga($candidato, $vaga, $ultimaDesistencia, CandidatoVagaStatusEnum::TriagemDeCurriculos->value);
        CandidatoVagaDTO::salvar($candidatoVaga);

        header('Location: /vaga/exibir?id=' . $_GET['id']);
    }

    public function processaMudancaDeStatus()
    {
        $candidatura = CandidatoVagaDTO::recuperar($_GET['candidatoId'], $_GET['id']);

        $resultado = $_GET['resultado'];

        if ($resultado == 1) {
            $novoStatus = $candidatura->getStatus() < CandidatoVagaStatusEnum::Aprovado->value && $candidatura->getStatus() !== CandidatoVagaStatusEnum::Desistencia->value ? ($candidatura->getStatus() + 1) : $candidatura->getStatus();
        } else {
            $novoStatus = CandidatoVagaStatusEnum::Reprovado->value;
        }

        $candidatura->setStatus($novoStatus);
        CandidatoVagaDTO::salvar($candidatura);

        header('Location: /vaga/editar?id=' . $_GET['id']);
    }

}
