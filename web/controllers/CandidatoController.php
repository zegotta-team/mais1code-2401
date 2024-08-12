<?php

/**
 * @noinspection PhpUnused
 */

class CandidatoController
{
    public function login()
    {
        Session::iniciaSessao();

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $remember = isset($_POST['remember_me']);

        if ($remember) {
            setcookie(TipoUsuarioEnum::CANDIDATO->session_key(), $email, time() + 3600 * 24 * 30 * 12 * 100, '/');
        } else {
            setcookie(TipoUsuarioEnum::CANDIDATO->session_key(), "", time() - 3600, '/');
        }

        $candidato = CandidatoDTO::autenticar($email, $senha);

        if (isset($candidato)) {
            header("Location: " . TipoUsuarioEnum::CANDIDATO->home());
            Session::set(TipoUsuarioEnum::CANDIDATO->session_key(), $candidato);
        } else {
            header("Location: /autenticacao/?tab=" . TipoUsuarioEnum::CANDIDATO->login_tab());
            Session::clear(TipoUsuarioEnum::CANDIDATO->session_key());
            FlashMessage::addMessage("Não foi possível efetuar sua autenticação.<br>Verifique seus dados e tente novamente.", FlashMessageType::ERROR);
        }
    }

    public function cadastrar()
    {
        Session::renegaSessao([TipoUsuarioEnum::EMPRESA]);

        View::renderizar('candidato/cadastrar', [], 'login');
    }

    public function salvar()
    {
        Session::renegaSessao([TipoUsuarioEnum::EMPRESA]);

        $candidato = new Candidato($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['disponibilidade'], $_POST['sexo'], $_POST['genero'], $_POST['status'], '', '', '', '', $_POST['habilidades'], []);

        CandidatoDTO::salvar($candidato);
        FlashMessage::addMessage('Usuário/candidato cadastrado com sucesso');
        header('Location: /autenticacao');
    }

    public function listar()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);

        $vagasCandidatadas = CandidatoVagaDTO::listar(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId());
        $propostas = PropostaDTO::listar('', Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId());

        View::renderizar('candidato/listar', compact('vagasCandidatadas', 'propostas'), 'sistema-candidato');
    }

    public function perfil()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);

        $candidato = CandidatoDTO::recuperar(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId());
        $categorias = CategoriaHabilidadeDTO::listar();

        foreach ($categorias as $categoria) {
            $habilidades[$categoria->getNome()] = HabilidadeDTO::listar('', '', $categoria->getId());
        }

        $beneficios = BeneficioDTO::listar();

        View::renderizar('candidato/perfil', compact('candidato', 'categorias', 'habilidades', 'beneficios'), 'sistema-candidato');
    }

    public function vagasRecomendadas()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);

        $vagas = VagaDTO::listar();
        $vagasPorPercentual = [];
        $percentual = 0;

        foreach ($vagas as $vaga) {
            $candidatura = CandidatoVagaDTO::recuperar(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId(), $vaga->getId());
            if (!empty($candidatura)) {
                continue;
            }

            $vagaHabilidades = $vaga->getHabilidades();
            $totalDeHabilidades = 0;
            $totalDeHabilidadesAtendidas = 0;

            foreach ($vagaHabilidades as $habilidadeVaga) {
                $totalDeHabilidades = $totalDeHabilidades + 1;

                if (Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->temHabilidadeId($habilidadeVaga->getId())) {
                    $totalDeHabilidadesAtendidas = $totalDeHabilidadesAtendidas + 1;
                }
            }

            if ($totalDeHabilidades > 0) {
                $percentual = floor($totalDeHabilidadesAtendidas / $totalDeHabilidades * 100);
            } else {
                $percentual = 100;
            }

            if ($percentual < 50) {
                continue;
            }

            $vagasPorPercentual[$percentual][] = $vaga;
        }

        krsort($vagasPorPercentual);
        $layout = Session::estaLogado([TipoUsuarioEnum::CANDIDATO]) ? 'sistema-candidato' : 'painel-vagas';

        View::renderizar('vaga/painelRecomendado', compact('vagasPorPercentual', 'vagas', 'percentual'), $layout);
    }

    public function salvarPerfil()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);

        $candidato = CandidatoDTO::recuperar(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId());

        $habilidades = [];
        if (isset($_POST['habilidade'])) {
            foreach ($_POST['habilidade'] as $habilidadeId) {
                $habilidades[] = HabilidadeDTO::recuperar($habilidadeId);
            }
        }

        $beneficios = [];
        if (isset($_POST['beneficio'])) {
            foreach ($_POST['beneficio'] as $beneficioId) {
                $beneficios[] = BeneficioDTO::recuperar($beneficioId);
            }
        }

        $candidato->setRegimeTrabalho($_POST['regimeTrabalho'])
            ->setRegimeContratacao($_POST['regimeContratacao'])
            ->setNivelSenioridade($_POST['nivelSenioridade'])
            ->setNivelHierarquia($_POST['nivelHierarquia'])
            ->setHabilidades($habilidades)
            ->setBeneficios($beneficios);

        CandidatoDTO::salvar($candidato);
        FlashMessage::addMessage('Dados gravados com sucesso', FlashMessageType::SUCCESS);

        Session::set(TipoUsuarioEnum::CANDIDATO->session_key(), $candidato);

        header("Location: /candidato/perfil");
    }

    public function depoimento()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);
        $empresaId = $_GET['empresa'];
        $empresa = EmpresaDTO::recuperar($empresaId);

        if (empty($empresa)) {
            header('Location:/candidato/listar');
            die();
        }

        View::renderizar('candidato/depoimento', compact('empresa'), 'sistema-candidato');
    }

    public function salvarDepoimento()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);

        $empresaId = $_POST['empresaId'];
        $empresa = EmpresaDTO::recuperar($empresaId);

        $candidatoId = Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId();

        if (empty($empresa)) {
            header('Location:/candidato/listar');
            die();
        }

        $depoimento = new Depoimento($empresaId, $candidatoId, $_POST['depoimento'], $_POST['rating']);
        DepoimentoDTO::salvar($depoimento);

        FlashMessage::addMessage('Depoimento cadastrado com sucesso', FlashMessageType::SUCCESS);

        header('Location: /candidato/listar');
    }

    public function trocarSenha()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);

        View::renderizar('candidato/trocarsenha', [], 'sistema-candidato');
    }

    public function salvarSenha()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);

        $candidato = CandidatoDTO::recuperar(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId());
        $candidato->setSenha(password_hash($_POST['senha'], PASSWORD_ARGON2ID));
        CandidatoDTO::salvar($candidato);
        header('Location: /vaga/painel');
    }

    public function exibir()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $candidatoId = $_GET['id'] ?? null;
        $candidato = CandidatoDTO::recuperar($candidatoId);

        $candidaturas = CandidatoVagaDTO::listar($candidatoId);

        $vagas = [];

        /** @var CandidatoVaga $candidatura */
        foreach ($candidaturas as $candidatura) {
            if ($candidatura->getVaga()->getEmpresa()->getId() == Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId()) {
                $vagas[] = $candidatura->getVaga();
            }
        }

        if (empty($candidato)) {
            header('Location:/error/');
        }


        View::renderizar('candidato/exibir', compact('candidato', 'vagas'), 'sistema-usuario');
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

        $id_candidato = $data['id'];
        $candidato = CandidatoDTO::recuperar($id_candidato);

        echo json_encode($candidato->toArray());
    }
}