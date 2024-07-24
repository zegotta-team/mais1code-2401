<?php

class AutenticacaoController
{
    public function __construct()
    {
    }

    public function index()
    {
        UsuarioController::renegaSessao();
        CandidatoController::renegaSessao();

        $tab = $_GET['tab'] ?? '';

        $usuarioLembrado = $_COOKIE['usuario'] ?? '';
        $candidatoLembrado = $_COOKIE['candidato'] ?? '';

        View::renderizar('autenticacao/login', compact('usuarioLembrado', 'candidatoLembrado', 'tab'), 'login');
    }

}