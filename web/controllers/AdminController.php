<?php

/**
 * @noinspection PhpUnused
 */

class AdminController
{
    public function login()
    {
        Session::iniciaSessao();

        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $administrador = AdministradorDTO::autenticar($login, $senha);

        if (isset($administrador)) {
            header("Location: " . TipoUsuarioEnum::ADMINISTRADOR->home());
            Session::set(TipoUsuarioEnum::ADMINISTRADOR->session_key(), $administrador);
        } else {
            header("Location: /autenticacao/?tab=" . TipoUsuarioEnum::ADMINISTRADOR->login_tab());
            Session::clear(TipoUsuarioEnum::ADMINISTRADOR->session_key());
            FlashMessage::addMessage("Não foi possível efetuar sua autenticação.<br>Verifique seus dados e tente novamente.", FlashMessageType::ERROR);
        }
    }

    public function index()
    {
        Session::exigeSessao([TipoUsuarioEnum::ADMINISTRADOR]);

        View::renderizar('admin/index', [], 'sistema-admin');
    }

}