<?php

class Empresa
{
    private $id;
    private $nome;
    private $cnpj;
    private $email;
    private $descricao;
    private $logo;

    public function __construct($nome, $cnpj, $email, $descricao, $logo)
    {
        $this->setNome($nome);
        $this->setCNPJ($cnpj);
        $this->setEmail($email);
        $this->setDescricao($descricao);
        $this->setLogo($logo);
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

    public function setNome($Nome)
    {
        $this->nome = $Nome;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setCNPJ($Cnpj)
    {
        $this->cnpj = $Cnpj;
        return $this;
    }

    public function getCNPJ()
    {
        return $this->cnpj;
    }

    public function setEmail($Email)
    {
        $this->email = $Email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setDescricao($Descricao)
    {
        $this->descricao = $Descricao;
        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setLogo($Logo)
    {
        $this->logo = $Logo;
        return $this;
    }

    public function getLogo()
    {
        return $this->logo;
    }

}