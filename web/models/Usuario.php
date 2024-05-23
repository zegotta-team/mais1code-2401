<?php

class Usuario {

    private $id;
    private Empresa $empresa;
    private $cpf;
    private $nome;
    private $email;
    private $senha;

    /**
     * @param Empresa $empresa
     * @param $cpf
     * @param $nome
     * @param $email
     * @param $senha
     */
    public function __construct(Empresa $empresa, $cpf, $nome, $email, $senha)
    {
        $this->empresa = $empresa;
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
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

    public function getEmpresa(): Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(Empresa $empresa): Usuario
    {
        $this->empresa = $empresa;
        return $this;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

}