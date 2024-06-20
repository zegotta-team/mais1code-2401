<?php

class CandidatoVaga
{
    private Candidato $candidato;
    private Vaga $vaga;
    private $ultima_desistencia;
    private $status;

    public function __construct($candidato, $vaga, $ultima_desistencia, $status) 
    {
        $this->setCandidato($candidato);
        $this->setVaga($vaga);
        $this->setUltimaDesistencia($ultima_desistencia);
        $this->setStatus($status);
    }

    public function setCandidato($candidato) 
    {
        $this->candidato = $candidato;
        return $this;
    }

    public function getCandidato() 
    {
        return $this->candidato;
    }

    public function setVaga($vaga) 
    {
        $this->vaga = $vaga;
        return $this;
    }

    public function getVaga() 
    {
        return $this->vaga;
    }

    public function setUltimaDesistencia($ultima_desistencia) 
    {
        $this->ultima_desistencia = $ultima_desistencia;
        return $this;
    }

    public function getUltimaDesistencia() 
    {
        return $this->ultima_desistencia;
    }

    public function setStatus($status) 
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus() 
    {
        return $this->status;
    }
}