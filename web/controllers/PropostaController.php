<?php

/**
 * @noinspection PhpUnused
 */

class PropostaController
{
    public function cadastrar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        View::renderizar('proposta/formulario');
    }

    public function salvar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $vagaId = $_POST['vaga'];
        $vaga = VagaDTO::recuperar($vagaId);

        $candidatoId = $_POST['candidato'];
        $candidato = CandidatoDTO::recuperar($candidatoId);

        $proposta = new Proposta($vaga, $candidato, $_POST['salario'], $_POST['regime_contratacao'], $_POST['regime_trabalho'], $_POST['nivel_hierarquico'], $_POST['nivel_senioridade'], $_POST['cargo'], $_POST['endereco'], $_POST['expediente'], $_POST['data_inicio'], PropostaStatusEnum::Aguardando->value);

        PropostaDTO::salvar($proposta);

        header("Location:/vaga/");
    }

    public function responder()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);

        $vagaId = $_POST['vaga'];
        $vaga = VagaDTO::recuperar($vagaId);

        $propostaStatus = PropostaStatusEnum::from($_POST['aceite']);
        $proposta = PropostaDTO::recuperar($vaga->getId(), Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId());
        $proposta->setAceite($propostaStatus->value);

        PropostaDTO::salvar($proposta);

        $candidatoVagaStatus = $propostaStatus === PropostaStatusEnum::Aceita ? CandidatoVagaStatusEnum::Contratado : CandidatoVagaStatusEnum::RecusouProposta;
        $candidatoVaga = CandidatoVagaDTO::recuperar(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId(), $vaga->getId());
        $candidatoVaga->setStatus($candidatoVagaStatus->value);

        CandidatoVagaDTO::salvar($candidatoVaga);

        if ($propostaStatus === PropostaStatusEnum::Aceita) {
            header('Location:/candidato/depoimento?empresa=' . $candidatoVaga->getVaga()->getEmpresa()->getId());
        } else {
            header("Location:/candidato/listar");
        }
    }

    public function exibir()
    {
        Session::exigeSessao([TipoUsuarioEnum::CANDIDATO]);
        $vagaId = $_GET['vagaId'];

        $candidato = Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->getId();

        $proposta = PropostaDTO::recuperar($vagaId, $candidato);

        View::renderizar('/proposta/detalhes', compact('vagaId', 'candidato', 'proposta'), 'sistema-candidato');
    }

}
