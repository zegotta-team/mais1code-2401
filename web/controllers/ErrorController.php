<?php

class ErrorController
{

    public function index()
    {

        $ignorarLayout = !AutenticacaoController::estaLogado() && !CandidatoController::estaLogado();
        if (!$ignorarLayout) {
            $layout = AutenticacaoController::estaLogado() ? 'sistema' : 'sistema-candidato';
        } else {
            $layout = '';
        }

        View::renderizar('error/index', [], $layout, $ignorarLayout);
    }
}