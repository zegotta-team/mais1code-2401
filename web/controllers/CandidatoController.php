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
            $_SESSION['error'] = null;
        } else {
            header('Location: /candidato/login');
            $_SESSION['candidato'] = null;
            $_SESSION['error'] = "Falha ao autenticar candidato! Email ou senha incorretos.";
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
        $_SESSION['CadastroRealizado'] = 'Usuário/candidato cadastrado com sucesso';
        header('Location: /candidato/login');
    }

    public static function estaLogado()
    {

        return !isset($_SESSION['candidato']);
    }

    public function processaLogout()
    {
        header('Location: /');
        session_start();
        session_destroy();

    }

    public static function renegaSessao()
    {
        session_start();
        if (!empty($_SESSION['candidato'])) {
            header("Location: /");
        }
    }

}