<?php

class Notificacoes
{
    private $id;
    private Candidato $candidato;
    private Empresa $empresa;
    private $titulo;
    private $descricao;
    private $status;
    private $data_hora;

    public function __construct($candidato, $empresa, $titulo, $descricao, $status, $data_hora) 
    {
        $this->setCandidato($candidato);
        $this->setEmpresa($empresa);
        $this->setTitulo($titulo);
        $this->setDescricao($descricao);
        $this->setStatus($status);
        $this->setDataHora($data_hora);
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

    public function setCandidato($candidato) 
    {
        $this->candidato = $candidato;
        return $this;
    }

    public function getCandidato() 
    {
        return $this->candidato;   
    }

    public function setEmpresa($empresa) 
    {
        $this->empresa = $empresa;
        return $this;
    }

    public function getEmpresa() 
    {
        return $this->empresa;
    }

    public function setTitulo($titulo) 
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function getTitulo() 
    {
        return $this->titulo;
    }

    public function setDescricao($descricao) 
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getDescricao() 
    {
        return $this->descricao;
    }

    public function setStatus($status) 
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus($formatado = false) 
    {
        if ($formatado) {
            return NotificacoesStatusEnum::from($this->status)->label();
        } else{
            return $this->status;
        }
    }

    public function setDataHora($data_hora) 
    {
        $this->data_hora = $data_hora;
        return $this;
    }

    public function getDataHora() 
    {
        return $this->data_hora;
    }
}