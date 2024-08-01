<?php

class PropostaController
{
    public function cadastrar()
    {
        UsuarioController::exigeSessao();

        View::renderizar('proposta/formulario');
    }

    public function salvar()
    {
        UsuarioController::exigeSessao();

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
        CandidatoController::exigeSessao();

        $vagaId = $_POST['vaga'];
        $vaga = VagaDTO::recuperar($vagaId);

        $propostaStatus = PropostaStatusEnum::from($_POST['aceite']);
        $proposta = PropostaDTO::recuperar($vaga->getId(), $_SESSION['candidato']->getId());
        $proposta->setAceite($propostaStatus->value);

        PropostaDTO::salvar($proposta);

        $candidatoVagaStatus = $propostaStatus === PropostaStatusEnum::Aceita ? CandidatoVagaStatusEnum::Contratado : CandidatoVagaStatusEnum::RecusouProposta;
        $candidatoVaga = CandidatoVagaDTO::recuperar($_SESSION['candidato']->getId(), $vaga->getId());
        $candidatoVaga->setStatus($candidatoVagaStatus->value);

        CandidatoVagaDTO::salvar($candidatoVaga);

        header("Location:/candidato/listar");
    }

    public function exibir()
    {
        CandidatoController::exigeSessao();
        $vagaId = $_GET['vagaId'];

        $candidato = $_SESSION['candidato']->getId();

        $proposta = PropostaDTO::recuperar($vagaId, $candidato);

        View::renderizar('/proposta/detalhes', compact('vagaId', 'candidato', 'proposta'), 'sistema-candidato');
    }

}
