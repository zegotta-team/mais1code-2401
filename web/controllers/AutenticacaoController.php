<?php

class AutenticacaoController
{
    public function __construct()
    {
    }

    public function index()
    {
        AutenticacaoController::renegaSessao();

        if (isset($_COOKIE['usuario'])) {
            $usuarioLembrado = $_COOKIE['usuario'];
        } else {
            $usuarioLembrado = '';
        }

        View::renderizar('autenticacao/login', compact('usuarioLembrado'), 'login');
    }

    public function processaLogin()
    {
        session_start();

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $remember = isset($_POST['remember_me']);

        if ($remember) {
            setcookie("usuario", $email, time() + 3600 * 24 * 30 * 12 * 100);
        } else {
            setcookie("usuario", "", time() - 3600);
        }

        $usuario = UsuarioDTO::autenticar($email, $senha);

        if (!empty($usuario)) {
            header('Location: /vaga/listar');
            $_SESSION['usuario'] = $usuario;
        } else {
            header('Location: /autenticacao');
            $_SESSION['usuario'] = null;
            FlashMessage::addMessage('Falha ao autenticar', FlashMessage::FLASH_ERROR);
        }
    }

    public function processaLogout()
    {
        session_start();
        session_destroy();
        header('Location: /');
    }

    public static function exigeSessao()
    {
        session_start();
        if (empty($_SESSION['usuario'])) {
            header("Location: /autenticacao/");
            die();
        }

    }

    public static function renegaSessao()
    {
        session_start();
        if (!empty($_SESSION['usuario'])) {
            header("Location: /vaga/listar");
        }
    }

    public static function estaLogado()
    {
        session_start();
        return !empty($_SESSION['usuario']);
    }

}