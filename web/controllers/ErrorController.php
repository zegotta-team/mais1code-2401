<?php

class ErrorController
{

    public function index()
    {
        if (AutenticacaoController::estaLogado()) {
            View::renderizar('error/index');
        } else {
            View::renderizar('autenticacao/login', [], 'login');
        }
    }
}