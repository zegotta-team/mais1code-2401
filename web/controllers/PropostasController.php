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

        if(isset($_POST['aceite'])){
            $propostas = PropostasDTO::recuperar($vagaId, $candidatoId);
            $propostas->setAceite($_POST['aceite']);
        }else{
            $propostas = new Propostas($vaga, $candidato, $_POST['salario'], $_POST['regime_contratacao'], $_POST['regime_trabalho'],  $_POST['nivel_hierarquico'], $_POST['nivel_senioridade'], $_POST['cargo'], $_POST['endereco'], $_POST['expediente'], $_POST['data_inicio'], PropostaStatusEnum::Aguardando->value);
        }

        PropostasDTO::salvar($propostas);

      header('Location:/vaga/index');
    }

    public function exibir()
    {
        AutenticacaoController::estaLogado();
        $vagaId = $_GET['vagaId'];

        $candidato = $_SESSION['candidato']->getId();

        $propostas = PropostasDTO::recuperar($vagaId, $candidato);

        View::renderizar('/propostas/aceite', compact('vagaId', 'candidato', 'propostas'), 'sistema-candidato');
    }

}
