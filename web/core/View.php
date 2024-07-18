<?php

class View
{

    public static function renderizar($arquivo, $dados = [], $layout = 'sistema',  $ignorarLayout = false)
    {
        extract($dados);

        if (!$ignorarLayout) {
            $cabecalho = "layouts/$layout/cabecalho.phtml";
            require_once $cabecalho;
        }

        $content = "views/$arquivo.phtml";

        require_once $content;

        if (!$ignorarLayout) {
            $rodape = "layouts/$layout/rodape.phtml";
            require_once $rodape;
        }
    }
}
