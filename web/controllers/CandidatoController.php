<?php

class CandidatoController
{
    public function cadastrar()
    {
        AutenticacaoController::renegaSessao();

        View::renderizar('candidato/cadastrar', [], 'candidato');
    }

    public function processaCadastrar()
    {
        AutenticacaoController::renegaSessao();

        $candidato = new Candidato($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['habilidades'], $_POST['cpf'], $_POST['nascimento'], $_POST['endereco'], $_POST['disponibilidade'], $_POST['sexo'], $_POST['genero'], $_POST['status']);
        CandidatoDTO::salvar($candidato);

        header('Location: /');
    }
}