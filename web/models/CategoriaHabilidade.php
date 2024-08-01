<?php

class CategoriaHabilidade
{
    private $id;
    private $nome;

    public function __construct($nome)
    {
        $this->setNome($nome);
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome()
        ];
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}