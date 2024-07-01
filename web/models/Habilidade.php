<?php

class Habilidade
{
    private $id;
    private $habilidade;
public function __construct($id, $habilidade){
    $this->setId($id);
    $this->setHabilidade($habilidade);
}
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
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