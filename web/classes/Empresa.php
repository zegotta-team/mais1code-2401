<?php

class Empresa
{
    private $id;
    private $nome;
    private $cnpj;
    private $usuario;
    private $email;
    private $senha;
    private $descricao;
    private $logo;
    private $endereco;

    public function __construct($nome, $cnpj, $usuario, $email, $senha, $descricao, $logo, $endereco)
    {
        $this->setNome($nome);
        $this->setCNPJ($cnpj);
        $this->setUsuario($usuario);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setDescricao($descricao);
        $this->setLogo($logo);
        $this->setEndereco($endereco);
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

    public function setUsuario($Usuario)
    {
        $this->usuario = $Usuario;
        return $this;
    }

    public function getUsuario()
    {
        return $this->usuario;
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

    public function setSenha($Senha)
    {
        $this->senha = $Senha;
        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
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

    public function setEndereco($Endereco)
    {
        $this->endereco = $Endereco;
        return $this;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }
}
