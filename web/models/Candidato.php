<?php

class Candidato
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $cpf;
    private $nascimento;
    private $endereco;
    private $disponibilidade;
    private $sexo;
    private $genero;
    private $status;
    private $regimeContratacao;
    private $regimeTrabalho;
    private $nivelSenioridade;
    private $nivelHierarquia;

    private $habilidades;
    private $beneficios;

    public function __construct($nome, $email, $senha, $cpf, $nascimento, $endereco, $disponibilidade, $sexo, $genero, $status, $regimeContratacao, $regimeTrabalho, $nivelSenioridade, $nivelHierarquia, $habilidades, $beneficios)
    {
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setCpf($cpf);
        $this->setNascimento($nascimento);
        $this->setEndereco($endereco);
        $this->setDisponibilidade($disponibilidade);
        $this->setSexo($sexo);
        $this->setGenero($genero);
        $this->setStatus($status);
        $this->setRegimeContratacao($regimeContratacao);
        $this->setRegimeTrabalho($regimeTrabalho);
        $this->setNivelSenioridade($nivelSenioridade);
        $this->setNivelHierarquia($nivelHierarquia);
        $this->setHabilidades($habilidades);
        $this->setBeneficios($beneficios);
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

    public function getRegimeContratacao()
    {
        return $this->regimeContratacao;
    }

    public function setRegimeContratacao($regimeContratacao)
    {
        $this->regimeContratacao = $regimeContratacao;
        return $this;
    }

    public function getRegimeTrabalho()
    {
        return $this->regimeTrabalho;
    }

    public function setRegimeTrabalho($regimeTrabalho)
    {
        $this->regimeTrabalho = $regimeTrabalho;
        return $this;
    }

    public function getNivelSenioridade()
    {
        return $this->nivelSenioridade;
    }

    public function setNivelSenioridade($nivelSenioridade)
    {
        $this->nivelSenioridade = $nivelSenioridade;
        return $this;
    }

    public function getNivelHierarquia()
    {
        return $this->nivelHierarquia;
    }

    public function setNivelHierarquia($nivelHierarquia)
    {
        $this->nivelHierarquia = $nivelHierarquia;
        return $this;
    }

    public function getBeneficios() 
    {
        return $this->beneficios;
    }

    public function setBeneficios($beneficios) 
    {
        $this->beneficios = $beneficios;
        return $this;
    }

    public function temHabilidadeId($id)
    {
        foreach ($this->habilidades as $habilidade) {
            if ($id === $habilidade->getId()) {
                return true;
            }
        }

        return false;
    }

    public function temBeneficioId($id) 
    {
        foreach ($this->beneficios as $beneficio) {
            if ($id === $beneficio->getId()) {
                return true;
            }
        }

        return false;
    }
}