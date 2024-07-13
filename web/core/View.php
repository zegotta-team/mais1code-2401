<?php

class View
{

    public static function renderizar($arquivo, $dados = [], $layout = 'sistema',  $ignorarLayout = false)
    {
        extract($dados);

        if (!$ignorarLayout) {
            $cabecalho = "layouts/$layout/cabecalho.phtml";
            if (NOVO_LAYOUT && file_exists("layouts/$layout/cabecalho_n.phtml")) {
                $cabecalho = "layouts/$layout/cabecalho_n.phtml";
            }
            require_once $cabecalho;
        }

        $content = "views/$arquivo.phtml";
        if (NOVO_LAYOUT && file_exists("views/$arquivo" . "_n.phtml")) {
            $content = "views/$arquivo" . "_n.phtml";
        }

        require_once $content;

        if (!$ignorarLayout) {
            $rodape = "layouts/$layout/rodape.phtml";
            if (NOVO_LAYOUT && file_exists("layouts/$layout/rodape_n.phtml")) {
                $rodape = "layouts/$layout/rodape_n.phtml";
            }
            require_once $rodape;
        }
    }
}
