<?php

class ErrorController
{

    public function index()
    {

        $ignorarLayout = !UsuarioController::estaLogado() && !CandidatoController::estaLogado();
        if (!$ignorarLayout) {
            $layout = UsuarioController::estaLogado() ? 'sistema-usuario' : 'sistema-candidato';
        } else {
            $layout = '';
        }

        View::renderizar('error/index', [], $layout, $ignorarLayout);
    }
}