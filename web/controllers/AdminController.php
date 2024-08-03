<?php

class AdminController
{

    public function index() {
        AdminController::exigeSessao();

        View::renderizar('admin/index', [], 'sistema-admin');
    }

    public function login()
    {
        session_start();

        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $administrador = AdministradorDTO::autenticar($login, $senha);

        if (isset($administrador)) {
            header('Location: /admin');
            $_SESSION['administrador'] = $administrador;
        } else {
            header('Location: /autenticacao/?tab=3');
            $_SESSION['administrador'] = null;
            FlashMessage::addMessage("Falha ao autenticar adminstrador! Email ou senha incorretos.", FlashMessage::FLASH_ERROR);
        }
    }

    public static function estaLogado()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return !empty($_SESSION['administrador']);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /admin');
    }

    public static function renegaSessao()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['administrador'])) {
            header("Location: /");
        }
    }

    public static function exigeSessao()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['administrador'])) {
            header("Location: /autenticacao");
        }
    }

}