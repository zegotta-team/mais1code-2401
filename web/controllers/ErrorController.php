<?php

class ErrorController
{

    public function index()
    {
        if (AutenticacaoController::estaLogado()) {
            $usuario = UsuarioDTO::recuperar($_SESSION['usuarioId']);
            View::renderizar('error/index', compact('usuario'));
        } else {
            View::renderizar('autenticacao/login', [], true);
        }
    }
}