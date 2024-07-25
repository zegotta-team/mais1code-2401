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

    public function getStatus($formatado = false)
    {
        if ($formatado) {
            return CandidatoVagaStatusEnum::from($this->status)->label();
        } else {
            return $this->status;
        }
    }

    public function desistenciaLiberada()
    {
        $tempo = strtotime($this->ultima_desistencia);
        $agora = time();
        $diferenca = ($agora - $tempo) / 3600;
        return $diferenca >= 24;
    }

    public function temProposta()
    {
        return !is_null(PropostaDTO::recuperar($this->vaga->getId(), $this->candidato->getId()));
    }
}