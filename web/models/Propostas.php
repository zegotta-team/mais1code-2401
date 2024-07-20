<?php

class Propostas
{
    private Vaga $vaga;
    private Candidato $candidato;
    private $salario;
    private $regime_contratacao;
    private $regime_trabalho;
    private $nivel_hierarquico;
    private $nivel_senioridade;
    private $cargo;
    private $endereco;
    private $expediente;
    private $data_inicio;
    private $aceite;

    public function __construct($vaga, $candidato, $salario, $regime_contratacao, $regime_trabalho, $nivel_hierarquico, $nivel_senioridade, $cargo, $endereco, $expediente, $data_inicio, $aceite)
    {
        $this->setVaga($vaga);
        $this->setCandidato($candidato);
        $this->setSalario($salario);
        $this->setRegimeContratacao($regime_contratacao);
        $this->setRegimeTrabalho($regime_trabalho);
        $this->setNivelHierarquico($nivel_hierarquico);
        $this->setNivelSenioridade($nivel_senioridade);
        $this->setCargo($cargo);
        $this->setEndereco($endereco);
        $this->setExpediente($expediente);
        $this->setDataInicio($data_inicio);
        $this->setAceite($aceite);
    }

    public function getVaga()
    {
        return $this->vaga;
    }

    public function setVaga($vaga)
    {
        $this->vaga = $vaga;
        return $this;
    }

    public function getCandidato()
    {
        return $this->candidato;
    }

    public function setCandidato($candidato)
    {
        $this->candidato = $candidato;
        return $this;
    }

    public function getSalario()
    {
        return $this->salario;
    }

    public function setSalario($salario)
    {
        $this->salario = $salario;
        return $this;
    }

    public function getRegimeContratacao()
    {
        return $this->regime_contratacao;
    }

    public function setRegimeContratacao($regime_contratacao)
    {
        $this->regime_contratacao = $regime_contratacao;
        return $this;
    }

    public function getRegimeTrabalho()
    {
        return $this->regime_trabalho;
    }

    public function setRegimeTrabalho($regime_trabalho)
    {
        $this->regime_trabalho = $regime_trabalho;
        return $this;
    }

    public function getNivelHierarquico()
    {
        return $this->nivel_hierarquico;
    }

    public function setNivelHierarquico($nivel_hierarquico)
    {
        $this->nivel_hierarquico = $nivel_hierarquico;
        return $this;
    }

    public function getNivelSenioridade()
    {
        return $this->nivel_senioridade;
    }

    public function setNivelSenioridade($nivel_senioridade)
    {
        $this->nivel_senioridade = $nivel_senioridade;
        return $this;
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function getExpediente()
    {
        return $this;
    }

    public function setExpediente($expediente)
    {
        $this->expediente = $expediente;
        return $this;
    }

    public function getDataInicio()
    {
        return $this->data_inicio;
    }

    public function setDataInicio($data_inicio)
    {
        $this->data_inicio = $data_inicio;
        return $this;
    }

    public function getAceite()
    {
        return $this->aceite;
    }

    public function setAceite($aceite)
    {
        $this->aceite = $aceite;
        return $this;
    }

}