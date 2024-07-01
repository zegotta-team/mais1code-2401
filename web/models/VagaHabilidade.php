<?php

class VagaHabilidade
{
    private Vaga $vaga_id;
    private Habilidade $habilidade_id;
    public function __construct($vaga_id, $habilidade_id)
    {
        $this->setVagaId($vaga_id);
        $this->setHabilidadeId($habilidade_id);
    }
    public function getVagaId(){
        return $this->vaga_id;
    }
    public function setVagaId($vaga_id){
        $this->vaga_id = $vaga_id;
        return $this;
    }
    public function getHabilidadeId(){
        return $this->habilidade_id;
    }
    public function setHabilidadeId($habilidade_id){
        $this->habilidade_id = $habilidade_id;
        return $this;
    }
}