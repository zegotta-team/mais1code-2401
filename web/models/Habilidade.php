<?php

class Habilidade
{
    private $id;
    private $habilidade;
    private CategoriaHabilidade $categoria;

    public function __construct($habilidade, $categoria)
    {
        $this->setHabilidade($habilidade);
        $this->setCategoria($categoria);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getHabilidade()
    {
        return $this->habilidade;
    }

    public function setHabilidade($habilidade)
    {
        $this->habilidade = $habilidade;
        return $this;
    }

    public function getCategoria() 
    {
        return $this->categoria;
    }

    public function setCategoria($categoria) 
    {
        $this->categoria = $categoria;
        return $this;
    }
}