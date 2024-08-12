<?php

/**
 * @noinspection PhpUnused
 */

class AutenticacaoController
{
    public function __construct()
    {
    }

    public function index()
    {
        Session::renegaSessao([TipoUsuarioEnum::EMPRESA, TipoUsuarioEnum::CANDIDATO]);

        $tab = $_GET['tab'] ?? '';

        $usuarioLembrado = $_COOKIE[TipoUsuarioEnum::EMPRESA->session_key()] ?? '';
        $candidatoLembrado = $_COOKIE[TipoUsuarioEnum::CANDIDATO->session_key()] ?? '';

        View::renderizar('autenticacao/login', compact('usuarioLembrado', 'candidatoLembrado', 'tab'), 'login');
    }

    public function logout()
    {
        Session::destruir();
        header('Location: /autenticacao');
    }

}