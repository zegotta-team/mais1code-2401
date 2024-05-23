<?php

class View
{

    public static function renderizar($arquivo, $dados = [], $ignorarLayout = false)
    {
        extract($dados);

        if (!$ignorarLayout) {
            require_once 'views/sistema/cabecalho.phtml';
        }

        require_once "views/$arquivo.phtml";

        if (!$ignorarLayout) {
            require_once "views/sistema/rodape.phtml";
        }
    }
}