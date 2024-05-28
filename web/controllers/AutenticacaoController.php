<?php

class AutenticacaoController
{
    public function __construct()
    {
    }

    public function index()
    {
        AutenticacaoController::renegaSessao();

        View::renderizar('autenticacao/login', [], true);
    }

    public function processaLogin()
    {


        session_start();

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $usuario = UsuarioDTO::autenticar($email, $senha);

        if (!empty($usuario)) {
            header('Location: /vaga/listar');
            $_SESSION['usuarioId'] = $usuario->getId();
            $_SESSION['empresaId'] = $usuario->getEmpresa()->getId();
            $_SESSION['error'] = null;
        } else {
            header('Location: /autenticacao');
            $_SESSION['usuarioId'] = null;
            $_SESSION['empresaId'] = null;
            $_SESSION['error'] = 'Falha ao autenticar';
        }
    }

    public function processaLogout()
    {
        header('Location: /autenticacao');
        session_start();
        session_destroy();

    }

    public static function exigeSessao()
    {
        session_start();
        if (empty($_SESSION['empresaId']) || empty($_SESSION['usuarioId'])) {
            header("Location: /autenticacao/processaLogout");
            die();
        }

    }

    public static function renegaSessao()
    {

        session_start();
        if (!empty($_SESSION['empresaId']) && !empty($_SESSION['usuarioId'])) {
            header("Location: /vaga/listar");
        }
    }

    public static function estaLogado()
    {
        session_start();
        return !empty($_SESSION['empresaId']) && !empty($_SESSION['usuarioId']);
    }

}