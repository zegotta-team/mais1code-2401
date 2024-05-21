<?php

class AutenticacaoController
{
    public function __construct()
    {
    }

    public function login()
    {
        AutenticacaoController::renegaSessao();

        require_once 'view/login.html';
    }

    public function processaLogin()
    {


        session_start();

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $usuario = UsuarioDTO::autenticar($email, $senha);

        if (!empty($usuario)) {
            header('Location: index.php?controller=Vaga&action=listar');
            $_SESSION['usuarioId'] = $usuario->getId();
            $_SESSION['empresaId'] = $usuario->getEmpresa()->getId();
            $_SESSION['error'] = null;
        } else {
            header('Location: index.php?controller=Autenticacao&action=login');
            $_SESSION['usuarioId'] = null;
            $_SESSION['empresaId'] = null;
            $_SESSION['error'] = 'Falha ao autenticar';
        }
    }

    public function processaLogout()
    {
        header('Location: index.php?controller=Autenticacao&action=login');
        session_start();
        session_destroy();

    }

    public static function exigeSessao()
    {
        session_start();
        if (empty($_SESSION['empresaId']) || empty($_SESSION['usuarioId'])) {
            header("Location: ../index.php?controller=Autenticacao&action=processaLogout");
            die();
        }

    }

    public static function renegaSessao()
    {

        session_start();
        if (!empty($_SESSION['empresaId']) && !empty($_SESSION['usuarioId'])) {
            header("Location: index.php?controller=Vaga&action=listar");
            die();
        }
    }

}