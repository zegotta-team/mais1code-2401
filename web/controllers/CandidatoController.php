<?php

class CandidatoController
{
    public function login()
    {
        self::renegaSessao();

        if (isset($_COOKIE['candidato'])) {
            $usuarioLembrado = $_COOKIE['candidato'];
        } else {
            $usuarioLembrado = '';
        }

        View::renderizar('candidato/login', compact('usuarioLembrado'), 'login');
    }

    public function processaLogin()
    {
        session_start();

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $remember = isset($_POST['remember_me']);

        if ($remember) {
            setcookie("candidato", $email, time() + 3600 * 24 * 30 * 12 * 100);
        } else {
            setcookie("candidato", "", time() - 3600);
        }

        $candidato = CandidatoDTO::autenticar($email, $senha);

        if (isset($candidato)) {
            header('Location: /vaga/index');
            $_SESSION['candidato'] = $candidato;
        } else {
            header('Location: /candidato/login');
            $_SESSION['candidato'] = null;
            FlashMessage::addMessage("Falha ao autenticar candidato! Email ou senha incorretos.", FlashMessage::FLASH_ERROR);
        }
    }

    public function cadastrar()
    {
        AutenticacaoController::renegaSessao();

        View::renderizar('candidato/cadastrar', [], 'cadastro-candidato');
    }

    public function processaCadastrar()
    {
        AutenticacaoController::renegaSessao();

        $candidato = new Candidato($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['habilidades'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['disponibilidade'], $_POST['sexo'], $_POST['genero'], $_POST['status'], $_POST['regimeContratacao'], $_POST['regimeTrabalho'], $_POST['nivelSenioridade'], $_POST['nivelHierarquia']);

        CandidatoDTO::salvar($candidato);
        FlashMessage::addMessage('Usuário/candidato cadastrado com sucesso');
        header('Location: /candidato/login');
    }

    public static function estaLogado()
    {
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
        session_start();
        if (!empty($_SESSION['candidato'])) {
            header("Location: /");
        }
    }

    public static function exigeSessao() 
    {
        session_start();
        if (empty($_SESSION['candidato'])) {
            header("Location: /candidato/login");
        }
    }

    public function listar() 
    {
        CandidatoController::exigeSessao();

        $vagasCandidatadas = CandidatoVagaDTO::listar($_SESSION['candidato']->getId());

        View::renderizar('candidato/listar', compact('vagasCandidatadas'), 'sistema-candidato');
    }

    public function perfil()
    {
        CandidatoController::exigeSessao();

        $candidatoId = CandidatoDTO::recuperar($_SESSION['candidato']->getId());

        View::renderizar('candidato/perfil', compact('candidatoId'), 'sistema-candidato');
    }

    public function salvar()
    {
        CandidatoController::exigeSessao();

        $candidato = CandidatoDTO::recuperar($_SESSION['candidato']->getId());

        $candidato->setRegimeTrabalho($_POST['regimeTrabalho'])
                    ->setRegimeContratacao($_POST['regimeContratacao'])
                    ->setNivelSenioridade($_POST['nivelSenioridade'])
                    ->setNivelHierarquia($_POST['nivelHierarquia']);
        CandidatoDTO::salvar($candidato);
        header("Location: /");
    }
}