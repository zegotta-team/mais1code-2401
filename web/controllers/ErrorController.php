<?php

/**
 * @noinspection PhpUnused
 */

class ErrorController
{
    public function index()
    {

        $layout = 'sistema-externo';
        if (Session::estaLogado([TipoUsuarioEnum::CANDIDATO])) {
            $layout = 'sistema-candidato';
        } elseif (Session::estaLogado([TipoUsuarioEnum::EMPRESA])) {
            $layout = 'sistema-usuario';
        }

        View::renderizar('error/index', [], $layout);
    }
}