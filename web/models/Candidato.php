<?php

class Candidato
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $habilidades;
    private $cpf;
    private $nascimento;
    private $endereco;
    private $disponibilidade;
    private $sexo;
    private $genero;
    private $status;

    public function __construct($nome, $email, $senha, $habilidades, $cpf, $nascimento, $endereco, $disponibilidade, $sexo, $genero, $status)
    {
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setHabilidades($habilidades);
        $this->setCpf($cpf);
        $this->setNascimento($nascimento);
        $this->setEndereco($endereco);
        $this->setDisponibilidade($disponibilidade);
        $this->setSexo($sexo);
        $this->setGenero($genero);
        $this->setStatus($status);
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

    public function getHabilidades()
    {
        return $this->habilidades;
    }

    public function setHabilidades($habilidades)
    {
        $this->habilidades = $habilidades;
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

    public function getNascimento()
    {
        return $this->nascimento;
    }

    public function setNascimento($nascimento)
    {
        $this->nascimento = $nascimento;
        return $this;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function getDisponibilidade()
    {
        return $this->disponibilidade;
    }

    public function setDisponibilidade($disponibilidade)
    {
        $this->disponibilidade = $disponibilidade;
        return $this;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
        return $this;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function setGenero($genero)
    {
        $this->genero = $genero;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function SetStatus($status)
    {
        $this->status = $status;
        return $this;
    }

}