<?php

/**
 * @noinspection PhpUnused
 */

class NotificacoesController
{
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
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);

        $notificacoes = NotificacoesDTO::listar(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId());

        View::renderizar('/candidato/notificacoes', compact('notificacoes'), 'sistema-candidato');
    }

    public function alterar() {
        $notificacao = NotificacoesDTO::recuperar($_GET['id']);
        $resultado = $_GET['indice'];

        if ($resultado == 2) {
            $notificacao->setStatus(NotificacoesStatusEnum::Inativa->value);
        } else{
            $notificacao->setStatus(NotificacoesStatusEnum::Lida->value);
        }

        NotificacoesDTO::salvar($notificacao);

        header('Location: /notificacoes/listar');
    }
}