<?php

class View
{

    public static function renderizar($arquivo, $dados = [], $layout = 'sistema',  $ignorarLayout = false)
    {
        extract($dados);

        if (!$ignorarLayout) {
            require_once "layouts/$layout/cabecalho.phtml";
        }

        require_once "views/$arquivo.phtml";

        if (!$ignorarLayout) {
            require_once "layouts/$layout/rodape.phtml";
        }
    }
}