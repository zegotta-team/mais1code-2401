<?php

/**
 * @noinspection PhpUnused
 */

class VagaController
{
    public function index()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $filiais = FilialDTO::listar(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId());
        $beneficios = BeneficioDTO::listar();

        $categorias = CategoriaHabilidadeDTO::listar();
        $habilidades = [];
        foreach ($categorias as $categoria) {
            $habilidades[$categoria->getNome()] = HabilidadeDTO::listar('', '', $categoria->getId());
        }


        $vagas = VagaDTO::listar(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId(), '', '', '', VagaOrdenacaoEnum::AlfabeticaCrescente);


        View::renderizar('vaga/index', compact('filiais', 'habilidades', 'categorias', 'beneficios', 'vagas'));
    }

    public function painel()
    {
        $filtro_contratacao = $_POST['filtro_contratacao'] ?? [];
        $filtro_trabalho = $_POST['filtro_trabalho'] ?? [];
        $filtro_habilidades = $_POST['filtro_habilidades'] ?? [];
        $filtro_beneficios = $_POST['filtro_beneficios'] ?? [];
        $filtro_empresas = $_POST['filtro_empresas'] ?? [];
        $filtro_estados = $_POST['filtro_estados'] ?? [];
        $filtro_hierarquia = $_POST['filtro_hierarquia'] ?? [];
        $filtro_senioridade = $_POST['filtro_senioridade'] ?? [];
        $filtro_salarioDe = $_POST['salarioDe'] ?? null;
        $filtro_salarioAte = $_POST['salarioAte'] ?? null;

        $idsContratacao = join(',', $filtro_contratacao);
        $idsTrabalho = join(',', $filtro_trabalho);
        $idsSenioridade = join(',', $filtro_senioridade);
        $idsHabilidades = join(',', $filtro_habilidades);
        $idsBeneficios = join(',', $filtro_beneficios);
        $idsHierarquia = join(',', $filtro_hierarquia);
        $nomesEstados = !empty($filtro_estados) ? "'" . join("','", $filtro_estados) . "'" : '';
        $idsEmpresas = !empty($filtro_empresas) ? "'" . join("','", $filtro_empresas) . "'" : '';

        $vagas = VagaDTO::listar(
            $idsEmpresas,
            '',
            VagaStatusEnum::Ativa->value,
            '',
            VagaOrdenacaoEnum::MaisRecente,
            $idsHierarquia,
            $idsSenioridade,
            $idsContratacao,
            $idsTrabalho,
            $nomesEstados,
            $idsHabilidades,
            $idsBeneficios,
            $filtro_salarioDe,
            $filtro_salarioAte,
        );

        $habilidades = HabilidadeDTO::listar();
        $beneficios = BeneficioDTO::listar();

        $empresas = EmpresaDTO::listar();

        $filtros_badges = [];

        foreach ($filtro_habilidades as $id_habilidade) {
            $habilidade = HabilidadeDTO::recuperar($id_habilidade);
            $filtros_badges[] = $habilidade->getHabilidade();
        }

        foreach ($filtro_beneficios as $id_beneficio) {
            $beneficio = BeneficioDTO::recuperar($id_beneficio);
            $filtros_badges[] = $beneficio->getNome();
        }

        foreach ($filtro_empresas as $id_empresa) {
            $empresa = EmpresaDTO::recuperar($id_empresa);
            $filtros_badges[] = $empresa->getNome();
        }

        $estados = EstadoEnum::forSelect();

        foreach ($filtro_estados as $indice) {
            $filtros_badges[] = $estados[$indice];
        }

        $hierarquias = NivelHierarquicoEnum::forSelect();
        foreach ($filtro_hierarquia as $indice) {
            $filtros_badges[] = $hierarquias[$indice];
        }

        $senioridades = NivelSenioridadeEnum::forSelect();
        foreach ($filtro_senioridade as $indice) {
            $filtros_badges[] = $senioridades[$indice];
        }

        $regimes_contratacao = RegimeContratacaoEnum::forSelect();
        foreach ($filtro_contratacao as $indice) {
            $filtros_badges[] = $regimes_contratacao[$indice];
        }

        $regimes_trabalho = RegimeTrabalhoEnum::forSelect();
        foreach ($filtro_trabalho as $indice) {
            $filtros_badges[] = $regimes_trabalho[$indice];
        }

        $hasMinSalario = !empty($filtro_salarioDe) && $filtro_salarioDe != 0;
        $hasMaxSalario = !empty($filtro_salarioAte) && $filtro_salarioAte != 1000000;

        if ($hasMinSalario) {
            $filtros_badges[] = 'A partir de R$' . $filtro_salarioDe;
        }

        if ($hasMaxSalario) {
            $filtros_badges[] = 'Até R$' . $filtro_salarioAte;
        }

        $layout = 'painel-vagas';
        if (Session::estaLogado([TipoUsuarioEnum::CANDIDATO])) {
            $layout = 'sistema-candidato';
        } elseif (Session::estaLogado([TipoUsuarioEnum::EMPRESA])) {
            $layout = 'sistema-usuario';
        } elseif (Session::estaLogado([TipoUsuarioEnum::ADMINISTRADOR])) {
            $layout = 'sistema-admin';
        }

        View::renderizar('vaga/painel', compact(
            'vagas',
            'habilidades',
            'beneficios',
            'empresas',
            'estados',
            'hierarquias',
            'senioridades',
            'regimes_contratacao',
            'regimes_trabalho',
            'filtro_empresas',
            'filtro_contratacao',
            'filtro_habilidades',
            'filtro_beneficios',
            'filtro_empresas',
            'filtro_estados',
            'filtro_hierarquia',
            'filtro_senioridade',
            'filtro_trabalho',
            'filtro_salarioDe',
            'filtro_salarioAte',
            'filtros_badges',
            'hasMinSalario',
            'hasMaxSalario'
        ), $layout);
    }

    public function cadastrar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $filiais = FilialDTO::listar(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId());
        $beneficios = BeneficioDTO::listar();

        $categorias = CategoriaHabilidadeDTO::listar();
        foreach ($categorias as $categoria) {
            $habilidades[$categoria->getNome()] = HabilidadeDTO::listar('', '', $categoria->getId());
        }

        View::renderizar('vaga/formulario', compact('filiais', 'habilidades', 'categorias', 'beneficios'));
    }

    public function salvar()
    {
        header('Location: /vaga/');
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $filial = FilialDTO::recuperar($_POST['filial']);

        $habilidades = [];
        if (!empty($_POST['habilidade'])) {
            foreach ($_POST['habilidade'] as $habilidadeId) {
                $habilidades[] = HabilidadeDTO::recuperar($habilidadeId);
            }
        }

        if (empty($_POST['vagaId'])) {
            $vaga = new Vaga($filial, Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa(), $_POST['titulo'], $_POST['email'], $_POST['salario'], $_POST['descricao'], $_POST['cargaHoraria'], $_POST['regimeContratacao'], $_POST['regimeTrabalho'], $_POST['nivelSenioridade'], $_POST['nivelHierarquia'], VagaStatusEnum::Ativa->value, $habilidades, []);

        } else {
            $vaga = VagaDTO::recuperar($_POST['vagaId']);

            $beneficios = [];
            foreach ($_POST['beneficio'] as $indice => $beneficioId) {
                $beneficio = BeneficioDTO::recuperar($beneficioId);
                $informacao = $_POST['informacao'][$indice];

                $vagaBeneficio = new VagaBeneficio($vaga->getId(), $beneficio->getId(), $informacao);
                $beneficios[] = $vagaBeneficio;
            }

            if (empty($vaga)) {
                FlashMessage::addMessage('Vaga não encontrada', FlashMessageType::ERROR);
                exit();
            }

            if (Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
                FlashMessage::addMessage('Sai pilantra, a vaga não é sua', FlashMessageType::ERROR);
                exit();
            }

            $vaga->setFilial($filial)
                ->setTitulo($_POST['titulo'])
                ->setEmail($_POST['email'])
                ->setSalario($_POST['salario'])
                ->setDescricao($_POST['descricao'])
                ->setCargaHoraria($_POST['cargaHoraria'])
                ->setRegimeContratacao($_POST['regimeContratacao'])
                ->setRegimeTrabalho($_POST['regimeTrabalho'])
                ->setNivelSenioridade($_POST['nivelSenioridade'])
                ->setNivelHierarquico($_POST['nivelHierarquia'])
                ->setStatus($_POST['status'])
                ->setHabilidades($habilidades)
                ->setBeneficios($beneficios);
        }

        VagaDTO::salvar($vaga);

        if (empty($_POST['vagaId'])) {
            $beneficios = [];
            foreach ($_POST['beneficio'] as $indice => $beneficioId) {
                $beneficio = BeneficioDTO::recuperar($beneficioId);
                $informacao = $_POST['informacao'][$indice];

                $vagaBeneficio = new VagaBeneficio($vaga->getId(), $beneficio->getId(), $informacao);
                $beneficios[] = $vagaBeneficio;
            }
            $vaga->setBeneficios($beneficios);
            VagaDTO::salvar($vaga);
        }

        FlashMessage::addMessage('Dados gravados com sucesso');
    }

    public function editar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $idVaga = $_GET['id'];
        $filiais = FilialDTO::listar(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId());
        $vaga = VagaDTO::recuperar($idVaga);
        $beneficios = BeneficioDTO::listar();

        $categorias = CategoriaHabilidadeDTO::listar();
        $habilidades = [];
        foreach ($categorias as $categoria) {
            $habilidades[$categoria->getNome()] = HabilidadeDTO::listar('', '', $categoria->getId());
        }

        $candidato_vagas = CandidatoVagaDTO::listar('', $vaga->getId());

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if (Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        View::renderizar('vaga/formulario', compact('vaga', 'candidato_vagas', 'filiais', 'habilidades', 'categorias', 'beneficios'));
    }

    public function excluir()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $idVaga = $_GET['id'];
        $vaga = VagaDTO::recuperar($idVaga);

        if (empty($vaga)) {
            die('Vaga não encontrada');
        }

        if (Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId() !== $vaga->getEmpresa()->getId()) {
            die('Sai pilantra, a vaga não é sua');
        }

        VagaDTO::deletar($vaga);

        header('Location: /vaga/');
    }

    public function listar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $vagas = VagaDTO::listar(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId(), '', '', '', VagaOrdenacaoEnum::AlfabeticaCrescente);

        View::renderizar('vaga/listar', compact('vagas'));
    }

    public function exibir()
    {
        Session::iniciaSessao();
        $vaga = VagaDTO::recuperar($_GET['id']);

        $habilidades = $vaga->getHabilidades();

        $habilidadesDescrita = '';

        foreach ($habilidades as $habilidade) {
            $habilidadesDescrita .= ' ' . $habilidade->getHabilidade();
        }

        $candidato_vaga = null;
        $layout = 'painel-vagas';

        if (Session::estaLogado([TipoUsuarioEnum::CANDIDATO])) {
            $candidato_vaga = CandidatoVagaDTO::recuperar(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId(), $vaga->getId());
            $layout = 'sistema-candidato';
        } elseif (Session::estaLogado([TipoUsuarioEnum::EMPRESA])) {
            $layout = 'sistema-usuario';
        }

        View::renderizar('vaga/detalhes', compact('vaga', 'candidato_vaga', 'habilidadesDescrita'), $layout);
    }

    public function desistirCandidatura()
    {
        Session::iniciaSessao();
        $dataHora = date("Y-m-d H:i:s");

        $candidatoVaga = CandidatoVagaDTO::recuperar(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())?->getId(), $_GET['id']);

        $candidatoVaga->setStatus(CandidatoVagaStatusEnum::Desistencia->value);
        $candidatoVaga->setUltimaDesistencia($dataHora);

        CandidatoVagaDTO::salvar($candidatoVaga);

        header('Location: /vaga/exibir?id=' . $_GET['id']);
    }

    public function processaCandidatura()
    {
        Session::iniciaSessao();

        $candidato = Session::get(TipoUsuarioEnum::CANDIDATO->session_key());
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
        $antigoStatus = $candidatura->getStatus(true);

        if ($resultado == 1) {
            $novoStatus = $candidatura->getStatus() < CandidatoVagaStatusEnum::Aprovado->value && $candidatura->getStatus() !== CandidatoVagaStatusEnum::Desistencia->value ? ($candidatura->getStatus() + 1) : $candidatura->getStatus();
        } else {
            $novoStatus = CandidatoVagaStatusEnum::Reprovado->value;
        }

        $candidatura->setStatus($novoStatus);
        NotificacoesController::criar($candidatura, $antigoStatus);

        CandidatoVagaDTO::salvar($candidatura);

        header('Location: /vaga/');
    }

    public function detalhesJson()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        header('Content-type: application/json');

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (empty($data)) {
            echo json_encode([]);
            die();
        }

        $id_vaga = $data['id'];
        $vaga = VagaDTO::recuperar($id_vaga);

        echo json_encode($vaga->toArray());
    }

    public function candidatosJson()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        header('Content-type: application/json');

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (empty($data)) {
            echo json_encode([]);
            die();
        }

        $id_vaga = $data['id'];

        $candidatos = CandidatoVagaDTO::listar('', $id_vaga);

        echo json_encode(array_map(function ($candidatoVaga) {
            return $candidatoVaga->toArray();
        }, $candidatos));
    }
}
