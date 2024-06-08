<?php

class ErrorController
{

    public function index()
    {
        View::renderizar('error/index', [], 'login', !AutenticacaoController::estaLogado());
    }
}