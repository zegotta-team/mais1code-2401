<?php

class CandidatoController
{
    public function processaLogin()
    {
        session_start();

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $remember = isset($_POST['remember_me']);

        if ($remember) {
            setcookie("candidato", $email, time() + 3600 * 24 * 30 * 12 * 100, '/');
        } else {
            setcookie("candidato", "", time() - 3600 , '/');
        }

        $candidato = CandidatoDTO::autenticar($email, $senha);

        if (isset($candidato)) {
            header('Location: /vaga/index');
            $_SESSION['candidato'] = $candidato;
        } else {
            header('Location: /autenticacao/');
            $_SESSION['candidato'] = null;
            FlashMessage::addMessage("Falha ao autenticar candidato! Email ou senha incorretos.", FlashMessage::FLASH_ERROR);
        }
    }

    public function cadastrar()
    {
        UsuarioController::renegaSessao();

        View::renderizar('candidato/cadastrar', [], 'login');
    }

    public function processaCadastrar()
    {
        UsuarioController::renegaSessao();

        $candidato = new Candidato($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['disponibilidade'], $_POST['sexo'], $_POST['genero'], $_POST['status'], '', '', '', '', $_POST['habilidades'], []);

        CandidatoDTO::salvar($candidato);
        FlashMessage::addMessage('Usuário/candidato cadastrado com sucesso');
        header('Location: /autenticacao');
    }

    public static function estaLogado()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return !empty($_SESSION['candidato']);
    }

    public function processaLogout()
    {
        session_start();
        session_destroy();
        header('Location: /');
    }

    public static function renegaSessao()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['candidato'])) {
            header("Location: /");
        }
    }

    public static function exigeSessao()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['candidato'])) {
            header("Location: /autenticacao");
        }
    }

    public function listar()
    {
        CandidatoController::exigeSessao();

        $vagasCandidatadas = CandidatoVagaDTO::listar($_SESSION['candidato']->getId());
        $propostas = PropostaDTO::listar('', $_SESSION['candidato']->getId());

        View::renderizar('candidato/listar', compact('vagasCandidatadas', 'propostas'), 'sistema-candidato');
    }

    public function perfil()
    {
        CandidatoController::exigeSessao();

        $candidato = CandidatoDTO::recuperar($_SESSION['candidato']->getId());
        $categorias = CategoriaHabilidadeDTO::listar();

        foreach ($categorias as $categoria) {
            $habilidades[$categoria->getNome()] = HabilidadeDTO::listar('', '', $categoria->getId());
        }

        $beneficios = BeneficioDTO::listar();

        View::renderizar('candidato/perfil', compact('candidato', 'categorias','habilidades', 'beneficios'), 'sistema-candidato');
    }

    public function vagasRecomendadas() {
        CandidatoController::estaLogado();
        $vagasCandidatadas = CandidatoVagaDTO::recuperar($_SESSION['candidato']->getId());
        $vagas= VagaDTO::listar();
        $vagasPorPercentual= [];
        $percentual= 0;

        foreach ($vagas as $vaga) {
            $candidatura = CandidatoVagaDTO::recuperar($_SESSION['candidato']->getId(),$vaga->getId()); 
            if (!empty($candidatura)) {
                continue;
            }

            $vagaHabilidades = $vaga->getHabilidades();
            $totalDeHabilidades = 0;
            $totalDeHabilidadesAtendidas = 0;

            foreach ($vagaHabilidades as $habilidadeVaga) { 
                $totalDeHabilidades = $totalDeHabilidades + 1;

                if ($_SESSION['candidato']->temHabilidadeId($habilidadeVaga->getId())) {
                    $totalDeHabilidadesAtendidas = $totalDeHabilidadesAtendidas + 1;
                }  
            }

            if ($totalDeHabilidades > 0 ) {
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
        $layout = CandidatoController::estaLogado() ? 'sistema-candidato' : 'painel-vagas';

        View::renderizar('vaga/painelRecomendado', compact('vagasPorPercentual','vagas','percentual'), $layout);
    }

    public function salvar()
    {
        CandidatoController::exigeSessao();

        $candidato = CandidatoDTO::recuperar($_SESSION['candidato']->getId());

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
            ->setBeneficios($beneficios)
        ;

        CandidatoDTO::salvar($candidato);
        FlashMessage::addMessage('Dados gravados com sucesso', FlashMessage::FLASH_SUCCESS);

        header("Location: /candidato/perfil");
    }
}