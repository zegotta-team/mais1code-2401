<?php

class Candidato_Vaga
{
    private $candidato_id;
    private $vaga_id;
    private $ultima_desistencia;
    private $status;

    public function __construct($candidato_id, $vaga_id, $ultima_desistencia, $status) 
    {
        $this->setCandidatoId($candidato_id);
        $this->setVagaId($vaga_id);
        $this->setUltimaDesistencia($ultima_desistencia);
        $this->setStatus($status);
    }

    public function setCandidatoId($candidato_id) 
    {
        $this->candidato_id = $candidato_id;
        return $this;
    }

    public function getCandidatoId() 
    {
        return $this->candidato_id;
    }

    public function setVagaId($vaga_id) 
    {
        $this->vaga_id = $vaga_id;
        return $this;
    }

    public function getVagaId() 
    {
        return $this->vaga_id;
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