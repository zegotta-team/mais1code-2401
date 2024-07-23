<?php

class PropostasController
{
    public function cadastrar()
    {
        AutenticacaoController::estaLogado();


        View::renderizar('propostas/cadastrar');
    }

    public function salvar()
    {
      AutenticacaoController::estaLogado();
        $vagaId = $_POST['vaga'];
        $vaga = VagaDTO::recuperar($vagaId);

        $candidatoId = $_POST['candidato'];
        $candidato = CandidatoDTO::recuperar($candidatoId);

        $propostas = new Propostas($vaga, $candidato, $_POST['salario'], $_POST['regime_contratacao'], $_POST['regime_trabalho'],  $_POST['nivel_hierarquico'], $_POST['nivel_senioridade'], $_POST['cargo'], $_POST['endereco'], $_POST['expediente'], $_POST['data_inicio'], 0);
        PropostasDTO::salvar($propostas);

      header('Location:/vaga/listar');
    }

}
