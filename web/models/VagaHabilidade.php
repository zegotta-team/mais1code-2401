<?php

class VagaHabilidade
{
    private Vaga $vaga;
    private Habilidade $habilidade;
    public function __construct($vaga, $habilidade)
    {
        $this->setVaga($vaga);
        $this->setHabilidade($habilidade);
    }
    public function getVaga(){
        return $this->vaga;
    }
    public function setVaga($vaga){
        $this->vaga = $vaga;
        return $this;
    }
    public function getHabilidade(){
        return $this->habilidade;
    }
    public function setHabilidade($habilidade){
        $this->habilidade = $habilidade;
        return $this;
    }
}