<?php

class CandidatoController
{
    public function login()
    {
        self::renegaSessao();

        View::renderizar('candidato/login', [], 'login');
    }

    public function processaLogin()
    {
        session_start();

        $email = $_POST['email'];
        $senha = $_POST['senha'];

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

        $candidato = new Candidato($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['habilidades'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['disponibilidade'], $_POST['sexo'], $_POST['genero'], $_POST['status']);

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

}