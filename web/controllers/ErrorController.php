<?php

class ErrorController
{

    public function index()
    {
        View::renderizar('error/index', [], 'sistema', !AutenticacaoController::estaLogado());
    }
}