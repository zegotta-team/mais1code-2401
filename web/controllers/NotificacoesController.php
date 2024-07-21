<?php

class NotificacoesController
{
    public function __construct()
    { 
    }

    public static function criar($candidatura, $antigoStatus) 
    {
        if (!empty($candidatura) && !empty($antigoStatus)) {
            $mensagem = "Alterado o status de $antigoStatus para " . $candidatura->getStatus(true) . " na vaga de " . $candidatura->getVaga()->getTitulo();

            $data_hora = date("Y-m-d H:i:s");

            $notificacao = new Notificacoes($candidatura->getCandidato(), $candidatura->getVaga()->getEmpresa(), $mensagem, '', NotificacoesStatusEnum::NaoLida->value, $data_hora);
            NotificacoesDTO::salvar($notificacao);
        }
    }

    public function listar() 
    {
        CandidatoController::exigeSessao();

        $notificacoes = NotificacoesDTO::listar($_SESSION['candidato']->getId());

        View::renderizar('/candidato/painel', compact('notificacoes'), 'sistema-candidato');
    }
}